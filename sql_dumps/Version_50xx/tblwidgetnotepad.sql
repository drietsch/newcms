CREATE TABLE IF NOT EXISTS `tblwidgetnotepad` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `tblwidgetnotepad` VALUES (1, 'Sonstiges', 1, '2007-05-24', 'Willkommen bei webEdition 5', 'Das Cockpit ist eine der Neuerungen in Version 5. Sie können im Cockpit-Menü verschiedene Widgets auswählen. Jedes Widget ist über die obere Leiste "Eigenschaften" konfigurierbar und kann frei positioniert werden.', 'low', 'always', '2007-06-04', '2007-06-04');