CREATE TABLE tblAnzeigePrefs (
  ID int(15) NOT NULL auto_increment,
  strDateiname varchar(255) NOT NULL default '',
  strFelder text NOT NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;
/* query separator */
INSERT INTO tblAnzeigePrefs VALUES (1,'edit_shop_properties','a:2:{s:14:"customerFields";a:0:{}s:19:"orderCustomerFields";a:0:{}}');
/* query separator */
INSERT INTO tblAnzeigePrefs VALUES (2,'shop_pref','€|19|german');
