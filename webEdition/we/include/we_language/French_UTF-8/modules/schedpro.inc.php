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
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


/**
 * Language file: schedpro.inc.php
 * Provides language strings.
 * Language: English
 */

$GLOBALS["l_schedpro"] = array();
$GLOBALS["l_schedpro"]["task"] = array();

$GLOBALS["l_schedpro"]["task"]["headline"] = "Task";
$GLOBALS["l_schedpro"]["task"][SCHEDULE_FROM] = "Publier";
$GLOBALS["l_schedpro"]["task"][SCHEDULE_TO] = "Depublier";
$GLOBALS["l_schedpro"]["task"][SCHEDULE_DELETE] = "Supprimer";
$GLOBALS["l_schedpro"]["task"][SCHEDULE_DOCTYPE] = "Changer le type de document";
$GLOBALS["l_schedpro"]["task"][SCHEDULE_CATEGORY] = "Changer la catégorie";
$GLOBALS["l_schedpro"]["task"][SCHEDULE_DIR] = "Changer le répertoire";

$GLOBALS["l_schedpro"]["type"] = array();

$GLOBALS["l_schedpro"]["type"]["headline"] = "Frequency";
$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_ONCE] = "une fois";
$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_HOUR] = "Une fois par heure";
$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_DAY] = "Une fois par jour";
$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_WEEK] = "Une fois par semaine";
$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_MONTH] = "Une fois par mois";
$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_YEAR] = "Une fois par an";

$GLOBALS["l_schedpro"]["time"] = "Heure";
$GLOBALS["l_schedpro"]["months"] = "Mois";
$GLOBALS["l_schedpro"]["days"] = "Jours";
$GLOBALS["l_schedpro"]["weekdays"] = "Jours de semaine";
$GLOBALS["l_schedpro"]["minutes"] = "Minutes"; // TRANSLATE
$GLOBALS["l_schedpro"]["datetime"] = "Date/Heure";

$GLOBALS["l_schedpro"]["categories"] = "Catégories";
$GLOBALS["l_schedpro"]["doctype"] = "Type de Document";
$GLOBALS["l_schedpro"]["dirctory"] = "Répertoire";

$GLOBALS["l_schedpro"]["active"] = "active";
$GLOBALS["l_schedpro"]["doctypeAll"] = "Adopter les valeurs standards";

$GLOBALS["l_schedpro"]["descriptiontext"] = "Pour créer une nouvelle tâche, contrôlé par temps, cliquez sur le bouton-plus.";
?>