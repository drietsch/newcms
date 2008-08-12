CREATE TABLE tblWebAdmin (
  Name varchar(255) NOT NULL default '',
  `Value` text NOT NULL
) TYPE=MyISAM;

INSERT INTO tblWebAdmin VALUES ('FieldAdds','a:9:{s:13:\"Newsletter_Ok\";a:1:{s:7:\"default\";s:3:\",ja\";}s:25:\"Newsletter_HTMLNewsletter\";a:1:{s:7:\"default\";s:3:\",ja\";}s:17:\"Kontakt_Addresse1\";a:1:{s:7:\"default\";s:0:\"\";}s:17:\"Kontakt_Addresse2\";a:1:{s:7:\"default\";s:0:\"\";}s:18:\"Kontakt_Bundesland\";a:1:{s:7:\"default\";s:214:\"Baden-Württemberg,Bayern,Berlin,Brandenburg,Bremen,Hamburg,Hessen,Mecklenburg-Vorpommern,Niedersachsen,Nordrhein-Westfalen,Rheinland-PfalzRheinland-Pfalz,Saarland,Sachsen,Sachsen-Anhalt,Schleswig-Holstein,Thüringen\";}s:12:\"Kontakt_Land\";a:1:{s:7:\"default\";s:0:\"\";}s:13:\"Anrede_Anrede\";a:1:{s:7:\"default\";s:10:\",Herr,Frau\";}s:12:\"Anrede_Titel\";a:1:{s:7:\"default\";s:11:\",Dr., Prof.\";}s:6:\"Gruppe\";a:1:{s:7:\"default\";s:22:\"Administratoren,Kunden\";}}');
INSERT INTO tblWebAdmin VALUES ('Prefs','a:2:{s:10:\"start_year\";s:4:\"1900\";s:17:\"default_sort_view\";s:6:\"Gruppe\";}');
INSERT INTO tblWebAdmin VALUES ('SortView','a:1:{s:6:\"Gruppe\";a:1:{i:0;a:4:{s:6:\"branch\";s:8:\"Sonstige\";s:5:\"field\";s:6:\"Gruppe\";s:8:\"function\";s:0:\"\";s:5:\"order\";s:3:\"ASC\";}}}');

