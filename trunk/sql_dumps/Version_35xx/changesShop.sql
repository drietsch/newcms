-- new table
CREATE TABLE tblshopvats (
  id int(11) NOT NULL auto_increment,
  text varchar(255) NOT NULL default '',
  vat varchar(16) NOT NULL default '',
  standard tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- changed table
ALTER TABLE tblOrders ADD strSerialOrder LONGTEXT NOT NULL;

-- noch den kompletten Dump
CREATE TABLE tblOrders (
  IntID int(11) NOT NULL auto_increment,
  IntOrderID int(11) default NULL,
  IntCustomerID int(11) default NULL,
  IntArticleID int(11) default NULL,
  IntQuantity int(11) default NULL,
  DateOrder datetime default NULL,
  DateShipping datetime default NULL,
  DatePayment datetime default NULL,
  Price varchar(20) default NULL,
  IntPayment_Type tinyint(4) default NULL,
  strSerial longtext NOT NULL,
  strSerialOrder longtext NOT NULL,
  PRIMARY KEY  (IntID)
) TYPE=MyISAM;

-- insert payment provider data
INSERT INTO tblanzeigeprefs (ID, strDateiname, strFelder) VALUES (3, 'payment_details', 'Forename|Surname|Contact_Address1|Contact_Zip|Contact_Address2|DE|phpscripter@onlinehome.de|DE|jan.gorba@webediton.de');
