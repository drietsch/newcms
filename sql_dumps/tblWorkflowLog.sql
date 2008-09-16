CREATE TABLE tblWorkflowLog (
  ID bigint(20) NOT NULL auto_increment,
  RefID bigint(20) NOT NULL default '0',
  docTable varchar(255) NOT NULL default '',
  userID bigint(20) NOT NULL default '0',
  logDate bigint(20) NOT NULL default '0',
  `Type` tinyint(4) NOT NULL default '0',
  Description varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
