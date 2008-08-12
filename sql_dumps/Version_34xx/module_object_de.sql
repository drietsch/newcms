# MySQL dump 8.13
#
# Host: localhost    Database: we_andy_clean_de
#--------------------------------------------------------
# Server version	3.23.37-log

#
# Table structure for table 'tblObject'
#

CREATE TABLE tblObject (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) NOT NULL default '0',
  strOrder text NOT NULL,
  Text varchar(255) NOT NULL default '',
  Icon varchar(64) NOT NULL default '',
  IsFolder tinyint(4) NOT NULL default '0',
  ContentType varchar(32) NOT NULL default '0',
  CreationDate int(11) NOT NULL default '0',
  ModDate int(11) NOT NULL default '0',
  Path varchar(255) NOT NULL default '',
  CreatorID bigint(20) NOT NULL default '0',
  ModifierID bigint(20) NOT NULL default '0',
  RestrictOwners tinyint(1) NOT NULL default '0',
  Owners varchar(255) NOT NULL default '',
  OwnersReadOnly text NOT NULL,
  RestrictUsers tinyint(1) NOT NULL default '0',
  Users varchar(255) NOT NULL default '',
  UsersReadOnly text NOT NULL,
  DefaultCategory varchar(255) NOT NULL default '',
  DefaultParentID bigint(20) NOT NULL default '0',
  DefaultText varchar(255) NOT NULL default '',
  DefaultValues longtext NOT NULL,
  DefaultDesc varchar(255) NOT NULL default '',
  DefaultTitle varchar(255) NOT NULL default '',
  ClassName varchar(64) NOT NULL default '',
  Workspaces varchar(255) NOT NULL default '',
  Templates varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblObject'
#

INSERT INTO tblObject VALUES (1,0,'0,1,2,3,4,5,6,7','adressen','object.gif',0,'object',1030117297,1030118929,'/adressen',1,1,0,'','',0,'','','',0,'','a:8:{s:11:\"input_Name1\";a:10:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:8:\"uniqueID\";s:32:\"d2003e1cfa23d4fa65a7b65ee7367d9f\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:11:\"input_Name2\";a:10:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:0:\"\";s:8:\"uniqueID\";s:32:\"73d07087298e8831948873f8a588f110\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:13:\"input_Strasse\";a:10:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:8:\"uniqueID\";s:32:\"9fc5e1a8fe0bb162481bc34fc5624c39\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:9:\"input_PLZ\";a:10:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:8:\"uniqueID\";s:32:\"6c4b4b7afd6517da86f58e41228738fa\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:9:\"input_Ort\";a:10:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:8:\"uniqueID\";s:32:\"b7bdc15ab62967b7e52e427124383856\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:13:\"input_Telefon\";a:10:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:0:\"\";s:8:\"uniqueID\";s:32:\"f4dce7561924e87322742c903d770e80\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:11:\"input_Email\";a:10:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:0:\"\";s:8:\"uniqueID\";s:32:\"a5072724eac3b1eea80f15d9561b598d\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:9:\"input_URL\";a:10:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:0:\"\";s:8:\"uniqueID\";s:32:\"82c762fba08d2514266d1fe3a54644d7\";s:4:\"meta\";a:1:{s:0:\"\";N;}}}','input_Name1','input_Name1','we_object','','');
INSERT INTO tblObject VALUES (2,0,'0,1,4,2,3','veranstaltungen','object.gif',0,'object',1030209283,1040246474,'/veranstaltungen',1,1,0,'','',0,'','','',0,'%Y%_%m%_%d%_%ID%','a:6:{s:13:\"WorkspaceFlag\";s:1:\"1\";s:24:\"input_Veranstaltungsname\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"648384762b12d00e0e734f9a811b3145\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:31:\"text_Veranstaltungsbeschreibung\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";s:3:\"off\";s:9:\"dhtmledit\";s:2:\"on\";s:9:\"showmenus\";s:3:\"off\";s:10:\"forbidhtml\";s:3:\"off\";s:9:\"forbidphp\";s:2:\"on\";s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"380b1b117348d74b2e8d5fe52d24df88\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:24:\"date_Veranstaltungsdatum\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"9c42efeb4fd9dc1914f112744447a9e7\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:8:\"object_1\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"0c7b7b7af26152591992398a5eba5658\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:26:\"text_Veranstaltungsdetails\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";s:3:\"off\";s:9:\"dhtmledit\";s:2:\"on\";s:9:\"showmenus\";s:3:\"off\";s:10:\"forbidhtml\";s:3:\"off\";s:9:\"forbidphp\";s:2:\"on\";s:5:\"users\";N;s:8:\"required\";s:0:\"\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"15c932b2872fb1a48cf00462fb70c03b\";s:4:\"meta\";a:1:{s:0:\"\";N;}}}','text_Veranstaltungsbeschreibung','input_Veranstaltungsname','we_object',',302,472,',',119,,');

