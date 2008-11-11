CREATE TABLE tblTemporaryDoc (
  ID bigint(20) NOT NULL auto_increment,
  DocumentID bigint(20) NOT NULL default '0',
  DocumentObject longtext NOT NULL,
  DocTable varchar(64) NOT NULL default '',
  UnixTimestamp bigint(20) NOT NULL default '0',
  Active tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
