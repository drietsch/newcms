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

/*
	data of variaiations have the following format in document

	we_doc->elements[WE_SHOP_VARIANTS_ELEMENT_NAME] = array(
		[0] => array(
			'VARIATIONNAME1' => array(
				'fieldName1' => array(
					'type' = 'txt',
					'dat' = 'Text'
				),
				'fieldName2' => array(
					'type' = 'img',
					'dat' = 152
				)
			),
		[1] => array(
			'VARIATIONNAME2' => array(
				'fieldName1' => array(
					'type' = 'txt',
					'dat' = 'CU'
				),
				'fieldName2' => array(
					'type' = 'img',
					'dat' = 155
				)
			)
		)
	)
	=====>>

	in editmode available in document
	we_doc->elements[WE_SHOP_VARIANTS_PREFIX . '0'] = array('type' = 'txt', 'dat' = 'VARIATIONNAME1');
	we_doc->elements[WE_SHOP_VARIANTS_PREFIX . '0' . '_' . fieldName1] = array('type' = 'txt', 'dat' = 'Text');
	we_doc->elements[WE_SHOP_VARIANTS_PREFIX . '0' . '_' . fieldName2] = array('type' = 'img', 'dat' = 152);

	we_doc->elements[WE_SHOP_VARIANTS_PREFIX . '1'] = array('type' = 'txt', 'dat' = 'VARIATIONNAME2');
	we_doc->elements[WE_SHOP_VARIANTS_PREFIX . '1' . '_' . fieldName1] = array('type' = 'txt', 'dat' = 'CU');
	...
*/

class weShopVariants {

	/**
	 * Searchs all elements of document/object
	 * fetches all variation-data in one single field
	 * and deletes all other fields
	 * when not save, the field is resettet for the editor
	 *
	 * @param object $model
	 * @param boolean $save
	 */
	function correctModelFields(&$model, $save=true) {

		$elements = $model->elements;

		// all variant fields must be stored in one single field of the content table

		// store variationfields in one array
		$variationElements = array();

		foreach ($elements as $element => $elemArr) {


			if (strpos($element, WE_SHOP_VARIANTS_PREFIX) !== false) {

				$variationElements[$element] = $elemArr;
				if ($save) {
					$model->elements[$element] = null;
					unset($model->elements[$element]);
				}
			}
		}
		// :ATTENTION: if nr of variants is > 10 a ksort of the elements is not
		// enough to build blocks of data of a single variant.
		ksort($variationElements);

		$variationElement = array();
		$nameOfPosition = array();

		// :ATTENTION: if nr of variants is > 10 a ksort of the elements is not
		// enough to build blocks of data of a single variant.
		foreach ($variationElements as $element => $data) {

			$elemNr = weShopVariants::getNrFromElemName($element);

			if (!isset($nameOfPosition["nameof_$elemNr"])) {
				$nameOfPosition["nameof_$elemNr"] = $data['dat'];
				$variationElement[$elemNr][$nameOfPosition["nameof_$elemNr"]] = array();

			} else {
				$fieldName = weShopVariants::getFieldNameFromElemName($element);
				$variationElement[$elemNr][$nameOfPosition["nameof_$elemNr"]][$fieldName] = $data;

			}

		}

		// now create element for the model
		// just overwrite new values ...
		$model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['type'] = 'variant';
		$model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'] = ($save ? serialize($variationElement) : $variationElement);
	}

