<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

/**
 * Language file: navigation.inc.php
 * Provides language strings.
 * Language: English
 */

$l_navigation = array();
$l_navigation['no_perms'] = 'You do not have the permission to select this option.';
$l_navigation['delete_alert'] = 'Delete current entry/folder.\\n Are you sure?';
$l_navigation['nothing_to_delete'] = 'The entry cannot be deleted!';
$l_navigation['nothing_to_save'] = 'The entry cannot be saved!';
$l_navigation['nothing_selected'] = 'Please select the entry/folder to delete.';
$l_navigation['we_filename_notValid'] = 'The username is not correct!\\nAlphanumeric characters, upper case and lower case, just as low line, hyphen, dot and blank character{blank; space} (a-z, A-Z, 0-9, _,-.,) are valid';

$l_navigation['menu_new'] = 'New';
$l_navigation['menu_save'] = 'Save';
$l_navigation['menu_delete'] = 'Delete';
$l_navigation['menu_exit'] = 'Close';

$l_navigation['menu_options'] = 'Options';
$l_navigation['menu_generate'] = 'Generate source code';

$l_navigation['menu_settings'] = 'Settings';
$l_navigation['menu_highlight_rules'] = 'Rules for Highlighting';

$l_navigation['menu_info'] = 'Info';
$l_navigation['menu_help'] = 'Help';

$l_navigation['property'] = 'Properties';
$l_navigation['preview'] = 'Preview';
$l_navigation['preview_code'] = 'Preview - source code';
$l_navigation['navigation'] = 'Navigation';
$l_navigation['group'] = 'Folder';
$l_navigation['name'] = 'Name';
$l_navigation['newFolder'] = 'New folder';
$l_navigation['display'] = 'Display';
$l_navigation['save_group_ok'] = 'The folder was saved.';
$l_navigation['save_ok'] = 'The navigation was saved.';

$l_navigation['path_nok'] = 'The path is not correct!';
$l_navigation['name_empty'] = 'The name may not be empty!';
$l_navigation['name_exists'] = 'The name already exists!';
$l_navigation['wrongtext'] = 'The name is not valid!\\nValid characters are are letters from a to z (upper case or lower case), figures, low line (_), deficit (-), dot (.), blank characters ( ) and at symbols (@). ';
$l_navigation['wrongTitleField'] = 'The navigation folder could not be saved, because the given title field doesn\'t  exist. Please correct the title field on the "content" tab and save again.';
$l_navigation['folder_path_exists'] = 'A entry/foder with this name exists allredy.';
$l_navigation['navigation_deleted'] = 'The entry/folder was deleted successfully.';
$l_navigation['group_deleted'] = 'The folder was deleted successfully.';

$l_navigation['selection'] = 'Selection';
$l_navigation['icon'] = 'Image';
$l_navigation['presentation'] = 'Representation';
$l_navigation['text'] = 'Text';
$l_navigation['title'] = 'Title';

$l_navigation['dir'] = 'Directory';
$l_navigation['categories'] = 'Categories';
$l_navigation['stat_selection'] = 'Static selection';
$l_navigation['dyn_selection'] = 'Dynamic selection';
$l_navigation['manual_selection'] = 'Manual selection';
$l_navigation['txt_dyn_selection'] = 'Explanation text for the dynamic selection';
$l_navigation['txt_stat_selection'] = 'Explanation text for the static selection. Linked to the selected document or object.';

$l_navigation['sort'] = 'Sorting';
$l_navigation['ascending'] = 'ascending';
$l_navigation['descending'] = 'descending';

$l_navigation['show_count'] = 'Number of entries to be displayed';
$l_navigation['title_field'] = 'Title field';
$l_navigation['select_field_txt'] = 'Select a field';

$l_navigation['content'] = 'Content';
$l_navigation['no_dyn_content'] = '- No dynamic contents -';
$l_navigation['dyn_content'] = 'The folder contains dynamic contents';
$l_navigation['link'] = 'Link';
$l_navigation['docLink'] = 'Internal document';
$l_navigation['objLink'] = 'Object';
$l_navigation['catLink'] = 'Category';
$l_navigation['order'] = 'Order';

$l_navigation['general'] = 'General';
$l_navigation['entry'] = 'Entry';
$l_navigation['entries'] = 'Entries';
$l_navigation['save_populate_question'] = 'You have defined the dynamic contents for the folder. After saving the document the generated entries are added resp. renewed. Would you like to proceed? ';
$l_navigation['depopulate_question'] = 'The dynamic contents will now be deleted. Would like you to proceed?';
$l_navigation['populate_question'] = 'The dynamic entries are now updated. Would you like to proceed?';
$l_navigation['depopulate_msg'] = 'The dynamic entries were deleted.';
$l_navigation['populate_msg'] = 'The dynamic entries were added.';

$l_navigation['documents'] = 'Documents';
$l_navigation['objects'] = 'Objects';
$l_navigation['workspace'] = 'Workspace';
$l_navigation['no_workspace'] = 'The object has no defined workspace! Thus, the object can not be selected!';

