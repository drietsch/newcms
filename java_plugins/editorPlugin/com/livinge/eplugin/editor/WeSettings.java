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


import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.URL;
import java.nio.charset.Charset;
import java.security.AccessController;
import java.util.Enumeration;
import java.util.Hashtable;
import java.util.Iterator;
import java.util.Properties;
import java.util.Vector;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;

import org.w3c.dom.Document;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.SAXException;

import com.livinge.eplugin.privileged.PrivilegedSave;
import com.livinge.eplugin.registry.MacRegistry;
import com.livinge.eplugin.registry.WinRegistry;


public class WeSettings{

	private String buildVersion="5.1_9";
	
	private String defRegistryCompanyDir="living-e";
	private String defRegistryProductDir="editorPlugin";
	
	private String defEditorFile="editor.xml";
	private String defSettingsFile="setting.xml";
	
	private String defCacheDir="cache";
	
	public String registryDir;
	private String editorFile;
	private String settingsFile;
	
	public String cacheDir;
	
	public String lastContentType = "";
	
	private Hashtable ParamList=new Hashtable();
	
	private Hashtable Settings=new Hashtable();
	
	//private Vector EditorList=new Vector();
	private Vector DefaultEditorList=new Vector();
	private Vector SystemEditorList=new Vector();
	
	
	private Vector ContentTypes = new Vector();
	private Vector ContentTypeIcons = new Vector();
	
	private URL HostUrl;
	
	private Properties PluginProperties;
	
	public String AppDir = new String("webEdition");
	
	public WeSettings(){

		/*System.out.println("file.separator = " + System.getProperty("file.separator"));
		System.out.println("line.separator (windows & unix platform) = \\n");
		System.out.println("line.separator (actual) = " + System.getProperty("line.separator"));
		System.out.println("path.separator = " + System.getProperty("path.separator"));
		System.out.println("java.class.version = " + System.getProperty("java.class.version"));
		System.out.println("java.vendor = " + System.getProperty("java.vendor"));
		System.out.println("java.vendor.url = " + System.getProperty("java.vendor.url"));
		System.out.println("java.version = " + System.getProperty("java.version"));
		System.out.println("os.arch = " + System.getProperty("os.arch"));
		System.out.println("os.name = " + System.getProperty("os.name"));
		System.out.println("os.version = " + System.getProperty("os.version"));

		System.out.println("Properties: (Applications only or Trusted Applets)");
		System.out.println("java.class.path = " + System.getProperty("java.class.path"));
		System.out.println("java.home = |" + System.getProperty("java.home"));
		System.out.println("user.dir = " + System.getProperty("user.dir"));
		System.out.println("user.home = " + System.getProperty("user.home"));
		System.out.println("user.name = " + System.getProperty("user.name"));*/
		
		//super();
		
		//System.out.println("os.name = " + System.getProperty("os.name"));
		
		// initialize content types
		
		ContentTypes.add("text/plain");
		ContentTypes.add("text/js");
		ContentTypes.add("text/css");
		ContentTypes.add("text/html");
		ContentTypes.add("text/xml");
		ContentTypes.add("text/webedition");
		ContentTypes.add("text/weTmpl");
		ContentTypes.add("image/*");
		ContentTypes.add("video/quicktime");
		ContentTypes.add("application/x-shockwave-flash");
		ContentTypes.add("application/*");

		ContentTypeIcons.add("link.gif"); //text/plain
		ContentTypeIcons.add("prog.gif"); //text/js
		ContentTypeIcons.add("prog.gif"); //text/css
		ContentTypeIcons.add("prog.gif"); //text/html
		ContentTypeIcons.add("link.gif"); //text/xml
		ContentTypeIcons.add("we_dokument.gif"); //text/webedition
		ContentTypeIcons.add("prog.gif"); //text/weTmpl
		ContentTypeIcons.add("image.gif"); //image/*
		ContentTypeIcons.add("film.gif"); //video/quicktime
		ContentTypeIcons.add("film.gif"); //application/x-shockwave-flash
		ContentTypeIcons.add("link.gif"); //application/*

		 Settings.put("askForEditor", "true");
		 
		 PluginProperties = new Properties();
		 try {
			 InputStream is = getClass().getResourceAsStream("eplugin.properties");
			 PluginProperties.load(is);
		} catch (IOException e) {
		} catch (NullPointerException e) {
		}
		
		String OS = System.getProperty("os.name").toLowerCase();
		
		String appDataPath = "";
		String sep = System.getProperty("file.separator");
		
		if(OS.matches("mac os x")) {
			appDataPath = System.getProperty("user.home")+ sep + "Library" + sep + "Application Support" + sep;
		} else if (OS.matches("windows(.)*")) {
			Process p = null;
			try {
				if (OS.indexOf("windows 9") > -1) {
					p = Runtime.getRuntime().exec("command.com /c echo %APPDATA%");
				} else {
					p = Runtime.getRuntime().exec("cmd.exe /c echo %APPDATA%");
				}
			} catch (IOException e) {
				e.printStackTrace();
			}
			BufferedReader br = new BufferedReader( new InputStreamReader( p.getInputStream() ) );
			
			try {
				appDataPath = br.readLine();
			} catch (IOException e) {
				e.printStackTrace();
			}
			if (appDataPath.length() == 0) {
				appDataPath=System.getProperty("user.home") + sep + "Application Data" + sep;
			} else {
				appDataPath = appDataPath + sep;
			}
			
			System.out.println(appDataPath);
			
		} else {
			System.out.println("Only Mac OSX and Windows are supported by the editor plugin!");
		}
		 
		registryDir=appDataPath+defRegistryCompanyDir+sep+defRegistryProductDir+sep;
		 
		 editorFile = registryDir+System.getProperty("file.separator")+defEditorFile;
		 settingsFile = registryDir+System.getProperty("file.separator")+defSettingsFile;
		 
		 loadSettings();
	}
	
	
	public void createCache() {
		
		String host = HostUrl.getHost();
		cacheDir=registryDir+defCacheDir+System.getProperty("file.separator")+host+System.getProperty("file.separator");
		 
		createDir(registryDir);
		
		createDir(cacheDir); 	
		
	}
	
