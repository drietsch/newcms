package com.livinge.eplugin.editor;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.URL;
import java.security.AccessController;

import com.livinge.eplugin.privileged.PrivilegedCheck;
import com.livinge.eplugin.privileged.PrivilegedMkDirs;
import com.livinge.eplugin.privileged.PrivilegedPrepareEditFile;
import com.livinge.eplugin.privileged.PrivilegedSave;
import com.livinge.eplugin.util.HttpRequest;

public class EPDocument {

	protected WeEditor Editor;
	protected String CacheFilename;
	protected String ContentType;
	protected String Transaction;
	protected String SessionId;
	protected long CacheLastSave=0;
	protected String Source;
	protected String CmdEntry;
	protected String Encoding;
	protected boolean Check = false;
	
	public EPDocument() {
		CacheFilename = "";
		ContentType = "";
		Transaction = "";
		SessionId = "";
		CmdEntry = "";
		Encoding = WeSettings.getDefaultEncoding();
		
	}
	
	public EPDocument(String session,String trans,String filename,String ct,String cmd) {
		CacheFilename = filename;
		ContentType = ct;
		Transaction = trans;
		SessionId = session;
		CmdEntry = cmd;
		Encoding = WeSettings.getDefaultEncoding();
		
		PrivilegedMkDirs pmkdir = new PrivilegedMkDirs(new File(CacheFilename).getParentFile().getPath());
		AccessController.doPrivileged(pmkdir);
		
	}
	
	public void setEditor(WeEditor ed) {
		Editor = ed;
	}
			
	public void setSource(String s) {
			
		Source = s;

	}
	
	public String getSource() {
		return Source;
	}
	
	public void setCacheFilename(String filename) {
		CacheFilename = clearPath(filename);
	}
	
	public String getCacheFilename() {
		return CacheFilename;
	}
	
	public String getTransaction() {
		return Transaction;
	}
	
	public void setTransaction(String trans) {
		Transaction = trans;
	}
	
	
	public String getContentType() {
		return ContentType;
	}
	
	public void setContentType(String ct) {
		ContentType = ct;
	}
	
	public String getEncoding() {
		return Encoding;
	}
	
	public void setEncoding(String enc) {
		Encoding = enc;
	}
	
	
	public void saveSource(){
		
		PrivilegedMkDirs pmkdir = new PrivilegedMkDirs(new File(CacheFilename).getParentFile().getPath());
		AccessController.doPrivileged(pmkdir);
		
	    // NOTE:save the source with default system charset
		PrivilegedSave textSave = new PrivilegedSave(CacheFilename,Source,Encoding);
	    AccessController.doPrivileged(textSave);
	    textSave.setCheck(true);	    
		AccessController.doPrivileged(textSave);
		CacheLastSave = textSave.LastChange;
	}

	public void loadSource(){
		Source="";
		try{
			BufferedReader in;
			
			if(WeSettings.isCharsetSupported(Encoding)) {
				in = new BufferedReader(new InputStreamReader(new FileInputStream(CacheFilename),Encoding));
			} else {
				in = new BufferedReader(new InputStreamReader(new FileInputStream(CacheFilename)));
			}
	        
	        String str;
	        while ((str = in.readLine()) != null) {
	        	Source+=str+System.getProperty("line.separator");
	        }
	        in.close();
		}
		catch(Exception e){
			e.printStackTrace();
		}
		
	}	
	
	public void copyFromUrl(String url) {
		try {
			PrivilegedPrepareEditFile pcopy = new PrivilegedPrepareEditFile(new URL(url), CacheFilename);
			AccessController.doPrivileged(pcopy);
			CacheLastSave = getLastSave();
		}catch(IOException e) {
			e.printStackTrace();
		}

	}
	
	static public String clearPath(String in) {
		
		String out="";
		
		out = in.replace('\\','/');
		out = out.replaceAll("[/]+", "/");
		if(System.getProperty("os.name").matches("Windows(.)*")) {
			out = out.replace('/','\\');
		}
		
		return out;
	}
	
	
	public void uploadFile() {
		try {
			
			HttpRequest fu = new HttpRequest();
			
			fu.addVariable("we_cmd[0]","setBinary");
			//fu.addVariable("PHPSESSID",SessionId);
			fu.addVariable("we_transaction",Transaction);
			fu.addVariable("contenttype",ContentType);
			fu.addFile("uploadfile",CacheFilename);
			fu.upload(CmdEntry);
			
		} catch (Exception ex) {
			System.err.println("Exception: " + ex);
			ex.printStackTrace();	
		}
	}

	public long getCacheLastSave() {
		return CacheLastSave;
	}

	public void setCacheLastSave(long ls) {
		CacheLastSave = ls;
	}

	public String getSessionId() {
		return SessionId;
	}

	public void setSessionId(String s) {
		SessionId = s;
	}	
	
	protected long getLastSave() {
		PrivilegedCheck pAction = new PrivilegedCheck(CacheFilename);
		AccessController.doPrivileged(pAction);	    					
		return pAction.LastChange;
	}
	
	public boolean isChanged() {
		long newLastSave=getLastSave();
		return (newLastSave>CacheLastSave);
	}
	
	public void setNewLastSave() {
		setCacheLastSave(getLastSave());
	}
	
	public boolean isText() {
		return (getContentType().indexOf("text/")!=-1);
	}
	
	public boolean getCheck() {
		return Check;
	}
	
	public void setCheck(boolean c) {
		Check = c;
	}
}