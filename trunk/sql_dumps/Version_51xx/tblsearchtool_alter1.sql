ALTER TABLE `tblsearchtool` ADD `activTab` TINYINT( 1 ) NOT NULL ;

UPDATE `tblsearchtool` SET `activTab` = '4' WHERE `tblsearchtool`.`ID` =1 LIMIT 1 ;

UPDATE `tblsearchtool` SET `activTab` = '4' WHERE `tblsearchtool`.`ID` =2 LIMIT 1 ;

UPDATE `tblsearchtool` SET `activTab` = '4' WHERE `tblsearchtool`.`ID` =3 LIMIT 1 ;

UPDATE `tblsearchtool` SET `activTab` = '3' WHERE `tblsearchtool`.`ID` =4 LIMIT 1 ;

UPDATE `tblsearchtool` SET `activTab` = '3' WHERE `tblsearchtool`.`ID` =5 LIMIT 1 ;

UPDATE `tblsearchtool` SET `activTab` = '3' WHERE `tblsearchtool`.`ID` =6 LIMIT 1 ;

UPDATE `tblsearchtool` SET `activTab` = '3' WHERE `tblsearchtool`.`ID` =7 LIMIT 1 ;

UPDATE `tblsearchtool` SET `activTab` = '4' WHERE `tblsearchtool`.`ID` =8 LIMIT 1 ;