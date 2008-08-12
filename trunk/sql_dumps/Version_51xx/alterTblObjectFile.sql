ALTER TABLE `tblObjectFiles` ADD `WebUserID` BIGINT NOT NULL ;

ALTER TABLE  `tblObjectFiles` ADD INDEX (  `WebUserID` ) ;
