<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

$buttonHref = new we_ui_controls_Button();
$buttonHref->setTitle('go to www.webedition.de');
$buttonHref->setText('go to www.webedition.de');
$buttonHref->setType('href');
$buttonHref->setHref('http://www.webedition.de');
$buttonHref->setTarget('_blank');
//$buttonHref->setDisabled(false);
//$buttonHref->setHidden(false);
$buttonHref->setWidth(300);
//$buttonHref->setIcon();
//$buttonHref->setImagePath();
//$buttonHref->setOnClick();
//$buttonHref->setTextPosition();


$buttonOnClick = new we_ui_controls_Button();
$buttonOnClick->setTitle('do something onClick');
$buttonOnClick->setText('do something onClick');
$buttonOnClick->setType('onClick');
//$buttonOnClick->setHref('http://www.webedition.de');
//$buttonOnClick->setTarget('_blank');
//$buttonOnClick->setDisabled(false);
//$buttonOnClick->setHidden(false);
$buttonOnClick->setWidth(300);
//$buttonOnClick->setIcon();
//$buttonOnClick->setImagePath();
$buttonOnClick->setOnClick('alert("Hello!");');
//$buttonOnClick->setTextPosition();


$buttonSubmitForm = new we_ui_controls_Button();
$buttonSubmitForm->setTitle('submit form');
$buttonSubmitForm->setText('submit form');
$buttonSubmitForm->setType('submit');
//$buttonSubmitForm->setHref('http://www.webedition.de');
//$buttonSubmitForm->setTarget('_blank');
//$buttonSubmitForm->setDisabled(false);
//$buttonSubmitForm->setHidden(false);
$buttonSubmitForm->setWidth(300);
//$buttonSubmitForm->setIcon();
//$buttonSubmitForm->setImagePath();
//$buttonSubmitForm->setOnClick('alert("Hello!");');
//$buttonSubmitForm->setTextPosition();



$buttonImage = new we_ui_controls_Button();
$buttonImage->setTitle('delete');
$buttonImage->setText('delete');
$buttonImage->setType('onClick');
//$buttonImage->setHref('http://www.webedition.de');
//$buttonImage->setTarget('_blank');
//$buttonImage->setDisabled(false);
//$buttonImage->setHidden(false);
$buttonImage->setWidth(300);
$buttonImage->setIcon(we_ui_controls_Button::kIconTrash);
//$buttonImage->setImagePath();
$buttonImage->setOnClick('alert("Delete it!");');
$buttonImage->setTextPosition('right');

$buttonImage2 = new we_ui_controls_Button();
$buttonImage2->setTitle('delete');
$buttonImage2->setText('delete');
$buttonImage2->setType('onClick');
//$buttonImage2->setHref('http://www.webedition.de');
//$buttonImage2->setTarget('_blank');
//$buttonImage2->setDisabled(false);
//$buttonImage2->setHidden(false);
$buttonImage2->setWidth(300);
$buttonImage2->setIcon(we_ui_controls_Button::kIconTrash);
//$buttonImage2->setImagePath();
$buttonImage2->setOnClick('alert("Delete it!");');
$buttonImage2->setTextPosition('left');


$buttonImage3 = new we_ui_controls_Button();
$buttonImage3->setTitle('delete');
//$buttonImage3->setText('delete');
$buttonImage3->setType('onClick');
//$buttonImage3->setHref('http://www.webedition.de');
//$buttonImage3->setTarget('_blank');
//$buttonImage3->setDisabled(true);
//$buttonImage3->setHidden(false);
$buttonImage3->setWidth(50);
$buttonImage3->setIcon(we_ui_controls_Button::kIconTrash);
//$buttonImage3->setImagePath();
$buttonImage3->setOnClick('alert("Delete it!");');
//$buttonImage3->setTextPosition('left');


