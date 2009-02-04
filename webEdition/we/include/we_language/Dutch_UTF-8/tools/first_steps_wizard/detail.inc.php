<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


//
// ---> Template
//

$lang["Template"]["headline"] = "Eerste Stappen Assistent";
$lang["Template"]["title"] = "Eerste Stappen Assistent";
$lang["Template"]["autocontinue"] = "U wordt doorverwezen in % seconden.";


//
// ---> Buttons
//

$lang["Buttons"]["next"] = "volgende";
$lang["Buttons"]["back"] = "vorige";


//
// ---> Wizards
//

$lang["Wizard"]["DetailWizard"]["title"] = ""; // TRANSLATE 


//
// ---> Steps
//

// Startscreen
$lang["Step"]["Startscreen"]["title"] = "Welkom"; 
$lang["Step"]["Startscreen"]["headline"] = "Welkom"; 
$lang["Step"]["Startscreen"]["content"] = "Welkom bij de Eerste Stappen Assistent voor ontwerpen. U kunt webEdition in de volgende stappen aanvullen met ontwerpen. <br /><br />Het importeren van de functionele onderdelen vind tegelijk plaats met de installatie van uw ontwerp met de Eerste Stappen Assistent.<br /><br />De beschikbare imports bevatten meerdere bestanden: sjablonen, documenten, voorbeelden of afbeeldingen.<br /><br />Bezoek regelmatig onze website(<a href=\"http://www.living-e.de/en/\" target=\"_blank\" class=\"defaultfont\">http://www.living-e.de/en</a>) voor nieuwe ontwerpen.<br /><br />Ontbreken de webEdition demo pagina's? Geen probleem: download de demo pagina's gratis als backup van onze website: <a href=\"http://demo.en.webedition.info/\" target=\"_blank\" class=\"defaultfont\">http://demo.en.webedition.info</a>U kunt de backup importeren via Bestand->Backup->Herstel backup..."; 
$lang["Step"]["Startscreen"]["description"] = "In versie 5 van webEdition, zit standaard de Export module. Hiermee kunt u functionele onderdelen exporteren zoals bijv. een gastenboek en deze beschikbaar maken voor andere gebruikers.<br /><br />Een hoop modules zijn geïntegreerd in webEdition 5: Peiling, Banner, Gebruikers beheer etc...<br /><br />U kunt terug naar de vorige pagina of naar de volgende pagina met de \\\"vorige\\\" en \\\"volgende\\\" buttons."; 
$lang["Step"]["Startscreen"]["no_connection"] = "Er kon geen verbinding gemaakt worden met de sjabloon server."; 
$lang["Step"]["Startscreen"]["error"] = "Fout"; 


// ChooseDesign
$lang["Step"]["ChooseDesign"]["title"] = "Kies ontwerp"; 
$lang["Step"]["ChooseDesign"]["headline"] = "Kies ontwerp"; 
$lang["Step"]["ChooseDesign"]["content"] = ""; // TRANSLATE 
$lang["Step"]["ChooseDesign"]["description"] = "Kies hier één van de beschikbare ontwerpen.<br /><br />De getoonde ontwerpen kunnen kostenloos gebruikt en eventueel aangepast worden.<br /><br />U kunt deze stap op ieder moment herhalen om het ontwerp van uw website eenvoudig te wijzigen.<br /><br />Selecteer \\\"voorvertoning\\\" voor een grotere weergave.<br /><br />Het webEdition team zal in de toekomst nieuwe ontwerpen toevoegen. Open de Eerste stappen hulp om deze te selecteren.<br /><br />Tijdens de installatie wordt een hoofdsjabloon geïnstalleerd waarop het ontwerp van de pagina's is gebasseerd<br /><br />U kunt met webEdition toegankelijke websites maken die gelezen kunnen worden door screenreaders en handhelds."; 
$lang["Step"]["ChooseDesign"]["no_import"] = "U heeft geen ontwerp geselecteerd."; 


