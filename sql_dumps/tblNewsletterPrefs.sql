CREATE TABLE tblNewsletterPrefs (
  pref_name varchar(255) NOT NULL default '',
  pref_value longtext NOT NULL
) TYPE=MyISAM;
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('black_list','');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('customer_email_field','Kontakt_Email');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('customer_firstname_field','Forename');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('customer_html_field','htmlMailYesNo');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('customer_lastname_field','Surname');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('customer_salutation_field','Anrede_Salutation');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('customer_title_field','Anrede_Title');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('default_htmlmail','0');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('default_reply','reply@meineDomain.de');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('default_sender','mailer@meineDomain.de');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('female_salutation','Frau');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('global_mailing_list','');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('log_sending','1');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('male_salutation','Herr');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('reject_malformed','1');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('reject_not_verified','1');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('send_step','20');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('send_wait','0');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('test_account','test@meineDomain.de');
/* query separator */
INSERT INTO tblNewsletterPrefs VALUES ('title_or_salutation','0');