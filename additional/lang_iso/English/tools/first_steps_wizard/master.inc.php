<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


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
//

$lang["Wizard"]["MasterWizard"]["title"] = ""; // TRANSLATE


//
// ---> Steps
//

// Startscreen
$lang["Step"]["Startscreen"]["title"] = "Welcome"; // TRANSLATE
$lang["Step"]["Startscreen"]["headline"] = "Welcome"; // TRANSLATE
$lang["Step"]["Startscreen"]["content"] = "Welcome to the webEdition First Steps Wizard (FSW). This wizard is for first-time webEdition users, who want to get to a basic website layout without studying the user guide for hours. But even for webEdition experts the wizard offers the possibility to create a functional website with just a few mouse clicks and edit it individually afterwards.<br /><br />The First Steps Wizard will guide you during installation of a first layout for your website on the following pages. On the righthand side, you can find helpful hints and explanations for every step.<br /><br />After installation of the layout, you can add to the functionality of your site with extensions like a guestbook oder picture gallery. The First Steps Wizard will guide you here as well: In File > New > webEdition page > Other you can start the First Steps Wizard, which will guide during installation of extensions.<br /><br />Are you missing the webEdition demo pages? No problem: download the demo pages for free as a backup from our web site: <a href=\"http://demo.en.webedition.info/\" target=\"_blank\" class=\"defaultfont\">http://demo.en.webedition.info</a><br />The import works by selecting File->Backup->Restore Backup..."; // TRANSLATE
$lang["Step"]["Startscreen"]["description"] = "The webEdition <b>First Steps Wizard (FSW)</b> will guide you during your first steps with the <b>Web Content Management System(WCMS)</b> webEdition.<br /><br />webEdition will not install any demo pages in version 5. That gives you a fully operational system from the get-go.<br /><br />The number of layouts for the FSW will keep growing. Check if new layouts are available from time to time. To do so, you only have to start the FSW.<br /><br />You may start the FSW at any time in File > New > Wizards > First Steps Wizard.<br /><br />You can go back to the previous page or go to the next page with the buttons \\\"back\\\" and \\\"next\\\"."; // TRANSLATE
$lang["Step"]["Startscreen"]["no_connection"] = "A connection to the template server could not be established."; // TRANSLATE
$lang["Step"]["Startscreen"]["error"] = "Error"; // TRANSLATE


// ChooseDesign
$lang["Step"]["ChooseDesign"]["title"] = "Choose layout"; // TRANSLATE
$lang["Step"]["ChooseDesign"]["headline"] = "Choose layout"; // TRANSLATE
$lang["Step"]["ChooseDesign"]["content"] = ""; // TRANSLATE
$lang["Step"]["ChooseDesign"]["description"] = "Please choose one of the available layouts here.<br /><br />The layouts displayed may be used without cost and may be altered to meet your demands.<br /><br />You may repeat this procedure at any time to easily change the layout of your website.<br /><br />Select \\\"preview\\\" to have an design enlarged.<br /><br />The webEdition Team will continue to publish further layouts in the future. Just open the First Steps Wizard again and be surprised.<br /><br />A master template will be installed during the installation, on which the design of all webEdition pages is based<br /><br />You may create accessible websites with webEdition that can be read by screenreaders and handhelds."; // TRANSLATE
$lang["Step"]["ChooseDesign"]["no_import"] = "You have not selected a layout."; // TRANSLATE


// DetermineFiles
$lang["Step"]["DetermineFiles"]["title"] = "Downloading necessary files."; // TRANSLATE
$lang["Step"]["DetermineFiles"]["headline"] = "Downloading necessary files."; // TRANSLATE
$lang["Step"]["DetermineFiles"]["content"] = "The files for the selected layout will be transferred from our server to your server and will be imported in webEdition. The files consist of a master template, a template for text pages, CSS-styles and layout specific files like pictures and images. You may create demo pages at a later point.<br /><br />The downloaded files will be displayed in the webEdition file tree after the successful import.<br /><br />There are tabs to the left of the file tree, that allow you to switch between documents and templates. Documents and templates have their respective file trees and contain different files.<br /><br />If you have already downloaded a layout and installed it with the wizard, it will be replaced with the new layout! If you wish to keep the old layout, you will need to move the corresponding files to another folder.<br /><br />The following folders will be created in the webEdition document file tree:<br />&nbsp; // TRANSLATE&nbsp; // TRANSLATE&nbsp; // TRANSLATE_include<br />&nbsp; // TRANSLATE&nbsp; // TRANSLATE&nbsp; // TRANSLATE_layout<br /><br />The following folders will be created in the webEdition template file tree:<br />&nbsp; // TRANSLATE&nbsp; // TRANSLATE&nbsp; // TRANSLATEinclude<br />&nbsp; // TRANSLATE&nbsp; // TRANSLATE&nbsp; // TRANSLATEmaster<br /><br />To add further extensions, please restart the First Steps Wizard after successful import at File > New > webEdition page > Other"; // TRANSLATE
$lang["Step"]["DetermineFiles"]["description"] = "Depending on the size and number of files and the internet connection speed, the download may take some time.<br /><br />The WCMS webEdition strictly separates content from design. That way a consistent layout of the website can be assured.<br /><br />The layouts are downloaded from our server; // TRANSLATE during this no personal data is gathered or saved.<br /><br />Editable areas are marked with so-called  &lt; // TRANSLATEwe:tags&gt; // TRANSLATE in webEdition. Currently, there are about 200 of them!<br /><br />You may edit your webEdition  templates in your HTML-Editor with the Editor Plugin."; // TRANSLATE

