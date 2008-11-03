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

package com.livinge.eplugin.gui;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Component;
import java.awt.Dimension;
import java.awt.Label;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.util.Vector;

import javax.swing.BorderFactory;
import javax.swing.Box;
import javax.swing.BoxLayout;
import javax.swing.DefaultListModel;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JList;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextField;
import javax.swing.ListCellRenderer;
import javax.swing.ListSelectionModel;
import javax.swing.border.CompoundBorder;
import javax.swing.border.EmptyBorder;

import com.livinge.eplugin.editor.EPDocument;
import com.livinge.eplugin.editor.WeEditor;
import com.livinge.eplugin.editor.WeSettings;

public class EPEditorDialog extends JFrame implements ActionListener {
										 	
	static final long serialVersionUID = -1611200117062004001L;
	
	private static final int MODE_EDITOR = 1;
	
    private JPanel listPane;
    private JButton choseButton;
    private JTextField chosePath;
    private JTextField choseArgs;
    
    private JButton startButton;
    private JButton closeButton;
    private JButton clearButton;
    private JButton addButton;
    private JButton editButton;
    private JButton delButton;
    
    
    private JCheckBox showAllEditors; 
    private JCheckBox autoStart;
    
    private JFileChooser fileSelector;
    private WeSettings weSettings;
    //private String sourceFile;
    //private String contentType;
    
    private JList editorList;
 
	private DefaultListModel listModel = new DefaultListModel();
    private Vector listVector = new Vector();
    
    protected EPDocument epDoc;
    protected int mode = MODE_EDITOR;
    protected WeEditor selectedEditor;
    
