<?php
declare(strict_types=1);

/**
* Set/Change Quotas
*/
function process_quota_settings(PDO $pdo, string $mode, int $id, int $quota_type, int $quota_limit_id = 0): void
{
    if ($mode === 'user')
    {
        if ($quota_limit_id === 0)
        {
            $stmt = $pdo->prepare('DELETE FROM ' . QUOTA_TABLE . ' WHERE user_id = :id AND quota_type = :quota_type');
            $stmt->execute(['id' => $id, 'quota_type' => $quota_type]);
        }
        else
        {
            // Check if user already exists in quota table
            $stmt = $pdo->prepare('SELECT user_id FROM ' . QUOTA_TABLE . ' WHERE user_id = :id AND quota_type = :quota_type');
            $stmt->execute(['id' => $id, 'quota_type' => $quota_type]);
            
            if ($stmt->rowCount() === 0)
            {
                $sql_ary = [
                    'user_id'       => $id,
                    'group_id'      => 0,
                    'quota_type'    => $quota_type,
                    'quota_limit_id'=> $quota_limit_id,
                ];

                // Assuming attach_mod_sql_build_array returns string like "(col1, col2) VALUES (:val1, :val2)"
                $sql = 'INSERT INTO ' . QUOTA_TABLE . ' ' . attach_mod_sql_build_array('INSERT', $sql_ary);
                $stmt = $pdo->prepare($sql);
                $stmt->execute($sql_ary);
            }
            else
            {
                $stmt = $pdo->prepare('UPDATE ' . QUOTA_TABLE . ' SET quota_limit_id = :quota_limit_id WHERE user_id = :id AND quota_type = :quota_type');
                $stmt->execute(['quota_limit_id' => $quota_limit_id, 'id' => $id, 'quota_type' => $quota_type]);
            }
        }
    }
    elseif ($mode === 'group')
    {
        if ($quota_limit_id === 0)
        {
            $stmt = $pdo->prepare('DELETE FROM ' . QUOTA_TABLE . ' WHERE group_id = :id AND quota_type = :quota_type');
            $stmt->execute(['id' => $id, 'quota_type' => $quota_type]);
        }
        else
        {
            $stmt = $pdo->prepare('SELECT group_id FROM ' . QUOTA_TABLE . ' WHERE group_id = :id AND quota_type = :quota_type');
            $stmt->execute(['id' => $id, 'quota_type' => $quota_type]);

            if ($stmt->rowCount() === 0)
            {
                $stmt = $pdo->prepare('INSERT INTO ' . QUOTA_TABLE . ' (user_id, group_id, quota_type, quota_limit_id) VALUES (0, :id, :quota_type, :quota_limit_id)');
                $stmt->execute(['id' => $id, 'quota_type' => $quota_type, 'quota_limit_id' => $quota_limit_id]);
            }
            else
            {
                $stmt = $pdo->prepare('UPDATE ' . QUOTA_TABLE . ' SET quota_limit_id = :quota_limit_id WHERE group_id = :id AND quota_type = :quota_type');
                $stmt->execute(['quota_limit_id' => $quota_limit_id, 'id' => $id, 'quota_type' => $quota_type]);
            }
        }
    }
}

/**
* Sort multi-dimensional Array (unchanged)
*/
function sort_multi_array($sort_array, $key, $sort_order, $pre_string_sort = 0) 
{
    $last_element = count($sort_array) - 1;

    if (!$pre_string_sort)
    {
        $string_sort = (isset($sort_array[$last_element - 1][$key]) && !is_numeric($sort_array[$last_element - 1][$key]));
    }
    else
    {
        $string_sort = $pre_string_sort;
    }

    for ($i = 0; $i < $last_element; $i++) 
    {
        $num_iterations = $last_element - $i;

        for ($j = 0; $j < $num_iterations; $j++) 
        {
            $switch = false;

            $current = $sort_array[$j][$key] ?? null;
            $next = $sort_array[$j + 1][$key] ?? null;

            if ($string_sort)
            {
                if ($current === null || $next === null) {
                    continue; // can't compare, skip
                }

                if (($sort_order == 'DESC' && strcasecmp($current, $next) < 0) || 
                    ($sort_order == 'ASC' && strcasecmp($current, $next) > 0))
                {
                    $switch = true;
                }
            }
            else
            {
                // treat null as less than any number
                $current_val = is_numeric($current) ? intval($current) : PHP_INT_MIN;
                $next_val = is_numeric($next) ? intval($next) : PHP_INT_MIN;

                if (($sort_order == 'DESC' && $current_val < $next_val) || 
                    ($sort_order == 'ASC' && $current_val > $next_val))
                {
                    $switch = true;
                }
            }

            if ($switch)
            {
                $temp = $sort_array[$j];
                $sort_array[$j] = $sort_array[$j + 1];
                $sort_array[$j + 1] = $temp;
            }
        }
    }

    return $sort_array;
}

