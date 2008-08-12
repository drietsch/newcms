<?php 

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


$tag_elements=array();
$tag_attributes=array();
$tag_category=array();
$tag_predefined=array();
$tag_languages=array("Deutsch","English");

#=========================================================
#         tag elements                                   
#=========================================================


$tag_elements[0]["name"]="we:a";
$tag_elements[1]["name"]="we:back";
$tag_elements[2]["name"]="we:category";
$tag_elements[3]["name"]="we:date";
$tag_elements[4]["name"]="we:description";
$tag_elements[5]["name"]="we:else";
$tag_elements[6]["name"]="we:field";
$tag_elements[7]["name"]="we:flashmovie";
$tag_elements[8]["name"]="we:form";
$tag_elements[9]["name"]="we:hidden";
$tag_elements[10]["name"]="we:ifBack";
$tag_elements[11]["name"]="we:ifEditmode";
$tag_elements[12]["name"]="we:ifNext";
$tag_elements[13]["name"]="we:ifNotEditmode";
$tag_elements[14]["name"]="we:ifNotEmpty";
$tag_elements[15]["name"]="we:ifNotFound";
$tag_elements[16]["name"]="we:ifNotSelf";
$tag_elements[17]["name"]="we:ifNotWebEdition";
$tag_elements[18]["name"]="we:ifSelf";
$tag_elements[19]["name"]="we:ifWebEdition";
$tag_elements[20]["name"]="we:img";
$tag_elements[21]["name"]="we:include";
$tag_elements[22]["name"]="we:input";
$tag_elements[23]["name"]="we:keywords";
$tag_elements[24]["name"]="we:link";
$tag_elements[25]["name"]="we:linklist";
$tag_elements[26]["name"]="we:list";
$tag_elements[27]["name"]="we:listview";
$tag_elements[28]["name"]="we:next";
$tag_elements[29]["name"]="we:postlink";
$tag_elements[30]["name"]="we:prelink";
$tag_elements[31]["name"]="we:repeat";
$tag_elements[32]["name"]="we:search";
$tag_elements[33]["name"]="we:select";
$tag_elements[34]["name"]="we:textarea";
$tag_elements[35]["name"]="we:title";
$tag_elements[36]["name"]="we:url";
$tag_elements[37]["name"]="we:var";


#=========================================================
#         tag category                                   
#=========================================================

#=========================================================
#         tag attributes                                  
#=========================================================
$tag_attributes[0]["name"]="name";
$tag_attributes[1]["name"]="dhtmledit";
$tag_attributes[2]["name"]="autobr";
$tag_attributes[3]["name"]="type";
$tag_attributes[4]["name"]="ltext";
$tag_attributes[5]["name"]="start";
$tag_attributes[6]["name"]="method";
$tag_attributes[7]["name"]="cols";
$tag_attributes[8]["name"]="rows";
$tag_attributes[9]["name"]="id";
$tag_attributes[10]["name"]="match";
$tag_attributes[11]["name"]="importrtf";
$tag_attributes[12]["name"]="doctype";
$tag_attributes[13]["name"]="categories";
$tag_attributes[14]["name"]="order";
$tag_attributes[15]["name"]="desc";
$tag_attributes[16]["name"]="maxlength";
$tag_attributes[17]["name"]="size";
$tag_attributes[18]["name"]="format";
$tag_attributes[19]["name"]="sql";
$tag_attributes[20]["name"]="mode";
$tag_attributes[21]["name"]="field";
$tag_attributes[22]["name"]="tokken";
$tag_attributes[23]["name"]="href";
$tag_attributes[24]["name"]="hyperlink";
$tag_attributes[25]["name"]="target";
$tag_attributes[26]["name"]="src";
$tag_attributes[27]["name"]="width";
$tag_attributes[28]["name"]="height";
$tag_attributes[29]["name"]="border";
$tag_attributes[30]["name"]="hspace";
$tag_attributes[31]["name"]="vspace";
$tag_attributes[32]["name"]="action";
$tag_attributes[33]["name"]="target";
$tag_attributes[34]["name"]="method";
$tag_attributes[35]["name"]="showMenues";
$tag_attributes[36]["name"]="bgcolor";
$tag_attributes[37]["name"]="offset";
$tag_attributes[38]["name"]="recipient";
$tag_attributes[39]["name"]="onsuccess";
$tag_attributes[40]["name"]="onerror";
$tag_attributes[41]["name"]="subject";
$tag_attributes[42]["name"]="order";
$tag_attributes[43]["name"]="required";
$tag_attributes[44]["name"]="alt";
$tag_attributes[45]["name"]="max";
$tag_attributes[46]["name"]="values";
$tag_attributes[47]["name"]="mimetype";

