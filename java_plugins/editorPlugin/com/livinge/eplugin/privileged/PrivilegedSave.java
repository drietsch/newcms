package com.livinge.eplugin.privileged;
import java.io.File;
import java.io.BufferedWriter;
import java.io.FileOutputStream;
import java.io.OutputStreamWriter;
import java.security.PrivilegedAction;
/*
 * Created on Nov 5, 2004
 *
 * TODO To change the template for this generated file go to
 * Window - Preferences - Java - Code Style - Code Templates
 */

import com.livinge.eplugin.editor.WeSettings;

/**
 * @author slavko
 *
 * TODO To change the template for this generated type comment go to
 * Window - Preferences - Java - Code Style - Code Templates
 */


public class PrivilegedSave implements PrivilegedAction {

		String path;
		String content;
		byte[] binary;
		boolean IsBinary=false;
		boolean IsCheck=false;
		public long LastChange=0;
		String encoding;
		
		
		public PrivilegedSave(String file,boolean check){
			path=file;
			setCheck(check);
			encoding = WeSettings.getDefaultEncoding();
		}
		
		public PrivilegedSave(String file, String code){
			path=file;
			content=code;
			encoding = WeSettings.getDefaultEncoding();
		}
		
		public PrivilegedSave(String file, String code,String enc){
			path=file;
			content=code;
			encoding = enc;
		}
		
		public PrivilegedSave(String file,byte[] buffer){
			path=file;
			content="";
			binary = new byte[buffer.length];
			binary = buffer;
			IsBinary=true;
			encoding = WeSettings.getDefaultEncoding();
		}
		
		public void setCheck(boolean check){
			IsCheck = check;
		}
		
		public Object run(){
			try{
				if(IsCheck){
					LastChange= (new File(path)).lastModified();
				}
				else{
					if(IsBinary){
						FileOutputStream output = new FileOutputStream(new File(path));
						output.write(binary,0,binary.length);
						output.close();
					}
					else{
						BufferedWriter out;
						File f = new File(path);
						if(f.exists()) {
							f.createNewFile();
						}

						if(WeSettings.isCharsetSupported(encoding)) {
							out = new BufferedWriter(new OutputStreamWriter(new FileOutputStream(f), encoding));
						} else {
							out = new BufferedWriter(new OutputStreamWriter(new FileOutputStream(f)));
						}
						out.write(content);
		    			out.close();
					}
				}
			}
			catch(Exception e){
				e.printStackTrace();
			}
			return null;
		}
	
	
}