// DownloadFiles
$lang["Step"]["DownloadFiles"]["title"] = $lang["Step"]["DetermineFiles"]["title"]; // TRANSLATE
$lang["Step"]["DownloadFiles"]["headline"] = $lang["Step"]["DetermineFiles"]["headline"]; // TRANSLATE
$lang["Step"]["DownloadFiles"]["content"] = $lang["Step"]["DetermineFiles"]["content"]; // TRANSLATE
$lang["Step"]["DownloadFiles"]["description"] = $lang["Step"]["DetermineFiles"]["description"]; // TRANSLATE

// ImportOptions
$lang["Step"]["ImportOptions"]["title"] = $lang["Step"]["DetermineFiles"]["title"]; // TRANSLATE
$lang["Step"]["ImportOptions"]["headline"] = $lang["Step"]["DetermineFiles"]["headline"]; // TRANSLATE
$lang["Step"]["ImportOptions"]["content"] = $lang["Step"]["DetermineFiles"]["content"]; // TRANSLATE
$lang["Step"]["ImportOptions"]["description"] = $lang["Step"]["DetermineFiles"]["description"]; // TRANSLATE

// ImportFiles
$lang["Step"]["ImportFiles"]["title"] = "Preparing necessary files"; // TRANSLATE
$lang["Step"]["ImportFiles"]["headline"] = "Preparing necessary files"; // TRANSLATE
$lang["Step"]["ImportFiles"]["content"] = "The files for your new layout have been transferred to your server. In this step, they will be imported in webEdition. Within the import, contents will be written into the database and the folders and files will be created in the webEdition interface.<br /><br />A simple text document is enclosed for your first steps with webEdition. Here, you can enter first content into a WYSIWYG(what you see is what you get) textarea and experiment with your webpage.<br /><br />Create your first text-based page in File > New > webEdition page > Text page. In this page you can greet the visitors of your site or introduce your website.<br /><br />A two-tier navigation is already included. Edit the navigation for your new website with the navigation tool. Start the navigation tool with Extras > Navigation...Here, you can create or edit existing navigation entries comfortably.<br /><br />Before any changes to any webEdition page appear on the website, you will need to save and publish the document!<br /><br />With the new multi tabs you may open several webEdition documents and templates. This enables you to switch quickly between a document and its template, to view the changes in the sourcecode at once.<br /><br />Documents and templates have multiple tabs at the upper end, with which you may switch between different displays. Documents can be validated or more information about templates can be displayed."; // TRANSLATE
$lang["Step"]["ImportFiles"]["description"] = "Do you know the seeMode? In this simplified display you navigate in webEdition like on the done webpage. Just activate the seeMode radiobutton at the login.<br /><br />You can cut or scale imported images directly in webEdition. Simply choose the file in the edit view.<br /><br />The new Editor Plugin can link file formats like .doc or .jpg to the original application: Start the editor, edit the file, save - done!<br /><br />You can\'t find the correct we:tag? You can find the Tag Wizard in the edit view of the templates: all tags are include therein with a short explanation!"; // TRANSLATE

// Finish
$lang["Step"]["Finish"]["title"] = "Layout has been created"; // TRANSLATE
$lang["Step"]["Finish"]["headline"] = "The Layout has been created..."; // TRANSLATE
$lang["Step"]["Finish"]["content"] = "Congratulations, the layout has been imported successfully!<br />Before you get started, you can perform a rebuild:<br />A rebuild is required after the import of detail templates."; // TRANSLATE
$lang["Step"]["Finish"]["description"] = "Any webEdition page can be displayed in the Sidebar: Whether online help or an overview of all shop articles - use the new possibilities.<br /><br />You can change the webEdition Cockpit to your liking: In Cockpit > Add Widget you can add further widgets to the cockpit.<br /><br />Do you backup your website regularly? It is real easy with webEdition: File > Backup > Create Backup...<br /><br />What is a <b>Rebuild</b>? webEdition creates web pages based on templates. If you change the template of a static webEdition page, that page has to be \\\"rebuilt\\\" and saved!"; // TRANSLATE
$lang["Step"]["Finish"]["content_2"] = "If have imported a layout before, you will be required to perform a rebuild! You can display the further possibilities for your new import in the new Sidebar. You can navigate directly to new documents or further extensions!<br /><br />Have fun with the WCMS webEdition. If you wish to stay informed about the newest developments, subscribe to our newsletter at<br /><a href=\"http://www.living-e.de/en/Newsletter/\" target=\"blank\" class=\"defaultfont\">http://www.living-e.de/en/Newsletter/</a><br /><br />If you have any questions, please refer to our support<br /><a href=\"http://support.living-e.de/en/webedition/\" class=\"defaultfont\" target=\"_blank\">http://support.living-e.de/en/webedition</a>"; // TRANSLATE

?>