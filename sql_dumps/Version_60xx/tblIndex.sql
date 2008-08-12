CREATE TABLE tblIndex (
  DID int(11) NOT NULL default '0',
  `Text` text NOT NULL,
  ID bigint(20) NOT NULL default '0',
  OID bigint(20) NOT NULL default '0',
  BText longblob NOT NULL,
  Workspace varchar(255) NOT NULL default '',
  WorkspaceID bigint(20) NOT NULL default '0',
  Category varchar(255) NOT NULL default '',
  ClassID bigint(20) NOT NULL default '0',
  Doctype bigint(20) NOT NULL default '0',
  Title varchar(255) NOT NULL default '',
  Description text NOT NULL,
  Path varchar(255) NOT NULL default '',
  KEY DID (DID)
) TYPE=MyISAM;
