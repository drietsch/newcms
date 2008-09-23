/*
LeSpellchecker - a spellchecking applet for webEdition
Copyright (C) 2006 living-e AG

*/
import java.applet.Applet;
import java.awt.Graphics;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.net.URL;
import java.util.Hashtable;
import java.util.Iterator;
import java.util.Vector;
import java.util.zip.ZipInputStream;

import com.livinge.spellchecker.engine.BaseUtility;
import com.livinge.spellchecker.engine.CopyUtility;
import com.livinge.spellchecker.engine.SpellDictionaryEncDisk;
import com.livinge.spellchecker.engine.SpellSuggestion;
import com.swabunga.spell.engine.Configuration;
import com.swabunga.spell.engine.SpellDictionaryHashMap;
import com.swabunga.spell.event.SpellCheckEvent;
import com.swabunga.spell.event.SpellCheckListener;
import com.swabunga.spell.event.SpellChecker;
import com.swabunga.spell.event.StringWordTokenizer;

/**
 * The applet immplements spellchecking function for webEdition CMS
 * The Jazzy library has been used   
 *
 * @author Slavko Tomcic
 * @version 1.0.1
 */

public class LeSpellchecker extends Applet implements SpellCheckListener {

	  private boolean initialized;
	  protected SpellCheckEvent event;
	  protected SpellChecker checker;
	  private StringWordTokenizer tokens;
	

	  protected int cursor=-1;	  
	  protected Vector MisspelledList = new Vector();

	  private static final int IGNORE_ALL_CAPS_WORD = 2;
	  private static final int IGNORE_CAPPED_WORD = 4;
	  private static final int IGNORE_MIXED_CASE = 8;
	  private static final int IGNORE_MIXED_DIGITS = 16;
	  private static final int REPORT_DOUBLED_WORD = 64;
	  private static final int IGNORE_DOMAIN_NAMES = 0x10000;

	  private static Hashtable configmap;

	  static {
	    configmap = new Hashtable();
	    configmap.put(new Integer(IGNORE_MIXED_DIGITS), Configuration.SPELL_IGNOREDIGITWORDS);
	    configmap.put(new Integer(IGNORE_DOMAIN_NAMES), Configuration.SPELL_IGNOREINTERNETADDRESSES);
	    configmap.put(new Integer(IGNORE_MIXED_CASE), Configuration.SPELL_IGNOREMIXEDCASE);
	    configmap.put(new Integer(REPORT_DOUBLED_WORD), Configuration.SPELL_IGNOREMULTIPLEWORDS);
	    configmap.put(new Integer(IGNORE_CAPPED_WORD), Configuration.SPELL_IGNORESENTENCECAPITALIZATION);
	    configmap.put(new Integer(IGNORE_ALL_CAPS_WORD), Configuration.SPELL_IGNOREUPPERCASE);
	  }	
	  
	  protected Hashtable baseMap = new Hashtable();
	  
	  	  
	  protected SpellDictionaryEncDisk localDict;
	  protected String userDictFilename = "myDict";
	  protected SpellDictionaryHashMap userDict;
	
	  	  
	  protected boolean runThreads=true;
	  protected CmdDispatcher Starter = new CmdDispatcher();
	  protected String Cmd = "";
	  
	  protected String[] CmdArgs = new String[]{""};
	  
	  protected boolean startCheck = false;
	  protected CheckerRun checkeR = new CheckerRun();

	 
	  protected String defEncoding = "UTF8";
	  
	  protected final int threadTick = 500;
	  protected final int spellTimeout = 500;
	  protected boolean working = true;
	  protected boolean timeout = false;
	  
	  protected boolean debug = false;
	  
	  public LeSpellchecker() {
	    initialized = false;
	  }

