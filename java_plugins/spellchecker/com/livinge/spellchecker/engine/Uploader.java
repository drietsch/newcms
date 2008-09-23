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

import java.io.File;
import java.io.FileInputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.URL;
import java.net.URLConnection;
import java.util.Enumeration;
import java.util.Hashtable;

public class Uploader {

	
	protected String FilePath;
	protected Hashtable RequestProperties;
	
	protected Hashtable Variables;
	protected Hashtable Files;
	
	protected String ContentBoundary = "boundary";
	
	public Uploader(){
			
		Variables = new Hashtable();
		Files = new Hashtable();
			
		RequestProperties = new Hashtable();
		RequestProperties.put("Content-Type","multipart/form-data; boundary=" + ContentBoundary);
		RequestProperties.put("User-Agent","Mozilla/4.7 [en] (WinNT; U)");
		RequestProperties.put("Accept","image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, application/vnd.ms-excel, application/msword, application/vnd.ms-powerpoint, application/pdf, application/x-comet, */*");
		RequestProperties.put("Accept-Encoding","gzip, deflate");
		RequestProperties.put("Accept-Language","en");
		RequestProperties.put("Cache-Control","no-cache");
		
	}
	
	public void addVariable(String name, String content){
		Variables.put(name,content);
	}

	public void addFile(String name,String path) {
		Files.put(name, path);
	}

	public String upload(String UploadURL) {
		
		String out = "";
		FileInputStream fileInputStream = null;
		OutputStream output = null;
		InputStream input = null;
		
		try {

			URL postURL = new URL(UploadURL);
			URLConnection connection = postURL.openConnection();

			connection.setDoOutput(true); // turns it into a post
			
			String name;

			/*if(Files.size()>0) {
				RequestProperties.put("Content-Type","multipart/form-data; boundary=" + ContentBoundary);
			}*/
			
			for (Enumeration e = RequestProperties.keys(); e.hasMoreElements();) {
                 name = (String)e.nextElement();
                 connection.setRequestProperty(name,(String)RequestProperties.get(name));
			}
									
			output = connection.getOutputStream();
			
			String startStr = "--" + ContentBoundary + "\r\n";
			String endStr = "\r\n--" + ContentBoundary + "--\r\n";
			
			for (Enumeration e = Variables.keys(); e.hasMoreElements();) {
                name = (String)e.nextElement();
                output.write((startStr + "Content-Disposition: form-data; name=\"" + name + "\";\r\nContent-Type: text/plain\r\n\r\n").getBytes());
				output.write(((String)(String)Variables.get(name)).getBytes());
				output.write(endStr.getBytes());
			}
			
			int readByte = -1;
						
			for (Enumeration e = Files.keys(); e.hasMoreElements();) {
                
				name = (String)e.nextElement();
				
				output.write( ("--" + ContentBoundary + "\r\n" + "Content-Disposition: form-data; name=\""+name+"\"; filename=\"" + (String)Files.get(name) + "\"\r\nContent-Type: text/plain\r\n\r\n").getBytes());
				
				fileInputStream = new FileInputStream(new File(Files.get(name).toString()));
				
				byte[] fileBuffer = new byte[512];
				int totalByte = 0;
				readByte = fileInputStream.read(fileBuffer, 0, 512);
				while (readByte != -1) {
						totalByte += readByte;
						output.write(fileBuffer, 0, readByte);
						readByte = fileInputStream.read(fileBuffer, 0, 512);
				}
				//System.out.println("wrote " + totalByte);
				fileInputStream.close();
				fileInputStream = null;
				output.write( ("\r\n--" + ContentBoundary + "--\r\n").getBytes());
			
			}
			
			input = connection.getInputStream();
		
			byte[] buffer = new byte[512];
			readByte = input.read(buffer, 0, 512);
			
			while (readByte != -1) {					
					out += new String(buffer,0,readByte);
					readByte = input.read(buffer, 0, 512);
			}
			
			//System.out.print(out);
			
			input.close();
			input = null;
			output.close();
			output = null;
		}catch (Exception ex) {
			System.err.println("Exception: " + ex);
			ex.printStackTrace();
		}
		finally {
			if (fileInputStream != null){
					try {
						fileInputStream.close();
					}catch (Exception ex) {
					}
			}
			if (input != null){
				try {
					input.close();
				} catch (Exception ex) {
				}
			}
			if (output != null){
				try {
					output.close();
				} catch (Exception ex) {

				}
			}
		}
		return out;
		
	}
		
}
