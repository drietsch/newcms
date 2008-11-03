CREATE TABLE tblMsgSettings (
  ID int(11) NOT NULL auto_increment,
  UserID int(11) NOT NULL default '0',
  strKey varchar(255) default NULL,
  strVal varchar(255) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