    public EPEditorDialog(EPDocument doc,WeSettings weset,int m) {
   		epDoc = doc;
    	weSettings=weset;
    	mode = m; 
    	buildGUI();
    	setTitle(weSettings.getParam("lan_main_dialog_title"));
    }
    
    
    protected void buildGUI() {
    	    	
    	EmptyBorder eb = new EmptyBorder(10,10,10,10);
        //BevelBorder bb = new BevelBorder(BevelBorder.RAISED);
        
        CompoundBorder cb = new CompoundBorder(eb,BorderFactory.createEtchedBorder());
    	
    	this.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		
		chosePath=new JTextField(weSettings.getParam("lan_select_text"));
		
		chosePath.setPreferredSize(new Dimension(300,chosePath.getFontMetrics(chosePath.getFont()).getHeight()));
		chosePath.addActionListener(this);
		
		choseArgs=new JTextField(weSettings.getParam("lan_args"));
		
		choseArgs.setPreferredSize(new Dimension(100, choseArgs.getFontMetrics(choseArgs.getFont()).getHeight()));
		choseArgs.addActionListener(this);		
		
		choseButton = new JButton(weSettings.getParam("lan_select_button"));
		//choseButton.setPreferredSize(new Dimension(100,20));
		choseButton.addActionListener(this);

		editorList=new JList(listModel);
		
    	CellRenderer renderer= new CellRenderer();
		renderer.setPreferredSize(new Dimension(200, 100));
		
		editorList.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
		editorList.setSelectionBackground(new Color(223,233,245));
		editorList.setCellRenderer(renderer);
		editorList.setAlignmentX(Label.LEFT_ALIGNMENT);
		
		editorList.addMouseListener(new MouseAdapter() {
			
            public void mouseClicked(MouseEvent e) {
       
            	if (e.getClickCount() == 1) {
            		if(editorList.getSelectedIndex()>-1) {
	            		selectedEditor =  (WeEditor)listVector.elementAt(editorList.getSelectedIndex());
	            		chosePath.setText(selectedEditor.Path);
	            		choseArgs.setText(selectedEditor.Args);
	                    editButton.setEnabled(true);
	                    delButton.setEnabled(true);
            		}
                }
            	if ((e.getClickCount())==2 && (mode==MODE_EDITOR)) {
            		if(editorList.getSelectedIndex()>-1) {
	            		selectedEditor =  (WeEditor)listVector.elementAt(editorList.getSelectedIndex());
						chosePath.setText(selectedEditor.Path);
						choseArgs.setText(selectedEditor.Args);
	                	lunchEditor();
            		}
                }
            }
        });
		
		refreshListModel(epDoc.getContentType());
		
		closeButton= new JButton(weSettings.getParam("lan_close_button"));
		closeButton.addActionListener(this);
		
		clearButton= new JButton(weSettings.getParam("lan_clear_button"));
		clearButton.addActionListener(this);		
		
		showAllEditors = new JCheckBox(weSettings.getParam("lan_showall_label"));
		showAllEditors.addActionListener(this);
		
		addButton = new JButton(weSettings.getParam("lan_add_button"));
		addButton.addActionListener(this);
		addButton.setEnabled(true);
		
		editButton = new JButton(weSettings.getParam("lan_edit_button"));
		editButton.addActionListener(this);
		editButton.setEnabled(false);
		
		delButton = new JButton(weSettings.getParam("lan_del_button"));
		delButton.addActionListener(this);
		delButton.setEnabled(false);
		
		JScrollPane listScroller = new JScrollPane(editorList);
		listScroller.setPreferredSize(new Dimension(250, 370));

	    listScroller.setMinimumSize(new Dimension(250, 370));
	    listScroller.setAlignmentX(LEFT_ALIGNMENT);		
		
		listPane = new JPanel();
		listPane.setLayout(new BorderLayout());
        listPane.add(Box.createRigidArea(new Dimension(0,5)));
        listPane.add(listScroller,BorderLayout.CENTER);
        listPane.setBorder(BorderFactory.createEmptyBorder(10,10,10,10));

        JPanel toolButtonsPane = new JPanel();
        toolButtonsPane.setLayout(new BorderLayout());
        toolButtonsPane.setBorder(BorderFactory.createEmptyBorder(10,0,0,0));

        JPanel toolsPane = new JPanel();
        toolsPane.setLayout(new BoxLayout(toolsPane, BoxLayout.X_AXIS));
        
        toolsPane.add(addButton);
        toolsPane.add(Box.createRigidArea(new Dimension(5, 0)));
        toolsPane.add(editButton);
        toolsPane.add(Box.createRigidArea(new Dimension(5, 0)));
        toolsPane.add(delButton);
        toolsPane.add(Box.createRigidArea(new Dimension(5, 0)));
        toolsPane.add(clearButton);        
        toolsPane.add(Box.createRigidArea(new Dimension(10, 0)));
        
        toolButtonsPane.add(toolsPane, BorderLayout.WEST);
        
        if(mode==MODE_EDITOR) {
        	toolButtonsPane.add(showAllEditors, BorderLayout.EAST);
        } else {
        	toolButtonsPane.add(Box.createRigidArea(new Dimension(150, 0)), BorderLayout.EAST);
        }
        
        listPane.add(toolButtonsPane,BorderLayout.SOUTH);
        
        JPanel centerPane = new JPanel();        
        centerPane.setLayout(new BorderLayout());
        centerPane.setBorder(cb);
        centerPane.add(listPane,BorderLayout.NORTH);

        if(mode==MODE_EDITOR) {
        
			JPanel selectPane = new JPanel();		
			selectPane.setLayout(new BoxLayout(selectPane, BoxLayout.X_AXIS));
			selectPane.setAlignmentX(LEFT_ALIGNMENT);
			selectPane.setBorder(BorderFactory.createEmptyBorder(0, 10, 10, 10));
	
			JLabel label2 = new JLabel();
	        label2.setLabelFor(selectPane);		
	
			selectPane.add(Box.createHorizontalGlue());
			selectPane.add(chosePath);
			selectPane.add(choseArgs);
			selectPane.add(Box.createRigidArea(new Dimension(10, 0)));
			selectPane.add(choseButton);
			centerPane.add(selectPane,BorderLayout.SOUTH);
        
        }
		
        JPanel buttonPane = new JPanel();		
        buttonPane.setLayout(new BoxLayout(buttonPane, BoxLayout.X_AXIS));
        buttonPane.setBorder(BorderFactory.createEmptyBorder(0, 20, 10, 10));
        
        if(mode==MODE_EDITOR) {
        	startButton= new JButton(weSettings.getParam("lan_start_button"));
    		startButton.addActionListener(this);
        	buttonPane.add(Box.createHorizontalGlue());
        	buttonPane.add(startButton);		
        	buttonPane.add(Box.createRigidArea(new Dimension(10, 0)));
        }
        
        buttonPane.add(closeButton);
        
        autoStart = new JCheckBox(weSettings.getParam("lan_autostart_label"));
        autoStart.addActionListener(this);
        autoStart.setSelected(weSettings.getSetting("askForEditor").equals("true") ? false : true);
        
        JPanel bottomPane = new JPanel();
        bottomPane.setLayout(new BorderLayout());
        bottomPane.setBorder(new EmptyBorder(0,10,10,10));
        bottomPane.add(autoStart,BorderLayout.WEST);
        bottomPane.add(buttonPane,BorderLayout.EAST);
               
        bottomPane.add(new JLabel("Build: " + weSettings.getVersion()),BorderLayout.EAST);
        
        getContentPane().add(centerPane,BorderLayout.CENTER);        
		getContentPane().add(bottomPane,BorderLayout.SOUTH);

	    int windowHeight = 640;
	    int windowWidth = 640;
		
        Dimension screenSize =Toolkit.getDefaultToolkit().getScreenSize();
         int w = windowWidth + 10;
         int h = windowHeight + 10;
         this.setLocation(screenSize.width/3 - w/2,screenSize.height/2 - h/2);
         this.setSize(w, h);
         this.setResizable(false);
    	
    }
    
    
    
