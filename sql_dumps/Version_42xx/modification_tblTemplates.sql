ALTER TABLE `tblTemplates` ADD `CacheType` ENUM( '', 'none', 'tag', 'document', 'full' ) DEFAULT 'none' NOT NULL ,
ADD `CacheLifeTime` INT( 5 ) DEFAULT '0' NOT NULL ;