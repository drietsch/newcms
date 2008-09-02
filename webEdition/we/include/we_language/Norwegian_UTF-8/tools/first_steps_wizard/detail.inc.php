<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


//
// ---> Template
//

$lang["Template"]["headline"] = "First Steps Wizard"; // TRANSLATE
$lang["Template"]["title"] = "First Steps Wizard"; // TRANSLATE
$lang["Template"]["autocontinue"] = "You will be redirected in % seconds."; // TRANSLATE


//
// ---> Buttons
//

$lang["Buttons"]["next"] = "next"; // TRANSLATE
$lang["Buttons"]["back"] = "back"; // TRANSLATE


//
// ---> Wizards
//

$lang["Wizard"]["DetailWizard"]["title"] = ""; // TRANSLATE


//
// ---> Steps
//

// Startscreen
$lang["Step"]["Startscreen"]["title"] = "Welcome"; // TRANSLATE
$lang["Step"]["Startscreen"]["headline"] = "Welcome"; // TRANSLATE
$lang["Step"]["Startscreen"]["content"] = "Welcome to the First Steps Wizard for extensions. You can enhance webEdition with further extensions in the following steps. <br /><br />The import of these functional units will take place in line with the installation of your layout with the First Steps Wizard.<br /><br />The available imports consist of several single files: Templates, documents, examples or images.<br /><br />Visit our website (<a href=\"http://www.living-e.de/en/\" target=\"_blank\" class=\"defaultfont\">http://www.living-e.de/en</a>) regularly to see if new extensions are available.<br /><br />Are you missing the webEdition demo pages? No problem: download the demo pages for free as a backup from our web site: <a href=\"http://demo.en.webedition.info/\" target=\"_blank\" class=\"defaultfont\">http://demo.en.webedition.info</a><br />The import works by selecting File->Backup->Restore Backup..."; // TRANSLATE
$lang["Step"]["Startscreen"]["description"] = "With version 5 of webEdition, the Export Module is contained in the basic version. With it, you may export functional units, e.g. a guestbook and make them available to other users.<br /><br />A lot of former modules have been integrated into webEdition 5: Voting, Banner, User Management etc...<br /><br />You can go back to the previous page or go to the next page with the buttons \\\"back\\\" and \\\"next\\\"."; // TRANSLATE
$lang["Step"]["Startscreen"]["no_connection"] = "A connection to the template server could not be established."; // TRANSLATE
$lang["Step"]["Startscreen"]["error"] = "Error"; // TRANSLATE


// ChooseDesign
$lang["Step"]["ChooseDesign"]["title"] = "Choose extension"; // TRANSLATE
$lang["Step"]["ChooseDesign"]["headline"] = "Choose extension"; // TRANSLATE
$lang["Step"]["ChooseDesign"]["content"] = ""; // TRANSLATE
$lang["Step"]["ChooseDesign"]["description"] = "Please choose one of the available extensions here.<br /><br />The extensions displayed may be used without cost and may be altered to meet your demands.<br /><br />You may repeat this procedure at any time to add further extensions.<br /><br />Select \\\"preview\\\" to have an extension enlarged.<br /><br />The webEdition Team will continue to publish further extensions in the future. Just open the First Steps Wizard again and be surprised.<br /><br />Templates and documents will be installed during the installation, on which the selected extension is based<br /><br />You may create accessible websites that can be read by screenreaders and handhelds."; // TRANSLATE
$lang["Step"]["ChooseDesign"]["no_import"] = "You have not selected an extension."; // TRANSLATE


