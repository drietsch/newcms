# MySQL dump 8.13
#
# Host: localhost    Database: we_andy_clean_en
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
  DefaultValues text NOT NULL,
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

INSERT INTO tblObject VALUES (1,0,'0,1,2,3,4,5,6,7','addresses','object.gif',0,'object',1030117297,1035907295,'/addresses',1,1,0,'','',0,'','','',0,'','a:9:{s:13:\"WorkspaceFlag\";i:1;s:11:\"input_Name1\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"d2003e1cfa23d4fa65a7b65ee7367d9f\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:11:\"input_Name2\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:0:\"\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"73d07087298e8831948873f8a588f110\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:12:\"input_Street\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"9fc5e1a8fe0bb162481bc34fc5624c39\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:9:\"input_ZIP\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"6c4b4b7afd6517da86f58e41228738fa\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:10:\"input_City\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"b7bdc15ab62967b7e52e427124383856\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:11:\"input_Phone\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:0:\"\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"f4dce7561924e87322742c903d770e80\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:11:\"input_Email\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:0:\"\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"a5072724eac3b1eea80f15d9561b598d\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:9:\"input_URL\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:0:\"\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"82c762fba08d2514266d1fe3a54644d7\";s:4:\"meta\";a:1:{s:0:\"\";N;}}}','input_Name1','input_Name1','we_object','','');
INSERT INTO tblObject VALUES (2,0,'0,1,4,2,3','events','object.gif',0,'object',1030209283,1035907373,'/events',1,1,0,'','',0,'','','',0,'%Y%_%m%_%d%_%ID%','a:6:{s:13:\"WorkspaceFlag\";i:1;s:15:\"input_EventName\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"648384762b12d00e0e734f9a811b3145\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:21:\"text_EventDescription\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";s:3:\"off\";s:9:\"dhtmledit\";s:2:\"on\";s:9:\"showmenus\";s:3:\"off\";s:10:\"forbidhtml\";s:3:\"off\";s:9:\"forbidphp\";s:2:\"on\";s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"380b1b117348d74b2e8d5fe52d24df88\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:14:\"date_EventDate\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"9c42efeb4fd9dc1914f112744447a9e7\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:8:\"object_1\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";N;s:9:\"dhtmledit\";N;s:9:\"showmenus\";N;s:10:\"forbidhtml\";N;s:9:\"forbidphp\";N;s:5:\"users\";N;s:8:\"required\";s:1:\"1\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"0c7b7b7af26152591992398a5eba5658\";s:4:\"meta\";a:1:{s:0:\"\";N;}}s:16:\"text_EventDetail\";a:13:{s:7:\"default\";s:0:\"\";s:6:\"autobr\";s:3:\"off\";s:9:\"dhtmledit\";s:2:\"on\";s:9:\"showmenus\";s:3:\"off\";s:10:\"forbidhtml\";s:3:\"off\";s:9:\"forbidphp\";s:2:\"on\";s:5:\"users\";N;s:8:\"required\";s:0:\"\";s:3:\"int\";N;s:5:\"intID\";N;s:7:\"intPath\";N;s:8:\"uniqueID\";s:32:\"15c932b2872fb1a48cf00462fb70c03b\";s:4:\"meta\";a:1:{s:0:\"\";N;}}}','text_EventDescription','input_EventName','we_object',',306,',',62,');

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

