CREATE TABLE tblErrorLog (
  ID int(11) NOT NULL auto_increment,
  `Text` text NOT NULL,
  `Date` int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
