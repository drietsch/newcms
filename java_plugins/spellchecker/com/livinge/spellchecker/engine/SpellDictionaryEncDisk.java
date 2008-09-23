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

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Vector;

import com.swabunga.spell.engine.SpellDictionaryDisk;
import com.swabunga.spell.engine.Word;

public class SpellDictionaryEncDisk extends SpellDictionaryDisk{

	protected List possible;
	protected String defEncoding;
	
	public SpellDictionaryEncDisk(File base, File phonetic, boolean block,String enc) throws FileNotFoundException, IOException {
		super(base,phonetic,block,enc);
		defEncoding = enc;
	      loadIndex();
	      ready = true;
	}
	
	public void buildDict(boolean block) {
		try {
			if(block) {
				buildNewDictionaryDatabase();
			} else {
				Thread t = new Thread() {
		        public void run() {
		            try {
		            	buildNewDictionaryDatabase();
		            } catch (Exception e) {
		              e.printStackTrace();
		            }
		          }
		        };
		        t.start();
			}
		} catch(IOException ex) {
		   	ex.printStackTrace();
		}
	}
	
	protected File buildSortedFile() throws FileNotFoundException, IOException {

	    List w = new ArrayList();

	    File[] wordFiles = words.listFiles();
	    for (int i = 0; i < wordFiles.length; i++) {
	      BufferedReader r = new BufferedReader(new InputStreamReader(new FileInputStream(wordFiles[i]),defEncoding));
	      String word;
	      while ((word = r.readLine()) != null) {
	        if (!word.equals("")) {
	          w.add(word.trim());
	        }
	      }
	      r.close();
	    }

	    Collections.sort(w);

	    File file = File.createTempFile("jazzy", "sorted");	    
	    BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(new FileOutputStream(file), defEncoding));
	    
	    String prev = null;
	    for (int i = 0; i < w.size(); i++) {
	      String word = (String) w.get(i);
	      if (prev == null || !prev.equals(word)) {
	        writer.write(word);
	        writer.newLine();
	      }
	      prev = word;
	    }
	    writer.close();

	    return file;
	}

	protected void buildCodeDb(File sortedWords) throws FileNotFoundException, IOException {
	    List codeList = new ArrayList();

	    BufferedReader reader = new BufferedReader(new InputStreamReader(new FileInputStream(sortedWords),defEncoding));
	    String word;
	    while ((word = reader.readLine()) != null) {
	      codeList.add(new CodeWord(this.getCode(word), word));
	    }
	    reader.close();

	    Collections.sort(codeList);

	    List index = new ArrayList();
	    
	    BufferedWriter out = new BufferedWriter(new OutputStreamWriter(new FileOutputStream(new File(db, FILE_DB)), defEncoding));
	    
	    String currentCode = null;
	    int currentPosition = 0;
	    int currentLength = 0;
	    for (int i = 0; i < codeList.size(); i++) {
	      CodeWord cw = (CodeWord) codeList.get(i);
	      String thisCode = cw.getCode();

	      thisCode = getIndexCode(thisCode, codeList);
	      String toWrite = cw.getCode() + "," + cw.getWord() + "\n";
	      byte[] bytes = toWrite.getBytes();

	      if (currentCode == null) currentCode = thisCode;
	      if (!currentCode.equals(thisCode)) {
	        index.add(new Object[]{currentCode, new int[]{currentPosition, currentLength}});
	        currentPosition += currentLength;
	        currentLength = bytes.length;
	        currentCode = thisCode;
	      } else {
	        currentLength += bytes.length;
	      }
	      out.write(new String(bytes));
	    }
	    out.close();

	    if (currentCode != null && currentPosition != 0 && currentLength != 0)
	      index.add(new Object[]{currentCode, new int[]{currentPosition, currentLength}});

	    BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(new FileOutputStream(new File(db, FILE_INDEX)), defEncoding));
	    
	    for (int i = 0; i < index.size(); i++) {
	      Object[] o = (Object[]) index.get(i);
	      writer.write(o[0].toString());
	      writer.write(",");
	      writer.write(String.valueOf(((int[]) o[1])[0]));
	      writer.write(",");
	      writer.write(String.valueOf(((int[]) o[1])[1]));
	      writer.newLine();
	    }
	    writer.close();
	}

	protected void loadIndex() throws IOException {
	    index = new HashMap();
	    File idx = new File(db, FILE_INDEX);	    
	    BufferedReader reader = new BufferedReader(new InputStreamReader(new FileInputStream(idx),defEncoding));
	    String line;
	    while ((line = reader.readLine()) != null) {
	      String[] fields = split(line, ",");
	      index.put(fields[0], new int[]{Integer.parseInt(fields[1]), Integer.parseInt(fields[2])});
	    }
	    reader.close();
	}
	
	public List getWordsList(String code) {			
		    Vector words = new Vector();
		    int[] posLen = getStartPosAndLen(code);
		    	    
		    if (posLen != null) {
		      try {
		        BufferedReader input = new BufferedReader(new InputStreamReader(new FileInputStream(new File(db, FILE_DB)),defEncoding));
		        input.skip(posLen[0]);
		        char[] bytes = new char[posLen[1]];		        		        
		        input.read(bytes, 0, posLen[1]);
		        input.close();
		        String data = new String(bytes);
		        String[] lines = split(data, "\n");
		        for (int i = 0; i < lines.length; i++) {
		          String[] s = split(lines[i], ",");		          
		          if (s[0].equals(code)) words.addElement(s[1]);
		        }
		      } catch (Exception e) {
		        e.printStackTrace();
		      }
		    }

		    return words;
	}
	
	 
	public boolean isCorrect(String word) {
		
		possible = getWordsList(getCode(word));	
	    if (possible.contains(word)) {
	      return true;
	    }
	    else if (possible.contains(word.toLowerCase())) {
	      return true;
	    }
	    return false;
	}	
	  
	public List getSuggestions(String word, int threshold, int[][] matrix) {
		Vector suggestions = new Vector();
		Iterator iterator = possible.iterator();
	    while(iterator.hasNext()) {	    
	    	suggestions.add(new Word(iterator.next().toString(),1));	    
	    }
	    return suggestions;

	}

}
