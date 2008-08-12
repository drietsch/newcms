
ALTER TABLE tblWebUser CHANGE Password Password VARCHAR( 255 ) NOT NULL;
ALTER TABLE tblWebUser CHANGE Username Username VARCHAR( 255 ) NOT NULL;

ALTER TABLE tblWebUser ADD LoginDenied TINYINT( 1 ) DEFAULT '0' NOT NULL AFTER Kontakt_Homepage;