	private boolean createDir(String dir){
		boolean exists = (new File(dir)).exists();
	    if (!exists) return (new File(dir)).mkdirs();
	    return false;
	}
	
	
	public void addEditor(WeEditor Editor,Vector List){
		
		boolean found = false;
		
		for(Iterator i = List.iterator();i.hasNext();) {
			
			WeEditor we = (WeEditor)i.next();
			if(Editor.Path.equals(we.Path)){
				found = true;
			}
		}
		
		if(!found) {
			List.add(Editor);
		}
	}
	
	
	public void addToDefaultEditors(WeEditor editor) {
		
		addEditor(editor,DefaultEditorList);
		
	}
	
	public void setParam(String name,String value){
		try{
			ParamList.put(name,value);
		}catch(NullPointerException e) {
			System.out.print("Missing param: " + name + "--" + value + "\n");
		}
		
	}
	
	public boolean isParam(String name){
		String val = (String)ParamList.get(name);
	     return (val != null);
	}	
	
	public String getParam(String name){
		return (String) ParamList.get(name);		
	}	
		
	
	/*public void saveSettings2(){
		
		
	    registryFile = registryDir+System.getProperty("file.separator")+defRegistryFile; 
	    WeEditor editor;
	    

		try{
			
			java.beans.XMLEncoder xmlEnc = new java.beans.XMLEncoder(
                new BufferedOutputStream(new FileOutputStream(registryFile)));
				for(int k=0;k<EditorList.size();k++){
					editor=(WeEditor) EditorList.elementAt(k);
					xmlEnc.writeObject(editor);	
				}				
				xmlEnc.close();			
		} catch (IOException e) {
			System.out.println(e);
		}
	    
		
	}	
	
	public void loadSettings2(){
		
	    registryFile = registryDir+System.getProperty("file.separator")+defRegistryFile;
		try{
			java.beans.XMLDecoder d = new java.beans.XMLDecoder(new BufferedInputStream(new FileInputStream(registryFile)));
			EditorList= (Vector) d.readObject();
			d.close();    
		} catch (IOException e) {
			System.out.println(e);
		}
	}	*/
	
	
	public void saveDefaultEditorList(){
		
	    WeEditor editor;       

	    String out="";

	    out="<?xml version=\"1.0\" encoding=\"UTF-8\"?>"+ System.getProperty("line.separator");
	    out+="<webEdition>"+ System.getProperty("line.separator");
	    for(int i=0;i<DefaultEditorList.size();i++){
				editor = (WeEditor) DefaultEditorList.elementAt(i);
				out+=editor.object2xml();
	    }	       	
	    out+="</webEdition>"+ System.getProperty("line.separator");

	    PrivilegedSave pSave = new PrivilegedSave(editorFile,out,"UTF-8");
	    AccessController.doPrivileged(pSave);	    

	}
	
