
--
-- Table structure for table `tblAnzeigePrefs`
--

SET SESSION sql_mode='';

DROP TABLE IF EXISTS tblAnzeigePrefs;
CREATE TABLE tblAnzeigePrefs (
  ID int(15) NOT NULL auto_increment,
  strDateiname varchar(255) NOT NULL default '',
  strFelder text NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblAnzeigePrefs`
--

INSERT INTO tblAnzeigePrefs VALUES (1,'edit_shop_properties','a:2:{s:14:"customerFields";a:0:{}s:19:"orderCustomerFields";a:0:{}}');
INSERT INTO tblAnzeigePrefs VALUES (2,'shop_pref','?|19|german');

--
-- Table structure for table `tblCategorys`
--

-- ------------------------------------------------------------------------

DROP TABLE IF EXISTS tblCategorys;
CREATE TABLE tblCategorys (
  ID int(11) NOT NULL auto_increment,
  Category varchar(64) NOT NULL default '',
  `Text` varchar(64) default NULL,
  Path varchar(255) default NULL,
  ParentID bigint(20) default NULL,
  IsFolder tinyint(1) default NULL,
  Icon varchar(64) default NULL,
  Catfields longtext NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblCategorys`
--


--
-- Table structure for table `tblCleanUp`
--

DROP TABLE IF EXISTS tblCleanUp;
CREATE TABLE tblCleanUp (
  Path varchar(255) NOT NULL default '',
  `Date` int(11) NOT NULL default '0'
) TYPE=MyISAM;

--
-- Dumping data for table `tblCleanUp`
--


--
-- Table structure for table `tblContent`
--

DROP TABLE IF EXISTS tblContent;
CREATE TABLE tblContent (
  ID bigint(20) NOT NULL auto_increment,
  BDID int(11) NOT NULL default '0',
  Dat longtext,
  IsBinary tinyint(4) NOT NULL default '0',
  AutoBR char(3) NOT NULL default '',
  LanguageID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblContent`
--


--
-- Table structure for table `tblContentTypes`
--

-- ------------------------------------------------------------------------

DROP TABLE IF EXISTS tblContentTypes;
CREATE TABLE tblContentTypes (
  OrderNr int(11) NOT NULL default '0',
  ContentType varchar(32) NOT NULL default '',
  Extension varchar(128) NOT NULL default '',
  DefaultCode text NOT NULL,
  IconID int(11) NOT NULL default '0',
  Template tinyint(4) NOT NULL default '0',
  `File` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ContentType)
) TYPE=MyISAM;

--
-- Dumping data for table `tblContentTypes`
--


--
-- Table structure for table `tblDocTypes`
--

DROP TABLE IF EXISTS tblDocTypes;
CREATE TABLE tblDocTypes (
  ID int(11) NOT NULL auto_increment,
  DocType varchar(32) NOT NULL default '',
  Extension varchar(10) NOT NULL default '',
  ParentID int(11) NOT NULL default '0',
  ParentPath varchar(255) NOT NULL default '',
  SubDir int(11) NOT NULL default '0',
  TemplateID int(11) NOT NULL default '0',
  IsDynamic tinyint(1) NOT NULL default '0',
  IsSearchable tinyint(1) NOT NULL default '0',
  ContentTable varchar(32) NOT NULL default '',
  JavaScript text NOT NULL,
  Notify text NOT NULL,
  NotifyTemplateID int(11) NOT NULL default '0',
  NotifySubject varchar(64) NOT NULL default '',
  NotifyOnChange tinyint(1) NOT NULL default '0',
  LockID int(11) NOT NULL default '0',
  Templates varchar(255) NOT NULL default '',
  Deleted int(11) NOT NULL default '0',
  Category varchar(255) default NULL,
  Language varchar(5) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblDocTypes`
--


--
-- Table structure for table `tblErrorLog`
--

-- ------------------------------------------------------------------------

DROP TABLE IF EXISTS tblErrorLog;
CREATE TABLE tblErrorLog (
  ID int(11) NOT NULL auto_increment,
  `Text` text NOT NULL,
  `Date` int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblErrorLog`
--


--
-- Table structure for table `tblFailedLogins`
--

-- ------------------------------------------------------------------------

DROP TABLE IF EXISTS tblFailedLogins;
CREATE TABLE tblFailedLogins (
  ID bigint(20) NOT NULL default '0',
  Username varchar(64) NOT NULL default '',
  `Password` varchar(32) NOT NULL default '',
  IP varchar(15) NOT NULL default '',
  LoginDate int(11) NOT NULL default '0'
) TYPE=MyISAM;

--
-- Dumping data for table `tblFailedLogins`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblFile`
--

DROP TABLE IF EXISTS tblFile;
CREATE TABLE tblFile (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) NOT NULL default '0',
  `Text` varchar(255) NOT NULL default '',
  Icon varchar(64) NOT NULL default '',
  IsFolder tinyint(4) NOT NULL default '0',
  ContentType varchar(32) NOT NULL default '',
  CreationDate int(11) NOT NULL default '0',
  ModDate int(11) NOT NULL default '0',
  Path varchar(255) NOT NULL default '',
  TemplateID int(11) NOT NULL default '0',
  temp_template_id int(11) NOT NULL default '0',
  Filename varchar(255) NOT NULL default '',
  Extension varchar(16) NOT NULL default '',
  IsDynamic tinyint(4) NOT NULL default '0',
  IsSearchable tinyint(1) NOT NULL default '0',
  DocType varchar(32) NOT NULL default '',
  temp_doc_type varchar(32) NOT NULL default '',
  ClassName varchar(64) NOT NULL default '',
  Category varchar(255) default NULL,
  temp_category varchar(255) default NULL,
  Deleted int(11) NOT NULL default '0',
  Published int(11) NOT NULL default '0',
  CreatorID bigint(20) NOT NULL default '0',
  ModifierID bigint(20) NOT NULL default '0',
  RestrictOwners tinyint(1) NOT NULL default '0',
  Owners varchar(255) NOT NULL default '',
  OwnersReadOnly text NOT NULL,
  documentArray text NOT NULL,
  Language varchar(5) NOT NULL default '',
  PRIMARY KEY  (ID),
  KEY Path (Path)
) TYPE=MyISAM;

--
-- Dumping data for table `tblFile`
--

--
-- Table structure for table `tblformmailblock`
--

CREATE TABLE tblformmailblock (
  id bigint(20) NOT NULL auto_increment,
  ip varchar(15) NOT NULL,
  blockedUntil int(11) NOT NULL,
  PRIMARY KEY  (id),
  KEY ipblockeduntil (ip,blockedUntil)
);

--
-- Dumping data for table `tblformmailblock`
--

--
-- Table structure for table `tblformmaillog`
--

CREATE TABLE tblformmaillog (
  id bigint(20) NOT NULL auto_increment,
  ip varchar(15) NOT NULL,
  unixTime int(11) NOT NULL,
  PRIMARY KEY  (id),
  KEY ipwhen (ip,unixTime)
);

--
-- Dumping data for table `tblformmaillog`
--


--
-- Table structure for table `tblIndex`
--

-- ------------------------------------------------------------------------

DROP TABLE IF EXISTS tblIndex;
CREATE TABLE tblIndex (
  DID int(11) NOT NULL default '0',
  `Text` text NOT NULL,
  ID bigint(20) NOT NULL default '0',
  OID bigint(20) NOT NULL default '0',
  BText longblob NOT NULL,
  Workspace varchar(255) NOT NULL default '',
  WorkspaceID bigint(20) NOT NULL default '0',
  Category varchar(255) NOT NULL default '',
  ClassID bigint(20) NOT NULL default '0',
  Doctype bigint(20) NOT NULL default '0',
  Title varchar(255) NOT NULL default '',
  Description text NOT NULL,
  Path varchar(255) NOT NULL default '',
  KEY DID (DID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblIndex`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblLink`
--

DROP TABLE IF EXISTS tblLink;
CREATE TABLE tblLink (
  DID int(11) NOT NULL default '0',
  CID int(11) NOT NULL default '0',
  `Type` varchar(16) NOT NULL default '',
  Name varchar(255) NOT NULL default '',
  DocumentTable varchar(64) NOT NULL default '',
  KEY DID (DID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblLink`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblLock`
--

DROP TABLE IF EXISTS tblLock;
CREATE TABLE tblLock (
  ID bigint(20) NOT NULL default '0',
  UserID bigint(20) NOT NULL default '0',
  tbl varchar(32) NOT NULL default ''
) TYPE=MyISAM;

--
-- Dumping data for table `tblLock`
--


--
-- Table structure for table `tblMessages`
--

DROP TABLE IF EXISTS tblMessages;
CREATE TABLE tblMessages (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) default NULL,
  UserID int(11) default NULL,
  msg_type tinyint(4) NOT NULL default '0',
  obj_type tinyint(4) NOT NULL default '0',
  headerDate int(11) default NULL,
  headerSubject varchar(255) default NULL,
  headerUserID int(11) default NULL,
  headerFrom varchar(255) default NULL,
  headerTo varchar(255) default NULL,
  Priority tinyint(4) default NULL,
  seenStatus tinyint(4) unsigned default NULL,
  MessageText text,
  tag tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblMessages`
--


--
-- Table structure for table `tblMsgAccounts`
--

DROP TABLE IF EXISTS tblMsgAccounts;
CREATE TABLE tblMsgAccounts (
  ID int(11) NOT NULL auto_increment,
  UserID int(11) default NULL,
  name varchar(255) NOT NULL default '',
  msg_type int(11) default NULL,
  deletable tinyint(4) NOT NULL default '0',
  uri varchar(255) default NULL,
  `user` varchar(255) default NULL,
  pass varchar(255) default NULL,
  update_interval smallint(5) unsigned NOT NULL default '0',
  ext varchar(255) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblMsgAccounts`
--


--
-- Table structure for table `tblMsgAddrbook`
--

DROP TABLE IF EXISTS tblMsgAddrbook;
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

--
-- Dumping data for table `tblMsgAddrbook`
--


--
-- Table structure for table `tblMsgFolders`
--

DROP TABLE IF EXISTS tblMsgFolders;
CREATE TABLE tblMsgFolders (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) default NULL,
  UserID int(11) NOT NULL default '0',
  account_id int(11) default NULL,
  msg_type tinyint(4) NOT NULL default '0',
  obj_type tinyint(4) NOT NULL default '0',
  Name varchar(255) NOT NULL default '',
  sortItem varchar(255) default NULL,
  sortOrder varchar(5) default NULL,
  Properties int(10) unsigned default NULL,
  tag tinyint(4) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblMsgFolders`
--

INSERT INTO tblMsgFolders VALUES (1,0,1,-1,1,3,'Messages',NULL,NULL,1,NULL);
INSERT INTO tblMsgFolders VALUES (2,1,1,-1,1,5,'Sent',NULL,NULL,1,NULL);
INSERT INTO tblMsgFolders VALUES (3,0,1,-1,2,3,'Task',NULL,NULL,1,NULL);
INSERT INTO tblMsgFolders VALUES (4,3,1,-1,2,13,'Done',NULL,NULL,1,NULL);
INSERT INTO tblMsgFolders VALUES (5,3,1,-1,2,11,'rejected',NULL,NULL,1,NULL);

--
-- Table structure for table `tblMsgSettings`
--

DROP TABLE IF EXISTS tblMsgSettings;
CREATE TABLE tblMsgSettings (
  ID int(11) NOT NULL auto_increment,
  UserID int(11) NOT NULL default '0',
  strKey varchar(255) default NULL,
  strVal varchar(255) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblMsgSettings`
--


--
-- Table structure for table `tblNewsletter`
--

DROP TABLE IF EXISTS tblNewsletter;
CREATE TABLE tblNewsletter (
  ID bigint(20) NOT NULL auto_increment,
  ParentID bigint(20) NOT NULL default '0',
  IsFolder tinyint(1) NOT NULL default '0',
  Icon varchar(255) NOT NULL default '',
  Path varchar(255) NOT NULL default '',
  `Text` varchar(255) NOT NULL default '',
  `Subject` varchar(255) NOT NULL default '',
  Sender varchar(255) NOT NULL default '',
  Reply varchar(255) NOT NULL default '',
  Test varchar(255) NOT NULL default '',
  Log text NOT NULL,
  Step int(11) NOT NULL default '0',
  `Offset` int(11) NOT NULL default '0',
  `Charset` varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblNewsletter`
--


--
-- Table structure for table `tblNewsletterBlock`
--

DROP TABLE IF EXISTS tblNewsletterBlock;
CREATE TABLE tblNewsletterBlock (
  ID bigint(20) NOT NULL auto_increment,
  NewsletterID bigint(20) NOT NULL default '0',
  Groups varchar(255) NOT NULL default '',
  `Type` tinyint(4) NOT NULL default '0',
  LinkID bigint(20) NOT NULL default '0',
  Field varchar(255) NOT NULL default '',
  Source longtext NOT NULL,
  Html longtext NOT NULL,
  Pack tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblNewsletterBlock`
--


--
-- Table structure for table `tblNewsletterConfirm`
--

DROP TABLE IF EXISTS tblNewsletterConfirm;
CREATE TABLE tblNewsletterConfirm (
  confirmID varchar(96) NOT NULL default '',
  subscribe_mail varchar(255) NOT NULL default '',
  subscribe_html tinyint(1) NOT NULL default '0',
  subscribe_salutation varchar(255) NOT NULL default '',
  subscribe_title varchar(255) NOT NULL default '',
  subscribe_firstname varchar(255) NOT NULL default '',
  subscribe_lastname varchar(255) NOT NULL default '',
  lists text NOT NULL,
  expires bigint(20) NOT NULL default '0'
) TYPE=MyISAM;

--
-- Dumping data for table `tblNewsletterConfirm`
--


--
-- Table structure for table `tblNewsletterGroup`
--

DROP TABLE IF EXISTS tblNewsletterGroup;
CREATE TABLE tblNewsletterGroup (
  ID bigint(20) NOT NULL auto_increment,
  NewsletterID bigint(20) NOT NULL default '0',
  Emails longtext NOT NULL,
  Customers longtext NOT NULL,
  SendAll tinyint(1) NOT NULL default '0',
  Filter blob NOT NULL,
  Extern longtext,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblNewsletterGroup`
--


--
-- Table structure for table `tblNewsletterLog`
--

DROP TABLE IF EXISTS tblNewsletterLog;
CREATE TABLE tblNewsletterLog (
  ID bigint(20) NOT NULL auto_increment,
  NewsletterID bigint(20) NOT NULL default '0',
  LogTime bigint(20) NOT NULL default '0',
  Log varchar(255) NOT NULL default '',
  Param varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblNewsletterLog`
--


--
-- Table structure for table `tblNewsletterPrefs`
--

DROP TABLE IF EXISTS tblNewsletterPrefs;
CREATE TABLE tblNewsletterPrefs (
  pref_name varchar(255) NOT NULL default '',
  pref_value longtext NOT NULL
) TYPE=MyISAM;

--
-- Dumping data for table `tblNewsletterPrefs`
--

INSERT INTO tblNewsletterPrefs VALUES ('black_list','');
INSERT INTO tblNewsletterPrefs VALUES ('customer_email_field','Kontakt_Email');
INSERT INTO tblNewsletterPrefs VALUES ('customer_firstname_field','Forename');
INSERT INTO tblNewsletterPrefs VALUES ('customer_html_field','htmlMailYesNo');
INSERT INTO tblNewsletterPrefs VALUES ('customer_lastname_field','Surname');
INSERT INTO tblNewsletterPrefs VALUES ('customer_salutation_field','Anrede_Salutation');
INSERT INTO tblNewsletterPrefs VALUES ('customer_title_field','Anrede_Title');
INSERT INTO tblNewsletterPrefs VALUES ('default_htmlmail','0');
INSERT INTO tblNewsletterPrefs VALUES ('default_reply','reply@meineDomain.de');
INSERT INTO tblNewsletterPrefs VALUES ('default_sender','mailer@meineDomain.de');
INSERT INTO tblNewsletterPrefs VALUES ('female_salutation','Frau');
INSERT INTO tblNewsletterPrefs VALUES ('global_mailing_list','');
INSERT INTO tblNewsletterPrefs VALUES ('log_sending','1');
INSERT INTO tblNewsletterPrefs VALUES ('male_salutation','Herr');
INSERT INTO tblNewsletterPrefs VALUES ('reject_malformed','1');
INSERT INTO tblNewsletterPrefs VALUES ('reject_not_verified','1');
INSERT INTO tblNewsletterPrefs VALUES ('send_step','20');
INSERT INTO tblNewsletterPrefs VALUES ('send_wait','0');
INSERT INTO tblNewsletterPrefs VALUES ('test_account','test@meineDomain.de');
INSERT INTO tblNewsletterPrefs VALUES ('title_or_salutation','0');

--
-- Table structure for table `tblObject`
--

DROP TABLE IF EXISTS tblObject;
CREATE TABLE tblObject (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) NOT NULL default '0',
  strOrder text NOT NULL,
  `Text` varchar(255) NOT NULL default '',
  Icon varchar(64) NOT NULL default '',
  IsFolder tinyint(4) NOT NULL default '0',
  ContentType varchar(32) NOT NULL default '',
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
  DefaultKeywords varchar(255) NOT NULL default '',
  ClassName varchar(64) NOT NULL default '',
  Workspaces varchar(255) NOT NULL default '',
  DefaultWorkspaces varchar(255) NOT NULL default '',
  Templates varchar(255) NOT NULL default '',
  CacheType ENUM( '', 'none', 'tag', 'document', 'full' ) DEFAULT 'none' NOT NULL,
  CacheLifeTime int(5) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblObject`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblObjectFiles`
--

DROP TABLE IF EXISTS tblObjectFiles;
CREATE TABLE tblObjectFiles (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) NOT NULL default '0',
  `Text` varchar(255) NOT NULL default '',
  Icon varchar(64) NOT NULL default '',
  IsFolder tinyint(4) NOT NULL default '0',
  ContentType varchar(32) NOT NULL default '',
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
  IsSearchable tinyint(1) NOT NULL default '1',
  `Charset` varchar(64) default NULL,
  Language varchar(5) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblObjectFiles`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblOrders`
--

DROP TABLE IF EXISTS tblOrders;
CREATE TABLE tblOrders (
  IntID int(11) NOT NULL auto_increment,
  IntOrderID int(11) default NULL,
  IntCustomerID int(11) default NULL,
  IntArticleID int(11) default NULL,
  IntQuantity int(11) default NULL,
  DateOrder datetime default NULL,
  DateShipping datetime default NULL,
  DatePayment datetime default NULL,
  Price varchar(20) default NULL,
  IntPayment_Type tinyint(4) default NULL,
  strSerial longtext NOT NULL,
  strSerialOrder longtext NOT NULL,
  PRIMARY KEY  (IntID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblOrders`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblPasswd`
--

DROP TABLE IF EXISTS tblPasswd;
CREATE TABLE tblPasswd (
  passwd varchar(32) NOT NULL default '',
  username varchar(128) NOT NULL default ''
) TYPE=MyISAM;

--
-- Dumping data for table `tblPasswd`
--

INSERT INTO tblPasswd VALUES ('21232f297a57a5a743894a0e4a801fc3','admin');

--
-- Table structure for table `tblPrefs`
--

DROP TABLE IF EXISTS tblPrefs;
CREATE TABLE tblPrefs (
  userID bigint(20) NOT NULL default '0',
  FileFilter int(11) NOT NULL default '0',
  openFolders_tblFile text NOT NULL,
  openFolders_tblTemplates text NOT NULL,
  DefaultTemplateID int(11) NOT NULL default '0',
  DefaultStaticExt varchar(7) NOT NULL default '',
  DefaultDynamicExt varchar(7) NOT NULL default '',
  DefaultHTMLExt varchar(7) NOT NULL default '',
  sizeOpt tinyint(1) NOT NULL default '0',
  weWidth int(11) NOT NULL default '0',
  weHeight int(11) NOT NULL default '0',
  usePlugin tinyint(1) NOT NULL default '0',
  autostartPlugin tinyint(1) NOT NULL default '0',
  promptPlugin tinyint(1) NOT NULL default '0',
  Language varchar(64) NOT NULL default '',
  openFolders_tblObject text,
  openFolders_tblObjectFiles text,
  phpOnOff tinyint(1) NOT NULL default '0',
  seem_start_file int(11) NOT NULL default '0',
  seem_start_type varchar(10) NOT NULL default '',
  editorSizeOpt tinyint(1) NOT NULL default '0',
  editorWidth int(11) NOT NULL default '0',
  editorHeight int(11) NOT NULL default '0',
  debug_normal tinyint(1) NOT NULL default '0',
  debug_seem tinyint(1) NOT NULL default '0',
  editorFontname varchar(255) NOT NULL default '',
  editorFontsize int(2) NOT NULL default '0',
  editorFont tinyint(1) NOT NULL default '0',
  default_tree_count int(11) NOT NULL default '0',
  xhtml_show_wrong tinyint(1) NOT NULL default '0',
  xhtml_show_wrong_text tinyint(2) NOT NULL default '0',
  xhtml_show_wrong_js tinyint(2) NOT NULL default '0',
  xhtml_show_wrong_error_log tinyint(2) NOT NULL default '0',
  import_from varchar(255) NOT NULL default '',
  siteImportPrefs longtext NOT NULL,
  cockpit_amount_last_documents int(2) NOT NULL default '3',
  cockpit_rss_feed_url text,
  use_jupload tinyint(1) NOT NULL default '1',
  cockpit_dat text,
  cockpit_amount_columns int(2) NOT NULL default '3',
  message_reporting int(11) NOT NULL default '7',
  force_glossary_check tinyint(1) NOT NULL default '0',
  force_glossary_action tinyint(1) NOT NULL default '0'
) TYPE=MyISAM;

--
-- Dumping data for table `tblPrefs`
--


INSERT INTO tblPrefs VALUES (1,0,'1','1,10',0,'.html','.php','.html',0,0,0,0,0,0,'Deutsch','','',0,98,'',1,900,700,0,0,'none',-1,0,20,0,0,0,0,'','',5,'http://webedition.de/de/Presse/Pressemeldungen/rss2.xml',1,'a:3:{i:0;a:2:{i:0;a:4:{i:0;s:3:"pad";i:1;s:4:"blue";i:2;i:1;i:3;s:18:"U29uc3RpZ2Vz,30020";}i:1;a:4:{i:0;s:3:"mfd";i:1;s:5:"green";i:2;i:1;i:3;s:12:"1111;0;5;00;";}}i:1;a:2:{i:0;a:4:{i:0;s:3:"rss";i:1;s:6:"yellow";i:2;i:1;i:3;s:106:"aHR0cDovL3d3dy53ZWJlZGl0aW9uLmRlL2RlL1ByZXNzZS9QcmVzc2VtZWxkdW5nZW4vcnNzMi54bWw=,111000,0,110000,1";}i:1;a:4:{i:0;s:3:"sct";i:1;s:3:"red";i:2;i:1;i:3;s:124:"open_document,new_document,new_template,new_directory,unpublished_pages;unpublished_objects,new_object,new_class,preferences";}}i:2;a:20:{i:0;a:2:{i:0;s:16:"bGl2aW5nLWUgQUc=";i:1;s:88:"aHR0cDovL3d3dy5saXZpbmctZS5kZS9kZS9wcmVzc2V6ZW50cnVtL3ByLW1pdHRlaWx1bmdlbi9yc3MyLnhtbA==";}i:1;a:2:{i:0;s:16:"Rk9DVVMtT25saW5l";i:1;s:60:"aHR0cDovL2ZvY3VzLm1zbi5kZS9mb2wvWE1ML3Jzc19mb2xuZXdzLnhtbA==";}i:2;a:2:{i:0;s:12:"U2xhc2hkb3Q=";i:1;s:56:"aHR0cDovL3Jzcy5zbGFzaGRvdC5vcmcvU2xhc2hkb3Qvc2xhc2hkb3Q=";}i:3;a:2:{i:0;s:24:"aGVpc2Ugb25saW5lIE5ld3M=";i:1;s:56:"aHR0cDovL3d3dy5oZWlzZS5kZS9uZXdzdGlja2VyL2hlaXNlLnJkZg==";}i:4;a:2:{i:0;s:20:"dGFnZXNzY2hhdS5kZQ==";i:1;s:68:"aHR0cDovL3d3dy50YWdlc3NjaGF1LmRlL3htbC90YWdlc3NjaGF1LW1lbGR1bmdlbi8=";}i:5;a:2:{i:0;s:12:"U0FUVklTSU9O";i:1;s:52:"aHR0cDovL3d3dy5zYXR2aXNpb24ub3JnL25ld3MvcnNzLnhtbA==";}i:6;a:2:{i:0;s:20:"QmFzZWwtSUkuaW5mbw==";i:1;s:52:"aHR0cDovL3d3dy5iYXNlbC1paS5pbmZvL0Jhc2VsLUlJLnBocA==";}i:7;a:2:{i:0;s:52:"LrAuTGlxdWlkIE1vdGlvbiBXZWItICYgR3JhZmlrZGVzaWdusC6w";i:1;s:52:"aHR0cDovL3d3dy5saXF1aWQtbW90aW9uLmRlL3Jzcy9yc3MueG1s";}i:8;a:2:{i:0;s:12:"RkFaLk5FVA==";i:1;s:64:"aHR0cDovL3d3dy5mYXoubmV0L3MvUnViL1RwbH5FcGFydG5lcn5TUnNzXy54bWw=";}i:9;a:2:{i:0;s:20:"RmlsbXN0YXJ0cy5kZQ==";i:1;s:60:"aHR0cDovL3d3dy5maWxtc3RhcnRzLmRlL3htbC9maWxtc3RhcnRzLnhtbA==";}i:10;a:2:{i:0;s:20:"TkVUWkVJVFVORy5ERQ==";i:1;s:76:"aHR0cDovL3d3dy5uZXR6ZWl0dW5nLmRlL2V4cG9ydC9uZXdzL3Jzcy90aXRlbHNlaXRlLnhtbA==";}i:11;a:2:{i:0;s:28:"aHR0cDovL3d3dy5zcGllZ2VsLmRl";i:1;s:52:"aHR0cDovL3d3dy5zcGllZ2VsLmRlL3NjaGxhZ3plaWxlbi9yc3Mv";}i:12;a:2:{i:0;s:8:"R0VPLmRl";i:1;s:48:"aHR0cDovL3d3dy5nZW8uZGUvcnNzL0dFTy9pbmRleC54bWw=";}i:13;a:2:{i:0;s:44:"MTAwMGUgU3By/GNoZSAoU3BydWNoIGRlcyBUYWdlcyk=";i:1;s:96:"aHR0cDovL3d3dy5ob21lcGFnZXNlcnZpY2Uudm9zc3dlYi5pbmZvL2F1c3dhaGwvc3BydWNoL3Jzcy9oZXV0ZS9yc3MueG1s";}i:14;a:2:{i:0;s:32:"QnVuZGVzcmVnaWVydW5nIEFrdHVlbGw=";i:1;s:56:"aHR0cDovL3d3dy5idW5kZXNyZWdpZXJ1bmcuZGUvYWt0dWVsbC5yc3M=";}i:15;a:2:{i:0;s:20:"QW53YWx0cy1UaXBwcw==";i:1;s:60:"aHR0cDovL3d3dy5hbndhbHRzc3VjaGRpZW5zdC5kZS9yc3MvcnNzLnhtbA==";}i:16;a:2:{i:0;s:56:"UHJvbW9NYXN0ZXJzIEludGVybmV0IE1hcmtldGluZyBSU1MgQmxvZw==";i:1;s:56:"aHR0cDovL3d3dy5wcm9tb21hc3RlcnMuYXQvcnNzL2luZGV4LnhtbA==";}i:17;a:2:{i:0;s:20:"U1dSMyBSREYtRmVlZA==";i:1;s:40:"aHR0cDovL3d3dy5zd3IzLmRlL3JkZi1mZWVkLw==";}i:18;a:2:{i:0;s:12:"Q0hJUC5ERQ==";i:1;s:44:"aHR0cDovL3d3dy5jaGlwLmRlL3Jzc19uZXdzLnhtbA==";}i:19;a:2:{i:0;s:12:"U3Rlcm4uZGU=";i:1;s:64:"aHR0cDovL3d3dy5zdGVybi5kZS9zdGFuZGFyZC9yc3MucGhwP2NoYW5uZWw9YWxs";}}}',2,7,0,0);
--
-- Table structure for table `tblRecipients`
--

DROP TABLE IF EXISTS tblRecipients;
CREATE TABLE tblRecipients (
  ID bigint(20) NOT NULL auto_increment,
  Email varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblRecipients`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblSchedule`
--

DROP TABLE IF EXISTS tblSchedule;
CREATE TABLE tblSchedule (
  DID bigint(20) NOT NULL default '0',
  Wann int(11) NOT NULL default '0',
  Was int(11) NOT NULL default '0',
  ClassName varchar(64) NOT NULL default '',
  SerializedData longblob,
  Schedpro longtext,
  `Type` tinyint(3) NOT NULL default '0',
  Active tinyint(1) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table `tblSchedule`
--


--
-- Table structure for table `tblTODO`
--

DROP TABLE IF EXISTS tblTODO;
CREATE TABLE tblTODO (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) default NULL,
  UserID int(11) NOT NULL default '0',
  account_id int(11) NOT NULL default '0',
  msg_type tinyint(4) NOT NULL default '0',
  obj_type tinyint(4) NOT NULL default '0',
  headerDate int(11) default NULL,
  headerSubject varchar(255) default NULL,
  headerCreator int(11) default NULL,
  headerAssigner int(11) default NULL,
  headerStatus tinyint(4) default NULL,
  headerDeadline int(11) default NULL,
  Priority tinyint(4) default NULL,
  Properties smallint(5) unsigned default NULL,
  MessageText text,
  Content_Type varchar(10) default NULL,
  seenStatus tinyint(3) unsigned default NULL,
  tag tinyint(3) unsigned default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblTODO`
--


--
-- Table structure for table `tblTODOHistory`
--

DROP TABLE IF EXISTS tblTODOHistory;
CREATE TABLE tblTODOHistory (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) NOT NULL default '0',
  UserID int(11) NOT NULL default '0',
  fromUserID int(11) NOT NULL default '0',
  `Comment` text,
  Created int(11) default NULL,
  `action` int(10) unsigned default NULL,
  `status` tinyint(3) unsigned default NULL,
  tag tinyint(3) unsigned default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblTODOHistory`
--


--
-- Table structure for table `tblTemplates`
--

DROP TABLE IF EXISTS tblTemplates;
CREATE TABLE tblTemplates (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) NOT NULL default '0',
  `Text` varchar(255) NOT NULL default '',
  Icon varchar(64) NOT NULL default '',
  IsFolder tinyint(4) NOT NULL default '0',
  ContentType varchar(32) NOT NULL default '',
  CreationDate int(11) NOT NULL default '0',
  ModDate int(11) NOT NULL default '0',
  Path varchar(255) NOT NULL default '',
  Filename varchar(64) NOT NULL default '',
  Extension varchar(10) NOT NULL default '',
  ClassName varchar(64) NOT NULL default '',
  Deleted int(11) NOT NULL default '0',
  Owners varchar(255) default NULL,
  RestrictOwners tinyint(1) default NULL,
  OwnersReadOnly text,
  CreatorID bigint(20) NOT NULL default '0',
  ModifierID bigint(20) NOT NULL default '0',
  MasterTemplateID bigint(20) NOT NULL default '0',
  IncludedTemplates varchar(255) NOT NULL default '',
  CacheType ENUM( '', 'none', 'tag', 'document', 'full' ) DEFAULT 'none' NOT NULL,
  CacheLifeTime int(5) NOT NULL default '0',
  PRIMARY KEY  (ID),
  KEY MasterTemplateID (MasterTemplateID),
  KEY IncludedTemplates (IncludedTemplates)
) TYPE=MyISAM;

--
-- Dumping data for table `tblTemplates`
--

-- ------------------------------------------------------------------------


--
-- Table structure for table `tblTemporaryDoc`
--

DROP TABLE IF EXISTS tblTemporaryDoc;
CREATE TABLE tblTemporaryDoc (
  ID bigint(20) NOT NULL auto_increment,
  DocumentID bigint(20) NOT NULL default '0',
  DocumentObject longtext NOT NULL,
  DocTable varchar(64) NOT NULL default '',
  UnixTimestamp bigint(20) NOT NULL default '0',
  Active tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblTemporaryDoc`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblUpdateLog`
--

DROP TABLE IF EXISTS tblUpdateLog;
CREATE TABLE tblUpdateLog (
  ID int(255) NOT NULL auto_increment,
  dortigeID int(255) NOT NULL default '0',
  datum datetime default NULL,
  aktion text NOT NULL,
  versionsnummer varchar(10) NOT NULL default '',
  module text NOT NULL,
  error tinyint(1) NOT NULL default '0',
  step int(4) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblUpdateLog`
--


--
-- Table structure for table `tblUser`
--

DROP TABLE IF EXISTS tblUser;
CREATE TABLE tblUser (
  ID bigint(20) NOT NULL auto_increment,
  ParentID bigint(20) NOT NULL default '0',
  `Text` varchar(255) NOT NULL default '',
  Path varchar(255) NOT NULL default '',
  Icon varchar(64) NOT NULL default '',
  IsFolder tinyint(1) NOT NULL default '0',
  `Type` tinyint(4) NOT NULL default '0',
  `First` varchar(255) NOT NULL default '',
  `Second` varchar(255) NOT NULL default '',
  Address varchar(255) NOT NULL default '',
  HouseNo varchar(11) NOT NULL default '',
  City varchar(255) NOT NULL default '',
  PLZ int(11) NOT NULL default '0',
  State varchar(255) NOT NULL default '',
  Country varchar(255) NOT NULL default '',
  Tel_preselection varchar(11) NOT NULL default '',
  Telephone varchar(32) NOT NULL default '',
  Fax_preselection varchar(11) NOT NULL default '',
  Fax varchar(32) NOT NULL default '',
  Handy varchar(32) NOT NULL default '',
  Email varchar(255) NOT NULL default '',
  Description text NOT NULL,
  username varchar(255) NOT NULL default '',
  passwd varchar(255) NOT NULL default '',
  Permissions text NOT NULL,
  ParentPerms tinyint(4) NOT NULL default '0',
  Alias bigint(20) NOT NULL default '0',
  CreatorID bigint(20) NOT NULL default '0',
  CreateDate bigint(20) NOT NULL default '0',
  ModifierID bigint(20) NOT NULL default '0',
  ModifyDate bigint(20) NOT NULL default '0',
  Ping int(11) NOT NULL default '0',
  Portal varchar(255) NOT NULL default '',
  workSpace varchar(255) NOT NULL default '',
  workSpaceDef varchar(255) NOT NULL default '',
  workSpaceTmp varchar(255) NOT NULL default '',
  workSpaceNav varchar(255) NOT NULL default '',
  workSpaceObj varchar(255) NOT NULL default '',
  workSpaceNwl varchar(255) NOT NULL default '',
  ParentWs tinyint(4) NOT NULL default '0',
  ParentWst tinyint(4) NOT NULL default '0',
  ParentWsn tinyint(4) NOT NULL default '0',
  ParentWso tinyint(4) NOT NULL default '0',
  ParentWsnl tinyint(4) NOT NULL default '0',
  Salutation varchar(32) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblUser`
--

INSERT INTO tblUser VALUES (1,0,'andy','/andy','user.gif',0,0,'webEdition','','','','',0,'','','','','','','','','','admin','21232f297a57a5a743894a0e4a801fc3','a:55:{s:13:\"ADMINISTRATOR\";s:1:\"1\";s:18:\"NEW_WEBEDITIONSITE\";s:1:\"1\";s:10:\"NEW_GRAFIK\";s:1:\"1\";s:8:\"NEW_HTML\";s:1:\"1\";s:9:\"NEW_FLASH\";s:1:\"1\";s:6:\"NEW_JS\";s:1:\"1\";s:7:\"NEW_CSS\";s:1:\"1\";s:12:\"NEW_SONSTIGE\";s:1:\"1\";s:12:\"NEW_TEMPLATE\";s:1:\"1\";s:14:\"NEW_DOC_FOLDER\";s:1:\"1\";s:22:\"CHANGE_DOC_FOLDER_PATH\";s:1:\"0\";s:15:\"NEW_TEMP_FOLDER\";s:1:\"1\";s:17:\"CAN_SEE_DOCUMENTS\";s:1:\"1\";s:17:\"CAN_SEE_TEMPLATES\";s:1:\"1\";s:22:\"SAVE_DOCUMENT_TEMPLATE\";s:1:\"1\";s:17:\"DELETE_DOC_FOLDER\";s:1:\"1\";s:18:\"DELETE_TEMP_FOLDER\";s:1:\"1\";s:15:\"DELETE_DOCUMENT\";s:1:\"1\";s:15:\"DELETE_TEMPLATE\";s:1:\"1\";s:13:\"BROWSE_SERVER\";s:1:\"1\";s:12:\"EDIT_DOCTYPE\";s:1:\"1\";s:14:\"EDIT_KATEGORIE\";s:1:\"1\";s:7:\"REBUILD\";s:1:\"1\";s:6:\"EXPORT\";s:1:\"1\";s:6:\"IMPORT\";s:1:\"1\";s:9:\"NEW_GROUP\";s:1:\"1\";s:8:\"NEW_USER\";s:1:\"1\";s:10:\"SAVE_GROUP\";s:1:\"1\";s:9:\"SAVE_USER\";s:1:\"1\";s:12:\"DELETE_GROUP\";s:1:\"1\";s:11:\"DELETE_USER\";s:1:\"1\";s:7:\"PUBLISH\";s:1:\"1\";s:21:\"EDIT_SETTINGS_DEF_EXT\";s:1:\"1\";s:13:\"EDIT_SETTINGS\";s:1:\"1\";s:11:\"EDIT_PASSWD\";s:1:\"1\";s:12:\"NEW_CUSTOMER\";s:1:\"0\";s:15:\"DELETE_CUSTOMER\";s:1:\"0\";s:13:\"EDIT_CUSTOMER\";s:1:\"0\";s:19:\"SHOW_CUSTOMER_ADMIN\";s:1:\"0\";s:16:\"NEW_SHOP_ARTICLE\";s:1:\"0\";s:19:\"DELETE_SHOP_ARTICLE\";s:1:\"0\";s:15:\"EDIT_SHOP_ORDER\";s:1:\"0\";s:17:\"DELETE_SHOP_ORDER\";s:1:\"0\";s:15:\"EDIT_SHOP_PREFS\";s:1:\"0\";s:19:\"CAN_SEE_OBJECTFILES\";s:1:\"1\";s:14:\"NEW_OBJECTFILE\";s:1:\"1\";s:21:\"NEW_OBJECTFILE_FOLDER\";s:1:\"1\";s:17:\"DELETE_OBJECTFILE\";s:1:\"1\";s:15:\"CAN_SEE_OBJECTS\";s:1:\"0\";s:10:\"NEW_OBJECT\";s:1:\"0\";s:13:\"DELETE_OBJECT\";s:1:\"0\";s:12:\"NEW_WORKFLOW\";s:1:\"0\";s:15:\"DELETE_WORKFLOW\";s:1:\"0\";s:13:\"EDIT_WORKFLOW\";s:1:\"0\";s:9:\"EMPTY_LOG\";s:1:\"0\";}',0,0,0,0,0,0,1146233940,'','','','','','','',0,0,0,0,0,'');

--
-- Table structure for table `tblWebAdmin`
--

DROP TABLE IF EXISTS tblWebAdmin;
CREATE TABLE tblWebAdmin (
  Name varchar(255) NOT NULL default '',
  `Value` text NOT NULL
) TYPE=MyISAM;

--
-- Dumping data for table `tblWebAdmin`
--

INSERT INTO tblWebAdmin VALUES ('FieldAdds','a:9:{s:13:\"Newsletter_Ok\";a:1:{s:7:\"default\";s:3:\",ja\";}s:25:\"Newsletter_HTMLNewsletter\";a:1:{s:7:\"default\";s:3:\",ja\";}s:17:\"Kontakt_Addresse1\";a:1:{s:7:\"default\";s:0:\"\";}s:17:\"Kontakt_Addresse2\";a:1:{s:7:\"default\";s:0:\"\";}s:18:\"Kontakt_Bundesland\";a:1:{s:7:\"default\";s:214:\"Baden-W�rttemberg,Bayern,Berlin,Brandenburg,Bremen,Hamburg,Hessen,Mecklenburg-Vorpommern,Niedersachsen,Nordrhein-Westfalen,Rheinland-PfalzRheinland-Pfalz,Saarland,Sachsen,Sachsen-Anhalt,Schleswig-Holstein,Th�ringen\";}s:12:\"Kontakt_Land\";a:1:{s:7:\"default\";s:0:\"\";}s:13:\"Anrede_Anrede\";a:1:{s:7:\"default\";s:10:\",Herr,Frau\";}s:12:\"Anrede_Titel\";a:1:{s:7:\"default\";s:11:\",Dr., Prof.\";}s:6:\"Gruppe\";a:1:{s:7:\"default\";s:22:\"Administratoren,Kunden\";}}');
INSERT INTO tblWebAdmin VALUES ('Prefs','a:2:{s:10:\"start_year\";s:4:\"1900\";s:17:\"default_sort_view\";s:6:\"Gruppe\";}');
INSERT INTO tblWebAdmin VALUES ('SortView','a:1:{s:6:\"Gruppe\";a:1:{i:0;a:4:{s:6:\"branch\";s:8:\"Sonstige\";s:5:\"field\";s:6:\"Gruppe\";s:8:\"function\";s:0:\"\";s:5:\"order\";s:3:\"ASC\";}}}');

--
-- Table structure for table `tblWebUser`
--

DROP TABLE IF EXISTS tblWebUser;
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

--
-- Dumping data for table `tblWebUser`
--

INSERT INTO tblWebUser VALUES (1,'admin','admin','','','webEdition1','Software GmbH','Waldstrasse 40b','76133 Karlsruhe','Baden-W�rttemberg','Deutschland','','','','','',0,'1144395493','1144397956','1144397956',0,'/admin',0,'customer.gif','admin','','','Administratoren');
INSERT INTO tblWebUser VALUES (2,'customer','customer','','','web','user','webland','universe','Saarland','','','','','','',0,'0','0','0',0,'/customer',0,'customer.gif','customer','','','Kunden');

--
-- Table structure for table `tblWorkflowDef`
--

DROP TABLE IF EXISTS tblWorkflowDef;
CREATE TABLE tblWorkflowDef (
  ID int(11) NOT NULL auto_increment,
  `Text` varchar(255) NOT NULL default '',
  `Type` bigint(20) NOT NULL default '0',
  Folders varchar(255) NOT NULL default '',
  DocType bigint(20) NOT NULL default '0',
  Objects varchar(255) NOT NULL default '',
  Categories varchar(255) NOT NULL default '',
  ObjCategories varchar(255) NOT NULL default '',
  `Status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblWorkflowDef`
--


--
-- Table structure for table `tblWorkflowDoc`
--

DROP TABLE IF EXISTS tblWorkflowDoc;
CREATE TABLE tblWorkflowDoc (
  ID int(11) NOT NULL auto_increment,
  workflowID int(11) NOT NULL default '0',
  documentID int(11) NOT NULL default '0',
  userID int(11) NOT NULL default '0',
  `Status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblWorkflowDoc`
--


--
-- Table structure for table `tblWorkflowDocStep`
--

DROP TABLE IF EXISTS tblWorkflowDocStep;
CREATE TABLE tblWorkflowDocStep (
  ID int(11) NOT NULL auto_increment,
  workflowDocID int(11) NOT NULL default '0',
  workflowStepID bigint(20) NOT NULL default '0',
  startDate bigint(20) NOT NULL default '0',
  finishDate bigint(20) NOT NULL default '0',
  `Status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblWorkflowDocStep`
--


--
-- Table structure for table `tblWorkflowDocTask`
--

DROP TABLE IF EXISTS tblWorkflowDocTask;
CREATE TABLE tblWorkflowDocTask (
  ID int(11) NOT NULL auto_increment,
  documentStepID bigint(20) NOT NULL default '0',
  workflowTaskID bigint(20) NOT NULL default '0',
  `Date` bigint(20) NOT NULL default '0',
  todoID bigint(20) NOT NULL default '0',
  `Status` int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblWorkflowDocTask`
--


--
-- Table structure for table `tblWorkflowLog`
--

DROP TABLE IF EXISTS tblWorkflowLog;
CREATE TABLE tblWorkflowLog (
  ID bigint(20) NOT NULL auto_increment,
  RefID bigint(20) NOT NULL default '0',
  docTable varchar(255) NOT NULL default '',
  userID bigint(20) NOT NULL default '0',
  logDate bigint(20) NOT NULL default '0',
  `Type` tinyint(4) NOT NULL default '0',
  Description varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblWorkflowLog`
--


--
-- Table structure for table `tblWorkflowStep`
--

DROP TABLE IF EXISTS tblWorkflowStep;
CREATE TABLE tblWorkflowStep (
  ID int(11) NOT NULL auto_increment,
  Worktime int(11) NOT NULL default '0',
  timeAction tinyint(1) NOT NULL default '0',
  stepCondition int(11) NOT NULL default '0',
  workflowID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblWorkflowStep`
--


--
-- Table structure for table `tblWorkflowTask`
--

DROP TABLE IF EXISTS tblWorkflowTask;
CREATE TABLE tblWorkflowTask (
  ID int(11) NOT NULL auto_increment,
  userID int(11) NOT NULL default '0',
  Edit int(11) NOT NULL default '0',
  Mail int(11) NOT NULL default '0',
  stepID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblWorkflowTask`
--


--
-- Table structure for table `tblbanner`
--

DROP TABLE IF EXISTS tblbanner;
CREATE TABLE tblbanner (
  ID bigint(20) NOT NULL auto_increment,
  ParentID bigint(20) NOT NULL default '0',
  `Text` varchar(255) NOT NULL default '',
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
  IsActive tinyint(1) NOT NULL default '0',
  clicks bigint(20) NOT NULL default '0',
  views bigint(20) NOT NULL default '0',
  Customers varchar(255) NOT NULL default '',
  TagName varchar(255) NOT NULL default '',
  weight tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblbanner`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblbannerclicks`
--

DROP TABLE IF EXISTS tblbannerclicks;
CREATE TABLE tblbannerclicks (
  ID bigint(20) NOT NULL default '0',
  `Timestamp` bigint(20) default NULL,
  IP varchar(30) NOT NULL default '',
  Referer varchar(255) NOT NULL default '',
  DID bigint(20) NOT NULL default '0',
  Page varchar(255) NOT NULL default ''
) TYPE=MyISAM;

--
-- Dumping data for table `tblbannerclicks`
--


--
-- Table structure for table `tblbannerprefs`
--

DROP TABLE IF EXISTS tblbannerprefs;
CREATE TABLE tblbannerprefs (
  pref_name varchar(255) NOT NULL default '',
  pref_value varchar(255) NOT NULL default ''
) TYPE=MyISAM;

--
-- Dumping data for table `tblbannerprefs`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblbannerviews`
--

DROP TABLE IF EXISTS tblbannerviews;
CREATE TABLE tblbannerviews (
  ID bigint(20) NOT NULL default '0',
  `Timestamp` bigint(20) default NULL,
  IP varchar(30) NOT NULL default '',
  Referer varchar(255) NOT NULL default '',
  DID bigint(20) NOT NULL default '0',
  Page varchar(255) NOT NULL default ''
) TYPE=MyISAM;

--
-- Dumping data for table `tblbannerviews`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblexport`
--

DROP TABLE IF EXISTS tblexport;
CREATE TABLE tblexport (
  ID bigint(20) NOT NULL auto_increment,
  ParentID bigint(20) NOT NULL default '0',
  `Text` varchar(255) NOT NULL default '',
  Icon varchar(255) NOT NULL default '',
  IsFolder tinyint(1) NOT NULL default '0',
  Path varchar(255) NOT NULL default '',
  ExportTo varchar(255) NOT NULL default '',
  ServerPath varchar(255) NOT NULL default '',
  Filename varchar(255) NOT NULL default '',
  Selection varchar(255) NOT NULL default '',
  SelectionType varchar(255) NOT NULL default '',
  DocType varchar(255) NOT NULL default '',
  Folder bigint(20) NOT NULL default '0',
  ClassName varchar(255) NOT NULL default '',
  Categorys varchar(255) NOT NULL default '',
  selDocs text NOT NULL,
  selTempl text NOT NULL,
  selObjs text NOT NULL,
  selClasses text NOT NULL,
  HandleDefTemplates tinyint(1) NOT NULL default '0',
  HandleDocIncludes tinyint(1) NOT NULL default '0',
  HandleObjIncludes tinyint(1) NOT NULL default '0',
  HandleDocLinked tinyint(1) NOT NULL default '0',
  HandleDefClasses tinyint(1) NOT NULL default '0',
  HandleObjEmbeds tinyint(1) NOT NULL default '0',
  HandleDoctypes tinyint(1) NOT NULL default '0',
  HandleCategorys tinyint(1) NOT NULL default '0',
  ExportDepth varchar(255) NOT NULL default '',
  HandleOwners tinyint(1) NOT NULL default '0',
  HandleNavigation tinyint(1) NOT NULL default '0',
  HandleThumbnails tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblexport`
--


--
-- Table structure for table `tblhistory`
--

DROP TABLE IF EXISTS tblhistory;
CREATE TABLE tblhistory (
  ID bigint(20) NOT NULL auto_increment,
  DID bigint(20) NOT NULL default '0',
  DocumentTable varchar(64) NOT NULL default '',
  ContentType varchar(32) NOT NULL default '',
  ModDate bigint(20) NOT NULL default '0',
  Act varchar(16) NOT NULL default '',
  UserName varchar(64) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblhistory`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblnavigation`
--

DROP TABLE IF EXISTS tblnavigation;
CREATE TABLE tblnavigation (
  ID bigint(20) NOT NULL auto_increment,
  ParentID bigint(20) NOT NULL default '0',
  Path varchar(255) NOT NULL default '',
  `Text` varchar(255) NOT NULL default '',
  ContentType varchar(255) NOT NULL default 'weNavigation',
  Icon varchar(32) NOT NULL default '0',
  IsFolder tinyint(4) NOT NULL default '0',
  TitleField varchar(255) NOT NULL default '',
  IconID bigint(20) NOT NULL default '0',
  Selection varchar(32) NOT NULL default '',
  LinkID bigint(20) NOT NULL default '0',
  SelectionType varchar(32) NOT NULL default '',
  FolderID bigint(20) NOT NULL default '0',
  DocTypeID bigint(20) NOT NULL default '0',
  ClassID bigint(20) NOT NULL default '0',
  Categories text NOT NULL,
  Sort text NOT NULL,
  ShowCount int(11) NOT NULL default '0',
  Ordn int(11) NOT NULL default '0',
  Depended tinyint(4) NOT NULL default '0',
  WorkspaceID bigint(20) NOT NULL default '-1',
  CatParameter varchar(255) NOT NULL default '',
  Parameter varchar(255) NOT NULL default '',
  LinkSelection varchar(255) NOT NULL default '',
  Url varchar(255) NOT NULL default '',
  UrlID bigint(20) NOT NULL default '0',
  Charset varchar(255) NOT NULL default '',
  Attributes text NOT NULL,
  FolderSelection varchar(32) NOT NULL default '',
  FolderWsID bigint(20) NOT NULL default '0',
  FolderParameter varchar(255) NOT NULL default '',
  FolderUrl varchar(255) NOT NULL default '',
  LimitAccess tinyint(4) NOT NULL default '0',
  AllCustomers tinyint(4) NOT NULL default '1',
  ApplyFilter tinyint(4) NOT NULL default '0',
  Customers text NOT NULL,
  CustomerFilter text NOT NULL,
  PRIMARY KEY  (ID)
) Type=MyISAM;

--
-- Dumping data for table `tblnavigation`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblnavigationrules`
--

DROP TABLE IF EXISTS tblnavigationrules;
CREATE TABLE tblnavigationrules (
  ID int(11) NOT NULL auto_increment,
  NavigationName varchar(255) default NULL,
  NavigationID int(11) NOT NULL default '0',
  SelectionType varchar(16) NOT NULL default '',
  FolderID int(11) NOT NULL default '0',
  DoctypeID int(11) NOT NULL default '0',
  Categories varchar(255) NOT NULL default '',
  ClassID int(11) NOT NULL default '0',
  WorkspaceID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblnavigationrules`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblshopvats`
--

DROP TABLE IF EXISTS tblshopvats;
CREATE TABLE tblshopvats (
  id int(11) NOT NULL auto_increment,
  `text` varchar(255) NOT NULL default '',
  vat varchar(16) NOT NULL default '',
  standard tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table `tblshopvats`
--


--
-- Table structure for table `tblthumbnails`
--

DROP TABLE IF EXISTS tblthumbnails;
CREATE TABLE tblthumbnails (
  ID bigint(20) NOT NULL auto_increment,
  Name varchar(255) NOT NULL default '',
  `Date` int(11) unsigned NOT NULL default '0',
  Format char(3) NOT NULL default '',
  Height smallint(5) unsigned default NULL,
  Width smallint(5) unsigned default NULL,
  Ratio tinyint(1) NOT NULL default '0',
  Maxsize tinyint(1) NOT NULL default '0',
  Interlace tinyint(1) NOT NULL default '1',
  `Directory` varchar(255) NOT NULL default '',
  Utilize tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblthumbnails`
--

-- ------------------------------------------------------------------------

--
-- Table structure for table `tblvalidationservices`
--

DROP TABLE IF EXISTS tblvalidationservices;
CREATE TABLE tblvalidationservices (
  PK_tblvalidationservices int(11) NOT NULL auto_increment,
  category varchar(20) NOT NULL default '',
  name varchar(255) NOT NULL default '',
  host varchar(255) NOT NULL default '',
  path varchar(255) NOT NULL default '',
  method varchar(4) NOT NULL default '',
  varname varchar(255) NOT NULL default '',
  checkvia varchar(20) NOT NULL default '',
  additionalVars varchar(255) NOT NULL default '',
  ctype varchar(20) NOT NULL default '',
  fileEndings varchar(255) NOT NULL default '',
  active tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (PK_tblvalidationservices)
) TYPE=MyISAM;

--
-- Dumping data for table `tblvalidationservices`
--


--
-- Table structure for table `tblvoting`
--

DROP TABLE IF EXISTS tblvoting;
CREATE TABLE tblvoting (
  ID bigint(20) NOT NULL auto_increment,
  ParentID bigint(20) NOT NULL default '0',
  Path varchar(255) default NULL,
  IsFolder tinyint(1) default NULL,
  Icon varchar(255) default NULL,
  `Text` varchar(255) NOT NULL default '',
  PublishDate bigint(20) NOT NULL default '0',
  QASet text NOT NULL,
  Scores text NOT NULL,
  RevoteControl tinyint(1) NOT NULL default '0',
  RevoteTime int(11) NOT NULL default '0',
  Owners text NOT NULL,
  RestrictOwners tinyint(1) NOT NULL default '0',
  Revote longtext NOT NULL,
  RevoteUserAgent longtext NOT NULL,
  Valid bigint(20) NOT NULL default '0',
  Active tinyint(1) NOT NULL default '0',
  ActiveTime tinyint(1) NOT NULL default '0',
  FallbackIp tinyint(1) NOT NULL default '0',
  UserAgent tinyint(1) NOT NULL default '0',
  Log tinyint(1) NOT NULL default '0',
  LogData longtext NOT NULL,
  RestrictIP tinyint(1) NOT NULL default '0',
  BlackList longtext NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `tblvoting`
--


--
-- Table structure for table `tblglossary`
--

CREATE TABLE `tblglossary` (
  `ID` int(10) NOT NULL auto_increment,
  `Path` varchar(255) default NULL,
  `IsFolder` tinyint(1) default NULL,
  `Icon` varchar(255) default NULL,
  `Text` varchar(255) NOT NULL default '',
  `Type` enum('abbreviation','acronym','foreignword','link') NOT NULL default 'abbreviation',
  `Language` varchar(5) NOT NULL default '',
  `Title` tinytext NOT NULL,
  `Attributes` text NOT NULL,
  `Linked` int(1) NOT NULL default '0',
  `Description` text NOT NULL,
  `CreationDate` int(11) NOT NULL default '0',
  `ModDate` int(11) NOT NULL default '0',
  `Published` int(11) NOT NULL default '0',
  `CreatorID` bigint(20) NOT NULL default '0',
  `ModifierID` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;


--
-- Table structure for table `tblwidgetnotepad`
--

CREATE TABLE IF NOT EXISTS `tblwidgetnotepad` (
  `ID` bigint(20) NOT NULL auto_increment,
  `WidgetName` varchar(100) NOT NULL default '',
  `UserID` bigint(20) NOT NULL default '0',
  `CreationDate` date NOT NULL default '0000-00-00',
  `Title` varchar(255) NOT NULL default '',
  `Text` text NOT NULL,
  `Priority` enum('low','medium','high') NOT NULL default 'low',
  `Valid` enum('always','date','period') NOT NULL default 'always',
  `ValidFrom` date NOT NULL default '0000-00-00',
  `ValidUntil` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



--
-- Daten f�r Tabelle `tblwidgetnotepad`
--

INSERT INTO `tblwidgetnotepad` VALUES (1, 'Sonstiges', 1, '2007-05-24', 'Willkommen bei webEdition 5', 'Das Cockpit ist eine der Neuerungen in Version 5. Sie k�nnen im Cockpit-Men� verschiedene Widgets ausw�hlen. Jedes Widget ist �ber die obere Leiste "Eigenschaften" konfigurierbar und kann frei positioniert werden.', 'low', 'always', '2007-06-04', '2007-06-04');

-- ------------------------------------------------------------------------