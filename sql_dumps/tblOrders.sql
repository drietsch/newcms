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
