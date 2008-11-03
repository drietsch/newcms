CREATE TABLE tblWorkflowDocStep (
  ID int(11) NOT NULL auto_increment,
  workflowDocID int(11) NOT NULL default '0',
  workflowStepID bigint(20) NOT NULL default '0',
  startDate bigint(20) NOT NULL default '0',
  finishDate bigint(20) NOT NULL default '0',
  `Status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
