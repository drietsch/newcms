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
  `Quality` TINYINT NOT NULL DEFAULT  '8',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
