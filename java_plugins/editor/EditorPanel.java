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
import java.awt.Font;
import java.awt.FontMetrics;
import java.awt.Graphics;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.AdjustmentEvent;
import java.awt.event.AdjustmentListener;
import java.awt.event.KeyAdapter;
import java.awt.event.KeyEvent;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;

import javax.swing.AbstractAction;
import javax.swing.Action;
import javax.swing.ActionMap;
import javax.swing.DefaultListModel;
import javax.swing.JComponent;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextPane;
import javax.swing.KeyStroke;
import javax.swing.event.UndoableEditEvent;
import javax.swing.event.UndoableEditListener;
import javax.swing.text.DefaultEditorKit;
import javax.swing.text.DefaultStyledDocument;
import javax.swing.text.Document;
import javax.swing.text.EditorKit;
import javax.swing.text.SimpleAttributeSet;
import javax.swing.text.StyleConstants;
import javax.swing.text.StyleContext;
import javax.swing.text.StyledEditorKit;
import javax.swing.text.TabSet;
import javax.swing.text.TabStop;
import javax.swing.undo.CannotRedoException;
import javax.swing.undo.CannotUndoException;
import javax.swing.undo.UndoManager;

public class EditorPanel extends JPanel
{
/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	// for this simple experiment, we keep the pane + scrollpane as members.
	
	JTextPane pane;
	JScrollPane scrollPane;
	Font NrPanelFont;
	EditorPanel panel;
	LineNumberPanel lineNumbers;
	
	Editor applet;
	
	DefaultListModel suggestedTags;
	DefaultListModel attribsForTag;
	
	TagSuggestor tSuggestor;
	AttribSuggestor aSuggestor;
	
	String tagName = null;
	String attribName = null;
	
	Action defaultDownAction = null;
	
	SuggestorController suggestorController = null;
	
	private Parameter parameter;
	
	public EditorPanel(final Editor applet) {
		super();
		
		setLayout(new BorderLayout());
		this.applet = applet;
		
		suggestedTags = new DefaultListModel();
		attribsForTag = new DefaultListModel();
		
		
		panel = this;
		

		StyleContext sc = new StyleContext();
		DefaultStyledDocument doc = new DefaultStyledDocument(sc);

		// we need to override paint so that the line numbers stay in sync
		pane = new JTextPane(doc) {		
			/**
			 * 
			 */
			private static final long serialVersionUID = 1L;

			public void paint(Graphics g) {
				super.paint(g);
				if (tSuggestor.isVisible()) {
					tSuggestor.repaint();
				} else if (aSuggestor.isVisible()) {
					aSuggestor.repaint();
				}
			}
			
		};
		
		JPanel p = new JPanel(new BorderLayout());
		p.add(pane);
		
		scrollPane = new JScrollPane(p);
		Parameter parameter = Parameter.getInstance();
		
		scrollPane.getVerticalScrollBar().setUnitIncrement(parameter.getFontSize()+1);

		lineNumbers = new LineNumberPanel(pane);
		
		suggestorController = new SuggestorController(pane, applet, lineNumbers);
		
		tSuggestor = suggestorController.getTagSuggestor();
		aSuggestor = suggestorController.getAttribSuggestor();
		
		
		EditorKit editorKit = new StyledEditorKit() {
			/**
			 * 
			 */
			private static final long serialVersionUID = 1L;

			public Document createDefaultDocument()
			{
				return new SyntaxDocument(applet, panel);
			}
		};

		parameter = Parameter.getInstance();
		String contentType = parameter.getContentType();
		
		if (contentType.equals("text/weTmpl")) {
			pane.setEditorKitForContentType(contentType, editorKit);
			pane.setContentType(contentType);
		}
		
		ActionMap am = pane.getActionMap();
		am.put(DefaultEditorKit.insertBreakAction, new IndentBreakAction());
		
		defaultDownAction = am.get(DefaultEditorKit.downAction);
		
		
		
		
		
		add(lineNumbers, BorderLayout.WEST);
				
		class MyAdjustmentListener implements AdjustmentListener {
	        public void adjustmentValueChanged(AdjustmentEvent evt) {
	        	tSuggestor.hideSuggestor();
	        	aSuggestor.hideSuggestor();
	        }
	    }
		AdjustmentListener listener = new MyAdjustmentListener();
		scrollPane.getVerticalScrollBar().addAdjustmentListener(listener);
		scrollPane.getHorizontalScrollBar().addAdjustmentListener(listener);

		add(tSuggestor);
		add(aSuggestor);
		add(scrollPane);
		
		
		pane.setFont(new Font(parameter.getFontName(), Font.PLAIN, parameter.getFontSize()));
		setTabs(pane, 4);

		pane.addKeyListener(new KeyAdapter() {
			
			boolean ctrlPressed = false;
			
            public void keyReleased(KeyEvent e) {
            	if (e.getKeyCode() == KeyEvent.VK_CONTROL) {
            		ctrlPressed = false;
            	}
            }
            public void keyTyped(KeyEvent e) {
            }
 
            public void keyPressed(KeyEvent e) {
            	if (e.getKeyCode() == KeyEvent.VK_CONTROL) {
            		ctrlPressed = true;
            	}
               	if (ctrlPressed && e.getKeyCode() == KeyEvent.VK_S) {
               		applet.sendCtrlS();
               	}
           }
		});
		
        pane.addMouseListener(new MouseAdapter() {
            public void mouseClicked(MouseEvent e) {
            }

            public void mousePressed(MouseEvent e) {
            	if (tSuggestor.isVisible()) {
            		tSuggestor.hideSuggestor();
            	}
            	if (aSuggestor.isVisible()) {
            		aSuggestor.hideSuggestor();
            	}
            }

            public void mouseReleased(MouseEvent e) {
            }

            public void mouseEntered(MouseEvent e) {
            }

            public void mouseExited(MouseEvent e) {
            }
        });
        
        
        
        
   		
	
	}
	
	
	
