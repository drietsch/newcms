CREATE TABLE tblvalidationservices (
  PK_tblvalidationservices int(11) NOT NULL auto_increment,
  category varchar(20) NOT NULL default '',
  name varchar(255) NOT NULL default '',
  host varchar(255) NOT NULL default '',
  path varchar(255) NOT NULL default '',
  method varchar(4) NOT NULL default '',
  varname varchar(255) NOT NULL default '',
  checkvia varchar(20) NOT NULL default '',
  additionalVars varchar(255) NOT NULL default '',
  ctype varchar(20) NOT NULL default '',
  fileEndings varchar(255) NOT NULL default '',
  active tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (PK_tblvalidationservices)
) TYPE=MyISAM;
