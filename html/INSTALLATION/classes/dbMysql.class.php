<?php

declare(strict_types=1);

class dbMysql
{
    private string $dbhost = 'localhost';
    private string $dbname = '';
    private string $dbuser = '';
    private string $dbpass = '';
    private string $dbtype = 'MySQL';
    private ?mysqli $link = null;
    private string $prefix = 'nuke';
    private string $userPrefix = 'nuke';
    public bool $error = false;
    public string $table = '';

    public function __construct()
    {
        error_reporting(E_ALL);
        if (!defined('INCLUDE_PATH')) {
            define('INCLUDE_PATH', '../');
        }

        if (file_exists(INCLUDE_PATH . 'config.php')) {
            include_once INCLUDE_PATH . 'config.php';
            $this->dbhost = $dbhost ?? $this->dbhost;
            $this->dbname = $dbname ?? '';
            $this->dbuser = $dbuname ?? '';
            $this->dbpass = $dbpass ?? '';
            $this->dbtype = $dbtype ?? 'MySQL';
            $this->prefix = $prefix ?? 'nuke';
            $this->userPrefix = $user_prefix ?? 'nuke';
        } else {
            $this->xhtmlMsgWrapper('Unable to locate config.php', 'error');
            exit;
        }
    }

    public function __destruct()
    {
        $this->dbServerDisconnect();
    }

    public function dbServerConnect(): void
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->link = new mysqli($this->dbhost, $this->dbuser, $this->dbpass);
            $this->xhtmlMsgWrapper('MySQL Server Connected');
        } catch (mysqli_sql_exception $e) {
            $this->xhtmlMsgWrapper('MySQL Server Not Connected: ' . $e->getMessage(), 'error');
            $this->addDefaultXhtmlTemplate('foot');
            exit;
        }
    }

    public function dbServerDisconnect(): void
    {
        if ($this->link instanceof mysqli) {
            try {
                if (@$this->link->ping()) {
                    $this->link->close();
                    $this->xhtmlMsgWrapper('Server Disconnect');
                }
            } catch (Throwable $e) {
                $this->xhtmlMsgWrapper('Error during disconnect: ' . $e->getMessage(), 'error');
            } finally {
                $this->link = null;
            }
        }
    }

    public function dbSelectDb(string $db = ''): void
    {
        $db = $db ?: $this->dbname;
        $this->error = false;

        try {
            $this->link?->select_db($db);
            $this->xhtmlMsgWrapper("Database $db Selected");
        } catch (mysqli_sql_exception $e) {
            $this->error = true;
            $this->xhtmlMsgWrapper("Database $db Not Found: " . $e->getMessage(), 'error');
            $this->dbServerDisconnect();
            exit;
        }
    }

    public function dbQueryInsert(string $tbl = 'raventest'): void
    {
        $sql = "INSERT INTO `{$this->prefix}_{$tbl}` VALUES(NULL, 'testing')";
        $this->executeQuery($sql, "inserted record into", $tbl);
    }

    public function dbQueryDelete(string $tbl = 'raventest'): void
    {
        $sql = "DELETE FROM `{$this->prefix}_{$tbl}` WHERE field1='testing2'";
        $this->executeQuery($sql, "deleted record from", $tbl);
    }

    public function dbQuerySelect(string $tbl = 'raventest'): ?mysqli_result
    {
        $sql = "SELECT * FROM `{$this->prefix}_{$tbl}`";
        $this->error = false;

        try {
            $result = $this->link?->query($sql);
            $this->xhtmlMsgWrapper("Successfully selected records from table $tbl");
            return $result;
        } catch (mysqli_sql_exception $e) {
            $this->error = true;
            $this->xhtmlMsgWrapper("Unable to select record from table $tbl: " . $e->getMessage(), 'error');
            $this->dbTableDropSelective($tbl);
            $this->dbServerDisconnect();
            exit;
        }
    }

    public function dbQueryUpdate(string $tbl = 'raventest'): void
    {
        $sql = "UPDATE `{$this->prefix}_{$tbl}` SET field1='testing2'";
        $this->executeQuery($sql, "updated record in", $tbl);
    }

    public function dbTableCreate(string $tbl = 'raventest'): void
    {
        $dropSql = "DROP TABLE IF EXISTS `{$this->prefix}_{$tbl}`";
        $createSql = "CREATE TABLE `{$this->prefix}_{$tbl}` (
            id INT NOT NULL AUTO_INCREMENT,
            field1 VARCHAR(30) NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->link?->query($dropSql);
        $this->executeQuery($createSql, "created table", $tbl);
        $this->table = $tbl;
    }

    public function dbTableDropSelective(string $tbl = 'raventest'): void
    {
        $sql = "DROP TABLE IF EXISTS `{$this->prefix}_{$tbl}`";
        $this->executeQuery($sql, "dropped table", $tbl);
    }

    public function addDefaultXhtmlTemplate(string $hf): void
    {
        if ($hf === 'head') {
            echo <<<HTML
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="css/ravenstaller.css" type="text/css" />
<link rel="stylesheet" href="windowfiles/dhtmlwindow.css" type="text/css" />
<link rel="stylesheet" href="modalfiles/modal.css" type="text/css" />
<script src="js/ravenstaller.js" type="text/javascript"></script>
<title>RavenNuke Installer</title>
</head>
<body>
HTML;
        } elseif ($hf === 'foot') {
            echo <<<HTML
</body>
</html>
HTML;
        }
    }

    public function xhtmlMsgWrapper(string $msg = 'No Message Defined', string $type = ''): void
    {
        $class = $type === 'error' ? 'mysql-error' : 'mysql';
        echo "<br /><center><div class=\"{$class}\">\n" . htmlspecialchars($msg) . "\n</div></center>\n";
    }

    private function executeQuery(string $sql, string $action, string $tbl): void
    {
        $this->error = false;

        try {
            $this->link?->query($sql);
            $this->xhtmlMsgWrapper("Successfully $action table $tbl");
        } catch (mysqli_sql_exception $e) {
            $this->error = true;
            $this->xhtmlMsgWrapper("Unable to $action table $tbl: " . $e->getMessage(), 'error');
            $this->dbTableDropSelective($tbl);
            $this->dbServerDisconnect();
            exit;
        }
    }
}