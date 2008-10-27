CREATE TABLE `tblcustomerfilter` (
  `id` bigint(20) NOT NULL auto_increment,
  `modelId` bigint(20) NOT NULL,
  `modelType` varchar(32) NOT NULL,
  `modelTable` varchar(64) NOT NULL,
  `accessControlOnTemplate` tinyint(1) NOT NULL default '0',
  `errorDocNoLogin` bigint(20) NOT NULL default '0',
  `errorDocNoAccess` bigint(20) NOT NULL default '0',
  `mode` tinyint(4) NOT NULL default '0',
  `specificCustomers` text NOT NULL,
  `filter` text NOT NULL,
  `whiteList` text NOT NULL,
  `blackList` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `mode` (`mode`,`specificCustomers`(330)),
  KEY `modelId` (`modelId`,`modelType`,`modelTable`),
  KEY `accessControlOnTemplate` (`accessControlOnTemplate`)
) TYPE=MyISAM;
