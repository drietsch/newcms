package com.livinge.spellchecker.swing;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.File;
import java.io.IOException;
import java.nio.charset.Charset;
import java.util.ArrayList;
import java.util.Hashtable;
import java.util.Iterator;
import java.util.Vector;

import javax.swing.BorderFactory;
import javax.swing.Box;
import javax.swing.BoxLayout;
import javax.swing.JApplet;
import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JFileChooser;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JTextField;
import javax.swing.border.CompoundBorder;
import javax.swing.border.EmptyBorder;

import com.livinge.spellchecker.engine.BaseUtility;
import com.livinge.spellchecker.engine.CopyUtility;
import com.livinge.spellchecker.engine.SpellDictionaryEncDisk;
import com.livinge.spellchecker.engine.Uploader;

public class DictEditor extends JApplet {

	protected String defEncoding = "UTF8";
	protected SpellDictionaryEncDisk newDict;
	
/*	protected File words = null;
	protected File phonetic = null;*/
	
	protected boolean runThreads = true;
	protected int threadTick = 2000;
	
	
	protected boolean working = false;
	protected boolean dictReady = false;
	protected boolean packed = false;
	protected boolean uploadFinished = false;
	
	final JLabel statusLabel = new JLabel("");
	
	Hashtable map = new Hashtable(); 
	final Hashtable params = new Hashtable();
	
	protected StatusRun satusR = new StatusRun();
	
	  /**
	   * @see java.awt.Component#paint(Graphics)
	   */
	  public void paint(Graphics arg0) {
	    super.paint(arg0);

	  }
		  
	  public boolean buildFinished() {
		  return dictReady;
	  }

	  public boolean packingFinished() {
		  return packed;
	  }
	  
	  public boolean uploadFinished() {
		  return uploadFinished;
	  }

	  public boolean isWorking() {
		  return working;
	  }	  
	  
	  public long getDbSize() {
		  return new File(map.get("localWordsDb") + "words.db").length();
	  }
	  
