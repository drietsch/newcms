<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");


/** Funktion zum Blaettern
*	Funktion zum erstellen einer Linkliste, die das Blaettern durch eine bestimmte Zahl von Ergebnissen erlaubt
*
*	@author Jan Gorba <jan.gorba@webedition.de>
*	@link http://www.webedition.de/
*	@version 1.0_php4 (de)
*
*
*	@advice Tabulatorweite ist 4
*/

// Nur waehrend der Entwicklung interessant
// error_reporting(E_ALL);

/*
Alle moeglichen Varianten
	Anfang -- Zurueck - 1, 2, 3 ... 6, 7, 8 ... 11, 12, 13 - Weiter -- Ende
	Zurueck - 1, 2, 3 ... 6, 7, 8 ... 11, 12, 13 - Weiter
	Anfang - 1, 2, 3 ... 6, 7, 8 ... 11, 12, 13 - Ende
	1, 2, 3 ... 6, 7, 8 ... 11, 12, 13

	Anfang -- Zurueck - ... 6, 7, 8 ... - Weiter -- Ende
	Zurueck ... 6, 7, 8 ... Weiter
	Anfang ... 6, 7, 8 ... Ende
	... 6, 7, 8 ...

	Anfang -- Zurueck - 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 - Weiter -- Ende
	Zurueck - 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 - Weiter
	Anfang - 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 - Ende
	1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13

Variablen fuer Links
	Variable						Beispiel						Ausgabebeispiel
	$delimiter1						--								Anfang -- Zurueck
	$delimiter2						-								Zurueck - 1
	$delimiter3						,								1, 2, 3
	$delimiter4						...								1, 2, 3 ... 6, 7, 8

	$link_active_text				Seite							Seite 1, Seite 2, Seite 3
	$link_active_bracket_left		[								6, [7], 8
	$link_active_bracket_right		]								6, [7], 8
	$link_active_more				style='font-size:1.2em;'		<a href='...' style='font-size:1.2em;'>

	$link_text						Seite							Seite 1, Seite 2, Seite 3
	$link_bracket_left				>								>1<, >2<, >3<
	$link_bracket_right				<								>1<, >2<, >3<
	$link_more						target='_blank'					<a href='...' target='_blank'>

	$link_first_text				Anfang							Anfang -- Zurueck
	$link_last_text					Ende							Weiter -- Ende
	$link_first_last_more			style='font-family:arial;'		<a href='...' style='font-family:arial;'>

	$link_next_text					Weiter							Weiter -- Ende
	$link_prev_text					Zurueck							Anfang -- Zurueck
	$link_next_prev_more			class='navigation'				<a href='...' class='navigation'>

	$show_count						3								6, 7, 8
	$show_continuous				true/false						true: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13
																	false: abhaengig von $show_outer
	$show_outer						true/false						true: 1, 2, 3 ... 6, 7, 8 ... 11, 12, 13
																	false: ... 6, 7, 8 ...
	$show_next_prev					true/false						true: Weiter/Zurueck anzeigen, false: nicht anzeigen
	$show_first_last				true/false						true: Anfang/Ende anzeigen, false: nicht anzeigen
	$show_active_link				true/false						true: 6, [7], 8, false: 6, 8
	$show_single_link				true/false						true: [1], false: (nichts)

	$link_href						bilder.php?id=$id&page=			<a href='bilder.php?id=BMW&page=2'>
*/

class blaettern {



	/** Erstellt einen normalen webEdition pager für den Shop
	*
	*	@access public
	*	@param string $url URL der Seite
	*	@param int $actPage Aktuelle Seitenzahl (0 = erste Seite)
	*	@param int $nrOfPage Anzahl Einträge pro Seite
	*	@param int $anz Anzahl Einträge gesamt
	*/
	function getStandardPagerHTML($url,$actPage,$nrOfPage,$anz ) {
		$we_button = new we_button();
		$offset = $actPage * $nrOfPage;

		$nextprev = '<table cellpadding="0" cellspacing="0" border="0"><tr><td>';
		if($actPage > 0) {
			$nextprev .= $we_button->create_button("back", $url . '&actPage=' . ($actPage - 1));
		} else {
			$nextprev .= $we_button->create_button("back", "#", false, 100, 22, "", "", true);
		}

		$nextprev .= '</td><td>'.getPixel(23,1)."</td><td class='defaultfont'><b>".(($anz)?$offset+1:0)."-";
		if ( ($anz-$offset) < $nrOfPage) {
			$nextprev .= $anz;
		} else {
			$nextprev .= $offset+$nrOfPage;
		}
		$nextprev .= "&nbsp;&nbsp;".$GLOBALS["l_global"]["from"]."&nbsp;&nbsp;".$anz."</b></td><td>".getPixel(23,1).'</td><td>';
		if (($offset+$nrOfPage) < $anz) {
			$nextprev .= $we_button->create_button("next", $url . '&actPage=' . ($actPage + 1));
		} else {
			$nextprev .= $we_button->create_button("next", "#", false, 100, 22, "", "", true);
		}
		$nextprev .= "</td></tr></table>";
		return $nextprev;

	}

