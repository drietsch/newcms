# MySQL dump 8.13
#
# Host: localhost    Database: we_andy_clean_de
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

INSERT INTO tblWebAdmin VALUES ('FieldAdds','a:9:{s:13:\"Newsletter_Ok\";a:1:{s:7:\"default\";s:3:\",ja\";}s:25:\"Newsletter_HTMLNewsletter\";a:1:{s:7:\"default\";s:3:\",ja\";}s:17:\"Kontakt_Addresse1\";a:1:{s:7:\"default\";s:0:\"\";}s:17:\"Kontakt_Addresse2\";a:1:{s:7:\"default\";s:0:\"\";}s:18:\"Kontakt_Bundesland\";a:1:{s:7:\"default\";s:214:\"Baden-Württemberg,Bayern,Berlin,Brandenburg,Bremen,Hamburg,Hessen,Mecklenburg-Vorpommern,Niedersachsen,Nordrhein-Westfalen,Rheinland-PfalzRheinland-Pfalz,Saarland,Sachsen,Sachsen-Anhalt,Schleswig-Holstein,Thüringen\";}s:12:\"Kontakt_Land\";a:1:{s:7:\"default\";s:0:\"\";}s:13:\"Anrede_Anrede\";a:1:{s:7:\"default\";s:10:\",Herr,Frau\";}s:12:\"Anrede_Titel\";a:1:{s:7:\"default\";s:11:\",Dr., Prof.\";}s:6:\"Gruppe\";a:1:{s:7:\"default\";s:22:\"Administratoren,Kunden\";}}');
INSERT INTO tblWebAdmin VALUES ('SortView','a:1:{s:6:\"Gruppe\";a:1:{i:0;a:4:{s:6:\"branch\";s:8:\"Sonstige\";s:5:\"field\";s:6:\"Gruppe\";s:8:\"function\";s:0:\"\";s:5:\"order\";s:3:\"ASC\";}}}');
INSERT INTO tblWebAdmin VALUES ('Prefs','a:2:{s:10:\"start_year\";s:4:\"1900\";s:17:\"default_sort_view\";s:6:\"Gruppe\";}');

#
# Table structure for table 'tblWebUser'
#

CREATE TABLE tblWebUser (
  ID bigint(20) NOT NULL auto_increment,
  Username varchar(32) NOT NULL default '',
  Password varchar(32) NOT NULL default '',
  Anrede_Anrede varchar(200) NOT NULL default '',
  Anrede_Titel varchar(200) NOT NULL default '',
  Forename varchar(128) NOT NULL default '',
  Surname varchar(128) NOT NULL default '',
  Kontakt_Addresse1 varchar(255) NOT NULL default '',
  Kontakt_Addresse2 varchar(255) NOT NULL default '',
  Kontakt_Bundesland varchar(200) NOT NULL default '',
  Kontakt_Land varchar(255) NOT NULL default '',
  Kontakt_Tel1 varchar(64) NOT NULL default '',
  Kontakt_Tel2 varchar(64) NOT NULL default '',
  Kontakt_Tel3 varchar(64) NOT NULL default '',
  Kontakt_Email varchar(128) NOT NULL default '',
  Kontakt_Homepage varchar(128) NOT NULL default '',
  MemberSince varchar(24) NOT NULL default '0',
  LastLogin varchar(24) NOT NULL default '0',
  LastAccess varchar(24) NOT NULL default '0',
  ParentID bigint(20) NOT NULL default '0',
  Path varchar(255) default '',
  IsFolder tinyint(1) default '0',
  Icon varchar(255) default 'customer.gif',
  Text varchar(255) default '',
  Newsletter_Ok varchar(200) NOT NULL default '',
  Newsletter_HTMLNewsletter varchar(200) NOT NULL default '',
  Gruppe varchar(200) NOT NULL default '',
  PRIMARY KEY  (ID),
  KEY Username (Username),
  KEY user_pass (Username,Password),
  KEY Email (Kontakt_Email),
  KEY LastAccess (LastAccess)
) TYPE=MyISAM;

#
# Dumping data for table 'tblWebUser'
#

INSERT INTO tblWebUser VALUES (1,'admin','admin','','','webEdition','Software GmbH','Waldstrasse 40b','76133 Karlsruhe','Baden-Württemberg','Deutschland','','','','','',0,1076608366,1076608413,0,'/admin',0,'customer.gif','admin','','','Administratoren');
INSERT INTO tblWebUser VALUES (2,'customer','customer','','','web','user','webland','universe','Saarland','','','','','','',0,0,0,0,'/customer',0,'customer.gif','customer','','','Kunden');