#
# Table structure for table 'tblObjectFiles'
#

CREATE TABLE tblObjectFiles (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) NOT NULL default '0',
  Text varchar(255) NOT NULL default '',
  Icon varchar(64) NOT NULL default '',
  IsFolder tinyint(4) NOT NULL default '0',
  ContentType varchar(32) NOT NULL default '0',
  CreationDate int(11) NOT NULL default '0',
  ModDate int(11) NOT NULL default '0',
  Path varchar(255) NOT NULL default '',
  CreatorID bigint(20) NOT NULL default '0',
  ModifierID bigint(20) NOT NULL default '0',
  RestrictOwners tinyint(1) NOT NULL default '0',
  Owners varchar(255) NOT NULL default '',
  OwnersReadOnly text NOT NULL,
  Workspaces varchar(255) NOT NULL default '',
  ExtraWorkspaces varchar(255) NOT NULL default '',
  ExtraWorkspacesSelected varchar(255) NOT NULL default '',
  Templates varchar(255) NOT NULL default '',
  ExtraTemplates varchar(255) NOT NULL default '',
  TableID bigint(20) NOT NULL default '0',
  ObjectID bigint(20) NOT NULL default '0',
  Category varchar(255) NOT NULL default '',
  ClassName varchar(64) NOT NULL default '',
  IsClassFolder tinyint(1) NOT NULL default '0',
  IsNotEditable tinyint(1) NOT NULL default '0',
  Published int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblObjectFiles'
#

INSERT INTO tblObjectFiles VALUES (12,11,'2002_08_24_12','objectFile.gif',0,'objectFile',1030209716,1040246807,'/veranstaltungen/2002_08_24_12',1,1,0,'','',',302,472,','','',',119,,','',2,3,'','we_objectFile',0,0,1040246807);
INSERT INTO tblObjectFiles VALUES (13,11,'2002_08_24_13','objectFile.gif',0,'objectFile',1030210227,1040246818,'/veranstaltungen/2002_08_24_13',1,1,0,'','',',302,472,','','',',119,,','',2,4,'','we_objectFile',0,0,1040246818);
INSERT INTO tblObjectFiles VALUES (14,11,'2002_08_24_14','objectFile.gif',0,'objectFile',1030211078,1040246829,'/veranstaltungen/2002_08_24_14',1,1,0,'','',',302,472,','','',',119,,','',2,5,'','we_objectFile',0,0,1040246829);
INSERT INTO tblObjectFiles VALUES (15,11,'2002_08_24_15','objectFile.gif',0,'objectFile',1030211372,1040246841,'/veranstaltungen/2002_08_24_15',1,1,0,'','',',302,472,','','',',119,,','',2,6,'','we_objectFile',0,0,1040246841);
INSERT INTO tblObjectFiles VALUES (16,11,'2002_08_24_16','objectFile.gif',0,'objectFile',1030212263,1040246781,'/veranstaltungen/2002_08_24_16',1,1,0,'','',',302,472,','','',',119,,','',2,7,'','we_objectFile',0,0,1040246781);
INSERT INTO tblObjectFiles VALUES (1,0,'adressen','class_folder.gif',1,'folder',1030117546,1030117546,'/adressen',1,1,0,'','','','','','','',0,0,'','we_class_folder',1,0,0);
INSERT INTO tblObjectFiles VALUES (2,1,'webEditionSoftwareGmbH','objectFile.gif',0,'objectFile',1030119213,1049636738,'/adressen/webEditionSoftwareGmbH',1,1,0,'','','','','','','',1,4,'','we_objectFile',0,0,1049636738);
INSERT INTO tblObjectFiles VALUES (3,1,'CMS-Halle','objectFile.gif',0,'objectFile',1030123178,1030200241,'/adressen/CMS-Halle',1,1,0,'','','','','','','',1,5,',20,','we_objectFile',0,0,1030200241);
INSERT INTO tblObjectFiles VALUES (6,1,'webEdition-Halle','objectFile.gif',0,'objectFile',1030123840,1030200410,'/adressen/webEdition-Halle',1,1,0,'','','','','','','',1,8,',20,','we_objectFile',0,0,1030200410);
INSERT INTO tblObjectFiles VALUES (5,1,'Musterhalle','objectFile.gif',0,'objectFile',1030123592,1030200335,'/adressen/Musterhalle',1,1,0,'','','','','','','',1,7,',20,','we_objectFile',0,0,1030200335);
INSERT INTO tblObjectFiles VALUES (7,1,'Irgendwo','objectFile.gif',0,'objectFile',1030124185,1030124391,'/adressen/Irgendwo',1,1,0,'','','','','','','',1,9,'','we_objectFile',0,0,1030124391);
INSERT INTO tblObjectFiles VALUES (8,1,'Turnhalle','objectFile.gif',0,'objectFile',1030124391,1030200375,'/adressen/Turnhalle',1,1,0,'','','','','','','',1,10,',20,','we_objectFile',0,0,1030200375);
INSERT INTO tblObjectFiles VALUES (9,1,'Kirche','objectFile.gif',0,'objectFile',1030124620,1030124813,'/adressen/Kirche',1,1,0,'','','','','','','',1,11,'','we_objectFile',0,0,1030124814);
INSERT INTO tblObjectFiles VALUES (10,1,'Fussballstadion','objectFile.gif',0,'objectFile',1030125015,1030200306,'/adressen/Fussballstadion',1,1,0,'','','','','','','',1,12,',20,','we_objectFile',0,0,1030200306);
INSERT INTO tblObjectFiles VALUES (11,0,'veranstaltungen','class_folder.gif',1,'folder',1030209564,1030209564,'/veranstaltungen',1,1,0,'','','','','','','',0,0,'','we_class_folder',1,0,0);