	  public void init() {
		  
		defEncoding = "UTF8";
		
	    logMess("Init");
	    logMess("Default encoding is set to: " + BaseUtility.getDefaultEncoding());
	    
	    // get params
	    final String dictionary = getParameter("dictionary");
	    final String dictBase = getParameter("dictBase");
	    
	    try {
	    	String dp = getParameter("debug");	    
	    	if(dp.equals("on")) {
	    		debug=true;
	    	}
	    } catch (Exception ex){
	    	
	    }
	    
	    // overwrite jazzy config
	    System.setProperty("jazzy.config", "com.livinge.spellchecker.engine.SpellCheckConfiguration");
	    
	    //this.setLocale(new Locale("de_DE"));
	    

	    // setup spellchecker
	    checker = new SpellChecker();	    	    	    
	    checker.setCache();
	    
	    //	  create necessery files and folders
	    try {
	    	baseMap = BaseUtility.createBase(dictionary);
	    	logMess("Local storage has been created");
	    } catch(java.lang.IllegalStateException ise) {
	    	ise.printStackTrace();
	    }
	    
	    
	    //download and install dictionaries in non-blocking mode
	    Thread t = new Thread() {
	    	public void run() {
	        	  try {
	            	installDicts(dictionary,dictBase);
	        	  } catch (Exception e) {
	            	e.printStackTrace();
	        	  }
	    	}
	    };
	    t.start();

	    Starter.start(); 
	    checkeR.start();
	    initialized = true;
	    setWorking(false);
	    
	    logMess("Init complited");
	        
	 
	}
	
	protected void installDicts(String dict,String dictBase) {
	    
		logMess("Seting up the dictionary for " + dict);

	    String dictionary = dict + ".zip";
	    
	    String lds = baseMap.get("localDictBase").toString();
	    String ldf = lds + dictionary;
	    
	    if(! new File(ldf).exists()){
    		logMess("Download dictionary:"+dictBase+dictionary);
    		try {
    			CopyUtility.copy(new URL(dictBase+dictionary),ldf);
    			
    		} catch (IOException ex) {
	    		ex.printStackTrace();
		    }
    	}	    

	    // check if the db is there
	    if((new File(ldf).exists()) && !(new File((baseMap.get("localWordsDb").toString()) + "words.db") ).exists()) {
	    	extractAndCopy(ldf);
	    }

	    //create necessary files if they don't exist
	    BaseUtility.createBaseFiles(baseMap);
	    
	    try {
	    	localDict = new SpellDictionaryEncDisk(new File(lds),new File(lds+dict+".phonet"),true,defEncoding);
	    	checker.addDictionary(localDict);
	    } catch(IOException ex) {
	    	ex.printStackTrace();
	    }
	    setUserDict(dictBase);
	    
	    logMess("Dictionaries installed");
	}
	
	protected void extractAndCopy(String ldf) {
	
	    String lds = baseMap.get("localDictBase").toString();	    
		
		logMess("Extract dictionary file: " + ldf);
    	try {
    		
			Vector ext = CopyUtility.extract(new ZipInputStream(new FileInputStream(ldf)),lds);
			
			for(Iterator j = ext.iterator();j.hasNext();) {
				String entry =j.next().toString();
				File f = new File(lds+entry);
				if(f.exists()) {
					if(entry.equals("words.db") || entry.equals("words.idx") || entry.equals("contents")) {
						f.renameTo(new File((baseMap.get("localWordsDb").toString())+entry));
					} else if(entry.indexOf(".phonet")<0) {						
						f.renameTo(new File((baseMap.get("localWords").toString())+entry));
					}
				}
			}		
    	} catch (IOException ex) {
    		ex.printStackTrace();
    	}
		
	}
	
	
	protected void setUserDict(String dictBase) {
		
		long udfs = 0;
		try {
	    	String user = getParameter("user").toString();
	    	userDictFilename = user + ".dict";
	    	udfs = Long.parseLong(getParameter("udSize").toString());
	    } catch (Exception ex){

	    }
		
		String lds = baseMap.get("localDictStorage").toString();
		String udfn = lds+userDictFilename;
		
		logMess("Seting up the user dictionary " + udfn);
		
	    try {
	    	File uDictFile = new File(udfn);
	    	
	    	if(!uDictFile.exists()) {
	    		if(!uDictFile.createNewFile()) {
	    			throw(new IOException());	
	    		}
	    	}
	    	
	    	if(uDictFile.length()<udfs) {
	    		logMess("Download dictionary:"+dictBase+userDictFilename);
	    		try {
	    			CopyUtility.copy(new URL(dictBase+userDictFilename),udfn);
	    		} catch (IOException ex) {
		    		ex.printStackTrace();
			    }	    		
	    	}

		    userDict = new SpellDictionaryHashMap(uDictFile);

		    if(userDict!=null){
		    	checker.setUserDictionary(userDict);
		  	}
		
	    } catch (IOException ex) {
	    	logMess(this.hashCode() + ": could not create user dict file in:"+udfn);
	    }		
	    logMess("User dictionary installed");
	}
	