// DetermineFiles
$lang["Step"]["DetermineFiles"]["title"] = "Downloading necessary files."; // TRANSLATE
$lang["Step"]["DetermineFiles"]["headline"] = "Downloading necessary files."; // TRANSLATE
$lang["Step"]["DetermineFiles"]["content"] = "The files for the selected extension will be transferred from our server to your server and will be imported in webEdition. The files consist of templates, CSS-styles and layout specific files like pictures and images. You may create demo pages at a later point.<br /><br />The downloaded files will be displayed in the webEdition file tree after the successful import.<br /><br />There are tabs to the left of the file tree, that allow you to switch between documents and templates. Documents and templates have their respective file trees and contain different files.<br /><br />If you have already downloaded a layout and installed it with the wizard, it will be replaced with the new layout! If you wish to keep the old layout, you will need to move the corresponding files to another folder.<br /><br />The following folders will be created in the webEdition document file tree:<br />&nbsp; // TRANSLATE&nbsp; // TRANSLATE&nbsp; // TRANSLATE{seleceted extension}/{extension}<br /><br />The following folders will be created in the webEdition template file tree:<br />&nbsp; // TRANSLATE&nbsp; // TRANSLATE&nbsp; // TRANSLATE/living-e/{extension}<br /><br />To add further extensions, please restart the First Steps Wizard after successful import at File > New > webEdition page > Other"; // TRANSLATE
$lang["Step"]["DetermineFiles"]["description"] = "Depending on the size and number of files and the internet connection speed, the download may take some time.<br /><br />The WCMS webEdition strictly separates content from design. That way a consistent layout of the website can be assured.<br /><br />The layouts are downloaded from our server; // TRANSLATE during this no personal data is gathered or saved.<br /><br />Editable areas are marked with so-called  &lt; // TRANSLATEwe:tags&gt; // TRANSLATE in webEdition. Currently, there are about 200 of them!<br /><br />You may edit your webEdition  templates in your HTML-Editor with the Editor Plugin."; // TRANSLATE

// DownloadFiles
$lang["Step"]["DownloadFiles"]["title"] = $lang["Step"]["DetermineFiles"]["title"]; // TRANSLATE
$lang["Step"]["DownloadFiles"]["headline"] = $lang["Step"]["DetermineFiles"]["headline"]; // TRANSLATE
$lang["Step"]["DownloadFiles"]["content"] = $lang["Step"]["DetermineFiles"]["content"]; // TRANSLATE
$lang["Step"]["DownloadFiles"]["description"] = $lang["Step"]["DetermineFiles"]["description"]; // TRANSLATE

// PostDownloadFiles
$lang["Step"]["PostDownloadFiles"]["title"] = $lang["Step"]["DetermineFiles"]["title"]; // TRANSLATE
$lang["Step"]["PostDownloadFiles"]["headline"] = $lang["Step"]["DetermineFiles"]["headline"]; // TRANSLATE
$lang["Step"]["PostDownloadFiles"]["content"] = $lang["Step"]["DetermineFiles"]["content"]; // TRANSLATE
$lang["Step"]["PostDownloadFiles"]["description"] = $lang["Step"]["DetermineFiles"]["description"]; // TRANSLATE

// ImportOptions
$lang["Step"]["ImportOptions"]["title"] = "Settings"; // TRANSLATE
$lang["Step"]["ImportOptions"]["headline"] = "Settings"; // TRANSLATE
$lang["Step"]["ImportOptions"]["content"] = "You may select here, which master template should be used for your import. If you have already imported a layout with the First Steps Wizard, the appropriate template should be preselected. Of course, you may also use one of your own templates.<br /><br />Activate \"Create documents\" to create webEdition pages with the new extensions in your selected folder immediately, which you may edit according to your demands.<br /><br />Activate \"Add navigation entries\" to reach the new documents via your navigation with the corresponding entry."; // TRANSLATE
$lang["Step"]["ImportOptions"]["description"] = "A <b>master template</b> is the <b>main template</b> for webEdition pages. You can define constant elements, that should be the same on all your pages, like the logo, navigation and so on, in the master template. This way the consistency of your webpage is  ensured.<br /><br />If you create a new template you may select a master template which it should be based on. This way, the base structure is created in a matter of seconds.<br /><br />You can edit your <b>navigation</b> comfortably with the navigation tool. It is located in Extra > Navigation...<br /><br />If you do not select the option \\\"Create documents\\\", only the templates will be imported. You can then create the documents yourself and select the corresponding template in the Properties view."; // TRANSLATE
$lang["Step"]["ImportOptions"]["choose_mastertemplate"] = "Which master template should the templates be based on:"; // TRANSLATE
$lang["Step"]["ImportOptions"]["labelUseDocuments"] = "Yes, create documents"; // TRANSLATE
$lang["Step"]["ImportOptions"]["choose_document_path"] = "Please select a folder in which the documents should be created:"; // TRANSLATE
$lang["Step"]["ImportOptions"]["labelUseNavigation"] = "Yes, add navigation entries"; // TRANSLATE
$lang["Step"]["ImportOptions"]["choose_navigation_path"] = "Please select a folder in which the navigation entries should be created:"; // TRANSLATE

