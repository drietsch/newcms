ALTER TABLE `tblPrefs` ADD `cockpit_dat` TEXT ;
ALTER TABLE `tblPrefs` ADD `cockpit_amount_columns` INT( 2 ) DEFAULT '3' NOT NULL ;
ALTER TABLE `tblPrefs` ADD `seem_start_type` VARCHAR( 10 ) DEFAULT '' NOT NULL ;