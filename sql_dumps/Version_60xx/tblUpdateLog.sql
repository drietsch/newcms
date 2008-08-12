CREATE TABLE tblUpdateLog (
  ID int(255) NOT NULL auto_increment,
  dortigeID int(255) NOT NULL default '0',
  datum datetime default NULL,
  aktion text NOT NULL,
  versionsnummer varchar(10) NOT NULL default '',
  module text NOT NULL,
  error tinyint(1) NOT NULL default '0',
  step int(4) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
