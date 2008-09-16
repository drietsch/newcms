CREATE TABLE `tblwidgetnotepad` (
  `ID` bigint(20) NOT NULL auto_increment,
  `WidgetName` varchar(100) NOT NULL default '',
  `UserID` bigint(20) NOT NULL default '0',
  `CreationDate` date NOT NULL default '0000-00-00',
  `Title` varchar(255) NOT NULL default '',
  `Text` text NOT NULL,
  `Priority` enum('low','medium','high') NOT NULL default 'low',
  `Valid` enum('always','date','period') NOT NULL default 'always',
  `ValidFrom` date NOT NULL default '0000-00-00',
  `ValidUntil` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;
/* query separator */
INSERT INTO `tblwidgetnotepad` VALUES (1, 'webEdition', 1, '2008-08-20', 'Welcome to webEdition!', '', 'low', 'always', '2008-08-20', '2008-08-20');