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

package com.livinge.eplugin.util;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.ByteArrayOutputStream;
import java.io.DataOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.Writer;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.Iterator;
import java.util.List;
import java.util.Vector;
import java.util.zip.CRC32;
import java.util.zip.ZipEntry;
import java.util.zip.ZipInputStream;
import java.util.zip.ZipOutputStream;

public class CopyUtility {


	
	public static void copy(InputStream fis,String filename) throws IOException {
		try {
			int len;			
			int buffersize = 2048;
			byte[] buffer = new byte[buffersize];
			//BufferedOutputStream output = new BufferedOutputStream(new DataOutputStream(new FileOutputStream(new File(filename)))); 			
			DataOutputStream output = new DataOutputStream(new FileOutputStream(new File(filename)));
		    while ((len = fis.read(buffer)) > 0) {
		    	output.write(buffer,0,len);
		   }
		   output.close();
		}catch(Exception e){
			e.printStackTrace();
			throw new IOException();
		}
	}
		
	public static long copyPart(String input,String output,long offset,long size) throws IOException {
		
		long allBytesRead=0;
		try {
		
			FileInputStream fis = new FileInputStream(new File(input));

			fis.skip(offset);
			
			int buffersize = 8192;
			
			int bytesRead=0;
			
			if(buffersize>size) {
				buffersize = Integer.parseInt(Long.toString(size));
			}
			
			byte[] buffer = new byte[buffersize];
 						
			FileOutputStream fos = new FileOutputStream(new File(output));
			
		    while ((bytesRead = fis.read(buffer,0,buffersize)) != -1) {
		    	//System.out.println("bytesRead:" + bytesRead);
		    	if((allBytesRead+bytesRead)<size){
		    		fos.write(buffer,0,bytesRead);
		    		allBytesRead += bytesRead;
		    	} else {
		    		break;
		    	}
		   }

		   fos.close();
		   fis.close();
		   
		}catch(Exception e){
			e.printStackTrace();
			throw new IOException();
		}
		return allBytesRead;
	}
		
	protected String getDefaultEncoding() {
	    OutputStreamWriter out = new OutputStreamWriter(new ByteArrayOutputStream());	    
	    return out.getEncoding();
	}
	
	public static void copy(URL url,String filename)  throws IOException {
		try{			
			try{
				InputStream is = url.openStream();
				CopyUtility.copy(is,filename);
				
			}catch(IOException ix){
				ix.printStackTrace();
				throw new IOException();
				
			}
						 
		}catch(MalformedURLException ex){
			ex.printStackTrace();
			throw new IOException();
		}		
		
	}	
	
	
	public static Vector extract(ZipInputStream zipFile,String base)  throws IOException {
		Vector entries = new Vector();
		try {
			ZipEntry ze = zipFile.getNextEntry();
			while(ze != null ) {

				CopyUtility.copy(zipFile,base+ze.getName());
				entries.add(ze.getName());
				zipFile.closeEntry();
				ze = zipFile.getNextEntry();
			}
			zipFile.close();
			return entries;
			
		} catch (IOException e) {
			e.printStackTrace();
			throw new IOException();
		}		
		
	}
	
	
	public static void saveToFile(String filename,String text,boolean encoded,String charset) {
		
		try {
			if(encoded) {				 
				text = Base64Coder.decode(text);		
			}
						
			File f = new File(filename);
			if(!f.exists()) {
				f.createNewFile();
			}
			
			FileOutputStream os = new FileOutputStream(filename);
			Writer out = new BufferedWriter(new OutputStreamWriter(os, charset));
			out.write(text);		
		    out.close();
		} catch (Exception ex) {
			ex.printStackTrace();
		}
	}	  	
	
	public static void copyTextFile(File from, File to, String fromEnc,String toEnc,String cropFrom){
		try {
			
			//int len;
			//int buffersize = 2048;
			//char[] buffer = new char[buffersize];
			
	        BufferedReader input = new BufferedReader(new InputStreamReader(new FileInputStream(from),fromEnc));						
	        BufferedWriter out = new BufferedWriter(new OutputStreamWriter(new DataOutputStream(new FileOutputStream(to)), toEnc));
	        
	        
	        String s;
	        
		    while (( s = input.readLine()) != null) {

		    	if(cropFrom !=null) {
			    	int ind = s.indexOf(cropFrom); 
			    	if(ind>0){
			    		s = s.substring(0, ind);
			    	}
		    	}

		    	s += "\n";
		    	
		    	out.write(s);

		   }

		   input.close();
		   out.close();
		   
		}catch(Exception e){
			e.printStackTrace();
		}
		
	}
	
	public static void pack(File zipFile,List files) {
		try{
			ZipOutputStream zos = new ZipOutputStream(new FileOutputStream(zipFile));
			zos.setMethod(ZipOutputStream.DEFLATED);

			String f = "";
			for(Iterator i = files.iterator();i.hasNext();) {
				  f = i.next().toString();

				  File file = new File(f);

			      long crc = CopyUtility.getCRC(new File(f));
			      			      
			      int buffersize = 8192;
			      int n = buffersize;
			      byte [] buff = new byte [buffersize];
			      			      
			      ZipEntry entry = new ZipEntry(file.getName());
			      entry.setSize(file.length());
			      entry.setTime(file.lastModified());
			      entry.setCrc(crc);
			      zos.putNextEntry(entry);
			      
			      FileInputStream fis = new FileInputStream(file);
			      long sum = 0;
			      
			      while ((n = fis.read(buff,0,buffersize)) != -1) {

			        zos.write(buff, 0, n);
			        
			        sum += n;
			      }
			      
			      fis.close();
			      zos.closeEntry();
			      
				
			}
			zos.flush();
			zos.close();
			
		} catch (Exception fn) {
			fn.printStackTrace();
		}
			
		
	}
	
	public static long getCRC(File file){
		int n;
	    byte [] buff = new byte [1000];
		CRC32 crc32 = new CRC32();
		
		try {
		
		  FileInputStream fis = new FileInputStream(file);
	      while ((n = fis.read(buff)) > -1)
	      {
	        crc32.update(buff, 0, n);
	      }
	      fis.close();
	      
		} catch (Exception fn) {
			fn.printStackTrace();
		}	      
	      
	    return crc32.getValue();
		
	}
	
}
