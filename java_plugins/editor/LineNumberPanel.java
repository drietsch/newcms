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


import java.awt.Dimension;
import java.awt.Font;
import java.awt.Graphics;
import java.awt.Point;
import java.awt.event.AdjustmentEvent;
import java.awt.event.AdjustmentListener;

import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextPane;
import javax.swing.text.BadLocationException;
import javax.swing.text.Document;


public class LineNumberPanel extends JPanel
{
/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	// for this simple experiment, we keep the pane + scrollpane as members.
	
	JTextPane pane;
	JScrollPane scrollPane;
	Font NrPanelFont;
	
		
	boolean userChanges=true;
		
	public LineNumberPanel(final JTextPane pane) {
		super();
		
		this.pane = pane;
				
		final LineNumberPanel _this = this;
		
		setMinimumSize(new Dimension(44, 0));
		setPreferredSize(new Dimension(44, 0));
		setMinimumSize(new Dimension(44, 0));
		
		NrPanelFont = new Font("courier", Font.PLAIN, 10);

		
		scrollPane = (JScrollPane) pane.getParent().getParent().getParent();
		
		
		class MyAdjustmentListener implements AdjustmentListener {
	        // This method is called whenever the value of a scrollbar is changed,
	        // either by the user or programmatically.
	        public void adjustmentValueChanged(AdjustmentEvent evt) {
	        	_this.repaint();
	        }
	    }
		AdjustmentListener listener = new MyAdjustmentListener();
		scrollPane.getVerticalScrollBar().addAdjustmentListener(listener);
		scrollPane.setVerticalScrollBarPolicy(JScrollPane.VERTICAL_SCROLLBAR_ALWAYS);
		scrollPane.setHorizontalScrollBarPolicy(JScrollPane.HORIZONTAL_SCROLLBAR_ALWAYS);


	}
	
    
 
    public void paintComponent(Graphics g) {
		super.paintComponent(g);
		g.setClip(0,2,40,scrollPane.getViewport().getHeight());
		// We need to properly convert the points to match the viewport
		// Read docs for viewport
		 // starting pos in document
		int start =	Math.max(0, pane.viewToModel(scrollPane.getViewport().getViewPosition()));
		// end pos in doc
		int end = pane.viewToModel(
		new Point(
				scrollPane.getViewport().getViewPosition().x + pane.getWidth(),
				scrollPane.getViewport().getViewPosition().y + pane.getHeight()
				)
		);

		// translate offsets to lines
		Document doc = pane.getDocument();
		int startline = doc.getDefaultRootElement().getElementIndex(start) + 1;
		int endline = doc.getDefaultRootElement().getElementIndex(end) + 1;
		g.setFont(NrPanelFont);

		int fontHeight = g.getFontMetrics(pane.getFont()).getHeight();
		int fontDesc = g.getFontMetrics(pane.getFont()).getMaxDescent();
		int starting_y = -1;

		try
		{
			starting_y = 1 + pane.modelToView(start).y - scrollPane.getViewport().getViewPosition().y + fontHeight - fontDesc;
		} catch (BadLocationException e1) {
			e1.printStackTrace();
		} catch (NullPointerException e1) {
			starting_y = 1 + fontHeight - fontDesc;
		}
		for (int line = startline, y = starting_y; line <= endline; y += fontHeight, line++) {
			int _w = g.getFontMetrics().stringWidth(Integer.toString(line));
			g.drawString(Integer.toString(line), 40 - _w, y);
		}
	}


}


