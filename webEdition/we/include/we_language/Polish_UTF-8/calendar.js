// ** I18N
// Calendar PL language
// Author: Artur Filipiak, <imagen@poczta.fm>
// January, 2004
// Encoding: UTF-8
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names
Calendar._DN = new Array("Niedziela", "PoniedziaĹek", "Wtorek", "Ĺroda", "Czwartek", "PiÄtek", "Sobota", "Niedziela");

Calendar._SDN = new Array("N", "Pn", "Wt", "Ĺr", "Cz", "Pt", "So", "N");
// First day of the week. "0" means display Sunday first, "1" means display
// Monday first, etc.
Calendar._FD = 0;

Calendar._MN = new Array("StyczeĹ", "Luty", "Marzec", "KwiecieĹ", "Maj", "Czerwiec", "Lipiec", "SierpieĹ", "WrzesieĹ", "PaĹşdziernik", "Listopad", "GrudzieĹ");

Calendar._SMN = new Array("Sty", "Lut", "Mar", "Kwi", "Maj", "Cze", "Lip", "Sie", "Wrz", "PaĹş", "Lis", "Gru");

// tooltips
Calendar._TT = {};
Calendar._TT["INFO"] = "O kalendarzu";

Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) dynarch.com 2002-2005 / Author: Mihai Bazon\n" + // don't translate this this ;-)
"For latest version visit: http://www.dynarch.com/projects/calendar/\n" +
"Distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"WybĂłr daty:\n" +
"- aby wybraÄ rok uĹźyj przyciskĂłw \xab, \xbb\n" +
"- aby wybraÄ miesiÄc uĹźyj przyciskĂłw " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + "\n" +
"- aby przyspieszyÄ wybĂłr przytrzymaj wciĹniÄty przycisk myszy nad ww. przyciskami.";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"WybĂłr czasu:\n" +
"- aby zwiÄkszyÄ wartoĹÄ kliknij na dowolnym elemencie selekcji czasu\n" +
"- aby zmniejszyÄ wartoĹÄ uĹźyj dodatkowo klawisza Shift\n" +
"- moĹźesz rĂłwnieĹź poruszaÄ myszkÄ w lewo i prawo wraz z wciĹniÄtym lewym klawiszem.";

Calendar._TT["TOGGLE"] = "Select first day of week";
Calendar._TT["PREV_YEAR"] = "Poprz. rok (przytrzymaj dla menu)";
Calendar._TT["PREV_MONTH"] = "Poprz. miesiÄc (przytrzymaj dla menu)";
Calendar._TT["GO_TODAY"] = "PokaĹź dziĹ";
Calendar._TT["NEXT_MONTH"] = "Nast. miesiÄc (przytrzymaj dla menu)";
Calendar._TT["NEXT_YEAR"] = "Nast. rok (przytrzymaj dla menu)";
Calendar._TT["SEL_DATE"] = "Wybierz datÄ";
Calendar._TT["DRAG_TO_MOVE"] = "PrzesuĹ okienko";
Calendar._TT["PART_TODAY"] = " (dziĹ)";

Calendar._TT["DAY_FIRST"] = "Display %s first";
Calendar._TT["WEEKEND"] = "0,6";

Calendar._TT["MON_FIRST"] = "PokaĹź PoniedziaĹek jako pierwszy";
Calendar._TT["SUN_FIRST"] = "PokaĹź NiedzielÄ jako pierwszÄ";

Calendar._TT["CLOSE"] = "Zamknij";
Calendar._TT["TODAY"] = "DziĹ";
Calendar._TT["TIME_PART"] = "(Shift-)klik | drag, aby zmieniÄ wartoĹÄ";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "%Y.%m.%d";
Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Calendar._TT["WK"] = "wk";