#=========================================================
#         tag elements attributes                        
#=========================================================

$tag_elements[0]["attributes"]="9";
$tag_elements[1]["attributes"]="";
$tag_elements[2]["attributes"]="22";
$tag_elements[3]["attributes"]="3 18";
$tag_elements[4]["attributes"]="4";
$tag_elements[5]["attributes"]="";
$tag_elements[6]["attributes"]="3 0 23 24 25 18 44 45 26 27 28 29 30 31";
$tag_elements[7]["attributes"]="0";
$tag_elements[8]["attributes"]="3 9 6 33 38 39 40 41 42 43 47";
$tag_elements[9]["attributes"]="0";
$tag_elements[10]["attributes"]="";
$tag_elements[11]["attributes"]="";
$tag_elements[12]["attributes"]="";
$tag_elements[13]["attributes"]="";
$tag_elements[14]["attributes"]="10";
$tag_elements[15]["attributes"]="";
$tag_elements[16]["attributes"]="9";
$tag_elements[17]["attributes"]="";
$tag_elements[18]["attributes"]="9";
$tag_elements[19]["attributes"]="";
$tag_elements[20]["attributes"]="0 27 28 29 30 31 44";
$tag_elements[21]["attributes"]="9";
$tag_elements[22]["attributes"]="3 0 17 16 18 20 46";
$tag_elements[23]["attributes"]="4";
$tag_elements[24]["attributes"]="0";
$tag_elements[25]["attributes"]="0";
$tag_elements[26]["attributes"]="0";
$tag_elements[27]["attributes"]="12 13 8 14 15 37";
$tag_elements[28]["attributes"]="";
$tag_elements[29]["attributes"]="";
$tag_elements[30]["attributes"]="";
$tag_elements[31]["attributes"]="";
$tag_elements[32]["attributes"]="3 17 16 7 8";
$tag_elements[33]["attributes"]="0 17";
$tag_elements[34]["attributes"]="0 7 8 2 11 1 35 36";
$tag_elements[35]["attributes"]="4";
$tag_elements[36]["attributes"]="9";
$tag_elements[37]["attributes"]="3 0";


#=========================================================
#         tag elements required attributes                
#=========================================================
$tag_elements[0]["required"]="9";
$tag_elements[1]["required"]="";
$tag_elements[2]["required"]="";
$tag_elements[3]["required"]="";
$tag_elements[4]["required"]="";
$tag_elements[5]["required"]="";
$tag_elements[6]["required"]="";
$tag_elements[7]["required"]="0";
$tag_elements[8]["required"]="";
$tag_elements[9]["required"]="0";
$tag_elements[10]["required"]="";
$tag_elements[11]["required"]="";
$tag_elements[12]["required"]="";
$tag_elements[13]["required"]="";
$tag_elements[14]["required"]="10";
$tag_elements[15]["required"]="";
$tag_elements[16]["required"]="9";
$tag_elements[17]["required"]="";
$tag_elements[18]["required"]="9";
$tag_elements[19]["required"]="";
$tag_elements[20]["required"]="0";
$tag_elements[21]["required"]="9";
$tag_elements[22]["required"]="0";
$tag_elements[23]["required"]="";
$tag_elements[24]["required"]="";
$tag_elements[25]["required"]="0";
$tag_elements[26]["required"]="0";
$tag_elements[27]["required"]="";
$tag_elements[28]["required"]="";
$tag_elements[29]["required"]="";
$tag_elements[30]["required"]="";
$tag_elements[31]["required"]="";
$tag_elements[32]["required"]="";
$tag_elements[33]["required"]="0";
$tag_elements[34]["required"]="0";
$tag_elements[35]["required"]="";
$tag_elements[36]["required"]="9";
$tag_elements[37]["required"]="0";


#=========================================================
#         tag elements description - Deutsch          
#=========================================================

