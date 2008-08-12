ALTER TABLE `tblPrefs` ADD `message_reporting` INT DEFAULT '7' NOT NULL ;
ALTER TABLE `tblPrefs` ADD `force_glossary_check` TINYINT( 1 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `tblPrefs` ADD `force_glossary_action` TINYINT( 1 ) DEFAULT '0' NOT NULL ;