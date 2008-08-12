CREATE TABLE tblnavigationrules (
  ID int(11) NOT NULL auto_increment,
  NavigationName varchar(255) default NULL,
  NavigationID int(11) NOT NULL,
  SelectionType varchar(16) NOT NULL,
  FolderID int(11) NOT NULL,
  DoctypeID int(11) NOT NULL,
  Categories varchar(255) NOT NULL,
  ClassID int(11) NOT NULL,
  WorkspaceID int(11) NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;