// ImportFiles
$lang["Step"]["ImportFiles"]["title"] = "Prepare necessary files"; // TRANSLATE
$lang["Step"]["ImportFiles"]["headline"] = "Prepare necessary files"; // TRANSLATE
$lang["Step"]["ImportFiles"]["content"] = "The files for your new extension have been transferred to your server. In this step, they will be imported in webEdition. Within the import, contents will be written into the database and the folders and files will be created in the webEdition interface.<br /><br />Depending on character and number of files, the import may take some time. The progress is displayed below.<br /><br />If you chose the corresponding settings on the last screen, the new documents are already embedded in your navigation and can be reached on your website.<br /><br />Before any changes to any webEdition page appear on the website, you will need to save and publish the document!<br /><br />With the new multi tabs you may open several webEdition documents and templates. This enables you to switch quickly between a document and its template, to view the changes in the sourcecode at once.<br /><br />Documents and templates have multiple tabs at the upper end, with which you may switch between different displays. Documents can be validated or more information about templates can be displayed."; // TRANSLATE
$lang["Step"]["ImportFiles"]["description"] = "Do you know the seeMode? In this simplified display you navigate in webEdition like on the done webpage. Just activate the seeMode radiobutton at the login.<br /><br />You can cut or scale imported images directly in webEdition. Simply choose the file in the edit view.<br /><br />The new Editor Plugin can link file formats like .doc or .jpg to the original application: Start the editor, edit the file, save - done!<br /><br />You can\'t find the correct we:tag? You can find the Tag Wizard in the edit view of the templates: all tags are include therein with a short explanation!"; // TRANSLATE

// Finish
$lang["Step"]["Finish"]["title"] = "Layout has been created"; // TRANSLATE
$lang["Step"]["Finish"]["headline"] = "The Layout has been created..."; // TRANSLATE
$lang["Step"]["Finish"]["content"] = "Congratulations, the layout has been imported successfully!<br />Before you get started, you can perform a rebuild:<br />A rebuild is required after the import of detail templates."; // TRANSLATE
$lang["Step"]["Finish"]["description"] = "Any webEdition page can be displayed in the Sidebar: Whether online help or an overview of all shop articles - use the new possibilities.<br /><br />You can change the webEdition Cockpit to your liking: In Cockpit > Add Widget you can add further widgets to the cockpit.<br /><br />Do you backup your website regularly? It is real easy with webEdition: File > Backup > Create Backup...<br /><br />What is a <b>Rebuild</b>? webEdition creates web pages based on templates. If you change the template of a static webEdition page, that page has to be \\\"rebuilt\\\" and saved!"; // TRANSLATE
$lang["Step"]["Finish"]["content_2"] = "You can display the further possibilities for your new import in the new Sidebar. You can navigate directly to new documents or further extensions!<br /><br />Have fun with the WCMS webEdition. If you wish to stay informed about the newest developments, subscribe to our newsletter at<br /><a href=\"http://www.living-e.de/en/Newsletter/\" target=\"blank\" class=\"defaultfont\">http://www.living-e.de/en/Newsletter</a><br /><br />If you have any questions, please refer to our support<br /><a href=\"http://support.living-e.de/en/webedition/\" class=\"defaultfont\" target=\"_blank\">http://support.living-e.de/en/webedition</a>"; // TRANSLATE
?>