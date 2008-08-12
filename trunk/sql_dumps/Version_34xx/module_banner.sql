# MySQL dump 8.13
#
# Host: localhost    Database: we_andy_clean_de
#--------------------------------------------------------
# Server version	3.23.37-log

#
# Table structure for table 'tblbanner'
#

CREATE TABLE tblbanner (
  ID bigint(20) NOT NULL auto_increment,
  ParentID bigint(20) NOT NULL default '0',
  Text varchar(255) NOT NULL default '',
  Path varchar(255) NOT NULL default '',
  Icon varchar(64) NOT NULL default '',
  IsFolder tinyint(1) NOT NULL default '0',
  CreatorID bigint(20) NOT NULL default '0',
  CreateDate bigint(20) NOT NULL default '0',
  ModifierID bigint(20) NOT NULL default '0',
  ModifyDate bigint(20) NOT NULL default '0',
  bannerID bigint(20) NOT NULL default '0',
  bannerUrl varchar(255) NOT NULL default '',
  bannerIntID bigint(20) NOT NULL default '0',
  IntHref tinyint(1) NOT NULL default '0',
  maxShow bigint(20) NOT NULL default '0',
  maxClicks bigint(20) NOT NULL default '0',
  IsDefault tinyint(1) NOT NULL default '0',
  clickPrice double NOT NULL default '0',
  showPrice double NOT NULL default '0',
  StartOk tinyint(1) NOT NULL default '0',
  EndOk tinyint(1) NOT NULL default '0',
  StartDate bigint(20) NOT NULL default '0',
  EndDate bigint(20) NOT NULL default '0',
  FileIDs varchar(255) NOT NULL default '',
  FolderIDs varchar(255) NOT NULL default '',
  CategoryIDs varchar(255) NOT NULL default '',
  DoctypeIDs varchar(255) NOT NULL default '',
  IsActive tinyint(1) NOT NULL default '1',
  clicks bigint(20) NOT NULL default '0',
  views bigint(20) NOT NULL default '0',
  Customers varchar(255) NOT NULL default '',
  TagName varchar(255) NOT NULL default '',
  weight tinyint(2) NOT NULL default '4',
  PRIMARY KEY  (ID),
  UNIQUE KEY ID (ID),
  KEY ID_2 (ID),
  KEY IsFolder (IsFolder),
  KEY IsActive (IsActive),
  KEY IsFolder_2 (IsFolder,IsActive)
) TYPE=MyISAM;

#
# Dumping data for table 'tblbanner'
#

INSERT INTO tblbanner VALUES (1,0,'we-Banner','/we-Banner','banner.gif',0,0,0,0,0,499,'http://www.webedition.de',0,0,10000,1000,0,0,0,0,0,1069608060,1069611660,'',',417,','','',1,8,99,',1,','100x600',4);

#
# Table structure for table 'tblbannerclicks'
#

CREATE TABLE tblbannerclicks (
  ID bigint(20) NOT NULL default '0',
  Timestamp bigint(20) default NULL,
  IP varchar(30) NOT NULL default '',
  Referer varchar(255) NOT NULL default '',
  DID bigint(20) NOT NULL default '0',
  Page varchar(255) NOT NULL default '',
  KEY bannerid_date (ID,Timestamp),
  KEY date (Timestamp)
) TYPE=MyISAM;

#
# Dumping data for table 'tblbannerclicks'
#

INSERT INTO tblbannerclicks VALUES (1,1069671723,'127.0.0.1','http://127.0.0.1/we_demo/',443,'');

#
# Table structure for table 'tblbannerprefs'
#

CREATE TABLE tblbannerprefs (
  pref_name varchar(255) NOT NULL default '',
  pref_value varchar(255) NOT NULL default ''
) TYPE=MyISAM;

#
# Dumping data for table 'tblbannerprefs'
#

INSERT INTO tblbannerprefs VALUES ('DefaultBannerID','1');

#
# Table structure for table 'tblbannerviews'
#

CREATE TABLE tblbannerviews (
  ID bigint(20) NOT NULL default '0',
  Timestamp bigint(20) default NULL,
  IP varchar(30) NOT NULL default '',
  Referer varchar(255) NOT NULL default '',
  DID bigint(20) NOT NULL default '0',
  Page varchar(255) NOT NULL default '',
  KEY bannerid_date (ID,Timestamp),
  KEY date (Timestamp)
) TYPE=MyISAM;

#
# Dumping data for table 'tblbannerviews'
#

INSERT INTO tblbannerviews VALUES (1,1076608338,'127.0.0.1','http://de/webEdition/openBrowser.php?url=/webEdition/we_redirect.php%3Fid%3D443',443,'');
INSERT INTO tblbannerviews VALUES (1,1076609101,'127.0.0.1','',443,'');
INSERT INTO tblbannerviews VALUES (1,1076661137,'127.0.0.1','http://webedition.127.0.0.1/',443,'');