	protected void startDict(String dict) {
		checker.reset();
		checker.removeAllDictionaries();		
	    String dictBase = getParameter("dictBase");
	    try {
	    	baseMap = BaseUtility.createBase(dict);
	    	logMess("Local storage has been be created");
	    } catch(java.lang.IllegalStateException ise) {
	    	ise.printStackTrace();
	    }
        installDicts(dict,dictBase);	    
	}
	
	public void setDict(String dict) {
		Cmd = "startDict";
		CmdArgs[0] = dict;
	}
	
	
	public void setOptions(int options) {
	    Configuration config = checker.getConfiguration();
	    for (int i = 1; i <= 0x20000; i = i << 1) {
	      String key = (String) configmap.get(new Integer(i));
	      if (key != null) config.setBoolean(key, (options & i) > 0);
	    }
	}

	
	protected void checkText(String text) {
		
		resetSuggestionList();
	  	checker.removeSpellCheckListener(this);
	    checker.addSpellCheckListener(this);
	    checker.reset();
	    tokens = new StringWordTokenizer(text);
	    
    
	    /*while(tokens.hasMoreWords()) {
	    	System.out.println(tokens.nextWord());
	    }*/
	    
	    
	    startCheck = true;
	    working = true;
	    timeout = false;
	}
	
	public void check(String Text) {
		  Cmd = "check";
		  CmdArgs[0] = Text;
	}
	
	public void addWord(String word) {
		Cmd = "addWord";		  
		CmdArgs[0] = word;
	}
	
	public void addWords(String word) {
		Cmd = "addWords";		  
		CmdArgs[0] = word;
	}
	
	protected void logMess(String s) {
		if(debug){
			System.out.println(s);
		}
	}
			
	public void destroy() {
		logMess("distroy");
		setWorking(false);
		runThreads=false;		
		doSleep(4*threadTick);
	}
	
	public void paint(Graphics arg0) {
		 super.paint(arg0);

	 }

	public String getAppletInfo(){
		return "Spellchecker Plugin\nAuthor Slavko Tomcic";
	}

	
	public String[][] getParameterInfo(){
		 String pinfo[][] = {
		 		 {"dictonary",    "string",    "the name of dictionary; should be saved as zip file in dictBase"},
		 		 {"dictBase",     "string",    "url where the dictionaries can be found"}
		 	 };
		 return pinfo; 
	}
	
	public void spellingError(SpellCheckEvent event) {
	    				 		 
		if (event != null) {
			boolean exists = false;
			
			for (Iterator i = MisspelledList.iterator(); i.hasNext();) {
				SpellSuggestion element = (SpellSuggestion) i.next();
			    if(element.getMisspelledWord().equals(event.getInvalidWord())) {
			    	exists = true;
			    	break;
			    }
			}

			if(!exists) {
				MisspelledList.add(new SpellSuggestion(event.getInvalidWord(),event.getWordContextPosition(),event.getSuggestions()));
				logMess("Misspelled: " + event.getInvalidWord());
			}
			// wait to see if the spelling ends
			timeOutChecking();
			
		    if(!working) {
		    	event.cancel();
		    }

		}

	}	
	
