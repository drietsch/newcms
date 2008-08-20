CREATE TABLE tblWebUser (
  ID bigint(20) NOT NULL auto_increment,
  Username varchar(255) NOT NULL default '',
  `Password` varchar(255) NOT NULL default '',
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
  LoginDenied tinyint(1) NOT NULL default '0',
  MemberSince varchar(24) NOT NULL default '',
  LastLogin varchar(24) NOT NULL default '',
  LastAccess varchar(24) NOT NULL default '',
  ParentID bigint(20) NOT NULL default '0',
  Path varchar(255) default NULL,
  IsFolder tinyint(1) default NULL,
  Icon varchar(255) default NULL,
  `Text` varchar(255) default NULL,
  Newsletter_Ok varchar(200) NOT NULL default '',
  Newsletter_HTMLNewsletter varchar(200) NOT NULL default '',
  Gruppe varchar(200) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
/* query separator */
INSERT INTO tblWebUser VALUES (1,'admin','admin','','','living-e','AG','Amalienstrasse 81-87','76133 Karlsruhe','Baden-Württemberg','Deutschland','','','','','',0,'1144395493','1144397956','1144397956',0,'/admin',0,'customer.gif','admin','','','Administratoren');
/* query separator */
INSERT INTO tblWebUser VALUES (2,'customer','customer','','','web','user','webland','universe','Saarland','','','','','','',0,'0','0','0',0,'/customer',0,'customer.gif','customer','','','Kunden');