    protected void loadEditorList(String ct) {
    	weSettings.loadEditorList(epDoc.getCacheFilename(),epDoc.getContentType());
    	
    	listVector = weSettings.getEditorList(ct);
    }
    
    public void refreshListModel(String ct) {
    	
    	loadEditorList(ct);
    	
    	int size = listVector.size();    	
    	listModel.removeAllElements();
		for (int i = 0; i < size; i++) {
			listModel.addElement(new Integer(i));
		}

    }
    
    
    public void reloadEditorList(){
    	if(showAllEditors.isSelected()) {
    		refreshListModel("");
    	} else {
    		refreshListModel(epDoc.getContentType());
    	}
    	editorList.repaint();
    }
    
    /** Returns an ImageIcon, or null if the path was invalid. */
    protected static ImageIcon createImageIcon(String path) {
        java.net.URL imgURL = EPEditorDialog.class.getResource(path);
        if (imgURL != null) {
            return new ImageIcon(imgURL);
        } else {
            System.err.println("Couldn't find file: " + path);
                return null;
        }
    }    
    
    private void lunchEditor(){
    	
    	String editor=chosePath.getText();
    	String args = choseArgs.getText();
    	
    	if(selectedEditor!=null) {
    		
    		selectedEditor.Path = chosePath.getText();
    		
    	} else {
    		
    		selectedEditor=new WeEditor();
    		selectedEditor.init(editor,editor,args,epDoc.getContentType(),"","");
        	
    	}
		
    	int exitVal=selectedEditor.start(epDoc);
    	
		if(exitVal==0){
			if(!weSettings.editorExists(editor)){
				weSettings.addToDefaultEditors(selectedEditor);
				weSettings.saveDefaultEditorList();
			}
			this.setVisible(false);
		}
		else{
	    	JOptionPane.showMessageDialog(
	    			this,
	                weSettings.getParam("lan_alert_noeditor_text"),	                
					weSettings.getParam("lan_alert_noeditor_title"),
					JOptionPane.ERROR_MESSAGE
			);
			
		}
    }
	
