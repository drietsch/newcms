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

import java.io.File;
import java.net.MalformedURLException;
import java.net.URL;
import java.security.AccessController;
import java.util.Iterator;
import java.util.Vector;

import javax.swing.JApplet;
import javax.swing.JFrame;
import javax.swing.JOptionPane;
import javax.swing.UIManager;
import javax.swing.UnsupportedLookAndFeelException;

import com.livinge.eplugin.editor.DocumentManager;
import com.livinge.eplugin.editor.EPDocument;
import com.livinge.eplugin.editor.WeEditor;
import com.livinge.eplugin.editor.WeSettings;
import com.livinge.eplugin.gui.EPEditorDialog;
import com.livinge.eplugin.privileged.PrivilegedSave;
import com.livinge.eplugin.util.Base64Coder;


public class EPlugin extends JApplet {
	
	
	
	static final long serialVersionUID = -1611200117062004017L;
	
	//private boolean initialized=false;
    //Specify the look and feel to use.  Valid values:
    //null (use the default), "Metal", "System", "Motif", "GTK+"
    final static String look = "System";

    protected EPEditorDialog editorDialog;
    protected WeSettings weSettings;
    
    protected String startDialog="";
    protected String cmdEntry="";
    
    private UIMonitor monUI=new UIMonitor();
    private CacheMonitor monCache=new CacheMonitor();
        
    protected boolean runThreads=true;
	protected final int threadTick = 500;
    
	protected boolean debug = true;
	
	protected Vector Messages = new Vector();
	
	private static final int MODE_INACTIVE = 0;
	private static final int MODE_EDITOR = 1;
	private static final int MODE_SETTINGS = 2;
	
	protected int runDialog=MODE_INACTIVE;	
	
	public boolean isLive = true;
	
    private void initLookAndFeel() {
        String lookAndFeel = null;

        if (look != null) {
            if (look.equals("Metal")) {
                lookAndFeel = UIManager.getCrossPlatformLookAndFeelClassName();
            } else if (look.equals("System")) {
                lookAndFeel = UIManager.getSystemLookAndFeelClassName();
            } else if (look.equals("Motif")) {
                lookAndFeel = "com.sun.java.swing.plaf.motif.MotifLookAndFeel";
            } else if (look.equals("GTK+")) { //new in 1.4.2
                lookAndFeel = "com.sun.java.swing.plaf.gtk.GTKLookAndFeel";
            } else {
                lookAndFeel = UIManager.getCrossPlatformLookAndFeelClassName();
            }

            try {
                UIManager.setLookAndFeel(lookAndFeel);
                JFrame.setDefaultLookAndFeelDecorated(false);
            } catch (ClassNotFoundException e) {
            	e.printStackTrace();
            } catch (UnsupportedLookAndFeelException e) {
            	e.printStackTrace();
            } catch (Exception e) {
             
                e.printStackTrace();
            }
        }
    }    
        
