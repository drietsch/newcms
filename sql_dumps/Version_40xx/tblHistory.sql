CREATE TABLE tblhistory (
  ID bigint(20) NOT NULL auto_increment,
  DID bigint(20) NOT NULL default '0',
  DocumentTable varchar(64) NOT NULL default '',
  ContentType varchar(32) NOT NULL default '',
  ModDate bigint(20) NOT NULL default '0',
  Act varchar(16) NOT NULL default '',
  UserName varchar(64) NOT NULL default '',
  PRIMARY KEY  (ID)
) Type=MyISAM;