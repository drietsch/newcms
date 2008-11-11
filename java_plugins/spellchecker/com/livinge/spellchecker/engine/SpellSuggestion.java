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
 * A copy is found in the textfile license.txt
 *
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

package com.livinge.spellchecker.engine;

import java.util.List;
import java.util.Iterator;

	public class SpellSuggestion {
	
		protected String  misspelledWord;
		protected int  misspelledOffset;
		protected List suggestions;
		
		public SpellSuggestion(String word,int offset,List suggestion) {
		
			misspelledWord = word;
			misspelledOffset = offset;
			suggestions  = suggestion;

		}
	
		public String getMisspelledWord() {
			return misspelledWord;
		}
	
		public int getMisspelledOffset() {
			return misspelledOffset;
		}
	
		public String getSuggestions() {
			String out = "";
			 for (Iterator i = suggestions.iterator(); i.hasNext();) {
			      com.swabunga.spell.engine.Word element = (com.swabunga.spell.engine.Word) i.next();
			      out += element.getWord() + "|";

			}
			return out;
		}
	}