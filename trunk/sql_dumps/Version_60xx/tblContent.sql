CREATE TABLE tblContent (
  ID bigint(20) NOT NULL auto_increment,
  BDID int(11) NOT NULL default '0',
  Dat longtext,
  IsBinary tinyint(4) NOT NULL default '0',
  AutoBR char(3) NOT NULL default '',
  LanguageID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