	public void loadEditorList(String filename,String ct) {
		
		loadDefaultEditorList();
		loadSystemEditorList(filename,ct);
						
	}
	
	
	protected void loadSystemEditorList(String filename,String ct) {
	
		SystemEditorList.removeAllElements();
		
		int index = filename.lastIndexOf('.');
		
		if(index>-1) {

			String ext = filename.substring(index+1);
			
			if((System.getProperty("os.name").matches("Mac OS X")) ||
			   (System.getProperty("os.name").matches("Windows(.)*"))
			) {

				Vector appList = new Vector();
				
				if(System.getProperty("os.name").matches("Mac OS X")) {
					MacRegistry mr = new MacRegistry(this);
					appList = mr.getAppList(ext);
				}	
				
				if(System.getProperty("os.name").matches("Windows(.)*")) {
					WinRegistry wr = new WinRegistry();
					appList = wr.getAppList(ext);
				}
				
				if(appList.size()>0) {
				
					
					WeEditor ed=new WeEditor();
					String path;
					String name;
					
					for(Iterator i = appList.iterator();i.hasNext();) {
						
						path = i.next().toString();
						name = ((new File(path)).getName()).replaceAll(".app", "");
							
						ed=new WeEditor();
						ed.init(name,path,"",ct,"","");
						addEditor(ed,SystemEditorList); 
						
					}
				}
				
			} else {
				
				
				
			}

		}
	}
		
	
	protected void loadDefaultEditorList(){
		
		DefaultEditorList.removeAllElements();
		 	    
	    if(!(new File(editorFile)).exists()) return;
	    
	    Document document;
	    
        DocumentBuilderFactory factory=DocumentBuilderFactory.newInstance();
        //factory.setValidating(true);   
        //factory.setNamespaceAware(true);
        try {
           DocumentBuilder builder = factory.newDocumentBuilder();
           
           document = builder.parse( new File(editorFile) );
           
           // get editors
           NodeList childs=document.getFirstChild().getChildNodes();
           int childCount=childs.getLength();
           Node node;
           //NamedNodeMap map;

           DefaultEditorList=new Vector();

           for(int i=0;i<childCount;i++){
           		node=childs.item(i);
           		           		
           		if(node.getNodeName()=="Editor"){           			

           			NodeList editorProps=node.getChildNodes();

           			String Name=new String();
           			String Path=new String();
           			String Args=new String();
           			String ContentType=new String();
					String DefaultFor=new String();
					String Encoding=new String();
           			
           			for(int j=0;j<editorProps.getLength();j++){
           				
						try { 
							if(editorProps.item(j).getNodeName()=="Name") Name=editorProps.item(j).getFirstChild().getNodeValue(); 
						}catch(NullPointerException e) {
							//System.err.println("No name:" + e);
						} 
						try {
							if(editorProps.item(j).getNodeName()=="Path") Path=editorProps.item(j).getFirstChild().getNodeValue();
						}catch(NullPointerException e) {
							//System.err.println("No path:" + e);
						} 
						try {
							if(editorProps.item(j).getNodeName()=="Args") Args=editorProps.item(j).getFirstChild().getNodeValue();
						}catch(NullPointerException e) {
							//System.err.println("No path:" + e);
						} 
						try {
							if(editorProps.item(j).getNodeName()=="ContentType") ContentType=editorProps.item(j).getFirstChild().getNodeValue();
						}catch(NullPointerException e) {
							//System.err.println("No content type:" + e);
						} 
						try {
							if(editorProps.item(j).getNodeName()=="DefaultFor") DefaultFor=editorProps.item(j).getFirstChild().getNodeValue();
						}catch(NullPointerException e) {
							//System.err.println("No default for: " + e);
						}
						try {
							if(editorProps.item(j).getNodeName()=="Encoding") Encoding=editorProps.item(j).getFirstChild().getNodeValue();
						}catch(NullPointerException e) {
							//System.err.println("No Encoding:" + e);
						}

           			}
           			
           			if(!Path.equals("")){
        				WeEditor ed=new WeEditor();
        				ed.init(Name,Path,Args,ContentType,DefaultFor,Encoding);
        				addEditor(ed,DefaultEditorList); 
           			}
           		
           		}
           	}
           
         
        } catch (SAXException sxe) {
           
        } catch (ParserConfigurationException pce) {

        } catch (IOException ioe) {
        
        } catch (Exception e) {
           
        }	    
	
	}
	
