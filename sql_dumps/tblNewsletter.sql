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
  isEmbedImages tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
