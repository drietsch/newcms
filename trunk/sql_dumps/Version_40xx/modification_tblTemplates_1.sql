ALTER TABLE `tblTemplates` ADD `MasterTemplateID` BIGINT NOT NULL , ADD `IncludedTemplates` VARCHAR( 255 ) NOT NULL ;
ALTER TABLE `tblTemplates` ADD INDEX ( `MasterTemplateID` );
ALTER TABLE `tblTemplates` ADD INDEX ( `IncludedTemplates` );
