CREATE TABLE tblvoting (
  ID bigint(20) NOT NULL auto_increment,
  ParentID bigint(20) NOT NULL default '0',
  Path varchar(255) default NULL,
  IsFolder tinyint(1) default '0',
  Icon varchar(255) default 'link.gif',
  Text varchar(255) NOT NULL default '',
  PublishDate bigint(20) NOT NULL default '0',
  QASet text NOT NULL,
  Scores text NOT NULL,
  RevoteControl tinyint(1) NOT NULL default '0',
  RevoteTime int(11) NOT NULL default '0',
  Owners text NOT NULL,
  RestrictOwners tinyint(1) NOT NULL default '0',
  Revote longtext NOT NULL,
  Valid bigint(20) NOT NULL default '0',
  Active tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;