/**
* See if a post or pm really exists
*/
function entry_exists(PDO $pdo, int $attach_id): bool
{
    if ($attach_id <= 0)
    {
        return false;
    }

    $stmt = $pdo->prepare('SELECT post_id, privmsgs_id FROM ' . ATTACHMENTS_TABLE . ' WHERE attach_id = :attach_id');
    $stmt->execute(['attach_id' => $attach_id]);
    $ids = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($ids as $row)
    {
        if (!empty($row['post_id']))
        {
            $checkStmt = $pdo->prepare('SELECT post_id FROM ' . POSTS_TABLE . ' WHERE post_id = :post_id');
            $checkStmt->execute(['post_id' => (int)$row['post_id']]);
            if ($checkStmt->fetch())
            {
                return true;
            }
        }
        elseif (!empty($row['privmsgs_id']))
        {
            $checkStmt = $pdo->prepare('SELECT privmsgs_id FROM ' . PRIVMSGS_TABLE . ' WHERE privmsgs_id = :privmsgs_id');
            $checkStmt->execute(['privmsgs_id' => (int)$row['privmsgs_id']]);
            if ($checkStmt->fetch())
            {
                return true;
            }
        }
    }

    return false;
}

/**
* Collect all Attachments in Filesystem
* (No DB changes, just minor modernization)
*/
function collect_attachments(string $upload_dir, array $attach_config): array
{
    $file_attachments = [];

    if (empty($attach_config['allow_ftp_upload']))
    {
        if ($dir = @opendir($upload_dir))
        {
            while (($file = readdir($dir)) !== false)
            {
                if ($file !== 'index.php' && $file !== '.htaccess' && !is_dir($upload_dir . '/' . $file) && !is_link($upload_dir . '/' . $file))
                {
                    $file_attachments[] = trim($file);
                }
            }
            closedir($dir);
        }
        else
        {
            throw new RuntimeException("Unable to open upload directory: $upload_dir");
        }
    }
    else
    {
        $conn_id = attach_init_ftp();

        $file_listing = @ftp_rawlist($conn_id, '');

        if (!$file_listing)
        {
            throw new RuntimeException("Unable to get raw file listing from FTP.");
        }

        foreach ($file_listing as $line)
        {
            if (preg_match('/^([-d])[rwxst-]{9}.* ([0-9]+) ([a-zA-Z]+[0-9: ]*[0-9]) ([0-9]{2}:[0-9]{2}) (.+)$/', $line, $regs))
            {
                if ($regs[1] === 'd')
                {
                    continue; // skip directories
                }
                $filename = $regs[5];
                if ($filename !== 'index.php' && $filename !== '.htaccess')
                {
                    $file_attachments[] = trim($filename);
                }
            }
        }

        ftp_close($conn_id);
    }

    return $file_attachments;
}

/**
* Returns the filesize of the upload directory in human readable format
*/
function get_formatted_dirsize(string $upload_dir, array $attach_config, array $lang): string
{
    $upload_dir_size = 0;

    if (empty($attach_config['allow_ftp_upload']))
    {
        if ($dirname = @opendir($upload_dir))
        {
            while (($file = readdir($dirname)) !== false)
            {
                if ($file !== 'index.php' && $file !== '.htaccess' && !is_dir($upload_dir . '/' . $file) && !is_link($upload_dir . '/' . $file))
                {
                    $upload_dir_size += filesize($upload_dir . '/' . $file);
                }
            }
            closedir($dirname);
        }
        else
        {
            return $lang['Not_available'];
        }
    }
    else
    {
        $conn_id = attach_init_ftp();
        $file_listing = @ftp_rawlist($conn_id, '');

        if (!$file_listing)
        {
            ftp_close($conn_id);
            return $lang['Not_available'];
        }

        foreach ($file_listing as $line)
        {
            if (preg_match('/^([-d])[rwxst-]{9}.* ([0-9]+) ([a-zA-Z]+[0-9: ]*[0-9]) ([0-9]{2}:[0-9]{2}) (.+)$/', $line, $regs))
            {
                if ($regs[1] === 'd')
                {
                    continue;
                }
                $upload_dir_size += (int)$regs[2];
            }
        }
        ftp_close($conn_id);
    }

    if ($upload_dir_size >= 1048576)
    {
        return round($upload_dir_size / 1048576, 2) . ' ' . $lang['MB'];
    }
    elseif ($upload_dir_size >= 1024)
    {
        return round($upload_dir_size / 1024, 2) . ' ' . $lang['KB'];
    }
    else
    {
        return $upload_dir_size . ' ' . $lang['Bytes'];
    }
}

