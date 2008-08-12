
CREATE TABLE tblAnzeigePrefs (
  ID int(15) NOT NULL auto_increment,
  strDateiname varchar(255) NOT NULL default '',
  strFelder text NOT NULL,
  PRIMARY KEY  (ID),
  UNIQUE KEY ID (ID),
  KEY ID_2 (ID)
) TYPE=MyISAM;

INSERT INTO tblAnzeigePrefs VALUES (1,'edit_shop_properties','First name:tblWebUser||Forename,Last name:tblWebUser||Surname,Address 1:tblWebUser||Contact_Address1,Address 2:tblWebUser||Contact_Address2,Country:tblWebUser||Contact_Country,Quantity:webE||<quantity>,Title:webE||shoptitle,Description:webE||shopdescription,Amount:webE||<price>,Total:webE||<totalprice>');
INSERT INTO tblAnzeigePrefs VALUES (2,'shop_pref','$|16|german');


CREATE TABLE tblCategorys (
  ID int(11) NOT NULL auto_increment,
  Category varchar(64) NOT NULL default '',
  Text varchar(64) default NULL,
  Path varchar(255) default NULL,
  ParentID bigint(20) default '0',
  IsFolder tinyint(1) default '0',
  Icon varchar(64) default 'cat.gif',
  Catfields longtext NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblCleanUp (
  Path varchar(255) NOT NULL default '',
  Date int(11) NOT NULL default '0'
) TYPE=MyISAM;



CREATE TABLE tblContent (
  ID bigint(20) NOT NULL auto_increment,
  BDID int(11) NOT NULL default '0',
  Dat longtext,
  IsBinary tinyint(4) NOT NULL default '0',
  AutoBR char(3) NOT NULL default 'off',
  LanguageID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID),
  KEY link (ID,LanguageID),
  KEY search (ID,LanguageID,IsBinary)
) TYPE=MyISAM;



