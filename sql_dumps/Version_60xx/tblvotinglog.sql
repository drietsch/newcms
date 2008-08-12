CREATE TABLE `tblvotinglog` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `voting` bigint(20) NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `ip` varchar(255) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `cookie` tinyint(1) NOT NULL,
  `fallback` tinyint(1) NOT NULL,
  `status` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM ;
