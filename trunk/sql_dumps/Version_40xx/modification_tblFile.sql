ALTER TABLE tblFile ADD temp_template_id INT( 11 ) NOT NULL;
ALTER TABLE tblFile ADD temp_doc_type VARCHAR( 32 ) NOT NULL;
ALTER TABLE tblFile ADD temp_category VARCHAR( 255 ) NOT NULL;