<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

$tabs = new we_ui_controls_Tabs();
$tabs->setID('tabContainer');
$tabs->setTabs(array(
					array(
						'id'=>'tab1', 
						'text'=>'Click me to alert!', 
						'onClick'=>'alert("do something first!");', 
						'title'=>'Click me to alert!',
						'reload'=>true,
						'hidden'=>false
					),
					array(
						'id'=>'tab2', 
						'text'=>'Tab 2', 
						'title'=>'Tab 2',
						'hidden'=>false,
						'reload'=>false,
						'active'=>true
					),
					array(
						'id'=>'tab3', 
						'text'=>'Tab 3', 
						'hidden'=>false,
						'title'=>'Tab 3'
					),
					array(
						'id'=>'tab4', 
						'text'=>'Tab 4 lang', 
						'hidden'=>false,
						'title'=>'Tab 4'
					),
					array(
						'id'=>'tab5', 
						'text'=>'Tab 5', 
						'hidden'=>false,
						'title'=>'Tab 5'
					),
					array(
						'id'=>'tab6', 
						'text'=>'Tab 6', 
						'disabled'=>true,
						'title'=>'Tab 6'
					),
					array(
						'id'=>'tab7', 
						'text'=>'Tab 7', 
						'hidden'=>false,
						'title'=>'Tab 7'
					),
					array(
						'id'=>'tab8', 
						'text'=>'Tab 8', 
						'hidden'=>true,
						'title'=>'Tab 8'
					),
					array(
						'id'=>'tab9', 
						'text'=>'Tab 9', 
						'hidden'=>false,
						'title'=>'Tab 9'
					),
					array(
						'id'=>'tab10', 
						'text'=>'Tab 10', 
						'hidden'=>false,
						'title'=>'Tab 10'
					),
					array(
						'id'=>'tab11', 
						'text'=>'Tab 11', 
						'hidden'=>false,
						'title'=>'Tab 11'
					),
					array(
						'id'=>'tab12', 
						'text'=>'TAB IN TAB', 
						'hidden'=>false,
						'title'=>'Tab 12'
					)
				)
			);

$tabs2 = new we_ui_controls_Tabs(
	array(
		'disabled'=>false, 
		'id'=>'tabContainer2',
		'width'=>400, 
		'tabs'=>array(
					array(
						'id'=>'tabx', 
						'text'=>'Tab x', 
						'onClick'=>'alert("tabx!");', 
						'title'=>'Tab x',
						'hidden'=>false
					),
					array(
						'id'=>'tabxx', 
						'text'=>'Tab xx', 
						'title'=>'Tab xx',
						'hidden'=>false,
						'active'=>true
					),
					array(
						'id'=>'tabxxx', 
						'text'=>'Tab xxx', 
						'hidden'=>false,
						'title'=>'Tab xxx'
					)
				),
		'hidden'=>false
	)
);

$tabs3 = new we_ui_controls_Tabs(
	array(
		'disabled'=>false, 
		'width'=>400, 
		'tabs'=>array(
					array(
						'id'=>'tabr', 
						'text'=>'Tab r', 
						'onClick'=>'alert("tabr!");', 
						'title'=>'Tab r',
						'hidden'=>false,
						'icon'=>we_ui_layout_Image::kTreeIconAudio
					),
					array(
						'id'=>'tabrr', 
						'text'=>'Tabrr', 
						'title'=>'Tab rr',
						'hidden'=>false,
						'active'=>true,
						'bottomline'=>true,
						'close'=>true,
						'onCloseClick'=>'alert("close!");', 
						'icon'=>we_ui_layout_Image::kTreeIconCss
					),
					array(
						'id'=>'tabrrr', 
						'text'=>'Tab rrr', 
						'hidden'=>false,
						'title'=>'Tab rrr',
						'icon'=>we_ui_layout_Image::kTreeIconExcel
					)
				),
		'hidden'=>false
	)
);

$htmlPage = we_ui_layout_HTMLPage::getInstance();

$htmlPage->setTitle('Hallo webEdition');

$htmlPage->addElement($tabs);

$htmlPage->addInlineJS("
			function submitForm(target, action, method) {
				var f = self.document.we_form;
				if (target) {
					f.target = target;
				}
			
				if (action) {
					f.action = action;
				}
			
				if (method) {
					f.method = method;
				}
			
				f.submit();
			}

			function mark() {
					var elem = document.getElementById('mark');
					elem.style.display = 'inline';

				}

				function unmark() {
					var elem = document.getElementById('mark');
					elem.style.display = 'none';
				}
			
			function setFrameSize(){
				if(document.getElementById('we_ui_controls_Tabs_Container').offsetWidth > 0) {
					var fs = parent.document.getElementsByTagName(\"FRAMESET\")[0];
					var tabsHeight = document.getElementById('main').offsetHeight;
					var fsRows = fs.rows.split(',');
					fsRows[0] = tabsHeight;
					fs.rows =  fsRows.join(\",\");
				} else {
					setTimeout(\"setFrameSize()\",100);
				}
			}			

		");

$htmlPage->addHTML('<form name="we_form">');
$htmlPage->addHTML('<input type="hidden" name="activTab" value="" />');
$htmlPage->addHTML('<div id="tab1" style="display: none">tab1</div>');

$htmlPage->addHTML('<div id="tab2" style="display: block">tab2</div>');

$htmlPage->addHTML('<div id="tab3" style="display: none">tab3</div>');
$htmlPage->addHTML('<div id="tab4" style="display: none">tab4</div>');
$htmlPage->addHTML('<div id="tab5" style="display: none">tab5</div>');
$htmlPage->addHTML('<div id="tab6" style="display: none">tab6</div>');
$htmlPage->addHTML('<div id="tab7" style="display: none">tab7</div>');
$htmlPage->addHTML('<div id="tab8" style="display: none">tab8</div>');
$htmlPage->addHTML('<div id="tab9" style="display: none">tab9</div>');
$htmlPage->addHTML('<div id="tab10" style="display: none">tab10</div>');
$htmlPage->addHTML('<div id="tab11" style="display: none">tab11</div>');
$htmlPage->addHTML('<div id="tab12" style="display: none">');
$htmlPage->addHTML('<br><br><br>');
$htmlPage->addElement($tabs2);
$htmlPage->addHTML('<div id="tabx" style="display: none">tabx</div>');

$htmlPage->addHTML('<div id="tabxx" style="display: block">tabxx</div>');

$htmlPage->addHTML('<div id="tabxxx" style="display: none">tabxxx</div>');

$htmlPage->addHTML('</div>');

$htmlPage->addHTML('<br><br><br>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Tabs.setTabClass(\''.$tabs->getId().'\',\'tab12\'); we_ui_controls_Tabs.setTab(\''.$tabs->getId().'\',\'tab12\',\'\');">show tab 12</a></div>');


$htmlPage->addHTML('<br><br><br>');
$htmlPage->addElement($tabs3);

$htmlPage->addHTML('<div id="tabr" style="display: none">tabr</div>');

$htmlPage->addHTML('<div id="tabrr" style="display: block">tabrr</div>');

$htmlPage->addHTML('<div id="tabrrr" style="display: none">tabrrr</div>');
$htmlPage->addHTML('</form>');

print $htmlPage->getHTML();

?>