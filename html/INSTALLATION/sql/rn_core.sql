DROP TABLE IF EXISTS $prefix.`_authors`;
CREATE TABLE IF NOT EXISTS $prefix.`_authors` ( `aid` varchar(25) NOT NULL default '', `name` varchar(50) default NULL, `url` varchar(255) NOT NULL default '', `email` varchar(255) NOT NULL default '', `pwd` varchar(40) default NULL, `counter` int(11) NOT NULL default '0', `radminsuper` tinyint(1) NOT NULL default '1', `admlanguage` varchar(30) NOT NULL default '', PRIMARY KEY  (`aid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_autonews`;
CREATE TABLE IF NOT EXISTS $prefix.`_autonews` ( `anid` int(11) NOT NULL auto_increment, `catid` int(11) NOT NULL default '0', `aid` varchar(25) NOT NULL default '', `title` varchar(80) NOT NULL default '', `time` varchar(19) NOT NULL default '', `hometext` text NOT NULL, `bodytext` text NOT NULL, `topic` int(3) NOT NULL default '1', `informant` varchar(25) NOT NULL default '', `notes` text NOT NULL, `ihome` int(1) NOT NULL default '0', `alanguage` varchar(30) NOT NULL default '', `acomm` int(1) NOT NULL default '0', `associated` text NOT NULL, PRIMARY KEY  (`anid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_banned_ip`;
CREATE TABLE IF NOT EXISTS $prefix.`_banned_ip` ( `id` int(11) NOT NULL auto_increment, `ip_address` varchar(15) NOT NULL default '', `reason` varchar(255) NOT NULL default '', `date` date NOT NULL default '1000-01-01', PRIMARY KEY  (`id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_banner`;
CREATE TABLE IF NOT EXISTS $prefix.`_banner` ( `bid` int(11) NOT NULL auto_increment, `cid` int(11) NOT NULL default '0', `name` varchar(50) NOT NULL default '', `imptotal` int(11) NOT NULL default '0', `impmade` int(11) NOT NULL default '0', `clicks` int(11) NOT NULL default '0', `imageurl` varchar(100) NOT NULL default '', `clickurl` varchar(200) NOT NULL default '', `alttext` varchar(255) NOT NULL default '', `date` datetime default NULL, `dateend` datetime default NULL, `position` int(10) NOT NULL default '0', `active` tinyint(1) NOT NULL default '1', `ad_class` varchar(5) NOT NULL default '', `ad_code` text NOT NULL, `ad_width` int(4) default NULL, `ad_height` int(4) default NULL, PRIMARY KEY  (`bid`), KEY `cid` (`cid`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_banner_clients`;
CREATE TABLE IF NOT EXISTS $prefix.`_banner_clients` ( `cid` int(11) NOT NULL auto_increment, `name` varchar(60) NOT NULL default '', `contact` varchar(60) NOT NULL default '',  `email` varchar(60) NOT NULL default '', `login` varchar(10) NOT NULL default '', `passwd` varchar(10) NOT NULL default '', `extrainfo` text NOT NULL, PRIMARY KEY  (`cid`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_banner_plans`;
CREATE TABLE $prefix.`_banner_plans` (`pid` int(10) NOT NULL auto_increment, `active` tinyint(1) NOT NULL default '0', `name` varchar(255) NOT NULL default '', `description` text NOT NULL, `delivery` varchar(10) NOT NULL default '', `delivery_type` varchar(25) NOT NULL default '', `price` varchar(25) NOT NULL default '0', `buy_links` text NOT NULL, PRIMARY KEY  (`pid`)) ENGINE=InnoDB AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS $prefix.`_banner_positions`;
CREATE TABLE $prefix.`_banner_positions` (`apid` int(10) NOT NULL auto_increment, `position_number` int(5) NOT NULL default '0', `position_name` varchar(255) NOT NULL default '', PRIMARY KEY  (`apid`), KEY `position_number` (`position_number`)) ENGINE=InnoDB AUTO_INCREMENT=3 ;
INSERT INTO $prefix.`_banner_positions` VALUES (1, 0, 'Page Top');
INSERT INTO $prefix.`_banner_positions` VALUES (2, 1, 'Page Header');

DROP TABLE IF EXISTS $prefix.`_banner_terms`;
CREATE TABLE $prefix.`_banner_terms` (`terms_body` text NOT NULL, `country` varchar(255) NOT NULL default '') ENGINE=InnoDB;
INSERT INTO $prefix.`_banner_terms` VALUES ('<div align="justify"><strong>Introduction:</strong> This Agreement between you and [sitename] consists of these Terms and Conditions. "You" or "Advertiser" means the entity identified in this enrollment form, and/or any agency acting on its behalf, which shall also be bound by the terms of this Agreement. Please read very carefully these Terms and Conditions.<br /><strong><br />Uses:</strong> You agree that your ads may be placed on (i) [sitename] web site and (ii) Any ads may be modified without your consent to comply with any policy of [sitename]. [sitename] reserves the right to, and in its sole discretion may, at any time review, reject, modify, or remove any ad. No liability of [sitename] and/or its owner(s) shall result from any such decision.<br /><br /></div><div align="justify"><strong>Parties'' Responsibilities:</strong> You are responsible of your own site and/or service advertised in [sitename] web site. You are solely responsible for the advertising image creation, advertising text and for the content of your ads, including URL links. [sitename] is not responsible for anything regarding your Web site(s) including, but not limited to, maintenance of your Web site(s), order entry, customer service, payment processing, shipping, cancellations or returns.<br /><br /></div><div align="justify"><strong>Impressions Count:</strong> Any hit to [sitename] web site is counted as an impression. Due to our advertising price we don''t discriminate from users or automated robots. Even if you access to [sitename] web site and see your own banner ad it will be counted as a valid impression. Only in the case of [sitename] web site administrator, the impressions will not be counted.<br /><br /></div><div align="justify"><strong>Termination, Cancellation:</strong> [sitename] may at any time, in its sole discretion, terminate the Campaign, terminate this Agreement, or cancel any ad(s) or your use of any Target. [sitename] will notify you via email of any such termination or cancellation, which shall be effective immediately. No refund will be made for any reason. Remaining impressions will be stored in a database and you''ll be able to request another campaign to complete your inventory. You may cancel any ad and/or terminate this Agreement with or without cause at any time. Termination of your account shall be effective when [sitename] receives your notice via email. No refund will be made for any reason. Remaining impressions will be stored in a database for future uses by you and/or your company.<br /><br /></div><div align="justify"><strong>Content:</strong> [sitename] web site doesn''t accepts advertising that contains: (i) pornography, (ii) explicit adult content, (iii) moral questionable content, (iv) illegal content of any kind, (v) illegal drugs promotion, (vi) racism, (vii) politics content, (viii) religious content, and/or (ix) fraudulent suspicious content. If your advertising and/or target web site has any of this content and you purchased an advertising package, you''ll not receive refund of any kind but your banners ads impressions will be stored for future use.<br /><br /></div><div align="justify"><strong>Confidentiality:</strong> Each party agrees not to disclose Confidential Information of the other party without prior written consent except as provided herein. "Confidential Information" includes (i) ads, prior to publication, (ii) submissions or modifications relating to any advertising campaign, (iii) clickthrough rates or other statistics (except in an aggregated form that includes no identifiable information about you), and (iv) any other information designated in writing as "Confidential." It does not include information that has become publicly known through no breach by a party, or has been (i) independently developed without access to the other party''s Confidential Information; (ii) rightfully received from a third party; or (iii) required to be disclosed by law or by a governmental authority.<br /><br /></div><div align="justify"><strong>No Guarantee:</strong> [sitename] makes no guarantee regarding the levels of clicks for any ad on its site. [sitename] may offer the same Target to more than one advertiser. You may not receive exclusivity unless special private contract between [sitename] and you.<br /><br /></div><div align="justify"><strong>No Warranty:</strong> [sitename] MAKES NO WARRANTY, EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION WITH RESPECT TO ADVERTISING AND OTHER SERVICES, AND EXPRESSLY DISCLAIMS THE WARRANTIES OR CONDITIONS OF NONINFRINGEMENT, MERCHANTABILITY AND FITNESS FOR ANY PARTICULAR PURPOSE.<br /><br /></div><div align="justify"><strong>Limitations of Liability:</strong> In no event shall [sitename] be liable for any act or omission, or any event directly or indirectly resulting from any act or omission of Advertiser, Partner, or any third parties (if any). EXCEPT FOR THE PARTIES'' INDEMNIFICATION AND CONFIDENTIALITY OBLIGATIONS HEREUNDER, (i) IN NO EVENT SHALL EITHER PARTY BE LIABLE UNDER THIS AGREEMENT FOR ANY CONSEQUENTIAL, SPECIAL, INDIRECT, EXEMPLARY, PUNITIVE, OR OTHER DAMAGES WHETHER IN CONTRACT, TORT OR ANY OTHER LEGAL THEORY, EVEN IF SUCH PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES AND NOTWITHSTANDING ANY FAILURE OF ESSENTIAL PURPOSE OF ANY LIMITED REMEDY AND (ii) [sitename] AGGREGATE LIABILITY TO ADVERTISER UNDER THIS AGREEMENT FOR ANY CLAIM IS LIMITED TO THE AMOUNT PAID TO [sitename] BY ADVERTISER FOR THE AD GIVING RISE TO THE CLAIM. Each party acknowledges that the other party has entered into this Agreement relying on the limitations of liability stated herein and that those limitations are an essential basis of the bargain between the parties. Without limiting the foregoing and except for payment obligations, neither party shall have any liability for any failure or delay resulting from any condition beyond the reasonable control of such party, including but not limited to governmental action or acts of terrorism, earthquake or other acts of God, labor conditions, and power failures.<br /><br /></div><div align="justify"><strong>Payment:</strong> You agree to pay in advance the cost of the advertising. [sitename] will not setup any banner ads campaign(s) unless the payment process is complete. [sitename] may change its pricing at any time without prior notice. If you have an advertising campaign running and/or impressions stored for future use for any mentioned cause and [sitename] changes its pricing, you''ll not need to pay any difference. Your purchased banners fee will remain the same. Charges shall be calculated solely based on records maintained by [sitename]. No other measurements or statistics of any kind shall be accepted by [sitename] or have any effect under this Agreement.<br /><br /></div><div align="justify"><strong>Representations and Warranties:</strong> You represent and warrant that (a) all of the information provided by you to [sitename] to enroll in the Advertising Campaign is correct and current; (b) you hold all rights to permit [sitename] and any Partner(s) to use, reproduce, display, transmit and distribute your ad(s); and (c) [sitename] and any Partner(s) Use, your Target(s), and any site(s) linked to, and products or services to which users are directed, will not, in any state or country where the ad is displayed (i) violate any criminal laws or third party rights giving rise to civil liability, including but not limited to trademark rights or rights relating to the performance of music; or (ii) encourage conduct that would violate any criminal or civil law. You further represent and warrant that any Web site linked to your ad(s) (i) complies with all laws and regulations in any state or country where the ad is displayed; (ii) does not breach and has not breached any duty toward or rights of any person or entity including, without limitation, rights of publicity or privacy, or rights or duties under consumer protection, product liability, tort, or contract theories; and (iii) is not false, misleading, defamatory, libelous, slanderous or threatening.<br /><br /></div><div align="justify"><strong>Your Obligation to Indemnify:</strong> You agree to indemnify, defend and hold [sitename], its agents, affiliates, subsidiaries, directors, officers, employees, and applicable third parties (e.g., all relevant Partner(s), licensors, licensees, consultants and contractors) ("Indemnified Person(s)") harmless from and against any and all third party claims, liability, loss, and expense (including damage awards, settlement amounts, and reasonable legal fees), brought against any Indemnified Person(s), arising out of, related to or which may arise from your use of the Advertising Program, your Web site, and/or your breach of any term of this Agreement. Customer understands and agrees that each Partner, as defined herein, has the right to assert and enforce its rights under this Section directly on its own behalf as a third party beneficiary.<br /><br /></div><div align="justify"><strong>Information Rights:</strong> [sitename] may retain and use for its own purposes all information you provide, including but not limited to Targets, URLs, the content of ads, and contact and billing information. [sitename] may share this information about you with business partners and/or sponsors. [sitename] will not sell your information. Your name, web site''s URL and related graphics shall be used by [sitename] in its own web site at any time as a sample to the public, even if your Advertising Campaign has been finished.<br /><br /></div><div align="justify"><strong>Miscellaneous:</strong> Any decision made by [sitename] under this Agreement shall be final. [sitename] shall have no liability for any such decision. You will be responsible for all reasonable expenses (including attorneys'' fees) incurred by [sitename] in collecting unpaid amounts under this Agreement. This Agreement shall be governed by the laws of [country]. Any dispute or claim arising out of or in connection with this Agreement shall be adjudicated in [country]. This constitutes the entire agreement between the parties with respect to the subject matter hereof. Advertiser may not resell, assign, or transfer any of its rights hereunder. Any such attempt may result in termination of this Agreement, without liability to [sitename] and without any refund. The relationship(s) between [sitename] and the "Partners" is not one of a legal partnership relationship, but is one of independent contractors. This Agreement shall be construed as if both parties jointly wrote it.</div>', '');

DROP TABLE IF EXISTS $prefix.`_bbauth_access`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbauth_access` ( `group_id` mediumint(8) NOT NULL default '0', `forum_id` smallint(5) unsigned NOT NULL default '0', `auth_view` tinyint(1) NOT NULL default '0', `auth_read` tinyint(1) NOT NULL default '0', `auth_post` tinyint(1) NOT NULL default '0', `auth_reply` tinyint(1) NOT NULL default '0', `auth_edit` tinyint(1) NOT NULL default '0', `auth_delete` tinyint(1) NOT NULL default '0', `auth_sticky` tinyint(1) NOT NULL default '0', `auth_announce` tinyint(1) NOT NULL default '0', `auth_vote` tinyint(1) NOT NULL default '0', `auth_pollcreate` tinyint(1) NOT NULL default '0', `auth_attachments` tinyint(1) NOT NULL default '0', `auth_mod` tinyint(1) NOT NULL default '0', KEY `group_id` (`group_id`), KEY `forum_id` (`forum_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbbanlist`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbbanlist` ( `ban_id` mediumint(8) unsigned NOT NULL auto_increment, `ban_userid` mediumint(8) NOT NULL default '0', `ban_ip` varchar(8) NOT NULL default '', `ban_email` varchar(255) default NULL, `ban_time` int(11) default NULL, `ban_expire_time` int(11) default NULL, `ban_by_userid` mediumint(8) default NULL, `ban_priv_reason` text, `ban_pub_reason_mode` tinyint(1) default NULL, `ban_pub_reason` text, PRIMARY KEY  (`ban_id`), KEY `ban_ip_user_id` (`ban_ip`,`ban_userid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbcategories`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbcategories` ( `cat_id` mediumint(8) unsigned NOT NULL auto_increment, `cat_title` varchar(100) default NULL, `cat_order` mediumint(8) unsigned NOT NULL default '0', PRIMARY KEY  (`cat_id`), KEY `cat_order` (`cat_order`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbconfig`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbconfig` ( `config_name` varchar(255) NOT NULL default '', `config_value` varchar(255) NOT NULL default '', PRIMARY KEY  (`config_name`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_bbconfig` VALUES ('config_id', '1');
INSERT INTO $prefix.`_bbconfig` VALUES ('board_disable', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('sitename', 'MySite.com');
INSERT INTO $prefix.`_bbconfig` VALUES ('site_desc', '');
INSERT INTO $prefix.`_bbconfig` VALUES ('cookie_name', 'phpbb2mysql');
INSERT INTO $prefix.`_bbconfig` VALUES ('cookie_path', '/');
INSERT INTO $prefix.`_bbconfig` VALUES ('cookie_domain', 'MySite.com');
INSERT INTO $prefix.`_bbconfig` VALUES ('cookie_secure', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('session_length', '3600');
INSERT INTO $prefix.`_bbconfig` VALUES ('allow_html', '1');
INSERT INTO $prefix.`_bbconfig` VALUES ('allow_html_tags', 'b,i,u,pre');
INSERT INTO $prefix.`_bbconfig` VALUES ('allow_bbcode', '1');
INSERT INTO $prefix.`_bbconfig` VALUES ('allow_smilies', '1');
INSERT INTO $prefix.`_bbconfig` VALUES ('allow_sig', '1');
INSERT INTO $prefix.`_bbconfig` VALUES ('allow_namechange', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('allow_theme_create', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('allow_avatar_local', '1');
INSERT INTO $prefix.`_bbconfig` VALUES ('allow_avatar_remote', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('allow_avatar_upload', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('override_user_style', '1');
INSERT INTO $prefix.`_bbconfig` VALUES ('posts_per_page', '15');
INSERT INTO $prefix.`_bbconfig` VALUES ('topics_per_page', '50');
INSERT INTO $prefix.`_bbconfig` VALUES ('hot_threshold', '25');
INSERT INTO $prefix.`_bbconfig` VALUES ('max_poll_options', '10');
INSERT INTO $prefix.`_bbconfig` VALUES ('max_sig_chars', '255');
INSERT INTO $prefix.`_bbconfig` VALUES ('max_inbox_privmsgs', '100');
INSERT INTO $prefix.`_bbconfig` VALUES ('max_sentbox_privmsgs', '100');
INSERT INTO $prefix.`_bbconfig` VALUES ('max_savebox_privmsgs', '100');
INSERT INTO $prefix.`_bbconfig` VALUES ('board_email_sig', 'Thanks, Webmaster@MySite.com');
INSERT INTO $prefix.`_bbconfig` VALUES ('board_email', 'Webmaster@MySite.com');
INSERT INTO $prefix.`_bbconfig` VALUES ('smtp_delivery', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('smtp_host', '');
INSERT INTO $prefix.`_bbconfig` VALUES ('require_activation', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('flood_interval', '15');
INSERT INTO $prefix.`_bbconfig` VALUES ('board_email_form', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('avatar_filesize', '6144');
INSERT INTO $prefix.`_bbconfig` VALUES ('avatar_max_width', '80');
INSERT INTO $prefix.`_bbconfig` VALUES ('avatar_max_height', '80');
INSERT INTO $prefix.`_bbconfig` VALUES ('avatar_path', 'modules/Forums/images/avatars');
INSERT INTO $prefix.`_bbconfig` VALUES ('avatar_gallery_path', 'modules/Forums/images/avatars');
INSERT INTO $prefix.`_bbconfig` VALUES ('smilies_path', 'modules/Forums/images/smiles');
INSERT INTO $prefix.`_bbconfig` VALUES ('default_style', '1');
INSERT INTO $prefix.`_bbconfig` VALUES ('default_dateformat', 'D M d, Y g:i a');
INSERT INTO $prefix.`_bbconfig` VALUES ('board_timezone', '10');
INSERT INTO $prefix.`_bbconfig` VALUES ('prune_enable', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('privmsg_disable', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('gzip_compress', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('coppa_fax', '');
INSERT INTO $prefix.`_bbconfig` VALUES ('coppa_mail', '');
INSERT INTO $prefix.`_bbconfig` VALUES ('board_startdate', '1013908210');
INSERT INTO $prefix.`_bbconfig` VALUES ('default_lang', 'english');
INSERT INTO $prefix.`_bbconfig` VALUES ('smtp_username', '');
INSERT INTO $prefix.`_bbconfig` VALUES ('smtp_password', '');
INSERT INTO $prefix.`_bbconfig` VALUES ('record_online_users', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('record_online_date', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('server_name', 'MySite.com');
INSERT INTO $prefix.`_bbconfig` VALUES ('server_port', '80');
INSERT INTO $prefix.`_bbconfig` VALUES ('script_path', '/modules/Forums/');
INSERT INTO $prefix.`_bbconfig` VALUES ('version', '.0.23');
INSERT INTO $prefix.`_bbconfig` VALUES ('enable_confirm', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('sendmail_fix', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('allow_autologin', '1');
INSERT INTO $prefix.`_bbconfig` VALUES ('max_autologin_time', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('max_login_attempts', '5');
INSERT INTO $prefix.`_bbconfig` VALUES ('login_reset_time', '30');
INSERT INTO $prefix.`_bbconfig` VALUES ('search_flood_interval', '15');
INSERT INTO $prefix.`_bbconfig` VALUES ('rand_seed', '0');
INSERT INTO $prefix.`_bbconfig` VALUES ('search_min_chars', '3');

DROP TABLE IF EXISTS $prefix.`_bbconfirm`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbconfirm` ( `confirm_id` char(32) NOT NULL default '', `session_id` char(32) NOT NULL default '', `code` char(6) NOT NULL default '', PRIMARY KEY  (`session_id`,`confirm_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbdisallow`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbdisallow` ( `disallow_id` mediumint(8) unsigned NOT NULL auto_increment, `disallow_username` varchar(25) default NULL, PRIMARY KEY  (`disallow_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbforum_prune`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbforum_prune` ( `prune_id` mediumint(8) unsigned NOT NULL auto_increment, `forum_id` smallint(5) unsigned NOT NULL default '0', `prune_days` tinyint(4) unsigned NOT NULL default '0', `prune_freq` tinyint(4) unsigned NOT NULL default '0', PRIMARY KEY  (`prune_id`), KEY `forum_id` (`forum_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbforums`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbforums` ( `forum_id` smallint(5) unsigned NOT NULL auto_increment, `cat_id` mediumint(8) unsigned NOT NULL default '0', `forum_name` varchar(150) default NULL, `forum_desc` text, `forum_status` tinyint(4) NOT NULL default '0', `forum_order` mediumint(8) unsigned NOT NULL default '1', `forum_posts` mediumint(8) unsigned NOT NULL default '0', `forum_topics` mediumint(8) unsigned NOT NULL default '0', `forum_last_post_id` mediumint(8) unsigned NOT NULL default '0', `prune_next` int(11) default NULL, `prune_enable` tinyint(1) NOT NULL default '1', `auth_view` tinyint(2) NOT NULL default '0', `auth_read` tinyint(2) NOT NULL default '0', `auth_post` tinyint(2) NOT NULL default '0', `auth_reply` tinyint(2) NOT NULL default '0', `auth_edit` tinyint(2) NOT NULL default '0', `auth_delete` tinyint(2) NOT NULL default '0', `auth_sticky` tinyint(2) NOT NULL default '0', `auth_announce` tinyint(2) NOT NULL default '0', `auth_vote` tinyint(2) NOT NULL default '0', `auth_pollcreate` tinyint(2) NOT NULL default '0', `auth_attachments` tinyint(2) NOT NULL default '0', PRIMARY KEY  (`forum_id`), KEY `forums_order` (`forum_order`), KEY `cat_id` (`cat_id`), KEY `forum_last_post_id` (`forum_last_post_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbgroups`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbgroups` ( `group_id` mediumint(8) NOT NULL auto_increment, `group_type` tinyint(4) NOT NULL default '1', `group_name` varchar(40) NOT NULL default '', `group_description` varchar(255) NOT NULL default '', `group_moderator` mediumint(8) NOT NULL default '0', `group_single_user` tinyint(1) NOT NULL default '1', PRIMARY KEY  (`group_id`), KEY `group_single_user` (`group_single_user`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_bbgroups` VALUES (1, 1, 'Anonymous', 'Personal User', 0, 1);
INSERT INTO $prefix.`_bbgroups` VALUES (3, 2, 'Moderators', 'Moderators of this Forum', 2, 0);

DROP TABLE IF EXISTS $prefix.`_bbposts`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbposts` ( `post_id` mediumint(8) unsigned NOT NULL auto_increment, `topic_id` mediumint(8) unsigned NOT NULL default '0', `forum_id` smallint(5) unsigned NOT NULL default '0', `poster_id` mediumint(8) NOT NULL default '0', `post_time` int(11) NOT NULL default '0', `poster_ip` varchar(8) NOT NULL default '', `post_username` varchar(25) default NULL, `enable_bbcode` tinyint(1) NOT NULL default '1', `enable_html` tinyint(1) NOT NULL default '0', `enable_smilies` tinyint(1) NOT NULL default '1', `enable_sig` tinyint(1) NOT NULL default '1', `post_edit_time` int(11) default NULL, `post_edit_count` smallint(5) unsigned NOT NULL default '0', PRIMARY KEY  (`post_id`), KEY `forum_id` (`forum_id`), KEY `topic_id` (`topic_id`), KEY `poster_id` (`poster_id`), KEY `post_time` (`post_time`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbposts_text`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbposts_text` ( `post_id` mediumint(8) unsigned NOT NULL default '0', `bbcode_uid` varchar(10) NOT NULL default '', `post_subject` varchar(60) default NULL, `post_text` text, PRIMARY KEY  (`post_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbprivmsgs`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbprivmsgs` ( `privmsgs_id` mediumint(8) unsigned NOT NULL auto_increment, `privmsgs_type` tinyint(4) NOT NULL default '0', `privmsgs_subject` varchar(255) NOT NULL default '0', `privmsgs_from_userid` mediumint(8) NOT NULL default '0', `privmsgs_to_userid` mediumint(8) NOT NULL default '0', `privmsgs_date` int(11) NOT NULL default '0', `privmsgs_ip` varchar(8) NOT NULL default '', `privmsgs_enable_bbcode` tinyint(1) NOT NULL default '1', `privmsgs_enable_html` tinyint(1) NOT NULL default '0', `privmsgs_enable_smilies` tinyint(1) NOT NULL default '1', `privmsgs_attach_sig` tinyint(1) NOT NULL default '1', PRIMARY KEY  (`privmsgs_id`), KEY `privmsgs_from_userid` (`privmsgs_from_userid`), KEY `privmsgs_to_userid` (`privmsgs_to_userid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbprivmsgs_text`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbprivmsgs_text` ( `privmsgs_text_id` mediumint(8) unsigned NOT NULL default '0', `privmsgs_bbcode_uid` varchar(10) NOT NULL default '0', `privmsgs_text` text, PRIMARY KEY  (`privmsgs_text_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbranks`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbranks` ( `rank_id` smallint(5) unsigned NOT NULL auto_increment, `rank_title` varchar(50) NOT NULL default '', `rank_min` mediumint(8) NOT NULL default '0', `rank_max` mediumint(8) NOT NULL default '0', `rank_special` tinyint(1) default '0', `rank_image` varchar(255) default NULL, PRIMARY KEY  (`rank_id`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_bbranks` VALUES (NULL, 'Site Admin', -1, -1, 1, 'modules/Forums/images/ranks/6stars.gif');
INSERT INTO $prefix.`_bbranks` VALUES (NULL, 'Newbie', 1, 0, 0, 'modules/Forums/images/ranks/1star.gif');

DROP TABLE IF EXISTS $prefix.`_bbsearch_results`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbsearch_results` ( `search_id` int(11) unsigned NOT NULL default '0', `session_id` varchar(32) NOT NULL default '', `search_array` text NOT NULL, search_time int(11) DEFAULT '0' NOT NULL, PRIMARY KEY  (`search_id`), KEY `session_id` (`session_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbsearch_wordlist`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbsearch_wordlist` ( `word_text` varchar(50) binary NOT NULL default '', `word_id` mediumint(8) unsigned NOT NULL auto_increment, `word_common` tinyint(1) unsigned NOT NULL default '0', PRIMARY KEY  (`word_text`), KEY `word_id` (`word_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbsearch_wordmatch`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbsearch_wordmatch` ( `post_id` mediumint(8) unsigned NOT NULL default '0', `word_id` mediumint(8) unsigned NOT NULL default '0', `title_match` tinyint(1) NOT NULL default '0', KEY `word_id` (`word_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbsessions`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbsessions` ( `session_id` char(32) NOT NULL default '', `session_user_id` mediumint(8) NOT NULL default '0', `session_start` int(11) NOT NULL default '0', `session_time` int(11) NOT NULL default '0', `session_ip` char(8) NOT NULL default '0', `session_page` int(11) NOT NULL default '0', `session_logged_in` tinyint(1) NOT NULL default '0', `session_admin` tinyint(2) NOT NULL default '0', KEY `session_user_id` (`session_user_id`), KEY `session_ip` (`session_ip`), KEY `session_id` (`session_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbsessions_keys`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbsessions_keys` ( `key_id` varchar(32) NOT NULL default '0', `user_id` mediumint(8) NOT NULL default '0', `last_ip` varchar(8) NOT NULL default '0', `last_login` int(11) NOT NULL default '0', PRIMARY KEY  (`key_id`,`user_id`), KEY `last_login` (`last_login`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbsmilies`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbsmilies` ( `smilies_id` smallint(5) unsigned NOT NULL auto_increment, `code` varchar(50) default NULL, `smile_url` varchar(100) default NULL, `emoticon` varchar(75) default NULL, PRIMARY KEY  (`smilies_id`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':D', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':-D', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':grin:', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':)', 'icon_smile.gif', 'Smile');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':-)', 'icon_smile.gif', 'Smile');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':smile:', 'icon_smile.gif', 'Smile');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':(', 'icon_sad.gif', 'Sad');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':-(', 'icon_sad.gif', 'Sad');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':sad:', 'icon_sad.gif', 'Sad');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':o', 'icon_surprised.gif', 'Surprised');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':-o', 'icon_surprised.gif', 'Surprised');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':eek:', 'icon_surprised.gif', 'Surprised');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, '8O', 'icon_eek.gif', 'Shocked');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, '8-O', 'icon_eek.gif', 'Shocked');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':shock:', 'icon_eek.gif', 'Shocked');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':?', 'icon_confused.gif', 'Confused');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':-?', 'icon_confused.gif', 'Confused');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':???:', 'icon_confused.gif', 'Confused');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, '8)', 'icon_cool.gif', 'Cool');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, '8-)', 'icon_cool.gif', 'Cool');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':cool:', 'icon_cool.gif', 'Cool');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':lol:', 'icon_lol.gif', 'Laughing');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':x', 'icon_mad.gif', 'Mad');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':-x', 'icon_mad.gif', 'Mad');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':mad:', 'icon_mad.gif', 'Mad');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':P', 'icon_razz.gif', 'Razz');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':-P', 'icon_razz.gif', 'Razz');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':razz:', 'icon_razz.gif', 'Razz');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':oops:', 'icon_redface.gif', 'Embarassed');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':cry:', 'icon_cry.gif', 'Crying or Very sad');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':evil:', 'icon_evil.gif', 'Evil or Very Mad');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':twisted:', 'icon_twisted.gif', 'Twisted Evil');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':roll:', 'icon_rolleyes.gif', 'Rolling Eyes');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':wink:', 'icon_wink.gif', 'Wink');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ';)', 'icon_wink.gif', 'Wink');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ';-)', 'icon_wink.gif', 'Wink');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':!:', 'icon_exclaim.gif', 'Exclamation');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':?:', 'icon_question.gif', 'Question');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':idea:', 'icon_idea.gif', 'Idea');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':arrow:', 'icon_arrow.gif', 'Arrow');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':|', 'icon_neutral.gif', 'Neutral');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':-|', 'icon_neutral.gif', 'Neutral');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':neutral:', 'icon_neutral.gif', 'Neutral');
INSERT INTO $prefix.`_bbsmilies` VALUES (NULL, ':mrgreen:', 'icon_mrgreen.gif', 'Mr. Green');

DROP TABLE IF EXISTS $prefix.`_bbthemes`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbthemes` ( `themes_id` mediumint(8) unsigned NOT NULL auto_increment, `template_name` varchar(30) NOT NULL default '', `style_name` varchar(30) NOT NULL default '', `head_stylesheet` varchar(100) default NULL, `body_background` varchar(100) default NULL, `body_bgcolor` varchar(6) default NULL, `body_text` varchar(6) default NULL, `body_link` varchar(6) default NULL, `body_vlink` varchar(6) default NULL, `body_alink` varchar(6) default NULL, `body_hlink` varchar(6) default NULL, `tr_color1` varchar(6) default NULL, `tr_color2` varchar(6) default NULL, `tr_color3` varchar(6) default NULL, `tr_class1` varchar(25) default NULL, `tr_class2` varchar(25) default NULL, `tr_class3` varchar(25) default NULL, `th_color1` varchar(6) default NULL, `th_color2` varchar(6) default NULL, `th_color3` varchar(6) default NULL, `th_class1` varchar(25) default NULL, `th_class2` varchar(25) default NULL, `th_class3` varchar(25) default NULL, `td_color1` varchar(6) default NULL, `td_color2` varchar(6) default NULL, `td_color3` varchar(6) default NULL, `td_class1` varchar(25) default NULL, `td_class2` varchar(25) default NULL, `td_class3` varchar(25) default NULL, `fontface1` varchar(50) default NULL, `fontface2` varchar(50) default NULL, `fontface3` varchar(50) default NULL, `fontsize1` tinyint(4) default NULL, `fontsize2` tinyint(4) default NULL, `fontsize3` tinyint(4) default NULL, `fontcolor1` varchar(6) default NULL, `fontcolor2` varchar(6) default NULL, `fontcolor3` varchar(6) default NULL, `span_class1` varchar(25) default NULL, `span_class2` varchar(25) default NULL, `span_class3` varchar(25) default NULL, `img_size_poll` smallint(5) unsigned default NULL, `img_size_privmsg` smallint(5) unsigned default NULL, PRIMARY KEY  (`themes_id`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_bbthemes` VALUES (1, 'subSilver', 'subSilver', 'subSilver.css', '', '0E3259', '000000', '006699', '5493B4', '', 'DD6900', 'EFEFEF', 'DEE3E7', 'D1D7DC', '', '', '', '98AAB1', '006699', 'FFFFFF', 'cellpic1.gif', 'cellpic3.gif', 'cellpic2.jpg', 'FAFAFA', 'FFFFFF', '', 'row1', 'row2', '', 'Verdana, Arial, Helvetica, sans-serif', 'Trebuchet MS', 'Courier, ''Courier New'', sans-serif', 10, 11, 12, '444444', '006600', 'FFA34F', '', '', '', NULL, NULL);

DROP TABLE IF EXISTS $prefix.`_bbthemes_name`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbthemes_name` ( `themes_id` smallint(5) unsigned NOT NULL default '0', `tr_color1_name` char(50) default NULL, `tr_color2_name` char(50) default NULL, `tr_color3_name` char(50) default NULL, `tr_class1_name` char(50) default NULL, `tr_class2_name` char(50) default NULL, `tr_class3_name` char(50) default NULL, `th_color1_name` char(50) default NULL, `th_color2_name` char(50) default NULL, `th_color3_name` char(50) default NULL, `th_class1_name` char(50) default NULL, `th_class2_name` char(50) default NULL, `th_class3_name` char(50) default NULL, `td_color1_name` char(50) default NULL, `td_color2_name` char(50) default NULL, `td_color3_name` char(50) default NULL, `td_class1_name` char(50) default NULL, `td_class2_name` char(50) default NULL, `td_class3_name` char(50) default NULL, `fontface1_name` char(50) default NULL, `fontface2_name` char(50) default NULL, `fontface3_name` char(50) default NULL, `fontsize1_name` char(50) default NULL, `fontsize2_name` char(50) default NULL, `fontsize3_name` char(50) default NULL, `fontcolor1_name` char(50) default NULL, `fontcolor2_name` char(50) default NULL, `fontcolor3_name` char(50) default NULL, `span_class1_name` char(50) default NULL, `span_class2_name` char(50) default NULL, `span_class3_name` char(50) default NULL, PRIMARY KEY  (`themes_id`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_bbthemes_name` VALUES (1, 'The lightest row colour', 'The medium row color', 'The darkest row colour', '', '', '', 'Border round the whole page', 'Outer table border', 'Inner table border', 'Silver gradient picture', 'Blue gradient picture', 'Fade-out gradient on index', 'Background for quote boxes', 'All white areas', '', 'Background for topic posts', '2nd background for topic posts', '', 'Main fonts', 'Additional topic title font', 'Form fonts', 'Smallest font size', 'Medium font size', 'Normal font size (post body etc)', 'Quote & copyright text', 'Code text colour', 'Main table header text colour', '', '', '');

DROP TABLE IF EXISTS $prefix.`_bbtopics`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbtopics` ( `topic_id` mediumint(8) unsigned NOT NULL auto_increment, `forum_id` smallint(8) unsigned NOT NULL default '0', `topic_title` char(60) NOT NULL default '', `topic_poster` mediumint(8) NOT NULL default '0', `topic_time` int(11) NOT NULL default '0', `topic_views` mediumint(8) unsigned NOT NULL default '0', `topic_replies` mediumint(8) unsigned NOT NULL default '0', `topic_status` tinyint(3) NOT NULL default '0', `topic_vote` tinyint(1) NOT NULL default '0', `topic_type` tinyint(3) NOT NULL default '0', `topic_last_post_id` mediumint(8) unsigned NOT NULL default '0', `topic_first_post_id` mediumint(8) unsigned NOT NULL default '0', `topic_moved_id` mediumint(8) unsigned NOT NULL default '0', PRIMARY KEY  (`topic_id`), KEY `forum_id` (`forum_id`), KEY `topic_moved_id` (`topic_moved_id`), KEY `topic_status` (`topic_status`), KEY `topic_type` (`topic_type`), KEY `topic_last_post_id` (`topic_last_post_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbtopics_watch`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbtopics_watch` ( `topic_id` mediumint(8) unsigned NOT NULL default '0', `user_id` mediumint(8) NOT NULL default '0', `notify_status` tinyint(1) NOT NULL default '0', KEY `topic_id` (`topic_id`), KEY `user_id` (`user_id`), KEY `notify_status` (`notify_status`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbuser_group`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbuser_group` ( `group_id` mediumint(8) NOT NULL default '0', `user_id` mediumint(8) NOT NULL default '0', `user_pending` tinyint(1) default NULL, KEY `group_id` (`group_id`), KEY `user_id` (`user_id`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_bbuser_group` VALUES (1, -1, 0);
INSERT INTO $prefix.`_bbuser_group` VALUES (3, 5, 0);

DROP TABLE IF EXISTS $prefix.`_bbvote_desc`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbvote_desc` ( `vote_id` mediumint(8) unsigned NOT NULL auto_increment, `topic_id` mediumint(8) unsigned NOT NULL default '0', `vote_text` text NOT NULL, `vote_start` int(11) NOT NULL default '0', `vote_length` int(11) NOT NULL default '0', PRIMARY KEY  (`vote_id`), KEY `topic_id` (`topic_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbvote_results`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbvote_results` ( `vote_id` mediumint(8) unsigned NOT NULL default '0', `vote_option_id` tinyint(4) unsigned NOT NULL default '0', `vote_option_text` varchar(255) NOT NULL default '', `vote_result` int(11) NOT NULL default '0', KEY `vote_option_id` (`vote_option_id`), KEY `vote_id` (`vote_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbvote_voters`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbvote_voters` ( `vote_id` mediumint(8) unsigned NOT NULL default '0', `vote_user_id` mediumint(8) NOT NULL default '0', `vote_user_ip` char(8) NOT NULL default '', KEY `vote_id` (`vote_id`), KEY `vote_user_id` (`vote_user_id`), KEY `vote_user_ip` (`vote_user_ip`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbwords`;
CREATE TABLE IF NOT EXISTS $prefix.`_bbwords` ( `word_id` mediumint(8) unsigned NOT NULL auto_increment, `word` char(100) NOT NULL default '', `replacement` char(100) NOT NULL default '', PRIMARY KEY  (`word_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_blocks`;
CREATE TABLE IF NOT EXISTS $prefix.`_blocks` ( `bid` int(10) NOT NULL auto_increment, `bkey` varchar(15) NOT NULL default '', `title` varchar(60) NOT NULL default '', `content` text NOT NULL, `url` varchar(200) NOT NULL default '', `bposition` char(1) NOT NULL default '', `weight` int(10) NOT NULL default '1', `active` int(1) NOT NULL default '1', `refresh` int(10) NOT NULL default '0', `time` varchar(14) NOT NULL default '0', `blanguage` varchar(30) NOT NULL default '', `blockfile` varchar(255) NOT NULL default '', `view` int(1) NOT NULL default '0', `expire` varchar(14) NOT NULL default '0', `action` char(1) NOT NULL default '', `subscription` int(1) NOT NULL default '0', `max_rss_items` int(5) NOT NULL default '0' , PRIMARY KEY  (`bid`), KEY `title` (`title`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_blocks` VALUES (NULL, '', 'nukeNAV', '', '', 'l', 1, 1, 0, '', '', 'block-nukeNAV.php', 0, '0', 'd', 0, 0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, 'admin', 'Administration', '<div class="ul-box"><ul class="rn-ul">\r\n<li><a href="admin.php">Administration</a></li>\r\n<li><a href="admin.php?op=adminStory">NEW Story</a></li>\r\n<li><a href="admin.php?op=create">Change Survey</a></li>\r\n<li><a href="admin.php?op=content">Content</a></li>\r\n<li><a href="admin.php?op=logout">Logout</a></li>\r\n</ul></div>\r\n<div class="block-spacer">&nbsp;</div>', '', 'l', 2, 1, 0, '985591188', '', '', 2, '0', 'd', 0,0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, '', 'Who''s Online', '', '', 'l', 3, 0, 0, '', '', 'block-Who_is_Online.php', 0, '0', 'd', 0,0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, '', 'Search', '', '', 'l', 4, 0, 3600, '', '', 'block-Search.php', 0, '0', 'd', 0,0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, '', 'Languages', '', '', 'l', 5, 0, 3600, '', '', 'block-Languages.php', 0, '0', 'd', 0,0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, '', 'Random Headlines', '', '', 'l', 6, 0, 3600, '', '', 'block-Random_Headlines.php', 0, '0', 'd', 0,0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, '', 'Site Info', '', '', 'l', 7, 1, 3600, '', '', 'block-User_Info.php', 0, 0, 'd', 0,0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, 'userbox', 'User''s Custom Box', '', '', 'r', 1, 1, 0, '', '', '', 1, '0', 'd', 0,0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, '', 'Categories Menu', '', '', 'r', 2, 0, 0, '', '', 'block-Categories.php', 0, '0', 'd', 0,0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, '', 'Survey', '', '', 'r', 3, 1, 3600, '', '', 'block-Survey.php', 0, '0', 'd', 0,0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, '', 'Login', '', '', 'r', 4, 0, 3600, '', '', 'block-Login.php', 3, '0', 'd', 0,0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, '', 'Big Story of Today', '', '', 'r', 5, 0, 3600, '', '', 'block-Big_Story_of_Today.php', 0, '0', 'd', 0,0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, '', 'Old Articles', '', '', 'r', 6, 0, 3600, '', '', 'block-Old_Articles.php', 0, '0', 'd', 0,0);
INSERT INTO $prefix.`_blocks` VALUES (NULL, '', 'Information', '<br /><div class="text-center"><span class="content">\r\n<a href="http://www.ravenphpscripts.com"><img src="images/powered/RavenWebServices.gif" border="0" alt="Powered by RavenNuke&trade;" title="Powered by RavenNuke&trade;" width="88" height="31" /></a></span></div><br />', '', 'r', 7, 0, 0, '', '', '', 0, '0', 'd', 0,0);

DROP TABLE IF EXISTS $prefix.`_comments`;
CREATE TABLE IF NOT EXISTS $prefix.`_comments` ( `tid` int(11) NOT NULL auto_increment, `pid` int(11) NOT NULL default '0', `sid` int(11) NOT NULL default '0', `date` datetime default NULL, `name` varchar(60) NOT NULL default '', `email` varchar(60) default NULL, `url` varchar(60) default NULL, `host_name` varchar(60) default NULL, `subject` varchar(85) NOT NULL default '', `comment` text NOT NULL, `score` tinyint(4) NOT NULL default '0', `reason` tinyint(4) NOT NULL default '0', PRIMARY KEY  (`tid`), KEY `pid` (`pid`), KEY `sid` (`sid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_config`;
CREATE TABLE IF NOT EXISTS $prefix.`_config` ( `sitename` varchar(255) NOT NULL default '', `nukeurl` varchar(255) NOT NULL default '', `site_logo` varchar(255) NOT NULL default '', `slogan` varchar(255) NOT NULL default '', `startdate` varchar(50) NOT NULL default '', `adminmail` varchar(255) NOT NULL default '', `anonpost` tinyint(1) NOT NULL default '0', `Default_Theme` varchar(255) NOT NULL default '', `foot1` text NOT NULL, `foot2` text NOT NULL, `foot3` text NOT NULL, `commentlimit` int(9) NOT NULL default '4096', `anonymous` varchar(255) NOT NULL default '', `minpass` tinyint(1) NOT NULL default '8', `pollcomm` tinyint(1) NOT NULL default '1', `articlecomm` tinyint(1) NOT NULL default '1', `broadcast_msg` tinyint(1) NOT NULL default '1', `my_headlines` tinyint(1) NOT NULL default '1', `top` int(3) NOT NULL default '10', `storyhome` int(2) NOT NULL default '10', `user_news` tinyint(1) NOT NULL default '1', `oldnum` int(2) NOT NULL default '30', `banners` tinyint(1) NOT NULL default '1', `backend_title` varchar(255) NOT NULL default '', `backend_language` varchar(10) NOT NULL default '', `language` varchar(100) NOT NULL default '', `locale` varchar(10) NOT NULL default '', `multilingual` tinyint(1) NOT NULL default '0', `useflags` tinyint(1) NOT NULL default '0', `notify` tinyint(1) NOT NULL default '0', `notify_email` varchar(255) NOT NULL default '', `notify_subject` varchar(255) NOT NULL default '', `notify_message` varchar(255) NOT NULL default '', `notify_from` varchar(255) NOT NULL default '', `moderate` tinyint(1) NOT NULL default '0', `admingraphic` tinyint(1) NOT NULL default '1', `CensorMode` tinyint(1) NOT NULL default '3', `CensorReplace` varchar(10) NOT NULL default '', `copyright` text NOT NULL, `Version_Num` varchar(10) NOT NULL default '', PRIMARY KEY  (`sitename`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_config` VALUES ('RaveNuke&trade; Powered Site', 'http://mysite.com', 'logo.gif', 'Your slogan here', '2018', 'webmaster@mysite.com', 0, 'RavenIce', '', 'All logos and trademarks in this site are property of their respective owner. The comments are property of their posters, all the rest &copy; 2018 by me.', 'You can syndicate our news using the file <a href="backend.php" target="_blank"><span class="footmsg_l">backend.php</span></a>.<br /><br /><span class="footmsg_l"><a href="http://www.ravenphpscripts.com" title="Distributed by Raven PHP Scripts" target="_blank">Distributed by Raven PHP Scripts</a><br />New code written and maintained by the<a href="http://rnwiki.ravennuke.com/wiki/RavenNuke2:Credits" target="_blank"> RavenNuke&trade; TEAM</a></span>', 4096, 'Anonymous', 8, 1, 1, 1, 1, 10, 10, 1, 30, 1, 'RavenNuke&trade; Powered Site', 'en-us', 'english', 'en_US', 0, 0, 0, 'me@mysite.com', 'NEWS for my site', 'Hey! You got a new submission for your site.', 'webmaster', 0, 1, 3, '*****', '<span class="footmsg_l">(Original PHP-Nuke Code Copyright &copy; 2004 by Francisco Burzi)</span>', 'rn2.52.00');

DROP TABLE IF EXISTS $prefix.`_confirm`;
CREATE TABLE IF NOT EXISTS $prefix.`_confirm` ( `confirm_id` char(32) NOT NULL default '', `session_id` char(32) NOT NULL default '', `code` char(6) NOT NULL default '', PRIMARY KEY  (`session_id`,`confirm_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_counter`;
CREATE TABLE IF NOT EXISTS $prefix.`_counter` ( `type` varchar(80) NOT NULL default '', `var` varchar(80) NOT NULL default '', `count` int(10) unsigned NOT NULL default '0',  PRIMARY KEY (`type`(20),`var`(20))) ENGINE=InnoDB;
INSERT INTO $prefix.`_counter` VALUES ('total', 'hits', 0);
INSERT INTO $prefix.`_counter` VALUES ('browser', 'WebTV', 0);
INSERT INTO $prefix.`_counter` VALUES ('browser', 'Lynx', 0);
INSERT INTO $prefix.`_counter` VALUES ('browser', 'MSIE', 0);
INSERT INTO $prefix.`_counter` VALUES ('browser', 'Opera', 0);
INSERT INTO $prefix.`_counter` VALUES ('browser', 'Konqueror', 0);
INSERT INTO $prefix.`_counter` VALUES ('browser', 'Netscape', 0);
INSERT INTO $prefix.`_counter` VALUES ('browser', 'FireFox', 0);
INSERT INTO $prefix.`_counter` VALUES ('browser', 'Bot', 0);
INSERT INTO $prefix.`_counter` VALUES ('browser', 'Other', 0);
INSERT INTO $prefix.`_counter` VALUES ('os', 'Windows', 0);
INSERT INTO $prefix.`_counter` VALUES ('os', 'Linux', 0);
INSERT INTO $prefix.`_counter` VALUES ('os', 'Mac', 0);
INSERT INTO $prefix.`_counter` VALUES ('os', 'FreeBSD', 0);
INSERT INTO $prefix.`_counter` VALUES ('os', 'SunOS', 0);
INSERT INTO $prefix.`_counter` VALUES ('os', 'IRIX', 0);
INSERT INTO $prefix.`_counter` VALUES ('os', 'BeOS', 0);
INSERT INTO $prefix.`_counter` VALUES ('os', 'OS/2', 0);
INSERT INTO $prefix.`_counter` VALUES ('os', 'AIX', 0);
INSERT INTO $prefix.`_counter` VALUES ('os', 'Other', 0);
INSERT INTO $prefix.`_counter` VALUES ('browser', 'Chrome', '0');
INSERT INTO $prefix.`_counter` VALUES ('browser', 'Safari', '0');

DROP TABLE IF EXISTS $prefix.`_encyclopedia`;
CREATE TABLE IF NOT EXISTS $prefix.`_encyclopedia` ( `eid` int(10) NOT NULL auto_increment, `title` varchar(255) NOT NULL default '', `description` text NOT NULL, `elanguage` varchar(30) NOT NULL default '', `active` int(1) NOT NULL default '0', PRIMARY KEY  (`eid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_encyclopedia_text`;
CREATE TABLE IF NOT EXISTS $prefix.`_encyclopedia_text` ( `tid` int(10) NOT NULL auto_increment, `eid` int(10) NOT NULL default '0', `title` varchar(255) NOT NULL default '', `text` text NOT NULL, `counter` int(10) NOT NULL default '0', PRIMARY KEY  (`tid`), KEY `eid` (`eid`), KEY `title` (`title`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_faqanswer`;
CREATE TABLE IF NOT EXISTS $prefix.`_faqanswer` ( `id` tinyint(4) NOT NULL auto_increment, `id_cat` tinyint(4) NOT NULL default '0', `question` varchar(255) default '', `answer` text, PRIMARY KEY  (`id`), KEY `id_cat` (`id_cat`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_faqcategories`;
CREATE TABLE IF NOT EXISTS $prefix.`_faqcategories` ( `id_cat` tinyint(3) NOT NULL auto_increment, `categories` varchar(255) default NULL, `flanguage` varchar(30) NOT NULL default '', PRIMARY KEY  (`id_cat`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_groups`;
CREATE TABLE IF NOT EXISTS $prefix.`_groups` ( `id` int(10) NOT NULL auto_increment, `name` varchar(255) NOT NULL default '', `description` text NOT NULL, `points` int(10) NOT NULL default '0', PRIMARY KEY `id` (`id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_groups_points`;
CREATE TABLE IF NOT EXISTS $prefix.`_groups_points` ( `id` int(10) NOT NULL auto_increment, `points` int(10) NOT NULL default '0', PRIMARY KEY `id` (`id`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);
INSERT INTO $prefix.`_groups_points` VALUES (NULL, 0);

DROP TABLE IF EXISTS $prefix.`_headlines`;
CREATE TABLE IF NOT EXISTS $prefix.`_headlines` ( `hid` int(11) NOT NULL auto_increment, `sitename` varchar(30) NOT NULL default '', `headlinesurl` varchar(200) NOT NULL default '', PRIMARY KEY  (`hid`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'RavenPHPScripts', 'http://www.ravenphpscripts.com/backend.php');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'Montego Scripts', 'http://montegoscripts.com/modules.php?name=Feeds&fid=1&type=RSS20');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'Code Authors', 'http://www.code-authors.com/modules.php?name=Feeds&fid=1&type=RSS20');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'Star Wars Rebellion', 'http://www.swrebellion.com/backend.php');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'nukeSEO', 'http://feeds.nukeseo.com/nukeSEO');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'Freshmeat', 'http://freshmeat.net/?format=atom');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'Learning Linux', 'http://www.learninglinux.com/backend.php');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'Linux.com', 'http://www.linux.com/feature/?theme=rss');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'LinuxCentral', 'http://linuxcentral.com/rss.php');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'LinuxJournal', 'http://feeds.feedburner.com/linuxjournalcom');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'LinuxWeelyNews', 'http://lwn.net/headlines/rss');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'mozillaZine', 'http://www.mozillazine.org/atom.xml');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'NukeResources', 'http://www.nukeresources.com/npbackend.php');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'PHPBuilder', 'http://phpbuilder.com/rss_feed.php');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'WebReference', 'http://webreference.com/webreference.rdf');
INSERT INTO $prefix.`_headlines` VALUES (NULL, 'Wikipedia Recent Changes', 'http://en.wikipedia.org/w/index.php?title=Special:Recentchanges&feed=atom');

DROP TABLE IF EXISTS $prefix.`_links_categories`;
CREATE TABLE IF NOT EXISTS $prefix.`_links_categories` ( `cid` int(11) NOT NULL auto_increment, `title` varchar(50) NOT NULL default '', `cdescription` text NOT NULL, `parentid` int(11) NOT NULL default '0', PRIMARY KEY  (`cid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_links_editorials`;
CREATE TABLE IF NOT EXISTS $prefix.`_links_editorials` ( `linkid` int(11) NOT NULL default '0', `adminid` varchar(60) NOT NULL default '', `editorialtimestamp` datetime NOT NULL default '1000-01-01 00:00:00', `editorialtext` text NOT NULL, `editorialtitle` varchar(100) NOT NULL default '', PRIMARY KEY  (`linkid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_links_links`;
CREATE TABLE IF NOT EXISTS $prefix.`_links_links` ( `lid` int(11) NOT NULL auto_increment, `cid` int(11) NOT NULL default '0', `sid` int(11) NOT NULL default '0', `title` varchar(100) NOT NULL default '', `url` varchar(100) NOT NULL default '', `description` text NOT NULL, `date` datetime default NULL, `name` varchar(100) NOT NULL default '', `email` varchar(100) NOT NULL default '', `hits` int(11) NOT NULL default '0', `submitter` varchar(60) NOT NULL default '', `linkratingsummary` double(6,4) NOT NULL default '0.0000', `totalvotes` int(11) NOT NULL default '0', `totalcomments` int(11) NOT NULL default '0', PRIMARY KEY  (`lid`), KEY `cid` (`cid`), KEY `sid` (`sid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_links_modrequest`;
CREATE TABLE IF NOT EXISTS $prefix.`_links_modrequest` ( `requestid` int(11) NOT NULL auto_increment, `lid` int(11) NOT NULL default '0', `cid` int(11) NOT NULL default '0', `sid` int(11) NOT NULL default '0', `title` varchar(100) NOT NULL default '', `url` varchar(100) NOT NULL default '', `description` text NOT NULL, `modifysubmitter` varchar(60) NOT NULL default '', `brokenlink` int(3) NOT NULL default '0', PRIMARY KEY  (`requestid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_links_newlink`;
CREATE TABLE IF NOT EXISTS $prefix.`_links_newlink` ( `lid` int(11) NOT NULL auto_increment, `cid` int(11) NOT NULL default '0', `sid` int(11) NOT NULL default '0', `title` varchar(100) NOT NULL default '', `url` varchar(100) NOT NULL default '', `description` text NOT NULL, `name` varchar(100) NOT NULL default '', `email` varchar(100) NOT NULL default '', `submitter` varchar(60) NOT NULL default '', PRIMARY KEY  (`lid`), KEY `cid` (`cid`), KEY `sid` (`sid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_links_votedata`;
CREATE TABLE IF NOT EXISTS $prefix.`_links_votedata` ( `ratingdbid` int(11) NOT NULL auto_increment, `ratinglid` int(11) NOT NULL default '0', `ratinguser` varchar(60) NOT NULL default '', `rating` int(11) NOT NULL default '0', `ratinghostname` varchar(60) NOT NULL default '', `ratingcomments` text NOT NULL, `ratingtimestamp` datetime NOT NULL default '1000-01-01 00:00:00', PRIMARY KEY  (`ratingdbid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_main`;
CREATE TABLE IF NOT EXISTS $prefix.`_main` ( `main_module` varchar(255) NOT NULL default '' ) ENGINE=InnoDB;
INSERT INTO $prefix.`_main` VALUES ('News');

DROP TABLE IF EXISTS $prefix.`_message`;
CREATE TABLE IF NOT EXISTS $prefix.`_message` ( `mid` int(11) NOT NULL auto_increment, `title` varchar(100) NOT NULL default '', `content` text NOT NULL, `date` varchar(14) NOT NULL default '', `expire` int(7) NOT NULL default '0', `active` int(1) NOT NULL default '1', `view` int(1) NOT NULL default '1', `mlanguage` varchar(30) NOT NULL default '', PRIMARY KEY  (`mid`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_message` VALUES (1, 'Welcome to RavenNuke&trade;!','<div class="text-center"><a href="http://www.ravenphpscripts.com" title="RavenPHPScripts - Home of RavenNuke&trade;"><img border="0" src="images/ravennuke76/RN_Book_NoVersion.png" alt="" /></a></div><p style="text-align: left;"><span style="font-size:12.0pt;font-family:Arial">RavenNuke&trade; is the smart choice to fulfill your needs; whether you need to build a simple or complex website, whether it is for your personal, organizational or business needs. It comes complete with a variety of great looking themes and a variety of built in modules that we are sure you will find extremely useful. If that is not enough, RavenNuke&trade; is search engine friendly,&nbsp; conforms to security and web standards and has an active support community. There is also a large community dedicated to developing third party modules and other add-ons you can install. In short, RavenNuke&trade; was created with security, ease of use and ease of installation in mind which makes it the CMS of choice for both newcomers and seasoned web developers.</span></p><p style="text-align: left;"><span style="font-size:12.0pt;font-family:Arial">If you have a support question or would just like to discuss RavenNuke&trade; in general please visit our </span><span style="color:blue"><a target="_blank" href="http://www.ravenphpscripts.com"><span style="font-family:Arial">Support Site</span></a></span><span style="font-family:Arial">.</span></p><p style="text-align: left;"><span style="font-size:12.0pt;font-family:Arial">If you would like an in-depth description of the changes in this release please visit the&nbsp;</span><a target="_blank" href="http://rnwiki.ravennuke.com/wiki/RavenNuke2:Release_Notes"><span style="font-family:Arial">RavenNuke Wiki</span></a><span style="font-family:Arial">.</span></p><p style="text-align: left;"><span style="font-size:12.0pt;font-family:Arial">As always your donations to the project are always appreciated, and are needed to keep this project going.&nbsp; If you are able please make a </span><a target="_blank" href="http://www.ravenphpscripts.com/donations.html"><span style="font-family:Arial">donation</span></a><span style="font-family:Arial">.</span></p>', '1252991938', 0, 1, 1, '');

DROP TABLE IF EXISTS $prefix.`_modules`;
CREATE TABLE IF NOT EXISTS $prefix.`_modules` ( `mid` int(10) NOT NULL auto_increment, `title` varchar(255) NOT NULL default '', `custom_title` varchar(255) NOT NULL default '', `active` int(1) NOT NULL default '0', `view` int(1) NOT NULL default '0', `inmenu` tinyint(1) NOT NULL default '1', `mod_group` int(10) default '0', `admins` varchar(255) NOT NULL default '', PRIMARY KEY  (`mid`), KEY `title` (`title`), KEY `custom_title` (`custom_title`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Advertising', 'Advertising', 0, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'AvantGo', 'AvantGo', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Comments', 'Comments', 1, 0, 0, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Content', 'Content', 0, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Downloads', 'Downloads', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Encyclopedia', 'Encyclopedia', 0, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'ErrorDocuments', 'ErrorDocuments', 0, 0, 0, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'FAQ', 'FAQ', 0, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Feedback', 'Feedback', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Feeds', 'Feeds', 1, 0, 0, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Forums', 'Forums', 0, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'GCalendar', 'GCalendar', 0, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Groups', 'Groups', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'HTML_Newsletter', 'Newsletters', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Legal', 'Legal', 1, 0, 0, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Members_List', 'Members List', 0, 1, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'News', 'News', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'nukeNAV', 'NukeNav', 1, 0, 0, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'NukeSentinel', 'NukeSentinel', 0, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Private_Messages', 'Private Messages', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Recommend_Us', 'Recommend Us', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Resend_Email', 'Resend Email', 1, 0, 0, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Reviews', 'Reviews', 0, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'rwsMetAuthors', 'Authors and Articles', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Search', 'Search', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Statistics', 'Statistics', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Stories_Archive', 'Stories Archive', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Submit_News', 'Submit News', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Surveys', 'Surveys', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Top', 'Top 10', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Topics', 'Topics', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Web_Links', 'Web Links', 1, 0, 1, 0, '');
INSERT INTO $prefix.`_modules` VALUES (NULL, 'Your_Account', 'Your Account', 1, 0, 1, 0, '');

DROP TABLE IF EXISTS $prefix.`_nsngd_accesses`;
CREATE TABLE $prefix.`_nsngd_accesses` ( `username` varchar(60) NOT NULL default '', `downloads` int(11) NOT NULL default '0', `uploads` int(11) NOT NULL default '0', PRIMARY KEY (`username`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS $prefix.`_nsngd_categories`;
CREATE TABLE $prefix.`_nsngd_categories` ( `cid` int(11) NOT NULL auto_increment, `title` varchar(50) NOT NULL default '', `cdescription` text NOT NULL, `parentid` int(11) NOT NULL default '0', `whoadd` tinyint(2) NOT NULL default '0', `uploaddir` varchar(255) NOT NULL default '', `canupload` tinyint(2) NOT NULL default '0', `active` tinyint(2) NOT NULL default '1', PRIMARY KEY  (`cid`), KEY `cid` (`cid`), KEY `title` (`title`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS $prefix.`_nsngd_config`;
CREATE TABLE $prefix.`_nsngd_config` ( `config_name` varchar(255) NOT NULL default '', `config_value` text NOT NULL, PRIMARY KEY  (`config_name`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO $prefix.`_nsngd_config` (`config_name`, `config_value`) VALUES ('admperpage', '50'), ('blockunregmodify', '1'), ('dateformat', 'D M j G:i:s T Y'), ('mostpopular', '25'), ('mostpopulartrig', '0'), ('perpage', '10'), ('popular', '500'), ('results', '10'), ('show_links_num', '0'), ('usegfxcheck', '0'), ('show_download', '0'), ('version_number', '1.1.3'), ('version_db', '100');

DROP TABLE IF EXISTS $prefix.`_nsngd_downloads`;
CREATE TABLE $prefix.`_nsngd_downloads` ( `lid` int(11) NOT NULL auto_increment, `cid` int(11) NOT NULL default '0', `sid` int(11) NOT NULL default '0', `title` varchar(100) NOT NULL default '', `url` varchar(255) NOT NULL default '', `description` text NOT NULL, `date` datetime NOT NULL default '1000-01-01 00:00:00', `name` varchar(100) NOT NULL default '', `email` varchar(100) NOT NULL default '', `hits` int(11) NOT NULL default '0', `submitter` varchar(60) NOT NULL default '', `sub_ip` varchar(16) NOT NULL default '0.0.0.0', `filesize` bigint(20) NOT NULL default '0', `version` varchar(20) NOT NULL default '', `homepage` varchar(255) NOT NULL default '', `active` tinyint(2) NOT NULL default '1', PRIMARY KEY  (`lid`), KEY `lid` (`lid`), KEY `cid` (`cid`), KEY `sid` (`sid`), KEY `title` (`title`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS $prefix.`_nsngd_extensions`;
CREATE TABLE $prefix.`_nsngd_extensions` ( `eid` int(11) NOT NULL auto_increment, `ext` varchar(6) NOT NULL default '', `file` tinyint(1) NOT NULL default '0', `image` tinyint(1) NOT NULL default '0', PRIMARY KEY  (`eid`), KEY `ext` (`eid`) ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21;
INSERT INTO $prefix.`_nsngd_extensions` (`eid`, `ext`, `file`, `image`) VALUES (1, '.ace', 1, 0), (2, '.arj', 1, 0), (3, '.bz', 1, 0), (4, '.bz2', 1, 0), (5, '.cab', 1, 0), (6, '.exe', 1, 0), (7, '.gif', 0, 1), (8, '.gz', 1, 0), (9, '.iso', 1, 0), (10, '.jpeg', 0, 1), (11, '.jpg', 0, 1), (12, '.lha', 1, 0), (13, '.lzh', 1, 0), (14, '.png', 0, 1), (15, '.rar', 1, 0), (16, '.tar', 1, 0), (17, '.tgz', 1, 0), (18, '.uue', 1, 0), (19, '.zip', 1, 0), (20, '.zoo', 1, 0);

DROP TABLE IF EXISTS $prefix.`_nsngd_mods`;
CREATE TABLE $prefix.`_nsngd_mods` ( `rid` int(11) NOT NULL auto_increment, `lid` int(11) NOT NULL default '0', `cid` int(11) NOT NULL default '0', `sid` int(11) NOT NULL default '0', `title` varchar(100) NOT NULL default '', `url` varchar(255) NOT NULL default '', `description` text NOT NULL, `modifier` varchar(60) NOT NULL default '', `sub_ip` varchar(16) NOT NULL default '0.0.0.0', `brokendownload` int(3) NOT NULL default '0', `name` varchar(100) NOT NULL default '', `email` varchar(100) NOT NULL default '', `filesize` bigint(20) NOT NULL default '0', `version` varchar(20) NOT NULL default '', `homepage` varchar(255) NOT NULL default '', PRIMARY KEY  (`rid`), UNIQUE KEY `rid` (`rid`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS $prefix.`_nsngd_new`;
CREATE TABLE $prefix.`_nsngd_new` ( `lid` int(11) NOT NULL auto_increment, `cid` int(11) NOT NULL default '0', `sid` int(11) NOT NULL default '0', `title` varchar(100) NOT NULL default '', `url` varchar(255) NOT NULL default '', `description` text NOT NULL, `date` datetime NOT NULL default '1000-01-01 00:00:00', `name` varchar(100) NOT NULL default '', `email` varchar(100) NOT NULL default '', `submitter` varchar(60) NOT NULL default '', `sub_ip` varchar(16) NOT NULL default '0.0.0.0', `filesize` bigint(20) NOT NULL default '0', `version` varchar(20) NOT NULL default '', `homepage` varchar(255) NOT NULL default '', PRIMARY KEY  (`lid`), KEY `lid` (`lid`), KEY `cid` (`cid`), KEY `sid` (`sid`), KEY `title` (`title`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS $prefix.`_poll_check`;
CREATE TABLE IF NOT EXISTS $prefix.`_poll_check` ( `ip` varchar(20) NOT NULL default '', `time` varchar(14) NOT NULL default '', `pollID` int(10) NOT NULL default '0',  PRIMARY KEY  (`pollID`,`ip`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_poll_data`;
CREATE TABLE IF NOT EXISTS $prefix.`_poll_data` ( `pollID` int(11) NOT NULL default '0', `optionText` char(50) NOT NULL default '', `optionCount` int(11) NOT NULL default '0', `voteID` int(11) NOT NULL default '0' ) ENGINE=InnoDB;
INSERT INTO $prefix.`_poll_data` VALUES (1, 'Ummmm, not bad', 0, 1);
INSERT INTO $prefix.`_poll_data` VALUES (1, 'Cool', 0, 2);
INSERT INTO $prefix.`_poll_data` VALUES (1, 'Terrific', 0, 3);
INSERT INTO $prefix.`_poll_data` VALUES (1, 'The best one!', 0, 4);
INSERT INTO $prefix.`_poll_data` VALUES (1, 'What is this?', 0, 5);
INSERT INTO $prefix.`_poll_data` VALUES (1, '', 0, 6);
INSERT INTO $prefix.`_poll_data` VALUES (1, '', 0, 7);
INSERT INTO $prefix.`_poll_data` VALUES (1, '', 0, 8);
INSERT INTO $prefix.`_poll_data` VALUES (1, '', 0, 9);
INSERT INTO $prefix.`_poll_data` VALUES (1, '', 0, 10);
INSERT INTO $prefix.`_poll_data` VALUES (1, '', 0, 11);
INSERT INTO $prefix.`_poll_data` VALUES (1, '', 0, 12);

DROP TABLE IF EXISTS $prefix.`_poll_desc`;
CREATE TABLE IF NOT EXISTS $prefix.`_poll_desc` ( `pollID` int(11) NOT NULL auto_increment, `pollTitle` varchar(100) NOT NULL default '', `timeStamp` int(11) NOT NULL default '0', `voters` mediumint(9) NOT NULL default '0', `planguage` varchar(30) NOT NULL default '', `artid` int(10) NOT NULL default '0', PRIMARY KEY  (`pollID`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_poll_desc` VALUES (1, 'What do you think about this site?', 961405160, 0, 'english', 0);

DROP TABLE IF EXISTS $prefix.`_pollcomments`;
CREATE TABLE IF NOT EXISTS $prefix.`_pollcomments` ( `tid` int(11) NOT NULL auto_increment, `pid` int(11) NOT NULL default '0', `pollID` int(11) NOT NULL default '0', `date` datetime default NULL, `name` varchar(60) NOT NULL default '', `email` varchar(60) default NULL, `url` varchar(60) default NULL, `host_name` varchar(60) default NULL, `subject` varchar(60) NOT NULL default '', `comment` text NOT NULL, `score` tinyint(4) NOT NULL default '0', `reason` tinyint(4) NOT NULL default '0', PRIMARY KEY  (`tid`), KEY `pid` (`pid`), KEY `pollID` (`pollID`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_public_messages`;
CREATE TABLE IF NOT EXISTS $prefix.`_public_messages` ( `mid` int(10) NOT NULL auto_increment, `content` varchar(255) NOT NULL default '', `date` varchar(14) default NULL, `who` varchar(25) NOT NULL default '', PRIMARY KEY  (`mid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_queue`;
CREATE TABLE IF NOT EXISTS $prefix.`_queue` ( `qid` smallint(5) unsigned NOT NULL auto_increment, `uid` mediumint(9) NOT NULL default '0', `uname` varchar(40) NOT NULL default '', `subject` varchar(100) NOT NULL default '', `story` text, `storyext` text NOT NULL, `timestamp` datetime NOT NULL default '1000-01-01 00:00:00', `topic` varchar(20) NOT NULL default '', `alanguage` varchar(30) NOT NULL default '', PRIMARY KEY  (`qid`), KEY `uid` (`uid`), KEY `uname` (`uname`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_quotes`;

DROP TABLE IF EXISTS $prefix.`_related`;
CREATE TABLE IF NOT EXISTS $prefix.`_related` ( `rid` int(11) NOT NULL auto_increment, `tid` int(11) NOT NULL default '0', `name` varchar(30) NOT NULL default '', `url` varchar(200) NOT NULL default '', PRIMARY KEY  (`rid`), KEY `tid` (`tid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_reviews`;
CREATE TABLE IF NOT EXISTS $prefix.`_reviews` ( `id` int(10) NOT NULL auto_increment, `date` date NOT NULL default '1000-01-01', `title` varchar(150) NOT NULL default '', `text` text NOT NULL, `reviewer` varchar(25) default NULL, `email` varchar(60) default NULL, `score` int(10) NOT NULL default '0', `cover` varchar(100) NOT NULL default '', `url` varchar(100) NOT NULL default '', `url_title` varchar(50) NOT NULL default '', `hits` int(10) NOT NULL default '0', `rlanguage` varchar(30) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_reviews_add`;
CREATE TABLE IF NOT EXISTS $prefix.`_reviews_add` ( `id` int(10) NOT NULL auto_increment, `date` date default NULL, `title` varchar(150) NOT NULL default '', `text` text NOT NULL, `reviewer` varchar(25) NOT NULL default '', `email` varchar(60) default NULL, `score` int(10) NOT NULL default '0', `url` varchar(100) NOT NULL default '', `url_title` varchar(50) NOT NULL default '', `rlanguage` varchar(30) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_reviews_comments`;
CREATE TABLE IF NOT EXISTS $prefix.`_reviews_comments` ( `cid` int(10) NOT NULL auto_increment, `rid` int(10) NOT NULL default '0', `userid` varchar(25) NOT NULL default '', `date` datetime default NULL, `comments` text, `score` int(10) NOT NULL default '0', PRIMARY KEY  (`cid`), KEY `rid` (`rid`), KEY `userid` (`userid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_reviews_main`;
CREATE TABLE IF NOT EXISTS $prefix.`_reviews_main` ( `title` varchar(100) default NULL, `description` text ) ENGINE=InnoDB;
INSERT INTO $prefix.`_reviews_main` VALUES ('Reviews Section Title', 'Reviews Section Long Description');

DROP TABLE IF EXISTS $prefix.`_session`;
CREATE TABLE IF NOT EXISTS $prefix.`_session` ( `uname` varchar(25) NOT NULL default '', `time` varchar(14) NOT NULL default '', `host_addr` varchar(48) NOT NULL default '', `guest` int(1) NOT NULL default '0', KEY `time` (`time`), KEY `guest` (`guest`), KEY `uname` (`uname`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_stats_date`;
CREATE TABLE IF NOT EXISTS $prefix.`_stats_date` ( `year` smallint(6) NOT NULL default '0', `month` tinyint(4) NOT NULL default '0', `date` tinyint(4) NOT NULL default '0',  `hits` bigint(20) NOT NULL default '0', PRIMARY KEY  (`year`,`month`,`date`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_stats_hour`;
CREATE TABLE IF NOT EXISTS $prefix.`_stats_hour` ( `year` smallint(6) NOT NULL default '0', `month` tinyint(4) NOT NULL default '0', `date` tinyint(4) NOT NULL default '0',  `hour` tinyint(4) NOT NULL default '0', `hits` int(11) NOT NULL default '0', PRIMARY KEY  (`year`,`month`,`date`,`hour`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_stats_month`;
CREATE TABLE IF NOT EXISTS $prefix.`_stats_month` ( `year` smallint(6) NOT NULL default '0', `month` tinyint(4) NOT NULL default '0', `hits` bigint(20) NOT NULL default '0',  PRIMARY KEY  (`year`,`month`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_stats_year`;
CREATE TABLE IF NOT EXISTS $prefix.`_stats_year` ( `year` smallint(6) NOT NULL default '0', `hits` bigint(20) NOT NULL default '0', PRIMARY KEY  (`year`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_stories`;
CREATE TABLE IF NOT EXISTS $prefix.`_stories` ( `sid` int(11) NOT NULL auto_increment, `catid` int(11) NOT NULL default '0', `aid` varchar(25) NOT NULL default '', `title` varchar(80) default NULL, `time` datetime default NULL, `hometext` text, `bodytext` text NOT NULL, `comments` int(11) default '0', `counter` mediumint(8) unsigned default NULL, `topic` int(3) NOT NULL default '1', `informant` varchar(25) NOT NULL default '', `notes` text NOT NULL, `ihome` int(1) NOT NULL default '0', `alanguage` varchar(30) NOT NULL default '', `acomm` int(1) NOT NULL default '0', `haspoll` int(1) NOT NULL default '0', `pollID` int(10) NOT NULL default '0', `score` int(10) NOT NULL default '0', `ratings` int(10) NOT NULL default '0', `associated` text NOT NULL, PRIMARY KEY  (`sid`), KEY `catid` (`catid`), KEY `counter` (`counter`), KEY `topic` (`topic`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_stories_cat`;
CREATE TABLE IF NOT EXISTS $prefix.`_stories_cat` ( `catid` int(11) NOT NULL auto_increment, `title` varchar(20) NOT NULL default '', `counter` int(11) NOT NULL default '0', PRIMARY KEY  (`catid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_subscriptions`;
CREATE TABLE IF NOT EXISTS $prefix.`_subscriptions` ( `id` int(10) NOT NULL auto_increment, `userid` int(10) NOT NULL default '0', `subscription_expire` varchar(50) NOT NULL default '', PRIMARY KEY `id` (`id`,`userid`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_topics`;
CREATE TABLE IF NOT EXISTS $prefix.`_topics` ( `topicid` int(3) NOT NULL auto_increment, `topicname` varchar(20) default NULL, `topicimage` varchar(20) default NULL, `topictext` varchar(40) default NULL, `counter` int(11) NOT NULL default '0', PRIMARY KEY  (`topicid`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_topics` VALUES (1, 'ravennuke', 'ravennuke76s2.png', 'RavenNuke&trade;', 0);

DROP TABLE IF EXISTS $user_prefix.`_users`;
CREATE TABLE IF NOT EXISTS $user_prefix.`_users` ( `user_id` int(11) NOT NULL auto_increment, `name` varchar(60) NOT NULL default '', `username` varchar(25) NOT NULL default '', `user_email` varchar(255) NOT NULL default '', `femail` varchar(255) NOT NULL default '', `user_website` varchar(255) NOT NULL default '', `user_avatar` varchar(255) NOT NULL default '', `user_regdate` varchar(20) NOT NULL default '', `user_icq` varchar(15) default NULL, `user_occ` varchar(100) default NULL, `user_from` varchar(100) default NULL, `user_interests` varchar(150) NOT NULL default '', `user_sig` varchar(255) default NULL, `user_viewemail` tinyint(2) default NULL, `user_theme` int(3) default NULL, `user_aim` varchar(18) default NULL, `user_yim` varchar(25) default NULL, `user_msnm` varchar(25) default NULL, `user_password` varchar(40) NOT NULL default '', `storynum` tinyint(4) NOT NULL default '10', `umode` varchar(10) NOT NULL default '', `uorder` tinyint(1) NOT NULL default '0', `thold` tinyint(1) NOT NULL default '0', `noscore` tinyint(1) NOT NULL default '0', `bio` tinytext NULL default NULL, `ublockon` tinyint(1) NOT NULL default '0', `ublock` tinytext NULL default NULL, `theme` varchar(255) NOT NULL default '', `commentmax` int(11) NOT NULL default '4096', `counter` int(11) NOT NULL default '0', `newsletter` int(1) NOT NULL default '0', `user_posts` int(10) NOT NULL default '0', `user_attachsig` int(2) NOT NULL default '0', `user_rank` int(10) NOT NULL default '0', `user_level` int(10) NOT NULL default '1', `broadcast` tinyint(1) NOT NULL default '1', `popmeson` tinyint(1) NOT NULL default '0', `user_active` tinyint(1) default '1', `user_session_time` int(11) NOT NULL default '0', `user_session_page` smallint(5) NOT NULL default '0', `user_lastvisit` int(11) NOT NULL default '0', `user_timezone` tinyint(4) NOT NULL default '10', `user_style` tinyint(4) default NULL, `user_lang` varchar(255) NOT NULL default 'english', `user_dateformat` varchar(14) NOT NULL default 'D M d, Y g:i a', `user_new_privmsg` smallint(5) unsigned NOT NULL default '0', `user_unread_privmsg` smallint(5) unsigned NOT NULL default '0', `user_last_privmsg` int(11) NOT NULL default '0', `user_emailtime` int(11) default NULL, `user_allowhtml` tinyint(1) default '1', `user_allowbbcode` tinyint(1) default '1', `user_allowsmile` tinyint(1) default '1', `user_allowavatar` tinyint(1) NOT NULL default '1', `user_allow_pm` tinyint(1) NOT NULL default '1', `user_allow_viewonline` tinyint(1) NOT NULL default '1', `user_notify` tinyint(1) NOT NULL default '0', `user_notify_pm` tinyint(1) NOT NULL default '0', `user_popup_pm` tinyint(1) NOT NULL default '0', `user_avatar_type` tinyint(4) NOT NULL default '3', `user_sig_bbcode_uid` varchar(10) default NULL, `user_actkey` varchar(32) default NULL, `user_newpasswd` varchar(32) default NULL, `points` int(10) default '0', `last_ip` varchar(15) NOT NULL default '0', `user_login_tries` smallint(5) unsigned NOT NULL default '0', `user_last_login_try` int(11) NOT NULL default '0', `agreedtos` TINYINT(1) DEFAULT 0 NOT NULL, `lastsitevisit` INT(11) NOT NULL DEFAULT 0, PRIMARY KEY  (`user_id`), KEY `uname` (`username`), KEY `user_session_time` (`user_session_time`) ) ENGINE=InnoDB;
INSERT INTO $user_prefix.`_users` VALUES (1, '', 'Anonymous', '', '', '', 'blank.gif', 'Oct 10, 2008', '', '', '', '', '', 0, 0, '', '', '', '', 10, '', 0, 0, 0, '', 0, '', '', 4096, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 10, NULL, 'english', 'D M d, Y g:i a', 0, 0, 0, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 0, 3, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0);

DROP TABLE IF EXISTS $user_prefix.`_users_temp`;
CREATE TABLE IF NOT EXISTS $user_prefix.`_users_temp` ( `user_id` int(10) NOT NULL auto_increment, `username` varchar(25) NOT NULL default '', `name` VARCHAR(255) NOT NULL, `user_email` varchar(255) NOT NULL default '', `femail` varchar(255) NOT NULL default '', `user_website` varchar(255) NOT NULL default '', `user_password` varchar(40) NOT NULL default '', `user_regdate` varchar(20) NOT NULL default '', `user_icq` varchar(15) default NULL, `user_occ` varchar(100) default NULL, `user_from` varchar(100) default NULL, `user_interests` varchar(150) NOT NULL default '', `user_sig` varchar(255) default NULL, `user_viewemail` tinyint(2) default NULL, `user_aim` varchar(18) default NULL, `user_yim` varchar(25) default NULL, `user_msnm` varchar(25) default NULL, `bio` tinytext NULL default NULL, `newsletter` int(1) NOT NULL default '0', `user_allow_viewonline` tinyint(1) NOT NULL default '1', `user_sig_bbcode_uid` varchar(10) default NULL, `check_num` varchar(50) NOT NULL default '', `time` varchar(14) NOT NULL default '', `requestor` VARCHAR(25) NOT NULL, `admin_approve` BOOL NOT NULL DEFAULT '0', PRIMARY KEY  (`user_id`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $user_prefix.`_users_config`;
CREATE TABLE $user_prefix.`_users_config` (config_name varchar(255) NOT NULL default '', config_value longtext, UNIQUE KEY config_name (config_name)) ENGINE=InnoDB;
INSERT INTO $user_prefix.`_users_config` VALUES ('allowmailchange', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('allowuserdelete', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('allowuserreg', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('allowusertheme', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('autosuspend', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('autosuspendmain', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('bad_mail', 'aravensoft.com\r\nbk.ru\r\nlist.ru\r\nmail.ru\r\nmysite.com\r\nya.ru\r\nyoursite.com');
INSERT INTO $user_prefix.`_users_config` VALUES ('bad_nick', 'adm\r\nadmin\r\nanonimo\r\nanonymous\r\nan=nimo\r\ngod\r\nlinux\r\nnobody\r\noperator\r\nroot\r\nstaff\r\nwebmaster');
INSERT INTO $user_prefix.`_users_config` VALUES ('codesize', '8');
INSERT INTO $user_prefix.`_users_config` VALUES ('cookiecheck', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('cookiecleaner', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('cookieinactivity', '-');
INSERT INTO $user_prefix.`_users_config` VALUES ('cookiepath', '');
INSERT INTO $user_prefix.`_users_config` VALUES ('cookietimelife', '2592000');
INSERT INTO $user_prefix.`_users_config` VALUES ('coppa', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('doublecheckemail', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('emailvalidate', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('expiring', '86400');
INSERT INTO $user_prefix.`_users_config` VALUES ('legal_did_TOS', '3');
INSERT INTO $user_prefix.`_users_config` VALUES ('nick_max', '25');
INSERT INTO $user_prefix.`_users_config` VALUES ('nick_min', '4');
INSERT INTO $user_prefix.`_users_config` VALUES ('pass_max', '20');
INSERT INTO $user_prefix.`_users_config` VALUES ('pass_min', '4');
INSERT INTO $user_prefix.`_users_config` VALUES ('perpage', '100');
INSERT INTO $user_prefix.`_users_config` VALUES ('requireadmin', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('sendaddmail', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('senddeletemail', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('servermail', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('tos', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('tosall', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('useactivate', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('useasreguser', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('usebirthdate', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('useextrainfo', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('usefakeemail', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('useforumnotifyoptions', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('usegender', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('usegfxcheck', '0');
INSERT INTO $user_prefix.`_users_config` VALUES ('usehideonline', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('useinstantmessaim', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('useinstantmessicq', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('useinstantmessmsn', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('useinstantmessyim', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('useinterests', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('uselocation', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('usenewsletter', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('useoccupation', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('usepoints', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('userealname', '3');
INSERT INTO $user_prefix.`_users_config` VALUES ('usesignature', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('useviewemail', '1');
INSERT INTO $user_prefix.`_users_config` VALUES ('usewebsite', '1');


DROP TABLE IF EXISTS $user_prefix.`_users_fields`;
CREATE TABLE IF NOT EXISTS $user_prefix.`_users_fields` (fid int(10) NOT NULL auto_increment, name varchar(255) NOT NULL default 'field', value varchar(255), size int(3), need int(1) NOT NULL default '1', pos int(3), public int(1) NOT NULL default '1', PRIMARY KEY  (fid) ) ENGINE=InnoDB AUTO_INCREMENT=1;
DROP TABLE IF EXISTS $user_prefix.`_users_fields_values`;
CREATE TABLE IF NOT EXISTS $user_prefix.`_users_field_values` (vid int(10) NOT NULL auto_increment, uid int(10) NOT NULL, fid int(10) NOT NULL, value varchar(255), PRIMARY KEY  (vid), KEY `combo_fid_uid` (`fid`,`uid`)) ENGINE=InnoDB AUTO_INCREMENT=1;
DROP TABLE IF EXISTS $user_prefix.`_users_temp_field_values`;
CREATE TABLE IF NOT EXISTS $user_prefix.`_users_temp_field_values` (vid int(10) NOT NULL auto_increment, uid int(10) NOT NULL, fid int(10) NOT NULL, value varchar(255), PRIMARY KEY (vid)) ENGINE=InnoDB AUTO_INCREMENT=1;


DROP TABLE IF EXISTS $prefix.`_nsngr_config`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsngr_config` ( `config_name` varchar(255) NOT NULL default '', `config_value` text NOT NULL, PRIMARY KEY  (`config_name`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsngr_config` VALUES ('perpage', '50');
INSERT INTO $prefix.`_nsngr_config` VALUES ('date_format', 'Y-m-d');
INSERT INTO $prefix.`_nsngr_config` VALUES ('send_notice', '1');
INSERT INTO $prefix.`_nsngr_config` VALUES ('version_number', '1.7.1');

DROP TABLE IF EXISTS $prefix.`_nsngr_groups`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsngr_groups` ( `gid` int(11) NOT NULL auto_increment, `gname` varchar(32) NOT NULL default '', `gdesc` text NOT NULL, `gpublic` tinyint(1) NOT NULL default '0', `glimit` int(11) NOT NULL default '0', `phpBB` int(11) NOT NULL default '0', `muid` int(11) NOT NULL default '0', PRIMARY KEY  (`gid`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsngr_groups` VALUES (1, 'Moderators', 'Moderators of this Forum', 0, 0, 3, 2);

DROP TABLE IF EXISTS $prefix.`_nsngr_users`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsngr_users` ( `gid` int(11) NOT NULL default '0', `uid` int(11) NOT NULL default '0', `trial` tinyint(1) NOT NULL default '0', `notice` tinyint(1) NOT NULL default '0', `sdate` int(14) NOT NULL default '0', `edate` int(14) NOT NULL default '0', PRIMARY KEY  (`gid`,`uid`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsngr_users` VALUES (1, 0, 0, 0, UNIX_TIMESTAMP(), 0);

ALTER TABLE $prefix.`_blocks` ADD `groups` TEXT NOT NULL AFTER `view`;
ALTER TABLE $prefix.`_message` ADD `groups` TEXT NOT NULL AFTER `view`;
ALTER TABLE $prefix.`_modules` ADD `groups` TEXT NOT NULL AFTER `view`;

DROP TABLE IF EXISTS $prefix.`_hnl_categories`;
CREATE TABLE IF NOT EXISTS $prefix.`_hnl_categories` ( `cid` int(11) NOT NULL auto_increment, `ctitle` varchar(50) NOT NULL default '', `cdescription` text NOT NULL, `cblocklimit` int(4) NOT NULL default '10', PRIMARY KEY  (`cid`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_hnl_categories` VALUES (1, '*Unassigned*', 'This is a catch-all category where newsletters can default to or if all other categories are removed. Do NOT remove this category! This category of newsletters are only shown to the Admins.', 5);
INSERT INTO $prefix.`_hnl_categories` VALUES (2, 'Archived Newsletters', 'This category is for newsletter subscribers.', 5);
INSERT INTO $prefix.`_hnl_categories` VALUES (3, 'Archived Mass Mails', 'This category is used for mass mails.', 5);

DROP TABLE IF EXISTS $prefix.`_hnl_cfg`;
CREATE TABLE IF NOT EXISTS $prefix.`_hnl_cfg` ( `cfg_nm` varchar(255) NOT NULL default '', `cfg_val` longtext NOT NULL, PRIMARY KEY  (`cfg_nm`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_hnl_cfg` VALUES ('debug_mode', 'ERROR');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('debug_output', 'DISPLAY');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('show_blocks', '0');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('dl_module', 'nsngd');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('blk_lmt', '10');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('scroll', '0');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('scroll_height', '180');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('scroll_amt', '2');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('scroll_delay', '100');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('version', '1.4.0');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('show_hits', '0');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('show_dates', '0');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('show_sender', '0');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('show_categories', '1');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('nsn_groups', '0');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('latest_news', '0');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('latest_downloads', '0');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('latest_links', '0');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('latest_forums', '0');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('latest_reviews', '0');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('wysiwyg_on', '1');
INSERT INTO $prefix.`_hnl_cfg` VALUES ('wysiwyg_rows', '30');

DROP TABLE IF EXISTS $prefix.`_hnl_newsletters`;
CREATE TABLE IF NOT EXISTS $prefix.`_hnl_newsletters` ( `nid` int(11) NOT NULL auto_increment, `cid` int(11) NOT NULL default '1', `topic` varchar(100) NOT NULL default '', `sender` varchar(20) NOT NULL default '', `filename` varchar(32) NOT NULL default '', `datesent` date default NULL, `view` int(1) NOT NULL default '0', `groups` text NOT NULL, `hits` int(11) NOT NULL default '0', PRIMARY KEY  (`nid`), KEY `cid` (`cid`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_hnl_newsletters` VALUES (NULL, 1, 'PREVIEW Newsletter File', 'Admin', 'tmp.php', '1000-01-01', 99, '', 0);
INSERT INTO $prefix.`_hnl_newsletters` VALUES (NULL, 1, 'Tested Email Temporary File', 'Admin', 'testemail.php', '1000-01-01', 99, '', 0);

DROP TABLE IF EXISTS $prefix.`_mail_config`;
CREATE TABLE IF NOT EXISTS $prefix.`_mail_config` ( `active` tinyint(1) NOT NULL default '0', `mailer` tinyint(1) NOT NULL default '1', `smtp_host` varchar(255) NOT NULL default '', `smtp_helo` varchar(255) NOT NULL default '', `smtp_port` int(10) NOT NULL default '25', `smtp_auth` tinyint(1) NOT NULL default '0', `smtp_uname` varchar(255) NOT NULL default '', `smtp_passw` varchar(255) NOT NULL default '', `sendmail_path` varchar(255) NOT NULL default '/usr/sbin/sendmail', `smtp_encrypt` tinyint(4) NOT NULL default '0', `smtp_encrypt_method` tinyint(4) NOT NULL default '0', `reply_to` varchar(255) NOT NULL default '', `debug_level` tinyint(4) NOT NULL default '0', PRIMARY KEY  (`mailer`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_mail_config` (`active`, `mailer`, `smtp_host`, `smtp_helo`, `smtp_port`, `smtp_auth`, `smtp_uname`, `smtp_passw`, `sendmail_path`, `smtp_encrypt`, `smtp_encrypt_method`, `reply_to`, `debug_level`) VALUES (0, 1, 'yourmaildomain.tld', 'yourmaildomain.tld', 25, 0, 'user@youmaildomain.tld', 'userpass', '/usr/sbin/sendmail', 0, 0, '', 0);

DROP TABLE IF EXISTS $prefix.`_gcal_category`;
CREATE TABLE $prefix.`_gcal_category` (`id` int(11) NOT NULL auto_increment,`name` varchar(128) NOT NULL default '',PRIMARY KEY  (`id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_gcal_category` VALUES (1, 'Unfiled');
INSERT INTO $prefix.`_gcal_category` VALUES (2, 'Show');
INSERT INTO $prefix.`_gcal_category` VALUES (3, 'Birthday');
INSERT INTO $prefix.`_gcal_category` VALUES (4, 'Release Date');
INSERT INTO $prefix.`_gcal_category` VALUES (5, 'Anniversary');
INSERT INTO $prefix.`_gcal_category` VALUES (6, 'Site Event');

DROP TABLE IF EXISTS $prefix.`_gcal_config`;
CREATE TABLE $prefix.`_gcal_config` (`id` int(11) NOT NULL auto_increment,`title` varchar(128) NOT NULL default 'Calendar of Events',`image` varchar(255) NOT NULL default '',`min_year` int(10) unsigned NOT NULL default '2006',`max_year` int(10) unsigned NOT NULL default '2037',`user_submit` enum('off','members','anyone','groups') NOT NULL default 'off',`req_approval` tinyint(1) NOT NULL default '1',`allowed_tags` text NOT NULL,`allowed_attrs` text NOT NULL,`version` varchar(16) NOT NULL default '',`time_in_24` tinyint(1) NOT NULL default '0',`short_date_format` varchar(16) NOT NULL default '',`reg_date_format` varchar(16) NOT NULL default '',`long_date_format` varchar(16) NOT NULL default '', `first_day_of_week` tinyint(1) NOT NULL default '0',`auto_link` tinyint(1) NOT NULL default '0',`location_required` tinyint(1) NOT NULL default '0',`details_required` tinyint(1) NOT NULL default '0',`email_notify` tinyint(1) NOT NULL default '0',`email_to` varchar(255) NOT NULL default '',`email_subject` varchar(255) NOT NULL default '',`email_msg` varchar(255) NOT NULL default '',`email_from` varchar(255) NOT NULL default '',`show_cat_legend` tinyint(1) NOT NULL default '1',`wysiwyg` tinyint(1) NOT NULL default '0',`user_update` tinyint(1) NOT NULL default '0',`weekends` SET( '0', '1', '2', '3', '4', '5', '6' ) NOT NULL DEFAULT '0,6',`rsvp` ENUM( 'off', 'on', 'email' ) NOT NULL DEFAULT 'off',`rsvp_email_subject` VARCHAR( 255 ) NOT NULL DEFAULT 'Event RSVP Notification', `groups_submit` TEXT NOT NULL , `groups_no_approval` TEXT NOT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_gcal_config` VALUES (1, 'Calendar of Events', 'images/admin/gcalendar.gif', 2006, 2037,'members', 1, 'a,b,i,img','href,src,border,alt,title', '1.7.0', 0, '%m/%d', '%B %d, %Y', '%A, %B %d, %Y', 0, 1, 0,0, 0, 'admin@yoursite.com', 'New GCalendar Event', 'A new GCalendar event was submitted.', 'admin@yoursite.com', 1, 1, 1, '0,6', 'off', 'Event RSVP Notification', '', '' );

DROP TABLE IF EXISTS $prefix.`_gcal_event`;
CREATE TABLE $prefix.`_gcal_event` (`id` int(11) NOT NULL auto_increment,`title` varchar(255) NOT NULL default '',`no_time` tinyint(1) NOT NULL default '1',`start_time` time NOT NULL default '00:00:00',`end_time` time NOT NULL default '00:00:00',`location` text NOT NULL,`category` int(11) NOT NULL default '0',`repeat_type` enum('none','daily','weekly','monthly','yearly') NOT NULL default 'none',`details` text NOT NULL,`interval_val` int(11) NOT NULL default '0',`no_end_date` tinyint(1) NOT NULL default '1',`start_date` date NOT NULL default '1000-01-01',`end_date` date NOT NULL default '1000-01-01',`weekly_days` set('0','1','2','3','4','5','6') NOT NULL default '',`monthly_by_day` tinyint(1) NOT NULL default '0',`submitted_by` varchar(25) NOT NULL default '',`approved` tinyint(1) NOT NULL default '0',`rsvp` ENUM( 'off', 'on', 'email' ) NOT NULL DEFAULT 'off',PRIMARY KEY  (`id`),KEY `approved` (`approved`),KEY `start_date` (`start_date`),KEY `repeat_type` (`repeat_type`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_gcal_rsvp`;
CREATE TABLE $prefix.`_gcal_rsvp` (`id` int(11) NOT NULL auto_increment,`event_id` int(11) NOT NULL,`user_id` int(11) NOT NULL,PRIMARY KEY  (`id`), KEY `event_id` (`event_id`,`user_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_gcal_exception`;
CREATE TABLE $prefix.`_gcal_exception` (`id` int(11) NOT NULL auto_increment, `event_id` int(11) NOT NULL, `date` date NOT NULL default '1000-01-01', PRIMARY KEY (`id`), KEY `event_id` (`event_id`), KEY `date` (`date`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_gcal_cat_group`;
CREATE TABLE $prefix.`_gcal_cat_group` (`id` int(11) NOT NULL auto_increment, `cat_id` int(11) NOT NULL, `group_id` int(11) NOT NULL, PRIMARY KEY (`id`), KEY `cat_id` (`cat_id`), KEY `group_id` (`group_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_gcal_cat_group` VALUES (NULL, 1, -1);
INSERT INTO $prefix.`_gcal_cat_group` VALUES (NULL, 2, -1);
INSERT INTO $prefix.`_gcal_cat_group` VALUES (NULL, 3, -1);
INSERT INTO $prefix.`_gcal_cat_group` VALUES (NULL, 4, -1);
INSERT INTO $prefix.`_gcal_cat_group` VALUES (NULL, 5, -1);
INSERT INTO $prefix.`_gcal_cat_group` VALUES (NULL, 6, -1);

DROP TABLE IF EXISTS $prefix.`_seo_config`;
CREATE TABLE $prefix.`_seo_config` (`config_type` varchar(150) NOT NULL, `config_name` varchar(150) NOT NULL, `config_value` text NOT NULL, PRIMARY KEY  (`config_type`,`config_name`) ) ENGINE=InnoDB;
INSERT INTO $prefix.`_seo_config` VALUES ('Feeds', 'use_fb', '1');
INSERT INTO $prefix.`_seo_config` VALUES ('Feeds', 'feedburner_url', 'http://feeds.feedburner.com');
INSERT INTO $prefix.`_seo_config` VALUES ('Feeds', 'version_check', '0');
INSERT INTO $prefix.`_seo_config` VALUES ('Feeds', 'version_newest', '1.1.1');
INSERT INTO $prefix.`_seo_config` VALUES ('Feeds', 'version_number', '1.1.1');
INSERT INTO $prefix.`_seo_config` VALUES ('Feeds', 'version_url', 'http://nukeseo.com/modules.php?name=Downloads');
INSERT INTO $prefix.`_seo_config` VALUES ('Feeds', 'version_notes', '');
INSERT INTO $prefix.`_seo_config` VALUES ('Feeds', 'show_circgraph', '1');
INSERT INTO $prefix.`_seo_config` VALUES ('Feeds', 'show_feedcount', '1');
INSERT INTO $prefix.`_seo_config` VALUES ('Feeds', 'feedcount_body', 'A6A6A6');
INSERT INTO $prefix.`_seo_config` VALUES ('Feeds', 'feedcount_text', '000000');

DROP TABLE IF EXISTS $prefix.`_seo_disabled_modules`;
CREATE TABLE $prefix.`_seo_disabled_modules` (`title` varchar(100) NOT NULL, `seo_module` varchar(100) NOT NULL, PRIMARY KEY  (`title`,`seo_module`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_seo_feed`;
CREATE TABLE $prefix.`_seo_feed` (`fid` int(6) NOT NULL auto_increment, `content` varchar(20) NOT NULL, `name` varchar(20) NOT NULL, `level` varchar(20) NOT NULL, `lid` int(6) NOT NULL, `title` varchar(50) NOT NULL, `desc` text NOT NULL, `order` varchar(20) NOT NULL, `howmany` char(3) NOT NULL, `active` int(1) NOT NULL, `desclimit` varchar(5) NOT NULL, `securitycode` varchar(50) NOT NULL, `cachetime` varchar(6) NOT NULL, `feedburner_address` varchar(100) NOT NULL, PRIMARY KEY  (`fid`), KEY `content` (`content`,`title`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_seo_feed` VALUES (1, 'News', 'News', 'module', 0, 'News', '', 'recent', '10', 1, '', '', '', '');
INSERT INTO $prefix.`_seo_feed` VALUES (2, 'Forums', 'Forums', 'module', 0, 'Forums', '', 'recent', '10', 1, '', '', '', '');

DROP TABLE IF EXISTS $prefix.`_seo_subscriptions`;
CREATE TABLE $prefix.`_seo_subscriptions` ( `sid` int(6) NOT NULL auto_increment, `type` varchar(255) NOT NULL, `name` varchar(60) NOT NULL, `tagline` varchar(60) NOT NULL, `image` varchar(255) NOT NULL, `icon` varchar(255) NOT NULL, `url` varchar(255) NOT NULL, `active` int(1) NOT NULL, PRIMARY KEY  (`sid`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_seo_subscriptions` VALUES (1, 'aggregator', '01 Google Reader', 'Add to Google', 'images/nukeFEED/subscribe/add-to-google-plus.gif', '', 'http://fusion.google.com/add?feedurl={URL}', 1);
INSERT INTO $prefix.`_seo_subscriptions` VALUES (2, 'aggregator', '02 My Yahoo!', 'Add to My Yahoo!', 'images/nukeFEED/subscribe/myYahoo.gif', '', 'http://add.my.yahoo.com/rss?url={URL}', 1);
INSERT INTO $prefix.`_seo_subscriptions` VALUES (3, 'aggregator', '03 My AOL', 'Add to My AOL', 'images/nukeFEED/subscribe/myAOL.gif', '', 'http://feeds.my.aol.com/add.jsp?url={URL}', 1);
INSERT INTO $prefix.`_seo_subscriptions` VALUES (4, 'aggregator', '04 My MSN', 'Add to My MSN', 'images/nukeFEED/subscribe/myMSN.gif', '', 'http://my.msn.com/addtomymsn.armx?id=rss&ut={URL}&ru={NUKEURL}', 1);
INSERT INTO $prefix.`_seo_subscriptions` VALUES (5, 'aggregator', '05 BlogLines', 'Subscribe with Bloglines', 'images/nukeFEED/subscribe/bloglines.gif', '', 'http://www.bloglines.com/sub/{URL}', 1);
INSERT INTO $prefix.`_seo_subscriptions` VALUES (6, 'aggregator', '06 netvibes', 'Add to netvibes', 'images/nukeFEED/subscribe/netvibes.gif', '', 'http://www.netvibes.com/subscribe.php?url={URL}', 1);
INSERT INTO $prefix.`_seo_subscriptions` VALUES (7, 'aggregator', '07 NewsGator', 'Subscribe in NewsGator Online', 'images/nukeFEED/subscribe/newsgator.gif', '', 'http://www.newsgator.com/ngs/subscriber/subext.aspx?url={URL}', 1);
INSERT INTO $prefix.`_seo_subscriptions` VALUES (8, 'aggregator', '08 Pageflakes', 'Subscribe with PageFlakes', 'images/nukeFEED/subscribe/pageflakes.gif', '', 'http://www.pageflakes.com/subscribe.aspx?url={URL}', 1);
INSERT INTO $prefix.`_seo_subscriptions` VALUES (9, 'aggregator', '09 Rojo', 'Subscribe in Rojo', 'images/nukeFEED/subscribe/addtorojo.gif', '', 'http://www.rojo.com/add-subscription?resource={URL}', 1);
INSERT INTO $prefix.`_seo_subscriptions` VALUES (10, 'aggregator', '10 Protopage', 'Add this site to your Protopage', 'images/nukeFEED/subscribe/protopage.gif', '', 'http://www.protopage.com/add-button-site?url={URL}&label={TITLE}&type=feed', 1);
INSERT INTO $prefix.`_seo_subscriptions` VALUES (11, 'aggregator', '11 Newsburst', 'Add to Newsburst', 'images/nukeFEED/subscribe/newsburst.gif', '', 'http://www.newsburst.com/Source/?add={URL}', 1);
INSERT INTO $prefix.`_seo_subscriptions` VALUES (12, 'aggregator', '12 NewsAlloy', 'Subscribe in NewsAlloy', 'images/nukeFEED/subscribe/newsalloy.gif', '', 'http://www.newsalloy.com/?rss={URL}', 1);
INSERT INTO $prefix.`_seo_subscriptions` VALUES (13, 'aggregator', '13 Blogarithm', 'Add to Blogarithm', 'images/nukeFEED/subscribe/blogarithm.gif', '', 'http://www.blogarithm.com/subrequest.php?BlogURL={URL}', 1);

DROP TABLE IF EXISTS $prefix.`_legal_cfg`;
CREATE TABLE $prefix.`_legal_cfg` (`contact_email` varchar(255) NOT NULL default 'legal@MySite.com', `contact_subject` varchar(255) NOT NULL default 'Legal Notice Inquiry', `country` varchar(255) NOT NULL default 'United States of America') ENGINE=InnoDB;
INSERT INTO $prefix.`_legal_cfg` VALUES('legal@MySite.com', 'Legal Notice Inquiry', 'United States of America');

DROP TABLE IF EXISTS $prefix.`_legal_docs`;
CREATE TABLE $prefix.`_legal_docs` (`did` int(11) NOT NULL auto_increment, `doc_name` varchar(32) NOT NULL, `doc_status` tinyint(4) NOT NULL default '0', PRIMARY KEY (`did`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_legal_docs` VALUES(1, 'notice', 1);
INSERT INTO $prefix.`_legal_docs` VALUES(2, 'privacy', 1);
INSERT INTO $prefix.`_legal_docs` VALUES(3, 'terms', 1);

DROP TABLE IF EXISTS $prefix.`_legal_text`;
CREATE TABLE $prefix.`_legal_text` (`tid` int(11) NOT NULL auto_increment, `doc_text` text NOT NULL, PRIMARY KEY (`tid`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_legal_text` VALUES(1, '<p>[sitename] authorizes you to view, download, and interact with materials, services, and forums on this website. Unless otherwise specified, the services and downloads provided by [sitename] are for your personal and or commercial use, provided that you retain all copyright and other proprietary notices contained in the original materials.</p>\r\n<p>The materials at [sitename] are copyrighted and any unauthorized use of these materials may violate copyrights and or trademarks of [country], headquarters of the owner of [sitename].</p>\r\n<p>These legal notices are for our protection and yours as well. Please read them carefully.</p>\r\n<p align="right">[date]</p>');
INSERT INTO $prefix.`_legal_text` VALUES(2, 'Legal Notice');
INSERT INTO $prefix.`_legal_text` VALUES(3, '<p style="TEXT-ALIGN: left" align="left"><span style="FONT-WEIGHT: bold">Introduction<br />\r\n<br />\r\n</span>The site editor takes your right to privacy seriously, and wants you to feel comfortable using [sitename]. This privacy policy deals with personally-identifiable information (referred to as &quot;data&quot; below) that may be collected by this site. This policy does not apply to other entities that are not owned or controlled by the site editor, nor to persons that are not employees or agents of the site editor, or that are not under the site editor''s control. Please take time to read this site''s <a href="modules.php?name=Legal&amp;op=terms">terms of use</a>.<br />\r\n<br />\r\n</p>\r\n<div align="left"></div>\r\n<div align="left"></div>\r\n<p style="TEXT-ALIGN: left" align="left"><span style="FONT-WEIGHT: bold">1. Collection of data<br />\r\n<br />\r\n</span>Registration of a user account on this site requires only a valid e-mail address and a user name that has not been used already. You are not required to provide any other information if do not want to. Please be aware that the user name you choose, the e-mail address you provide and other information you provide may render you personally identifiable, and may possibly be displayed on [sitename] intentionally (depending on choices you make during the registration process, or on the way in which the site is configured) or unintentionally (such as, but not limited to, subsequent to a successful act of intrusion by a third party). As on many web sites, the site editor may also automatically receive general information that is contained in server log files, such as your IP address, and cookie information. Information about how advertising may be served on this site (if it is the site editor''s policy to display advertising) is set forth below.<br />\r\n<br />\r\n</p>\r\n<div align="left"></div>\r\n<p style="TEXT-ALIGN: left" align="left"><span style="FONT-WEIGHT: bold">2. Use of data<br />\r\n<br />\r\n</span>Data may be used to customize and improve your user experience on this site. Efforts will be made to prevent your data being made available to third parties unless (ID 1033 0 1) provided for otherwise in this Privacy Policy; (ii) your consent is obtained, such as when you choose to opt-in or opt-out for the sharing of data; (iii) a service provided on our site requires interaction a third party with or is provided by a third party, such as an application service provider; (iv) pursuant to legal action or law enforcement; (v) it is found that your use of this site violates this policy, terms of service, or other usage guidelines, or if it is deemed reasonably necessary by the site editor to protect the site editor''s legal rights and or property; or (vi) this site is purchased by a third party, in which case that third party will be able to use the data in the same manner as set forth in this Policy. In the event you choose to use links that appear on [sitename] to visit other web sites, you are advised to read the privacy policies that appear on those sites.<br />\r\n<br />\r\n</p>\r\n<div align="left"></div>\r\n<p style="TEXT-ALIGN: left" align="left"><span style="FONT-WEIGHT: bold">3. Cookies<br />\r\n<br />\r\n</span>Like many web sites, [sitename] sets and uses cookies to enhance your user experience, such as retaining your personal settings. Advertisements may appear on [sitename] and, if so, may set and access cookies on your computer; such cookies are subject to the privacy policy of the parties providing the advertisement. However, the parties serving the advertising do not have access to this site''s cookies. These parties usually use non-personally-identifiable or anonymous codes to obtain information about your visits to this site. You can visit the <a href="http://www.networkadvertising.org/optout_nonppii.asp">Network Advertising Initiative</a> if you want to find out more information about this practice, and to learn about your options, including your options with regard to the following companies that may serve advertising on this site:<br />\r\n<br />\r\n[<a href="http://www.associateprograms.com/"> AssociatePrograms.com</a> ] [<a title="AdBrite" target="_blank" href="http://www.adbrite.com"> AdBrite</a> ] [ <a href="http://www.cj.com/">Commission Junction</a> ] [ <a href="http://www.doubleclick.net/">DoubleClick</a> ] [ <a href="http://www.linkshare.com/">Linkshare</a> ]<br />\r\n<br />\r\n</p>\r\n<div align="left"></div>\r\n<p style="TEXT-ALIGN: left" align="left"><span style="FONT-WEIGHT: bold">4. Minors<br />\r\n<br />\r\n</span>People aged thirteen or younger are not allowed to become registered users of this site. For more information, please contact <a href="modules.php?name=Legal&amp;op=contact">the webmaster</a>.<br />\r\n<br />\r\n</p>\r\n<div align="left"></div>\r\n<p style="TEXT-ALIGN: left" align="left"><span style="FONT-WEIGHT: bold">5. Editing or deleting your account information<br />\r\n<br />\r\n</span>This site provides you with the ability to edit the information in your user account that you provided to during the registration process, by visiting <a href="modules.php?name=Your_Account">your personal home page configuration page</a>. You may request deletion of your user account by contacting <a href="modules.php?name=Legal&amp;op=contact">the webmaster</a>. Content or other information that you may have provided, and that is not contained within your user account, such as posts that may appear within site forums, may continue to remain on the site at the site editor''s discretion, even though your user account is deleted. Please see the site''s <a href="modules.php?name=Legal&amp;op=terms">Terms of Use</a> for more information.<br />\r\n<br />\r\n</p>\r\n<div align="left"></div>\r\n<p style="TEXT-ALIGN: left" align="left"><span style="FONT-WEIGHT: bold">6. Changes to this privacy policy<br />\r\n<br />\r\n</span>Changes may be made to this policy from time to time. You will be notified of substantial changes to this policy either by through the posting of a prominent announcement on the site, and or by a message being sent to the e-mail address you have provided, which is contained in your user settings.<br />\r\n<br />\r\n</p>\r\n<div align="left"></div>\r\n<p style="TEXT-ALIGN: left" align="left"><span style="FONT-WEIGHT: bold">7. NO GUARANTEES<br />\r\n<br />\r\n</span>While this privacy policy states standards for maintenance of data, and while efforts will be made to meet the said standards, the site editor is not in a position to guarantee compliance with these standards. There may be factors beyond the site editor''s control that may result in disclosure of data. Consequently, the site editor offers no warranties or representations as regards maintenance or nondisclosure of data.<br />\r\n<br />\r\n</p>\r\n<div align="left"></div>\r\n<p style="TEXT-ALIGN: left" align="left"><span style="FONT-WEIGHT: bold">8. Contact information<br />\r\n<br />\r\n</span>If you have any questions about this policy or [sitename], please feel free to contact <a href="modules.php?name=Legal&amp;op=contact">the webmaster</a>.</p>\r\n<p align="right">[date]</p>');
INSERT INTO $prefix.`_legal_text` VALUES(4, 'Privacy Policy');
INSERT INTO $prefix.`_legal_text` VALUES(5, '<p style="text-align: left;"><span style="font-weight: bold;">1. Acceptance of terms of use and amendments<br />\r\n<br />\r\n</span>Each time you use or cause access to [sitename], you agree to be bound by these <a href="modules.php?name=Legal&amp;op=terms">terms of use</a>, as amended from time to time with or without notice to you. In addition, if you are using a particular service hosted on or accessed via [sitename], you will be subject to any rules or guidelines applicable to the said services, and they will be incorporated by reference within these <a href="modules.php?name=Legal&amp;op=terms">terms of use</a>. Please refer to this site''s <a href="modules.php?name=Legal&amp;op=privacy">privacy policy</a>, which is incorporated within these <a href="modules.php?name=Legal&amp;op=terms">terms of use</a> by reference.</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">2. The site editor''s service<br />\r\n<br />\r\n</span>This web site and services provided to you on and through [sitename] are provided on an &quot;AS IS&quot; basis.You agree that the site editor exclusively reserves the right to modify or discontinue provision of [sitename] and its services, and to delete the data you provide, either temporarily or permanently; the site and may, at any time and without notice and any liability to you, The site editor shall have no responsibility or liability for the timeliness, deletion, failure to store, inaccuracy, or improper delivery of any data or information.</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">3. Your responsibilities and registration obligations<br />\r\n<br />\r\n</span>In order to use [sitename] or certain parts of it, you may be required to <a href="modules.php?name=Your_Account&amp;op=new_user">register a user account</a> on this web site; in this case, you agree to provide truthful information when requested, and undertake that you are aged at least the thirteen (13) or more.&nbsp;&nbsp; In addition, you are required to register a unique user account to you and that is not shared.&nbsp; <span style="color:#ff0000;">Sharing of user accounts is expressly prohibited</span>.<br />\r\n</p>\r\n<p style="text-align: left;">By registering, you explicitly agree to this site''s <a href="modules.php?name=Legal&amp;op=terms">terms of use</a>, including any amendments made by the site editor from time to time and available here.</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">4. Privacy policy</span>.<br />\r\n</p>\r\n<p style="text-align: left;">Registration data and other personally-identifiable information that may be collected on this site is subject to the terms of the site''s <a href="modules.php?name=Legal&amp;op=privacy">privacy policy</a>.</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">5. Registration and password<br />\r\n<br />\r\n</span>You are responsible for maintaining the confidentiality of your password, and shall be responsible for all usage of your user account and or user name, whether authorized or unauthorized by you. You agree to immediately notify the site editor of any unauthorized use or your user account, user name or password.</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">6. Your conduct.<br />\r\n<br />\r\n</span>You agree that all information or data of any kind, whether text, software, code, music or sound, photographs or graphics, video or other materials (&quot;content&quot;), made available publicly or privately, shall be under the sole responsibility of the person providing the content or the person whose user account is used. You agree that [sitename] may expose you to content that may be objectionable or offensive. The site editor shall not be responsible to you in any way for the content that appears on [sitename], nor for any error or omission.</p>\r\n<p style="text-align: left;">By using [sitename] or any service provided, you explicitly agree that you shall not:<br />\r\n(a) provide any content or conduct yourself in any way that may be construed as: unlawful; illegal; threatening; harmful; abusive; harassing; stalking; tortuous; defamatory; libelous; vulgar; obscene; offensive; objectionable; pornographic; designed to interfere or interrupt [sitename] or any service provided, infected with a virus or other destructive or deleterious programming routine; giving rise to civil or criminal liability; or in violation of [country], applicable local, national or international law;<br />\r\n(b) impersonate or misrepresent your association with any person or entity; forge or otherwise seek to conceal or misrepresent the origin of any content provided by you;<br />\r\n(c) collect or harvest any data about other users;<br />\r\n(d) provide or use [sitename] for the provision of any content or service in any commercial manner, or in any manner that would involve junk mail, spam, chain letters, pyramid schemes, or any other form of unauthorized advertising, without the site editor''s prior written consent; <br />\r\n(e) provide any content that may give rise to civil or criminal liability of the site editor, or that may constitute or be considered a violation of [country], any local, national or international law, including -- but not limited to -- laws relating to copyright, trademark, patent, or trade secrets.</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">7. Submission of content on [sitename]<br />\r\n<br />\r\n</span>By providing any content to [sitename]:<br />\r\n(a) you agree to grant the site editor a worldwide, royalty-free, perpetual, non-exclusive right and license (including any moral rights or other necessary rights.) to use, display, reproduce, modify, adapt, publish, distribute, perform, promote, archive, translate, and to create derivative works and compilations, in whole or in part. Such license will apply with respect to any form, media, technology already known or developed subsequently;<br />\r\n(b) you warrant and represent that you have all legal, moral, and other rights that may be necessary to grant us the license specified in this section 7;<br />\r\n(c) you acknowledge and agree that the site editor shall have the right (but not obligation), at the site editor''s entire discretion, to refuse to publish, or to remove, or to block access to any content you provide, at any time and for any reason, with or without notice.</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">8. Third-party services<br />\r\n<br />\r\n</span>Goods and services of third parties may be advertised and or made available on or through [sitename]. Representations made regarding products and services provided by third parties are governed by the policies and representations made by these third parties. The site editor shall not be liable for or responsible in any manner for any of your dealings or interaction with third parties.</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">9. Indemnification<br />\r\n<br />\r\n</span>You agree to indemnify and hold harmless the site editor and the site editor''s subsidiaries, affiliates, related parties, officers, directors, employees, agents, independent contractors, advertisers, partners, and co-branders, from any claim or demand, including reasonable attorney''s fees, that may be made by any third party, due to or arising out of your conduct or connection with [sitename] or service, your provision of content, your violation of these <a href="modules.php?name=Legal&amp;op=terms">terms of use</a>, or any other violation of the rights of another person or party.</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">10. DISCLAIMER OF WARRANTIES<br />\r\n<br />\r\n</span>YOU UNDERSTAND AND AGREE THAT YOUR USE OF THIS WEB SITE AND ANY SERVICES OR CONTENT PROVIDED (THE &quot;SERVICE&quot;) IS MADE AVAILABLE AND PROVIDED TO YOU AT YOUR OWN RISK. IT IS PROVIDED TO YOU &quot;AS IS&quot; AND THE SITE EDITOR EXPRESSLY DISCLAIMS ALL WARRANTIES OF ANY KIND, EITHER IMPLIED OR EXPRESS, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NON-INFRINGEMENT.&nbsp;</p>\r\n<p style="text-align: left;">THE SITE EDITOR MAKES NO WARRANTY, IMPLIED OR EXPRESS, THAT ANY PART OF THE SERVICE WILL BE UNINTERRUPTED, ERROR-FREE, VIRUS-FREE, TIMELY, SECURE, ACCURATE, RELIABLE, OR OF ANY QUALITY, NOR IS IT WARRANTED EITHER IMPLICITLY OR EXPRESSLY THAT ANY CONTENT IS SAFE IN ANY MANNER FOR DOWNLOAD. YOU UNDERSTAND AND AGREE THAT NEITHER THE SITE EDITOR NOR ANY PARTICIPANT IN THE SERVICE PROVIDES PROFESSIONAL ADVICE OF ANY KIND AND THAT USE OF ANY ADVICE OR ANY OTHER INFORMATION OBTAINED VIA THIS WEB SITE IS SOLELY AT YOUR OWN RISK, AND THAT THE SITE EDITOR MAY NOT BE HELD LIABLE IN ANY WAY. <br />\r\n</p>\r\n<p style="text-align: left;">Some jurisdictions may not allow disclaimers of implied warranties, and certain statements in the above disclaimer may not apply to you as regards implied warranties; the other terms and conditions remain enforceable notwithstanding.</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">11. LIMITATION OF LIABILITY<br />\r\n<br />\r\n</span>YOU EXPRESSLY UNDERSTAND AND AGREE THAT THE SITE EDTIOR SHALL NOT BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL, INDICENTAL, CONSEQUENTIAL OR EXEMPLARY DAMAGES; THIS INCLUDES, BUT IS NOT LIMITED TO, DAMAGES FOR LOSS OF PROFITS, GOODWILL, USE, DATA OR OTHER INTANGIBLE LOSS (EVEN IF THE SITE EDITOR HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES), RESULTING FROM OR ARISING OUT OF (I) THE USE OF OR THE INABILITY TO USE THE SERVICE, (II) THE COST OF OBTAINING SUBSTITUTE GOODS AND OR SERVICES RESULTING FROM ANY TRANSACTION ENTERED INTO ON THROUGH THE SERVICE, (III) UNAUTHORIZED ACCESS TO OR ALTERATION OF YOUR DATA TRANSMISSIONS, (IV) STATEMENTS BY ANY THIRD PARTY OR CONDUCT OF ANY THIRD PARTY USING THE SERVICE, OR (V) ANY OTHER MATTER RELATING TO THE SERVICE.</p>\r\n<p style="text-align: left;">In some jurisdictions, it is not permitted to limit liability and, therefore, such limitations may not apply to you.</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">12. Reservation of rights<br />\r\n<br />\r\n</span>The site editor reserves all of the site editor''s rights, including but not limited to any and all copyrights, trademarks, patents, trade secrets, and any other proprietary right that the site editor may have for [sitename], its content, and the goods and services that may be provided. The use of the site editor''s rights. and property requires the site editor''s prior written consent. By making services available to you, the site editor is not providing you with any implied or express licenses or rights, and you will have no rights. to make any commercial uses of [sitename] or service without the site editor''s prior written consent.</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">13. Notification of copyright infringement<br />\r\n<br />\r\n</span>If you believe that your property has been used in any way that would be considered a copyright infringement or a violation of your intellectual property rights, the site editor''s copyright agent may be contacted at the following address:<br />\r\n<br />\r\n<a href="modules.php?name=Legal&amp;op=contact">Click here to contact the webmaster</a><br />\r\n<br />\r\n<span style="font-weight: bold;">14. Applicable law<br />\r\n<br />\r\n</span>You agree that these <a href="modules.php?name=Legal&amp;op=terms">terms of use</a> and any dispute arising out of your use of [sitename] or the site editor''s products or services shall be governed by and construed in accordance with local laws in force of [country], headquarters of the owner of [sitename], without regard to its conflict of law provisions. By registering or using this web site and service, you consent and submit to the exclusive jurisdiction and venue of [country], headquarters of the owner of [sitename].&nbsp;</p>\r\n<p style="text-align: left;"><span style="font-weight: bold;">15. Miscellaneous information<br />\r\n<br />\r\n</span>(ID 1033 0 1) In the event that these <a href="modules.php?name=Legal&amp;op=terms">terms of use</a> conflict with any law under which any provision may be held invalid by a court with jurisdiction over the parties, such provision will be interpreted to reflect the original intentions of the parties in accordance with applicable law, and the remainder of these <a href="modules.php?name=Legal&amp;op=terms">terms of use</a> will remain valid and intact; (ii) The failure of either party to assert any right under these <a href="modules.php?name=Legal&amp;op=terms">terms of use</a> shall not be considered a waiver of that party''s right, and that right will remain in full force and effect; (iii) You agree that, without regard to any statute or contrary law, that any claim or cause arising out of [sitename] or its services must be filed within one (1) year after such claim or cause arose, or else the claim shall be forever barred; (iv) The site editor may assign the site editor''s rights and obligations under these <a href="modules.php?name=Legal&amp;op=terms">terms of use</a>; in this case, the site editor shall be relieved of any further obligation.</p>\r\n<p align="right">[country], [date]</p>');
INSERT INTO $prefix.`_legal_text` VALUES(6, 'Terms of Use');

DROP TABLE IF EXISTS $prefix.`_legal_text_map`;
CREATE TABLE $prefix.`_legal_text_map` (`mid` mediumint(9) NOT NULL, `did` int(11) NOT NULL, `tid` int(11) NOT NULL, `language` varchar(32) NOT NULL default 'english', UNIQUE KEY `mid` (`mid`,`did`,`tid`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_legal_text_map` VALUES(1, 1, 1, 'english');
INSERT INTO $prefix.`_legal_text_map` VALUES(2, 1, 2, 'english');
INSERT INTO $prefix.`_legal_text_map` VALUES(1, 2, 3, 'english');
INSERT INTO $prefix.`_legal_text_map` VALUES(2, 2, 4, 'english');
INSERT INTO $prefix.`_legal_text_map` VALUES(1, 3, 5, 'english');
INSERT INTO $prefix.`_legal_text_map` VALUES(2, 3, 6, 'english');

DROP TABLE IF EXISTS $prefix.`_bbattachments_config`;
CREATE TABLE $prefix.`_bbattachments_config` ( `config_name` varchar(255) NOT NULL,  `config_value` varchar(255) NOT NULL,  PRIMARY KEY (`config_name`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('upload_dir','modules/Forums/files');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('upload_img','modules/Forums/images/icon_clip.gif');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('topic_icon','modules/Forums/images/icon_clip.gif');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('display_order','0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('max_filesize','262144');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('attachment_quota','52428800');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('max_filesize_pm','262144');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('max_attachments','3');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('max_attachments_pm','1');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('disable_mod','0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('allow_pm_attach','1');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('attachment_topic_review','0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('allow_ftp_upload','0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('show_apcp','0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('attach_version','2.4.5');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('default_upload_quota', '0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('default_pm_quota', '0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('ftp_server','');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('ftp_path','');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('download_path','');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('ftp_user','');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('ftp_pass','');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('ftp_pasv_mode','1');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('img_display_inlined','1');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('img_max_width','0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('img_max_height','0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('img_link_width','0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('img_link_height','0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('img_create_thumbnail','0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('img_min_thumb_filesize','12000');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('img_imagick', '');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('use_gd2','0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('wma_autoplay','0');
INSERT INTO $prefix.`_bbattachments_config` (`config_name`, `config_value`) VALUES ('flash_autoplay','0');

DROP TABLE IF EXISTS $prefix.`_bbforbidden_extensions`;
CREATE TABLE $prefix.`_bbforbidden_extensions` ( `ext_id` mediumint(8) UNSIGNED NOT NULL auto_increment,   extension varchar(100) NOT NULL,   PRIMARY KEY (`ext_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_bbforbidden_extensions` (`ext_id`, `extension`) VALUES (1,'php');
INSERT INTO $prefix.`_bbforbidden_extensions` (`ext_id`, `extension`) VALUES (2,'php3');
INSERT INTO $prefix.`_bbforbidden_extensions` (`ext_id`, `extension`) VALUES (3,'php4');
INSERT INTO $prefix.`_bbforbidden_extensions` (`ext_id`, `extension`) VALUES (4,'phtml');
INSERT INTO $prefix.`_bbforbidden_extensions` (`ext_id`, `extension`) VALUES (5,'pl');
INSERT INTO $prefix.`_bbforbidden_extensions` (`ext_id`, `extension`) VALUES (6,'asp');
INSERT INTO $prefix.`_bbforbidden_extensions` (`ext_id`, `extension`) VALUES (7,'cgi');
INSERT INTO $prefix.`_bbforbidden_extensions` (`ext_id`, `extension`) VALUES (8,'php5');
INSERT INTO $prefix.`_bbforbidden_extensions` (`ext_id`, `extension`) VALUES (9,'php6');

DROP TABLE IF EXISTS $prefix.`_bbextension_groups`;
CREATE TABLE $prefix.`_bbextension_groups` ( `group_id` mediumint(8) NOT NULL auto_increment,  `group_name` char(20) NOT NULL,  `cat_id` tinyint(2) DEFAULT '0' NOT NULL,   `allow_group` tinyint(1) DEFAULT '0' NOT NULL,  `download_mode` tinyint(1) UNSIGNED DEFAULT '1' NOT NULL,  `upload_icon` varchar(100) DEFAULT '',  `max_filesize` int(20) DEFAULT '0' NOT NULL,  `forum_permissions` varchar(255) default '' NOT NULL,  PRIMARY KEY `group_id` (`group_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_bbextension_groups` (`group_id`, `group_name`, `cat_id`, `allow_group`, `download_mode`, `upload_icon`, `max_filesize`, `forum_permissions`) VALUES (1,'Images',1,1,1,'',0,'');
INSERT INTO $prefix.`_bbextension_groups` (`group_id`, `group_name`, `cat_id`, `allow_group`, `download_mode`, `upload_icon`, `max_filesize`, `forum_permissions`) VALUES (2,'Archives',0,1,1,'',0,'');
INSERT INTO $prefix.`_bbextension_groups` (`group_id`, `group_name`, `cat_id`, `allow_group`, `download_mode`, `upload_icon`, `max_filesize`, `forum_permissions`) VALUES (3,'Plain Text',0,0,1,'',0,'');
INSERT INTO $prefix.`_bbextension_groups` (`group_id`, `group_name`, `cat_id`, `allow_group`, `download_mode`, `upload_icon`, `max_filesize`, `forum_permissions`) VALUES (4,'Documents',0,0,1,'',0,'');
INSERT INTO $prefix.`_bbextension_groups` (`group_id`, `group_name`, `cat_id`, `allow_group`, `download_mode`, `upload_icon`, `max_filesize`, `forum_permissions`) VALUES (5,'Real Media',0,0,2,'',0,'');
INSERT INTO $prefix.`_bbextension_groups` (`group_id`, `group_name`, `cat_id`, `allow_group`, `download_mode`, `upload_icon`, `max_filesize`, `forum_permissions`) VALUES (6,'Streams',2,0,1,'',0,'');
INSERT INTO $prefix.`_bbextension_groups` (`group_id`, `group_name`, `cat_id`, `allow_group`, `download_mode`, `upload_icon`, `max_filesize`, `forum_permissions`) VALUES (7,'Flash Files',3,0,1,'',0,'');

DROP TABLE IF EXISTS $prefix.`_bbextensions`;
CREATE TABLE $prefix.`_bbextensions` ( `ext_id` mediumint(8) UNSIGNED NOT NULL auto_increment,  `group_id` mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,  `extension` varchar(100) NOT NULL,  `comment` varchar(100),  PRIMARY KEY `ext_id` (`ext_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (1, 1,'gif', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (2, 1,'png', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (3, 1,'jpeg', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (4, 1,'jpg', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (5, 1,'tif', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (6, 1,'tga', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (7, 2,'gtar', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (8, 2,'gz', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (9, 2,'tar', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (10, 2,'zip', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (11, 2,'rar', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (12, 2,'ace', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (13, 3,'txt', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (14, 3,'c', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (15, 3,'h', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (16, 3,'cpp', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (17, 3,'hpp', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (18, 3,'diz', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (19, 4,'xls', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (20, 4,'doc', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (21, 4,'dot', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (22, 4,'pdf', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (23, 4,'ai', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (24, 4,'ps', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (25, 4,'ppt', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (26, 5,'rm', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (27, 6,'wma', '');
INSERT INTO $prefix.`_bbextensions` (`ext_id`, `group_id`, `extension`, `comment`) VALUES (28, 7,'swf', '');

DROP TABLE IF EXISTS $prefix.`_bbattachments_desc`;
CREATE TABLE $prefix.`_bbattachments_desc` ( `attach_id` mediumint(8) UNSIGNED NOT NULL auto_increment,  `physical_filename` varchar(255) NOT NULL,  `real_filename` varchar(255) NOT NULL,  `download_count` mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,  `comment` varchar(255),  `extension` varchar(100),  `mimetype` varchar(100),  `filesize` int(20) NOT NULL,  `filetime` int(11) DEFAULT '0' NOT NULL,  `thumbnail` tinyint(1) DEFAULT '0' NOT NULL,  PRIMARY KEY (`attach_id`),  KEY `filetime` (`filetime`),  KEY `physical_filename` (`physical_filename`(10)),  KEY `filesize` (`filesize`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbattachments`;
CREATE TABLE $prefix.`_bbattachments` ( `attach_id` mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,   `post_id` mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,   `privmsgs_id` mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,  `user_id_1` mediumint(8) NOT NULL,  `user_id_2` mediumint(8) NOT NULL,  KEY `attach_id_post_id` (`attach_id`, `post_id`),  KEY `attach_id_privmsgs_id` (`attach_id`, `privmsgs_id`),  KEY `post_id` (`post_id`),  KEY `privmsgs_id` (`privmsgs_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_bbquota_limits`;
CREATE TABLE $prefix.`_bbquota_limits` ( `quota_limit_id` mediumint(8) unsigned NOT NULL auto_increment,  `quota_desc` varchar(20) NOT NULL default '',  `quota_limit` bigint(20) unsigned NOT NULL default '0',  PRIMARY KEY  (`quota_limit_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_bbquota_limits` (`quota_limit_id`, `quota_desc`, `quota_limit`) VALUES (1, 'Low', 262144);
INSERT INTO $prefix.`_bbquota_limits` (`quota_limit_id`, `quota_desc`, `quota_limit`) VALUES (2, 'Medium', 2097152);
INSERT INTO $prefix.`_bbquota_limits` (`quota_limit_id`, `quota_desc`, `quota_limit`) VALUES (3, 'High', 5242880);

DROP TABLE IF EXISTS $prefix.`_bbattach_quota`;
CREATE TABLE $prefix.`_bbattach_quota` (  `user_id` mediumint(8) unsigned NOT NULL default '0',  `group_id` mediumint(8) unsigned NOT NULL default '0',  `quota_type` smallint(2) NOT NULL default '0',  `quota_limit_id` mediumint(8) unsigned NOT NULL default '0',  KEY `quota_type` (`quota_type`)) ENGINE=InnoDB;

ALTER TABLE $prefix.`_bbforums` ADD `auth_download` TINYINT(2) DEFAULT '0' NOT NULL;
ALTER TABLE $prefix.`_bbforums` ADD `attached_forum_id` mediumint(8) NOT NULL DEFAULT '-1'
ALTER TABLE $prefix.`_bbauth_access` ADD `auth_download` TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE $prefix.`_bbposts` ADD `post_attachment` TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE $prefix.`_bbtopics` ADD `topic_attachment` TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE $prefix.`_bbprivmsgs` ADD `privmsgs_attachment` TINYINT(1) DEFAULT '0' NOT NULL;

DROP TABLE IF EXISTS $prefix.`_nsnpj_config`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_config` (`config_name` varchar(255) NOT NULL default '', `config_value` text NOT NULL) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnpj_config` (`config_name`, `config_value`) VALUES ('admin_report_email', 'webmaster@mysite.com'),('admin_request_email', 'webmaster@mysite.com'),('new_project_position', '1'),('new_project_priority', '3'),('new_project_status', '1'),('new_report_position', '2'),('new_report_status', '5'),('new_report_type', '-1'),('new_request_position', '2'),('new_request_status', '6'),('new_request_type', '-1'),('new_task_position', '2'),('new_task_priority', '3'),('new_task_status', '4'),('notify_report_admin', '0'),('notify_report_submitter', '0'),('notify_request_admin', '0'),('notify_request_submitter', '0'),('project_date_format', 'Y-m-d H:i:s'),('report_date_format', 'Y-m-d H:i:s'),('request_date_format', 'Y-m-d H:i:s'),('task_date_format', 'Y-m-d H:i:s');

DROP TABLE IF EXISTS $prefix.`_nsnpj_members`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_members` (`member_id` int(11) NOT NULL auto_increment, `member_name` varchar(255) NOT NULL default '', `member_email` varchar(255) NOT NULL default '',  PRIMARY KEY  (`member_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnpj_members_positions`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_members_positions` (`position_id` int(11) NOT NULL auto_increment, `position_name` varchar(255) NOT NULL default '',  `position_weight` int(11) NOT NULL default '0', PRIMARY KEY  (`position_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnpj_members_positions` (`position_id`, `position_name`, `position_weight`) VALUES (-1, 'N/A', 0),(1, 'Manager', 1),(2, 'Developer', 2),(3, 'Tester', 3),(4, 'Sponsor', 4);

DROP TABLE IF EXISTS $prefix.`_nsnpj_projects`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_projects` (`project_id` int(11) NOT NULL auto_increment,  `project_name` varchar(255) NOT NULL default '',  `project_description` text NOT NULL,  `project_site` varchar(255) NOT NULL default '',  `priority_id` int(11) NOT NULL default '0',  `status_id` int(11) NOT NULL default '0',  `project_percent` float NOT NULL default '0',  `weight` int(11) NOT NULL default '0',  `featured` tinyint(2) NOT NULL default '0',  `allowreports` tinyint(2) NOT NULL default '0',  `allowrequests` tinyint(2) NOT NULL default '0',  `date_created` int(14) NOT NULL default '0',  `date_started` int(14) NOT NULL default '0',  `date_finished` int(14) NOT NULL default '0',  PRIMARY KEY  (`project_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnpj_projects_members`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_projects_members` (  `project_id` int(11) NOT NULL default '0',  `member_id` int(11) NOT NULL default '0',  `position_id` int(11) NOT NULL default '0',  KEY `project_id` (`project_id`),  KEY `member_id` (`member_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnpj_projects_priorities`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_projects_priorities` (  `priority_id` int(11) NOT NULL auto_increment,  `priority_name` varchar(30) NOT NULL default '',  `priority_weight` int(11) NOT NULL default '1',  PRIMARY KEY  (`priority_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnpj_projects_priorities` (`priority_id`, `priority_name`, `priority_weight`) VALUES(-1, 'N/A', 0),(1, 'Low', 1),(2, 'Low-Med', 2),(3, 'Medium', 3),(4, 'High-Med', 4),(5, 'High', 5);

DROP TABLE IF EXISTS $prefix.`_nsnpj_projects_status`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_projects_status` (  `status_id` int(11) NOT NULL auto_increment,  `status_name` varchar(255) NOT NULL default '',  `status_weight` int(11) NOT NULL default '0',  PRIMARY KEY  (`status_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnpj_projects_status` (`status_id`, `status_name`, `status_weight`) VALUES(-1, 'N/A', 0),(1, 'Pending', 1),(2, 'Completed', 2),(3, 'Active', 3),(4, 'Inactive', 4),(5, 'Released', 5);

DROP TABLE IF EXISTS $prefix.`_nsnpj_reports`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_reports` (  `report_id` int(11) NOT NULL auto_increment,  `project_id` int(11) NOT NULL default '0',  `type_id` int(11) NOT NULL default '0',  `status_id` int(11) NOT NULL default '0',  `report_name` varchar(255) NOT NULL default '',  `report_description` text NOT NULL,  `submitter_name` varchar(32) NOT NULL default '',  `submitter_email` varchar(255) NOT NULL default '',  `submitter_ip` varchar(20) NOT NULL default '0.0.0.0',  `date_submitted` int(14) NOT NULL default '0',  `date_commented` int(14) NOT NULL default '0',  `date_modified` int(14) NOT NULL default '0',  PRIMARY KEY  (`report_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnpj_reports_comments`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_reports_comments` (  `comment_id` int(11) NOT NULL auto_increment,  `report_id` int(11) NOT NULL default '0',  `commenter_name` varchar(32) NOT NULL default '',  `commenter_email` varchar(255) NOT NULL default '',  `commenter_ip` varchar(20) NOT NULL default '0.0.0.0',  `comment_description` text NOT NULL,  `date_commented` int(14) NOT NULL default '0',  PRIMARY KEY  (`comment_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnpj_reports_members`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_reports_members` (  `report_id` int(11) NOT NULL default '0',  `member_id` int(11) NOT NULL default '0',  `position_id` int(11) NOT NULL default '0',  KEY `report_id` (`report_id`),  KEY `member_id` (`member_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnpj_reports_status`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_reports_status` (  `status_id` int(11) NOT NULL auto_increment,  `status_name` varchar(255) NOT NULL default '',  `status_weight` int(11) NOT NULL default '0',  PRIMARY KEY  (`status_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnpj_reports_status` (`status_id`, `status_name`, `status_weight`) VALUES(-1, 'N/A', 0),(1, 'Open', 1),(2, 'Closed', 2),(3, 'Duplicate', 3),(4, 'Feedback', 4),(5, 'Submitted', 5),(6, 'Suspended', 6),(7, 'Assigned', 7),(8, 'Info Needed', 8),(9, 'Unverifiable', 9);

DROP TABLE IF EXISTS $prefix.`_nsnpj_reports_types`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_reports_types` (  `type_id` int(11) NOT NULL auto_increment,  `type_name` varchar(255) NOT NULL default '',  `type_weight` int(11) NOT NULL default '0',  PRIMARY KEY  (`type_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnpj_reports_types` (`type_id`, `type_name`, `type_weight`) VALUES(-1, 'N/A', 0),(1, 'General', 1);

DROP TABLE IF EXISTS $prefix.`_nsnpj_requests`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_requests` (  `request_id` int(11) NOT NULL auto_increment,  `project_id` int(11) NOT NULL default '0',  `type_id` int(11) NOT NULL default '0',  `status_id` int(11) NOT NULL default '0',  `request_name` varchar(255) NOT NULL default '',  `request_description` text NOT NULL,  `submitter_name` varchar(32) NOT NULL default '',  `submitter_email` varchar(255) NOT NULL default '',  `submitter_ip` varchar(20) NOT NULL default '0.0.0.0',  `date_submitted` int(14) NOT NULL default '0',  `date_commented` int(14) NOT NULL default '0',  `date_modified` int(14) NOT NULL default '0',  PRIMARY KEY  (`request_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnpj_requests_comments`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_requests_comments` (  `comment_id` int(11) NOT NULL auto_increment,  `request_id` int(11) NOT NULL default '0',  `commenter_name` varchar(32) NOT NULL default '',  `commenter_email` varchar(255) NOT NULL default '',  `commenter_ip` varchar(20) NOT NULL default '0.0.0.0',  `comment_description` text NOT NULL,  `date_commented` int(14) NOT NULL default '0',  PRIMARY KEY  (`comment_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnpj_requests_members`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_requests_members` (  `request_id` int(11) NOT NULL default '0',  `member_id` int(11) NOT NULL default '0',  `position_id` int(11) NOT NULL default '0',  KEY `request_id` (`request_id`),  KEY `member_id` (`member_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnpj_requests_status`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_requests_status` (  `status_id` int(11) NOT NULL auto_increment,  `status_name` varchar(255) NOT NULL default '',  `status_weight` int(11) NOT NULL default '0',  PRIMARY KEY  (`status_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnpj_requests_status` (`status_id`, `status_name`, `status_weight`) VALUES(-1, 'N/A', 0),(1, 'Duplicate', 1),(2, 'Closed', 2),(3, 'Inclusion', 3),(4, 'Open', 4),(5, 'Feedback', 5),(6, 'Submitted', 6),(7, 'Discarded', 7),(8, 'Assigned', 8);

DROP TABLE IF EXISTS $prefix.`_nsnpj_requests_types`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_requests_types` (  `type_id` int(11) NOT NULL auto_increment,  `type_name` varchar(255) NOT NULL default '',  `type_weight` int(11) NOT NULL default '0',  PRIMARY KEY  (`type_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnpj_requests_types` (`type_id`, `type_name`, `type_weight`) VALUES(-1, 'N/A', 0),(1, 'General', 1);

DROP TABLE IF EXISTS $prefix.`_nsnpj_tasks`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_tasks` (  `task_id` int(11) NOT NULL auto_increment,  `project_id` int(11) NOT NULL default '0',  `task_name` varchar(255) NOT NULL default '',  `task_description` text NOT NULL,  `priority_id` int(11) NOT NULL default '1',  `status_id` int(11) NOT NULL default '0',  `task_percent` float NOT NULL default '0',  `date_created` int(14) NOT NULL default '0',  `date_started` int(14) NOT NULL default '0',  `date_finished` int(14) NOT NULL default '0',  PRIMARY KEY  (`task_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnpj_tasks_members`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_tasks_members` (  `task_id` int(11) NOT NULL default '0',  `member_id` int(11) NOT NULL default '0',  `position_id` int(11) NOT NULL default '0',  KEY `task_id` (`task_id`),  KEY `member_id` (`member_id`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnpj_tasks_priorities`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_tasks_priorities` (  `priority_id` int(11) NOT NULL auto_increment,  `priority_name` varchar(30) NOT NULL default '',  `priority_weight` int(11) NOT NULL default '1',  PRIMARY KEY  (`priority_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnpj_tasks_priorities` (`priority_id`, `priority_name`, `priority_weight`) VALUES(-1, 'N/A', 0),(1, 'Low', 1),(2, 'Low-Med', 2),(3, 'Medium', 3),(4, 'High-Med', 4),(5, 'High', 5);

DROP TABLE IF EXISTS $prefix.`_nsnpj_tasks_status`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnpj_tasks_status` (  `status_id` int(11) NOT NULL auto_increment,  `status_name` varchar(255) NOT NULL default '',  `status_weight` int(11) NOT NULL default '0',  PRIMARY KEY  (`status_id`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnpj_tasks_status` (`status_id`, `status_name`, `status_weight`) VALUES(-1, 'N/A', 0),(1, 'Inactive', 1),(2, 'On Going', 2),(3, 'Holding', 3),(4, 'Open', 4),(5, 'Completed', 5),(6, 'Discontinued', 6),(7, 'Active', 7);

DROP TABLE IF EXISTS $prefix.`_pages`;
CREATE TABLE $prefix.`_pages` (  `pid` int(10) NOT NULL auto_increment,  `cid` int(10) NOT NULL default '0',  `title` varchar(255) NOT NULL default '',  `subtitle` varchar(255) NOT NULL default '',  `tags` varchar(255) NOT NULL,  `active` int(1) NOT NULL default '0',  `page_header` text NOT NULL,  `text` text NOT NULL,  `page_footer` text NOT NULL,  `signature` text NOT NULL,  `date` datetime NOT NULL default '1000-01-01 00:00:00',  `counter` int(10) NOT NULL default '0',  `clanguage` varchar(30) NOT NULL default '',  `uname` varchar(40) NOT NULL default '',  PRIMARY KEY  (`pid`),  KEY `cid` (`cid`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_pages_categories`;
CREATE TABLE $prefix.`_pages_categories` (  `cid` int(10) NOT NULL auto_increment,  `cimg` varchar(255) NOT NULL,  `title` varchar(255) NOT NULL default '',  `description` text NOT NULL,  PRIMARY KEY  (`cid`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_pages_feat`;
CREATE TABLE $prefix.`_pages_feat` (  `cid` int(10) NOT NULL default '0',  `pid` int(10) NOT NULL default '0') ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_newpages`;
CREATE TABLE $prefix.`_newpages` (  `pid` int(10) NOT NULL auto_increment,  `cid` int(10) NOT NULL default '0',  `title` varchar(255) NOT NULL default '',  `subtitle` varchar(255) NOT NULL default '',  `tags` varchar(255) NOT NULL default '',  `page_header` text NOT NULL,  `text` text NOT NULL,  `page_footer` text NOT NULL,  `signature` text NOT NULL,  `uname` varchar(40) NOT NULL default '',  `date` datetime NOT NULL default '1000-01-01 00:00:00',  `clanguage` varchar(30) NOT NULL default '',  PRIMARY KEY  (`pid`),  KEY `cid` (`cid`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_seo_dh`;
CREATE TABLE IF NOT EXISTS $prefix.`_seo_dh` (`dhid` int(11) NOT NULL auto_increment, `levelsort` int(1) NOT NULL, `title` varchar(255) NOT NULL, `id` int(11) NOT NULL, `mid` int(11) NOT NULL, `lang` varchar(30) NOT NULL, `active` int(1) NOT NULL, `metavalue` text NOT NULL, PRIMARY KEY  (`dhid`), KEY `levelsort` (`levelsort`,`title`,`id`,`mid`)) ENGINE=InnoDB;

INSERT INTO $prefix.`_seo_dh` VALUES (1, 0, '', 0, 1, '', 1, '%slogan% - %sitename%');
INSERT INTO $prefix.`_seo_dh` VALUES (2, 0, '', 0, 5, '', 1, 'text/javascript');
INSERT INTO $prefix.`_seo_dh` VALUES (3, 0, '', 0, 6, '', 1, 'text/css');
INSERT INTO $prefix.`_seo_dh` VALUES (4, 0, '', 0, 8, '', 1, '0');
INSERT INTO $prefix.`_seo_dh` VALUES (5, 0, '', 0, 16, '', 1, 'DOCUMENT');
INSERT INTO $prefix.`_seo_dh` VALUES (6, 0, '', 0, 17, '', 1, 'GLOBAL');
INSERT INTO $prefix.`_seo_dh` VALUES (7, 0, '', 0, 18, '', 1, '%sitename%');
INSERT INTO $prefix.`_seo_dh` VALUES (8, 0, '', 0, 19, '', 1, 'Copyright (c) %year% by %sitename%');
INSERT INTO $prefix.`_seo_dh` VALUES (9, 0, '', 0, 20, '', 1, 'Welcome to %sitename%.  %slogan%');
INSERT INTO $prefix.`_seo_dh` VALUES (10, 0, '', 0, 21, '', 1, 'RavenNuke, news, technology, headlines, nuke, phpnuke, php-nuke, CMS, content management system');
INSERT INTO $prefix.`_seo_dh` VALUES (11, 0, '', 0, 22, '', 1, 'INDEX, FOLLOW');
INSERT INTO $prefix.`_seo_dh` VALUES (12, 0, '', 0, 23, '', 1, '1 DAY');
INSERT INTO $prefix.`_seo_dh` VALUES (13, 0, '', 0, 24, '', 1, 'GENERAL');
INSERT INTO $prefix.`_seo_dh` VALUES (14, 0, '', 0, 25, '', 1, 'RavenNuke&trade; Copyright (c) 2002-2018 by Gaylen Fraley. This is free software, and you may redistribute it under the GPL (http://www.gnu.org/licenses/gpl-2.0.txt). RavenNuke&trade; is supported at http://www.ravenphpscripts.com .');

DROP TABLE IF EXISTS $prefix.`_seo_dh_master`;
CREATE TABLE IF NOT EXISTS $prefix.`_seo_dh_master` (`mid` int(11) NOT NULL auto_increment, `order` int(5) NOT NULL, `type` varchar(50) NOT NULL, `name` varchar(50) NOT NULL, `default` varchar(255) NOT NULL, `active` int(1) NOT NULL, PRIMARY KEY  (`mid`), KEY `order` (`order`)) ENGINE=InnoDB;

INSERT INTO $prefix.`_seo_dh_master` VALUES (1, 0, 'title', 'title', '$slogan', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (2, 100, 'http-equiv', 'refresh', '', 0);
INSERT INTO $prefix.`_seo_dh_master` VALUES (3, 200, 'http-equiv', 'Content-Type', '', 0);
INSERT INTO $prefix.`_seo_dh_master` VALUES (4, 300, 'http-equiv', 'Content-Language', '', 0);
INSERT INTO $prefix.`_seo_dh_master` VALUES (5, 400, 'http-equiv', 'Content-Script-Type', 'text/javascript', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (6, 500, 'http-equiv', 'Content-Style-Type', 'text/css', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (7, 600, 'http-equiv', 'Pragma', 'no-cache', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (8, 700, 'http-equiv', 'Expires', '0', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (9, 800, 'http-equiv', 'Ext-cache', '', 0);
INSERT INTO $prefix.`_seo_dh_master` VALUES (10, 900, 'http-equiv', 'set-cookie', '', 0);
INSERT INTO $prefix.`_seo_dh_master` VALUES (11, 1000, 'http-equiv', 'window-target', '', 0);
INSERT INTO $prefix.`_seo_dh_master` VALUES (12, 1100, 'http-equiv', 'PICS-Label', '', 0);
INSERT INTO $prefix.`_seo_dh_master` VALUES (13, 1200, 'http-equiv', 'Cache-Control', '', 0);
INSERT INTO $prefix.`_seo_dh_master` VALUES (14, 1300, 'http-equiv', 'Vary', '', 0);
INSERT INTO $prefix.`_seo_dh_master` VALUES (15, 1400, 'name', 'ROBOTS', 'NOARCHIVE', 0);
INSERT INTO $prefix.`_seo_dh_master` VALUES (16, 1500, 'name', 'RESOURCE-TYPE', 'DOCUMENT', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (17, 1600, 'name', 'DISTRIBUTION', 'GLOBAL', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (18, 1700, 'name', 'AUTHOR', '$sitename', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (19, 1800, 'name', 'COPYRIGHT', 'Copyright (c) 2009-2018 by $sitename', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (20, 1900, 'name', 'DESCRIPTION', '$slogan', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (21, 2000, 'name', 'KEYWORDS', 'news, technology, headlines, nuke, phpnuke, php-nuke, geek, geeks, hacker, hackers', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (22, 2100, 'name', 'ROBOTS', 'INDEX, FOLLOW', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (23, 2200, 'name', 'REVISIT-AFTER', '1 DAY', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (24, 2300, 'name', 'RATING', 'GENERAL', 1);
INSERT INTO $prefix.`_seo_dh_master` VALUES (25, 2400, 'name', 'GENERATOR', 'RavenNuke&trade; Copyright (c) 2002-2018 by Gaylen Fraley. This is free software, and you may redistribute it under the GPL (http://www.gnu.org/licenses/gpl-2.0.txt). RavenNuke&trade; is supported at http://www.ravenphpscripts.com .', 1);

CREATE TABLE IF NOT EXISTS $prefix.`_themes` ( `theme` varchar(25) NOT NULL default "", `themename` varchar(25) NOT NULL default "", `active` tinyint(1) NOT NULL default "0", `default` tinyint(1) NOT NULL default "0", `guest` tinyint(1) NOT NULL default "0", `moveableblocks` tinyint(1) NOT NULL default "0", `collapsibleblocks` tinyint(1) NOT NULL default "0", `compatible` tinyint(1) NOT NULL default "0", PRIMARY KEY (`theme`) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_tags`;
CREATE TABLE IF NOT EXISTS $prefix.`_tags` ( `tag` varchar(25) NOT NULL, `cid` int(10) NOT NULL default '0', `whr` int(1) NOT NULL default '0') ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_tags_temp`;
CREATE TABLE IF NOT EXISTS $prefix.`_tags_temp` ( `tag` varchar(25) NOT NULL, `cid` int(10) NOT NULL default '0', `whr` int(1) NOT NULL default '0') ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_ton`;
CREATE TABLE IF NOT EXISTS $prefix.`_ton` (  `newsrows` int(1) NOT NULL default '0',`bookmark` int(1) NOT NULL default '0', `rblocks` int(1) NOT NULL default '0', `linklocation` varchar(6) NOT NULL default '0', `articlelink` int(1) NOT NULL default '0', `artview` varchar(3) NOT NULL default '0', `TON_useTitleLink` int(1) NOT NULL default '0', `TON_usePDF` int(1) NOT NULL default '0', `TON_useRating` int(1) NOT NULL default '0', `TON_useSendToFriend` int(1) NOT NULL default '0', `showtags` int(1) NOT NULL default '0', `TON_useCharLimit` int(1) NOT NULL default '0', `TON_CharLimit` int(3) NOT NULL default '0', `topadact` int(1) NOT NULL default '0', `topad` int(3) NOT NULL default '0', `bottomadact` int(1) NOT NULL default '0', `bottomad` int(3) NOT NULL default '0', `usedisqus` int(1) NOT NULL default '0', `shortname` varchar(25) NOT NULL default '0', `googlapi` varchar(44) NULL, `usegooglsb` int(1) NOT NULL default '0', `usegooglart` int(1) NOT NULL default '0') ENGINE=InnoDB;

INSERT INTO $prefix.`_ton` ( `newsrows`, `bookmark`, `rblocks`, `linklocation`, `articlelink`, `artview`, `TON_useTitleLink`, `TON_usePDF`, `TON_useRating`, `TON_useSendToFriend`, `showtags`, `TON_useCharLimit`, `TON_CharLimit`, `topadact`, `topad`, `bottomadact`, `bottomad`, `usedisqus`, `shortname`, `googlapi`, `usegooglsb`, `usegooglart`) VALUES ('1', '1', '1', 'top', '1', 'new', '1', '1', '1', '1', '0', '0', '240', '0', '0', '0', '0', '0', 'Short Name', '', '0', '0');
DROP TABLE IF EXISTS $prefix.`_nsnst_admins`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_admins` (`aid` varchar(25) NOT NULL default '', `login` varchar(25) NOT NULL default '', `password` varchar(40) NOT NULL default '', `password_md5` varchar(60) NOT NULL default '', `password_crypt` varchar(60) NOT NULL default '', `protected` tinyint(2) NOT NULL default '0', PRIMARY KEY  (`aid`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnst_blocked_ips`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_blocked_ips` (`ip_addr` varchar(15) NOT NULL default '', `ip_long` int(10) unsigned NOT NULL default '0', `user_id` int(11) NOT NULL default '1', `username` varchar(60) NOT NULL default '', `user_agent` text NOT NULL, `date` int(20) NOT NULL default '0', `notes` text NOT NULL, `reason` tinyint(1) NOT NULL default '0', `query_string` text NOT NULL, `get_string` text NOT NULL, `post_string` text NOT NULL, `x_forward_for` varchar(32) NOT NULL default '', `client_ip` varchar(32) NOT NULL default '',`remote_addr` varchar(32) NOT NULL default '',`remote_port` varchar(11) NOT NULL default '', `request_method` varchar(10) NOT NULL default '', `expires` int(20) NOT NULL default '0', `c2c` char(2) NOT NULL default '00', PRIMARY KEY  (`ip_addr`), KEY `ip_long` (`ip_long`), KEY `c2c` (`c2c`), KEY `date` (`date`), KEY `expires` (`expires`), KEY `reason` (`reason`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnst_blocked_ranges`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_blocked_ranges` (`ip_lo` int(10) unsigned NOT NULL default '0', `ip_hi` int(10) unsigned NOT NULL default '0', `date` int(20) NOT NULL default '0', `notes` text NOT NULL, `reason` tinyint(1) NOT NULL default '0', `expires` int(20) NOT NULL default '0',  `c2c` char(2) NOT NULL default '00', PRIMARY KEY  (`ip_lo`,`ip_hi`), KEY `c2c` (`c2c`), KEY `date` (`date`), KEY `expires` (`expires`), KEY `reason` (`reason`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnst_blockers`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_blockers` ( `blocker` int(4) NOT NULL default '0', `block_name` varchar(20) NOT NULL default '', `activate` int(4) NOT NULL default '0', `block_type` int(4) NOT NULL default '0', `email_lookup` int(4) NOT NULL default '0', `forward` varchar(255) NOT NULL default '', `reason` varchar(20) NOT NULL default '', `template` varchar(255) NOT NULL default '', `duration` int(20) NOT NULL default '0', `htaccess` int(4) NOT NULL default '0', `list` longtext NOT NULL, PRIMARY KEY  (`blocker`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnst_blockers` (`blocker`, `block_name`, `activate`, `block_type`, `email_lookup`, `forward`, `reason`, `template`, `duration`, `htaccess`, `list`) VALUES(0, 'other', 0, 0, 0, '', 'Abuse-Other', 'abuse_default.tpl', 0, 0, '');
INSERT INTO $prefix.`_nsnst_blockers` (`blocker`, `block_name`, `activate`, `block_type`, `email_lookup`, `forward`, `reason`, `template`, `duration`, `htaccess`, `list`) VALUES(1, 'union', 1, 0, 0, '', 'Abuse-Union', 'abuse_union.tpl', 0, 0, '');
INSERT INTO $prefix.`_nsnst_blockers` (`blocker`, `block_name`, `activate`, `block_type`, `email_lookup`, `forward`, `reason`, `template`, `duration`, `htaccess`, `list`) VALUES(2, 'clike', 1, 0, 0, '', 'Abuse-CLike', 'abuse_clike.tpl', 0, 0, '');
INSERT INTO $prefix.`_nsnst_blockers` (`blocker`, `block_name`, `activate`, `block_type`, `email_lookup`, `forward`, `reason`, `template`, `duration`, `htaccess`, `list`) VALUES(3, 'harvester', 0, 0, 0, '', 'Abuse-Harvest', 'abuse_harvester.tpl', 0, 0, '');
INSERT INTO $prefix.`_nsnst_blockers` (`blocker`, `block_name`, `activate`, `block_type`, `email_lookup`, `forward`, `reason`, `template`, `duration`, `htaccess`, `list`) VALUES(4, 'script', 1, 0, 0, '', 'Abuse-Script', 'abuse_script.tpl', 0, 0, '');
INSERT INTO $prefix.`_nsnst_blockers` (`blocker`, `block_name`, `activate`, `block_type`, `email_lookup`, `forward`, `reason`, `template`, `duration`, `htaccess`, `list`) VALUES(5, 'author', 1, 0, 0, '', 'Abuse-Author', 'abuse_author.tpl', 0, 0, '');
INSERT INTO $prefix.`_nsnst_blockers` (`blocker`, `block_name`, `activate`, `block_type`, `email_lookup`, `forward`, `reason`, `template`, `duration`, `htaccess`, `list`) VALUES(6, 'referer', 0, 0, 0, '', 'Abuse-Referer', 'abuse_referer.tpl', 0, 0, '');
INSERT INTO $prefix.`_nsnst_blockers` (`blocker`, `block_name`, `activate`, `block_type`, `email_lookup`, `forward`, `reason`, `template`, `duration`, `htaccess`, `list`) VALUES(7, 'filter', 1, 0, 0, '', 'Abuse-Filter', 'abuse_filter.tpl', 0, 0, '');
INSERT INTO $prefix.`_nsnst_blockers` (`blocker`, `block_name`, `activate`, `block_type`, `email_lookup`, `forward`, `reason`, `template`, `duration`, `htaccess`, `list`) VALUES(8, 'request', 0, 0, 0, '', 'Abuse-Request', 'abuse_request.tpl', 0, 0, '');
INSERT INTO $prefix.`_nsnst_blockers` (`blocker`, `block_name`, `activate`, `block_type`, `email_lookup`, `forward`, `reason`, `template`, `duration`, `htaccess`, `list`) VALUES(9, 'string', 0, 0, 0, '', 'Abuse-String', 'abuse_string.tpl', 0, 0, '');
INSERT INTO $prefix.`_nsnst_blockers` (`blocker`, `block_name`, `activate`, `block_type`, `email_lookup`, `forward`, `reason`, `template`, `duration`, `htaccess`, `list`) VALUES(10, 'admin', 1, 0, 0, '', 'Abuse-Admin', 'abuse_admin.tpl', 0, 0, '');
INSERT INTO $prefix.`_nsnst_blockers` (`blocker`, `block_name`, `activate`, `block_type`, `email_lookup`, `forward`, `reason`, `template`, `duration`, `htaccess`, `list`) VALUES(11, 'flood', 0, 0, 0, '', 'Abuse-Flood', 'abuse_flood.tpl', 0, 0, '');

DROP TABLE IF EXISTS $prefix.`_nsnst_cidrs`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_cidrs` ( `cidr` int(2) NOT NULL default '0', `hosts` int(10) NOT NULL default '0', `mask` varchar(15) NOT NULL default '', PRIMARY KEY  (`cidr`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(1, 2147483647, '127.255.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(2, 1073741824, '63.255.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(3, 536870912, '31.255.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(4, 268435456, '15.255.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(5, 134217728, '7.255.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(6, 67108864, '3.255.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(7, 33554432, '1.255.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(8, 16777216, '0.255.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(9, 8388608, '0.127.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(10, 4194304, '0.63.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(11, 2097152, '0.31.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(12, 1048576, '0.15.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(13, 524288, '0.7.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(14, 262144, '0.3.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(15, 131072, '0.1.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(16, 65536, '0.0.255.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(17, 32768, '0.0.127.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(18, 16384, '0.0.63.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(19, 8192, '0.0.31.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(20, 4096, '0.0.15.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(21, 2048, '0.0.7.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(22, 1024, '0.0.3.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(23, 512, '0.0.1.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(24, 256, '0.0.0.255');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(25, 128, '0.0.0.127');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(26, 64, '0.0.0.63');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(27, 32, '0.0.0.31');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(28, 16, '0.0.0.15');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(29, 8, '0.0.0.7');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(30, 4, '0.0.0.3');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(31, 2, '0.0.0.1');
INSERT INTO $prefix.`_nsnst_cidrs` (`cidr`, `hosts`, `mask`) VALUES(32, 1, '0.0.0.0');

DROP TABLE IF EXISTS $prefix.`_nsnst_config`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_config` ( `config_name` varchar(255) NOT NULL default '', `config_value` longtext NOT NULL, PRIMARY KEY  (`config_name`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('admin_contact', 'webmaster@yoursite.com');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('blocked_clear', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('block_perpage', '50');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('block_sort_column', 'date');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('block_sort_direction', 'desc');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('crypt_salt', 'N$');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('disable_switch', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('display_link', '3');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('display_reason', '3');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('dump_directory', 'cache/');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('flood_delay', '2');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('force_nukeurl', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('ftaccess_path', '');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('help_switch', '1');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('htaccess_path', '');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('http_auth', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('ip2c_version', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('list_harvester', '@yahoo.com\r\nalexibot\r\nalligator\r\nanonymiz\r\nasterias\r\nbackdoorbot\r\nblack hole\r\nblackwidow\r\nblowfish\r\nbotalot\r\nbuiltbottough\r\nbullseye\r\nbunnyslippers\r\ncatch\r\ncegbfeieh\r\ncharon\r\ncheesebot\r\ncherrypicker\r\nchinaclaw\r\ncombine\r\ncopyrightcheck\r\ncosmos\r\ncrescent\r\ncurl\r\ndbrowse\r\ndisco\r\ndittospyder\r\ndlman\r\ndnloadmage\r\ndownload\r\ndreampassport\r\ndts agent\r\necatch\r\neirgrabber\r\nerocrawler\r\nexpress webpictures\r\nextractorpro\r\neyenetie\r\nfantombrowser\r\nfantomcrew browser\r\nfileheap\r\nfilehound\r\nflashget\r\nfoobot\r\nfranklin locator\r\nfreshdownload\r\nfscrawler\r\ngamespy_arcade\r\ngetbot\r\ngetright\r\ngetweb\r\ngo!zilla\r\ngo-ahead-got-it\r\ngrab\r\ngrafula\r\ngsa-crawler\r\nharvest\r\nhloader\r\nhmview\r\nhttplib\r\nhttpresume\r\nhttrack\r\nhumanlinks\r\nigetter\r\nimage stripper\r\nimage sucker\r\nindustry program\r\nindy library\r\ninfonavirobot\r\ninstallshield digitalwizard\r\ninterget\r\niria\r\nirvine\r\niupui research bot\r\njbh agent\r\njennybot\r\njetcar\r\njobo\r\njoc\r\nkapere\r\nkenjin spider\r\nkeyword density\r\nlarbin\r\nleechftp\r\nleechget\r\nlexibot\r\nlibweb/clshttp\r\nlibwww-perl\r\nlightningdownload\r\nlincoln state web browser\r\nlinkextractorpro\r\nlinkscan/8.1a.unix\r\nlinkwalker\r\nlwp-trivial\r\nlwp::simple\r\nmac finder\r\nmata hari\r\nmediasearch\r\nmetaproducts\r\nmicrosoft url control\r\nmidown tool\r\nmiixpc\r\nmissauga locate\r\nmissouri college browse\r\nmister pix\r\nmoget\r\nmozilla.*newt\r\nmozilla/3.0 (compatible)\r\nmozilla/3.mozilla/2.01\r\nmsie 4.0 (win95)\r\nmultiblocker browser\r\nmydaemon\r\nmygetright\r\nnabot\r\nnavroad\r\nnearsite\r\nnet vampire\r\nnetants\r\nnetmechanic\r\nnetpumper\r\nnetspider\r\nnewsearchengine\r\nnicerspro\r\nninja\r\nnitro downloader\r\nnpbot\r\noctopus\r\noffline explorer\r\noffline navigator\r\nopenfind\r\npagegrabber\r\npapa foto\r\npavuk\r\npbrowse\r\npcbrowser\r\npeval\r\npompos/\r\nprogram shareware\r\npropowerbot\r\nprowebwalker\r\npsurf\r\npuf\r\npuxarapido\r\nqueryn metasearch\r\nrealdownload\r\nreget\r\nrepomonkey\r\nrsurf\r\nrumours-agent\r\nsakura\r\nscan4mail\r\nsemanticdiscovery\r\nsitesnagger\r\nslysearch\r\nspankbot\r\nspanner \r\nspiderzilla\r\nsq webscanner\r\nstamina\r\nstar downloader\r\nsteeler\r\nstrip\r\nsuperbot\r\nsuperhttp\r\nsurfbot\r\nsuzuran\r\nswbot\r\nszukacz\r\ntakeout\r\nteleport\r\ntelesoft\r\ntest spider\r\nthe intraformant\r\nthenomad\r\ntighttwatbot\r\ntitan\r\ntocrawl/urldispatcher\r\ntrue_robot\r\ntsurf\r\nturing machine\r\nturingos\r\nurlblaze\r\nurlgetfile\r\nurly warning\r\nutilmind\r\nvci\r\nvoideye\r\nweb image collector\r\nweb sucker\r\nwebauto\r\nwebbandit\r\nwebcapture\r\nwebcollage\r\nwebcopier\r\nwebenhancer\r\nwebfetch\r\nwebgo\r\nwebleacher\r\nwebmasterworldforumbot\r\nwebql\r\nwebreaper\r\nwebsite extractor\r\nwebsite quester\r\nwebster\r\nwebstripper\r\nwebwhacker\r\nwep search\r\nwget\r\nwhizbang\r\nwidow\r\nwildsoft surfer\r\nwww-collector-e\r\nwww.netwu.com\r\nwwwoffle\r\nxaldon\r\nxenu\r\nzeus\r\nziggy\r\nzippy');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('list_referer', '121hr.com\r\n1st-call.net\r\n1stcool.com\r\n5000n.com\r\n69-xxx.com\r\n9irl.com\r\n9uy.com\r\na-day-at-the-party.com\r\naccessthepeace.com\r\nadult-model-nude-pictures.com\r\nadult-sex-toys-free-porn.com\r\nagnitum.com\r\nalfonssackpfeiffe.com\r\nalongwayfrommars.com\r\nanime-sex-1.com\r\nanorex-sf-stimulant-free.com\r\nantibot.net\r\nantique-tokiwa.com\r\napotheke-heute.com\r\narmada31.com\r\nartark.com\r\nartlilei.com\r\nascendbtg.com\r\naschalaecheck.com\r\nasian-sex-free-sex.com\r\naslowspeeker.com\r\nassasinatedfrogs.com\r\nathirst-for-tranquillity.net\r\naubonpanier.com\r\navalonumc.com\r\nayingba.com\r\nbayofnoreturn.com\r\nbbw4phonesex.com\r\nbeersarenotfree.com\r\nbierikiuetsch.com\r\nbilingualannouncements.com\r\nblack-pussy-toon-clip-anal-lover-single.com\r\nblownapart.com\r\nblueroutes.com\r\nboasex.com\r\nbooksandpages.com\r\nbootyquake.com\r\nbossyhunter.com\r\nboyz-sex.com\r\nbrokersaandpokers.com\r\nbrowserwindowcleaner.com\r\nbudobytes.com\r\nbusiness2fun.com\r\nbuymyshitz.com\r\nbyuntaesex.com\r\ncaniputsomeloveintoyou.com\r\ncartoons.net.ru\r\ncaverunsailing.com\r\ncertainhealth.com\r\nclantea.com\r\nclose-protection-services.com\r\nclubcanino.com\r\nclubstic.com\r\ncobrakai-skf.com\r\ncollegefucktour.co.uk\r\ncommanderspank.com\r\ncoolenabled.com\r\ncrusecountryart.com\r\ncrusingforsex.co.uk\r\ncunt-twat-pussy-juice-clit-licking.com\r\ncustomerhandshaker.com\r\ncyborgrama.com\r\ndarkprofits.co.uk\r\ndatingforme.co.uk\r\ndatingmind.com\r\ndegree.org.ru\r\ndelorentos.com\r\ndiggydigger.com\r\ndinkydonkyaussie.com\r\ndjpritchard.com\r\ndjtop.com\r\ndraufgeschissen.com\r\ndreamerteens.co.uk\r\nebonyarchives.co.uk\r\nebonyplaya.co.uk\r\necobuilder2000.com\r\nemailandemail.com\r\nemedici.net\r\nengine-on-fire.com\r\nerocity.co.uk\r\nesport3.com\r\neteenbabes.com\r\neurofreepages.com\r\neurotexans.com\r\nevolucionweb.com\r\nfakoli.com\r\nfe4ba.com\r\nferienschweden.com\r\nfindly.com\r\nfirsttimeteadrinker.com\r\nfishing.net.ru\r\nflatwonkers.com\r\nflowershopentertainment.com\r\nflymario.com\r\nfree-xxx-pictures-porno-gallery.com\r\nfreebestporn.com\r\nfreefuckingmovies.co.uk\r\nfreexxxstuff.co.uk\r\nfruitologist.net\r\nfruitsandbolts.com\r\nfuck-cumshots-free-midget-movie-clips.com\r\nfuck-michaelmoore.com\r\nfundacep.com\r\ngadless.com\r\ngallapagosrangers.com\r\ngalleries4free.co.uk\r\ngalofu.com\r\ngaypixpost.co.uk\r\ngeomasti.com\r\ngirltime.co.uk\r\nglassrope.com\r\ngodjustblessyouall.com\r\ngoldenageresort.com\r\ngonnabedaddies.com\r\ngranadasexi.com\r\nguardingtheangels.com\r\nguyprofiles.co.uk\r\nhappy1225.com\r\nhappychappywacky.com\r\nhealth.org.ru\r\nhexplas.com\r\nhighheelsmodels4fun.com\r\nhillsweb.com\r\nhiptuner.com\r\nhistoryintospace.com\r\nhoa-tuoi.com\r\nhomebuyinginatlanta.com\r\nhorizonultra.com\r\nhorseminiature.net\r\nhotkiss.co.uk\r\nhotlivegirls.co.uk\r\nhotmatchup.co.uk\r\nhusler.co.uk\r\niaentertainment.com\r\niamnotsomeone.com\r\niconsofcorruption.com\r\nihavenotrustinyou.com\r\ninformat-systems.com\r\ninteriorproshop.com\r\nintersoftnetworks.com\r\ninthecrib.com\r\ninvestment4cashiers.com\r\niti-trailers.com\r\njackpot-hacker.com\r\njacks-world.com\r\njamesthesailorbasher.com\r\njesuislemonds.com\r\njustanotherdomainname.com\r\nkampelicka.com\r\nkanalrattenarsch.com\r\nkatzasher.com\r\nkerosinjunkie.com\r\nkillasvideo.com\r\nkoenigspisser.com\r\nkontorpara.com\r\nl8t.com\r\nlaestacion101.com\r\nlambuschlamppen.com\r\nlankasex.co.uk\r\nlaser-creations.com\r\nle-tour-du-monde.com\r\nlecraft.com\r\nledo-design.com\r\nleftregistration.com\r\nlekkikoomastas.com\r\nlepommeau.com\r\nlibr-animal.com\r\nlibraries.org.ru\r\nlikewaterlikewind.com\r\nlimbojumpers.com\r\nlink.ru\r\nlockportlinks.com\r\nloiproject.com\r\nlongtermalternatives.com\r\nlottoeco.com\r\nlucalozzi.com\r\nmaki-e-pens.com\r\nmalepayperview.co.uk\r\nmangaxoxo.com\r\nmaps.org.ru\r\nmarcofields.com\r\nmasterofcheese.com\r\nmasteroftheblasterhill.com\r\nmastheadwankers.com\r\nmegafrontier.com\r\nmeinschuppen.com\r\nmercurybar.com\r\nmetapannas.com\r\nmicelebre.com\r\nmidnightlaundries.com\r\nmikeapartment.co.uk\r\nmillenniumchorus.com\r\nmimundial2002.com\r\nminiaturegallerymm.com\r\nmixtaperadio.com\r\nmondialcoral.com\r\nmonja-wakamatsu.com\r\nmonstermonkey.net\r\nmouthfreshners.com\r\nmullensholiday.com\r\nmusilo.com\r\nmyhollowlog.com\r\nmyhomephonenumber.com\r\nmykeyboardisbroken.com\r\nmysofia.net\r\nnaked-cheaters.com\r\nnaked-old-women.com\r\nnastygirls.co.uk\r\nnationclan.net\r\nnatterratter.com\r\nnaughtyadam.com\r\nnestbeschmutzer.com\r\nnetwu.com\r\nnewrealeaseonline.com\r\nnewrealeasesonline.com\r\nnextfrontiersonline.com\r\nnikostaxi.com\r\nnotorious7.com\r\nnrecruiter.com\r\nnursingdepot.com\r\nnustramosse.com\r\nnuturalhicks.com\r\noccaz-auto49.com\r\nocean-db.net\r\noilburnerservice.net\r\nomburo.com\r\noneoz.com\r\nonepageahead.net\r\nonlinewithaline.com\r\norganizate.net\r\nourownweddingsong.com\r\nowen-music.com\r\np-partners.com\r\npaginadeautor.com\r\npakistandutyfree.com\r\npamanderson.co.uk\r\nparentsense.net\r\nparticlewave.net\r\npay-clic.com\r\npay4link.net\r\npcisp.com\r\npersist-pharma.com\r\npeteband.com\r\npetplusindia.com\r\npickabbw.co.uk\r\npicture-oral-position-lesbian.com\r\npl8again.com\r\nplaneting.net\r\npopusky.com\r\nporn-expert.com\r\npromoblitza.com\r\nproproducts-usa.com\r\nptcgzone.com\r\nptporn.com\r\npublishmybong.com\r\nputtingtogether.com\r\nqualifiedcancelations.com\r\nrahost.com\r\nrainbow21.com\r\nrakkashakka.com\r\nrandomfeeding.com\r\nrape-art.com\r\nrd-brains.com\r\nrealestateonthehill.net\r\nrebuscadobot\r\nrequested-stuff.com\r\nretrotrasher.com\r\nricopositive.com\r\nrisorseinrete.com\r\nrotatingcunts.com\r\nrunawayclicks.com\r\nrutalibre.com\r\ns-marche.com\r\nsabrosojazz.com\r\nsamuraidojo.com\r\nsanaldarbe.com\r\nsasseminars.com\r\nschlampenbruzzler.com\r\nsearchmybong.com\r\nseckur.com\r\nsex-asian-porn-interracial-photo.com\r\nsex-porn-fuck-hardcore-movie.com\r\nsexa3.net\r\nsexer.com\r\nsexintention.com\r\nsexnet24.tv\r\nsexomundo.com\r\nsharks.com.ru\r\nshells.com.ru\r\nshop-ecosafe.com\r\nshop-toon-hardcore-fuck-cum-pics.com\r\nsilverfussions.com\r\nsin-city-sex.net\r\nsluisvan.com\r\nsmutshots.com\r\nsnagglersmaggler.com\r\nsomethingtoforgetit.com\r\nsophiesplace.net\r\nsoursushi.com\r\nsouthernxstables.com\r\nspeed467.com\r\nspeedpal4you.com\r\nsporty.org.ru\r\nstopdriving.net\r\nstw.org.ru\r\nsufficientlife.com\r\nsussexboats.net\r\nswinger-party-free-dating-porn-sluts.com\r\nsydneyhay.com\r\nszmjht.com\r\nteninchtrout.com\r\nthebalancedfruits.com\r\ntheendofthesummit.com\r\nthiswillbeit.com\r\nthosethosethose.com\r\nticyclesofindia.com\r\ntits-gay-fagot-black-tits-bigtits-amateur.com\r\ntonius.com\r\ntoohsoft.com\r\ntoolvalley.com\r\ntooporno.net\r\ntoosexual.com\r\ntorngat.com\r\ntour.org.ru\r\ntowneluxury.com\r\ntrafficmogger.com\r\ntriacoach.net\r\ntrottinbob.com\r\ntttframes.com\r\ntvjukebox.net\r\nundercvr.com\r\nunfinished-desires.com\r\nunicornonero.com\r\nunionvillefire.com\r\nupsandowns.com\r\nupthehillanddown.com\r\nvallartavideo.com\r\nvietnamdatingservices.com\r\nvinegarlemonshots.com\r\nvizy.net.ru\r\nvnladiesdatingservices.com\r\nvomitandbusted.com\r\nwalkingthewalking.com\r\nwell-I-am-the-type-of-boy.com\r\nwhales.com.ru\r\nwhincer.net\r\nwhitpagesrippers.com\r\nwhois.sc\r\nwipperrippers.com\r\nwordfilebooklets.com\r\nworld-sexs.com\r\nxsay.com\r\nxxxchyangel.com\r\nxxxx:\r\nxxxzips.com\r\nyouarelostintransit.com\r\nyuppieslovestocks.com\r\nyuzhouhuagong.com\r\nzhaori-food.com\r\nzwiebelbacke.com');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('list_string', '');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('lookup_link', 'http://www.DNSstuff.com/tools/whois/?ip=');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('page_delay', '5');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('prevent_dos', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('proxy_reason', 'admin_proxy_reason.tpl');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('proxy_switch', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('santy_protection', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('self_expire', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('show_right', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('site_reason', 'admin_site_reason.tpl');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('site_switch', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('staccess_path', '');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('test_switch', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('track_active', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('track_clear', '0');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('track_max', '604800');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('track_perpage', '50');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('track_sort_column', '6');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('track_sort_direction', 'desc');
INSERT INTO $prefix.`_nsnst_config` (`config_name`, `config_value`) VALUES('version_number', '2.6.03');

DROP TABLE IF EXISTS $prefix.`_nsnst_countries`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_countries` ( `c2c` char(2) NOT NULL default '', `country` varchar(60) NOT NULL default '', PRIMARY KEY  (`c2c`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnst_excluded_ranges`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_excluded_ranges` ( `ip_lo` int(10) unsigned NOT NULL default '0', `ip_hi` int(10) unsigned NOT NULL default '0', `date` int(20) NOT NULL default '0', `notes` text NOT NULL, `c2c` char(2) NOT NULL default '00', PRIMARY KEY  (`ip_lo`,`ip_hi`), KEY `c2c` (`c2c`), KEY `date` (`date`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnst_harvesters`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_harvesters` ( `hid` int(2) NOT NULL auto_increment, `harvester` varchar(255) NOT NULL default '', PRIMARY KEY  (`harvester`), KEY `hid` (`hid`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(1, '@yahoo.com');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(2, 'alexibot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(3, 'alligator');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(4, 'anonymiz');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(5, 'asterias');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(6, 'backdoorbot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(7, 'black hole');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(8, 'blackwidow');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(9, 'blowfish');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(10, 'botalot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(11, 'builtbottough');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(12, 'bullseye');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(13, 'bunnyslippers');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(14, 'catch');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(15, 'cegbfeieh');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(16, 'charon');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(17, 'cheesebot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(18, 'cherrypicker');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(19, 'chinaclaw');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(20, 'combine');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(21, 'copyrightcheck');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(22, 'cosmos');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(23, 'crescent');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(24, 'curl');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(25, 'dbrowse');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(26, 'disco');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(27, 'dittospyder');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(28, 'dlman');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(29, 'dnloadmage');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(30, 'download');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(31, 'dreampassport');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(32, 'dts agent');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(33, 'ecatch');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(34, 'eirgrabber');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(35, 'erocrawler');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(36, 'express webpictures');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(37, 'extractorpro');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(38, 'eyenetie');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(39, 'fantombrowser');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(40, 'fantomcrew browser');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(41, 'fileheap');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(42, 'filehound');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(43, 'flashget');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(44, 'foobot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(45, 'franklin locator');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(46, 'freshdownload');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(47, 'fscrawler');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(48, 'gamespy_arcade');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(49, 'getbot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(50, 'getright');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(51, 'getweb');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(52, 'go!zilla');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(53, 'go-ahead-got-it');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(54, 'grab');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(55, 'grafula');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(56, 'gsa-crawler');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(57, 'harvest');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(58, 'hloader');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(59, 'hmview');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(60, 'httplib');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(61, 'httpresume');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(62, 'httrack');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(63, 'humanlinks');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(64, 'igetter');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(65, 'image stripper');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(66, 'image sucker');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(67, 'industry program');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(68, 'indy library');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(69, 'infonavirobot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(70, 'installshield digitalwizard');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(71, 'interget');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(72, 'iria');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(73, 'irvine');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(74, 'iupui research bot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(75, 'jbh agent');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(76, 'jennybot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(77, 'jetcar');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(78, 'jobo');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(79, 'joc');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(80, 'kapere');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(81, 'kenjin spider');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(82, 'keyword density');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(83, 'larbin');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(84, 'leechftp');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(85, 'leechget');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(86, 'lexibot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(87, 'libweb/clshttp');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(88, 'libwww-perl');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(89, 'lightningdownload');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(90, 'lincoln state web browser');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(91, 'linkextractorpro');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(92, 'linkscan/8.1a.unix');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(93, 'linkwalker');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(94, 'lwp-trivial');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(95, 'lwp::simple');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(96, 'mac finder');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(97, 'mata hari');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(98, 'mediasearch');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(99, 'metaproducts');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(100, 'microsoft url control');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(101, 'midown tool');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(102, 'miixpc');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(103, 'missauga locate');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(104, 'missouri college browse');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(105, 'mister pix');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(106, 'moget');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(107, 'mozilla.*newt');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(108, 'mozilla/3.0 (compatible)');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(109, 'mozilla/3.mozilla/2.01');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(110, 'msie 4.0 (win95)');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(111, 'multiblocker browser');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(112, 'mydaemon');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(113, 'mygetright');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(114, 'nabot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(115, 'navroad');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(116, 'nearsite');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(117, 'net vampire');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(118, 'netants');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(119, 'netmechanic');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(120, 'netpumper');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(121, 'netspider');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(122, 'newsearchengine');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(123, 'nicerspro');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(124, 'ninja');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(125, 'nitro downloader');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(126, 'npbot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(127, 'octopus');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(128, 'offline explorer');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(129, 'offline navigator');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(130, 'openfind');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(131, 'pagegrabber');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(132, 'papa foto');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(133, 'pavuk');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(134, 'pbrowse');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(135, 'pcbrowser');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(136, 'peval');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(137, 'pompos/');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(138, 'program shareware');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(139, 'propowerbot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(140, 'prowebwalker');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(141, 'psurf');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(142, 'puf');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(143, 'puxarapido');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(144, 'queryn metasearch');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(145, 'realdownload');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(146, 'reget');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(147, 'repomonkey');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(148, 'rsurf');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(149, 'rumours-agent');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(150, 'sakura');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(151, 'scan4mail');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(152, 'semanticdiscovery');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(153, 'sitesnagger');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(154, 'slysearch');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(155, 'spankbot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(156, 'spanner ');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(157, 'spiderzilla');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(158, 'sq webscanner');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(159, 'stamina');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(160, 'star downloader');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(161, 'steeler');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(162, 'strip');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(163, 'superbot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(164, 'superhttp');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(165, 'surfbot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(166, 'suzuran');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(167, 'swbot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(168, 'szukacz');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(169, 'takeout');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(170, 'teleport');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(171, 'telesoft');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(172, 'test spider');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(173, 'the intraformant');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(174, 'thenomad');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(175, 'tighttwatbot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(176, 'titan');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(177, 'tocrawl/urldispatcher');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(178, 'true_robot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(179, 'tsurf');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(180, 'turing machine');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(181, 'turingos');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(182, 'urlblaze');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(183, 'urlgetfile');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(184, 'urly warning');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(185, 'utilmind');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(186, 'vci');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(187, 'voideye');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(188, 'web image collector');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(189, 'web sucker');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(190, 'webauto');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(191, 'webbandit');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(192, 'webcapture');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(193, 'webcollage');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(194, 'webcopier');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(195, 'webenhancer');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(196, 'webfetch');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(197, 'webgo');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(198, 'webleacher');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(199, 'webmasterworldforumbot');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(200, 'webql');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(201, 'webreaper');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(202, 'website extractor');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(203, 'website quester');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(204, 'webster');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(205, 'webstripper');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(206, 'webwhacker');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(207, 'wep search');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(208, 'wget');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(209, 'whizbang');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(210, 'widow');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(211, 'wildsoft surfer');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(212, 'www-collector-e');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(213, 'www.netwu.com');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(214, 'wwwoffle');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(215, 'xaldon');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(216, 'xenu');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(217, 'zeus');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(218, 'ziggy');
INSERT INTO $prefix.`_nsnst_harvesters` (`hid`, `harvester`) VALUES(219, 'zippy');

DROP TABLE IF EXISTS $prefix.`_nsnst_ip2country`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_ip2country` ( `ip_lo` int(10) unsigned NOT NULL default '0', `ip_hi` int(10) unsigned NOT NULL default '0', `date` int(20) NOT NULL default '0', `c2c` char(2) NOT NULL default '', PRIMARY KEY  (`ip_lo`,`ip_hi`,`c2c`), UNIQUE KEY `c2c` (`c2c`,`ip_hi`,`ip_lo`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnst_protected_ranges`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_protected_ranges` ( `ip_lo` int(10) unsigned NOT NULL default '0', `ip_hi` int(10) unsigned NOT NULL default '0', `date` int(20) NOT NULL default '0', `notes` text NOT NULL, `c2c` char(2) NOT NULL default '00', PRIMARY KEY  (`ip_lo`,`ip_hi`), KEY `c2c` (`c2c`), KEY `date` (`date`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnst_referers`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_referers` ( `rid` int(2) NOT NULL auto_increment, `referer` varchar(255) NOT NULL default '', PRIMARY KEY  (`referer`), KEY `rid` (`rid`)) ENGINE=InnoDB;
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(1, '121hr.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(2, '1st-call.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(3, '1stcool.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(4, '5000n.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(5, '69-xxx.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(6, '9irl.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(7, '9uy.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(8, 'a-day-at-the-party.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(9, 'accessthepeace.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(10, 'adult-model-nude-pictures.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(11, 'adult-sex-toys-free-porn.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(12, 'agnitum.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(13, 'alfonssackpfeiffe.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(14, 'alongwayfrommars.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(15, 'anime-sex-1.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(16, 'anorex-sf-stimulant-free.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(17, 'antibot.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(18, 'antique-tokiwa.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(19, 'apotheke-heute.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(20, 'armada31.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(21, 'artark.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(22, 'artlilei.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(23, 'ascendbtg.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(24, 'aschalaecheck.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(25, 'asian-sex-free-sex.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(26, 'aslowspeeker.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(27, 'assasinatedfrogs.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(28, 'athirst-for-tranquillity.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(29, 'aubonpanier.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(30, 'avalonumc.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(31, 'ayingba.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(32, 'bayofnoreturn.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(33, 'bbw4phonesex.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(34, 'beersarenotfree.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(35, 'bierikiuetsch.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(36, 'bilingualannouncements.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(37, 'black-pussy-toon-clip-anal-lover-single.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(38, 'blownapart.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(39, 'blueroutes.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(40, 'boasex.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(41, 'booksandpages.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(42, 'bootyquake.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(43, 'bossyhunter.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(44, 'boyz-sex.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(45, 'brokersaandpokers.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(46, 'browserwindowcleaner.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(47, 'budobytes.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(48, 'business2fun.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(49, 'buymyshitz.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(50, 'byuntaesex.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(51, 'caniputsomeloveintoyou.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(52, 'cartoons.net.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(53, 'caverunsailing.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(54, 'certainhealth.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(55, 'clantea.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(56, 'close-protection-services.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(57, 'clubcanino.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(58, 'clubstic.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(59, 'cobrakai-skf.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(60, 'collegefucktour.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(61, 'commanderspank.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(62, 'coolenabled.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(63, 'crusecountryart.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(64, 'crusingforsex.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(65, 'cunt-twat-pussy-juice-clit-licking.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(66, 'customerhandshaker.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(67, 'cyborgrama.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(68, 'darkprofits.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(69, 'datingforme.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(70, 'datingmind.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(71, 'degree.org.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(72, 'delorentos.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(73, 'diggydigger.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(74, 'dinkydonkyaussie.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(75, 'djpritchard.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(76, 'djtop.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(77, 'draufgeschissen.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(78, 'dreamerteens.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(79, 'ebonyarchives.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(80, 'ebonyplaya.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(81, 'ecobuilder2000.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(82, 'emailandemail.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(83, 'emedici.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(84, 'engine-on-fire.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(85, 'erocity.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(86, 'esport3.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(87, 'eteenbabes.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(88, 'eurofreepages.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(89, 'eurotexans.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(90, 'evolucionweb.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(91, 'fakoli.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(92, 'fe4ba.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(93, 'ferienschweden.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(94, 'findly.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(95, 'firsttimeteadrinker.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(96, 'fishing.net.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(97, 'flatwonkers.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(98, 'flowershopentertainment.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(99, 'flymario.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(100, 'free-xxx-pictures-porno-gallery.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(101, 'freebestporn.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(102, 'freefuckingmovies.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(103, 'freexxxstuff.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(104, 'fruitologist.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(105, 'fruitsandbolts.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(106, 'fuck-cumshots-free-midget-movie-clips.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(107, 'fuck-michaelmoore.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(108, 'fundacep.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(109, 'gadless.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(110, 'gallapagosrangers.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(111, 'galleries4free.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(112, 'galofu.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(113, 'gaypixpost.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(114, 'geomasti.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(115, 'girltime.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(116, 'glassrope.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(117, 'godjustblessyouall.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(118, 'goldenageresort.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(119, 'gonnabedaddies.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(120, 'granadasexi.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(121, 'guardingtheangels.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(122, 'guyprofiles.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(123, 'happy1225.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(124, 'happychappywacky.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(125, 'health.org.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(126, 'hexplas.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(127, 'highheelsmodels4fun.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(128, 'hillsweb.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(129, 'hiptuner.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(130, 'historyintospace.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(131, 'hoa-tuoi.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(132, 'homebuyinginatlanta.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(133, 'horizonultra.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(134, 'horseminiature.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(135, 'hotkiss.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(136, 'hotlivegirls.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(137, 'hotmatchup.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(138, 'husler.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(139, 'iaentertainment.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(140, 'iamnotsomeone.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(141, 'iconsofcorruption.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(142, 'ihavenotrustinyou.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(143, 'informat-systems.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(144, 'interiorproshop.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(145, 'intersoftnetworks.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(146, 'inthecrib.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(147, 'investment4cashiers.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(148, 'iti-trailers.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(149, 'jackpot-hacker.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(150, 'jacks-world.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(151, 'jamesthesailorbasher.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(152, 'jesuislemonds.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(153, 'justanotherdomainname.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(154, 'kampelicka.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(155, 'kanalrattenarsch.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(156, 'katzasher.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(157, 'kerosinjunkie.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(158, 'killasvideo.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(159, 'koenigspisser.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(160, 'kontorpara.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(161, 'l8t.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(162, 'laestacion101.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(163, 'lambuschlamppen.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(164, 'lankasex.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(165, 'laser-creations.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(166, 'le-tour-du-monde.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(167, 'lecraft.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(168, 'ledo-design.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(169, 'leftregistration.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(170, 'lekkikoomastas.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(171, 'lepommeau.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(172, 'libr-animal.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(173, 'libraries.org.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(174, 'likewaterlikewind.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(175, 'limbojumpers.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(176, 'link.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(177, 'lockportlinks.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(178, 'loiproject.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(179, 'longtermalternatives.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(180, 'lottoeco.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(181, 'lucalozzi.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(182, 'maki-e-pens.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(183, 'malepayperview.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(184, 'mangaxoxo.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(185, 'maps.org.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(186, 'marcofields.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(187, 'masterofcheese.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(188, 'masteroftheblasterhill.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(189, 'mastheadwankers.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(190, 'megafrontier.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(191, 'meinschuppen.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(192, 'mercurybar.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(193, 'metapannas.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(194, 'micelebre.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(195, 'midnightlaundries.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(196, 'mikeapartment.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(197, 'millenniumchorus.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(198, 'mimundial2002.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(199, 'miniaturegallerymm.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(200, 'mixtaperadio.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(201, 'mondialcoral.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(202, 'monja-wakamatsu.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(203, 'monstermonkey.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(204, 'mouthfreshners.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(205, 'mullensholiday.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(206, 'musilo.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(207, 'myhollowlog.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(208, 'myhomephonenumber.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(209, 'mykeyboardisbroken.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(210, 'mysofia.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(211, 'naked-cheaters.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(212, 'naked-old-women.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(213, 'nastygirls.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(214, 'nationclan.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(215, 'natterratter.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(216, 'naughtyadam.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(217, 'nestbeschmutzer.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(218, 'netwu.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(219, 'newrealeaseonline.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(220, 'newrealeasesonline.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(221, 'nextfrontiersonline.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(222, 'nikostaxi.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(223, 'notorious7.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(224, 'nrecruiter.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(225, 'nursingdepot.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(226, 'nustramosse.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(227, 'nuturalhicks.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(228, 'occaz-auto49.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(229, 'ocean-db.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(230, 'oilburnerservice.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(231, 'omburo.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(232, 'oneoz.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(233, 'onepageahead.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(234, 'onlinewithaline.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(235, 'organizate.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(236, 'ourownweddingsong.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(237, 'owen-music.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(238, 'p-partners.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(239, 'paginadeautor.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(240, 'pakistandutyfree.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(241, 'pamanderson.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(242, 'parentsense.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(243, 'particlewave.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(244, 'pay-clic.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(245, 'pay4link.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(246, 'pcisp.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(247, 'persist-pharma.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(248, 'peteband.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(249, 'petplusindia.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(250, 'pickabbw.co.uk');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(251, 'picture-oral-position-lesbian.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(252, 'pl8again.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(253, 'planeting.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(254, 'popusky.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(255, 'porn-expert.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(256, 'promoblitza.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(257, 'proproducts-usa.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(258, 'ptcgzone.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(259, 'ptporn.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(260, 'publishmybong.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(261, 'puttingtogether.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(262, 'qualifiedcancelations.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(263, 'rahost.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(264, 'rainbow21.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(265, 'rakkashakka.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(266, 'randomfeeding.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(267, 'rape-art.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(268, 'rd-brains.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(269, 'realestateonthehill.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(270, 'rebuscadobot');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(271, 'requested-stuff.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(272, 'retrotrasher.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(273, 'ricopositive.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(274, 'risorseinrete.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(275, 'rotatingcunts.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(276, 'runawayclicks.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(277, 'rutalibre.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(278, 's-marche.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(279, 'sabrosojazz.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(280, 'samuraidojo.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(281, 'sanaldarbe.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(282, 'sasseminars.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(283, 'schlampenbruzzler.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(284, 'searchmybong.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(285, 'seckur.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(286, 'sex-asian-porn-interracial-photo.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(287, 'sex-porn-fuck-hardcore-movie.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(288, 'sexa3.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(289, 'sexer.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(290, 'sexintention.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(291, 'sexnet24.tv');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(292, 'sexomundo.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(293, 'sharks.com.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(294, 'shells.com.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(295, 'shop-ecosafe.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(296, 'shop-toon-hardcore-fuck-cum-pics.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(297, 'silverfussions.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(298, 'sin-city-sex.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(299, 'sluisvan.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(300, 'smutshots.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(301, 'snagglersmaggler.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(302, 'somethingtoforgetit.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(303, 'sophiesplace.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(304, 'soursushi.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(305, 'southernxstables.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(306, 'speed467.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(307, 'speedpal4you.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(308, 'sporty.org.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(309, 'stopdriving.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(310, 'stw.org.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(311, 'sufficientlife.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(312, 'sussexboats.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(313, 'swinger-party-free-dating-porn-sluts.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(314, 'sydneyhay.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(315, 'szmjht.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(316, 'teninchtrout.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(317, 'thebalancedfruits.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(318, 'theendofthesummit.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(319, 'thiswillbeit.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(320, 'thosethosethose.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(321, 'ticyclesofindia.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(322, 'tits-gay-fagot-black-tits-bigtits-amateur.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(323, 'tonius.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(324, 'toohsoft.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(325, 'toolvalley.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(326, 'tooporno.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(327, 'toosexual.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(328, 'torngat.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(329, 'tour.org.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(330, 'towneluxury.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(331, 'trafficmogger.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(332, 'triacoach.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(333, 'trottinbob.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(334, 'tttframes.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(335, 'tvjukebox.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(336, 'undercvr.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(337, 'unfinished-desires.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(338, 'unicornonero.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(339, 'unionvillefire.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(340, 'upsandowns.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(341, 'upthehillanddown.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(342, 'vallartavideo.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(343, 'vietnamdatingservices.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(344, 'vinegarlemonshots.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(345, 'vizy.net.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(346, 'vnladiesdatingservices.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(347, 'vomitandbusted.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(348, 'walkingthewalking.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(349, 'well-I-am-the-type-of-boy.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(350, 'whales.com.ru');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(351, 'whincer.net');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(352, 'whitpagesrippers.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(353, 'whois.sc');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(354, 'wipperrippers.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(355, 'wordfilebooklets.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(356, 'world-sexs.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(357, 'xsay.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(358, 'xxxchyangel.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(359, 'xxxx:');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(360, 'xxxzips.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(361, 'youarelostintransit.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(362, 'yuppieslovestocks.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(363, 'yuzhouhuagong.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(364, 'zhaori-food.com');
INSERT INTO $prefix.`_nsnst_referers` (`rid`, `referer`) VALUES(365, 'zwiebelbacke.com');

DROP TABLE IF EXISTS $prefix.`_nsnst_strings`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_strings` ( `sid` int(2) NOT NULL auto_increment, `string` varchar(255) NOT NULL default '', PRIMARY KEY  (`string`), KEY `sid` (`sid`)) ENGINE=InnoDB;

DROP TABLE IF EXISTS $prefix.`_nsnst_tracked_ips`;
CREATE TABLE IF NOT EXISTS $prefix.`_nsnst_tracked_ips` ( `tid` int(10) NOT NULL auto_increment, `ip_addr` varchar(15) NOT NULL default '', `ip_long` int(10) unsigned NOT NULL default '0', `user_id` int(11) NOT NULL default '1', `username` varchar(60) NOT NULL default '', `user_agent` text NOT NULL, `refered_from` text NOT NULL, `date` int(20) NOT NULL default '0', `page` text NOT NULL, `x_forward_for` varchar(32) NOT NULL default '',  `client_ip` varchar(32) NOT NULL default '', `remote_addr` varchar(32) NOT NULL default '', `remote_port` varchar(11) NOT NULL default '', `request_method` varchar(10) NOT NULL default '',  `c2c` char(2) NOT NULL default '00', PRIMARY KEY  (`tid`), KEY `ip_addr` (`ip_addr`), KEY `ip_long` (`ip_long`), KEY `user_id` (`user_id`), KEY `username` (`username`), KEY `user_agent` (`user_agent`(255)), KEY `refered_from` (`refered_from`(255)), KEY `date` (`date`), KEY `page` (`page`(255)), KEY `c2c` (`c2c`)) ENGINE=InnoDB;

/* New Password UPDATE */
ALTER TABLE `nuke_authors` CHANGE `pwd` `pwd` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `nuke_users` CHANGE `user_password` `user_password` VARCHAR(255) NOT NULL;