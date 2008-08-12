# MySQL dump 8.13
#
# Host: localhost    Database: we_andy_clean_en
#--------------------------------------------------------
# Server version	3.23.37-log

#
# Table structure for table 'tblWebAdmin'
#

CREATE TABLE tblWebAdmin (
  Name varchar(255) NOT NULL default '',
  Value text NOT NULL
) TYPE=MyISAM;

#
# Dumping data for table 'tblWebAdmin'
#

INSERT INTO tblWebAdmin VALUES ('FieldAdds','a:5:{s:13:\"Newsletter_Ok\";a:1:{s:7:\"default\";s:4:\",yes\";}s:19:\"Newsletter_HTMLMail\";a:1:{s:7:\"default\";s:4:\",yes\";}s:21:\"Salutation_Salutation\";a:1:{s:7:\"default\";s:8:\",Mr.,Ms.\";}s:16:\"Salutation_Title\";a:1:{s:7:\"default\";s:11:\",Dr., Prof.\";}s:9:\"UserGroup\";a:1:{s:7:\"default\";s:12:\"Admins,Users\";}}');
INSERT INTO tblWebAdmin VALUES ('SortView','a:1:{s:9:\"UserGroup\";a:1:{i:0;a:4:{s:6:\"branch\";s:5:\"Other\";s:5:\"field\";s:9:\"UserGroup\";s:8:\"function\";s:0:\"\";s:5:\"order\";s:3:\"ASC\";}}}');
INSERT INTO tblWebAdmin VALUES ('Prefs','a:2:{s:10:\"start_year\";s:4:\"1900\";s:17:\"default_sort_view\";s:9:\"UserGroup\";}');

#
# Table structure for table 'tblWebUser'
#

CREATE TABLE tblWebUser (
  ID bigint(20) NOT NULL auto_increment,
  Username varchar(32) NOT NULL default '',
  Password varchar(32) NOT NULL default '',
  Salutation_Salutation varchar(200) NOT NULL default '',
  Salutation_Title varchar(200) NOT NULL default '',
  Forename varchar(128) NOT NULL default '',
  Surname varchar(128) NOT NULL default '',
  Contact_Address1 varchar(128) NOT NULL default '',
  Contact_Address2 varchar(128) NOT NULL default '',
  Contact_Country varchar(128) NOT NULL default '',
  Contact_State varchar(128) NOT NULL default '',
  Contact_Tel1 varchar(64) NOT NULL default '',
  Contact_Tel2 varchar(64) NOT NULL default '',
  Contact_Tel3 varchar(64) NOT NULL default '',
  Contact_Email varchar(128) NOT NULL default '',
  Contact_Homepage varchar(128) NOT NULL default '',
  MemberSince varchar(24) NOT NULL default '0',
  LastLogin varchar(24) NOT NULL default '0',
  LastAccess varchar(24) NOT NULL default '0',
  ParentID bigint(20) NOT NULL default '0',
  Path varchar(255) default '',
  IsFolder tinyint(1) default '0',
  Icon varchar(255) default 'customer.gif',
  Text varchar(255) default '',
  Newsletter_Ok varchar(200) NOT NULL default '',
  Newsletter_HTMLMail varchar(200) NOT NULL default '',
  UserGroup varchar(200) NOT NULL default '',
  PRIMARY KEY  (ID),
  KEY Username (Username),
  KEY user_pass (Username,Password),
  KEY Email (Contact_Email),
  KEY LastAccess (LastAccess)
) TYPE=MyISAM;

#
# Dumping data for table 'tblWebUser'
#

INSERT INTO tblWebUser VALUES (1,'admin','admin','','','webEdition','Software GmbH','Waldstrasse 40b','D-76133 Karlsruhe','Germany','','','','','','',0,1076604226,1076604295,0,'/admin',0,'customer.gif','admin','','','Admins');
INSERT INTO tblWebUser VALUES (2,'customer','customer','','','web','user','webland','universe','reality','','','','','','',0,0,0,0,'/customer',0,'customer.gif','customer','','','Users');

