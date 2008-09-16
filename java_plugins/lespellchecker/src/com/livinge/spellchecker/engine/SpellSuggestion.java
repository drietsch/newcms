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