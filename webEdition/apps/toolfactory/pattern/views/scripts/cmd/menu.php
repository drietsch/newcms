
$js = <<<EOS

self.focus();
weCmdController.fire({cmdName: "{$this->cmdName}"})

EOS;

$page = we_ui_layout_HTMLPage::getInstance();
$page->addInlineJS($js);

echo $page->getHTML();