	  public void init() {
		
		
		String[] paramNames = {"l_select","l_select_words","l_select_phonetic","l_build","l_close","l_dictname","l_encoding",
							"l_encoding","l_name_warning","l_filename_warning","l_phonetic_warning","l_enc_warning","l_filename_nok",
							"l_phonetic_nok","upload_size","upload_url","l_building","l_packing","l_uploading","l_finished","scid"
							};
		
		
		for(int c=0;c<paramNames.length;c++){
			try {
				params.put(paramNames[c], getParameter(paramNames[c]));		
			} catch (Exception e){
				System.err.print("Missing parameter:" + paramNames[c]);
				//e.printStackTrace();
			} 
		}
		final JTextField dictName=new JTextField();
	    final JTextField wFilename=new JTextField();
	    final JTextField pFilename=new JTextField();

	    final JFileChooser fc = new JFileChooser();
	    final JButton addWords = new JButton(params.get("l_select").toString());
	    addWords.setPreferredSize(new Dimension(100,20));
	    		
	    final JButton addPhonet = new JButton(params.get("l_select").toString());
	    addPhonet.setPreferredSize(new Dimension(100,20));
	    
	    final JButton startButton = new JButton(params.get("l_build").toString());
	    final JButton closeButton = new JButton(params.get("l_close").toString());
	    
	    Vector supportedEnc = new Vector(Charset.availableCharsets().values());                
        final JComboBox encodings = new JComboBox(supportedEnc);
        
        statusLabel.setForeground(new Color(0,109,180));
        
        
        final JLabel dictNameLabel = new JLabel(params.get("l_dictname").toString());
        final JLabel encodingLabel = new JLabel(params.get("l_encoding").toString());
        
        String s="";
        int count = -1;
        String denc = BaseUtility.getDefaultEncoding();
        for(Iterator it=supportedEnc.iterator();it.hasNext();s = it.next().toString()) {
        	if(s.equals(denc)) {
        		encodings.setSelectedIndex(count);
        		break;
        	}
        	count++;
        }
        
        encodings.setPreferredSize(new Dimension(300,dictName.getFontMetrics(encodings.getFont()).getHeight()+5));
        	    
	    ActionListener al = new ActionListener() {
		      public void actionPerformed(ActionEvent e) {
		    	
		    	  if (e.getSource() == addWords || e.getSource() == addPhonet) {
		    	        int returnVal = fc.showOpenDialog(DictEditor.this);
		    	        if (returnVal == JFileChooser.APPROVE_OPTION) {
		    	        	if (e.getSource() == addWords) {
		    	        		wFilename.setText(fc.getSelectedFile().getPath());		    	        		
		    	        		
		    	        	} else {
		    	        		pFilename.setText(fc.getSelectedFile().getPath());
		    	        	}
		    	            
		    	        }
		    	   }
		    	  
		    	  if (e.getSource() == startButton) {

		    		if(dictName.getText().equals("")) {		    			
		    			msgBox(params.get("l_name_warning").toString());
		    		}
		    		  
		    		else if(wFilename.getText().equals("")) {
		    			msgBox(params.get("l_filename_warning").toString());		    			
		    			
					}
		    		else if(!(new File(wFilename.getText()).exists())) {
		    			msgBox(params.get("l_filename_nok").toString());		    			
		    			
					}		    		
		    		else if(pFilename.getText().equals("")) {
		    			msgBox(params.get("l_phonetic_warning").toString());
					}
		    		else if(!(new File(pFilename.getText()).exists())) {
		    			msgBox(params.get("l_phonetic_nok").toString());		    			
		    			
					}
		    		else if(encodings.getSelectedItem().toString().equals("")) {
		    			msgBox(params.get("l_enc_warning").toString());
					}
		    		else {
		    			
		    			addWords.setEnabled(false);
		    			addPhonet.setEnabled(false);
		    			startButton.setEnabled(false);
		    			closeButton.setEnabled(false);
		    			
		    			dictName.setEnabled(false);
		    			wFilename.setEnabled(false);
		    			pFilename.setEnabled(false);
		    			encodings.setEnabled(false);
		    			dictNameLabel.setEnabled(false);
		    			encodingLabel.setEnabled(false);
		    			
		    			statusLabel.setText(params.get("l_building").toString());
		    			
		    			getContentPane().repaint();
		    			
		    			final String dict = dictName.getText();
		    			
		    			working = true;
		    			
		    			Thread t = new Thread() {
		    		        public void run() {
		    		            try {
		    					    			
					    			buildDict(dict,wFilename.getText(),pFilename.getText(),encodings.getSelectedItem().toString());		    			
					    			dictReady = true;
					    			
					    			statusLabel.setText(params.get("l_packing").toString());
					    			getContentPane().repaint();
					    			
					    			pack(dict);
					    			packed = true;
					    			
					    			statusLabel.setText(params.get("l_uploading").toString());
					    			getContentPane().repaint();
					    			
					    			upload(params.get("upload_url").toString(),map.get("localDictBase").toString() + dict + ".zip", Long.parseLong(params.get("upload_size").toString()));
					    			uploadFinished = true;
					    			working = false;
					    			
					    			statusLabel.setText(params.get("l_finished").toString());
					    			getContentPane().repaint();
					    			
		    		        } catch (Exception e) {
		  		              e.printStackTrace();
		  		            }
		    		        }
		    			};
		    			
		    			t.start();
		    			
		    		}
		    	  }
		    	  
		    	  if (e.getSource() == closeButton) {

		    		 uploadFinished = true;
		    		  
		    	  }

		      }
		 };	    
	    
		addWords.addActionListener(al);		
		addPhonet.addActionListener(al);
		startButton.addActionListener(al);
		closeButton.addActionListener(al);
		
		
	    wFilename.setPreferredSize(new Dimension(300,wFilename.getFontMetrics(wFilename.getFont()).getHeight()));
	    wFilename.setText(params.get("l_select_words").toString());
	    pFilename.setPreferredSize(new Dimension(300,pFilename.getFontMetrics(pFilename.getFont()).getHeight()));
	    pFilename.setText(params.get("l_select_phonetic").toString());
	    dictName.setPreferredSize(new Dimension(300,dictName.getFontMetrics(dictName.getFont()).getHeight()+5));
	    
		JPanel selectPaneW = new JPanel();		
		selectPaneW.setLayout(new BoxLayout(selectPaneW, BoxLayout.X_AXIS));
		selectPaneW.setAlignmentX(LEFT_ALIGNMENT);
		selectPaneW.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));

		selectPaneW.add(Box.createHorizontalGlue());
		selectPaneW.add(wFilename);
		selectPaneW.add(Box.createRigidArea(new Dimension(10, 0)));
		selectPaneW.add(addWords);
        
		JPanel selectPaneP = new JPanel();		
		selectPaneP.setLayout(new BoxLayout(selectPaneP, BoxLayout.X_AXIS));
		selectPaneP.setAlignmentX(LEFT_ALIGNMENT);
		selectPaneP.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));

        selectPaneP.add(Box.createHorizontalGlue());
        selectPaneP.add(pFilename);
        selectPaneP.add(Box.createRigidArea(new Dimension(10, 0)));
        selectPaneP.add(addPhonet);		
		
		JPanel buttonPane = new JPanel();		
        buttonPane.setLayout(new BoxLayout(buttonPane, BoxLayout.X_AXIS));
        buttonPane.setBorder(BorderFactory.createEmptyBorder(0, 10, 10, 10));    
        buttonPane.add(Box.createHorizontalGlue());
        buttonPane.add(statusLabel);
        buttonPane.add(Box.createRigidArea(new Dimension(100, 0)));
		buttonPane.add(startButton);		
        buttonPane.add(Box.createRigidArea(new Dimension(10, 0)));
        buttonPane.add(closeButton);
	    
        EmptyBorder eb = new EmptyBorder(10,10,10,10);
        //EmptyBorder eb = new EmptyBorder(new Insets(10,10,10,10));
        CompoundBorder cb = new CompoundBorder(eb,BorderFactory.createEtchedBorder());

        JPanel centerPane = new JPanel();        
        centerPane.setLayout(new BorderLayout());
        centerPane.setBorder(cb);
        centerPane.add(selectPaneW,BorderLayout.NORTH);
        centerPane.add(selectPaneP,BorderLayout.SOUTH);

        JPanel headerPane = new JPanel();
        headerPane.setLayout(new BoxLayout(headerPane, BoxLayout.X_AXIS));
        headerPane.setAlignmentX(LEFT_ALIGNMENT);
        headerPane.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));
        headerPane.add(Box.createHorizontalGlue());
        headerPane.add(dictNameLabel);
        headerPane.add(Box.createRigidArea(new Dimension(10, 0)));
        headerPane.add(dictName);

        JPanel encPane = new JPanel(); 
        
        
        encPane.setLayout(new BoxLayout(encPane, BoxLayout.X_AXIS));
        encPane.setAlignmentX(LEFT_ALIGNMENT);
        encPane.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));
        encPane.add(Box.createHorizontalGlue());
        encPane.add(encodingLabel);
        encPane.add(Box.createRigidArea(new Dimension(10, 0)));
        encPane.add(encodings);
        
        
        JPanel footerPane = new JPanel();
        footerPane.setLayout(new BorderLayout());
        footerPane.add(encPane,BorderLayout.NORTH);        
        footerPane.add(buttonPane,BorderLayout.SOUTH);
        
        getContentPane().add(headerPane,BorderLayout.NORTH);
        getContentPane().add(centerPane,BorderLayout.CENTER);        
		getContentPane().add(footerPane,BorderLayout.SOUTH);
        
	  }
	  
	  protected void buildDict(String dict,String wordFilename,String phonetFilename,String enc) {
		  
		  File words = new File(wordFilename);
		  File phonetic = new File(phonetFilename);
		  
		  map = BaseUtility.createBase(dict);
		  BaseUtility.createBaseFiles(map);
		  
		  CopyUtility.copyTextFile(words,new File(map.get("localWords").toString() + dict),enc,defEncoding,"/");
		  CopyUtility.copyTextFile(phonetic,new File(map.get("localDictBase").toString() + dict + ".phonet"),enc,defEncoding,null);
		  
		  satusR.start();
		  
		  try {
			newDict = new SpellDictionaryEncDisk(new File(map.get("localDictBase").toString()),new File(map.get("localDictBase").toString()+dict+".phonet"),true,defEncoding);
			newDict.buildDict(true);
	      } catch(IOException ex) {
		   	ex.printStackTrace();
		  }
	      
	  }
	  	  
	  protected void pack(String dict) {
		  //System.out.println(map.get("localDictBase").toString() + dict + ".zip");
		  File zipFile = new File(map.get("localDictBase").toString() + dict + ".zip");
		  if(!zipFile.exists()) {
			  try {
				  zipFile.createNewFile();
			  } catch(IOException ex) {
				   	ex.printStackTrace();
			  }
		  }
	      ArrayList files = new ArrayList();
		  files.add(map.get("localWordsDb").toString() + "words.db");
		  files.add(map.get("localWordsDb").toString() + "words.idx");
		  files.add(map.get("localDictBase").toString() + dict + ".phonet");
		  
		  CopyUtility.pack(zipFile, files);		  
		  
	  }
	  
	  protected void upload(String url,String filename,long chunksize) {
		  
		  String sep = System.getProperty("file.separator");
		  String localDir = System.getProperty("user.home")+sep+".livinge"+sep+"spellchecker"+sep;
		  String chunkName = localDir + "upload";

		  File chunkFile = new File(chunkName);
		  
		  if(chunkFile.exists()) {
			  chunkFile.delete();
		  }
		  
		  long offset = 0;
		  long size=0;
		  Uploader up = new Uploader();
 
		  File upFile = new File(filename); 
		  
		  //System.out.println("SCID:" + params.get("scid").toString());
		  
		  up.addVariable("scid",params.get("scid").toString());
		  
		  up.addVariable("cmd[0]", "removeDictFile");
		  up.addVariable("cmd[1]", upFile.getName());		  
		  up.upload(url);
		  		  
		  up.addVariable("cmd[0]", "uploadPart");
		  up.addVariable("cmd[1]", upFile.getName());
		  
		  up.addFile("chunk", chunkName);

		  try {
			  
			  while((size=CopyUtility.copyPart(filename,chunkName,offset,chunksize))>0) {
				  up.addVariable("cmd[2]", Long.toString(CopyUtility.getCRC(chunkFile)));
				  up.upload(url);
				  offset += size;
			  }

			  if(chunkFile.exists()) {
				  chunkFile.delete();
			  }
			  
		  }catch(Exception er){
			  er.printStackTrace();
		  }
	  }
	  	  	  
	  protected void msgBox(String s) {
		  JOptionPane.showMessageDialog(getContentPane(), s);
	  }
	  
	  public void destroy() {
		  runThreads=false;
		  try {
				Thread.sleep(2*threadTick);
		} catch (Exception e) {
				e.printStackTrace();
				System.exit(1);
		}
	  }	  
	  
	  class StatusRun extends Thread {
			public void run() {
				while (runThreads) {
					
					statusLabel.setText(params.get("l_building").toString() + " " + Long.toString((new File((map.get("localWordsDb").toString()) + "words.db").length()/1024)) + " KB");
					getContentPane().repaint();
					
					try {
						Thread.sleep(threadTick);
					} catch (Exception e) {
						e.printStackTrace();
						System.exit(1);
					}
				}
			}
		}
	  
	  
	  
}
	

