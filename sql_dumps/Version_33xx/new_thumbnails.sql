# MySQL dump 9.10
#
# Host: localhost    Database: webedition
#--------------------------------------------------------
# Server version	MySQL 4.0.18-log

#
# Table structure for table 'tblthumbnails'
#

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