	public boolean isReady() {
		//return initialized && isDictReady();
		return initialized;
	}

	public boolean isDictReady() {
		return localDict.isReady();
	}
	
	public boolean isWorking() {
		return working;
	}
	
	public boolean isTimeout() {
		return timeout;
	}
	
	protected void timeOutChecking() {
//		 wait to see if the spelling ends 
		Thread t = new Thread() {
	    	public void run() {
	    		if(runThreads) {
	        	  try {
	        		sleep(spellTimeout);
	            	//setWorking(false);
	        		setTimeout(true);
	        		timeout = true;
	        	  } catch (Exception e) {
	            	e.printStackTrace();
	        	  }
	    		}
	    	}
	    };
	    t.start();	
	}
	
	protected void setWorking(boolean value) {
		working = value;
	}
	
	public void setTimeout(boolean value) {
		timeout = value;
	}
	
	protected void doSleep(int ms){
		try {
			Thread.sleep(ms);
		} catch (Exception e) {
			//e.printStackTrace();
		}
	}
	
	public void resetSuggestionList() {
		cursor = -1;
		MisspelledList = new Vector();
	}
	
	public boolean nextSuggestion() {
		if(hasNextSuggestion()) {
			cursor++;
			return true;
		} else {
			return false;
		}
	}
	
	public boolean hasNextSuggestion() {
		return ((cursor+1)<MisspelledList.size());
	}
	
	public String getMisspelledWord() {
		SpellSuggestion ss = (SpellSuggestion) MisspelledList.get(cursor);
		return ss.getMisspelledWord();		
	}
	
	public int getMisspelledOffset() {
		SpellSuggestion ss = (SpellSuggestion) MisspelledList.get(cursor);
		return ss.getMisspelledOffset();		
	}
	
	public String getSuggestions() {
		SpellSuggestion ss = (SpellSuggestion) MisspelledList.get(cursor);
		return ss.getSuggestions();		
	}
	
	
	protected boolean deleteDic(String dict) {
		File dictDir = new File(baseMap.get("localDictStorage").toString() + dict);
		return delDir(dictDir);
	} 	
	
	protected boolean delDir(File dir) {
        if (dir.isDirectory()) {
            String[] childs = dir.list();
            for (int i=0; i<childs.length; i++) {
                if (!delDir(new File(dir, childs[i]))) {
                    return false;
                }
            }
	    }
	    return dir.delete();
	} 	
	
		
	class CmdDispatcher extends Thread {
		public void run() {
			while (runThreads) {

				if(Cmd.equals("check")) {
					checkText(CmdArgs[0]);
					Cmd = "";
				}
				if(Cmd.equals("addWord")) {
					checker.addToDictionary(CmdArgs[0]);	
					Cmd = "";
				}
				
				if(Cmd.equals("addWords")) {
					String[] s = (CmdArgs[0]).split(",");
					for (int i=0;i<s.length;i++) {
						if(!s[i].equals("") && !s[i].equals(" ")){
							checker.addToDictionary(s[i]);
						}
					}
					Cmd = "";
				}				
				
				if(Cmd.equals("startDict")) {
					startDict(CmdArgs[0]);
					Cmd = "";
				}

				doSleep(threadTick);
			}
			
			
		}			

	}
	
	class CheckerRun extends Thread {
		public void run() {
			while (runThreads) {
				if(startCheck) {
					startCheck = false;
					checker.checkSpelling(tokens);
					setWorking(false);
					//timeOutChecking();
					//startCheck = false;
				}
				doSleep(threadTick);
			}
		}
	}
	

}

