CREATE TABLE tblWorkflowStep (
  ID int(11) NOT NULL auto_increment,
  Worktime int(11) NOT NULL default '0',
  timeAction tinyint(1) NOT NULL default '0',
  stepCondition int(11) NOT NULL default '0',
  workflowID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