	public boolean hasContentType(String list,String ct) {
		
		if((ct.trim()).equals("")) {
			return true;
		}
		
		if((list.trim()).equals("")) {
			return false;
		}
		
		String arr[] = list.split(",");
		String it;
		
		for(int i = 0;i<arr.length;i++) {
			it = (arr[i].trim());
			if(it.length()>0 && it.equals(ct)) {
				return true;
			}
			
		}
		return false;
	}
	
	/*public void resetEditorList() {
		EditorList.removeAllElements();
		EditorList = new Vector();
	}*/
	
	public void clearList(){
		DefaultEditorList.removeAllElements();
		DefaultEditorList = new Vector();
		saveDefaultEditorList();
	}
	
	public Vector getEditorList(String ct){
		
		Vector edList = new Vector();
		
		for(Iterator i = DefaultEditorList.iterator();i.hasNext();) {
			WeEditor ed= (WeEditor)i.next();
			if(!ed.Path.equals("") && hasContentType(ed.ContentType,ct)){
				addEditor(ed,edList); 
			}
		}
		
		for(Iterator i = SystemEditorList.iterator();i.hasNext();) {
			WeEditor ed= (WeEditor)i.next();
			if(!ed.Path.equals("") && hasContentType(ed.ContentType,ct)){
				addEditor(ed,edList); 
			}
		}
		
		return edList;
	}
	
	
	public boolean editorExists(String path){
		
		Vector edList = getEditorList("");
		
		for(int i=0;i<edList.size();i++){
			if(((WeEditor)edList.elementAt(i)).Path.equals(path)) return true;
		}
		return false;
	}
	
	public WeEditor getDefaultEditor(String ct){
	
		for(Iterator i = DefaultEditorList.iterator();i.hasNext();) {
			WeEditor ed = (WeEditor)i.next();
			
			String edarr[] = ed.DefaultFor.split(",");
			String it;
			
			for(int j = 0;j<edarr.length;j++) {
				
				it = (edarr[j].trim());
				if(it.length()>0 && it.equals(ct)) {
					return ed;
				}
				
				
			}
			
		}
		
		return null;
	}
	
	public WeEditor getEditorAt(int index){
		Vector edList = getEditorList("");
		return (WeEditor) edList.elementAt(index);
	}
	
	public Vector getContentTypes(){
		return (Vector) ContentTypes.clone();
	}
			
	public void setUrl(String url) {
		try {
			HostUrl = new URL(url);
		} catch (Exception e) {
			// do nothing
		}
	}
	
	public URL getUrl(){
		return HostUrl;
	}
	
	public void setAppDir(String app) {
		AppDir = app;
	}
	
	public String getAppDir() {
		return AppDir;
	}
	
	public String getHost() {
		return HostUrl.toExternalForm();
	}
	
	public void removeFromDefaultEditorList(WeEditor editor) {
		DefaultEditorList.removeElement(editor);
		saveDefaultEditorList();
	}
	
	public boolean isInDefaultEditorList(WeEditor editor) {
		
		for(Iterator i = DefaultEditorList.iterator();i.hasNext();) {
			WeEditor ed = (WeEditor)i.next();
			if(editor.Path.equals(ed.Path)) {
				return true;
			}
		}
		return false;
	}
	
