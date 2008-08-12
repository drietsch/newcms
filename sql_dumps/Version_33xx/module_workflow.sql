# MySQL dump 8.13
#
# Host: localhost    Database: we_andy_clean_de
#--------------------------------------------------------
# Server version	3.23.37-log

#
# Table structure for table 'tblWorkflowDef'
#

CREATE TABLE tblWorkflowDef (
  ID int(11) NOT NULL auto_increment,
  Text varchar(255) NOT NULL default '',
  Type bigint(20) NOT NULL default '0',
  Folders varchar(255) NOT NULL default '0',
  DocType bigint(20) NOT NULL default '0',
  Objects varchar(255) NOT NULL default '',
  Categories varchar(255) NOT NULL default '',
  ObjCategories varchar(255) NOT NULL default '',
  Status tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblWorkflowDef'
#


#
# Table structure for table 'tblWorkflowDoc'
#

CREATE TABLE tblWorkflowDoc (
  ID int(11) NOT NULL auto_increment,
  workflowID int(11) NOT NULL default '0',
  documentID int(11) NOT NULL default '0',
  userID int(11) NOT NULL default '0',
  Status tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblWorkflowDoc'
#


#
# Table structure for table 'tblWorkflowDocStep'
#

CREATE TABLE tblWorkflowDocStep (
  ID int(11) NOT NULL auto_increment,
  workflowDocID int(11) NOT NULL default '0',
  workflowStepID bigint(20) NOT NULL default '0',
  startDate bigint(20) NOT NULL default '0',
  finishDate bigint(20) NOT NULL default '0',
  Status tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblWorkflowDocStep'
#


#
# Table structure for table 'tblWorkflowDocTask'
#

CREATE TABLE tblWorkflowDocTask (
  ID int(11) NOT NULL auto_increment,
  documentStepID bigint(20) NOT NULL default '0',
  workflowTaskID bigint(20) NOT NULL default '0',
  Date bigint(20) NOT NULL default '0',
  todoID bigint(20) NOT NULL default '0',
  Status int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblWorkflowDocTask'
#


#
# Table structure for table 'tblWorkflowLog'
#

CREATE TABLE tblWorkflowLog (
  ID bigint(20) NOT NULL auto_increment,
  RefID bigint(20) NOT NULL default '0',
  docTable varchar(255) NOT NULL default '',
  userID bigint(20) NOT NULL default '0',
  logDate bigint(20) NOT NULL default '0',
  Type tinyint(4) NOT NULL default '0',
  Description varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID),
  UNIQUE KEY ID (ID),
  KEY ID_2 (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblWorkflowLog'
#


#
# Table structure for table 'tblWorkflowStep'
#

CREATE TABLE tblWorkflowStep (
  ID int(11) NOT NULL auto_increment,
  Worktime int(11) NOT NULL default '0',
  timeAction tinyint(1) NOT NULL default '0',
  stepCondition int(11) NOT NULL default '0',
  workflowID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID),
  KEY workflowDef (workflowID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblWorkflowStep'
#


#
# Table structure for table 'tblWorkflowTask'
#

CREATE TABLE tblWorkflowTask (
  ID int(11) NOT NULL auto_increment,
  userID int(11) NOT NULL default '0',
  Edit int(11) NOT NULL default '0',
  Mail int(11) NOT NULL default '0',
  stepID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID),
  KEY Step (stepID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblWorkflowTask'
#