$tag_elements[0]["description"]["Deutsch"]="Das we:a Tag erzeugt ein HTML-Link Tag, das auf ein webEdition internes Dokument mit der unten angegebenen ID verweist. Der gesamte Inhalt zwischen Start- und Endtag wird verlinkt.";
$tag_elements[1]["description"]["Deutsch"]="";
$tag_elements[2]["description"]["Deutsch"]='Das we:category Tag wird durch die Kategorie(n) ersetzt, die in der Ansicht "Eigenschaft" dem Dokument zugeordnet wurden. Wenn es mehrere Kategorien sind, werden sie durch Kommas getrennt. Wenn Sie ein anderes Trennzeichen verwenden m&ouml;chten, k&ouml;nnen Sie dies mit dem Attribut "tokken" zuweisen. Bsp.: tokken = " " (Hier werden Leerzeichen verwendet um die Kategorien zu trennen.)';
$tag_elements[3]["description"]["Deutsch"]='Das we:date Tag zeigt, entsprechend dem Formatstring, das aktuelle Datum auf der Seite an. Wenn das Dokument statisch gespeichert wird, sollte der Typ auf "js" gesetzt werden, damit das Datum mit Javascript erzeugt wird.';
$tag_elements[4]["description"]["Deutsch"]='Das we:description Tag erzeugt ein description Meta-Tag. Falls das Beschreibungsfeld in der Ansicht "Eigenschaft" leer ist, wird der Inhalt zwischen Start- und Endtag als default-description eingetragen.';
$tag_elements[5]["description"]["Deutsch"]='';
$tag_elements[6]["description"]["Deutsch"]='';
$tag_elements[7]["description"]["Deutsch"]='Das we:flashmovie Tag dient dazu, einen Flash Movie in den Inhalt des Dokumentes einzubauen. Im Bearbeitungsmodus eines Dokumentes, das diese Vorlage zugrunde liegen hat, ist ein Button "edit" sichtbar. Durch Anklicken dieses Buttons, &ouml;ffnet sich ein Dateimanager, in dem man einen Flash Movie, der zuvor in webEdition angelegt wurde, ausw&auml;hlen kann.';
$tag_elements[8]["description"]["Deutsch"]='Das we:form Tag wird f&uuml;r Such- und Mailformulare eingesetzt. Es funktioniert wie das normale HTML-Form-Tag, jedoch werden zus&auml;tzliche Hidden-Fields vom Parser eingef&uuml;gt.';
$tag_elements[9]["description"]["Deutsch"]='Das we:hidden Tag erzeugt ein hidden-input Tag, den Inhalt der globalen Php-Variablen und dem Namen, der unten eingegeben wird. Dieses Tag wird normalerweise gebraucht, um eingehende Variablen weiterzuleiten.';
$tag_elements[10]["description"]["Deutsch"]='';
$tag_elements[11]["description"]["Deutsch"]="";
$tag_elements[12]["description"]["Deutsch"]="";
$tag_elements[13]["description"]["Deutsch"]="";
$tag_elements[14]["description"]["Deutsch"]='Das we:ifNotEmpty Tag bewirkt, da&szlig; alles, was zwischen dem Start- und Endtag steht nur dann angezeigt wird, wenn das Feld, das den in "match" eingetragenen Namen hat,  nicht leer ist. Eine Ver&auml;nderung ist nur auf der fertigen Webseite und in der Vorschau zu sein, im Bearbeitungsmodus wird alles angezeigt.';
$tag_elements[15]["description"]["Deutsch"]="";
$tag_elements[16]["description"]["Deutsch"]='Das we:ifNotSelf-Tag bewirkt, da&szlig; alles, was zwischen dem Start- und Endtag steht nicht angezeigt wird, wenn das Dokument die unten eingetragene ID hat.';
$tag_elements[17]["description"]["Deutsch"]='Alles was zwischen start- und entag steht wird nicht innerhalb webEdition angezeigt (im Editmode als auch in der Vorschau). Auf der erzeugten Seite wird der Code angezeigt.';
$tag_elements[18]["description"]["Deutsch"]='Durch das we:ifSelf Tag wird der Inhalt zwischen dem Start- und Endtag nur dann angezeigt, wenn es sich um das Dokument mit der ID handelt, die unten angegeben wird.';
$tag_elements[19]["description"]["Deutsch"]='Alles was zwischen start- und entag steht wird nur innerhalb webEdition angezeigt (im Editmode als auch in der Vorschau). Auf der erzeugten Seite wird der Code nicht angezeigt.';
$tag_elements[20]["description"]["Deutsch"]='Das we:img Tag dient dazu eine Grafik in den Inhalt eines Dokumentes einzubauen. Im Bearbeitungsmodus eines Dokumentes, das diese Vorlage zugrunde liegen hat, ist ein Button "edit" sichtbar. Durch Anklicken des Buttons &ouml;ffnet sich der Dateimanager, aus dem man eine Grafik ausw&auml;hlen oder neu anlegen kann. Wenn die Attribute "width", "height", border, "hspace", "vspace" und "alt" gesetzt werden, dann werden diese Einstellungen f&uuml;r die Grafik verwendet, ansonsten gelten die Einstellungen, welche bei der Grafik gemacht wurden.';
$tag_elements[21]["description"]["Deutsch"]='Anstelle des we:include Tags wird die Seite mit der unten angegebenen ID eingef&uuml;gt.';
$tag_elements[22]["description"]["Deutsch"]='Das we:input Tag bewirkt, da&szlig; im Bearbeitungsmodus des Dokumentes, das diese Vorlage zugrundeliegen hat, ein einzeiliges Eingabefeld erzeugt wird, wenn der Typ = "text" ausgew&auml;hlt wird. F&uuml;r die anderen Typen siehe Handbuch oder Hilfe.';
$tag_elements[23]["description"]["Deutsch"]='Das we:keywords Tag erzeugt ein Schl&uuml;sselwort Meta-Tag. Alles zwischen Start- und Endtag wird als default-keywords eingetragen, falls das Schl&uuml;sselwortfeld in der Ansicht "Eigenschaft" leer ist. Ansonsten werden die Schl&uuml;sselworte aus der Ansicht "Eigenschaft" eingetragen.';
$tag_elements[24]["description"]["Deutsch"]='Das we:link Tag wird erzeugt einen einzelnen Link, der durch einen Button "edit" ver&auml;ndert werden kann. Wird das Tag innerhalb von Linklisten verwendet, so darf das Attribut "name" nicht angegeben werden.';
$tag_elements[25]["description"]["Deutsch"]='Mit dem we:linklist Tag kann man Linklisten generieren. Im Bearbeitungsmodus erscheint ein Plus-Button. Klickt man diesen Button, so wird der Liste ein neuer Link hinzugef&uuml;gt. Innerhalb des Start- und Endtags wird mit Hilfe der Tags "we:link", "we:prelink" und "we:postlink", sowie normalem HTML, das Aussehen der Linkliste bestimmt. Alle eingef&uuml;gten Links k&ouml;nnen mit einem Button "edit" ver&auml;ndert werden, oder mit einem Button "l&ouml;schen" gel&ouml;scht werden.';
$tag_elements[26]["description"]["Deutsch"]='Mit dem we:list Tag kann man erweiterbare Listen erzeugen. Alles, was zwischen Start- und Endtag steht, wird im Bearbeitungsmodus durch einen Klick auf den Plus-Button angeh&auml;ngt, bzw. eingef&uuml;gt. Dies k&ouml;nnen beliebiges HTML sowie we:tags sein.';
$tag_elements[27]["description"]["Deutsch"]='Das we:listview Tag ist das Start- und Endtag von automatisch generierten Listen. (&Uuml;bersichtsseiten von News, usw.)';
$tag_elements[28]["description"]["Deutsch"]="";
$tag_elements[29]["description"]["Deutsch"]="";
$tag_elements[30]["description"]["Deutsch"]="";
$tag_elements[31]["description"]["Deutsch"]="";
$tag_elements[32]["description"]["Deutsch"]='Das we:search Tag erzeugt ein Eingabefeld oder ein Textfeld, das f&uuml;r Suchanfragen genutzt werden soll. Das Suchfeld hat intern den Namen "we_search". Wenn die Suchform also submitted wird, dann wird auf der empfangenden Webseite die Php-Variable we_search mit dem Inhalt des Eingabefeldes gef&uuml;llt sein.';
$tag_elements[33]["description"]["Deutsch"]='Das we:select Tag erzeugt im Bearbeitungsmodus eine Auswahlbox f&uuml;r die Eingabe. Wird bei Size eine 1 eingetragen (Size = "1"), so erscheint die Auswahlbox als Popup Men&uuml;. Dieses Tag verh&auml;lt sich genau wie ein HTML-Select-Tag. Innerhalb von Start- und Endtag werden die Eintr&auml;ge durch normale HTML-Options-Tags bestimmt.';
$tag_elements[34]["description"]["Deutsch"]='Das we:textarea Tag erzeugt ein mehrzeiliges Eingabefeld.';
$tag_elements[35]["description"]["Deutsch"]='Das we:title Tag erzeugt ein normales title-Tag. Alles, das zwischen dem Start- und Endtag steht wird als default-Titel eingetragen, falls das Titelfeld in der Ansicht "Eigenschaft" leer ist. Ansonsten wird der Titel aus dieser Ansicht eingetragen.';
$tag_elements[36]["description"]["Deutsch"]='Das we:url Tag erzeugt eine webEdition interne URL, die auf das Dokument mit der unten angegebenen ID verlinkt.';
$tag_elements[37]["description"]["Deutsch"]='Das we:var Tag zeigt den Inhalt einer globalen Php-Variablen bzw. den Inhalt eines Dokumentfeldes, mit dem unten eingegebenen Namen an.';


