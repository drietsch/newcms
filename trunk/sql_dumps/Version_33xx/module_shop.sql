# MySQL dump 8.13
#
# Host: localhost    Database: we_andy_clean_de
#--------------------------------------------------------
# Server version	3.23.37-log

#
# Table structure for table 'tblAnzeigePrefs'
#

CREATE TABLE tblAnzeigePrefs (
  ID int(15) NOT NULL auto_increment,
  strDateiname varchar(255) NOT NULL default '',
  strFelder text NOT NULL,
  PRIMARY KEY  (ID),
  UNIQUE KEY ID (ID),
  KEY ID_2 (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblAnzeigePrefs'
#

INSERT INTO tblAnzeigePrefs VALUES (1,'edit_shop_properties','Vorname:tblWebUser||Forename,Nachname:tblWebUser||Surname,Strasse:tblWebUser||Kontakt_Addresse1,Ort:tblWebUser||Kontakt_Addresse2,Land:tblWebUser||Kontakt_Land,Anzahl:webE||<quantity>,Titel:webE||shoptitle,Beschreibung:webE||shopdescription,Preis:webE||<price>,Gesamt:webE||<totalprice>');
INSERT INTO tblAnzeigePrefs VALUES (2,'shop_pref','€|16|german');

#
# Table structure for table 'tblOrders'
#

CREATE TABLE tblOrders (
  IntID int(11) NOT NULL auto_increment,
  IntOrderID int(11) default NULL,
  IntCustomerID int(11) default NULL,
  IntArticleID int(11) default NULL,
  IntQuantity int(11) default NULL,
  DateOrder datetime default NULL,
  DateShipping datetime default NULL,
  DatePayment datetime default NULL,
  Price float default NULL,
  IntPayment_Type tinyint(4) default NULL,
  strSerial longtext NOT NULL,
  PRIMARY KEY  (IntID),
  UNIQUE KEY IntID (IntID),
  KEY IntID_2 (IntID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblOrders'
#

INSERT INTO tblOrders VALUES (1,1,1,458,1,'2003-11-23 14:38:55','0000-00-00 00:00:00','0000-00-00 00:00:00',159,NULL,'a:62:{s:11:\"Artikelname\";s:23:\"webEdition Basisversion\";s:8:\"Keywords\";s:14:\"cms,webEdition\";s:5:\"Title\";s:23:\"webEdition Basisversion\";s:7:\"Ordnung\";s:1:\"1\";s:15:\"shopdescription\";s:13:\"CMS fürs Volk\";s:4:\"Bild\";s:3:\"438\";s:4:\"Text\";s:263:\"Mit der Basisversion von <STRONG>webEdition</STRONG> kann man eine Domain verwalten. <BR><BR>Die Zielgruppe sind alle kleinen und mittelständischen Firmen sowie Privatleute, die keine Kenntnisse in HTML haben, aber ihre Webseite dennoch dynamisch pflegen wollen. \";s:5:\"Preis\";s:6:\"159.00\";s:11:\"Description\";s:13:\"CMS fürs Volk\";s:9:\"shoptitle\";s:23:\"webEdition Basisversion\";s:7:\"wedoc_0\";s:3:\"458\";s:8:\"wedoc_ID\";s:3:\"458\";s:7:\"wedoc_1\";s:3:\"421\";s:14:\"wedoc_ParentID\";s:3:\"421\";s:7:\"wedoc_2\";s:14:\"webedition.php\";s:10:\"wedoc_Text\";s:14:\"webedition.php\";s:7:\"wedoc_3\";s:15:\"we_dokument.gif\";s:10:\"wedoc_Icon\";s:15:\"we_dokument.gif\";s:7:\"wedoc_4\";s:1:\"0\";s:14:\"wedoc_IsFolder\";s:1:\"0\";s:7:\"wedoc_5\";s:15:\"text/webedition\";s:17:\"wedoc_ContentType\";s:15:\"text/webedition\";s:7:\"wedoc_6\";s:10:\"1040237045\";s:18:\"wedoc_CreationDate\";s:10:\"1040237045\";s:7:\"wedoc_7\";s:10:\"1040242948\";s:13:\"wedoc_ModDate\";s:10:\"1040242948\";s:7:\"wedoc_8\";s:36:\"/we_demo/shop/artikel/webedition.php\";s:10:\"wedoc_Path\";s:36:\"/we_demo/shop/artikel/webedition.php\";s:7:\"wedoc_9\";s:3:\"108\";s:16:\"wedoc_TemplateID\";s:3:\"108\";s:8:\"wedoc_10\";s:10:\"webedition\";s:14:\"wedoc_Filename\";s:10:\"webedition\";s:8:\"wedoc_11\";s:4:\".php\";s:15:\"wedoc_Extension\";s:4:\".php\";s:8:\"wedoc_12\";s:1:\"1\";s:15:\"wedoc_IsDynamic\";s:1:\"1\";s:8:\"wedoc_13\";s:1:\"1\";s:18:\"wedoc_IsSearchable\";s:1:\"1\";s:8:\"wedoc_14\";s:2:\"10\";s:13:\"wedoc_DocType\";s:2:\"10\";s:8:\"wedoc_15\";s:21:\"we_webEditionDocument\";s:15:\"wedoc_ClassName\";s:21:\"we_webEditionDocument\";s:8:\"wedoc_16\";s:3:\",7,\";s:14:\"wedoc_Category\";s:3:\",7,\";s:8:\"wedoc_17\";s:1:\"0\";s:13:\"wedoc_Deleted\";s:1:\"0\";s:8:\"wedoc_18\";s:10:\"1040242948\";s:15:\"wedoc_Published\";s:10:\"1040242948\";s:8:\"wedoc_19\";s:1:\"1\";s:15:\"wedoc_CreatorID\";s:1:\"1\";s:8:\"wedoc_20\";s:1:\"1\";s:16:\"wedoc_ModifierID\";s:1:\"1\";s:8:\"wedoc_21\";s:1:\"0\";s:20:\"wedoc_RestrictOwners\";s:1:\"0\";s:8:\"wedoc_22\";s:0:\"\";s:12:\"wedoc_Owners\";s:0:\"\";s:8:\"wedoc_23\";s:0:\"\";s:20:\"wedoc_OwnersReadOnly\";s:0:\"\";s:8:\"wedoc_24\";s:0:\"\";s:19:\"wedoc_documentArray\";s:0:\"\";s:7:\"WE_PATH\";s:36:\"/we_demo/shop/artikel/webedition.php\";s:7:\"WE_TEXT\";s:362:\"webEdition Basisversion CMS fürs Volk 159.00 Mit der Basisversion von webEdition kann man eine Domain verwalten. Die Zielgruppe sind alle kleinen und mittelständischen Firmen sowie Privatleute, die keine Kenntnisse in HTML haben, aber ihre Webseite dennoch dynamisch pflegen wollen.  CMS fürs Volk webEdition Basisversion 1 cms,webEdition webEdition Basisversion\";}');
INSERT INTO tblOrders VALUES (2,2,1,458,1,'2004-02-12 18:53:33','0000-00-00 00:00:00','0000-00-00 00:00:00',199,NULL,'a:61:{s:11:\"Artikelname\";s:23:\"webEdition Basisversion\";s:8:\"Keywords\";s:14:\"cms,webEdition\";s:5:\"Title\";s:23:\"webEdition Basisversion\";s:7:\"Ordnung\";s:1:\"1\";s:4:\"Bild\";s:3:\"438\";s:4:\"Text\";s:263:\"Mit der Basisversion von <STRONG>webEdition</STRONG> kann man eine Domain verwalten. <BR><BR>Die Zielgruppe sind alle kleinen und mittelständischen Firmen sowie Privatleute, die keine Kenntnisse in HTML haben, aber ihre Webseite dennoch dynamisch pflegen wollen. \";s:5:\"Preis\";s:6:\"159.00\";s:11:\"Description\";s:13:\"CMS fürs Volk\";s:9:\"shoptitle\";s:23:\"webEdition Basisversion\";s:7:\"wedoc_0\";s:3:\"458\";s:8:\"wedoc_ID\";s:3:\"458\";s:7:\"wedoc_1\";s:3:\"421\";s:14:\"wedoc_ParentID\";s:3:\"421\";s:7:\"wedoc_2\";s:14:\"webedition.php\";s:10:\"wedoc_Text\";s:14:\"webedition.php\";s:7:\"wedoc_3\";s:15:\"we_dokument.gif\";s:10:\"wedoc_Icon\";s:15:\"we_dokument.gif\";s:7:\"wedoc_4\";s:1:\"0\";s:14:\"wedoc_IsFolder\";s:1:\"0\";s:7:\"wedoc_5\";s:15:\"text/webedition\";s:17:\"wedoc_ContentType\";s:15:\"text/webedition\";s:7:\"wedoc_6\";s:10:\"1040237045\";s:18:\"wedoc_CreationDate\";s:10:\"1040237045\";s:7:\"wedoc_7\";s:10:\"1040242948\";s:13:\"wedoc_ModDate\";s:10:\"1040242948\";s:7:\"wedoc_8\";s:36:\"/we_demo/shop/artikel/webedition.php\";s:10:\"wedoc_Path\";s:36:\"/we_demo/shop/artikel/webedition.php\";s:7:\"wedoc_9\";s:3:\"108\";s:16:\"wedoc_TemplateID\";s:3:\"108\";s:8:\"wedoc_10\";s:10:\"webedition\";s:14:\"wedoc_Filename\";s:10:\"webedition\";s:8:\"wedoc_11\";s:4:\".php\";s:15:\"wedoc_Extension\";s:4:\".php\";s:8:\"wedoc_12\";s:1:\"1\";s:15:\"wedoc_IsDynamic\";s:1:\"1\";s:8:\"wedoc_13\";s:1:\"1\";s:18:\"wedoc_IsSearchable\";s:1:\"1\";s:8:\"wedoc_14\";s:2:\"10\";s:13:\"wedoc_DocType\";s:2:\"10\";s:8:\"wedoc_15\";s:21:\"we_webEditionDocument\";s:15:\"wedoc_ClassName\";s:21:\"we_webEditionDocument\";s:8:\"wedoc_16\";s:3:\",7,\";s:14:\"wedoc_Category\";s:3:\",7,\";s:8:\"wedoc_17\";s:1:\"0\";s:13:\"wedoc_Deleted\";s:1:\"0\";s:8:\"wedoc_18\";s:10:\"1040242948\";s:15:\"wedoc_Published\";s:10:\"1040242948\";s:8:\"wedoc_19\";s:1:\"1\";s:15:\"wedoc_CreatorID\";s:1:\"1\";s:8:\"wedoc_20\";s:1:\"1\";s:16:\"wedoc_ModifierID\";s:1:\"1\";s:8:\"wedoc_21\";s:1:\"0\";s:20:\"wedoc_RestrictOwners\";s:1:\"0\";s:8:\"wedoc_22\";s:0:\"\";s:12:\"wedoc_Owners\";s:0:\"\";s:8:\"wedoc_23\";s:0:\"\";s:20:\"wedoc_OwnersReadOnly\";s:0:\"\";s:8:\"wedoc_24\";s:0:\"\";s:19:\"wedoc_documentArray\";s:0:\"\";s:7:\"WE_PATH\";s:36:\"/we_demo/shop/artikel/webedition.php\";s:7:\"WE_TEXT\";s:348:\"webEdition Basisversion cms,webEdition webEdition Basisversion 1 Mit der Basisversion von webEdition kann man eine Domain verwalten. Die Zielgruppe sind alle kleinen und mittelständischen Firmen sowie Privatleute, die keine Kenntnisse in HTML haben, aber ihre Webseite dennoch dynamisch pflegen wollen.  159.00 CMS fürs Volk webEdition Basisversion\";}');