	/** Erstellt ein Objekt fuer die Blaetterfunktion
	*
	*	@access public
	*	@param (int) $active_page						Zahl der aktuellen Seite, erhaelt man ungefaehr so: "$active_page=isset($_GET['ap']) ? $_GET['ap'] : 0;"
	*	@param (int) $entries							Anzahl aller Ergebnisse; erhaelt man ungefaehr so: "$entries=mysql_num_rows($resource);"
	*/
	function blaettern($active_page, $entries) {
		$this->set_Active_Page($active_page);
		$this->set_Entries($entries);
	}


	/** Erstellt die Liste mit Links
	*
	*	@access public
	*	@return (mixed)									Gibt den erstellten String der Links oder false bei Fehlern zurueck
	*/
	function create() {
		// Hab keine Lust mit den langen Namen zu arbeiten, also erstelle ich Referenzen darauf... :)
		$active_page				= &$this->active_page;
		$entries					= &$this->entries;
		$epp						= &$this->epp;
		$link_count					= &$this->link_count;
		$link_count_surround		= &$this->link_count_surround;
		$show_count					= &$this->show_count;
		$show_continuous			= &$this->show_continuous;
		$show_outer					= &$this->show_outer;
		$show_single_link			= &$this->show_single_link;
		$show_active_link			= &$this->show_active_link;
		$page_next					= &$this->page_next;
		$page_prev					= &$this->page_prev;
		$page_first					= &$this->page_first;
		$page_last					= &$this->page_last;
		$links						= &$this->links;


		// Array neu initialisieren
		$links=array();

		// Erst einmal testen, ob die Werte okay sind
		if ($entries==0) {
			$links[0]='';
			return $links;
		}

		// Anzahl aller moeglichen Links zu den Seiten ermitteln
		$link_count = $entries%$epp==0 ? (int)$entries/$epp : (int)ceil($entries/$epp);

		// Ermitteln, wie viele Links den aktuellen umgeben werden
		$link_count_surround=floor($show_count/2);

		// Wenn sinnvoll ($show_outer===true, aber $link_count<=$show_count*3), dann ueberschreiben wir hier $show_continuous
		if ($show_outer===true &&
			$link_count<=$show_count*3) {
			$show_continuous=true;
		}

		// Angabe der aktuelllen Seite pruefen, gegebenenfalls neu setzen
		if ($link_count<$active_page) {
			$active_page=$link_count-1;
		}
		elseif (!is_numeric($active_page) ||
				$active_page<0) {
			$active_page=0;
		}

		// Jetzt berechnen wir erst einmal die Seitenzahlen fuer die erste, letzte, naechste und vorherige Seite
		// Sollte eine Seite nicht existieren, dann ist der Wert null (nicht 0!)
		$page_next=$active_page+1;
		if ($page_next>=$link_count-1 &&
			$active_page==$link_count-1) {
			$page_next=null;
		}
		$page_prev=$active_page-1;
		if ($page_prev<=0 &&
			$active_page==0) {
			$page_prev=null;
		}
		$page_first=0;
		if ($active_page==0) {
			$page_first=null;
		}
		$page_last=$link_count-1;
		if ($active_page==$link_count-1) {
			$page_last=null;
		}


		// Wenn kein Blaettern zu Stande kommt, dann mal schauen, ob der Nutzer den einzelnen Link sehen will
		if (($show_single_link===false ||
			 $show_active_link===false) &&
			$entries<=$show_count) {
			$links='';
			return $links;
		}

		// Alle Seitenzahlen durchgehen (egal, ob am Ende gezeigt oder nicht) und Seitenzahlen im Array speichern
		for ($i=0; $i<$link_count; $i++) {
			$links[]=$i;
		}
		// Links aus Seitenzahlen erstellen
		$this->_make_links();

		// Wenn alle Seiten angezeigt werden sollen...
		// ...oder Anzahl Links kleiner oder gleich der zu zeigenden ist, dann die Links speichern
		if ($show_continuous===true ||
			$link_count<=$show_count) {
			$this->_add_delimiter3();
		}
		else {
			// Oder wenn nicht alle Links angezeigt werden sollen...
			// ...und nicht die aeusseren, dann Links speichern
			if ($show_outer===false) {
				// Wenn aktiver Link einer der aeusseren ist, dann dieses gesondert zeigen
				if ($active_page<=$link_count_surround) {
					$links=$this->_get_Outer_Links('left');
					$this->_add_delimiter3();
					$this->_add_delimiter4(false, true);
				}
				elseif ($active_page>=$page_last-$link_count_surround) {
					$links=$this->_get_Outer_Links('right');

					$this->_add_delimiter3();
					$this->_add_delimiter4(true, false);
				}
				// Ansonsten die $show_count relevanten Links ermitteln und speichern
				else {
					$links=$this->_get_Inner_Links();
					$this->_add_delimiter3();
					$this->_add_delimiter4(true, true);
				}
			}
			// Oder wenn nicht alle Links angezeigt werden sollen...
			// ...und die aeusseren, dann Links speichern
			elseif ($show_outer===true) {
				// Alle moeglichen Links sammeln
				$temp[0]=$this->_get_Outer_Links('left');
				$temp[1]=$this->_get_Inner_Links();
				$temp[2]=$this->_get_Outer_Links('right');

				// Alle drei Arrays in eins packen
				// Keine array_*-Funktion, da diese die Indizes loeschen
				$temp2=$temp[0];
				for ($i=1; $i<3; $i++) {
					foreach ($temp[$i] as $k => $v) {
						$temp2[$k]=$v;
					}
				}
				$temp=$temp2;
				unset($temp2);
				ksort($temp);

				// Zusammenhaengende Links (Abstand zum naechsten gleich 1) in eigene Arrays packen
				$last_index=0;
				$j=0;
				foreach ($temp as $k => $v) {
					if ($k-$last_index>1) {
						$j++;
					}

					$temp2[$j][]=$v;

					$last_index=$k;
				}

				// Arrays zusammenhaengender Links zu Strings zusammenfassen
				// Kein Funktionsaufruf, da diese auf $this->links zugreifen
				unset($temp);
				for ($i=0; $i<count($temp2); $i++) {
					$temp[]=join($this->delimiter3, $temp2[$i]);
				}
				$links=join($this->delimiter4, $temp);
			}
		}

		// Links fuer Weiter/Zurueck und Anfang/Ende hinzufuegen, na ja, wenn es denn gewuenscht ist
		$this->_add_Next_Prev();
		$this->_add_First_Last();

		return $links;
	}


