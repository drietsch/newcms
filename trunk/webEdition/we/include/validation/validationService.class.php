<?php
    // +----------------------------------------------------------------------+
    // | webEdition                                                           |
    // +----------------------------------------------------------------------+
    // | PHP version 4.1.0 or greater                                         |
    // +----------------------------------------------------------------------+
    // | Copyright (c) 2000 - 2007 living-e AG                                |
    // +----------------------------------------------------------------------+

    class validationService{
        
        var $id;
        
        var $art;       //  custom | default
        var $category;  //  xhtml | link | css | accessibility
        
        var $name;
        var $host;
        var $path;
        var $method;
        var $varname;
        var $checkvia;
        var $additionalVars;
        var $ctype;
        
        var $fileEndings;
        
        var $active;
        
        function validationService($id=0,$art="",$category="",$name="",$host="",$path="",$method="",$varname="",$checkvia="",$ctype="",$additionalVars="",$fileEndings="",$active=1){
            
            $this->id = $id;        //  id to edit this service
            
            $this->art = $art;
            $this->category = $category;
            
            $this->name = $name;
            $this->host = $host;
            $this->path = $path;
            $this->method = $method;
            $this->varname = $varname;
            $this->checkvia = $checkvia;
            $this->ctype = $ctype;
            $this->additionalVars = $additionalVars;
            
            $this->fileEndings = $fileEndings;
            
            $this->active = $active;
        }
        
        function getName(){
            return $this->art . '_' . $this->id;
        }
    }
?>