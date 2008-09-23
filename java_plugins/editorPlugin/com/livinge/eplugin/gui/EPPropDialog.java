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

import java.awt.BorderLayout;
import java.awt.Component;
import java.awt.Dimension;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.nio.charset.Charset;
import java.util.Iterator;
import java.util.Vector;

import javax.swing.BorderFactory;
import javax.swing.Box;
import javax.swing.BoxLayout;
import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextField;
import javax.swing.border.CompoundBorder;
import javax.swing.border.EmptyBorder;

import com.livinge.eplugin.editor.WeEditor;
import com.livinge.eplugin.editor.WeSettings;

public class EPPropDialog extends JFrame implements ActionListener {
	
	static final long serialVersionUID = -1611200117062004003L;
	
	private WeSettings weSettings;
	
	private JTextField nameText;
	private JTextField pathText;
	private JTextField argsText;
	//private JTextField iconText;
	private JTextField contentTypeText;
	private JTextField defaultForText;
	
	private JButton cancelButton;
	private JButton saveButton;
	private JButton pathButton;
	
	private JComboBox contentTypeBox;
	
	private JComboBox defaultForBox;
	
	private JComboBox encodingBox;
	
	private EPEditorDialog parentFrame;
	
	public EPPropDialog(WeSettings wesettings,WeEditor editor,EPEditorDialog parent){
		
		//Index = index;
		weSettings = wesettings;		
		parentFrame=parent;
		
		String Name = "";
		String Path = "";
		String Args = "";
		String ContentType = "";
		String DefaultFor = "";	
		String Encoding = WeSettings.getDefaultEncoding();
		
		Name = editor.Name;
		Path = editor.Path;
		Args = editor.Args;
		ContentType = (editor.ContentType==null) ? weSettings.lastContentType : editor.ContentType;
		DefaultFor = editor.DefaultFor;
		Encoding = editor.Encoding;
		

		EmptyBorder eb = new EmptyBorder(10,10,10,10);
		//BevelBorder bb = new BevelBorder(BevelBorder.RAISED);
		//BorderFactory.createTitledBorder("Editor properties");
		CompoundBorder cb = new CompoundBorder(eb,BorderFactory.createEtchedBorder());
		//CompoundBorder cb = new CompoundBorder(eb,BorderFactory.createTitledBorder("Editor properties"));
		
		int textFieldSize = 32;
		
		nameText = new JTextField(Name,textFieldSize);
		JLabel nameLabel = new JLabel(weSettings.getParam("lan_editor_name"));				

		pathText = new JTextField(Path,textFieldSize);
		JLabel pathLabel = new JLabel(weSettings.getParam("lan_path")); 
		pathButton = new JButton("...");
		pathButton.addActionListener(this);
		
		argsText = new JTextField(Args,textFieldSize);
		JLabel argsLabel = new JLabel(weSettings.getParam("lan_args")); 
		
		
		JPanel namePane = new JPanel();
		namePane.setLayout(new BoxLayout(namePane, BoxLayout.X_AXIS));
		namePane.add(nameText);
		
		JPanel pathPane = new JPanel();
		pathPane.setLayout(new BoxLayout(pathPane, BoxLayout.X_AXIS));
		pathPane.add(pathText);
		pathPane.add(pathButton);

		JPanel argsPane = new JPanel();
		argsPane.setLayout(new BoxLayout(argsPane, BoxLayout.X_AXIS));
		argsPane.add(argsText);

		
		// Content types
		
		Vector contentTypes = new Vector(); 
		contentTypes = (Vector)weSettings.getContentTypes();
		contentTypes.insertElementAt("",0);
		
		contentTypeText = new JTextField(ContentType,textFieldSize);
		contentTypeText.setText(ContentType);
		contentTypeBox = new JComboBox(contentTypes);
		contentTypeBox.setPreferredSize(new Dimension(200,10));
		contentTypeBox.addActionListener(this);
		JLabel contentTypeLabel = new JLabel(weSettings.getParam("lan_contenttypes"));
				
		JPanel contentTypePane = new JPanel();
		contentTypePane.setLayout(new BoxLayout(contentTypePane, BoxLayout.X_AXIS));
		contentTypePane.add(contentTypeText);
		contentTypePane.add(Box.createRigidArea(new Dimension(5, 0)));
		contentTypePane.add(contentTypeBox);
		
		// Default editor for content type
		defaultForText = new JTextField(DefaultFor,textFieldSize);
		defaultForBox = new JComboBox();
		defaultForBox.setPreferredSize(new Dimension(200,10));
		addItems(defaultForBox,","+ContentType);
		defaultForBox.addActionListener(this);
		JLabel defaultForBoxLabel = new JLabel(weSettings.getParam("lan_defaultfor_label"));
		
		JPanel defaultForPane = new JPanel();
		defaultForPane.setLayout(new BoxLayout(defaultForPane, BoxLayout.X_AXIS));
		defaultForPane.add(defaultForText);
		defaultForPane.add(Box.createRigidArea(new Dimension(5, 0)));
		defaultForPane.add(defaultForBox);
		
		// Encoding panel
		encodingBox = new JComboBox();
		encodingBox.setPreferredSize(new Dimension(200,10));
		Vector supportedEnc = new Vector(Charset.availableCharsets().values());
		supportedEnc.insertElementAt("", 0);
		encodingBox = new JComboBox(supportedEnc);

        String s="";
        int count = -1;
        for(Iterator it=supportedEnc.iterator();it.hasNext();s = it.next().toString()) {        	
        	if(s.equals(Encoding)) {
        		encodingBox.setSelectedIndex(count);
        		break;
        	}
        	count++;
        }
		
		encodingBox.addActionListener(this);
		JPanel encodingPane = new JPanel();
		encodingPane.setLayout(new BoxLayout(encodingPane, BoxLayout.X_AXIS));
		encodingPane.add(encodingBox);
		JLabel encodingLabel = new JLabel(weSettings.getParam("lan_encoding"));
		
		
		// Main panel
		JPanel mainPane = new JPanel();
		mainPane.setLayout(new BorderLayout());
		mainPane.setBorder(cb);
		
		JPanel centerPane = new JPanel();				
		centerPane.setLayout(new BoxLayout(centerPane, BoxLayout.PAGE_AXIS));
		centerPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 10, 15));
		centerPane.setAlignmentY(JPanel.LEFT_ALIGNMENT);
		
		nameLabel.setAlignmentX(Component.LEFT_ALIGNMENT);
		namePane.setAlignmentX(Component.LEFT_ALIGNMENT);
		pathLabel.setAlignmentX(Component.LEFT_ALIGNMENT);
		pathPane.setAlignmentX(Component.LEFT_ALIGNMENT);
		argsLabel.setAlignmentX(Component.LEFT_ALIGNMENT);
		argsPane.setAlignmentX(Component.LEFT_ALIGNMENT);
		contentTypeLabel.setAlignmentX(Component.LEFT_ALIGNMENT);
		contentTypePane.setAlignmentX(Component.LEFT_ALIGNMENT);
		defaultForPane.setAlignmentX(Component.LEFT_ALIGNMENT);
		encodingPane.setAlignmentX(Component.LEFT_ALIGNMENT);
		
		centerPane.add(Box.createRigidArea(new Dimension(10, 10)));
		centerPane.add(nameLabel);		
		centerPane.add(namePane);
		centerPane.add(Box.createRigidArea(new Dimension(10, 10)));
		centerPane.add(pathLabel);		
		centerPane.add(pathPane);
		centerPane.add(argsLabel);		
		centerPane.add(argsPane);
		
		centerPane.add(Box.createRigidArea(new Dimension(10, 10)));
		centerPane.add(contentTypeLabel);
		centerPane.add(contentTypePane);
				
		centerPane.add(Box.createRigidArea(new Dimension(10, 10)));
		centerPane.add(defaultForBoxLabel);
		centerPane.add(defaultForPane);
		
		centerPane.add(Box.createRigidArea(new Dimension(10, 10)));
		centerPane.add(encodingLabel);
		centerPane.add(encodingPane);
		
		
		mainPane.add(centerPane,BorderLayout.CENTER);
		
		cancelButton = new JButton(weSettings.getParam("lan_close_button"));		
		cancelButton.addActionListener(this);
		cancelButton.setAlignmentX(Component.RIGHT_ALIGNMENT);
		
		saveButton = new JButton(weSettings.getParam("lan_save_button"));
		saveButton.addActionListener(this);
		saveButton.setAlignmentX(Component.RIGHT_ALIGNMENT);
		
		Box box = Box.createHorizontalBox();
		box.add(Box.createHorizontalGlue());
		box.add(saveButton);
		box.add(Box.createHorizontalStrut(5));
		box.add(cancelButton);
		box.setBorder(BorderFactory.createEmptyBorder(0,20,10,10));
		  
		getContentPane().add(mainPane,BorderLayout.NORTH);        
		getContentPane().add(box, BorderLayout.SOUTH);
		
		int windowHeight = 320;
		int windowWidth = 320;

		Dimension screenSize =Toolkit.getDefaultToolkit().getScreenSize();
		int w = windowWidth + 10;
		int h = windowHeight + 10;
		this.setLocation(screenSize.width/3 - w/2,screenSize.height/2 - h/2);
		this.setSize(w, h);
		this.setTitle(weSettings.getParam("lan_editor_prop"));
		this.setResizable(false);
		 		
	}
	
	private void addItems(JComboBox combo,String items)  {
		
		String arr[] = items.split(",");
		String it;
		
		for(int i = 0;i<arr.length;i++) {
			it = (arr[i].trim());
			if(!hasItem(combo,it)) {
				combo.addItem(new String(it));
			}
		}
		
	 }
	
	private boolean hasItem(JComboBox combo,String item) {
		
		String s;
		int c = defaultForBox.getItemCount();
		
		for(int i = 0;i<c;i++) {
			s = (String)combo.getItemAt(i);
			if(s.equals(item)) {
				return true;
			} 
		}
		return false;
		
	}
	
	private boolean inList(String list,String item) {
		
		String arr[] = list.split(",");
		String it;
		
		for(int i = 0;i<arr.length;i++) {
			it = (arr[i].trim());
			if(item.equals(it)) {
				return true;
			}
		}
		return false;
		
	}
	
	public void actionPerformed(ActionEvent e) {

		if (e.getSource() == cancelButton) {
        	this.dispose();
		}

		if (e.getSource() == pathButton) {
			JFileChooser fileSelector = new JFileChooser();
			int returnVal = fileSelector.showOpenDialog(pathButton.getParent());        	
			if (returnVal == JFileChooser.APPROVE_OPTION) {
				String selected=fileSelector.getSelectedFile().getPath();
				pathText.setText(selected);
			}			
		}		

		if (e.getSource() == contentTypeBox) {
			String text = contentTypeText.getText();
			String selected = (String)contentTypeBox.getSelectedItem();
			if(!inList(text,selected)) {
				if(!selected.matches("")){
					if(!text.matches("")) {
						text+=","+selected;
					}
					else {
						text=selected;
					}
					addItems(defaultForBox,text);
					contentTypeText.setText(text);					
				}
				
			}
			contentTypeBox.setSelectedItem("");
		}
		
		if (e.getSource() == defaultForBox) {
			String text = defaultForText.getText();
			String selected = (String)defaultForBox.getSelectedItem();
			if(!inList(text,selected)) {
				if(!selected.matches("")){
					if(!text.matches("")) {
						text+=","+selected;
					}
					else {
						text=selected;
					}
					
					defaultForText.setText(text);
				}
			}
			defaultForBox.setSelectedItem("");
		}
		
		if (e.getSource() == saveButton) {		

			WeEditor editor = new WeEditor();

			Object enc = encodingBox.getSelectedItem();
			
			editor.init(nameText.getText(),pathText.getText(),argsText.getText(),contentTypeText.getText(),defaultForText.getText(),(enc!=null ? enc.toString() : ""));
			
			if(weSettings.isInDefaultEditorList(editor)) {
			
				weSettings.replaceEditor(editor);
			}
			else {
				weSettings.addToDefaultEditors(editor);
			}
			weSettings.saveDefaultEditorList();
			this.dispose();
			parentFrame.reloadEditorList();
		}
		
		        
	}

}