$l_navigation['no_entry'] = '--all the same--';
$l_navigation['parameter'] = 'Parameter';
$l_navigation['urlLink'] = 'External document';
$l_navigation['doctype'] = 'Document type';
$l_navigation['class'] = 'Class';

$l_navigation['parameter_text'] = 'In the parameter the following variables of the navigation can be used: $LinkID, FolderID, $DocTypID, $ClassID, $Ordn and $WorkspaceID';

$l_navigation['intern'] = 'Internal Link';
$l_navigation['extern'] = 'External Link';
$l_navigation['linkSelection'] = 'Link selection';
$l_navigation['catParameter'] = 'Name of the category parameter';

$l_navigation['rules']['navigation_rules'] = "Navigation rules";
$l_navigation['rules']['available_rules'] = "Available rules";
$l_navigation['rules']['rule_name'] = "Name of rule";
$l_navigation['rules']['rule_navigation_link'] = "Active navigation item";
$l_navigation['rules']['rule_applies_for'] = "Rule applies for";
$l_navigation['rules']['rule_folder'] = "In folder";
$l_navigation['rules']['rule_doctype'] = "Document type";
$l_navigation['rules']['rule_categories'] = "Categories";
$l_navigation['rules']['rule_class'] = "Of class";
$l_navigation['rules']['rule_workspace'] = "Workspace";
$l_navigation['rules']['invalid_name'] = "The name may consist only of letter, figures, hyphen and unterscore";
$l_navigation['rules']['name_exists'] = "The name \"%s\" already exists, please enter another name.";
$l_navigation['rules']['saved_successful'] = "The entry \"%s\" was saved.";

$l_navigation['exit_doc_question'] = 'It seems, as if you have changed the navigation.<br>Do you want to save your changes?';
$l_navigation['add_navigation'] = 'Add navigation';
$l_navigation['begin'] = 'at the beginning';
$l_navigation['end'] = 'at the end';

$l_navigation['del_question'] = 'The entry will be deleted definitely. Are you sure?';
$l_navigation['dellall_question'] = 'All entries will be deleted definitely. Are you sure?';
$l_navigation['charset'] = 'Character coding';

$l_navigation['more_attributes'] = 'More properties';
$l_navigation['less_attributes'] = 'Less properties';
$l_navigation['attributes'] = 'Attributes';
$l_navigation['title'] = 'Title';
$l_navigation['anchor'] = 'Anchor';
$l_navigation['language'] = 'Language';
$l_navigation['target'] = 'Target';
$l_navigation['link_language'] = 'Link';
$l_navigation['href_language'] = 'Linked document';
$l_navigation['keyboard'] = 'Keyboard';
$l_navigation['accesskey'] = 'Accesskey';
$l_navigation['tabindex'] = 'Tabindex';
$l_navigation['relation'] = 'Relation';
$l_navigation['link_attribute'] = 'Link attributes';
$l_navigation['popup'] = 'Popup window';
$l_navigation['popup_open'] = 'Open';
$l_navigation['popup_center'] = 'Center';
$l_navigation['popup_x'] = 'x position';
$l_navigation['popup_y'] = 'y position';
$l_navigation['popup_width'] = 'Width';
$l_navigation['popup_height'] = 'Height';
$l_navigation['popup_status'] = 'Status';
$l_navigation['popup_scrollbars'] = 'Scrollbars';
$l_navigation['popup_menubar'] = 'Menubar';
$l_navigation['popup_resizable'] = 'Resizable';
$l_navigation['popup_location'] = 'Location';
$l_navigation['popup_toolbar'] = 'Toolbar';

$l_navigation['icon_properties'] = 'Image properties';
$l_navigation['icon_properties_out'] = 'Hide image properties';
$l_navigation['icon_width'] = 'Width';
$l_navigation['icon_height'] = 'Heigt';
$l_navigation['icon_border'] = 'Border';
$l_navigation['icon_align'] = 'Align';
$l_navigation['icon_hspace'] = 'horiz. space';
$l_navigation['icon_vspace'] = 'vert. space';
$l_navigation['icon_alt'] = 'Alt text';
$l_navigation['icon_title'] = 'Title';

$l_navigation['linkprops_desc'] = 'Here you can define the additional link properties. In dynamic items only link target and popup window properties will be applied.';
$l_navigation['charset_desc'] = 'The selected charset will be applyed on the current folder and all folder entries.';


$l_navigation['customers'] = 'Customer filter';
$l_navigation['limit_access'] = 'Define customer access level';
$l_navigation['customer_access'] = 'All customers can access the item';
$l_navigation['filter'] = 'Define filter';
$l_navigation['and'] = 'and';
$l_navigation['or'] = 'or';
$l_navigation['selected_customers'] = 'Only folowing customers can access the item';
$l_navigation['useDocumentFilter'] = 'Use filter settings of document/object';
$l_navigation['reset_customer_filter'] = 'Reset all customer filters';
$l_navigation['reset_customerfilter_done_message'] = 'The cusomer filters were successfully reset!';

?>