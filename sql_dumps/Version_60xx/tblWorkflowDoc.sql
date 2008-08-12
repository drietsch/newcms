CREATE TABLE tblWorkflowDoc (
  ID int(11) NOT NULL auto_increment,
  workflowID int(11) NOT NULL default '0',
  documentID int(11) NOT NULL default '0',
  userID int(11) NOT NULL default '0',
  `Status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
