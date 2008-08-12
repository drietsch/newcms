# MySQL dump 8.13
#
# Host: localhost    Database: we_andy_clean_de
#--------------------------------------------------------
# Server version	3.23.37-log

#
# Table structure for table 'tblMessages'
#

CREATE TABLE tblMessages (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) default '0',
  UserID int(11) default NULL,
  msg_type tinyint(4) NOT NULL default '0',
  obj_type tinyint(4) NOT NULL default '0',
  headerDate int(11) default NULL,
  headerSubject varchar(255) default NULL,
  headerUserID int(11) default NULL,
  headerFrom varchar(255) default NULL,
  headerTo varchar(255) default NULL,
  Priority tinyint(4) default NULL,
  seenStatus tinyint(4) unsigned default '0',
  MessageText text,
  tag tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ID),
  KEY ID (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblMessages'
#


#
# Table structure for table 'tblMsgAccounts'
#

CREATE TABLE tblMsgAccounts (
  ID int(11) NOT NULL auto_increment,
  UserID int(11) default NULL,
  name varchar(255) NOT NULL default '',
  msg_type int(11) default NULL,
  deletable tinyint(4) NOT NULL default '1',
  uri varchar(255) default NULL,
  user varchar(255) default NULL,
  pass varchar(255) default NULL,
  update_interval smallint(5) unsigned NOT NULL default '0',
  ext varchar(255) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblMsgAccounts'
#


#
# Table structure for table 'tblMsgAddrbook'
#

CREATE TABLE tblMsgAddrbook (
  ID int(11) NOT NULL auto_increment,
  UserID int(11) default NULL,
  strMsgType varchar(255) default NULL,
  strID varchar(255) default NULL,
  strAlias varchar(255) NOT NULL default '',
  strFirstname varchar(255) default NULL,
  strSurname varchar(255) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblMsgAddrbook'
#


#
# Table structure for table 'tblMsgFolders'
#

CREATE TABLE tblMsgFolders (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) default '0',
  UserID int(11) NOT NULL default '0',
  account_id int(11) default '-1',
  msg_type tinyint(4) NOT NULL default '0',
  obj_type tinyint(4) NOT NULL default '0',
  Name varchar(255) NOT NULL default '',
  sortItem varchar(255) default NULL,
  sortOrder varchar(5) default NULL,
  Properties int(10) unsigned default '0',
  tag tinyint(4) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblMsgFolders'
#

INSERT INTO tblMsgFolders VALUES (1,0,1,-1,1,3,'Messages',NULL,NULL,1,NULL);
INSERT INTO tblMsgFolders VALUES (2,1,1,-1,1,5,'Sent',NULL,NULL,1,NULL);
INSERT INTO tblMsgFolders VALUES (3,0,1,-1,2,3,'Task',NULL,NULL,1,NULL);
INSERT INTO tblMsgFolders VALUES (4,3,1,-1,2,13,'Done',NULL,NULL,1,NULL);
INSERT INTO tblMsgFolders VALUES (5,3,1,-1,2,11,'rejected',NULL,NULL,1,NULL);

#
# Table structure for table 'tblMsgSettings'
#

CREATE TABLE tblMsgSettings (
  ID int(11) NOT NULL auto_increment,
  UserID int(11) NOT NULL default '0',
  strKey varchar(255) default NULL,
  strVal varchar(255) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblMsgSettings'
#


#
# Table structure for table 'tblTODO'
#

CREATE TABLE tblTODO (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) default NULL,
  UserID int(11) NOT NULL default '0',
  account_id int(11) NOT NULL default '-1',
  msg_type tinyint(4) NOT NULL default '0',
  obj_type tinyint(4) NOT NULL default '0',
  headerDate int(11) default NULL,
  headerSubject varchar(255) default NULL,
  headerCreator int(11) default NULL,
  headerAssigner int(11) default NULL,
  headerStatus tinyint(4) default '0',
  headerDeadline int(11) default NULL,
  Priority tinyint(4) default NULL,
  Properties smallint(5) unsigned default '0',
  MessageText text,
  Content_Type varchar(10) default 'text',
  seenStatus tinyint(3) unsigned default '0',
  tag tinyint(3) unsigned default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblTODO'
#


#
# Table structure for table 'tblTODOHistory'
#

CREATE TABLE tblTODOHistory (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) NOT NULL default '0',
  UserID int(11) NOT NULL default '0',
  fromUserID int(11) NOT NULL default '0',
  Comment text,
  Created int(11) default NULL,
  action int(10) unsigned default '0',
  status tinyint(3) unsigned default NULL,
  tag tinyint(3) unsigned default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblTODOHistory'
#