$buttonExtern = new we_ui_controls_Button();
$buttonExtern->setTitle('www.webedition.de');
$buttonExtern->setText('www.webedition.de');
$buttonExtern->setType('href');
$buttonExtern->setHref('http://www.webedition.de');
//$buttonExtern->setTarget('_blank');
//$buttonExtern->setDisabled(true);
//$buttonExtern->setHidden(false);
$buttonExtern->setWidth(200);
$buttonExtern->setHeight(50);
//$buttonExtern->setIcon(we_ui_controls_Button::kIconTrash);
$buttonExtern->setImagePath('/webEdition/images/update/alert.gif');
//$buttonExtern->setOnClick('');
$buttonExtern->setTextPosition('left');


$buttonExtern2 = new we_ui_controls_Button();
$buttonExtern2->setTitle('www.webedition.de');
$buttonExtern2->setText('www.webedition.de');
$buttonExtern2->setType('href');
$buttonExtern2->setHref('http://www.webedition.de');
//$buttonExtern2->setTarget('_blank');
//$buttonExtern2->setDisabled(true);
//$buttonExtern2->setHidden(false);
$buttonExtern2->setWidth(200);
$buttonExtern2->setHeight(50);
//$buttonExtern2->setIcon(we_ui_controls_Button::kIconTrash);
$buttonExtern2->setImagePath('/webEdition/images/update/alert.gif');
//$buttonExtern2->setOnClick('');
$buttonExtern2->setTextPosition('right');


$buttonExtern3 = new we_ui_controls_Button();
$buttonExtern3->setTitle('www.webedition.de');
//$buttonExtern3->setText('www.webedition.de');
$buttonExtern3->setType('onClick');
//$buttonExtern3->setHref('http://www.webedition.de');
//$buttonExtern3->setTarget('_blank');
//$buttonExtern3->setDisabled(true);
//$buttonExtern3->setHidden(false);
$buttonExtern3->setWidth(32);
$buttonExtern3->setHeight(32);
//$buttonExtern3->setIcon(we_ui_controls_Button::kIconTrash);
$buttonExtern3->setImagePath('/webEdition/images/update/alert.gif');
$buttonExtern3->setOnClick('alert("Hello!");');
//$buttonExtern3->setTextPosition('right');

$newButton = new we_ui_controls_Button();
$newButton->setTitle('button to add');
$newButton->setText('button to add');
$newButton->setType('onClick');
//$newButton->setHref('http://www.webedition.de');
//$newButton->setTarget('_blank');
//$newButton->setDisabled(true);
//$newButton->setHidden(false);
$newButton->setWidth(150);
//$newButton->setHeight(32);
//$newButton->setIcon(we_ui_controls_Button::kIconTrash);
//$newButton->setImagePath('/webEdition/images/update/alert.gif');
$newButton->setOnClick('alert("Hello!");');
//$newButton->setTextPosition('right');


$htmlPage = we_ui_layout_HTMLPage::getInstance();
$htmlPage->setTitle('Samples Button');
$htmlPage->addInlineCSS('
body { 
	padding:10px !important;
}
');

$htmlPage->addHTML("<br/>link<br/><br/>");
$htmlPage->addElement($buttonHref);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonHref->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonHref->getId().'&quot;, false);">enable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.hide(&quot;'.$buttonHref->getId().'&quot;);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.show(&quot;'.$buttonHref->getId().'&quot;);">show</a></div>');
$htmlPage->addHTML('<div><a href="javascript:alert(we_ui_controls_Button.isDisabled(&quot;'.$buttonHref->getId().'&quot;));">isDisabled</a></div>');
$htmlPage->addHTML('<div><a href="javascript:alert(we_ui_controls_Button.isEnabled(&quot;'.$buttonHref->getId().'&quot;));">isEnabled</a></div>');
$htmlPage->addHTML("<br/><br/>");

$htmlPage->addHTML("<br/>onClick<br/><br/>");
$htmlPage->addElement($buttonOnClick);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonOnClick->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonOnClick->getId().'&quot;, false);">enable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.hide(&quot;'.$buttonOnClick->getId().'&quot;);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.show(&quot;'.$buttonOnClick->getId().'&quot;);">show</a></div>');
$htmlPage->addHTML("<br/><br/>");