INSERT INTO tblObjectFiles VALUES (11,0,'events','class_folder.gif',1,'folder',1030209564,1030209564,'/events',1,1,0,'','','','','','','',0,0,'','we_class_folder',1,0,0);
INSERT INTO tblObjectFiles VALUES (8,1,'HallOfSports','objectFile.gif',0,'objectFile',1030124391,1036067819,'/addresses/HallOfSports',1,1,0,'','','','','','','',1,10,',20,','we_objectFile',0,0,1036067819);
INSERT INTO tblObjectFiles VALUES (9,1,'Curch','objectFile.gif',0,'objectFile',1030124620,1036067841,'/addresses/Curch',1,1,0,'','','','','','','',1,11,'','we_objectFile',0,0,1036067842);
INSERT INTO tblObjectFiles VALUES (10,1,'SoccerStadium','objectFile.gif',0,'objectFile',1030125015,1036067669,'/addresses/SoccerStadium',1,1,0,'','','','','','','',1,12,',20,','we_objectFile',0,0,1036067669);
INSERT INTO tblObjectFiles VALUES (5,1,'ArenadiMaggio','objectFile.gif',0,'objectFile',1030123592,1036067777,'/addresses/ArenadiMaggio',1,1,0,'','','','','','','',1,7,',20,','we_objectFile',0,0,1036067777);
INSERT INTO tblObjectFiles VALUES (7,1,'Fightclub','objectFile.gif',0,'objectFile',1030124185,1036068217,'/addresses/Fightclub',1,1,0,'','','','','','','',1,9,'','we_objectFile',0,0,1036068217);
INSERT INTO tblObjectFiles VALUES (3,1,'CMS-Hall','objectFile.gif',0,'objectFile',1030123178,1035910586,'/addresses/CMS-Hall',1,1,0,'','','','','','','',1,5,',20,','we_objectFile',0,0,1035910586);
INSERT INTO tblObjectFiles VALUES (6,1,'webEdition-Hall','objectFile.gif',0,'objectFile',1030123840,1036064516,'/addresses/webEdition-Hall',1,1,0,'','','','','','','',1,8,',20,','we_objectFile',0,0,1036064516);
INSERT INTO tblObjectFiles VALUES (1,0,'addresses','class_folder.gif',1,'folder',1030117546,1030117546,'/addresses',1,1,0,'','','','','','','',0,0,'','we_class_folder',1,0,0);
INSERT INTO tblObjectFiles VALUES (2,1,'webEdition','objectFile.gif',0,'objectFile',1030119213,1036068080,'/addresses/webEdition',1,1,0,'','','','','','','',1,4,'','we_objectFile',0,0,1036068080);
INSERT INTO tblObjectFiles VALUES (16,11,'2002_08_24_16','objectFile.gif',0,'objectFile',1030212263,1036067587,'/events/2002_08_24_16',1,1,0,'','',',306,','','',',62,','',2,7,'','we_objectFile',0,0,1036067587);
INSERT INTO tblObjectFiles VALUES (13,11,'2002_08_24_13','objectFile.gif',0,'objectFile',1030210227,1036067363,'/events/2002_08_24_13',1,1,0,'','',',306,','','',',62,','',2,4,'','we_objectFile',0,0,1036067363);
INSERT INTO tblObjectFiles VALUES (14,11,'2002_08_24_14','objectFile.gif',0,'objectFile',1030211078,1076404814,'/events/2002_08_24_14',1,1,0,'','',',306,','','',',62,','',2,5,'','we_objectFile',0,0,1076404814);
INSERT INTO tblObjectFiles VALUES (15,11,'2002_08_24_15','objectFile.gif',0,'objectFile',1030211372,1036067118,'/events/2002_08_24_15',1,1,0,'','',',306,','','',',62,','',2,6,'','we_objectFile',0,0,1036067118);
INSERT INTO tblObjectFiles VALUES (12,11,'2002_08_24_12','objectFile.gif',0,'objectFile',1030209716,1036067440,'/events/2002_08_24_12',1,1,0,'','',',306,','','',',62,','',2,3,'','we_objectFile',0,0,1036067440);

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
  input_Street varchar(255) NOT NULL default '',
  input_ZIP varchar(10) NOT NULL default '',
  input_City varchar(255) NOT NULL default '',
  input_Phone varchar(255) NOT NULL default '',
  input_Email varchar(255) NOT NULL default '',
  input_URL varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblObject_1'
#

