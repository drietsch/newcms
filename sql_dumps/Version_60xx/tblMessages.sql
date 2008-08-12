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
