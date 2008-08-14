CREATE TABLE tblContentTypes (
  OrderNr int(11) NOT NULL default '0',
  ContentType varchar(32) NOT NULL default '',
  Extension varchar(128) NOT NULL default '',
  DefaultCode text NOT NULL,
  IconID int(11) NOT NULL default '0',
  Template tinyint(4) NOT NULL default '0',
  `File` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ContentType)
) TYPE=MyISAM;