INSERT INTO tblObject_1 VALUES (9,7,1,'Fightclub','/addresses/Fightclub','','','','','','',1036068217,'Fightclub','','242 Fifth Fist','67857','PLeaseme','00989 / 37489234','fist@fightclub.com','http://fightclub.com');
INSERT INTO tblObject_1 VALUES (8,6,1,'webEdition-Hall','/addresses/webEdition-Hall','','','','','',',20,',1036064516,'webEdition Hall','','webEdition Street 120','56785','WebEdition','0190 / 346782346','info@webEdition.de','http://www.webedition.de');
INSERT INTO tblObject_1 VALUES (12,10,1,'SoccerStadium','/addresses/SoccerStadium','','','','','',',20,',1036067669,'Soccer Stadium','','65 Sportstreet','67868','Sportcity','','','');
INSERT INTO tblObject_1 VALUES (7,5,1,'ArenadiMaggio','/addresses/ArenadiMaggio','','','','','',',20,',1036067777,'Arena di Maggio','','Via Arena 12','45464','Magicten','009876 / 4389334','info@arenadimaggio.com','http://www.arenadimaggio.com');
INSERT INTO tblObject_1 VALUES (11,9,1,'Curch','/addresses/Curch','','','','','','',1036067842,'Church','','Church Street 54','65438','Curch City','','','');
INSERT INTO tblObject_1 VALUES (1,0,0,'','','','','','','','',0,'','','','','','','','');
INSERT INTO tblObject_1 VALUES (5,3,1,'CMS-Hall','/addresses/CMS-Hall','','','','','',',20,',1035910586,'CMS-Hall','','CMS-Street 111','12345','CMS-City','01212 / 38934','cms@cms.cms','http://www.cms.cms');
INSERT INTO tblObject_1 VALUES (10,8,1,'HallOfSports','/addresses/HallOfSports','','','','','',',20,',1036067819,'Hall of sports','','98 Sportstreet','23412','Sportstown','','','');

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
  input_EventName varchar(255) NOT NULL default '',
  text_EventDescription longtext NOT NULL,
  date_EventDate int(11) NOT NULL default '0',
  object_1 bigint(22) NOT NULL default '0',
  text_EventDetail longtext NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblObject_2'
#

INSERT INTO tblObject_2 VALUES (4,13,11,'2002_08_24_13','/events/2002_08_24_13',',306,','','',',62,','','',1036067363,'Workshop for webEdition developer','This workshop is targeted to developer with knowledge and experience in HTML, DHTML, Javascript, PHP4 and Database Technologies',1036659600,6,'<P><STRONG>Duration:</STRONG> 2 Days<BR><STRONG>No. Attendees:</STRONG> 10<BR><STRONG>Fee: </STRONG>400.00 Euro / Attendee</P>');
INSERT INTO tblObject_2 VALUES (1,0,0,'','','','','','','','',0,'','',0,0,'');
INSERT INTO tblObject_2 VALUES (3,12,11,'2002_08_24_12','/events/2002_08_24_12',',306,','','',',62,','','',1036067440,'Why CMS?','Christian Schulmeyer explains the advantage of using content management systems.',1033030800,2,'<STRONG>Duration:</STRONG>2 Hours<BR><STRONG>Seats:</STRONG> 100<BR><STRONG>Fee:</STRONG> free Entry');
INSERT INTO tblObject_2 VALUES (5,14,11,'2002_08_24_14','/events/2002_08_24_14',',306,','','',',62,','','',1076404814,'PHP Basics','Basic developing in PHP. You will learn how to develop interactive Websites on you own based on PHP.',1033286400,7,'<strong>Fee:</strong> 350.00 Euro / Attendee<br><strong>Duration:</strong> 1 Day');
INSERT INTO tblObject_2 VALUES (7,16,11,'2002_08_24_16','/events/2002_08_24_16',',306,','','',',62,','','',1036067587,'Web of Life','Exhibition \"intermedium2\" featuring the presentation of the multimedia project \"Web of Life\". ',1031061600,3,'');
INSERT INTO tblObject_2 VALUES (6,15,11,'2002_08_24_15','/events/2002_08_24_15',',306,','','',',62,','','',1036067118,'\"El beso de la tierra\" - Video in Spanish w/o subtitles','Regie: Lucinda Torre, Spain\nAt 8.00 pm: Welcome and introduction\nAt 8.30 pm: Presentation of the movie in spanish without subtitles.',1033149600,5,'');

