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

import java.awt.Color;
import java.awt.Graphics;
import java.awt.Point;
import java.awt.Rectangle;
import java.awt.event.KeyAdapter;
import java.awt.event.KeyEvent;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.util.Enumeration;
import java.util.Vector;

import javax.swing.ActionMap;
import javax.swing.DefaultListModel;
import javax.swing.JList;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextPane;
import javax.swing.SwingUtilities;
import javax.swing.text.DefaultEditorKit;

abstract class Suggestor extends JPanel {

	private static final long serialVersionUID = 1L;
	public JList list = new JList();
	public boolean processSelection = true;

	protected Editor applet;
	protected JTextPane pane;
	protected LineNumberPanel lineNumbers;

	protected String suggestedValue;

	protected Vector<SuggestorListener> listeners;

	public Suggestor(Editor anApplet, JTextPane aPane,
			LineNumberPanel someLineNumbers) {
		super();
		this.applet = anApplet;
		this.pane = aPane;
		this.lineNumbers = someLineNumbers;

		this.suggestedValue = "";

		setLayout(null);
		setSize(200, 200);
		list.setFocusable(false);
		list.setBackground(new Color(255, 255, 235));
		JScrollPane scroll = new JScrollPane(list);
		scroll
				.setBorder(javax.swing.BorderFactory
						.createLineBorder(Color.gray));
		scroll
				.setVerticalScrollBarPolicy(JScrollPane.VERTICAL_SCROLLBAR_AS_NEEDED);
		scroll
				.setHorizontalScrollBarPolicy(JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);
		scroll.setFocusable(false);
		scroll.setSize(200, 200);
		add(scroll);
		setVisible(false);

		list.addKeyListener(new KeyAdapter() {
			public void keyReleased(KeyEvent e) {
				if (isVisible()) {
					//repaint();
					switch (e.getKeyCode()) {

					case KeyEvent.VK_ESCAPE:
						hideSuggestor();
						return;

					case KeyEvent.VK_ENTER:
						_suggestorAction();
						return;

					}
				}
			}
		});

		list.addMouseListener(new MouseAdapter() {
			public void mouseClicked(MouseEvent e) {
				_suggestorAction();
			}

			public void mousePressed(MouseEvent e) {
			}

			public void mouseReleased(MouseEvent e) {
			}

			public void mouseEntered(MouseEvent e) {
			}

			public void mouseExited(MouseEvent e) {
			}
		});
	}

	protected void _suggestorAction() {
		if (processSelection) {
			try {
				int index = list.getSelectedIndex();
				String word = (String) list.getModel().getElementAt(index);
				updatePane(word);
				suggestedValue = word;
				fireSuggestorEvent();
				hideSuggestor();
			} catch (Exception ex) {
				ex.printStackTrace();
			}
		}
	}

	abstract protected void updatePane(String word);

	public void showSuggestor(DefaultListModel model) {
		int pos = pane.getSelectionStart();
		if (model.size() > 0 && !isVisible()) {
			list.setModel(model);
			try {

				JScrollPane scrollPane = (JScrollPane) pane.getParent()
						.getParent().getParent();

				Point p = scrollPane.getViewport().getViewPosition();
				Rectangle rect = pane.getUI().modelToView(pane, pos);
				int x = (int) rect.getX() + lineNumbers.getWidth() + 4 - p.x;
				int y = (int) (rect.getY() + rect.getHeight() + 2) - p.y;
				int appletW = applet.getContentPane().getWidth();
				int appletH = applet.getContentPane().getHeight();
				int suggestorWidth = this.getWidth();
				int suggestorHeight = this.getHeight();
				if (x + suggestorWidth > appletW) {
					x = Math.max(0, appletW - suggestorWidth);
				}
				if (y + suggestorHeight > appletH) {
					y = Math.max(0, y - suggestorHeight - 16);
				}

				setLocation(x, y);
				setVisible(true);
				suggestorWillShow();
				SwingUtilities.invokeLater(new Runnable() {
					public void run() {
						processSelection = true;
						pane.requestFocus();

					}
				});

			} catch (Exception ex) {
				ex.printStackTrace();
			}
		}
	}

	public void hideSuggestor() {
		if (isVisible()) {
			setVisible(false);
			suggestorWillHide();
			if (pane != null) {
				pane.setFocusable(true);
				pane.requestFocus();
				processSelection = false;
			}
		}
	}

	public String getSuggestedValue() {
		return suggestedValue;
	}

	public void setSuggestedValue(String aValue) {
		suggestedValue = aValue;
	}

	public void paint(Graphics g) {
		super.paint(g);
	}

	public void suggestorWillShow() {
		ActionMap am = pane.getActionMap();
		am.put(DefaultEditorKit.downAction, new EditorDownAction());
	}

	public void suggestorWillHide() {
		ActionMap am = pane.getActionMap();
		am.remove(DefaultEditorKit.downAction);

	}

	synchronized public void addSuggestorListener(SuggestorListener jcl) {

		if (listeners == null) {
			listeners = new Vector<SuggestorListener>();
		}

		listeners.addElement(jcl);
	}

	synchronized public void removeSuggestorListener(SuggestorListener jcl) {

		if (listeners == null) {
			listeners = new Vector<SuggestorListener>();
		}
		listeners.removeElement(jcl);
	}

	@SuppressWarnings("unchecked")
	protected void fireSuggestorEvent() {
		Vector<SuggestorListener> targets;
		Enumeration<SuggestorListener> en;
		SuggestorListener jcl;

		if (listeners != null && !listeners.isEmpty()) {
			SuggestorEvent event = new SuggestorEvent(this, suggestedValue);
			synchronized (this) {
				targets = (Vector<SuggestorListener>) listeners.clone();
			}
			en = targets.elements();
			while (en.hasMoreElements()) {
				jcl = en.nextElement();
				jcl.entrySelected(event);
			}
		}
	}

	public void selectEntry(String value) {
		System.out.println(value);
		list.setSelectedValue(value, true);
	}
}
