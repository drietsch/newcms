package com.livinge.spellchecker.engine;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.util.Hashtable;
import java.util.Iterator;
import java.util.Vector;

public class BaseUtility {

	public static Hashtable createBase(String dict) throws IllegalStateException {
		
		Hashtable map = new Hashtable();
		
		String sep = System.getProperty("file.separator");
		
		String localDir = System.getProperty("user.home")+sep+".livinge"+sep+"spellchecker"+sep;
		
		map.put("localDir",localDir);
		map.put("localDictStorage",localDir+"dict"+sep);
		map.put("localDictBase",localDir+"dict"+sep+dict+sep);
		map.put("localWords",localDir+"dict"+sep+dict+sep+"words"+sep);
		map.put("localWordsDb",localDir+"dict"+sep+dict+sep+"db"+sep);
		
		Vector folders = new Vector(map.values()); 
		
		for(Iterator i = folders.iterator();i.hasNext();) {
			File f = new File((String)i.next());
		    if (!f.exists()) { 
			    if(!f.mkdirs()){			    	
			    	throw new java.lang.IllegalStateException("Local storage cannot be created.");
			    }
		    }
		}
		
		return map;

	}
	
	public static void createBaseFiles(Hashtable map) {
		
		 //create necessary files if they don't exist
	    Vector f = new Vector();
	    f.add((map.get("localWordsDb").toString()) + "words.db");
	    f.add((map.get("localWordsDb").toString()) + "words.idx");
	    f.add((map.get("localWordsDb").toString()) + "contents");
	    for(Iterator i = f.iterator();i.hasNext();) {
	    	File check = new File((i.next().toString()));
	    	if(!check.exists()) {
	    		try {
	    			check.createNewFile();
	    		} catch (IOException ex) {
		    		ex.printStackTrace();
	    		}
	    	}
	    }
		
	}
	
	public static String getDefaultEncoding() {		
		return System.getProperty("file.encoding").replaceFirst("Cp", "windows-");		
	    //OutputStreamWriter out = new OutputStreamWriter(new ByteArrayOutputStream());	    
	    //return out.getEncoding();
	}
	
	
}