	// The Undo action
	  public class UndoAction extends AbstractAction {
	    /**
		 * 
		 */
		private static final long serialVersionUID = 1L;

		public UndoAction(UndoManager manager, LineNumberPanel ln) {
	      this.manager = manager;
	      this.lineNumbers = ln;
	    }

	    public void actionPerformed(ActionEvent evt) {
		  try {
		    manager.undo();
		    lineNumbers.repaint();
		  } catch (CannotUndoException e) {
		    Toolkit.getDefaultToolkit().beep();
		  }
	    }

	    private UndoManager manager;
	    private LineNumberPanel lineNumbers;

	  }

	  // The Redo action
	  public class RedoAction extends AbstractAction {
	    /**
		 * 
		 */
		private static final long serialVersionUID = 1L;

		public RedoAction(UndoManager manager, LineNumberPanel ln) {
	      this.manager = manager;
	      this.lineNumbers = ln;
	    }

	    public void actionPerformed(ActionEvent evt) {
	      try {
	        manager.redo();
		    lineNumbers.repaint();
	      } catch (CannotRedoException e) {
	        Toolkit.getDefaultToolkit().beep();
	      }
	    }

	    private LineNumberPanel lineNumbers;
	    private UndoManager manager;
	  }
	   
    

 	public void setTabs( JTextPane textPane, int charactersPerTab)
	{
		FontMetrics fm = textPane.getFontMetrics( textPane.getFont() );
		int charWidth = fm.charWidth( 'w' );
		int tabWidth = charWidth * charactersPerTab;
 
		TabStop[] tabs = new TabStop[10];
 
		for (int j = 0; j < tabs.length; j++)
		{
			int tab = j + 1;
			tabs[j] = new TabStop( tab * tabWidth );
		}
 
		TabSet tabSet = new TabSet(tabs);
		SimpleAttributeSet attributes = new SimpleAttributeSet();
		StyleConstants.setTabSet(attributes, tabSet);
		int length = textPane.getDocument().getLength();
		textPane.getStyledDocument().setParagraphAttributes(0, length, attributes, false);
	}

    public void paint(Graphics g) {
    	super.paint(g);
    	tSuggestor.repaint();
    }
    
    public void initUndoManager() {
		UndoManager manager = new CompoundUndoManager( pane );
	    //pane.getDocument().addUndoableEditListener(manager);
	    Action undoAction = new UndoAction(manager, lineNumbers);
	    Action redoAction = new RedoAction(manager, lineNumbers);
	    
	    pane.registerKeyboardAction(undoAction, KeyStroke.getKeyStroke("meta pressed Z"), JComponent.WHEN_FOCUSED);
	    pane.registerKeyboardAction(undoAction, KeyStroke.getKeyStroke("ctrl pressed Z"), JComponent.WHEN_FOCUSED);
	    pane.registerKeyboardAction(redoAction, KeyStroke.getKeyStroke("meta shift pressed Z"), JComponent.WHEN_FOCUSED);
	    pane.registerKeyboardAction(redoAction, KeyStroke.getKeyStroke("ctrl shift pressed Z"), JComponent.WHEN_FOCUSED);
	    pane.registerKeyboardAction(redoAction, KeyStroke.getKeyStroke("ctrl pressed Y"), JComponent.WHEN_FOCUSED);
   	
    }

	public void setCode(String code) {
		pane.setText(code);
	}
	
	public String getCode() {
		return pane.getText();
	}
	
	public TagSuggestor getSuggestor(){
		return tSuggestor;
	}
	
	
}


