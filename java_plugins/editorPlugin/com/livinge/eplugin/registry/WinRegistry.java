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

package com.livinge.eplugin.registry;

import java.util.Iterator;
import java.util.StringTokenizer;
import java.util.Vector;

import com.livinge.eplugin.util.CmdProxy;

public class WinRegistry implements Registry {
    
	private final String REGQUERY_UTIL = "reg query "; 
	private final String REGSTR_TOKEN = "REG_SZ"; 
	  
	private Vector OpenWithList = new Vector();
	  
	  
	public void addNewApp(String app) {
		
		if(OpenWithList.indexOf(app)==-1) {
			
			OpenWithList.add(app);
			
		}
		
	}
	
	
	public Vector getAppList(String ext) {
		
		getOpenWithListForExtension(ext);
		getOpenWithListForType(ext);
		getOpenWithListForUser(ext);
		
		return findApplications(OpenWithList);
		
	}
	
	
	 public String parseShellCommands(String content) {
		  
		  StringTokenizer st = new StringTokenizer(content,"\n");
		  
		  String ss;
		  
		  while (st.hasMoreTokens()) {
			  
			  ss = st.nextToken();
		    
			  
		      if ((ss.indexOf("REG_EXPAND_SZ") != -1) || ( ss.indexOf("REG_SZ") != -1)) { 
		    	  
		    	  ss = ss.replaceAll("<NO NAME>\tREG_EXPAND_SZ\t", "").trim();
		    	  
		    	  ss = ss.replaceAll("<NO NAME>\tREG_SZ\t", "").trim();
		    	  
		    	  return ss;
				  
		      }
		      
		  }
		  
		  return "";
		  
	  }
	
	
	
	public String getShellCommands(String app,String key) {
			
		String query = new String("reg query \"HKCR\\Applications\\"+ app +"\\shell\\"+key+"\\command\"");
		
		String result = CmdProxy.executeCmd(query);
		
		if(result!=null && result.trim().length()>0) {
			
			result = parseShellCommands(result);
			 
			String result2;
			
			 if(result!=null && result.trim().length()>0) {
		    	  
				 result = result.replaceAll("%[0-9]+","");
				 result = result.replaceAll("\"","").trim();
				 
				 String cmd = "cmd /C echo ";
				 if( System.getProperty("os.name" ).equals( "Windows 95") ){
					 cmd = "command /C echo ";
		         }
				 
		    	 result2 = CmdProxy.executeCmd(cmd + result);
		    	 
		    	 result2 = result2.replaceAll("%(.)*","");
		    	 
		    	 result2 = result2.trim();
		    	 
		    	 
		    	 if(result2.length()>0) {
		    		 return result2; 
		    		  
		    	 }
		    	  
			 }
		}
		 
		return "";
		
	}
	
	public Vector findApplications(Vector appList) {

		Vector newList = new Vector();
		String s = "";
		String result = "";
		
		for(Iterator i = appList.iterator();i.hasNext();) {
			
			s = i.next().toString().trim();

			result = getShellCommands(s,"edit");
			if(result.length()>0) {
				newList.add(result);
			}
			
		}
		
		return newList;
	
	}
	
	public void parseOpenWithList(String content) {
		  
		  StringTokenizer st = new StringTokenizer(content,"\n");
		  
		  boolean inList = false;
		
		  String next = "";
		  
		  while (st.hasMoreTokens()) {
			  String ss = st.nextToken();
					  
			  StringTokenizer st1 = new StringTokenizer(ss,"\\");
		  
			  inList = false; 
		 
			  while (st1.hasMoreTokens()) {
				  next = st1.nextToken();
				  
				  if(inList) {
					  addNewApp(new String(next));
				  }
				  
				  if(next.toString().equals("OpenWithList")) {
					  inList = true;
				  } else {
					  inList = false;
				  }
	
			  }	
		  }
		  
		  
	  }
	
	
	  public String parsePerceivedType(String content) {
		  
		  StringTokenizer st = new StringTokenizer(content,"\n");
		  
		  String ss;
		  
		  while (st.hasMoreTokens()) {
			  
			  ss = st.nextToken();
		  
			  int p = ss.indexOf("PerceivedType");

		      if (p != -1) { 
		    	  
		    	  return ss.replaceAll("PerceivedType\t"+REGSTR_TOKEN, "").trim();		  
				  
		      }
		      
		  }
		  
		  return null;
		  
	  }
	  
	  
	  public void getOpenWithListForType(String extension) {
		  
		  String query = REGQUERY_UTIL + 
		  "\"HKCR\\."+ extension +"\"";
		  
		  try {
			  
			  String result = CmdProxy.executeCmd(query);  
		      
		      if(result!=null) {
		    	  
		    	  String type = parsePerceivedType(result);
		    	  
		    	  if(type!=null) {
		    		  getOpenWithListType(type);
		    		  
		    	  } 
		    	  
		      }	      
		      
		      //return result;
		     
		      
		    } 
		    catch (Exception e) { 
		      //return null; 
		    }
		  
	  }
	  
	  
	  public final void getOpenWithListForExtension(String extension) {
		  
		  String query = REGQUERY_UTIL + 
		  "\"HKCR\\."+ extension +"\\OpenWithList\"";
		  
		  try {
			  
		      parseOpenWithList(CmdProxy.executeCmd(query));
		      
		    } 
		    catch (Exception e) { 
		      
		    }
		  
	  }
	  
	  
	  public void getOpenWithListType(String type) { 
		  
		  	String query = REGQUERY_UTIL + 
		  	"\"HKCR\\SystemFileAssociations\\"+type+"\\OpenWithList\"";
		  
		    try { 
		      
		      parseOpenWithList(CmdProxy.executeCmd(query));
		   
		    } 
		    catch (Exception e) { 
		      //return null; 
		    }
		    
	  }	  
	  
	  
	  public final void getOpenWithListForUser(String extension) {
		  
		  String query = REGQUERY_UTIL + 
		  "\"HKCR\\Software\\Microsoft\\Windows\\CurrentVersion\\Explorer\\FileExts\\."+ extension +"\\OpenWithList\"";

		  try {
			  
		      String result = CmdProxy.executeCmd(query); 

		      parseOpenWithList(result);
		      
		    } 
		    catch (Exception e) { 
		      
		    }
		  
	  }
	  
	  public WinRegistry() {
		  	      
		  
		  
	  }
    
}