	public void replaceEditor(WeEditor editor) {
		int i = 0;
		int size = DefaultEditorList.size();
		
		for(i = 0;i<size;i++) {
			WeEditor ed = (WeEditor)DefaultEditorList.elementAt(i);
			if(ed.Path.equals(editor.Path)) {
				break;
			}
		}
		
		if(i<size) {
			DefaultEditorList.setElementAt(editor, i);
		}
		
	}
	
	public void saveSettings() {
		
	    String out="";

	    out="<?xml version=\"1.0\"?>"+ System.getProperty("line.separator");
	    out+="<webEdition>"+ System.getProperty("line.separator");
	    
	    Enumeration e = Settings.keys();
	    
	    for(;e.hasMoreElements();) {
	    	out+="\t<Setting>" + System.getProperty("line.separator");
	    	String key = (String)e.nextElement();
	    	out+="\t\t<Name>" + key + "</Name>" + System.getProperty("line.separator");
	    	out+="\t\t<Value>" + Settings.get(key) + "</Value>" + System.getProperty("line.separator");
	    	out+="\t</Setting>" + System.getProperty("line.separator");
	    }
	    
	    out+="</webEdition>"+ System.getProperty("line.separator");

	    PrivilegedSave pSave = new PrivilegedSave(settingsFile,out);
	    AccessController.doPrivileged(pSave);	    
		
		
	}
	
	public void loadSettings() {
		
		Document document;
        DocumentBuilderFactory factory=DocumentBuilderFactory.newInstance();

        try {
        	
           File sFile = new File(settingsFile);
           
           if(!sFile.exists()) {
        	   sFile.getParentFile().mkdirs();
        	   sFile.createNewFile();
           } else {

        	   if(sFile.length()>0) {

		           DocumentBuilder builder = factory.newDocumentBuilder();
		           document = builder.parse( sFile );
	
		           // get editors
		           NodeList childs=document.getFirstChild().getChildNodes();
		           int childCount=childs.getLength();
		           Node node;
		           //NamedNodeMap map;
	
		           for(int i=0;i<childCount;i++){
		           		node=childs.item(i);
	
		           		if(node.getNodeName()=="Setting"){           			
		
		           			NodeList settingProps=node.getChildNodes();
		
		           			String Name=new String();
		           			String Value=new String();
		           			
		           			for(int j=0;j<settingProps.getLength();j++){
		           				
								try { 
									if(settingProps.item(j).getNodeName()=="Name") Name=settingProps.item(j).getFirstChild().getNodeValue(); 
								}catch(NullPointerException e) {
									//System.err.println("No name:" + e);
								} 
								try {
									if(settingProps.item(j).getNodeName()=="Value") Value=settingProps.item(j).getFirstChild().getNodeValue();
								}catch(NullPointerException e) {
									//System.err.println("No value:" + e);
								} 
		
		           			}
		           			
		           			if(!Name.equals("")){
		        				 Settings.put(Name, Value);
		           			}
		           		}
		           	}
        	   }
           }
         
        } catch (SAXException sxe) {
        
        } catch (ParserConfigurationException pce) {

        } catch (IOException ioe) {
        
        } catch (Exception e) {
        
        }
	}
	
	public void setSetting(String name,String value){
		try{
			Settings.put(name,value);
		}catch(NullPointerException e) {
			System.out.print("Missing setting: " + name + "--" + value + "\n");
		}
		
	}
	
	public String getSetting(String name){
		return (String) Settings.get(name);		
	}
	
	public static String getDefaultEncoding() {		
		/*PrivilegedSystemProperties p = new PrivilegedSystemProperties("file.encoding");
		AccessController.doPrivileged(p);
		return p.Value.replaceFirst("Cp", "windows-");*/		
		return new OutputStreamWriter(new ByteArrayOutputStream()).getEncoding().replaceFirst("Cp", "windows-");
	}
	
	public static boolean isCharsetSupported(String charset) {
		try{
			if(Charset.isSupported(charset)) {
				return true;
			} else {
				return false;
			}
		} catch (Exception e){
			return false;
		}
	}
	
	public String getVersion() {
		return buildVersion;
	}
	
}