#=========================================================
#         tag elements description - English          
#=========================================================
$tag_elements[0]["description"]["English"]="";
$tag_elements[1]["description"]["English"]="";
$tag_elements[2]["description"]["English"]="";
$tag_elements[3]["description"]["English"]="";
$tag_elements[4]["description"]["English"]="";
$tag_elements[5]["description"]["English"]="";
$tag_elements[6]["description"]["English"]="";
$tag_elements[7]["description"]["English"]="";
$tag_elements[8]["description"]["English"]="";
$tag_elements[9]["description"]["English"]="";
$tag_elements[10]["description"]["English"]="";
$tag_elements[11]["description"]["English"]="";
$tag_elements[12]["description"]["English"]="";
$tag_elements[13]["description"]["English"]="";
$tag_elements[14]["description"]["English"]="";
$tag_elements[15]["description"]["English"]="";
$tag_elements[16]["description"]["English"]="";
$tag_elements[17]["description"]["English"]="";
$tag_elements[18]["description"]["English"]="";
$tag_elements[19]["description"]["English"]="";
$tag_elements[20]["description"]["English"]="";
$tag_elements[21]["description"]["English"]="";
$tag_elements[22]["description"]["English"]="";
$tag_elements[23]["description"]["English"]="";
$tag_elements[24]["description"]["English"]="";
$tag_elements[25]["description"]["English"]="";
$tag_elements[26]["description"]["English"]="";
$tag_elements[27]["description"]["English"]="";
$tag_elements[28]["description"]["English"]="";
$tag_elements[29]["description"]["English"]="";
$tag_elements[30]["description"]["English"]="";
$tag_elements[31]["description"]["English"]="";
$tag_elements[32]["description"]["English"]="";
$tag_elements[33]["description"]["English"]="";
$tag_elements[34]["description"]["English"]="";
$tag_elements[35]["description"]["English"]="";
$tag_elements[36]["description"]["English"]="";
$tag_elements[37]["description"]["English"]="";

#=========================================================
#         tag attributes alias                            
#=========================================================
$tag_alias[4][4]="Standardwert";
$tag_alias[23][4]="Standardwert";
$tag_alias[35][4]="Standardwert";

#=========================================================
#         tag predefined                          
#=========================================================
$tag_predefined[3][3]="js,php";
$tag_predefined[6][3]="text,date,img";
$tag_predefined[6][24]="on,off";
$tag_predefined[8][3]="formmail";
$tag_predefined[8][6]="get,post";
$tag_predefined[22][3]="text,checkbox,date,choice";
$tag_predefined[27][15]="true";
$tag_predefined[32][3]="textinput,textarea";
$tag_predefined[34][2]="on,off";
$tag_predefined[34][11]="on,off";
$tag_predefined[34][1]="on,off";
$tag_predefined[34][35]="on,off";
$tag_predefined[37][3]="global,document";


#=========================================================
#         tags which needs close tag                          
#=========================================================
$need_close="0 1 4 8 10 11 12 13 14 15 16 17 18 19 23 25 26 27 28 29 30 31 35";
/*$need_close="13 16 17 18 19 20";*/

?>