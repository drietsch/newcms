
--
-- Tabellenstruktur für Tabelle `tblversionslog`
--

DROP TABLE IF EXISTS `tblversionslog`;
CREATE TABLE `tblversionslog` (
  `ID` bigint(20) NOT NULL auto_increment,
  `timestamp` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `data` longtext NOT NULL,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM ;



