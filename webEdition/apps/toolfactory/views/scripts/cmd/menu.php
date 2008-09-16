<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

$js = <<<EOS

weCmdController.fire({cmdName: "{$this->cmdName}"})

EOS;

$page = we_ui_layout_HTMLPage::getInstance();
$page->addInlineJS($js);

echo $page->getHTML();
