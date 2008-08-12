CREATE TABLE tblshopvats (
  id int(11) NOT NULL auto_increment,
  `text` varchar(255) NOT NULL default '',
  vat varchar(16) NOT NULL default '',
  standard tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