// DetermineFiles
$lang["Step"]["DetermineFiles"]["title"] = "Downloaden van benodigde bestanden."; 
$lang["Step"]["DetermineFiles"]["headline"] = "Downlaoden van benodigde bestanden."; 
$lang["Step"]["DetermineFiles"]["content"] = "De bestanden voor het geselecteerde ontwerp worden verstuurd van onze server naar uw server en worden vervolgens geïmporteerd in webEdition. De bestanden bestaan uit een hoofdsjabloon, een sjabloon voor tekst documenten, CSS stijlen en layout specifieke bestanden als afbeeldingen. U kunt in een later stadium demo pagina's aanmaken.<br /><br />De gedownloade bestanden worden na succesvol importeren getoond in de webEdition bestands structuur.<br /><br />Links van de boomstructuur bevinden zich tabbladen waarmee u kunt schakelen tussen documenten en sjablonen. Documenten sjablonen hebben hun eigen bestands structuur en bevatten andere bestanden.<br /><br />Indien u al een ontwerp geïnstalleerd heeft met de hulp, wordt deze vervangen door het nieuwe ontwerp! Indien u het huidige ontwerp wilt behouden moet u de bijbehorende bestanden naar een andere map verplaatsen.<br /><br />De volgende mappen worden aangemaakt in de webEdition document boomstructuur:<br />&nbsp;&nbsp;&nbsp;_include<br />&nbsp;&nbsp;&nbsp;_layout<br /><br />De volgende mappen worden aangemaakt in de sjabloon boomstructuur:<br />&nbsp;&nbsp;&nbsp;include<br />&nbsp;&nbsp;&nbsp;master<br /><br />"; // CHECK
// changed from: "The files for the selected extension will be transferred from our server to your server and will be imported in webEdition. The files consist of templates, CSS-styles and layout specific files like pictures and images. You may create demo pages at a later point.<br /><br />The downloaded files will be displayed in the webEdition file tree after the successful import.<br /><br />There are tabs to the left of the file tree, that allow you to switch between documents and templates. Documents and templates have their respective file trees and contain different files.<br /><br />If you have already downloaded a layout and installed it with the wizard, it will be replaced with the new layout! If you wish to keep the old layout, you will need to move the corresponding files to another folder.<br /><br />The following folders will be created in the webEdition document file tree:<br />&nbsp; // TRANSLATE&nbsp; // TRANSLATE&nbsp; // TRANSLATE{seleceted extension}/{extension}<br /><br />The following folders will be created in the webEdition template file tree:<br />&nbsp; // TRANSLATE&nbsp; // TRANSLATE&nbsp; // TRANSLATE/living-e/{extension}<br /><br />To add further extensions, please restart the First Steps Wizard after successful import at File > New > webEdition page > Other"
// changed to  : "The files for the selected extension will be transferred from our server to your server and will be imported in webEdition. The files consist of templates, CSS-styles and layout specific files like pictures and images. You may create demo pages at a later point.<br /><br />The downloaded files will be displayed in the webEdition file tree after the successful import.<br /><br />There are tabs to the left of the file tree, that allow you to switch between documents and templates. Documents and templates have their respective file trees and contain different files.<br /><br />If you have already downloaded a layout and installed it with the wizard, it will be replaced with the new layout! If you wish to keep the old layout, you will need to move the corresponding files to another folder.<br /><br />The following folders will be created in the webEdition document file tree:<br />&nbsp; &nbsp; &nbsp; {seleceted extension}/{extension}<br /><br />The following folders will be created in the webEdition template file tree:<br />&nbsp; &nbsp; &nbsp; /living-e/{extension}<br /><br />To add further extensions, please restart the First Steps Wizard after successful import at File > New > webEdition page > Other"
 
$lang["Step"]["DetermineFiles"]["description"] = "Afhankelijk van de grootte, aantal bestanden en de internet verbinding kan het downloaden enige tijd in beslag nemen.<br /><br />webEdition scheidt inhoud van ontwerp. Hierdoor kan een consistent ontwerp worden verzekerd.<br /><br />De ontwerpen worden gedownload van onze server; tijdens dit proces worden er geen gegevens verzameld of bewaard.<br /><br />Elementen die u kunt wijzigen zijn te herkennen aan zogenoemde &lt;we:tags&gt; in webEdition. Momenteel zijn er ongeveer 200 beschikbaar!<br /><br />U kunt uw webEdition sjablonen wijzigen in uw HTML-Editor met de Editor Plugin."; // CHECK
// changed from: "Depending on the size and number of files and the internet connection speed, the download may take some time.<br /><br />The WCMS webEdition strictly separates content from design. That way a consistent layout of the website can be assured.<br /><br />The layouts are downloaded from our server; // TRANSLATE during this no personal data is gathered or saved.<br /><br />Editable areas are marked with so-called  &lt; // TRANSLATEwe:tags&gt; // TRANSLATE in webEdition. Currently, there are about 200 of them!<br /><br />You may edit your webEdition  templates in your HTML-Editor with the Editor Plugin."
// changed to  : "Depending on the size and number of files and the internet connection speed, the download may take some time.<br /><br />The WCMS webEdition strictly separates content from design. That way a consistent layout of the website can be assured.<br /><br />The layouts are downloaded from our server;  during this no personal data is gathered or saved.<br /><br />Editable areas are marked with so-called  &lt; we:tags&gt;  in webEdition. Currently, there are about 200 of them!<br /><br />You may edit your webEdition  templates in your HTML-Editor with the Editor Plugin."
 

