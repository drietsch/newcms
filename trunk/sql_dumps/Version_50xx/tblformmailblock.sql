CREATE TABLE tblformmailblock (
  id bigint(20) NOT NULL auto_increment,
  ip varchar(15) NOT NULL,
  blockedUntil int(11) NOT NULL,
  PRIMARY KEY  (id),
  KEY ipblockeduntil (ip,blockedUntil)
);

