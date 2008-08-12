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