    public void actionPerformed(ActionEvent e) {
        if (e.getSource() == choseButton) {
        	fileSelector = new JFileChooser();
        	int returnVal = fileSelector.showOpenDialog(choseButton.getParent());
        	
            if (returnVal == JFileChooser.APPROVE_OPTION) {
            	String selected=fileSelector.getSelectedFile().getPath();
            	chosePath.setText(selected);
            	choseArgs.setText("");
            } else {

            }
        }
        
        if (e.getSource() == addButton) {
        	EPPropDialog propDialog = new EPPropDialog(weSettings, new WeEditor(),this);
			propDialog.pack();
			propDialog.setVisible(true);
        }
        
        if (e.getSource() == startButton) {
        	lunchEditor();
        }
                
        if (e.getSource() == closeButton) {
        	this.setVisible(false);
        }
        
        if (e.getSource() == clearButton) {
        	 if (JOptionPane.showConfirmDialog(this,
     		        weSettings.getParam("lan_clear_question"), weSettings.getParam("lan_question"), 
     		        JOptionPane.YES_NO_OPTION)
     		     == JOptionPane.YES_OPTION) {
     		  
        		 ((javax.swing.DefaultListModel) editorList.getModel()).clear();
             	weSettings.clearList();  
     		  
     	  }
        	
        }
        
        if(e.getSource() == editButton){
        	EPPropDialog propDialog = new EPPropDialog(weSettings,(WeEditor)listVector.get(editorList.getSelectedIndex()),this);
			propDialog.pack();
			propDialog.setVisible(true);
        }        
        
        if(e.getSource() == delButton){
        	
        	  if (JOptionPane.showConfirmDialog(this,
        		        weSettings.getParam("lan_del_question"), weSettings.getParam("lan_question"), 
        		        JOptionPane.YES_NO_OPTION)
        		     == JOptionPane.YES_OPTION) {
        		  
        		  
        		  weSettings.removeFromDefaultEditorList((WeEditor)listVector.elementAt(editorList.getSelectedIndex()));
        		 
    	          reloadEditorList();
        		  
        	  }
        	
        	
        }
        
        if (e.getSource() == showAllEditors) {
        	
        	reloadEditorList();
        }
        
        if (e.getSource() == autoStart) {
        	
        	if(autoStart.isSelected()) {
        		weSettings.setSetting("askForEditor", "false");
        	} else {
        		weSettings.setSetting("askForEditor", "true");
        	}
        	weSettings.saveSettings();
        	
        }
        
    }
    
    class CellRenderer extends JLabel
                           implements ListCellRenderer {
		


		public CellRenderer() {
            setOpaque(true);
            setHorizontalAlignment(LEFT);
            setVerticalAlignment(CENTER);
        }

       
        public Component getListCellRendererComponent(
                                           JList list,
                                           Object value,
                                           int index,
                                           boolean isSelected,
                                           boolean cellHasFocus) {

            int selectedIndex = ((Integer)value).intValue();

            if (isSelected) {
                setBackground(list.getSelectionBackground());
                setForeground(list.getSelectionForeground());
            } else {
                setBackground(list.getBackground());
                setForeground(list.getForeground());
            }

			if(listVector.size()>selectedIndex) {

				WeEditor editor=(WeEditor)listVector.elementAt(selectedIndex);
				
	            String text = "<html>" +
	            	"			<table>" +
	            	"				<tr>" +
	            	"					<td>" +
	            	"						&nbsp;&nbsp;</td>" +
	            	"					<td></td>" +
	            	"					<td>" +
	            	"						<font color='black' size='5'><b>"+editor.Name+"</b></font><br>" +
	            	"						<font color='gray' size='3'><i>"+editor.Path+"</i></font><br>" +
	            	(editor.ContentType!=null ? (editor.ContentType.trim().length()>0 ? "						<font color='black'>"+weSettings.getParam("lan_contenttypes")+": "+editor.ContentType+"</font><br>": "") : "") +        
					(editor.DefaultFor!=null ? (editor.DefaultFor.trim().length()>0 ? "						<font  size='3' color='back'><i>"+weSettings.getParam("lan_default_for")+": "+editor.DefaultFor+"</i></font><br>": "") : "") +
					(editor.Encoding!=null ? (editor.Encoding.trim().length()>0 ? "						<font  size='2' color='back'>"+weSettings.getParam("lan_encoding")+": "+editor.Encoding+"</font>": "") : "") +
	            	"					</td>" +
	            	"				</tr>" +
	            	"			</table>" +
	            	"		</html>";

				setText(text);
				setFont(list.getFont());

			}

            return this;
        }

    }
    
	
}