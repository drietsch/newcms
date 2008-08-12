<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');


$select = new we_ui_controls_Select();
$select->setName('select');
$select->setMultiple(false);
$select->setSize(3);
$select->setHidden(false);
$select->setDisabled(false);
$select->setTitle('Titel');
$select->setOnChange('alert("onChange!");');
$select->setSelectedValue('3');
$select->setOptions(array(
				'1'=>'Option 1', 
				'2'=>'Option 2',  
				'3'=>'Option 3', 
				'4'=>'Option 4',  
				'5'=>'Option 5', 
				'6'=>'Option 6'
			));

$select2 = new we_ui_controls_Select(
	array(
		'name'=>'select2', 
		'multiple'=>true, 
		'size'=>3,
		'disabled'=>false, 
		'hidden'=>false,
		'onChange'=>'alert("onChange!");', 
		'title'=>'Titel 2',
		'selectedValue'=>'2',
		'options' => array(
				'1'=>'Option 1', 
				'2'=>'Option 2',  
				'3'=>'Option 3', 
				'4'=>'Option 4',  
				'5'=>'Option 5', 
				'6'=>'Option 6'
			)
	)
);

$select3 = new we_ui_controls_Select(
	array(
		'name'=>'select', 
		'multiple'=>true, 
		'size'=>16,
		'disabled'=>false, 
		'hidden'=>false,
		'title'=>'Titel 2',
		'width'=>150,
		'selectedValue'=>'2',
		'optgroups'=>array(
						array(
							'label' => 'group 1',
							'options' => array(
										'7'=>'Option 7', 
										'8'=>'Option 8',  
										'9'=>'Option 9', 
										'10'=>'Option 10',  
										'11'=>'Option 11', 
										'12'=>'Option 12'
									)
						),
						array(
							'label' => 'group 2',
							'options' => array(
										'13'=>'Option 13', 
										'14'=>'Option 14',  
										'15'=>'Option 15'
									)
						)
					),
		'options' => array(
				'1'=>'Option 1', 
				'2'=>'Option 2',  
				'3'=>'Option 3', 
				'4'=>'Option 4',  
				'5'=>'Option 5', 
				'6'=>'Option 6'
			)
	)
);

$select->addOption("7","added Option 7");

$addedOptions = array(
				'8'=>'new Option 8', 
				'9'=>'new Option 9'
			);
			
$select->setSelectedValue("5");

$select->addOptions($addedOptions);

$htmlPage = we_ui_layout_HTMLPage::getInstance();

$htmlPage->setTitle('Hallo webEdition');

$htmlPage->addInlineCSS('
body { 
		padding:10px !important;
}
');

$htmlPage->addElement($select);

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.setDisabled(&quot;'.$select->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.setDisabled(&quot;'.$select->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.show(&quot;'.$select->getId().'&quot;);">show</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.hide(&quot;'.$select->getId().'&quot;);">hide</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.insertOptionBeforeSelected(&quot;'.$select->getId().'&quot;, \'text1\', \'value1\');">insertOptionBefore</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.removeOptionSelected(&quot;'.$select->getId().'&quot;);">removeOptionSelected</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.addLastOption(&quot;'.$select->getId().'&quot;, \'text1\', \'value1\');">addLastOption</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.removeLastOption(&quot;'.$select->getId().'&quot;);">removeLastOption</a></div>');
$htmlPage->addHTML("<br>");
$htmlPage->addHTML($select->getOptionNum() . " Options");

$htmlPage->addHTML("<br><br><br><br>");

$htmlPage->addElement($select2);

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.setDisabled(&quot;'.$select2->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.setDisabled(&quot;'.$select2->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.show(&quot;'.$select2->getId().'&quot;);">show</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.hide(&quot;'.$select2->getId().'&quot;);">hide</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.insertOptionBeforeSelected(&quot;'.$select2->getId().'&quot;, \'text1\', \'value1\');">insertOptionBeforeSelected</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.removeOptionSelected(&quot;'.$select2->getId().'&quot;);">removeOptionSelected</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.addLastOption(&quot;'.$select2->getId().'&quot;, \'text1\', \'value1\');">addLastOption</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.removeLastOption(&quot;'.$select2->getId().'&quot;);">removeLastOption</a></div>');

$htmlPage->addHTML("<br><br><br><br>");

$htmlPage->addElement($select3);
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.setDisabled(&quot;'.$select3->getId().'&quot;, true);">disable</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.setDisabled(&quot;'.$select3->getId().'&quot;, false);">enable</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.show(&quot;'.$select3->getId().'&quot;);">show</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.hide(&quot;'.$select3->getId().'&quot;);">hide</a></div>');

$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.insertOptionBeforeSelected(&quot;'.$select3->getId().'&quot;, \'text1\', \'value1\');">insertOptionBeforeSelected</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.removeOptionSelected(&quot;'.$select3->getId().'&quot;);">removeOptionSelected</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.addLastOption(&quot;'.$select3->getId().'&quot;, \'text1\', \'value1\');">addLastOption</a></div>');
$htmlPage->addHTML('<div><a href="javascript:we_ui_controls_Select.removeLastOption(&quot;'.$select3->getId().'&quot;);">removeLastOption</a></div>');


print $htmlPage->getHTML();




?>