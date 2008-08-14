CREATE TABLE tblWorkflowDocTask (
  ID int(11) NOT NULL auto_increment,
  documentStepID bigint(20) NOT NULL default '0',
  workflowTaskID bigint(20) NOT NULL default '0',
  `Date` bigint(20) NOT NULL default '0',
  todoID bigint(20) NOT NULL default '0',
  `Status` int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
