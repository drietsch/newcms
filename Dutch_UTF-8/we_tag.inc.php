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

$l_we_tag['a']['description'] = "De we:a tag creeert een HTML link tag die refereert aan een intern webEdition document met onderstaand ID. De tag koppelt alle content tussen de start tag en de eind tag.";
$l_we_tag['a']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['addDelNewsletterEmail']['description'] = "Deze tag wordt gebuikt om een e-mail adres toe te voegen of te verwijderen uit een nieuwsbrief lijst. In het attribuut &quot;path&quot moet het complete pad naar de nieuwsbrief lijst gegeven worden. Wanneer het pad begint zonder &quot;/&quot; zal het pad voortkomen uit de DOCUMENT_ROOT. Wanneer u meerdere lijsten gerbuikt, kunt u meerdere paden opgeven, gescheiden door een komma";
$l_we_tag['addDelShopItem']['description'] = "Gebruik de we:addDelShopItem tag om een artikel toe te voegen of te verwijderen uit de winkelmand.";
$l_we_tag['addPercent']['description'] = "De we:addPercent tag voegt een gespecificeerd percentage toe, bijvoorbeeld, BTW.";
$l_we_tag['addPercent']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['answers']['description'] = "Deze tag toont de reactie mogelijkheden van een peiling.";
$l_we_tag['answers']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['author']['description'] = "De we:author tag toont de maker van het document. Wanneer het attribuut 'type' niet ingevuld is, wordt de gebruikersnaam getoont. Wanneer type=&quot;name&quot;, worden de voor- en achter naam van de gebruiker getoont. Wanneer 'type=&quot;initials&quot;, worden de initialen van de gebruiker getoond. Indien er geen voor- of achter naam is ingevoerd, wordt de gebruikersnaam getoond.";
$l_we_tag['back']['description'] = "De we:back tag creeert een HTML link tag die refereert aan de vorige we:listview pagina. De tag koppelt alle content tussen de start tag en de eind tag.";
$l_we_tag['back']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['banner']['description'] = "Gebruik de we:banner tag om een banner in te voegen vanuit de Banner/Statistieken Module.";
$l_we_tag['bannerSelect']['description'] = "Deze tag toont een uitklap menu (&lt;select&gt;), voor het selecteren van banners. Als de Klanten Beheer Module is geïnstalleerd en het attribuut klant heeft als waarde ja, dan worden alleen banners van de ingelogde klant getoond.";
$l_we_tag['bannerSum']['description'] = "De we:bannerSum tag toont het aantal getoonde, bezochte banners of het aantal bezoeken. De tag werkt alleen binnen een listview met type=&quot;banner&quot;";
$l_we_tag['block']['description'] = "De we:block tag geeft de mogelijkheid om uitbreidbare blokken/lijsten aan te maken. Alles binnen de start en eind tag wordt herhaald ( elke HTML en bijna alle we:tags ), wanneer u op de plus knop drukt in de edit modus.";
$l_we_tag['block']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['calculate']['description'] = "De we:calculate tag staat allerlei soorten wiskundige berekeningen toe.(*, /, +, -,(), sqrt.....)";
$l_we_tag['calculate']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['captcha']['description'] = "Deze tag genereert een afbeelding met een random code. ";
$l_we_tag['category']['description'] = "De we:category tag wordt vervangen door de categorie ( of categorieën ) die is / zijn toegekend aan het document in de eigenschappen venster. Als er meer categorieën zijn toegekend, gebruik dan een komma als scheidingsteken. Als u gebruik wenst te maken van een ander scheidingsteken, dan moet u die specificeren door middel van het 'tokken' attribuut. Bijvoorbeeld: tokken='&nbsp;' (in dit geval wordt er een spatie gebruikt om categorieën te scheiden).";
$l_we_tag['categorySelect']['description'] = "Deze tag wordt gebruik om een uitklapmenu (&lt;select&gt;) in een webEdition document in te voegen. Gebruik deze tag om een categorie te selecteren. Door de eind tag direct achter de begin tag te plaatsen, zal het uitklapmenu alle, in webEdition gedefinieerde, categorieën bevatten.";
$l_we_tag['categorySelect']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['charset']['description'] = "De we_charset tag genereert een meta tag die de karakterset voor de pagina bepaald. 'ISO-8859-1' is gebruikelijk voor Nederlandse webpagina's. Deze tag moet binnen de meta tag van de HTML pagina worden geplaatst.";
$l_we_tag['charset']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['checkForm']['description'] = "De we:checkForm tag valideert de invoer van een formulier mbv. JavaScript. <br/> De combinatie van de parameters 'match' en 'type' bepalen de 'name' of het 'id' van het te conroleren formulier. <br/> 'mandatory' en 'email' bevatten een komma gescheiden lijst van verplichte velden of e-mailvelden. In 'password' is het mogelijk om 2 veldnamen en een minimum lengte van ingevoerde wachtwoorden te bepalen.<br/> Met 'onError' kunt u de naam van een individuele JavaScript functie kiezen, die wordt aangeroepen in het geval van een fout. Deze functie geeft een opsomming en een markering van de ontbrekende verplichte velden en e-mailvelden, indien het wachtwoord juist is. Als 'onError' niet is gedefinieerd of de functie bestaat niet dan wordt de standaard waarde weergegeven in een dialoog venster.";
$l_we_tag['checkForm']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['colorChooser']['description'] = "De we:colorChooser tag maakt een invoerveld aan, waarmee een kleur gekzoen kan worden.";
$l_we_tag['condition']['description'] = "Deze tag wordt gebruikt in combinatie met &lt;we:conditionAdd&gt; om in een &lt;we:listview type='object'&gt; dynamisch een voorwaarde toe te voegen aan het attribuut 'condition' . Voorwaarden kunnen ingenesteld worden.";
$l_we_tag['condition']['defaultvalue'] = "&lt;we:conditionAdd field=\"Type\" var=\"type\" compare=\"=\"/&gt;"; // TRANSLATE
$l_we_tag['conditionAdd']['description'] = "Deze tag wordt gebruikt om een nieuwe regel of conditie aan te maken binnen een &lt;we:condition&gt; block.";
$l_we_tag['conditionAnd']['description'] = "Deze tag wordt gebruikt om condities toe te voegen binnen een &lt;we:condition&gt;. Dit is een logische AND, wat betekent dat aan beide bestaande condities moet worden voldaan.";
$l_we_tag['conditionOr']['description'] = "Deze tag wordt gebruikt om condities toe te voegen binnen een a &lt;we:condition&gt;. Dit is een logische OR, wat betekent dat aan één van de twee condities moet worden voldaan.";
$l_we_tag['content']['description'] = "&lt;we:content /&gt; wordt alleen gebruikt binnen een hoofdsjabloon. Dit bepaalt de plek waar de content van het sjabloon wordt gebruikt in het hoofdsjabloon.";
$l_we_tag['controlElement']['description'] = "De tag we:controlElement kan controle elementen beïnvloeden in het edit venster van een document. Knoppen kunnen worden verborgen. Checkboxen kunnen uitgeschakeld, aangevinkt en/of verborgen worden.";
$l_we_tag['cookie']['description'] = "Deze tag is vereist binnen de Peiling module en stelt een cookie in, welke ervoor zorgt dat een gebruiker slechts één keer kan stemmen. De tag moet aan het begin vna het sjabloon geplaatst worden. Er mogen geen breaks of spaties zijn voor deze tag.";
$l_we_tag['createShop']['description'] = "De we:createShop tag is vereist voor iedere pagina die winkel data bevat.";
$l_we_tag['css']['description'] = "De we:css tag genereert een HTML tag die refereert aan een intern webEdition CSS stylesheet met onderstaand ID. U kunt stylesheets in een apart bestand definiëren.";
$l_we_tag['customer']['description'] = ""; // TRANSLATE
$l_we_tag['customer']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['date']['description'] = "De we:date tag geeft de huidige datum weer op een pagina volgens de ingevoerde specificaties in onderstaand 'format' veld. Als het een statische pagina betreft, kiest u bij type 'js', zodat de datum gegeneerd wordt d.m.v. JavaScript.";
$l_we_tag['dateSelect']['description'] = "De we:dateSelect tag geeft een keuzeveld weer voor data, welke gebruikt kunnen worden in combinatie met de we:processDateSelect tag bij het uitlezen van de datum gegevens naar een variabele zoals een UNIX tijdstempel.";
$l_we_tag['delete']['description'] = "De we:delete tag wordt gebruikt om webEdition documenten via &lt;we:a edit='document' delete='true'&gt; of &lt;we:a edit='object' delete='true'&gt; te verwijderen.";
$l_we_tag['deleteShop']['description'] = "De we:deleteShop tag verwijdert de volledige winkelmand.";
$l_we_tag['description']['description'] = "De we:description tag genereert de HTML meta tag 'omschrijving'. Als het omschrijvingsveld in het Eigenschappen venster leeg is, dan zal de inhoud tussen de begin en eind tag worden gebruikt als standaard omschrijving.";
$l_we_tag['description']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['DID']['description'] = "Deze tag stuurt het ID terug van een webEdition document.";
$l_we_tag['docType']['description'] = "Deze tag stuurt het document type terug van een webEdition document.";
$l_we_tag['else']['description'] = "Deze tag wordt gebruikt om alternatieve condities toe te voegen binnen een if-type tag bijv. &lt;we:ifEditmode&gt;, &lt;we:ifNotVar&gt;, &lt;we:ifNotEmpty&gt;, &lt;we:ifFieldNotEmpty&gt;";
$l_we_tag['field']['description'] = "De we:field tag voegt de inhoud van het veld met de naam gedefinieerd in het attribuut 'name' in. Het kan alleen gebruikt worden tussen de begin en eind tag van we:repeat.";
$l_we_tag['flashmovie']['description'] = "Met de we:flashmovie tag is het mogelijk een Flash film in een document in te voegen. Documenten die gebaseerd zijn op dit sjabloon, bevatten in de wijzig modus een wijzig knop. Wanneer u op deze knop drukt zal er een venster openen, waarbinnen u een Flash film kan kiezen die zich reeds binnen webEdition bevindt.";
$l_we_tag['form']['description'] = "De we:form tag wordt gebruikt voor zoek en e-mail formulieren. Het werkt hetzelfde als de normale HTML formulier tag, maar geeft de parser de mogelijkheid om extra verborgen velden toe te voegen.";
$l_we_tag['form']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['formfield']['description'] = "De we:formfield tag wordt gebruikt om een veld te generen aan de voorkant van de site.";
$l_we_tag['formmail']['description'] = "With activated Setting Call Formmail via webEdition document, the integration of the formmail script is realized with a webEdition document. For this, the (currently without attributes) we-Tag formmail will be used. <br />Indien de Captcha-controle gebruitk wordt, bevind &lt;we:formmail/&gt; zich binnen de we-Tag ifCaptcha.";
$l_we_tag['hidden']['description'] = "De we:hidden tag creëert een verborgen input tag die de globale PHP variabelen met dezelfde naam bevat. Gebruik deze tag als u inkomende variabelen wilt doorsturen.";
$l_we_tag['hidePages']['description'] = "De we:hidePages tag maakt het mogelijk om sommige modi van een document uit te schakelen. Deze tag kunt u bijvoorbeeld gebruiken om de toegang tot het Eigenschappen venster van een document te blokkeren. In dit geval is het niet mogelijk om document eigenschappen te wijzigen.";
$l_we_tag['href']['description'] = "De we:href tag maakt een URL aan die in de wijzig modus kan worden ingevoerd.";
$l_we_tag['icon']['description'] = "De we:icon tag creëert een HTML tag die refereert aan een intern webEdition icoon met onderstaand ID. Hiermee kunt u een icoon bijvoegen die getoond wordt in Internet Explorer, Mozilla, Sarafi and Opera bij het bookmarken van uw homepage.";
$l_we_tag['ifBack']['description'] = "De we:if_back tag wordt gebruikt tussen de begin en de eind tags van &lt;we:listview&gt;. Alles binnen de begin en de eind tags van deze tag wordt getoond als er een 'vorige' pagina is. Bijv. U kunt de tag gebruiken op de tweede pagina van een listview met 20 onderdelen, en bijv. 5 onderdelen per pagina.";
$l_we_tag['ifBack']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifCaptcha']['description'] = "Content omsloten door deze tag wordt alleen weergegeven indien de juiste code is ingevoerd door de gebruiker.";
$l_we_tag['ifCaptcha']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifCat']['description'] = "De we:ifNotVar tag zorgt ervoor dat alles wat zich tussen de begin tag en de eind tag bevindt alleen getoond wordt als één of meer van de onder 'categories' ingevoerde categorieën de document categorieën zijn.";
$l_we_tag['ifCat']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifClient']['description'] = "De we:ifClient tag zorgt ervoor dat alles wat zich tussen de begin tag en de eind tag bevindt alleen getoond wordt als de client (browser) zich meet met de gevestigde standaards. Deze tag werkt alleen met dynamisch bewaarde pagina's!";
$l_we_tag['ifClient']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifConfirmFailed']['description'] = "Bij gebruik van DoubleOptIn met de nieuwsbrief module, controleert &lt;we:ifConfirmFailed&gt; of het e-mailadres bevestigd is.";
$l_we_tag['ifConfirmFailed']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifCurrentDate']['description'] = "Deze tag belicht de huidige dag binnen een kalender listview.";
$l_we_tag['ifCurrentDate']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifDeleted']['description'] = "Content binnen de begin tag en de eind tag wordt alleen getoond als een specifiek document of object verwijderd is met gebruik van &lt;we:delete/&gt;";
$l_we_tag['ifDeleted']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifDoctype']['description'] = "De we:ifDocType tag zorgt ervoor dat alles wat zich tussen de begin tag en de eind tag bevindt alleen getoond wordt als het onder 'doctype' ingevoerde document type hetzelfde is als het document type van het document.";
$l_we_tag['ifDoctype']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifDoubleOptIn']['description'] = "Content omsloten door deze tag wordt alleen getoond tijdens het eerste deel van een double opt-in proces.";
$l_we_tag['ifDoubleOptIn']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifEditmode']['description'] = "Deze tag wordt gebruikt om content binnen deze tags alleen te tone in de edit mode.";
$l_we_tag['ifEditmode']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifEmailExists']['description'] = "Content omsloten door deze tag wordt alleen getoond indien een gespecificeerd e-mailadres zich in de nieuwsbrief adreslijst bevind.";
$l_we_tag['ifEmailExists']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifEmailInvalid']['description'] = "Content omsloten door deze tag is alleen zichtbaar indien een specifiek e-mailadres niet correct is.";
$l_we_tag['ifEmailInvalid']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifEmailNotExists']['description'] = "Content omsloten door deze tag wordt alleen getoond indien het e-mailadres zich niet in de nieuwsbrief adreslijst bevind.";
$l_we_tag['ifEmailNotExists']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifEmpty']['description'] = "De we:ifEmpty tag zorgt ervoor dat alles wat zich tussen de begin tag en de eind tag bevindt alleen getoond wordt als het veld met dezelfde naam als ingevoerd onder 'match' leeg is. Het type veld moet gespecificeerd worden in het attribuut 'type', als het een 'img', 'flashmovie' of 'href' veld is.";
$l_we_tag['ifEmpty']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifEqual']['description'] = "De we:ifEqual tag vergelijkt de content van de velden 'name' en 'eqname'. Als de content van beide velden hetzelfde is, wordt alles tussen de begin en eind tag getoond. Als de tag gebruikt wordt in we:list, we:block of we:linklist, kan slechts één veld binnen deze tags vergeleken met één veld erbuiten. In dit geval moet u het attribuut 'name' instellen op de naam van het veld binnen de we:block, we:list of we:linklist-tags. Het attribuut 'eqname' moet dan ingesteld worden op de naam van een veld buiten deze tags. De tag kan ook geplaatst worden in dynamisch ingevoegde webEdition pagina's. In dit geval wordt 'name' ingesteld op een veld binnen de bijgevoegde pagina en 'eqname' wordt ingesteld op de naam van een veld in de hoofd pagina. Als het attribuut 'value' ingevuld is, wordt 'eqname' genegeerd en wordt de content van het veld 'name' vergeleken met de waarde ingevuld in het attribuut 'value'.";
$l_we_tag['ifEqual']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifFemale']['description'] = "Content omsloten door deze tag wordt alleen getoond indien de gebruiker bij aanhef selectbox vrouw selecteert.";
$l_we_tag['ifFemale']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifField']['description'] = "Deze tag wordt gebruikt tussen de begin- en eind tag van we:repeat. Alles binnen de begin- en eind tags wordt alleen getoond indien de waarde van het attribuut \"match\" gelijk is aan de waarde van het database veld van de listview invoer.";
$l_we_tag['ifField']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifFieldEmpty']['description'] = "De we:ifFieldEmpty tag zorgt ervoor dat alles wat zich tussen de begin tag en de eind tag bevindt alleen getoond wordt als het lijstweergave veld met dezelfde naam als opgegeven in 'match' leeg is. Het type veld moet gespecificeerd worden in het attribuut 'type' als het een 'img', 'flashmovie' of 'href' veld is.";
$l_we_tag['ifFieldEmpty']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifFieldNotEmpty']['description'] = "De we:ifFieldNotEmpty tag zorgt ervoor dat alles wat zich tussen de begin tag en de eind tag bevindt alleen getoond wordt als het lijstweergave veld met dezelfde naam als opgegeven in 'match' niet leeg is. Het type veld moet gespecificeerd worden in het attribuut 'type' als het een 'img', 'flashmovie' of 'href' veld is.";
$l_we_tag['ifFieldNotEmpty']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifFound']['description'] = "Content omsloten door deze tag wordt alleen getoond indien er documenten gevonden worden binnen een &lt;we:listview&gt;.";
$l_we_tag['ifFound']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifHasChildren']['description'] = "Binnen de &lt;we:repeat&gt; tag wordt &lt;we:ifHasChildren&gt; gebruikt om op te vragen of een categorie(map) child categorieën heeft.";
$l_we_tag['ifHasChildren']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifHasCurrentEntry']['description'] = "we:ifHasCurrentEntry kan gebruikt worden binnen we:navigationEntry type=\"folder\" om alleen content te tonen indien de navigatie map de actieve invoer bevat.";
$l_we_tag['ifHasCurrentEntry']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifHasEntries']['description'] = "we:ifHasEntries kan gebruikt worden binnen we:navigationEntry om alleen content te tonen indien de navigatie invoer gegevens bevat.";
$l_we_tag['ifHasEntries']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifHasShopVariants']['description'] = "De tag we:ifHasShopVariants kan content tonen afhankelijk van het bestaan van varianten in een object of document. Hiermee kan geregeld worden of een &lt;we:listview type=\"shopVariant\"&gt; getoond moet worden.";
$l_we_tag['ifHasShopVariants']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifHtmlMail']['description'] = "Content omsloten door deze tag wordt alleen getoond indien het nieuwsbrief formaat HTML is.";
$l_we_tag['ifHtmlMail']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifIsDomain']['description'] = "De we:iflsDomain tag zorgt ervoor dat alles wat zich tussen de begin tag en de eind tag bevindt alleen getoond wordt als de domein-naam van de server hetzelfde is als opgegeven in 'domain'. Het resultaat kan alleen bekeken worden in de eigenlijke website of in de voorvertoning. In de Wijzig modus wordt alles getoond.";
$l_we_tag['ifIsDomain']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifIsNotDomain']['description'] = "De we:iflsNotDomain tag zorgt ervoor dat alles wat zich tussen de begin tag en de eind tag bevindt alleen getoond wordt als de domein-naam van de server niet hetzelfde is als opgegeven in 'domain'. Het resultaat kan alleen bekeken worden in de eigenlijke website of in de voorvertoning. In de Wijzig modus wordt alles getoond.";
$l_we_tag['ifIsNotDomain']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifLastCol']['description'] = "&lt;we:ifLastCol&gt; kan de laatste kolom detecteren van een tabel rij bij gebruik van de tabel functies van een &lt;we:listview&gt;";
$l_we_tag['ifLastCol']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifLoginFailed']['description'] = "Content omsloten door deze tag wordt alleen getoond indien het inloggen is mislukt.";
$l_we_tag['ifLoginFailed']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifMailingListEmpty']['description'] = "Content omsloten door deze tag wordt alleen getoond indien de gebruiker geen nieuwsbrief heeft geselecteerd.";
$l_we_tag['ifMailingListEmpty']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifMale']['description'] = "Content omsloten door deze tag wordt alleen getoond indien de gebruiker mannelijk is. Deze tag wordt gebruikt voor de aanhef in nieuwsbrieven.";
$l_we_tag['ifMale']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNew']['description'] = "omsloten door deze tag wordt alleen getoond in een nieuw webEdition document of object.";
$l_we_tag['ifNew']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNext']['description'] = "Content omsloten door deze tag wordt alleen getoond indien er een volgende pagina met items beschikbaar is in een &lt;we:listview&gt;";
$l_we_tag['ifNext']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNoJavaScript']['description'] = "De we:ifNoJavaScript tag creëert een HTML tag die refereert aan een intern webEdition document met onderstaand ID.  Deze tag kan alleen gebruikt worden tussen de &lt;head&gt; tags van een sjabloon.";
$l_we_tag['ifNotCaptcha']['description'] = "Content omsloten door deze tag wordt alleen getoond indien de door de gebruiker ingevoerde code onjuist is.";
$l_we_tag['ifNotCaptcha']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotDeleted']['description'] = "Content omsloten door deze tag wordt alleen getoond als een webEdition document of object niet verwijderd kon worden door middel van &lt;we:delete/&gt;";
$l_we_tag['ifNotDeleted']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotDoctype']['description'] = ""; // TRANSLATE
$l_we_tag['ifNotDoctype']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotEditmode']['description'] = "Content omsloten door deze tag wordt niet getoond in de edit mode.";
$l_we_tag['ifNotEditmode']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotEmpty']['description'] = "De we:ifNotEmpty zorgt ervoor dat alles wat zich tussen de begin tag en de eind tag bevindt alleen getoond wordt als het als het lijstweergave veld met dezelfde naam als opgegeven in 'match' niet leeg is. Het type veld moet gespecificeerd worden in het attribuut 'type', als het een 'img', 'flashmovie' of 'href' veld is.";
$l_we_tag['ifNotEmpty']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotEqual']['description'] = "De we:ifNotEqual tag vergelijkt de content van de velden 'name' en 'eqname'. Als de content van beide velden hetzelfde is, wordt alles tussen de begin en eind tag niet getoond. Als de tag gebruikt wordt in we:list, we:block of we:linklist, kan slechts één veld binnen deze tags vergeleken met één veld erbuiten. In dit geval moet u het attribuut 'name' instellen op de naam van het veld binnen de we:block, we:list of we:linklist-tags. Het attribuut 'eqname' moet dan ingesteld worden op de naam van een veld buiten deze tags. De tag kan ook geplaatst worden in dynamisch ingevoegde webEdition pagina's. In dit geval wordt 'name' ingesteld op een veld binnen de bijgevoegde pagina en 'eqname' wordt ingesteld op de naam van een veld in de hoofd pagina. Als het attribuut 'value' ingevuld is, wordt 'eqname' genegeerd en wordt de content van het veld 'name' vergeleken met de waarde ingevuld in het attribuut 'value'.";
$l_we_tag['ifNotEqual']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotField']['description'] = "Deze tag wordt gebruikt tussen de begin- en eind tag van een we:repeat. Alles tussen de begin- en eind tags wordt alleen getoond als de waarde van het attribuut \"match\" niet gelijk is aan het database veld van de listview invoer.";
$l_we_tag['ifNotField']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotFound']['description'] = "Content omsloten door deze tag wordt alleen getoond indien er niks gevonden is door een &lt;we:listview&gt;.";
$l_we_tag['ifNotFound']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotHtmlMail']['description'] = "Content omsloten door deze tag wordt alleen getoond in een HTML nieuwsbrief document.";
$l_we_tag['ifNotHtmlMail']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotNew']['description'] = "Content omsloten door deze tag wordt alleen getoond in een oud webEdition document of object.";
$l_we_tag['ifNotNew']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotObject']['description'] = "De omsloten content wordt alleen getoond indien de invoer binnen &lt;we:listview type=\"search\"&gt; geen object is.&lt;br /&gt;";
$l_we_tag['ifNotObject']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotPosition']['description'] = "De we:ifNotPosition tag geeft de mogelijkheid om een actie te definiëren welke niet uitgevoerd wordt op een bepaalde positie van een block, een listview, een linklist of een listdir. De parameter \"position\"  kan veelzijdige waardes aan voor het bepalen van de eerste-, laatste-, alle even-, alle oneven- of een specifieke positie (1,2,3, ...). Wanneer  \"type= block or linklist\" is het noodzakelijk de naam te specificeren (referentie) van de gerelateerde block/linklist.";
$l_we_tag['ifNotPosition']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotRegisteredUser']['description'] = "Controleert of een gebruiker zich niet geregistreerd heeft.";
$l_we_tag['ifNotRegisteredUser']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotReturnPage']['description'] = "Content omsloten door deze tag wordt alleen getoond na aanmaak/aanpassing en als de return waarde \"return\" van &lt;we:a edit=\"true\"&gt; is \"false\" id niet ingesteld.";
$l_we_tag['ifNotReturnPage']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotSearch']['description'] = "Door instellen van de  &lt;we:ifNotSearch&gt;-tag wordt de content tussen de begin- en eind tag alleen getoond wanneer er geen zoekterm verzonden is door &lt;we:search&gt; of leeg was. Als het attribuut &quot;set&quot; ingesteld is op &quot;true&quot;, wordt alleen de variabele 'request' van &lt;we:search&gt; gevalideerd.";
$l_we_tag['ifNotSearch']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotSeeMode']['description'] = "Deze tag wordt gebruikt om de omsloten content alleen te tonen buiten de seeMode.";
$l_we_tag['ifNotSeeMode']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotSelf']['description'] = "De  we:ifNotSelf tag zorgt ervoor dat alles wat zich tussen de begin tag en de eind tag bevindt niet getoond wordt als het document ID is ingevoerd in de tag. Als de tag zich niet bevindt binnen de we:linklist of we:listdir tags, is 'id' een vereist veld!";
$l_we_tag['ifNotSelf']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotSidebar']['description'] = ""; // TRANSLATE
$l_we_tag['ifNotSidebar']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotSubscribe']['description'] = "Content omsloten door deze tag wordt alleen getoond indien een inschrijving niet succesvol is afgerond. Deze tag komt voor in een sjabloon (voor inschrijven van nieuwsbrieven) na &lt;we:addDelNewsletterEmail&gt;.";
$l_we_tag['ifNotSubscribe']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotTemplate']['description'] = "Show enclosed content only if the current document is not based on the given template.<br /><br />You'll find further information in the reference of the tag we:ifTemplate."; // TRANSLATE
$l_we_tag['ifNotTemplate']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotTop']['description'] = "De omsloten content wordt alleen getoond indien deze tag zich bevind in een ingevoegd document.";
$l_we_tag['ifNotTop']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotUnsubscribe']['description'] = "Content omsloten door deze tag wordt alleen getoond indien een verzoek voor inschrijving niet verloopt als plan. Deze tag moet geplaatst worden in het sjabloon (voor uitschrijving) na een &lt;we:addDellnewsletterEmail&gt;.";
$l_we_tag['ifNotUnsubscribe']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotVar']['description'] = "De we:ifNotVar tag zorgt ervoor dat alles wat zich binnen de begin en de eind tag niet zichtbaar is als de variabele 'name' dezelfde waarde heeft als ingevoerd onder 'match'. Het type variabele kan gespecificeerd worden in het attribuut 'type'.";
$l_we_tag['ifNotVar']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotVarSet']['description'] = "Content omsloten door deze tag wordt alleen getoond als de variabele 'name' niet ingesteld is. Let op: &quot;Not set&quot; is niet hetzelfde als &quot;empty&quot;!";
$l_we_tag['ifNotVarSet']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotVote']['description'] = "Alels tussen de begin- en eind tag wordt alleen getoond indien de peiling niet bewaard is. Het attribuut type specificeert het soort fout.";
$l_we_tag['ifNotVote']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotWebEdition']['description'] = "Content omsloten door deze tag is alleen zichtbaar buiten webEdition.";
$l_we_tag['ifNotWebEdition']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotWorkspace']['description'] = "Controleert of het document zich NIET bevind in de workspace gespecificeerd in \"path\".";
$l_we_tag['ifNotWorkspace']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifNotWritten']['description'] = "Content omsloten door deze tag wordt alleen getoond als er een fout optreed tijdens het schrijven van een webEdition document of object met gebruik van de &lt;we:write&gt; tag.";
$l_we_tag['ifNotWritten']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifObject']['description'] = "Content omsloten door deze tag wordt alleen getoond als de individuele invoer gevonden door &lt;we:listview type=\"search\"&gt; een object is.";
$l_we_tag['ifObject']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifPosition']['description'] = "De we:ifPosition tag geeft de mogelijkheid om de positie van blocks, listviews, linklists or listdirs te bepalen. De parameter \"position\"  kan veelzijdige waardes aan voor het bepalen van de eerste-, laatste-, alle even-, alle oneven- of een specifieke positie (1,2,3, ...). Wanneer  \"type= block or linklist\" is het noodzakelijk de naam te specificeren (referentie) van de gerelateerde block/linklist.";
$l_we_tag['ifPosition']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifRegisteredUser']['description'] = "Controleert of een gebruiker geregistreerd is.";
$l_we_tag['ifRegisteredUser']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifRegisteredUserCanChange']['description'] = "Content omsloten door deze tag wordt alleen getoond als een geregistreerde gebruiker die is ingelogd, toestemming heeft om het huidige webEdition document of object te wijzigen.";
$l_we_tag['ifRegisteredUserCanChange']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifReturnPage']['description'] = "Content omsloten door deze tag wordt alleen getoond nadat een webEdition document of object is aangemaakt of aangepast en het teruggestuurde resultaat \"return\" vanaf &lt;we:a edit=\"document\"&gt; of &lt;we:a edit=\"object\"&gt; is \"true\".";
$l_we_tag['ifReturnPage']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifSearch']['description'] = "Door instellen van de  &lt;we:ifSearch&gt;-tag wordt de content tussen de begin- en eind tag alleen getoond wanneer er een zoekterm verzonden is door &lt;we:search&gt; en niet leeg is. Als het attribuut &quot;set&quot; ingesteld is op &quot;true&quot;, wordt alleen de variabele 'request' van &lt;we:search&gt; gevalideerd.";
$l_we_tag['ifSearch']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifSeeMode']['description'] = "Deze tag wordt gebruikt om de omsloten content alleen te tonen in de seeMode.";
$l_we_tag['ifSeeMode']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifSelf']['description'] = "De  we:ifSelf tag zorgt ervoor dat alles wat zich tussen de begin tag en de eind tag bevindt alleen getoond wordt als het document ID is ingevoerd in de tag. Als de tag zich niet bevindt binnen de we:linklist of we:listdir tags, is 'id' een vereist veld!";
$l_we_tag['ifSelf']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifShopEmpty']['description'] = "Alles tussen de begin- en eind tag wordt getoond als de winkelmand leeg is.";
$l_we_tag['ifShopEmpty']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifShopNotEmpty']['description'] = "Alles tussen de begin- en eind tag wordt getoond als de winkelmand niet leeg is.";
$l_we_tag['ifShopNotEmpty']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifShopPayVat']['description'] = "De omsloten content wordt alleen getoond als een ingelogde gebruiker BTW moet betalen.";
$l_we_tag['ifShopPayVat']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifShopVat']['description'] = "we:ifShopVat controleert de BTW van het artikel (document/ winkelwagen). De parameter ID geeft de mogelijkheid om de BTW van een artikel te controleren a.d.h.v. het opgegeven ID.";
$l_we_tag['ifShopVat']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifSidebar']['description'] = ""; // TRANSLATE
$l_we_tag['ifSidebar']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifSubscribe']['description'] = "Content omsloten door deze tag wordt alleen getoond als een inschrijving van een nieuwsbrief succesvol is afgerond. Deze tag moet geplaatst worden in een inschrijvings sjabloon na een &lt;we:addDelnewsletterEmail&gt; tag.";
$l_we_tag['ifSubscribe']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifTemplate']['description'] = ""; // TRANSLATE
$l_we_tag['ifTemplate']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifTop']['description'] = "De omsloten content wordt alleen getoond als deze tag zicht niet bevind in een ingevoeegs document.";
$l_we_tag['ifTop']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifUnsubscribe']['description'] = "Content omsloten door deze tag wordt alleen getoond als een uitschrijving van een nieuwsbrief succesvol is afgerond. Deze tag moet geplaatst worden in een uitschrijvings sjabloon na een &lt;we:addDelnewsletterEmail&gt; tag.";
$l_we_tag['ifUnsubscribe']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifUserInputEmpty']['description'] = "Content omsloten door deze tag is alleen zichtbaar indien het doelgebruikers invoer veld leeg is.";
$l_we_tag['ifUserInputEmpty']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifUserInputNotEmpty']['description'] = "Content omsloten door deze tag is alleen zichtbaar indien het doelgebruikers invoer veld niet leeg is.";
$l_we_tag['ifUserInputNotEmpty']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifVar']['description'] = "De we:ifVar tag zorgt ervoor dat alles wat zich binnen de begin en de eind tag alleen zichtbaar is indien de variabele 'name' dezelfde waarde heeft als ingevoerd onder 'match'. Het type variabele kan gespecificeerd worden in het attribuut 'type'.";
$l_we_tag['ifVar']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifVarEmpty']['description'] = "Content omsloten door deze tag is alleen zichtbaar indien de variabele genoemd in het attribuut 'match' leeg is.";
$l_we_tag['ifVarEmpty']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifVarNotEmpty']['description'] = "Content omsloten door deze tag is alleen zichtbaar indien de variabele genoemd in het attribuut 'match' niet leeg is.";
$l_we_tag['ifVarNotEmpty']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifVarSet']['description'] = "Content omsloten door deze tag is alleen zichtbaar wanneer de doel variabele opgegeven is. Let op: &quot;Set&quot; is niet hetzelfde als &quot;not empty&quot;!";
$l_we_tag['ifVarSet']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifVote']['description'] = "Alles tussen de begin- en eind tag wordt alleen getoond indien de peiling succesvol is bewaard.";
$l_we_tag['ifVote']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifVoteActive']['description'] = "Alle content tussen de begin- en eind tag wordt alleen getoond indien de peiling niet verlopen is.";
$l_we_tag['ifVoteActive']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifWebEdition']['description'] = "Content omsloten door deze tag wordt alleen getoond binnen webEdition, maar niet op het uiteindelijke document. Deze tag wordt gebruikt voor gebruikers meldingen, etc.";
$l_we_tag['ifWebEdition']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifWorkspace']['description'] = "Controleert of een document zich bevind in de workspace gespecificeerd in \"path\".";
$l_we_tag['ifWorkspace']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['ifWritten']['description'] = "Content omsloten door deze tag is alleen beschikbaar indien het schrijf proces van een webEdition document of object succesvol was. Zie &lt;we:write&gt;.";
$l_we_tag['ifWritten']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['img']['description'] = "De we:img tag is vereist om een afbeelding te plaatsen in de content van de pagina. In de Wijzig modus is een wijzig knop zichtbaar. Wanneer u op de knop drukt opent de bestandsmanager, waarmee u een afbeelding kunt selecteren binnen webEdition. Als de attributen 'width', 'height', 'border', 'hspace', 'vspace', 'alt', of 'align' zijn ingesteld, worden deze gebruikt voor de afbeelding. Anders zijn de opgegeven instellingen van kracht. Als het attribuut ID is ingesteld, wordt de afbeelding gebruikt met dit ID, indien er geen andere afbeelding is geselecteerd. Het attribuut 'showimage' geeft de mogelijkheid om de afbeelding te verbergen in de Wijzig modus, slechts de aanpas knoppen zijn zichtbaar. Met 'showinputs' kunnen de invoer velden voor 'alt' en 'titel' gedeactiveerd worden.";
$l_we_tag['include']['description'] = "De we:include tag geeft u de mogelijkheid om een webEdition document of een HTML pagina bij te voegen in het sjabloon. Dit is vooral handig in het geval van navigatie of onderdelen die op meerdere sjablonen terugkeren. Als u met de we:include tag werkt hoeft u niet in elk sjabloon de navigatie aan te passen. Het wijzigen van het bijgevoegde document volstaat. Naderhand hoeft u alleen een 'heropbouw' uit te voeren en alle pagina's worden automatisch aangepast. Indien al uw pagina's dynamisch zijn hoeft u geen 'heropbouw' uit te voeren. Op de plek van de we:include tag wordt de pagina met onderstaand ID ingevoegd. Met het attribuut 'gethttp' kunt u aangeven of de pagina verzonden moet worden via HTTP of niet.<br>Het attribuut 'seem' bepaalt of het document aanpasbaar is in de seeMode. Dit attribuut werkt alleen wanneer het document ID opgegeven is.";
$l_we_tag['input']['description'] = "De we:input tag creëert een single-line input box in de Wijzig modus van het document gebaseerd op dit sjabloon, wanneer type = 'text' is geselecteerd. Voor alle andere types kunt u de handleiding of de help functie raadplegen.";
$l_we_tag['js']['description'] = "De we:jstag creëert een HTML tag die refereert aan een intern webEdition JavaScript document met onderstaand ID. U kunt JavaScripts definiëren in een apart bestand.";
$l_we_tag['keywords']['description'] = "De we:keywords tag genereert een keywords meta teg. Als het keywords veld in de &quot;Eigenschappen&quot; weergave leeg is, wordt de content tussen de begin tag en de eind tag gebruikt als standaard keywords. Anders worden de keywords van de Eigenschappen weergave ingevoerd.";
$l_we_tag['link']['description'] = "De we:link tag creeert een enkele koppeling welke gewijzigd kan worden door middel van de 'wijzig' knop. De 'name' attribuut mag niet gespecificeerd worden tussen de we:linklist begin tag en eind tag. De 'name' attribuut moet gespecificeerd worden buiten de we:linklist tags. 'only' geeft de mogelijkheid om één enkel attribuut (only='attribuut naam') van de koppeling of alleen de content (only='content') van de koppeling op te vragen.";
$l_we_tag['linklist']['description'] = "De we:linklist tag wordt gebruikt om koppeling lijsten aan te maken. Een 'plus' knop is zichtbaar in de Wijzig modus. Wanneer u op de knop drukt komt er een nieuwe link bij in de lijst. De uitstraling van de link list wordt bepaald door de gebruikte HTML in de link list en het gebruik van 'we:prelink' en 'we:postlink'  tussen  <we:link> en </we:link>. Alle koppelingen kunnen worden verwijderd met een verwijder knop en gewijzigd worden met  wijzig knop.";
$l_we_tag['linklist']['defaultvalue'] = "&lt;we:link /&gt;&lt;we:postlink&gt;&lt;br /&gt;&lt;/we:postlink&gt;"; // TRANSLATE
$l_we_tag['linkToSeeMode']['description'] = "Deze tag genereert een koppeling die het geselecteerde document opent in de seeMode.";
$l_we_tag['list']['description'] = "De we:list tag geeft u de mogelijkheid om expandable lists te maken. Alles binnen de begin tag en de eind tag wordt ingevoerd (alle HTML en bijna alle we:tags) als u op de 'plus' knop drukt in de Wijzig modus.";
$l_we_tag['list']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['listdir']['description'] = "De we:listdir tag creëert  een nieuwe lijst die alle bestanden in dezelfde directory toont. In het attribuut 'field' kunt u bepalen welk veld getoond moet worden. Als het veld leeg is of niet bestaat, wordt de bestandsnaam gebruikt. Directories worden doorzocht op index bestanden; indien er een index bestand is, wordt deze getoond. Welk veld er gebruikt moet worden om directories te tonen kunt u bepalen in het attribuut 'dirfield'. Als het veld leeg is of niet bestaat, wordt de invoer van 'field' respectief tot de naam van het bestand gebruikt. Als het attribuut 'id' ingesteld is worden de bestanden of de directory met het aangegeven ID getoond.";
$l_we_tag['listdir']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['listview']['description'] = "De we:listview tag is de begin tag en de eind tag van automatisch gegenereerde lijsten (nieuwspagina overzichten etc.).";
$l_we_tag['listview']['defaultvalue'] = "&lt;we:repeat&gt;