CREATE TABLE tblContentTypes (
  OrderNr int(11) NOT NULL default '0',
  ContentType varchar(32) NOT NULL default '',
  Extension varchar(128) NOT NULL default '',
  DefaultCode text NOT NULL,
  IconID int(11) NOT NULL default '0',
  Template tinyint(4) NOT NULL default '0',
  File tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ContentType)
) TYPE=MyISAM;


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
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblErrorLog (
  ID int(11) NOT NULL auto_increment,
  Text text NOT NULL,
  Date int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblexport (
  ID bigint(20) NOT NULL auto_increment,
  ParentID bigint(20) NOT NULL default '0',
  Text varchar(255) NOT NULL default '',
  Icon varchar(255) NOT NULL default 'link.gif',
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
  HandleDefTemplates varchar(255) NOT NULL default '',
  HandleDocIncludes varchar(255) NOT NULL default '',
  HandleObjIncludes varchar(255) NOT NULL default '',
  HandleDocLinked varchar(255) NOT NULL default '',
  HandleDefClasses varchar(255) NOT NULL default '',
  HandleObjEmbeds varchar(255) NOT NULL default '',
  HandleDoctypes varchar(255) NOT NULL default '',
  HandleCategorys varchar(255) NOT NULL default '',
  ExportDepth varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblFailedLogins (
  ID bigint(20) NOT NULL default '0',
  Username varchar(64) NOT NULL default '',
  Password varchar(32) NOT NULL default '',
  IP varchar(15) NOT NULL default '',
  LoginDate int(11) NOT NULL default '0'
) TYPE=MyISAM;

CREATE TABLE tblFile (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) NOT NULL default '0',
  Text varchar(255) binary NOT NULL default '',
  Icon varchar(64) NOT NULL default '',
  IsFolder tinyint(4) NOT NULL default '0',
  ContentType varchar(32) NOT NULL default '0',
  CreationDate int(11) NOT NULL default '0',
  ModDate int(11) NOT NULL default '0',
  Path varchar(255) binary NOT NULL default '',
  TemplateID int(11) NOT NULL default '0',
  Filename varchar(255) binary NOT NULL default '',
  Extension varchar(16) binary NOT NULL default '',
  IsDynamic tinyint(4) NOT NULL default '0',
  IsSearchable tinyint(1) NOT NULL default '0',
  DocType varchar(32) NOT NULL default '',
  ClassName varchar(64) NOT NULL default '',
  Category varchar(255) default NULL,
  Deleted int(11) NOT NULL default '0',
  Published int(11) NOT NULL default '0',
  CreatorID bigint(20) NOT NULL default '0',
  ModifierID bigint(20) NOT NULL default '0',
  RestrictOwners tinyint(1) NOT NULL default '0',
  Owners varchar(255) NOT NULL default '',
  OwnersReadOnly text NOT NULL,
  documentArray text NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblIndex (
  DID int(11) NOT NULL default '0',
  Text text NOT NULL,
  ID bigint(20) NOT NULL default '0',
  OID bigint(20) NOT NULL default '0',
  BText longblob NOT NULL,
  Workspace varchar(255) NOT NULL default '/',
  WorkspaceID bigint(20) NOT NULL default '0',
  Category varchar(255) NOT NULL default '',
  ClassID bigint(20) NOT NULL default '0',
  Doctype bigint(20) NOT NULL default '0',
  Title varchar(255) NOT NULL default '',
  Description text NOT NULL,
  Path varchar(255) NOT NULL default ''
) TYPE=MyISAM;


CREATE TABLE tblLink (
  DID int(11) NOT NULL default '0',
  CID int(11) NOT NULL default '0',
  Type varchar(16) NOT NULL default '0',
  Name varchar(255) NOT NULL default '',
  DocumentTable varchar(64) NOT NULL default 'tblFile',
  KEY DID (DID)
) TYPE=MyISAM;


CREATE TABLE tblLock (
  ID bigint(20) NOT NULL default '0',
  UserID bigint(20) NOT NULL default '0',
  tbl varchar(32) NOT NULL default ''
) TYPE=MyISAM;


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

INSERT INTO tblMsgFolders VALUES (1,0,1,-1,1,3,'Messages',NULL,NULL,1,NULL);
INSERT INTO tblMsgFolders VALUES (2,1,1,-1,1,5,'Sent',NULL,NULL,1,NULL);
INSERT INTO tblMsgFolders VALUES (3,0,1,-1,2,3,'Task',NULL,NULL,1,NULL);
INSERT INTO tblMsgFolders VALUES (4,3,1,-1,2,13,'Done',NULL,NULL,1,NULL);
INSERT INTO tblMsgFolders VALUES (5,3,1,-1,2,11,'rejected',NULL,NULL,1,NULL);

CREATE TABLE tblMsgSettings (
  ID int(11) NOT NULL auto_increment,
  UserID int(11) NOT NULL default '0',
  strKey varchar(255) default NULL,
  strVal varchar(255) default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblNewsletter (
  ID bigint(20) NOT NULL auto_increment,
  ParentID bigint(20) NOT NULL default '0',
  IsFolder tinyint(1) NOT NULL default '0',
  Icon varchar(255) NOT NULL default 'newsletter.gif',
  Path varchar(255) NOT NULL default '',
  Text varchar(255) NOT NULL default '',
  Subject varchar(255) NOT NULL default '',
  Sender varchar(255) NOT NULL default '',
  Reply varchar(255) NOT NULL default '',
  Test varchar(255) NOT NULL default '',
  Log text NOT NULL,
  Step int(11) NOT NULL default '0',
  Offset int(11) NOT NULL default '0',
  Charset varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;



CREATE TABLE tblNewsletterBlock (
  ID bigint(20) NOT NULL auto_increment,
  NewsletterID bigint(20) NOT NULL default '0',
  Groups varchar(255) NOT NULL default '',
  Type tinyint(4) NOT NULL default '0',
  LinkID bigint(20) NOT NULL default '0',
  Field varchar(255) NOT NULL default '',
  Source longtext NOT NULL,
  Html longtext NOT NULL,
  Pack tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


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

CREATE TABLE tblNewsletterGroup (
  ID bigint(20) NOT NULL auto_increment,
  NewsletterID bigint(20) NOT NULL default '0',
  Emails longtext NOT NULL,
  Customers longtext NOT NULL,
  SendAll tinyint(1) NOT NULL default '1',
  Filter blob NOT NULL,
  Extern longtext,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblNewsletterLog (
  ID bigint(20) NOT NULL auto_increment,
  NewsletterID bigint(20) NOT NULL default '0',
  LogTime bigint(20) NOT NULL default '0',
  Log varchar(255) NOT NULL default '',
  Param varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblNewsletterPrefs (
  pref_name varchar(255) NOT NULL default '',
  pref_value longtext NOT NULL
) TYPE=MyISAM;


INSERT INTO tblNewsletterPrefs VALUES ('reject_malformed','1');
INSERT INTO tblNewsletterPrefs VALUES ('send_step','150');
INSERT INTO tblNewsletterPrefs VALUES ('reject_not_verified','1');
INSERT INTO tblNewsletterPrefs VALUES ('test_account','test@meineDomain.de');
INSERT INTO tblNewsletterPrefs VALUES ('log_sending','1');
INSERT INTO tblNewsletterPrefs VALUES ('default_sender','mailer@meineDomain.de');
INSERT INTO tblNewsletterPrefs VALUES ('default_reply','reply@meineDomain.de');
INSERT INTO tblNewsletterPrefs VALUES ('customer_email_field','Kontakt_Email');
INSERT INTO tblNewsletterPrefs VALUES ('customer_html_field','htmlMailYesNo');
INSERT INTO tblNewsletterPrefs VALUES ('default_htmlmail','0');
INSERT INTO tblNewsletterPrefs VALUES ('customer_firstname_field','Forename');
INSERT INTO tblNewsletterPrefs VALUES ('customer_lastname_field','Surname');
INSERT INTO tblNewsletterPrefs VALUES ('customer_salutation_field','Anrede_Salutation');
INSERT INTO tblNewsletterPrefs VALUES ('female_salutation','Frau');
INSERT INTO tblNewsletterPrefs VALUES ('male_salutation','Herr');
INSERT INTO tblNewsletterPrefs VALUES ('customer_title_field','Anrede_Title');
INSERT INTO tblNewsletterPrefs VALUES ('black_list','');
INSERT INTO tblNewsletterPrefs VALUES ('title_or_salutation','0');
INSERT INTO tblNewsletterPrefs VALUES ('global_mailing_list','');
INSERT INTO tblNewsletterPrefs VALUES ('reject_save_malformed','1');
INSERT INTO tblNewsletterPrefs VALUES ('use_https_refer','0');
INSERT INTO tblNewsletterPrefs VALUES ('send_wait','0');

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
  PRIMARY KEY (IntID)
) TYPE=MyISAM;


CREATE TABLE tblPasswd (
  passwd varchar(32) NOT NULL default '',
  username varchar(128) NOT NULL default ''
) TYPE=MyISAM;


INSERT INTO tblPasswd VALUES ('21232f297a57a5a743894a0e4a801fc3','admin');


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
  editorSizeOpt tinyint(1) NOT NULL default '0',
  editorWidth int(11) NOT NULL default '0',
  editorHeight int(11) NOT NULL default '0',
  debug_normal tinyint(1) NOT NULL default '0',
  debug_seem tinyint(1) NOT NULL default '0',
  editorFontname varchar(255) NOT NULL default 'none',
  editorFontsize int(2) NOT NULL default '-1',
  editorFont tinyint(1) NOT NULL default '0',
  default_tree_count int(11) NOT NULL default '0',
  xhtml_show_wrong tinyint(1) NOT NULL default '0',
  xhtml_show_wrong_text tinyint(2) NOT NULL default '0',
  xhtml_show_wrong_js tinyint(2) NOT NULL default '0',
  xhtml_show_wrong_error_log tinyint(2) NOT NULL default '0'
) TYPE=MyISAM;

INSERT INTO tblPrefs VALUES (1,0,'','',0,'.html','.php','.html',0,0,0,0,0,0,'Deutsch','','',0,98,0,0,0,0,0,'none',-1,0,20,0,0,0,0);

CREATE TABLE tblRecipients (
  ID bigint(20) NOT NULL auto_increment,
  Email varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblSchedule (
  DID bigint(20) NOT NULL default '0',
  Wann int(11) NOT NULL default '0',
  Was int(11) NOT NULL default '0',
  ClassName varchar(64) NOT NULL default '',
  SerializedData longblob,
  Schedpro longtext,
  Type tinyint(3) NOT NULL default '0',
  Active tinyint(1) default '1'
) TYPE=MyISAM;


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


CREATE TABLE tblTemplates (
  ID int(11) NOT NULL auto_increment,
  ParentID int(11) NOT NULL default '0',
  Text varchar(255) NOT NULL default '',
  Icon varchar(64) NOT NULL default '',
  IsFolder tinyint(4) NOT NULL default '0',
  ContentType varchar(32) NOT NULL default '0',
  CreationDate int(11) NOT NULL default '0',
  ModDate int(11) NOT NULL default '0',
  Path varchar(255) NOT NULL default '',
  Filename varchar(64) NOT NULL default '',
  Extension varchar(10) NOT NULL default '',
  ClassName varchar(64) NOT NULL default '',
  Deleted int(11) NOT NULL default '0',
  Owners varchar(255) default NULL,
  RestrictOwners tinyint(1) default '0',
  OwnersReadOnly text,
  CreatorID bigint(20) NOT NULL default '0',
  ModifierID bigint(20) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblTemporaryDoc (
  ID bigint(20) NOT NULL auto_increment,
  DocumentID bigint(20) NOT NULL default '0',
  DocumentObject longtext NOT NULL,
  DocTable varchar(64) NOT NULL default '',
  UnixTimestamp bigint(20) NOT NULL default '0',
  Active tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


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


CREATE TABLE tblUser (
  ID bigint(20) NOT NULL auto_increment,
  ParentID bigint(20) NOT NULL default '0',
  Text varchar(255) NOT NULL default '',
  Path varchar(255) NOT NULL default '',
  Icon varchar(64) NOT NULL default '',
  IsFolder tinyint(1) NOT NULL default '0',
  Type tinyint(4) NOT NULL default '0',
  First varchar(255) NOT NULL default '',
  Second varchar(255) NOT NULL default '',
  Address varchar(255) NOT NULL default '0',
  HouseNo varchar(11) NOT NULL default '',
  City varchar(255) NOT NULL default '',
  PLZ int(11) NOT NULL default '0',
  State varchar(255) NOT NULL default '',
  Country varchar(255) NOT NULL default '',
  Tel_preselection varchar(11) NOT NULL default '0',
  Telephone varchar(32) NOT NULL default '',
  Fax_preselection varchar(11) NOT NULL default '0',
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
  ParentWs tinyint(4) NOT NULL default '0',
  ParentWst tinyint(4) NOT NULL default '0',
  Salutation varchar(32) NOT NULL default '',
  PRIMARY KEY  (ID),
  UNIQUE KEY ID (ID),
  KEY ID_2 (ID)
) TYPE=MyISAM;

INSERT INTO tblUser VALUES (1,0,'admin','/admin','user.gif',0,0,'webEdition','','','','',0,'','','','','','','','','','admin','21232f297a57a5a743894a0e4a801fc3','a:55:{s:13:\"ADMINISTRATOR\";s:1:\"1\";s:18:\"NEW_WEBEDITIONSITE\";s:1:\"1\";s:10:\"NEW_GRAFIK\";s:1:\"1\";s:8:\"NEW_HTML\";s:1:\"1\";s:9:\"NEW_FLASH\";s:1:\"1\";s:6:\"NEW_JS\";s:1:\"1\";s:7:\"NEW_CSS\";s:1:\"1\";s:12:\"NEW_SONSTIGE\";s:1:\"1\";s:12:\"NEW_TEMPLATE\";s:1:\"1\";s:14:\"NEW_DOC_FOLDER\";s:1:\"1\";s:22:\"CHANGE_DOC_FOLDER_PATH\";s:1:\"0\";s:15:\"NEW_TEMP_FOLDER\";s:1:\"1\";s:17:\"CAN_SEE_DOCUMENTS\";s:1:\"1\";s:17:\"CAN_SEE_TEMPLATES\";s:1:\"1\";s:22:\"SAVE_DOCUMENT_TEMPLATE\";s:1:\"1\";s:17:\"DELETE_DOC_FOLDER\";s:1:\"1\";s:18:\"DELETE_TEMP_FOLDER\";s:1:\"1\";s:15:\"DELETE_DOCUMENT\";s:1:\"1\";s:15:\"DELETE_TEMPLATE\";s:1:\"1\";s:13:\"BROWSE_SERVER\";s:1:\"1\";s:12:\"EDIT_DOCTYPE\";s:1:\"1\";s:14:\"EDIT_KATEGORIE\";s:1:\"1\";s:7:\"REBUILD\";s:1:\"1\";s:6:\"EXPORT\";s:1:\"1\";s:6:\"IMPORT\";s:1:\"1\";s:9:\"NEW_GROUP\";s:1:\"1\";s:8:\"NEW_USER\";s:1:\"1\";s:10:\"SAVE_GROUP\";s:1:\"1\";s:9:\"SAVE_USER\";s:1:\"1\";s:12:\"DELETE_GROUP\";s:1:\"1\";s:11:\"DELETE_USER\";s:1:\"1\";s:7:\"PUBLISH\";s:1:\"1\";s:21:\"EDIT_SETTINGS_DEF_EXT\";s:1:\"1\";s:13:\"EDIT_SETTINGS\";s:1:\"1\";s:11:\"EDIT_PASSWD\";s:1:\"1\";s:12:\"NEW_CUSTOMER\";s:1:\"0\";s:15:\"DELETE_CUSTOMER\";s:1:\"0\";s:13:\"EDIT_CUSTOMER\";s:1:\"0\";s:19:\"SHOW_CUSTOMER_ADMIN\";s:1:\"0\";s:16:\"NEW_SHOP_ARTICLE\";s:1:\"0\";s:19:\"DELETE_SHOP_ARTICLE\";s:1:\"0\";s:15:\"EDIT_SHOP_ORDER\";s:1:\"0\";s:17:\"DELETE_SHOP_ORDER\";s:1:\"0\";s:15:\"EDIT_SHOP_PREFS\";s:1:\"0\";s:19:\"CAN_SEE_OBJECTFILES\";s:1:\"1\";s:14:\"NEW_OBJECTFILE\";s:1:\"1\";s:21:\"NEW_OBJECTFILE_FOLDER\";s:1:\"1\";s:17:\"DELETE_OBJECTFILE\";s:1:\"1\";s:15:\"CAN_SEE_OBJECTS\";s:1:\"0\";s:10:\"NEW_OBJECT\";s:1:\"0\";s:13:\"DELETE_OBJECT\";s:1:\"0\";s:12:\"NEW_WORKFLOW\";s:1:\"0\";s:15:\"DELETE_WORKFLOW\";s:1:\"0\";s:13:\"EDIT_WORKFLOW\";s:1:\"0\";s:9:\"EMPTY_LOG\";s:1:\"0\";}',0,0,0,0,0,0,0,'','','','',0,0,'');


CREATE TABLE tblWebAdmin (
  Name varchar(255) NOT NULL default '',
  Value text NOT NULL
) TYPE=MyISAM;


INSERT INTO tblWebAdmin VALUES ('FieldAdds','a:5:{s:13:\"Newsletter_Ok\";a:1:{s:7:\"default\";s:4:\",yes\";}s:19:\"Newsletter_HTMLMail\";a:1:{s:7:\"default\";s:4:\",yes\";}s:21:\"Salutation_Salutation\";a:1:{s:7:\"default\";s:8:\",Mr.,Ms.\";}s:16:\"Salutation_Title\";a:1:{s:7:\"default\";s:11:\",Dr., Prof.\";}s:9:\"UserGroup\";a:1:{s:7:\"default\";s:12:\"Admins,Users\";}}');
INSERT INTO tblWebAdmin VALUES ('SortView','a:1:{s:9:\"UserGroup\";a:1:{i:0;a:4:{s:6:\"branch\";s:5:\"Other\";s:5:\"field\";s:9:\"UserGroup\";s:8:\"function\";s:0:\"\";s:5:\"order\";s:3:\"ASC\";}}}');
INSERT INTO tblWebAdmin VALUES ('Prefs','a:2:{s:10:\"start_year\";s:4:\"1900\";s:17:\"default_sort_view\";s:9:\"UserGroup\";}');

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

INSERT INTO tblWebUser VALUES (1,'admin','admin','','','webEdition','Software GmbH','Waldstrasse 40b','D-76133 Karlsruhe','Germany','','','','','','',0,1076604226,1076604295,0,'/admin',0,'customer.gif','admin','','','Admins');

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


CREATE TABLE tblWorkflowDoc (
  ID int(11) NOT NULL auto_increment,
  workflowID int(11) NOT NULL default '0',
  documentID int(11) NOT NULL default '0',
  userID int(11) NOT NULL default '0',
  Status tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblWorkflowDocStep (
  ID int(11) NOT NULL auto_increment,
  workflowDocID int(11) NOT NULL default '0',
  workflowStepID bigint(20) NOT NULL default '0',
  startDate bigint(20) NOT NULL default '0',
  finishDate bigint(20) NOT NULL default '0',
  Status tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblWorkflowDocTask (
  ID int(11) NOT NULL auto_increment,
  documentStepID bigint(20) NOT NULL default '0',
  workflowTaskID bigint(20) NOT NULL default '0',
  Date bigint(20) NOT NULL default '0',
  todoID bigint(20) NOT NULL default '0',
  Status int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;


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


CREATE TABLE tblWorkflowStep (
  ID int(11) NOT NULL auto_increment,
  Worktime int(11) NOT NULL default '0',
  timeAction tinyint(1) NOT NULL default '0',
  stepCondition int(11) NOT NULL default '0',
  workflowID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID),
  KEY workflowDef (workflowID)
) TYPE=MyISAM;


CREATE TABLE tblWorkflowTask (
  ID int(11) NOT NULL auto_increment,
  userID int(11) NOT NULL default '0',
  Edit int(11) NOT NULL default '0',
  Mail int(11) NOT NULL default '0',
  stepID int(11) NOT NULL default '0',
  PRIMARY KEY  (ID),
  KEY Step (stepID)
) TYPE=MyISAM;


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


CREATE TABLE tblbannerprefs (
  pref_name varchar(255) NOT NULL default '',
  pref_value varchar(255) NOT NULL default ''
) TYPE=MyISAM;


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


CREATE TABLE tblthumbnails (
   ID bigint(20) NOT NULL auto_increment,
   Name varchar(255) NOT NULL default '',
   Date int(11) unsigned NOT NULL default '0',
   Format char(3) NOT NULL default 'jpg',
   Height smallint(5) unsigned default '64',
   Width smallint(5) unsigned default '64',
   Ratio tinyint(1) NOT NULL default '1',
   Maxsize tinyint(1) NOT NULL default '0',
   PRIMARY KEY  (ID)
) TYPE=MyISAM;


CREATE TABLE tblvalidationservices (
  PK_tblvalidationservices int(11) NOT NULL auto_increment,
  category varchar(20) NOT NULL default '',
  name varchar(40) NOT NULL default '',
  host varchar(200) NOT NULL default '',
  path varchar(200) NOT NULL default '',
  method varchar(4) NOT NULL default 'get',
  varname varchar(200) NOT NULL default '',
  checkvia varchar(20) NOT NULL default '',
  additionalVars varchar(250) NOT NULL default '',
  ctype varchar(20) NOT NULL default 'text/html',
  fileEndings varchar(200) NOT NULL default '',
  active tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (PK_tblvalidationservices)
) TYPE=MyISAM;


CREATE TABLE tblvoting (
  ID bigint(20) NOT NULL auto_increment,
  ParentID bigint(20) NOT NULL default '0',
  Path varchar(255) default NULL,
  IsFolder tinyint(1) default '0',
  Icon varchar(255) default 'link.gif',
  Text varchar(255) NOT NULL default '',
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

CREATE TABLE tblshopvats (
  id int(11) NOT NULL auto_increment,
  text varchar(255) NOT NULL default '',
  vat varchar(16) NOT NULL default '',
  standard tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;