// DownloadFiles
$lang["Step"]["DownloadFiles"]["title"] = $lang["Step"]["DetermineFiles"]["title"]; 
$lang["Step"]["DownloadFiles"]["headline"] = $lang["Step"]["DetermineFiles"]["headline"]; 
$lang["Step"]["DownloadFiles"]["content"] = $lang["Step"]["DetermineFiles"]["content"]; 
$lang["Step"]["DownloadFiles"]["description"] = $lang["Step"]["DetermineFiles"]["description"]; 

// PostDownloadFiles
$lang["Step"]["PostDownloadFiles"]["title"] = $lang["Step"]["DetermineFiles"]["title"]; 
$lang["Step"]["PostDownloadFiles"]["headline"] = $lang["Step"]["DetermineFiles"]["headline"]; 
$lang["Step"]["PostDownloadFiles"]["content"] = $lang["Step"]["DetermineFiles"]["content"]; 
$lang["Step"]["PostDownloadFiles"]["description"] = $lang["Step"]["DetermineFiles"]["description"]; 

// ImportOptions
$lang["Step"]["ImportOptions"]["title"] = "Settings"; 
$lang["Step"]["ImportOptions"]["headline"] = "Instellingen"; 
$lang["Step"]["ImportOptions"]["content"] = "U kunt hier kiezen welk hoofdsjabloon gebruikt moet worden voor uw import. Indien u al een ontwerp hebt geïmporteerd met de Eerste Stappen Assistent, dan moet het juiste sjabloon geselecteerd worden. Uiteraard kunt u ook een eigen sjabloon gebruiken.<br /><br />Activeer \"Maak documenten aan\" om webEdition pagina's aan te maken aan de hand van het ontwerp.<br /><br />Activeer \"Voeg navigatie invoeren toe\" om de documenten te bereiken via het menu."; 
$lang["Step"]["ImportOptions"]["description"] = "Een <b>hoofdsjabloon</b> is het <b>standaard sjabloon</b> voor webEdition pagina's. Hierin kunt u standaard elementen definiëren die voor elke pagina hetzelfde zijn, zoals bijvoorbeeld het logo, navigatie enzovoort. Als u een nieuw sjabloon aanmaakt kunt u een hoofdsjabloon kiezen waarop he document gebaseerd moet worden. U kunt de navigatie wijzigen in de navigatie tool. Deze kunt u bereiken via > Navigatie...<br /><br />Indien u niet de optie \\\"Maak documenten aan\\\" selecteert, worden alleen de sjablonen geïmporteerd. U kunt daarna zelf de documenten aanmaken en de corresponderende sjablonen selecteren in de eigenschappen weergave."; 
$lang["Step"]["ImportOptions"]["choose_mastertemplate"] = "Op welk hoofdsjabloon moeten de sjablonen gebaseerd zijn:"; 
$lang["Step"]["ImportOptions"]["labelUseDocuments"] = "Ja, maak documenten aan"; 
$lang["Step"]["ImportOptions"]["choose_document_path"] = "Selecteer a.u.b. een map waarin de documenten aangemaakt moeten worden:"; 
$lang["Step"]["ImportOptions"]["labelUseNavigation"] = "Ja, voeg navigatie invoeren toe"; 
$lang["Step"]["ImportOptions"]["choose_navigation_path"] = "Selecteer a.u.b. een map waarin de navigatie invoeren aangemaakt moeten worden:"; 

