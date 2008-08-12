ALTER TABLE tblObject ADD DefaultWorkspaces VARCHAR( 255 ) NOT NULL AFTER Workspaces;

ALTER TABLE tblObject ADD DefaultKeywords VARCHAR( 255 ) NOT NULL AFTER DefaultTitle;