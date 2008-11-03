CREATE TABLE tblSchedule (
  DID bigint(20) NOT NULL default '0',
  Wann int(11) NOT NULL default '0',
  Was int(11) NOT NULL default '0',
  ClassName varchar(64) NOT NULL default '',
  SerializedData longblob,
  Schedpro longtext,
  `Type` tinyint(3) NOT NULL default '0',
  Active tinyint(1) default NULL
) TYPE=MyISAM;