	public void init() {
		URL codeBase = getCodeBase();
		String SERVER_NAME = codeBase.getHost();
		int port=(getDocumentBase()).getPort();
		String protocol=(getDocumentBase()).getProtocol();
		String url;
		
		if(port!=-1)
			url = protocol+"://"+SERVER_NAME+":"+port+"/webEdition/eplugin/initPlugin.html";
		else
			url = protocol+"://"+SERVER_NAME+"/webEdition/eplugin/initPlugin.html";
		
		
		try {
			this.getAppletContext().showDocument (new URL(url),"load");
		} catch (MalformedURLException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
		initLookAndFeel();
		weSettings=new WeSettings();
		try{

			String[] plist=getParameter("param_list").split(",");
			for(int i=0;i<plist.length;i++){
				weSettings.setParam(plist[i],getParameter(plist[i]));
			}
			
			weSettings.setUrl(getParameter("host").toString());
			
			weSettings.createCache();
			
			cmdEntry = getParameter("cmdentry");
			
			
		}catch(NullPointerException e) {
			System.out.print(e);
		}

		Messages = new Vector();
		
		monUI.start();
		
		
	}
	
	public void start(){
		
	}
    
	public void stop()  {
		runThreads=false;
		gotoBed(2*threadTick);
	}
	
	public String getAppletInfo(){
		return "Editor Plugin\nAuthor Slavko Tomcic";
	}

	
	public String[][] getParameterInfo(){
		 String pinfo[][] = {
		 		 {"param_list",    "string",    "list of dinamicaly loadable parameters"}
		 	 };
		 return pinfo; 
	}
	
	protected void saveDwFiles(EPDocument doc) {
		
		String content = "webEditionUrl = \""+weSettings.getHost()+"/webEdition/rpc/rpc.php\";\n";
		content += "sessionId = \"" + doc.getSessionId() + "\";\n";
		
		String fn = weSettings.registryDir + "/installation.js";
		
		
		PrivilegedSave ps = new PrivilegedSave(fn,content);
	    AccessController.doPrivileged(ps);
		
	    String path = new String(doc.getCacheFilename()); 
	    
	    //path = path.replaceAll("\\", "\\\\");
	    
	    path = EPlugin.replace(path,"\\", "\\\\");
	    
	    
	    content = "transactions = new Object();\n";
		content += "transactions[\"" + path + "\"] = \"" + doc.getTransaction() + "\";\n";
		
		fn = weSettings.registryDir + "/transaction.js";
		
		ps = new PrivilegedSave(fn,content);
	    AccessController.doPrivileged(ps);
	    
		
	}
	
	protected void deleteDwFiles() {
		
		String fn = weSettings.registryDir + "/installation.js";
		try {
			new File(fn).delete();
		} catch (Exception e) {
			
		}
		fn = weSettings.registryDir + "/transaction.js";
		try {
			new File(fn).delete();
		} catch (Exception e) {
			
		}
		
	}
	
	
	public String clearPath(String in) {
		
		String out="";
		
		out = in.replace('\\','/');
		out = out.replaceAll("[/]+", "/");
		if(System.getProperty("os.name").matches("Windows(.)*")) {
			out = out.replace('/','\\');
		}
		
		return out;
	}
		
	public void editSource(	String sess,String trans,String filename,String code,
							String contenttype,String encoded,String charset){

		weSettings.lastContentType = contenttype;
		String cachefn = "";
		if(contenttype.equals("text/weTmpl")) {
			cachefn=clearPath(weSettings.cacheDir+"template"+System.getProperty("file.separator")+filename);
		} else {
			cachefn=clearPath(weSettings.cacheDir+"document"+System.getProperty("file.separator")+filename);
		}

		System.out.println("contenttype:"+contenttype);
		EPDocument document = new EPDocument(sess,trans,cachefn,contenttype,cmdEntry);
	
		if(encoded.equals("true")) {
			code=Base64Coder.decode(code,charset);
		}
		
		document.setSource(code);
		
		//document.saveSource();
						
		saveDwFiles(document);
			
		invokeEditor(document);
		
	}
	
	
	public void editFile(String sess,String trans,String path,String url, String contenttype){
		
		String cachefn = "";
		if(contenttype.equals("text/weTmpl")) {
			cachefn=clearPath(weSettings.cacheDir+"template"+System.getProperty("file.separator")+path);
		} else {
			cachefn=clearPath(weSettings.cacheDir+"document"+System.getProperty("file.separator")+path);
		}

		EPDocument document = new EPDocument(sess,trans,cachefn,contenttype,cmdEntry);
		
		document.copyFromUrl(url);
		
		invokeEditor(document);
	}
		
	private void invokeEditor(EPDocument doc){
	
		runDialog=MODE_EDITOR;
		
		DocumentManager.addDocument(doc);
		
		if(!monUI.isAlive()){
			monUI=new UIMonitor();
			monUI.start();
		}
		
		runThreads=true;
		if(!monCache.isAlive()) { 
			monCache.start();
		}
		
	}

	
	public void editSettings() {

		runDialog = MODE_SETTINGS;
		
		if(!monUI.isAlive()){
			monUI=new UIMonitor();
			monUI.start();
		}
		
		/*
		runThreads=true;
		if(!monCache.isAlive()) {
			monCache.start();		
		}
		*/
	}	
	
	public void removeDocument(String transaction) {
		DocumentManager.removeDocument(transaction);
		/*
		System.out.println("Remove document: " + transaction);
		DocumentManager.reset();
		while(DocumentManager.hasNext()) {
			EPDocument doc = DocumentManager.next();
			System.out.println(doc.getTransaction() + ": " + doc.getCacheFilename());
		}*/
		
	}

	public boolean inEditor(String transaction) {
		return DocumentManager.hasDocument(transaction);
	}

	public int getDocumentCount() {
		return DocumentManager.getCount();
	}
	
	private void gotoBed(int ms){
		try {
			Thread.sleep(ms);
		} catch (Exception e) {
			e.printStackTrace();
			System.exit(1);
		}
	}
	
	
	public void setSource(String sourceCode){ 
		DocumentManager.getCurrent().setSource(sourceCode);
		
	}
	
	public String getSource(String trans){
		return DocumentManager.getDocument(trans).getSource();
	}	
	
	
	
	
	public void addMessage(String message) {
		
		Messages.add(message);
		
	}
	
	public boolean hasMessages() {
		
		return !Messages.isEmpty();
		
	}
	
	public String getMessages() {
		
		String mess = ""; 

		for(Iterator i = Messages.iterator();i.hasNext();) {
			mess += "\n" + i.next().toString();
		}

		Messages.removeAllElements();
		return mess;	
	}
	
	public void destroy() {
		deleteDwFiles();
	}
	
	public static String replace(String source, String find, String replace) {
        if (source!=null) {
	        final int len = find.length();
	        StringBuffer buff = new StringBuffer();
	        int found = -1;
	        int start = 0;

	        while( (found = source.indexOf(find, start) ) != -1) {
	        	buff.append(source.substring(start, found));
	        	buff.append(replace);
	            start = found + len;
	        }
	
	        buff.append(source.substring(start));
	
	        return buff.toString();
        }
        else {
        	return "";
        }
    }
	
	public int getDocCount() {
		return DocumentManager.getCount(); 
	}
	
	
	class UIMonitor extends Thread {
		public void run() {
			while (runThreads) {
					
					if(runDialog==MODE_EDITOR){
						
						EPDocument doc = DocumentManager.getLast();
												
						if(weSettings.getSetting("askForEditor").equals("true")) {
							editorDialog=new EPEditorDialog(doc,weSettings,MODE_EDITOR);
							editorDialog.pack();
							editorDialog.setVisible(true);
						} else {
						
							weSettings.loadEditorList(doc.getCacheFilename(), doc.getContentType());
							WeEditor ed = weSettings.getDefaultEditor(doc.getContentType());
							
							if(ed!=null){
								ed.start(doc);
							}
							else{
						    	JOptionPane.showMessageDialog(
						    			editorDialog,
						    			weSettings.getParam("lan_alert_nodefeditor_text"),
										weSettings.getParam("lan_alert_noeditor_title"),					                
										JOptionPane.ERROR_MESSAGE
								);
							}

						}
						
					} else if(runDialog==MODE_SETTINGS){

						editorDialog=new EPEditorDialog(new EPDocument(),weSettings,MODE_SETTINGS);
						editorDialog.pack();
						editorDialog.setVisible(true);
						
					}
					
					runDialog=MODE_INACTIVE;
					
					gotoBed(threadTick);
			}
		}
		
		protected void log(String s) {
			if(debug){
				System.out.println(s);
			}
		}
		
	}
	
	class CacheMonitor extends Thread {
		public void run() {
			while (runThreads) {
					
					DocumentManager.reset();
					
					while(DocumentManager.hasNext()) {
						
						EPDocument doc = DocumentManager.next();

						if(!doc.getCacheFilename().equals("")){
							
							if(doc.isChanged() && doc.getCheck()) {
								
								doc.setNewLastSave();

								if(doc.isText()) {
									doc.loadSource();
									addMessage("setSource(\""+doc.getTransaction()+"\");");
								} else {
									doc.uploadFile();
									addMessage("reloadContentFrame(\""+doc.getTransaction()+"\");");
								}

							}

						}
						
					}
					
					gotoBed(threadTick);
			}
		}
	}
		
}