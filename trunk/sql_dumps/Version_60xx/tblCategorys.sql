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
