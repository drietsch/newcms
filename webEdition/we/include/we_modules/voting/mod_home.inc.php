<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */



include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");


$we_button = new we_button();

$createVoting = $we_button->create_button("new_voting", "javascript:top.opener.top.we_cmd('new_voting');", true, -1, -1, "", "", !we_hasPerm("NEW_VOTING"));
$createVotingGroup = $we_button->create_button("new_voting_group", "javascript:top.opener.top.we_cmd('new_voting_group');", true, -1, -1, "", "", !we_hasPerm("NEW_VOTING"));


$content = $createVoting  . getPixel(2,14) . $createVotingGroup;

$modimage = "voting.gif";

?>