$htmlPage->addHTML("<br/>submit form<br/><br/>");
$htmlPage->addHTML('<form name="myForm" action="'.$_SERVER['PHP_SELF'].'" method="post" onSubmit="alert(\'onSubmit do something\');">');
$inp = new we_ui_controls_TextField(array('name'=>'test', 'value'=>'default', 'width'=>100));
$htmlPage->addElement($inp);
$htmlPage->addHTML("<br/><br/>");
$htmlPage->addElement($buttonSubmitForm);
$htmlPage->addHTML('</form>');
if(isset($_REQUEST['test'])) {
	$htmlPage->addHTML($_REQUEST['test']);
	$_REQUEST['test']="";
}
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonSubmitForm->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonSubmitForm->getId().'&quot;, false);">enable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.hide(&quot;'.$buttonSubmitForm->getId().'&quot;);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.show(&quot;'.$buttonSubmitForm->getId().'&quot;);">show</a></div>');
$htmlPage->addHTML("<br/><br/>");

$htmlPage->addHTML("<br/>image - text on the right<br/><br/>");
$htmlPage->addElement($buttonImage);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonImage->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonImage->getId().'&quot;, false);">enable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.hide(&quot;'.$buttonImage->getId().'&quot;);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.show(&quot;'.$buttonImage->getId().'&quot;);">show</a></div>');
$htmlPage->addHTML("<br/><br/>");

$htmlPage->addHTML("<br/>image - text on the left <br/><br/>");
$htmlPage->addElement($buttonImage2);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonImage2->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonImage2->getId().'&quot;, false);">enable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.hide(&quot;'.$buttonImage2->getId().'&quot;);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.show(&quot;'.$buttonImage2->getId().'&quot;);">show</a></div>');
$htmlPage->addHTML("<br/><br/>");

$htmlPage->addHTML("<br/>predefined internal image<br/><br/>");
$htmlPage->addElement($buttonImage3);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonImage3->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonImage3->getId().'&quot;, false);">enable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.hide(&quot;'.$buttonImage3->getId().'&quot;);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.show(&quot;'.$buttonImage3->getId().'&quot;);">show</a></div>');
$htmlPage->addHTML("<br/><br/>");

$htmlPage->addHTML("<br/>external image and text on the left<br/><br/>");
$htmlPage->addElement($buttonExtern);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonExtern->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonExtern->getId().'&quot;, false);">enable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.hide(&quot;'.$buttonExtern->getId().'&quot;);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.show(&quot;'.$buttonExtern->getId().'&quot;);">show</a></div>');
$htmlPage->addHTML("<br/><br/>");

$htmlPage->addHTML("<br/>external image and text on the right<br/><br/>");
$htmlPage->addElement($buttonExtern2);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonExtern2->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonExtern2->getId().'&quot;, false);">enable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.hide(&quot;'.$buttonExtern2->getId().'&quot;);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.show(&quot;'.$buttonExtern2->getId().'&quot;);">show</a></div>');
$htmlPage->addHTML("<br/><br/>");

$htmlPage->addHTML("<br/>external image<br/><br/>");
$htmlPage->addElement($buttonExtern3);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonExtern3->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.setDisabled(&quot;'.$buttonExtern3->getId().'&quot;, false);">enable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.hide(&quot;'.$buttonExtern3->getId().'&quot;);">hide</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Button.show(&quot;'.$buttonExtern3->getId().'&quot;);">show</a></div>');
$htmlPage->addHTML("<br/><br/>");


$htmlPage->addHTML('<div><a href="javascript:appendButton();">append Button</a></div>');
$htmlPage->addHTML('<div id="newButtons"></div>');
$js = <<<endOfScript
function appendButton() {
	buttonHtml = '{$newButton->getJSHTML()}';
	var container = document.body;
	we_ui_controls_Button.addButton('{$newButton->getId()}__INDEX__', buttonHtml, container);
}
endOfScript;
$htmlPage->addInlineJS($js);
$htmlPage->addHTML("<br/><br/>");

print $htmlPage->getHTML();

?>