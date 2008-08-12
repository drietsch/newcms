package com.livinge.eplugin.privileged;
import java.io.File;
import java.security.PrivilegedAction;

/**
 * @author slavko
 *
 * TODO To change the template for this generated type comment go to
 * Window - Preferences - Java - Code Style - Code Templates
 */


public class PrivilegedCheck implements PrivilegedAction {

		String path;
		public long LastChange=0;
		
		public PrivilegedCheck(String file){
			path=file;
		}
		
		
		public Object run(){
			try{
				
				LastChange= (new File(path)).lastModified();

			}
			catch(Exception e){
				e.printStackTrace();
			}
			return null;
		}
	
	
}