	/** Macht aus den im Array $links gepeicherten IDs Links mit allem Dran und Drum
	*
	*	@access private
	*/
	function _make_links() {
		// Hab keine Lust mit den langen Namen zu arbeiten, also erstelle ich Referenzen darauf... :)
		$active_page				= &$this->active_page;
		$link_href					= &$this->link_href;
		$link_active_bracket_left 	= &$this->link_active_bracket_left;
		$link_active_bracket_right	= &$this->link_active_bracket_right;
		$link_active_more			= &$this->link_active_more;
		$link_active_text			= &$this->link_active_text;
		$link_bracket_left			= &$this->link_bracket_left;
		$link_bracket_right			= &$this->link_bracket_right;
		$link_more					= &$this->link_more;
		$link_text					= &$this->link_text;
		$show_active_link			= &$this->show_active_link;
		$links						= &$this->links;

		for ($i=0; $i<count($links); $i++) {
			if ($i==$active_page) {
				$temp=$i+1;
				$links[$i]="<a href='{$link_href}{$i}'{$link_active_more}>{$link_active_bracket_left}{$link_active_text}{$temp}{$link_active_bracket_right}</a>";
			}
			else {
				$temp=$i+1;
				$links[$i]="<a href='{$link_href}{$i}'{$link_more}>{$link_bracket_left}{$link_text}{$temp}{$link_bracket_right}</a>";
			}
		}

		// Jetzt lassen wir den aktiven Link verschwinden - wenn denn gewuenscht
		if ($show_active_link===false) {
			unset($links[$active_page]);
		}
		unset($temp);
		foreach ($links as $k => $v) {
			$temp[]=$v;
		}
		$links=$temp;
	}


	/** Gibt Array der inneren Links zurueck
	*
	*	@access private
	*/
	function _get_Inner_Links() {
		// Hab keine Lust mit den langen Namen zu arbeiten, also erstelle ich Referenzen darauf... :)
		$active_page				= &$this->active_page;
		$page_first					= &$this->page_first;
		$page_last					= &$this->page_last;
		$link_count_surround		= &$this->link_count_surround;
		$link_count					= &$this->link_count;
		$show_count					= &$this->show_count;
		$links						= &$this->links;

		$temp=false;
		$from=$active_page-$link_count_surround;
		if ($from<0) {
			$from=0;
		}
		$to=$from+$show_count;
		if ($to>$link_count-1) {
			$to=$link_count-1;
		}

		for ($i=$from; $i<$to; $i++) {
			$temp[$i]=$links[$i];
		}

		return $temp;
	}


	/** Gibt Array mit aeusseren Links (links 'left' oder rechts 'right') zurueck
	*
	*	@access private
	*/
	function _get_Outer_Links($side=null) {
		// Hab keine Lust mit den langen Namen zu arbeiten, also erstelle ich Referenzen darauf... :)
		$show_active_link			= &$this->show_active_link;
		$link_count					= &$this->link_count;
		$show_count					= &$this->show_count;
		$links						= &$this->links;

		$temp=false;

		if ($side==='left') {
			for ($i=0; $i<$show_count; $i++) {
				$temp[$i]=$links[$i];
			}
		}
		elseif ($side==='right') {
			// Der erste Workaround, da sonst ein Link zu wenig gezeigt wird, wenn aktiver ausgeblendet
			if ($show_active_link===false) {
				$from=$link_count-$show_count-1;
			}
			else {
				$from=$link_count-$show_count;
			}
			$to=$from+$show_count;

			for ($i=$from; $i<$to; $i++) {
				$temp[$i]=$links[$i];
			}
		}

		return $temp;
	}


