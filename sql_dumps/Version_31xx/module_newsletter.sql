# MySQL dump 8.13
#
# Host: localhost    Database: we_andy_clean_de
#--------------------------------------------------------
# Server version	3.23.37-log

#
# Table structure for table 'tblNewsletter'
#

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
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblNewsletter'
#


#
# Table structure for table 'tblNewsletterBlock'
#

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

#
# Dumping data for table 'tblNewsletterBlock'
#


#
# Table structure for table 'tblNewsletterConfirm'
#

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

#
# Dumping data for table 'tblNewsletterConfirm'
#


#
# Table structure for table 'tblNewsletterGroup'
#

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

#
# Dumping data for table 'tblNewsletterGroup'
#


#
# Table structure for table 'tblNewsletterLog'
#

CREATE TABLE tblNewsletterLog (
  ID bigint(20) NOT NULL auto_increment,
  NewsletterID bigint(20) NOT NULL default '0',
  LogTime bigint(20) NOT NULL default '0',
  Log varchar(255) NOT NULL default '',
  Param varchar(255) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

#
# Dumping data for table 'tblNewsletterLog'
#


#
# Table structure for table 'tblNewsletterPrefs'
#

CREATE TABLE tblNewsletterPrefs (
  pref_name varchar(255) NOT NULL default '',
  pref_value longtext NOT NULL
) TYPE=MyISAM;

#
# Dumping data for table 'tblNewsletterPrefs'
#

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

