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

import javax.swing.SwingUtilities;
import javax.swing.event.DocumentEvent;
import javax.swing.event.DocumentListener;
import javax.swing.event.UndoableEditEvent;
import javax.swing.event.UndoableEditListener;
import javax.swing.text.AbstractDocument;
import javax.swing.text.JTextComponent;
import javax.swing.undo.CannotUndoException;
import javax.swing.undo.CompoundEdit;
import javax.swing.undo.UndoManager;
import javax.swing.undo.UndoableEdit;

public class CompoundUndoManager extends UndoManager
	implements UndoableEditListener, DocumentListener
{
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	public CompoundEdit compoundEdit;
	private JTextComponent editor;
 
	//  These fields are used to help determine whether the edit is an
	//  incremental edit. For each character added the offset and length
	//  should increase by 1 or decrease by 1 for each character removed.
 
	private int lastOffset;
	private int lastLength;
 
	public CompoundUndoManager(JTextComponent editor)
	{
		this.editor = editor;
		editor.getDocument().addUndoableEditListener( this );
	}
 
	/*
	**  Add a DocumentLister before the undo is done so we can position
	**  the Caret correctly as each edit is undone.
	*/
	public void undo()
	{
		editor.getDocument().addDocumentListener( this );
		super.undo();
		editor.getDocument().removeDocumentListener( this );
	}
 
	/*
	**  Add a DocumentLister before the redo is done so we can position
	**  the Caret correctly as each edit is redone.
	*/
	public void redo()
	{
		editor.getDocument().addDocumentListener( this );
		super.redo();
		editor.getDocument().removeDocumentListener( this );
	}
 
	/*
	**  Whenever an UndoableEdit happens the edit will either be absorbed
	**  by the current compound edit or a new compound edit will be started
	*/
	public void undoableEditHappened(UndoableEditEvent e)
	{
		//  Start a new compound edit
 
		if (compoundEdit == null)
		{
			compoundEdit = startCompoundEdit( e.getEdit() );
			lastLength = editor.getDocument().getLength();
			return;
		}
 
		//  Check for an attribute change
 
		AbstractDocument.DefaultDocumentEvent event =
			(AbstractDocument.DefaultDocumentEvent)e.getEdit();
 
		if  (event.getType().equals(DocumentEvent.EventType.CHANGE))
		{
			compoundEdit.addEdit( e.getEdit() );
			return;
		}
 
		//  Check for an incremental edit or backspace.
		//  The change in Caret position and Document length should be either
		//  1 or -1 .
 
		int offsetChange = editor.getCaretPosition() - lastOffset;
		int lengthChange = editor.getDocument().getLength() - lastLength;
 
		if (Math.abs(offsetChange) == 1
		&&  Math.abs(lengthChange) == 1)
		{
			compoundEdit.addEdit( e.getEdit() );
			lastOffset = editor.getCaretPosition();
			lastLength = editor.getDocument().getLength();
			return;
		}
 
		//  Not incremental edit, end previous edit and start a new one
 
		compoundEdit.end();
		compoundEdit = startCompoundEdit( e.getEdit() );
	}
 
	/*
	**  Each CompoundEdit will store a group of related incremental edits
	**  (ie. each character typed or backspaced is an incremental edit)
	*/
	private CompoundEdit startCompoundEdit(UndoableEdit anEdit)
	{
		//  Track Caret and Document information of this compound edit
 
		lastOffset = editor.getCaretPosition();
		lastLength = editor.getDocument().getLength();
 
		//  The compound edit is used to store incremental edits
 
		compoundEdit = new MyCompoundEdit();
		compoundEdit.addEdit( anEdit );
 
		//  The compound edit is added to the UndoManager. All incremental
		//  edits stored in the compound edit will be undone/redone at once
 
		addEdit( compoundEdit );
		return compoundEdit;
	}
 
	//  Implement DocumentListener
	//
	// 	Updates to the Document as a result of Undo/Redo will cause the
	//  Caret to be repositioned
 
	public void insertUpdate(final DocumentEvent e)
	{
		SwingUtilities.invokeLater(new Runnable()
		{
			public void run()
			{
				int offset = e.getOffset() + e.getLength();
				offset = Math.min(offset, editor.getDocument().getLength());
				editor.setCaretPosition( offset );
			}
		});
	}
 
	public void removeUpdate(DocumentEvent e)
	{
		editor.setCaretPosition(e.getOffset());
	}
 
	public void changedUpdate(DocumentEvent e) 	{}
 
 
	class MyCompoundEdit extends CompoundEdit
	{
		/**
		 * 
		 */
		private static final long serialVersionUID = 1L;

		public boolean isInProgress()
		{
			//  in order for the canUndo() and canRedo() methods to work
			//  assume that the compound edit is never in progress
 
			return false;
		}
 
		public void undo() throws CannotUndoException
		{
			//  End the edit so future edits don't get absorbed by this edit
 
			if (compoundEdit != null)
				compoundEdit.end();
 
			super.undo();
 
			//  Always start a new compound edit after an undo
 
			compoundEdit = null;
		}
 
	
	}
}
 