	/**
	* this function is reverse function to correctModelFields
	* initialises variant data in the model and stores them in special fields
	* @param object $model
	* @param boolean $unserialize
	*/
	function setVariantDataForModel(&$model, $unserialize=false) {

		// set variation data from array and

		$elements = $model->elements;

		if (isset($elements[WE_SHOP_VARIANTS_ELEMENT_NAME])) {

			if ($unserialize) {
				$model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'] =
					is_array($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat']) ?
					$model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'] :
					(
						(substr($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'],0,2) == "a:") ?
						unserialize($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat']) :
						array()
					);

				$elements = $model->elements;
			}

			$variations = $elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'];

			for ($i = 0; $i <sizeof($variations); $i++) {

				$variation = $variations[$i];

				if (is_array($variation)) {

					foreach ($variation as $name => $varArr) {

						$model->elements[WE_SHOP_VARIANTS_PREFIX . $i] = array(
							'type' => 'txt',
							'dat'  => $name
						);

						foreach ($varArr as $name => $datArr) {

							$model->elements[WE_SHOP_VARIANTS_PREFIX . $i . '_' . $name] = $datArr;
						}
					}
				}
			}
		}
	}

	function getNrFromElemName($elemName) {

		$elemPos = substr($elemName, strlen(WE_SHOP_VARIANTS_PREFIX));
		$elemPos = preg_replace('/_(.*)/', '', $elemPos);

		return $elemPos;
	}

	function getFieldNameFromElemName($elemName) {

		$fieldNameTmp = substr($elemName, strlen(WE_SHOP_VARIANTS_PREFIX));
		$fieldName = preg_replace("/(\d+_*)/", "", $fieldNameTmp, 1);

		if ($fieldNameTmp == $fieldName) {
			return '';
		} else {
			return $fieldName;
		}
	}

	function getNumberOfVariants(&$model) {

		if ( isset($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]) && is_array($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'])) {

			return sizeof($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat']);
		}

		return 0;
	}

	function insertVariant(&$model, $position) {

		$amount = weShopVariants::getNumberOfVariants($model);

		// init model->elements if neccessary

		if (!isset($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]) || !isset($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat']) || !is_array($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'])) {

			$model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME] = array();
			$model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'] = array();
		}

		// add new element at end of array, move it when neccesary
		array_push(
			$model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'],
			weShopVariants::createNewVariantElement($model)
		);

		// now move element, it is actually at last position
		if ($amount > $position) { // move all elements

			$newElemPos = $amount;
			while ($position < $newElemPos) {
				weShopVariants::changeVariantPosition($newElemPos, --$newElemPos, $model);
			}
		}
	}

	function createNewVariantElement(&$model) {

		// :TODO: improve me
		return array();
	}

	function getAllVariationFields($model, $pos=false) {

		$elements = $model->elements;

		$variationElements = array();

		foreach ($elements as $element => $elemArr) {

			if (strpos($element, WE_SHOP_VARIANTS_PREFIX) !== false) {

				$variationElements[$element] = $elemArr;
			}
		}
		ksort($variationElements);

		if ($pos === false) {
			return $variationElements;
		} else {
			foreach ($variationElements as $name => $value) {
				if (weShopVariants::getNrFromElemName($name) != $pos) {
					unset($variationElements[$name]);
				}
			}
			return $variationElements;
		}
	}

	function moveVariant(&$model, $pos, $direction) {

		// check if a move is possible
		if ($direction == 'up') {
			weShopVariants::changeVariantPosition($pos, ($pos-1), $model);
		} else {
			weShopVariants::changeVariantPosition($pos, ($pos+1), $model);
		}
	}

	/**
	 * @param integer $pos1
	 * @param integer $pos2
	 * @param array $model
	 */
	function changeVariantPosition($pos1, $pos2, &$model) {

		// first move all fields in the $modell
		$tmp = $model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'][$pos1];
		$model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'][$pos1] = $model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'][$pos2];
		$model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'][$pos2] = $tmp;
		// move elements for editmode
		$variationElements_1 = weShopVariants::getAllVariationFields($model, $pos1);
		$variationElements_2 = weShopVariants::getAllVariationFields($model, $pos2);

		// backup pos 1
		$tmp = array();
		foreach ($variationElements_1 as $name => $arr) {
			$tmp[$name] = $arr;
			unset($model->elements[$name]);
		}

		// overwrite pos 1 with pos 2
		foreach ($variationElements_2 as $name => $arr) {
			$model->elements[weShopVariants::getNameForPosition($name, $pos1)] = $model->elements[$name];
			unset($model->elements[$name]);

		}

		// restore pos 1 to pos2
		foreach ($tmp as $name => $arr) {
			$model->elements[weShopVariants::getNameForPosition($name, $pos2)] = $tmp[$name];
		}
		// delete backup
		unset($tmp);
	}

	function getNameForPosition($name, $pos) {

		if (($fieldName = weShopVariants::getFieldNameFromElemName($name)) == '') {
			return WE_SHOP_VARIANTS_PREFIX . $pos;
		} else {
			return WE_SHOP_VARIANTS_PREFIX . $pos . '_' . weShopVariants::getFieldNameFromElemName($name);
		}
	}

	function removeVariant(&$model, $delPos) {

		$total = weShopVariants::getNumberOfVariants($model);

		$lastPos = $total - 1;

		// move at last position, then remove it
		while ($delPos < $lastPos) {

			weShopVariants::moveVariant($model,$delPos++,'down');
		}

		// first remove all fields from doc
		$variationFields = weShopVariants::getAllVariationFields($model, $delPos);
		foreach ($variationFields as $name => $dat) {
			unset($model->elements[$name]);
		}
		if (is_array( ($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'][$delPos]) )) {
			unset($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'][$delPos]);
		}
	}

	function getVariantsEditorMultiBoxArrayObjectFile($model) {

		$we_button = new we_button();

		$variantFields = $model->getVariantFields();

		$count = weShopVariants::getNumberOfVariants($model);

		$i = 0;
		$ret = '';
		$parts = array();

		if ($count > 0) {

			for ($i=0; $i<$count; $i++) {
				$plusBut = $we_button->create_button("image:btn_add_field", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('shop_insert_variant','".($i)."');",true,40);
				$upbut   = ($i == 0 ? $we_button->create_button("image:btn_direction_up", "", true, 21, 22, "", "", true) : $we_button->create_button("image:btn_direction_up", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('shop_move_variant_up','".($i)."');"));
				$downbut = ($i == ($count-1) ? $we_button->create_button("image:btn_direction_down", "", true, 21, 22, "", "", true): $we_button->create_button("image:btn_direction_down", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('shop_move_variant_down','".($i)."');"));
				$trashbut   = $we_button->create_button("image:btn_function_trash", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('shop_remove_variant','".($i)."');",true,30);

				$content = '<table border="0" class="defaultgray" width="700">
<tr>
		<td width="200"><span class="defaultfont"><b>Name</b></span></td>
</tr>
<tr>
		<td>' . $model->getFieldHTML(WE_SHOP_VARIANTS_PREFIX . $i, 'input', array(), true, true) . '</td>
		<td>
			<table class="defaultgray" align="right" width="120">
				<tr>
					<td>' . $plusBut . '</td>
					<td>' . $upbut . '</td>
					<td>' . $downbut . '</td>
					<td>' . $trashbut . '</td>
				</tr>
			</table>
		</td>
	</tr>';

				foreach ($variantFields as $realName => $attributes) {

					$fieldInfo = explode('_', $realName);

					$type = $fieldInfo[0];
					$realname = $fieldInfo[1];

					$name = WE_SHOP_VARIANTS_PREFIX . $i . '_' . $realname;

					$content .= '<tr>
						<td><span class="defaultfont"><b>' . $realname . '</b></span><div class="objectDescription">' . (isset($model->DefArray[$type . '_' . $realname]['editdescription']) ? $model->DefArray[$type . '_' . $realname]['editdescription'] : '') . '</div></td>
						</tr>
						<tr>
						<td>' . $model->getFieldHTML($name, $type, $attributes, true, true) . '</td>
						</tr>
						<tr>
							<td>' . getPixel(1,8) . '</td>
						</tr>
					';
				}
				$content .= '</table>';
				array_push($parts, array(	'headline'=>'',
											'html' => $content,
											'space' => 0
									)
				);
			}
		}
		$plusBut = $we_button->create_button("image:btn_add_field", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('shop_insert_variant','".($i)."');");
		$content = $plusBut;

		array_push($parts, array(	'headline'=>'',
									'html' => $content,
									'space' => 0
								)
		);
		return $parts;
	}

	function getVariantsEditorMultiBoxArray($model) {

		$we_button = new we_button();

		$variationFields = $model->getVariantFields();

		$count = weShopVariants::getNumberOfVariants($model);

		$i = 0;
		$ret = '';
		$parts = array();

		if ($count > 0) {

			for ($i=0; $i<$count; $i++) {
				$plusBut = $we_button->create_button("image:btn_add_field", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('shop_insert_variant','".($i)."');",true,40);
				$upbut   = ($i == 0 ? $we_button->create_button("image:btn_direction_up", "", true, 21, 22, "", "", true) : $we_button->create_button("image:btn_direction_up", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('shop_move_variant_up','".($i)."');"));
				$downbut = ($i == ($count-1) ? $we_button->create_button("image:btn_direction_down", "", true, 21, 22, "", "", true): $we_button->create_button("image:btn_direction_down", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('shop_move_variant_down','".($i)."');"));
				$trashbut   = $we_button->create_button("image:btn_function_trash", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('shop_remove_variant','".($i)."');",true,30);
				$previewBut = $we_button->create_button("image:btn_function_view", "javascript:we_cmd('shop_preview_variant','" . $GLOBALS['we_transaction'] . "','".($model->getElement(WE_SHOP_VARIANTS_PREFIX . $i))."');",true,30);

				$content = '<table border="0" class="defaultgray" width="700">
<tr>
	<td width="200" class="defaultfont"><b>Name</b></td>
</tr>
<tr>
	<td>' . $model->formTextInput('input', WE_SHOP_VARIANTS_PREFIX . $i, '') . '</td>
		<td>
			<table class="defaultgray" align="right">
				<tr>
					<td>' . $previewBut . '</td>
					<td>&nbsp;&nbsp;</td>
					<td>' . $plusBut . '</td>
					<td>' . $upbut . '</td>
					<td>' . $downbut . '</td>
					<td>' . $trashbut . '</td>
				</tr>
			</table>
		</td>
	</tr>';

				foreach ($variationFields as $name => $fieldInformation) {

					$fieldInformation['attributes']['name'] = WE_SHOP_VARIANTS_PREFIX . $i . '_' . $fieldInformation['attributes']['name'];
					$content .= '<tr>';
					$content .= '
						<td class="defaultfont"><b>' . $name . '</b></td>
						</tr>
						<tr>
						<td>' . we_tag($fieldInformation['type'], $fieldInformation['attributes'], (isset($fieldInformation['content']) ? $fieldInformation['content'] : '')) . '</td>
					';
					$content .= '<tr>';
				}
				$content .= '</table>';

				array_push($parts, array(	'headline'=>'',
											'html' => $content,
											'space' => 0
									)
				);
			}
		}
		$plusBut = $we_button->create_button("image:btn_add_field", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('shop_insert_variant','".($i)."');");
		$content = $plusBut;

		array_push($parts, array(	'headline'=>'',
									'html' => $content,
									'space' => 0
								)
		);
		return $parts;
	}

	function useVariant(&$model, $name) {

		$variantDatArray = $model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'];

		$model->Variant = $name;

		for ($i=0; $i<sizeof($variantDatArray); $i++) {

			$variant = $variantDatArray[$i];
			if (is_array($variant)) {
				foreach ($variant as $variantName => $variantData) {
	
					if ($variantName == $name) {
	
						foreach ($variantData as $elementName => $elementData) {
							$model->elements[$elementName] = $elementData;
						}
					}
				}
			}
		}
	}


	/**
	 * This function sets variant data for serialised document in the shopping basket
	 * different function, due to performance reasons and the shop itself
	 *
	 * @param array $record
	 * @param string $name
	 */
	function useVariantForShop(&$record, $name) {

		if (isset($record[WE_SHOP_VARIANTS_ELEMENT_NAME])) {

			$variantDatArray = unserialize($record[WE_SHOP_VARIANTS_ELEMENT_NAME]);

			for ($i=0; $i<sizeof($variantDatArray); $i++) {

				$variant = $variantDatArray[$i];

				foreach ($variant as $variantName => $variantData) {

					if ($variantName == $name) {

						foreach ($variantData as $elementName => $elementData) {

							if ($elementData['type'] == 'img') {
								$record[$elementName] = $elementData['bdid'];
							} else {
								$record[$elementName] = $elementData['dat'];
							}
						}
					}
				}
			}
		}
	}

	/**
	 * This function sets variant data for serialised object in the shopping basket
	 * different function, due to performance reasons and the shop itself
	 *
	 * @param array $record
	 * @param string $name
	 * @param we_objectFile $model
	 */
	function useVariantForShopObject(&$record, $name, $model) {


		if (isset($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME])) {

			$variantDatArray = $model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'];

			for ($i=0; $i<sizeof($variantDatArray); $i++) {

				$variant = $variantDatArray[$i];

				foreach ($variant as $variantName => $variantData) {

					if ($variantName == $name) {

						foreach ($variantData as $elementName => $elementData) {

							// fields have the prefix we_
							if ($elementData['type'] == 'img') {
								$record["we_$elementName"] = isset($elementData['bdid']) ? $elementData['bdid'] : '';
							} else {
								$record["we_$elementName"] = isset($elementData['dat']) ? $elementData['dat'] : '';
							}
						}
					}
				}
			}
		}
	}

	function getVariantData($model, $defaultname) {

		if (isset($model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME])) {

			// add default data to listview
			$elements = $model->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'];

			$newPos = sizeof($elements);

			if($newPos>0) {

				$elemdata = $elements[0];
				if (is_array($elemdata)){

					foreach ( $elemdata as $name => $varArr) {
	
						foreach ($varArr as $key => $fieldArr) {
	
							if (isset($model->elements[$key])) {
								$elements[$newPos][$defaultname][$key] = $model->elements[$key];
							}
						}
					}
				}

			}

			return $elements;

		} else {

			return array();
		}

	}
}
?>