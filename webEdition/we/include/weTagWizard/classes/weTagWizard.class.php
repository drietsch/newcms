<?php
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
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

require_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/data/module_tags.inc.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/data/we_tag_groups.inc.php');

class weTagWizard
{

	function getExistingWeTags()
	{
		
		$retTags = array();
		
		foreach ($GLOBALS['module_tags'] as $modulename => $tags) {
			
			if ($modulename == 'basis' || in_array($modulename, $GLOBALS['_we_active_modules'])) {
				$retTags = array_merge($retTags, $tags);
			}
		}
		
		// add custom tags
		$retTags = array_merge($retTags, weTagWizard::getCustomTags());
		
		natcasesort($retTags);
		return array_values($retTags);
	}

	function getWeTagGroups($allTags = array())
	{
		
		$taggroups = array();
		
		// 1st make grps based on modules
		foreach ($GLOBALS['module_tags'] as $modulename => $tags) {
			
			if ($modulename == 'basis') {
				$taggroups['alltags'] = $tags;
			}
			
			if (in_array($modulename, $GLOBALS['_we_active_modules'])) {
				$taggroups[$modulename] = $tags;
				$taggroups['alltags'] = array_merge($taggroups['alltags'], $tags);
			}
		}
		
		// 2nd add some taggroups to this array
		if (!sizeof($allTags)) {
			$allTags = weTagWizard::getExistingWeTags();
		}
		foreach ($GLOBALS['tag_groups'] as $key => $tags) {
			
			for ($i = 0; $i < sizeof($tags); $i++) {
				if (in_array($tags[$i], $allTags)) {
					$taggroups[$key][] = $tags[$i];
				}
			}
		}
		
		// at last add custom tags.
		$customTags = weTagWizard::getCustomTags();
		if (sizeof($customTags)) {
			$taggroups['custom'] = $customTags;
			$taggroups['alltags'] = array_merge($taggroups['alltags'], $taggroups['custom']);
		}
		
		natcasesort($taggroups['alltags']);
		return $taggroups;
	}

	function getCustomTags()
	{
		
		if (!isset($GLOBALS['weTagWizard_customTags'])) {
			
			$GLOBALS['weTagWizard_customTags'] = array();
			
			if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/we_tags/custom_tags')) {
				
				// get the custom tag-descriptions
				$handle = dir(
						$_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/we_tags/custom_tags');
				
				while (false !== ($entry = $handle->read())) {
					
					if (preg_match("/we_tag_(.*).inc.php/", $entry, $match)) {
						$GLOBALS['weTagWizard_customTags'][] = $match[1];
					}
				}
			}
		}
		return $GLOBALS['weTagWizard_customTags'];
	}
}

?>