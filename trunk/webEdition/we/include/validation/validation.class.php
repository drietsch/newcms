<?php
    // +----------------------------------------------------------------------+
    // | webEdition                                                           |
    // +----------------------------------------------------------------------+
    // | PHP version 4.1.0 or greater                                         |
    // +----------------------------------------------------------------------+
    // | Copyright (c) 2000 - 2007 living-e AG                                |
    // +----------------------------------------------------------------------+

    
    include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/accessibility.inc.php');
    
    class validation{
        
        function validation(){
            die('static class do not use constructor');
        }
        
        function getAllCategories(){
            
            global $l_validation;
            
            $cats = array(
                'xhtml'=>$l_validation['category_xhtml'],
                'links'=>$l_validation['category_links'],
                'css'=>$l_validation['category_css'],
                'accessibility'=>$l_validation['category_accessibility']
                );
            return $cats;
        }
        
        function saveService($validationService){
            
            global $DB_WE;
            
            // before saving check if another validationservice has this name
			$checkNameQuery = '
				SELECT *
				FROM ' . VALIDATION_SERVICES_TABLE . '
				WHERE name="' . $validationService->name . '"
					AND PK_tblvalidationservices != ' . $validationService->id . '
				';
			
			$DB_WE->query($checkNameQuery);
			if ($DB_WE->num_rows()) {
				
				$GLOBALS['errorMessage'] = $GLOBALS['l_validation']['edit_service']['servicename_already_exists'];
				return false;
			}
            
            
            if($validationService->id != 0){
                $query = '
                    UPDATE ' . VALIDATION_SERVICES_TABLE . '
                        SET category="' . $validationService->category . '",name="' . addslashes($validationService->name) . '",host="' . addslashes($validationService->host) . '",path="' . addslashes($validationService->path) . '",method="' . $validationService->method . '",varname="' . addslashes($validationService->varname) . '",checkvia="' . $validationService->checkvia . '",additionalVars="' . addslashes($validationService->additionalVars) . '",ctype="' . addslashes($validationService->ctype) . '",fileEndings="' . addslashes($validationService->fileEndings) . '",active="' . $validationService->active . '"
                        WHERE PK_tblvalidationservices = ' . $validationService->id;
            } else {
            	
                $query = '
                    INSERT INTO ' . VALIDATION_SERVICES_TABLE . '
                        (category, name, host, path, method, varname, checkvia, additionalVars, ctype, fileEndings, active)
                        VALUES("' . $validationService->category . '", "' . addslashes($validationService->name) . '", "' . addslashes($validationService->host) . '", "' . addslashes($validationService->path) . '", "' . $validationService->method . '", "' . addslashes($validationService->varname) . '", "' . $validationService->checkvia . '", "' . addslashes($validationService->additionalVars) . '", "' . addslashes($validationService->ctype) . '", "' . addslashes($validationService->fileEndings) . '", "' . $validationService->active . '");
                ';
            }
            
            if($DB_WE->query($query)){
                if($validationService->id == 0){
                    $id = f("SELECT LAST_INSERT_ID() as LastID FROM " . VALIDATION_SERVICES_TABLE,"LastID",$DB_WE);
                    $validationService->id = $id;
                }
                return $validationService;
            } else {
                return false;
            }
        }
        
        function deleteService($validationService){
            
            global $DB_WE;
            
            if($validationService->id != 0){
                $query = '
                    DELETE FROM ' . VALIDATION_SERVICES_TABLE . '
                        WHERE PK_tblvalidationservices = ' . $validationService->id;
                
                if($DB_WE->query($query)){
                    return true;
                }
            } else {
                //  not saved entry - must not be deleted from db
                return true;
            }
            return false;
        }
        
        function getValidationServices($mode='edit'){
            
            global $DB_WE,$we_doc;
            
            $_ret = array();
            
            switch($mode){
                
                case 'edit':
                    $query = '
                        SELECT *
                        FROM ' . VALIDATION_SERVICES_TABLE;
                    break;
                case 'use':
                    $query = '
                        SELECT *
                        FROM ' . VALIDATION_SERVICES_TABLE . '
                        WHERE fileEndings LIKE "%' . $we_doc->Extension . '%" AND active=1';
                    break;
            }
            
            $DB_WE->query($query);
            while($DB_WE->next_record()){
                $_ret[] = new validationService($DB_WE->f('PK_tblvalidationservices'),'custom',$DB_WE->f('category'),$DB_WE->f('name'),$DB_WE->f('host'),$DB_WE->f('path'),$DB_WE->f('method'),$DB_WE->f('varname'),$DB_WE->f('checkvia'),$DB_WE->f('ctype'),$DB_WE->f('additionalVars'),$DB_WE->f('fileEndings'),$DB_WE->f('active'));
            }
            return $_ret;
        }
    }
?>