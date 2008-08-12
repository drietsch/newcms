-- 
-- Tabellenstruktur fuer Tabelle `tblsearchtool`;
-- 

DROP TABLE IF EXISTS `tblsearchtool`;
CREATE TABLE `tblsearchtool` (
  `ID` bigint(20) NOT NULL auto_increment,
  `ParentID` bigint(20) NOT NULL default '0',
  `IsFolder` tinyint(4) NOT NULL default '0',
  `Icon` varchar(255) NOT NULL,
  `Path` varchar(255) NOT NULL,
  `Text` varchar(255) NOT NULL,
  `predefined` tinyint(1) NOT NULL,
  `folderIDDoc` int(11) NOT NULL,
  `folderIDTmpl` int(11) NOT NULL,
  `searchDocSearch` varchar(255) NOT NULL,
  `searchTmplSearch` varchar(255) NOT NULL,
  `searchForTextDocSearch` varchar(255) NOT NULL,
  `searchForTitleDocSearch` tinyint(1) NOT NULL,
  `searchForContentDocSearch` varchar(255) NOT NULL,
  `searchForTextTmplSearch` varchar(255) NOT NULL,
  `searchForContentTmplSearch` varchar(255) NOT NULL,
  `anzahlDocSearch` int(4) NOT NULL,
  `anzahlTmplSearch` int(4) NOT NULL,
  `anzahlAdvSearch` int(4) NOT NULL,
  `setViewDocSearch` tinyint(1) NOT NULL,
  `setViewTmplSearch` tinyint(1) NOT NULL,
  `setViewAdvSearch` tinyint(1) NOT NULL,
  `OrderDocSearch` varchar(64) NOT NULL,
  `OrderTmplSearch` varchar(64) NOT NULL,
  `OrderAdvSearch` varchar(64) NOT NULL,
  `searchAdvSearch` varchar(255) NOT NULL,
  `locationAdvSearch` varchar(255) NOT NULL,
  `searchFieldsAdvSearch` varchar(255) NOT NULL,
  `search_tables_advSearch` varchar(255) NOT NULL,
  `activTab` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM ;

--
-- Daten für Tabelle `tblsearchtool`
--

INSERT INTO `tblsearchtool` (`ID`, `ParentID`, `IsFolder`, `Icon`, `Path`, `Text`, `predefined`, `folderIDDoc`, `folderIDTmpl`, `searchDocSearch`, `searchTmplSearch`, `searchForTextDocSearch`, `searchForTitleDocSearch`, `searchForContentDocSearch`, `searchForTextTmplSearch`, `searchForContentTmplSearch`, `anzahlDocSearch`, `anzahlTmplSearch`, `anzahlAdvSearch`, `setViewDocSearch`, `setViewTmplSearch`, `setViewAdvSearch`, `OrderDocSearch`, `OrderTmplSearch`, `OrderAdvSearch`, `searchAdvSearch`, `locationAdvSearch`, `searchFieldsAdvSearch`, `search_tables_advSearch`, `activTab`) VALUES
(1, 0, 1, 'folder.gif', '/Vordefinierte Suchanfragen', 'Vordefinierte Suchanfragen', 1, 0, 0, '', '', '', 0, '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '',4),
(2, 1, 1, 'folder.gif', '/Vordefinierte Suchanfragen/Dokumente', 'Dokumente', 1, 0, 0, '', '', '', 0, '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '',4),
(3, 1, 1, 'folder.gif', '/Vordefinierte Suchanfragen/Objekte', 'Objekte', 1, 0, 0, '', '', '', 0, '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '',4),
(4, 2, 0, 'Suche.gif', '/Vordefinierte Suchanfragen/Dokumente/Unveröffentlichte Dokumente', 'Unveröffentlichte Dokumente', 1, 0, 0, 'a:1:{i:0;s:0:"";}', 'a:1:{i:0;s:0:"";}', '1', 1, '1', '1', '1', 25, 25, 25, 0, 0, 0, 'Text', 'Text', 'Text', 'a:1:{i:0;s:17:"geparkt_geaendert";}', 's:24:"a:1:{i:0;s:7:"CONTAIN";}";', 'a:1:{i:0;s:6:"Status";}', 'a:4:{s:7:"tblFile";s:1:"1";s:14:"tblObjectFiles";s:1:"0";s:12:"tblTemplates";s:1:"0";s:9:"tblObject";s:1:"0";}',3),
(5, 2, 0, 'Suche.gif', '/Vordefinierte Suchanfragen/Dokumente/Statische Dokumente', 'Statische Dokumente', 1, 0, 0, 'a:1:{i:0;s:0:"";}', 'a:1:{i:0;s:0:"";}', '1', 1, '1', '1', '1', 25, 25, 25, 0, 0, 0, 'Text', 'Text', 'Text', 'a:1:{i:0;s:8:"statisch";}', 's:32:"s:24:"a:1:{i:0;s:7:"CONTAIN";}";";', 'a:1:{i:0;s:11:"Speicherart";}', 'a:4:{s:7:"tblFile";s:1:"1";s:14:"tblObjectFiles";s:1:"0";s:12:"tblTemplates";s:1:"0";s:9:"tblObject";s:1:"0";}',3),
(6, 2, 0, 'Suche.gif', '/Vordefinierte Suchanfragen/Dokumente/Dynamische Dokumente', 'Dynamische Dokumente', 1, 0, 0, 'a:1:{i:0;s:0:"";}', 'a:1:{i:0;s:0:"";}', '1', 1, '1', '1', '1', 25, 25, 25, 0, 0, 0, 'Text', 'Text', 'Text', 'a:1:{i:0;s:9:"dynamisch";}', 's:32:"s:24:"a:1:{i:0;s:7:"CONTAIN";}";";', 'a:1:{i:0;s:11:"Speicherart";}', 'a:4:{s:7:"tblFile";s:1:"1";s:14:"tblObjectFiles";s:1:"0";s:12:"tblTemplates";s:1:"0";s:9:"tblObject";s:1:"0";}',3),
(7, 3, 0, 'Suche.gif', '/Vordefinierte Suchanfragen/Objekte/Unveröffentlichte Objekte', 'Unveröffentlichte Objekte', 1, 0, 0, 'a:1:{i:0;s:0:"";}', 'a:1:{i:0;s:0:"";}', '1', 1, '1', '1', '1', 25, 25, 25, 0, 0, 0, 'Text', 'Text', 'Text', 'a:1:{i:0;s:17:"geparkt_geaendert";}', 'a:1:{i:0;s:7:"CONTAIN";}', 'a:1:{i:0;s:6:"Status";}', 'a:4:{s:7:"tblFile";s:1:"0";s:14:"tblObjectFiles";s:1:"1";s:12:"tblTemplates";s:1:"0";s:9:"tblObject";s:1:"0";}',3),
(8, 0, 1, 'folder.gif', '/Eigene Suchanfragen', 'Eigene Suchanfragen', 1, 0, 0, 'a:1:{i:0;s:0:"";}', 'a:1:{i:0;s:0:"";}', '0', 0, '0', '0', '0', 10, 10, 10, 0, 0, 0, '', '', '', 'a:1:{i:0;s:0:"";}', 'a:1:{i:0;s:7:"CONTAIN";}', 'a:1:{i:0;s:2:"ID";}', 'a:4:{s:7:"tblFile";s:1:"1";s:14:"tblobjectFiles";s:1:"1";s:12:"tblTemplates";s:1:"0";s:9:"tblobject";s:1:"0";}', 4),


INSERT INTO `tblsearchtool` (`ID`, `ParentID`, `IsFolder`, `Icon`, `Path`, `Text`, `predefined`, `folderIDDoc`, `folderIDTmpl`, `searchDocSearch`, `searchTmplSearch`, `searchForTextDocSearch`, `searchForTitleDocSearch`, `searchForContentDocSearch`, `searchForTextTmplSearch`, `searchForContentTmplSearch`, `anzahlDocSearch`, `anzahlTmplSearch`, `anzahlAdvSearch`, `setViewDocSearch`, `setViewTmplSearch`, `setViewAdvSearch`, `OrderDocSearch`, `OrderTmplSearch`, `OrderAdvSearch`, `searchAdvSearch`, `locationAdvSearch`, `searchFieldsAdvSearch`, `search_tables_advSearch`, `activTab`) VALUES
('', 0, 1, 'folder.gif', '/Versionen', 'Versionen', 1, 0, 0, 'a:1:{i:0;s:0:"";}', 'a:1:{i:0;s:0:"";}', '0', 0, '0', '0', '0', 10, 10, 10, 0, 0, 0, '', '', '', 'a:1:{i:0;s:0:"";}', 'a:1:{i:0;s:7:"CONTAIN";}', 'a:1:{i:0;s:2:"ID";}', 'a:4:{s:7:"tblFile";s:1:"1";s:14:"tblobjectFiles";s:1:"1";s:12:"tblTemplates";s:1:"0";s:9:"tblobject";s:1:"0";}',4);

INSERT INTO `tblsearchtool` (`ID`, `ParentID`, `IsFolder`, `Icon`, `Path`, `Text`, `predefined`, `folderIDDoc`, `folderIDTmpl`, `searchDocSearch`, `searchTmplSearch`, `searchForTextDocSearch`, `searchForTitleDocSearch`, `searchForContentDocSearch`, `searchForTextTmplSearch`, `searchForContentTmplSearch`, `anzahlDocSearch`, `anzahlTmplSearch`, `anzahlAdvSearch`, `setViewDocSearch`, `setViewTmplSearch`, `setViewAdvSearch`, `OrderDocSearch`, `OrderTmplSearch`, `OrderAdvSearch`, `searchAdvSearch`, `locationAdvSearch`, `searchFieldsAdvSearch`, `search_tables_advSearch`, `activTab`) VALUES
('', (SELECT LAST_INSERT_ID()), 1, 'folder.gif', '/Versionen/Dokumente', 'Dokumente', 1, 0, 0, '', '', '', 0, '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '',4),
('', (SELECT LAST_INSERT_ID()), 1, 'folder.gif', '/Versionen/Objekte', 'Objekte', 1, 0, 0, '', '', '', 0, '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '',4);

INSERT INTO `tblsearchtool` (`ID`, `ParentID`, `IsFolder`, `Icon`, `Path`, `Text`, `predefined`, `folderIDDoc`, `folderIDTmpl`, `searchDocSearch`, `searchTmplSearch`, `searchForTextDocSearch`, `searchForTitleDocSearch`, `searchForContentDocSearch`, `searchForTextTmplSearch`, `searchForContentTmplSearch`, `anzahlDocSearch`, `anzahlTmplSearch`, `anzahlAdvSearch`, `setViewDocSearch`, `setViewTmplSearch`, `setViewAdvSearch`, `OrderDocSearch`, `OrderTmplSearch`, `OrderAdvSearch`, `searchAdvSearch`, `locationAdvSearch`, `searchFieldsAdvSearch`, `search_tables_advSearch`, `activTab`) VALUES
('', (SELECT LAST_INSERT_ID()), 0, 'Suche.gif', '/Versionen/Dokumente/gelöschte Dokumente', 'gelöschte Dokumente', 1, 0, 0, 'a:1:{i:0;s:0:"";}', 'a:1:{i:0;s:0:"";}', '1', 1, '1', '1', '1', 10, 10, 10, 0, 0, 0, 'Text', 'Text', 'Text', 'a:1:{i:0;s:7:"deleted";}', 'a:1:{i:0;s:7:"CONTAIN";}', 'a:1:{i:0;s:6:"Status";}', 'a:5:{s:7:"tblFile";s:1:"1";s:14:"tblObjectFiles";s:1:"0";s:11:"tblversions";s:1:"1";s:12:"tblTemplates";s:1:"0";s:9:"tblObject";s:1:"0";}',3);

INSERT INTO `tblsearchtool` (`ID`, `ParentID`, `IsFolder`, `Icon`, `Path`, `Text`, `predefined`, `folderIDDoc`, `folderIDTmpl`, `searchDocSearch`, `searchTmplSearch`, `searchForTextDocSearch`, `searchForTitleDocSearch`, `searchForContentDocSearch`, `searchForTextTmplSearch`, `searchForContentTmplSearch`, `anzahlDocSearch`, `anzahlTmplSearch`, `anzahlAdvSearch`, `setViewDocSearch`, `setViewTmplSearch`, `setViewAdvSearch`, `OrderDocSearch`, `OrderTmplSearch`, `OrderAdvSearch`, `searchAdvSearch`, `locationAdvSearch`, `searchFieldsAdvSearch`, `search_tables_advSearch`, `activTab`) VALUES
('', (SELECT LAST_INSERT_ID()-1), 0, 'Suche.gif', '/Versionen/Objekte/gelöschte Objekte', 'gelöschte Objekte', 1, 0, 0, 'a:1:{i:0;s:0:"";}', 'a:1:{i:0;s:0:"";}', '1', 1, '1', '1', '1', 10, 10, 10, 0, 0, 0, 'Text', 'Text', 'Text', 'a:1:{i:0;s:7:"deleted";}', 'a:1:{i:0;s:7:"CONTAIN";}', 'a:1:{i:0;s:6:"Status";}', 'a:5:{s:7:"tblFile";s:1:"0";s:14:"tblObjectFiles";s:1:"1";s:11:"tblversions";s:1:"1";s:12:"tblTemplates";s:1:"0";s:9:"tblObject";s:1:"0";}',3);