&lt;we:field name=\"Title\" alt=\"we_path\" hyperlink=\"on\"/&gt;
&lt;br /&gt;
&lt;/we:repeat&gt;";
$l_we_tag['listviewEnd']['description'] = "Deze tag toont het nummer van de laatste invoer van de huidige &lt;we:listview&gt; pagina.";
$l_we_tag['listviewPageNr']['description'] = "Deze tag geeft het nummer op van de huidige pagina in een &lt;we:listview&gt;.";
$l_we_tag['listviewPages']['description'] = "Deze tag geeft het aantal pagina's op in een &lt;we:listview&gt;.";
$l_we_tag['listviewRows']['description'] = "Deze tag geeft het aantal gevonden invoeren op in een &lt;we:listview&gt;.";
$l_we_tag['listviewStart']['description'] = "Deze tag toont het nummer van de eerste invoer van de huidige &lt;we:listview&gt; pagina.";
$l_we_tag['makeMail']['description'] = "Deze tag moet geplaatst worden op de eerste regel van elk sjabloon om een webEdition document te genereren die verstuurd kan worden met &lt;we:sendMail/&gt;.";
$l_we_tag['master']['description'] = ""; // TRANSLATE
$l_we_tag['master']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['metadata']['description'] = ""; // TRANSLATE
$l_we_tag['metadata']['defaultvalue'] = "&lt;we:field name=\"NameOfField\" /&gt;"; // TRANSLATE
$l_we_tag['navigation']['description'] = "we:navigation wordt gebruikt om een navigatie te initialiseren die gemaakt is met de navigatie-tool.";
$l_we_tag['navigationEntries']['description'] = "Binnen we:navigationEntry type=\"folder\" maakt deze tag een place holder aan voor alle invoeren van een navigatie map.";
$l_we_tag['navigationEntry']['description'] = "Met we:navigationEntry kan de weergave van een invoer gecontroleerd worden binnen de navigatie. Met de attributen \"type\", \"level\", \"current\" en \"position\" kunnen individuele elementen van verschillende niveau's specifiek gekozen en getoond worden.";
$l_we_tag['navigationEntry']['defaultvalue'] = "&lt;a href=\"&lt;we:navigationField name=\"href\" /&gt;\"&gt;&lt;we:navigationField name=\"text\" /&gt;&lt;/a&gt;&lt;br /&gt;"; // TRANSLATE
$l_we_tag['navigationField']['description'] = "&lt;we:navigationField&gt; wordt gebruikt binnen &lt;we:navigationEntry&gt; om een waarde te schrijven van de huidige navigatie invoer.";
$l_we_tag['navigationWrite']['description'] = ""; // TRANSLATE
$l_we_tag['newsletterConfirmLink']['description'] = "Deze tag wordt gebruikt om de double opt-in bevestigings-koppeling te genereren.";
$l_we_tag['newsletterConfirmLink']['defaultvalue'] = "Bevestig nieuwsbrief";
$l_we_tag['newsletterField']['description'] = ""; // TRANSLATE
$l_we_tag['newsletterSalutation']['description'] = "Deze tag wordt gebruikt om aanhef-velden weer te geven.";
$l_we_tag['newsletterUnsubscribeLink']['description'] = "Creëert een koppeling voor uitschrijving van een nieuwsbrief lijst. Deze tag kan alleen gebruikt worden in e-mail sjablonen!";
$l_we_tag['next']['description'] = "Crëert de HTML koppeling tag die refereert aan de volgende pagina binnen listviews. De tag koppelt alle content gevonden tussen de begin- en eind tag.";
$l_we_tag['next']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['noCache']['description'] = "PHP-Code omsloten door deze tag wordt elke keer uitgevoerd als het ge-cachde document opgevraagd wordt (Uitzondering: Volledige-Cache)";
$l_we_tag['noCache']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['object']['description'] = "De we:object tag wordt gebruikt om objecten te tonen. De velden van een object kunnen getoond worden met de we:field tags binnen de begin tag en de eind tag. Als slechts het attribuut 'name' is ingevoerd voor een object, of als deze een waarde heeft, wordt de object kiezer getoond in de Wijzig modus, en heeft de editor de keuze alle objecten te selecteren uit alle classen. Waneer ook het attribuut 'classid' een waarde heeft, wordt de selectie in de object kiezer beperkt tot alle objecten gerelateerd aan de in 'classid' gedefinieerde class. Met het attribuut 'id' kunt u een voorselectie definiëren van een specifiek object gedefinieerd door 'classid' en 'id'. Het attribuut 'triggerid' wordt gebruikt om dynamische pagina's  te tonen in een statische object listview.";
$l_we_tag['object']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['pagelogger']['description'] = "De we:pagelogger tag genereert, aan de hand van het geselecteerde &quot;type&quot; attribuut, de benodigde code voor pageLogger of de bestandsserver - respectievelijk de download code.";
$l_we_tag['path']['description'] = "De we:path tag representeert het pad van het huidige document. Als er zich een index bestand bevindt in één van de subdirectories, wordt een koppeling ingesteld op de respectieve directory. De gebruikte index bestanden (komma gescheiden) kunnen gespecificeerd worden in het attribuut 'index'. Als er niks gekozen is worden 'default.html', 'index.htm', 'index.php', 'default. htm', 'default.html' en 'default.php' gebruikt als standaard instellingen. In het attribuut 'home' kunt u kiezen wat er aan het begin moet komen. Als er niks gekozen is wordt 'home' automatisch getoond. De attribuut seperator omschrijft de afbakening tussen de directories. Als het attribuut leeg is wordt '/' gebruikt als scheiding. Het attribuut 'field' definieert welk soort veld (bestanden, directories) word getoond. Het attribuut 'dirfield' definieert welk veld wordt gebruikt bij vertoning in directories. Als het veld leeg is of niet bestaat wordt de invoer van 'field' of de bestandsnaam gebruikt.";
$l_we_tag['paypal']['description'] = "we:paypal implementeert een interface naar de betalings aanbieder paypal. Voor optimale werking van deze tag dient u additionele informatie toe te voegen in de backend van de winkel module.";
$l_we_tag['position']['description'] = "De tag we:position wordt gebruikt om de eigenlijke positie van een listview, block, linklist, listdir op te vragen. Als \"type= block or linklist\" dan is het noodzakelijk om de naam (referentie) van de gerelateerde block/linklist te specificeren. Het attribuut \"format\" bepaalt het format van het resultaat.";
$l_we_tag['postlink']['description'] = "De we:postlink tag zorgt ervoor dat alles wat zich binnen de begin en eind tag bevindt, niet getoond wordt bij de laatste koppeling in de link list.";
$l_we_tag['postlink']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['prelink']['description'] = "De we:prelink tag zorgt ervoor dat alles wat zich binnen de begin en eind tag bevindt, niet getoond wordt bij de eerste link in de link list.";
$l_we_tag['prelink']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['printVersion']['description'] = "De we:printVersion tag creëert een HTML koppeling tag die refereert aan hetzelfde document, met een ander sjabloon. Het attribuut 'tid' bepaalt het sjabloon ID. De tag koppelt alle content binnen de begin tag en de eind tag.";
$l_we_tag['printVersion']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['processDateSelect']['description'] = "De we:processDateSelect tag verwerkt de 3 waardes uit de select boxes van de we:dateSelect tag naar een UNIX tijdstempel. De waarde wordt bewaard naar een globale variabele met de naam die was ingevoerd in het attribuut &quot;name&quuot;.";
$l_we_tag['quicktime']['description'] = "De we:quicktime tag geeft de mogelijkheid een QuickTime film in te voegen in de content van een document. Documenten gebasseerd op dit sjabloon bevatten een Wijzig knop in de Wijzig modus. Wanneer u op deze knop drukt, opent u de Bestands manager waarmee u een QuickTime film kunt selecteren binnen webEdition. Er bestaat nog geen xhtml-valid output die werkt in gebruikelijke browsers (IE, Mozilla). Daarom staat xml altijd op 'false'";
$l_we_tag['registeredUser']['description'] = "De we:registeredUser tag wordt gebruikt om klant data, opgeslagen in de klant module, te printen.";
$l_we_tag['registerSwitch']['description'] = "Deze tag genereert een switch waarmee u kan schakelen tussen de status van een geregistreerde en een ongeregistreerde gebruiker in de edit-mode. Indien u de &lt;we:ifRegisteredUser&gt; en &lt;we:ifNotRgisteredUser&gt; tags gebruikt, deze tag geeft de mogelijkheid veschillende weergaven te zien en controle te houden over de lay-out.";
$l_we_tag['repeat']['description'] = "Content omsloten in deze tag wordt herhaald voor elke invoer gevonden door een &lt;we:listview&gt;. Deze tag wordt alleen gebruikt binnen een &lt;we:listview&gt; sectie.";
$l_we_tag['repeat']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['repeatShopItem']['description'] = "Deze tag toont alle artikelen in de winkelmand.";
$l_we_tag['repeatShopItem']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['returnPage']['description'] = "De we:returnPage tag wordt gebruikt om de refererende URL te tonen, als de waarde van het attribuut 'return' op 'true' stond bij gebruik in de tags: &lt;we:a edit='document'&gt; or &lt;we:a edit='object'&gt;";
$l_we_tag['saferpay']['description'] = "we:saferpay implementeert een interface naar de betalings aanbieder saferpay. Voor optimale werking van deze tag dient u additionele informatie toe te voegen in de backend van de winkel module.";
$l_we_tag['saveRegisteredUser']['description'] = "De we:saveRegisteredUser tag bewaart alle klantdata ingevoerd door middel van sessie velden.";
$l_we_tag['search']['description'] = "De we:search tag creeert een input box of een tekst box die is bedoeld voor zoek opdrachten. Het zoek veld heeft de interne naam \"we_search\". Met als gevolg, als het zoek-formulier is voorgelegd, De PHP variabele \"we_search\" op de ontvangende internet pagina wordt gevuld met de inhoud van de input box.";
$l_we_tag['select']['description'] = "De we:select tag creeert een select box voor invoer in de Wijzig modus. Als \"1\" is gespecificeerd als grootte (size= \"1\" ), verschijnt de select box als een pop-up menu. Dit werkt hetzelfde als een HTML select tag. Binnen de begin tag en de eind-tag, worden invoeren bepaald door middel van normale HTML option tags.";
$l_we_tag['select']['defaultvalue'] = "&lt;option&gt;#1&lt;/option&gt;
&lt;option&gt;#2&lt;/option&gt;
&lt;option&gt;#3&lt;/option&gt;";
$l_we_tag['sendMail']['description'] = "De we:sendMail tag verstuurt een webEdition pagina als e-mail naar de adresssen die zijn opgegeven in het attribuut 'recipient'.";
$l_we_tag['sessionField']['description'] = "De we:sessionField tag creëert een HTML input, select of text area tag. Het wordt gebruikt voor elke invoer in sessie velden (bijv. Userdata, etc.).";
$l_we_tag['sessionLogout']['description'] = "De we:sessionLogout tag creëert een HTML koppeling tag die refereert aan een intern webEdition document met het ID genoemd in de webEdition Tag Wizard. Indien dit webEdition document een we:sessionStart tag bevat met het attribuut \"dynamic\", dan wordt de active sessie geleegd en afgesloten. Er worden geen gegevens bewaard.";
$l_we_tag['sessionLogout']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['sessionStart']['description'] = "Deze tag wordt gebruikt om een sessie te starten of om een bestaande sessie te hervatten. Deze tag is vereist in sjablonen die de volgende pagian's genereren: Pagina's die afgeschermd zijn met de Klant beheer module, Winkel pagina's en pagina's die front end invoer ondersteunen.&lt;br /&gt;Deze tag MOET geplaatst worden op de eerste regel van het sjabloon!";
$l_we_tag['setVar']['description'] = "De we:setVar tag wordt gebruikt om de waardes van verschillende types variabelen in te stellen.";
$l_we_tag['shipping']['description'] = "Met betrekking tot de aankoop wordt we:shipping gebruikt om de verzend kosten te bepalen. Deze kosten zijn gebaseerd op de waarde van de winkelwagen, het land van herkomst van de geregistreerde gebruiker en de verzend overeenkomsten, te wijzigen in de Winkel module. De parameter \"sum\" bevat de naam van een met we:sum berekende som. De parameter type wordt gebruikt bij het bepalen van de netto waarde, bruto waarde of het aantal van de BTW toebehorend aan de verzendkosten.";
$l_we_tag['shopField']['description'] = "Deze tag geeft de mogelijkheid om meerdere invoervelden direct aan een artikel/winkelwagen (bestelling) toe te voegen. De beheerder kan sommige waardes vooraf definiëren waaruit de klant een eigen waarde kan selecteren of invoeren. Hierdoor is het mogelijk om meerdere artikel varianten eenvoudig in kaart te brengen.";
$l_we_tag['shopVat']['description'] = "Deze tag wordt gebruikt voor het bepalen van de BTW van een artikel. Gebruik om verschillende BTW waardes te beheren de Winkel module. Een opgegeven Id geeft direct de BTW waarde van dit artikel weer.";
$l_we_tag['showShopItemNumber']['description'] = "De we:showShopItemNumber tag toont het aantal gespecificeerde onderdelen in de winkelmand.";
$l_we_tag['sidebar']['description'] = ""; // TRANSLATE
$l_we_tag['sidebar']['defaultvalue'] = "Open sidebar"; // TRANSLATE
$l_we_tag['subscribe']['description'] = "De we:subscribe tag wordt gebruikt om een single input veld toe te voegen aan een webEdition document zodat de gebruiker zich kan inschrijven voor een nieuwsbrief.";
$l_we_tag['sum']['description'] = "De we:sum tag sommeert alle figuren in een lijst.";
$l_we_tag['target']['description'] = "Deze tag wordt gebruikt om de doel van een koppeling te genereren binnen een &lt;we:linklist&gt;.";
$l_we_tag['textarea']['description'] = "De we:textarea tag creeert een multi-line invoer box.";
$l_we_tag['title']['description'] = "De we:title tag creeert een normale titel tag. Als het titelveld in de Eigenschappen weergave leeg is, wordt alles tussen de  begin en eind tag gebruikt als standaard titel.";
$l_we_tag['tr']['description'] = "De &lt;we:tr&gt; Tag correspondeert aan de HTML-tag &lt;tr&gt; en wordt gebruikt om een tabel rij te definieren.";
$l_we_tag['tr']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['unsubscribe']['description'] = "De we:unsubscribe tag wordt gebruikt om een single input veld te genereren op een webEdition document zodat de gebruiker zijn e-mailadres kan invoeren voor uitschrijving van een nieuwsbrief.";
$l_we_tag['url']['description'] = "De we:url tag creëert een interne webEdition URL die refereert aan het document met onderstaand ID.";
$l_we_tag['userInput']['description'] = "De we:userInput tag creërt invoervelden voor gebruik met we:form type=&quot;document&quot; of type=&quot;object&quot; om documenten of objecten aan te kunnen maken.";
$l_we_tag['useShopVariant']['description'] = "De we:shopVariant tag gebruikt de gegevens van een artikel variant a.d.h.v. de opgegeven naam van de variant. Indien er geen variant bestaat met de opgegeven naam wordt het standaard artikel getoond.";
$l_we_tag['var']['description'] = "De we:var tag toont de inhoud van een globaal PHP variable respectief tot de inhoud van een documentveld met onderstaande naam.";
$l_we_tag['voting']['description'] = "De we:voting tag wordt gebruikt om peilingen weer te geven.";
$l_we_tag['voting']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['votingField']['description'] = "Het we:votingField-tag is vereist om de inhoud van een peiling te tonen. Het name-attribuut definieert wat er getoond moet worden. Het attribuut type, definieert hoe. Geldige name-type combinaties zijn: vraag - tekst; antwoord - tekst,radio,selecteer; resultaat - telling, percentage, totaal; id - antwoord, selecteer, radio, peiling;";
$l_we_tag['votingList']['description'] = "Deze tag genereert automatisch de peiling lijsten.";
$l_we_tag['votingList']['defaultvalue'] = ""; // TRANSLATE
$l_we_tag['votingSelect']['description'] = "Gebruik deze tag voor het genereren van een dropdown menu; (&lt;select&gt;) voor het selecteren van een peiling.";
$l_we_tag['write']['description'] = "Deze tag parkeert een document/object gegenereerd door &lt;we:form type=\"document/object&gt;";
$l_we_tag['writeShopData']['description'] = "De we:writeShopData tag schrijft alle huidige winkelmand data naar de database.";
$l_we_tag['writeVoting']['description'] = "Deze tag schrijft een peiling naar de database. Als het attribuut \"id\" gedefinieerd is, wordt alleen de peiling met het respectievelijke id bewaard.";
$l_we_tag['xmlfeed']['description'] = "Deze tag laad xml content vanaf de opgegeven url";
$l_we_tag['xmlnode']['description'] = "Deze tag print een xml element vanaf de opgegeven feed of url.";
$l_we_tag['xmlnode']['defaultvalue'] = ""; // TRANSLATE

?>