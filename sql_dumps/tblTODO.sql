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