#
# Table structure for table 'tblObject_1'
#

CREATE TABLE tblObject_1 (
  ID bigint(20) NOT NULL auto_increment,
  OF_ID bigint(20) NOT NULL default '0',
  OF_ParentID bigint(20) NOT NULL default '0',
  OF_Text varchar(255) NOT NULL default '',
  OF_Path varchar(255) NOT NULL default '',
  OF_Workspaces varchar(255) NOT NULL default '',
  OF_ExtraWorkspaces varchar(255) NOT NULL default '',
  OF_ExtraWorkspacesSelected varchar(255) NOT NULL default '',
  OF_Templates varchar(255) NOT NULL default '',
  OF_ExtraTemplates varchar(255) NOT NULL default '',
  OF_Category varchar(255) NOT NULL default '',
  OF_Published int(11) NOT NULL default '0',
  input_Name1 varchar(255) NOT NULL default '',
  input_Name2 varchar(255) NOT NULL default '',
  input_Strasse varchar(255) NOT NULL default '',
  input_PLZ varchar(10) NOT NULL default '',
  input_Ort varchar(255) NOT NULL default '',
  input_Telefon varchar(255) NOT NULL default '',
  input_Email varchar(255) NOT NULL default '',
  input_URL varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblObject_1'
#

INSERT INTO tblObject_1 VALUES (10,8,1,'Turnhalle','/adressen/Turnhalle','','','','','',',20,',1030200375,'Turnhalle','','Turnstraße 98','23412','Turningen','','','');
INSERT INTO tblObject_1 VALUES (11,9,1,'Kirche','/adressen/Kirche','','','','','','',1030124814,'Kirche','','Kirchweg 54','65438','Kirchhausen','','','');
INSERT INTO tblObject_1 VALUES (1,0,0,'','','','','','','','',0,'','','','','','','','');
INSERT INTO tblObject_1 VALUES (4,2,1,'webEditionSoftwareGmbH','/adressen/webEditionSoftwareGmbH','','','','','','',1049636738,'webEdition','Software GmbH','Waldstrasse 40b','76133','Karlsruhe','0721 / 0815','info@webedition.de','http://www.webedition.de');
INSERT INTO tblObject_1 VALUES (5,3,1,'CMS-Halle','/adressen/CMS-Halle','','','','','',',20,',1030200241,'CMS-Halle','','CMS-Straße 111','12345','CMS-Hausen','01212 / 38934','cms@cms.cms','http://www.cms.cms');
INSERT INTO tblObject_1 VALUES (7,5,1,'Musterhalle','/adressen/Musterhalle','','','','','',',20,',1030200335,'Musterhalle','','Musterstraße','45464','Musterberg','009876 / 4389334','muster@musterhalle.de','http://www.musterhalle.de');
INSERT INTO tblObject_1 VALUES (8,6,1,'webEdition-Halle','/adressen/webEdition-Halle','','','','','',',20,',1030200410,'webEdition Halle','','webEdition Straße 120','56785','WebEdition','0190 / 346782346','info@webEdition.de','http://www.webedition.de');
INSERT INTO tblObject_1 VALUES (12,10,1,'Fussballstadion','/adressen/Fussballstadion','','','','','',',20,',1030200306,'Fußballstadion','','Sportweg 65','67868','Sporthausen','','','');
INSERT INTO tblObject_1 VALUES (9,7,1,'Irgendwo','/adressen/Irgendwo','','','','','','',1030124391,'Irgendwo','','Irgendeine Straße 142a','67857','Irgendein Ort','00989 / 37489234','irgendwo@irgendeinedomain.de','http://irgendeinedomain.de');

#
# Table structure for table 'tblObject_2'
#

CREATE TABLE tblObject_2 (
  ID bigint(20) NOT NULL auto_increment,
  OF_ID bigint(20) NOT NULL default '0',
  OF_ParentID bigint(20) NOT NULL default '0',
  OF_Text varchar(255) NOT NULL default '',
  OF_Path varchar(255) NOT NULL default '',
  OF_Workspaces varchar(255) NOT NULL default '',
  OF_ExtraWorkspaces varchar(255) NOT NULL default '',
  OF_ExtraWorkspacesSelected varchar(255) NOT NULL default '',
  OF_Templates varchar(255) NOT NULL default '',
  OF_ExtraTemplates varchar(255) NOT NULL default '',
  OF_Category varchar(255) NOT NULL default '',
  OF_Published int(11) NOT NULL default '0',
  input_Veranstaltungsname varchar(255) NOT NULL default '',
  text_Veranstaltungsbeschreibung longtext NOT NULL,
  date_Veranstaltungsdatum int(11) NOT NULL default '0',
  object_1 bigint(22) NOT NULL default '0',
  text_Veranstaltungsdetails longtext NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblObject_2'
#

INSERT INTO tblObject_2 VALUES (1,0,0,'','','','','','','','',0,'','',0,0,'');
INSERT INTO tblObject_2 VALUES (3,12,11,'2002_08_24_12','/veranstaltungen/2002_08_24_12',',302,472,','','',',119,,','','',1040246807,'Warum CMS?','Christian Schulmeyer, erläutert die Vorteile eines Content-Management-Systems.',1033030800,2,'<P><STRONG>Dauer:</STRONG> ca. 2 Stunden<BR><STRONG>Plätze:</STRONG> 100<BR><STRONG>Preis:</STRONG> 0,00 Euro</P>');
INSERT INTO tblObject_2 VALUES (4,13,11,'2002_08_24_13','/veranstaltungen/2002_08_24_13',',302,472,','','',',119,,','','',1040246818,'webEdition Schulung für Entwickler','Diese Schulung ist für Programmierer mit ausreichend guten Kenntnissen in HTML, DHTML, Javascript, PHP4 und Datenbank-Technologien gedacht.',1036659600,6,'<P><STRONG>Dauer:</STRONG> 2 Tage<BR><STRONG>Anzahl Personen:</STRONG> 10<BR><STRONG>Preis: </STRONG>400 Euro / Person</P>');
INSERT INTO tblObject_2 VALUES (5,14,11,'2002_08_24_14','/veranstaltungen/2002_08_24_14',',302,472,','','',',119,,','','',1040246829,'PHP Grundkurs','Grundlagen in der PHP Programmierung. Nach diesem Kurs sind Sie in der Lage eigenständig interaktive Webseiten zu programmieren.',1033286400,7,'<P><STRONG>Preis:</STRONG> 350.- Euro / Person<BR><STRONG>Dauer:</STRONG> 1 Tag</P>');
INSERT INTO tblObject_2 VALUES (6,15,11,'2002_08_24_15','/veranstaltungen/2002_08_24_15',',302,472,','','',',119,,','','',1040246841,'\"El beso de la tierra\" - Videofilm in spanischer Originalsprache','Regie: Lucinda Torre, Spanien ab 20.00 Uhr: Einführung in den Film ab 20.30 Uhr: Videofilm in spanischer Originalsprache.',1033149600,5,'');
INSERT INTO tblObject_2 VALUES (7,16,11,'2002_08_24_16','/veranstaltungen/2002_08_24_16',',302,472,','','',',119,,','','',1040246781,'Web of Life','Präsentation des Multimediaprojektes im Rahmen der Ausstellung \"intermedium2\".',1031061600,3,'');