	/** Macht aus den im Array $links gepeicherten IDs Links mit allem Dran und Drum (siehe Beispiele)
	*
	*	@access private
	*/
	function _add_Delimiter1() {
		if ($this->page_first!==null) {
			$this->links=$this->delimiter1.$this->links;
		}
		if ($this->page_last!==null) {
			$this->links=$this->links.$this->delimiter1;
		}
	}


	/** Macht aus den im Array $links gepeicherten IDs Links mit allem Dran und Drum (siehe Beispiele)
	*
	*	@access private
	*/
	function _add_Delimiter2() {
		// Hab keine Lust mit den langen Namen zu arbeiten, also erstelle ich Referenzen darauf... :)
		$links						= &$this->links;
		$page_prev					= &$this->page_prev;
		$page_next					= &$this->page_next;
		$delimiter2					= &$this->delimiter2;
		$delimiter4					= &$this->delimiter4;

		if ($page_prev!==null &&
			// Verhindern, dass Delimiter2 gezeigt wird, wenn Delimiter4 schon da ist (pure Schoenheit)
			substr($links, 0, strlen($delimiter4)) != $delimiter4) {
				$links=$delimiter2.$links;
		}
		if ($page_next!==null &&
			substr($links, -1*strlen($delimiter4)) != $delimiter4) {
			$links=$links.$delimiter2;
		}
	}


	/** Macht aus den im Array $links gepeicherten IDs Links mit allem Dran und Drum (siehe Beispiele)
	*
	*	@access private
	*/
	function _add_Delimiter3() {
		$this->links=join($this->delimiter3, $this->links);
	}


	/** Macht aus den im Array $links gepeicherten IDs Links mit allem Dran und Drum (siehe Beispiele)
	*
	*	@access private
	*/
	function _add_Delimiter4($left=false, $right=false) {
		if ($left===true) {
			$this->links=$this->delimiter4.$this->links;
		}
		if ($right===true) {
			$this->links=$this->links.$this->delimiter4;
		}
	}


	/** Fuegt dem Array Links fuer Weiter/Zurueck hinzu - wenn denn gewuenscht
	*
	*	@access private
	*/
	function _add_Next_Prev() {
		// Hab keine Lust mit den langen Namen zu arbeiten, also erstelle ich Referenzen darauf... :)
		$active_page				= &$this->active_page;
		$link_href					= &$this->link_href;
		$link_next_text	 		 	= &$this->link_next_text;
		$link_prev_text	 		 	= &$this->link_prev_text;
		$link_next_prev_more		= &$this->link_next_prev_more;
		$show_next_prev				= &$this->show_next_prev;
		$page_next					= &$this->page_next;
		$page_prev					= &$this->page_prev;
		$links						= &$this->links;

		if ($show_next_prev===true) {
			$this->_add_delimiter2();

			$temp1=$temp2='';
			if ($page_prev!==null) {
				$temp1="<a href='{$link_href}".($page_prev-$this->steps_next_prev+1)."'{$link_next_prev_more}>$link_prev_text</a>";
			}
			if ($page_next!==null) {
				$temp2="<a href='{$link_href}".($page_next+$this->steps_next_prev-1)."'{$link_next_prev_more}>$link_next_text</a>";
			}
			$links=$temp1.$links.$temp2;
		}
	}


	/** Fuegt dem Array Links fuer Anfang/Ende hinzu - wenn denn gewuenscht
	*
	*	@access private
	*/
	function _add_First_Last() {
		// Hab keine Lust mit den langen Namen zu arbeiten, also erstelle ich Referenzen darauf... :)
		$link_href					= &$this->link_href;
		$link_first_text 		 	= &$this->link_first_text;
		$link_last_text	 		 	= &$this->link_last_text;
		$link_first_last_more		= &$this->link_first_last_more;
		$show_first_last			= &$this->show_first_last;
		$page_first					= &$this->page_first;
		$page_last					= &$this->page_last;
		$links						= &$this->links;

		if ($show_first_last===true) {
			$this->_add_delimiter1();

			$temp1=$temp2='';
			if ($page_first!==null) {
				$temp1="<a href='{$link_href}{$page_first}'{$link_first_last_more}>$link_first_text</a>";
			}
			if ($page_last!==null) {
				$temp2="<a href='{$link_href}{$page_last}'{$link_first_last_more}>$link_last_text</a>";
			}
			$links=$temp1.$links.$temp2;
		}
	}


