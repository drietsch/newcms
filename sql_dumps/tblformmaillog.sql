CREATE TABLE tblformmaillog (
  id bigint(20) NOT NULL auto_increment,
  ip varchar(15) NOT NULL,
  unixTime int(11) NOT NULL,
  PRIMARY KEY  (id),
  KEY ipwhen (ip,unixTime)
) TYPE=MyISAM;
