CREATE TABLE `tblMetadata` (
  `id` int(11) NOT NULL auto_increment,
  `tag` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `importFrom` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
)  TYPE=MyISAM;