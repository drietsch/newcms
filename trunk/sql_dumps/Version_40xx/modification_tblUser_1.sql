ALTER TABLE tblUser ADD workSpaceNwl VARCHAR( 255 ) NOT NULL AFTER workSpaceTmp;
ALTER TABLE tblUser ADD ParentWsnl TINYINT( 4 ) DEFAULT '0' NOT NULL AFTER ParentWst;