	/** Setzt Wert fuer Zahl der aktuelle Seite
	*	<b>Achtung</b> 10 hier, bedeutet bei der Ausgabe Seite 11
	*	Dieser Wert MUSS dynamisch festgelegt werden
	*	'ap' MUSS mit der letzten Variable bei $link_href uebereinstimmen (ap = active page)
	*
	*	@access public
	*	@param (int) $active_page						Zahl der aktuellen Seite, erhaelt man ungefaehr so: "$active_page=isset($_GET['ap']) ? $_GET['ap'] : 0;"
	*	@return (bool)									Gibt false zurueck, wenn $active_page keinen gueltigen Wert hat
	*/
	function set_Active_Page($active_page) {
		if (is_numeric($active_page)) {
			$this->active_page=round($active_page);
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt Wert fuer Gesamtzahl aller Eintraege
	*
	*	@access public
	*	@param (int) $entries							Anzahl aller Ergebnisse; erhaelt man ungefaehr so: "$entries=mysql_num_rows($resource);"
	*	@return (bool)									Gibt false zurueck, wenn $entries keinen gueltigen Wert hat
	*/
	function set_Entries($entries) {
		if (is_numeric($entries)) {
			$this->entries=round($entries);
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt Wert fuer Anzahl Ergebnis pro Seite, die angezeigt werden sollen
	*
	*	@access public
	*	@param (int) $epp								Anzahl Ergebnis pro Seite, die angezeigt werden sollen
	*	@return (bool)									Gibt false zurueck, wenn $epp keinen gueltigen Wert hat
	*/
	function set_Entries_Per_Page($epp) {
		if (is_numeric($epp) &&
			$epp>=0) {
			$this->epp=round($epp);
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt Wert fuer Link, zu dem verwiesen werden soll
	*	<b>WICHTIG</b> Die Variable, die den Wert der aktuellen Seite enthaelt muss ganz am Ende stehen und dahinter ein = (siehe Beispiele)!!
	*	Die Seitenzahl wird immer hinten angehangen, weshalb das unbedingt beachtet werden muss!
	*
	*	@access public
	*	@param (string) $link_href						Link, zu dem verwiesen werden soll
	*	@return (bool)									Gibt false zurueck, wenn $link_href keinen gueltigen Wert hat
	*/
	function set_Link_Href($link_href) {
		if (is_string($link_href)) {
			if (substr($link_href, -1)!='=') {
				$link_href.='=';
			}
			$this->link_href=trim($link_href);
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt Trennzeichen zwischen Links Anfang/Zurueck und Weiter/Ende
	*
	*	@access public
	*	@param (string) $delimiter1						Zeichen, die zwischen Links Anfang/Zurueck und Weiter/Ende angezeigt werden (siehe 'Alle moeglichen Varianten')
	*	@return (bool)									Gibt false zurueck, wenn $delimiter1 keinen gueltigen Wert hat
	*/
	function set_Delimiter1($delimiter1=' -- ') {
		if (is_string($delimiter1)) {
			$this->delimiter1=$delimiter1;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt Trennzeichen zwischen Links Zurueck und den Seitenzahlen sowie Weiter und den Seitenzahlen
	*
	*	@access public
	*	@param (string) $delimiter2						Zeichen, die zwischen Links Zurueck und den Seitenzahlen sowie Weiter und den Seitenzahlen angezeigt werden (siehe 'Alle moeglichen Varianten')
	*	@return (bool)									Gibt false zurueck, wenn $delimiter2 keinen gueltigen Wert hat
	*/
	function set_Delimiter2($delimiter2=' - ') {
		if (is_string($delimiter2)) {
			$this->delimiter2=$delimiter2;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt Trennzeichen zwischen Links der einzelnen Seiten
	*
	*	@access public
	*	@param (string) $delimiter3						Zeichen, die zwischen Links der einzelnen Seiten gezeigt weden (siehe 'Alle moeglichen Varianten')
	*	@return (bool)									Gibt false zurueck, wenn $delimiter3 keinen gueltigen Wert hat
	*/
	function set_Delimiter3($delimiter3=', ') {
		if (is_string($delimiter3)) {
			$this->delimiter3=$delimiter3;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt Trennzeichen zwischen Links der einzelnen Seiten
	*
	*	@access public
	*	@param (string) $delimiter4						Zeichen, die zwischen Links der einzelnen Seiten gezeigt werden (siehe 'Alle moeglichen Varianten')
	*	@return (bool)									Gibt false zurueck, wenn $delimiter4 keinen gueltigen Wert hat
	*/
	function set_Delimiter4($delimiter4=' ... ') {
		if (is_string($delimiter4)) {
			$this->delimiter4=$delimiter4;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt Wert fuer Zeichen vor und hinter aktivem Link
	*
	*	@access public
	*	@param (string) $link_active_bracket_left		Zeichen vor aktivem Link (siehe 'Variablen')
	*	@param (string) $link_active_bracket_right		Zeichen hinter aktivem Link (siehe 'Variablen')
	*	@return (bool)									Gibt false zurueck, wenn $link_active_bracket_left oder $link_active_bracket_right keinen gueltigen Wert hat
	*/
	function set_Link_Active_Bracket($link_active_bracket_left='[', $link_active_bracket_right=']') {
		if (is_string($link_active_bracket_left) &&
			is_string($link_active_bracket_right)) {
			$this->link_active_bracket_left=trim($link_active_bracket_left);
			$this->link_active_bracket_right=trim($link_active_bracket_right);
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt erweiterte Einstellungen des aktiven Links
	*
	*	@access public
	*	@param (string) $link_active_more				Erweitere Einstellungen des aktiven Links (JavaScript, CSS, target, ...)
	*	@return (bool)									Gibt false zurueck, wenn $link_active_more keinen gueltigen Wert hat
	*/
	function set_Link_Active_More($link_active_more='') {
		if (is_string($link_active_more)) {
			$link_active_more=' '.trim($link_active_more);
			$this->link_active_more=$link_active_more;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt Wert fuer Zeichen vor und hinter jeden (nicht aktiven) Link
	*
	*	@access public
	*	@param (string) $link_bracket_left				Zeichen vor jedem (nicht aktiven) Link (siehe 'Variablen')
	*	@param (string) $link_bracket_right				Zeichen hinter jedem (nicht aktiven) Link (siehe 'Variablen')
	*	@return (bool)									Gibt false zurueck, wenn $link_bracket_left keinen gueltigen Wert hat
	*/
	function set_Link_Bracket_Left($link_bracket_left='', $link_bracket_right='') {
		if (is_string($link_bracket_left) &&
			is_string($link_bracket_right)) {
			$this->link_bracket_left=trim($link_bracket_left);
			$this->link_bracket_right=trim($link_bracket_right);
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt erweiterte Einstellungen fuer jeden (nicht aktiven) Link
	*
	*	@access public
	*	@param (string) $link_more						Erweitere Einstellungen des jedes (nicht aktiven) Links (JavaScript, CSS, target, ...)
	*	@return (bool)									Gibt false zurueck, wenn $link_more keinen gueltigen Wert hat
	*/
	function set_Link_More($link_more='') {
		if (is_string($link_more)) {
			$link_more=' '.trim($link_more);
			$this->link_more=$link_more;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt Text fuer Links Zurueck/Weiter
	*
	*	@access public
	*	@param (string) $link_next_text					Text des Links Weiter
	*	@param (string) $link_prev_text					Text des Links Zurueck
	*	@return (bool)									Gibt false zurueck, wenn $link_next_text oder $link_prev_text keinen gueltigen Wert hat
	*/
	function set_Link_Next_Prev_Text($link_next_text='Weiter', $link_prev_text='Zur&uuml;ck') {
		if (is_string($link_next_text) &&
			is_string($link_prev_text)) {
			$this->link_next_text=$link_next_text;
			$this->link_prev_text=$link_prev_text;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt erweiterte Einstellungen fuer Links Zurueck/Weiter
	*
	*	@access public
	*	@param (string) $link_next_prev_more			Erweitere Einstellungen Links Zurueck/Weiter (JavaScript, CSS, target, ...)
	*	@return (bool)									Gibt false zurueck, wenn $link_next_prev_more keinen gueltigen Wert hat
	*/
	function set_Link_Next_Prev_More($link_next_prev_more='') {
		if (is_string($link_next_prev_more)) {
			$link_next_prev_more=' '.trim($link_next_prev_more);
			$this->link_next_prev_more=$link_next_prev_more;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt Text fuer Links Anfang/Ende
	*
	*	@access public
	*	@param (string) $link_first_text				Text des Links Anfang
	*	@param (string) $link_last_text					Text des Links Ende
	*	@return (bool)									Gibt false zurueck, wenn $link_first_text oder $link_last_text keinen gueltigen Wert hat
	*/
	function set_Link_First_Last_Text($link_first_text='Anfang', $link_last_text='Ende') {
		if (is_string($link_first_text) &&
			is_string($link_last_text)) {
			$this->link_first_text=$link_first_text;
			$this->link_last_text=$link_last_text;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt erweiterte Einstellungen fuer Links Anfang/Ende
	*
	*	@access public
	*	@param (string) $link_first_last_more			Erweitere Einstellungen Links Anfang/Ende (JavaScript, CSS, target, ...)
	*	@return (bool)									Gibt false zurueck, wenn $link_first_last_more keinen gueltigen Wert hat
	*/
	function set_Link_First_Last_More($link_first_last_more='') {
		if (is_string($link_first_last_more)) {
			$link_first_last_more=' '.trim($link_first_last_more);
			$this->link_first_last_more=$link_first_last_more;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt den Wert, wie viele Links gezeigt werden sollen
	*
	*	@access public
	*	@param (int) $show_count						Gibt Zahl der Links an, die nebeneinander gezeigt werden (ungerade Zahlen sind idealer)
	*	@return (bool)									Gibt false zurueck, wenn $show_count keinen gueltigen Wert hat
	*/
	function set_Show_Count($show_count=3) {
		if (is_numeric($show_count) &&
			$show_count>=3) {
			$this->show_count=ceil($show_count);
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt den Wert, um wie viele Seiten bei Weiter/Zurueck gesprungen werden soll
	*
	*	@access public
	*	@param (bool) $steps_next_prev					Gibt Zahl der Seiten an, um die bei Weiter/Zurueck gesprungen werden soll
	*	@return (bool)									Gibt false zurueck, wenn $steps_next_prev keinen gueltigen Wert hat
	*/
	function set_Steps_Next_Prev($steps_next_prev=null) {
		if (is_numeric($steps_next_prev) &&
			$steps_next_prev>=1) {
			$this->steps_next_prev=round($steps_next_prev);
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt den Wert, ob alle Links auf einmal gezeigt werden sollen
	*
	*	@access public
	*	@param (bool) $show_continuous					Wenn true, dann werden alle Links auf einmal gezeigt
	*	@return (bool)									Gibt false zurueck, wenn $show_outer keinen gueltigen Wert hat
	*/
	function set_Show_Continuous($show_continuous=false) {
		if (is_bool($show_continuous)) {
			$this->show_continuous=$show_continuous;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt den Wert, ob aeussere Links der Seiten gezeigt werden sollen
	*
	*	@access public
	*	@param (bool) $show_outer						Wenn true, dann werden aeusseren Links der Seiten angezeigt (siehe 'Alle moeglichen Varianten')
	*	@return (bool)									Gibt false zurueck, wenn $show_outer keinen gueltigen Wert hat
	*/
	function set_Show_Outer($show_outer=true) {
		if (is_bool($show_outer)) {
			$this->show_outer=$show_outer;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt den Wert, ob Link der aktuellen Seite gezeigt werden soll
	*
	*	@access public
	*	@param (bool) $show_active_link					Wenn true, dann wird der Link der aktuellen Seite angezeigt
	*	@return (bool)									Gibt false zurueck, wenn $show_active_link keinen gueltigen Wert hat
	*/
	function set_Show_Active_Link($show_active_link=true) {
		if (is_bool($show_active_link)) {
			$this->show_active_link=$show_active_link;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt den Wert, ob Links fuer Zurueck/Weiter gezeigt werden sollen
	*
	*	@access public
	*	@param (bool) $show_next_prev					Wenn true, dann werden Links fuer Zurueck/Weiter angezeigt
	*	@return (bool)									Gibt false zurueck, wenn $show_next_prev keinen gueltigen Wert hat
	*/
	function set_Show_Next_Prev($show_next_prev=true) {
		if (is_bool($show_next_prev)) {
			$this->show_next_prev=$show_next_prev;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt den Wert, ob Links fuer Anfang/Ende gezeigt werden sollen
	*
	*	@access public
	*	@param (bool) $show_first_last					Wenn true, dann werden Links fuer Anfang/Ende angezeigt
	*	@return (bool)									Gibt false zurueck, wenn $show_first_last keinen gueltigen Wert hat
	*/
	function set_Show_First_Last($show_first_last=true) {
		if (is_bool($show_first_last)) {
			$this->show_first_last=$show_first_last;
			return true;
		}
		else {
			return false;
		}
	}


	/** Setzt den Wert, ob ein einzelner Link gezeigt werden sollen
	*
	*	@access public
	*	@param (bool) $show_single_link					Wenn true, wird auch bei nur einer Seite ein Link zurueckgegeben, sonst nichts
	*	@return (bool)									Gibt false zurueck, wenn $show_single_link keinen gueltigen Wert hat
	*/
	function set_Show_Single_Link($show_single_link=false) {
		if (is_bool($show_single_link)) {
			$this->show_single_link=$show_single_link;
			return true;
		}
		else {
			return false;
		}
	}


	/** Gibt Zahl zu zeigender Ergebnisse pro Seite zurueck
	*
	*	@access public
	*	@return (int)									Zahl zu zeigender Ergebnisse pro Seite
	*/
	function get_Epp() {
		return $this->epp;
	}


	/** Gibt (eventuell korrigierte) Zahl der aktuellen Seite zurueck
	*
	*	@access public
	*	@return (int)									(eventuell korrigierte) Zahl der aktuellen Seite
	*/
	function get_Active_Page() {
		return $this->active_page;
	}


	/** Zeigt den Wert aller Variablen an
	*
	*	@access public
	*/
	function dump() {
		$width=30;
		$vars=array(
			'active_page',
			'delimiter1',
			'delimiter2',
			'delimiter3',
			'delimiter4',
			'entries',
			'epp',
			'link_active_bracket_left',
			'link_active_bracket_right',
			'link_active_more',
			'link_active_text',
			'link_bracket_left',
			'link_bracket_right',
			'link_count',
			'link_count_surround',
			'link_first_last_more',
			'link_first_text',
			'link_href',
			'link_last_text',
			'link_more',
			'link_next_prev_more',
			'link_next_text',
			'link_prev_text',
			'link_text',
			'page_first',
			'page_last',
			'page_next',
			'page_prev',
			'show_active_link',
			'show_continuous',
			'show_count',
			'show_first_last',
			'show_next_prev',
			'show_outer',
			'show_single_link',
			'steps_next_prev');

		echo "<pre>\n";

		for ($i=0; $i<count($vars); $i++) {
			$temp=$this->$vars[$i];

			if (is_bool($temp)) {
				$temp = $temp ? 'true' : 'false';
			}
			echo '$'.str_pad($vars[$i], $width, ' ', STR_PAD_RIGHT)." = $temp\n";
		}

		if (is_array($this->links)) {
			echo '$links = ';
				print_r($this->links);
			echo '$links = Array'."\n(\n";
				for ($i=0; $i<count($this->links); $i++) {
					echo "    [$i] => ".htmlentities($this->links[$i])."\n";
				}
			echo ")\n";
		}
		else {
			echo '$'.str_pad('links', $width, ' ', STR_PAD_RIGHT)." = $this->links\n";
			echo '$'.str_pad('links', $width, ' ', STR_PAD_RIGHT).' = '.htmlentities(str_replace('<a href', "\n	<a href", $this->links))."\n";
		}

		echo "</pre>\n";
	}


	// Wer hier Werte setzt, der sollte sicher sein, dass sie richtig sind, geprueft werden sie nicht!
	// Also lieber die dafuer vorgesehenen Methoden nutzen.

	//////////////////////////////////////////////////
	// Erforderliche Variablen
	//////////////////////////////////////////////////
	/** Zahl der aktuellen Seite (Seite 1 hat Wert 0)
	*
	*	@access private
	*	@var (int)
	*/
	var $active_page				= 0;

	/** Anzahl aller Eintraege
	*
	*	@access private
	*	@var (int)
	*/
	var $entries					= 0;

	/** Eintraege, die pro Seite gezeigt werden sollen
	*
	*	@access private
	*	@var (int)
	*/
	var $epp						= 12;

	/** URI zur Datei, plus Variablen, fuer Links
	*
	*	@access private
	*	@var (string)
	*/
	var $link_href					= 'edit_shop_revenueTop.php?ViewYear=2005&page=';

	//////////////////////////////////////////////////
	// Optionale Variablen
	//////////////////////////////////////////////////
	/** Trennzeichen, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $delimiter1					= ' - ';

	/**
	*
	*	@access private
	*	@var (string)
	*/
	var $delimiter2					= ' - ';

	/** Trennzeichen, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $delimiter3					= '  ';

	/** Trennzeichen, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $delimiter4					= ' ... ';

	/** Text vor aktivem Link, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_active_text			= '';

	/** Zeichen vor aktivem Link, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_active_bracket_left	= '[';

	/** Zeichen hinter aktivem Link, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_active_bracket_right	= ']';

	/** Zusaetzliche Angaben zum aktiven Link, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_active_more			= '';

	/** Zeichen vor nicht-aktiven Links, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_text					= '';

	/** Zeichen vor nicht-aktiven Links, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_bracket_left			= '';

	/** Zeichen hinter nicht-aktiven Links, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_bracket_right			= '';

	/** Zusaetzliche Angaben zu nicht-aktiven Links, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_more					= '';

	/** Text fuer 'Weiter' (naechste Seite), siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_next_text				= 'Vorwärts';

	/** Text fuer 'Zurueck' (vorherige Seite), siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_prev_text				= 'Zurück';

	/** Zusaetzliche Angaben zu Links 'Weiter' und 'Zurueck', siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_first_last_more		= '';

	/** Text fuer 'Anfang' (erste Seite), siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	//var $link_first_text			= '<img src="/webEdition/we/include/we_modules/shop/images/shopCardB.gif" border="0">';
	var $link_first_text			= 'Start';
	/** Text fuer 'Ende' (letzte Seite), siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_last_text				= 'Ende';

	/** Zusaetzliche Angaben zu Links 'Anfang' und 'Ende', siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (string)
	*/
	var $link_next_prev_more		= '';

	/** Anzahl Links, die nebeneinander gezeigt werden, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (int)
	*/
	var $show_count					= 3;

	/** Alle Links zeigen ja/nein, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (bool)
	*/
	var $show_continuous			= false;

	/** Aeussere Links zeigen ja/nein, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (bool)
	*/
	var $show_outer					= true;

	/** 'Weiter' und 'Zurueck' zeigen ja/nein, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (bool)
	*/
	var $show_next_prev				= true;

	/** 'Anfang' und 'Ende' zeigen ja/nein, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (bool)
	*/
	var $show_first_last			= true;

	/** Link der aktuellen Seite zeigen ja/nein, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (bool)
	*/
	var $show_active_link			= true;

	/** Wenn nur eine Seite, Link zeigen ja/nein, siehe 'Variablen fuer Links'
	*
	*	@access private
	*	@var (bool)
	*/
	var $show_single_link			= false;

	/** Um wie viele Seiten Weiter/Zurueck springen soll
	*
	*	@access private
	*	@var (bool)
	*/
	var $steps_next_prev			= 1;


	//////////////////////////////////////////////////
	// Voll und ganz interne Variablen
	//////////////////////////////////////////////////
	/** Anzahl aller Links
	*
	*	@access private
	*	@var (int)
	*/
	var $link_count					= 0;

	/** Anzahl der Links, die den aktuellen umgeben
	*
	*	@access private
	*	@var (int)
	*/
	var $link_count_surround		= 0;

	/** Seitenzahl fuer vorherige Seite
	*
	*	@access private
	*	@var (int)
	*/
	var $page_prev					= 0;

	/** Seitenzahl fuer naechste Seite
	*
	*	@access private
	*	@var (int)
	*/
	var $page_next					= 0;

	/** Seitenzahl fuer erste Seite
	*
	*	@access private
	*	@var (int)
	*/
	var $page_first					= 0;

	/** Seitenzahl fuer letzte Seite
	*
	*	@access private
	*	@var (int)
	*/
	var $page_last					= 0;

	/** Array aller Links, String mit Links bei Uebergabe
	*
	*	@access private
	*	@var (mixed)
	*/
	var $links						= array();
}



?>