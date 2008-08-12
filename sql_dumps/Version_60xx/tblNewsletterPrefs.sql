CREATE TABLE tblNewsletterPrefs (
  pref_name varchar(255) NOT NULL default '',
  pref_value longtext NOT NULL
) TYPE=MyISAM;

INSERT INTO tblNewsletterPrefs VALUES ('black_list','');
INSERT INTO tblNewsletterPrefs VALUES ('customer_email_field','Kontakt_Email');
INSERT INTO tblNewsletterPrefs VALUES ('customer_firstname_field','Forename');
INSERT INTO tblNewsletterPrefs VALUES ('customer_html_field','htmlMailYesNo');
INSERT INTO tblNewsletterPrefs VALUES ('customer_lastname_field','Surname');
INSERT INTO tblNewsletterPrefs VALUES ('customer_salutation_field','Anrede_Salutation');
INSERT INTO tblNewsletterPrefs VALUES ('customer_title_field','Anrede_Title');
INSERT INTO tblNewsletterPrefs VALUES ('default_htmlmail','0');
INSERT INTO tblNewsletterPrefs VALUES ('default_reply','reply@meineDomain.de');
INSERT INTO tblNewsletterPrefs VALUES ('default_sender','mailer@meineDomain.de');
INSERT INTO tblNewsletterPrefs VALUES ('female_salutation','Frau');
INSERT INTO tblNewsletterPrefs VALUES ('global_mailing_list','');
INSERT INTO tblNewsletterPrefs VALUES ('log_sending','1');
INSERT INTO tblNewsletterPrefs VALUES ('male_salutation','Herr');
INSERT INTO tblNewsletterPrefs VALUES ('reject_malformed','1');
INSERT INTO tblNewsletterPrefs VALUES ('reject_not_verified','1');
INSERT INTO tblNewsletterPrefs VALUES ('send_step','20');
INSERT INTO tblNewsletterPrefs VALUES ('send_wait','0');
INSERT INTO tblNewsletterPrefs VALUES ('test_account','test@meineDomain.de');
INSERT INTO tblNewsletterPrefs VALUES ('title_or_salutation','0');
