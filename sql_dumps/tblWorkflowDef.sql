CREATE TABLE tblWorkflowDef (
  ID int(11) NOT NULL auto_increment,
  `Text` varchar(255) NOT NULL default '',
  `Type` bigint(20) NOT NULL default '0',
  Folders varchar(255) NOT NULL default '',
  DocType bigint(20) NOT NULL default '0',
  Objects varchar(255) NOT NULL default '',
  Categories varchar(255) NOT NULL default '',
  ObjCategories varchar(255) NOT NULL default '',
  `Status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