/**
* Build SQL-Statement for the search feature
*/
function search_attachments(PDO $pdo, string $order_by, int &$total_rows, array $search_vars): array
{
    $where_sql = [];

    // Extract search variables with defaults
    $search_keyword_fname = $search_vars['search_keyword_fname'] ?? '';
    $search_keyword_comment = $search_vars['search_keyword_comment'] ?? '';
    $search_author = $search_vars['search_author'] ?? '';
    $search_size_smaller = $search_vars['search_size_smaller'] ?? '';
    $search_size_greater = $search_vars['search_size_greater'] ?? '';
    $search_count_smaller = $search_vars['search_count_smaller'] ?? '';
    $search_count_greater = $search_vars['search_count_greater'] ?? '';
    $search_days_greater = $search_vars['search_days_greater'] ?? '';
    $search_forum = $search_vars['search_forum'] ?? null;

    $params = [];

    if ($search_author !== '')
    {
        // Assuming phpbb_clean_username and attach_mod_sql_escape exist and are safe
        $search_author_clean = attach_mod_sql_escape(phpbb_clean_username(html_entity_decode($search_author, ENT_QUOTES)));
        $search_author_clean = str_replace('*', '%', $search_author_clean);

        // Get matching user IDs
        $stmt = $pdo->prepare('SELECT user_id FROM ' . USERS_TABLE . ' WHERE username LIKE :username');
        $stmt->execute(['username' => $search_author_clean]);
        $user_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($user_ids))
        {
            throw new RuntimeException('No attachment search match');
        }

        $in  = implode(',', array_map('intval', $user_ids));
        $where_sql[] = "t.user_id_1 IN ($in)";
    }

    if ($search_keyword_fname !== '')
    {
        $match_word = str_replace('*', '%', attach_mod_sql_escape($search_keyword_fname));
        $where_sql[] = "a.real_filename LIKE :filename";
        $params['filename'] = $match_word;
    }

    if ($search_keyword_comment !== '')
    {
        $match_word = str_replace('*', '%', attach_mod_sql_escape($search_keyword_comment));
        $where_sql[] = "a.comment LIKE :comment";
        $params['comment'] = $match_word;
    }

    if ($search_count_smaller !== '')
    {
        $where_sql[] = 'a.download_count < :count_smaller';
        $params['count_smaller'] = (int)$search_count_smaller;
    }
    elseif ($search_count_greater !== '')
    {
        $where_sql[] = 'a.download_count > :count_greater';
        $params['count_greater'] = (int)$search_count_greater;
    }

    if ($search_size_smaller !== '')
    {
        $where_sql[] = 'a.filesize < :size_smaller';
        $params['size_smaller'] = (int)$search_size_smaller;
    }
    elseif ($search_size_greater !== '')
    {
        $where_sql[] = 'a.filesize > :size_greater';
        $params['size_greater'] = (int)$search_size_greater;
    }

    if ($search_days_greater !== '')
    {
        $where_sql[] = 'a.filetime < :time_limit';
        $params['time_limit'] = time() - ((int)$search_days_greater * 86400);
    }

    if ($search_forum)
    {
        $where_sql[] = 'p.forum_id = :forum_id';
        $params['forum_id'] = (int)$search_forum;
    }

    $sql = 'SELECT a.*, t.post_id, p.post_time, p.topic_id
            FROM ' . ATTACHMENTS_TABLE . ' t
            JOIN ' . ATTACHMENTS_DESC_TABLE . ' a ON a.attach_id = t.attach_id
            JOIN ' . POSTS_TABLE . ' p ON t.post_id = p.post_id';

    if (!empty($where_sql))
    {
        $sql .= ' WHERE ' . implode(' AND ', $where_sql);
    }

    $total_rows_sql = $sql; // for total rows count

    $sql .= ' ' . $order_by;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $attachments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($attachments) === 0)
    {
        throw new RuntimeException('No attachment search match');
    }

    // Get total rows count
    $stmt = $pdo->prepare($total_rows_sql);
    $stmt->execute($params);
    $total_rows = $stmt->rowCount();

    return $attachments;
}

/**
* perform LIMIT statement on arrays
*/
function limit_array(array $array, int $start, int $pagelimit): array
{
    return array_slice($array, $start, $pagelimit);
}