// ImportFiles
$lang["Step"]["ImportFiles"]["title"] = "Voorbereiden van benodigde bestanden"; 
$lang["Step"]["ImportFiles"]["headline"] = "Voorbereiden van benodigde bestanden"; 
$lang["Step"]["ImportFiles"]["content"] = "De bestanden voor uw ontwerp zijn verzonden naar uw server. In deze stap, worden de bestanden geïmporteerd in webEdition. Tijdens het importeren, wordt de inhoud naar een database geschreven, en de mappen en bestanden worden aangemaakt in de webEdition interface.<br /><br />Er is een eenvoudig tekst document toegevoegd voor uw eerste stappen met webEdition. Hier kunt u uw eerste content vullen in een WYSIWYG(what you see is what you get) tekstveld om te oefenen.<br /><br />Maak uw eerste tekst gebasseerde pagina aan via Bestand > Nieuw > Tekst pagina. Op deze pagina kunt u de bezoekers verwelkomen of uw website introduceren.<br /><br />Er is ook een menu structuur toegevoegd. Wijzig het menu van uw website met de navigatie tool. Start de navigatie tool via Extras > Navigatie...Hier kunt u eenvoudig nieuwe menu onderdelen aanmaken of bestaande wijzigen.<br /><br />Voordat een wijziging op een webEdition pagina zichtbaar is op de website, moet u eerst het document bewaren en publiceren!<br /><br />Met de nieuwe multi tabs kunt u meerdere webEdition documenten en sjablonen tegelijk openen. Hierdoor kunt u snel schakelen tussen een document en het bijbehorende sjabloon.<br /><br />Documenten en sjablonen hebben meerdere tabbladen aan de bovenkant van de pagina waarmee u kunt wisselen tussen verschillende weergaves. Documenten kunnen gevalideerd worden of meer informatie over een sjabloon kan worden getoond."; 
$lang["Step"]["ImportFiles"]["description"] = "Kent u de seeMode? In deze versimpelde weergave navigeert u door in webEdition zoals op de website zelf. Selecteer in het inlogvenster de optie seeMode.<br /><br />U kunt geïmporteerde afbeeldingen direct in webEdition snijden of schalen, via het tabblad wijzig.<br /><br />De nieuwe Editor Plugin kan word bestanden (.doc) of afbeeldingen (.jpg) koppelen aan het originele programma: Start de editor, wijzig het bestand, opslaan - en klaar!<br /><br />Kunt u niet de juiste we:tag vinden? In de wijzig weergave van sjablonen bevindt zich de tag hulp: hier vind u alle tags met een korte uitleg!"; 

// Finish
$lang["Step"]["Finish"]["title"] = "Ontwerp is aangemaakt"; 
$lang["Step"]["Finish"]["headline"] = "Het ontwerp is aangemaakt..."; 
$lang["Step"]["Finish"]["content"] = "Gefeliciteerd, het ontwerp is succescol geïmporteerd!<br />Voordat u begint, kunt u de website herbouwen:<br />Herbouwen is nodig na het importeren van detail sjablonen."; 
$lang["Step"]["Finish"]["description"] = "Elke webEdition page kan getoond worden in de zijbalk: bijvoorbeeld alle nieuwsberichten.<br /><br />U kunt de Cockpit invullen naar uw wensen: Via Cockpit > Voeg Widget toe kunt u widgets toevoegen aan de cockpit.<br /><br />Maakt u regelmatig een backup van uw website? Dit gaat heel eenvoudig via: Bestand > Backup > Maak Backup aan...<br /><br />Wat is heropbouwen van de pagina? webEdition maakt webpagina's aan gebasseerd op sjablonen. Wanneer u het sjabloon van een statische webEdition pagina wijzigt, moet deze opnieuw opgebouwd en bewaard worden!"; 
$lang["Step"]["Finish"]["content_2"] = "U kunt de overige mogelijkheden ontdekken in de zijbalk. U kunt direct navigeren naar nieuwe documenten of andere ontwerpen!<br /><br />Veel plezier met webEdition. Als u op de hoogte gehouden wilt worden over de nieuwste ontwikkelingen, kunt u zich inschrijven op onze nieuwsbrief door op de volgende link te klikken <br /><a href=\"http://www.living-e.de/en/newsletter/\" target=\"blank\" class=\"defaultfont\">http://www.living-e.de/en/newsletter</a><br /><br />Indien u vragen heeft, kunt u contact opnemen met onze support afdeling via<br /><a href=\"http://support.living-e.de/en/webedition/\" class=\"defaultfont\" target=\"_blank\">http://support.living-e.de/en/webedition</a>"; 
?>