ALTER TABLE  `tblFile` ADD  `WebUserID` BIGINT NOT NULL ;

ALTER TABLE  `tblFile` ADD INDEX (  `WebUserID` ) ;

