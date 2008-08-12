ALTER TABLE tblPrefs ADD import_from VARCHAR( 255 ) NOT NULL ;
ALTER TABLE tblPrefs ADD cockpit_amount_last_documents INT( 2 ) DEFAULT '5' NOT NULL ;
ALTER TABLE tblPrefs ADD cockpit_rss_feed_url TEXT NOT NULL ;
ALTER TABLE tblPrefs ADD use_jupload TINYINT( 1 ) DEFAULT '1' NOT NULL;