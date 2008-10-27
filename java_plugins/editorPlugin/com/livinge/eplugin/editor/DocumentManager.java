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

package com.livinge.eplugin.editor;

import java.util.Enumeration;
import java.util.Hashtable;
import java.util.Vector;

public class DocumentManager {

	protected static Hashtable Documents = new Hashtable(); 
	protected static int Current = 0;
	protected static String Last = null;
	
	protected static Vector Keys = null;
	
	private DocumentManager() {
		Documents = new Hashtable();
	}
	
	private static class SingletonHolder {
	    private static DocumentManager instance = new DocumentManager();
	} 

	public static DocumentManager getInstance() {
	    return SingletonHolder.instance;
	}
	
	public static void addDocument(EPDocument document) {
		
		Documents.put(document.getTransaction(), document);
		Last = document.getTransaction();
		generateKeys();
	}
	
	protected static void generateKeys() {
		Keys = new Vector();
		Enumeration en = Documents.keys();
		while(en.hasMoreElements()) {
			String s = (String)en.nextElement();			
			Keys.add(s);
		}
	}
	
	public static void removeDocument(String key) {
		Documents.remove(key);
		generateKeys();
	}
	
	public static EPDocument getLast() {
		return getDocument(Last);
	}
	
	public static EPDocument getDocument(String key) {
		return (EPDocument) Documents.get(key);
	}
	
	public static EPDocument getCurrent() {
		return (EPDocument) Documents.get(Keys.get(Current));
	}
	
	public static boolean hasNext() {
		return (Current<Keys.size());

	}

	public static EPDocument next() {
		
		if(hasNext()) {
			int curr = Current;
			Current++;
			return (EPDocument) Documents.get(Keys.get(curr));
		} else {
			return null;
		}

	}
	
	public static void reset() {
		Current = 0;
	}
	
	
	public void remove() {
		
	}
	
	public static int getCount() {
		return Documents.size();
	}
	
	public static boolean hasDocument(String trans) {
		return Documents.containsKey(trans);
	}
	
	
}
