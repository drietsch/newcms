<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

/**
 * This class can create a HTTP Request. It is possible to submit data to a certain web-site
 * via POST or GET.
 */
class HttpRequest{
    
    var $http_path     = '';
    var $http_host     = '';
    var $http_method   = '';
    var $http_protocol = '';
    
    var $http_port = 80;
    
    var $http_headers  = array();
    var $http_body = '';
    var $http_response = '';
    
    
    //  datas to submit
    var $files = array();   //  files array
    var $vars  = array();   //  array with variables
    
    // in case something went wrong with the connection
    var $error  = false;
    var $errno  = 0;
    var $errstr = 0;
    

    function HttpRequest($path, $host, $method='POST', $protocol='HTTP/1.0'){
        
        $this->http_path     = $path;
        $this->http_host     = $host;
        $this->http_method   = (strtoupper($method) == 'GET' ? 'GET' : 'POST');    //  only get or post is allowed
        
        $this->http_protocol = $protocol;
        $this->http_headers["Host"] = $host;
    }
    
   /**
    * @return void
    * @param string $varname
    * @param string $content
    * @param string $contentType
    * @param string $filename
    * @desc This function adds a file to the HTTP-Request, by given varname (of form), content, content-type and filename
    */
    function addFileByContent($varname, $content, $contentType="text/html", $filename="foo.html"){
        
        $this->files[] = array(
            'varname'     => $varname,
            'filename'    => $filename,
            'contentType' => $contentType,
            'content'     => $content
        );
    }
    
   /**
    * @return bool
    * @param string $path
    * @param string $varname
    * @param string $contentType
    * @param string $filename
    * @desc This function adds a file by path (could be a web-path) and adds it to the HttpRequest.
    *       returns false, when file does not exist.
    */
    function addFileByPath($path, $varname, $contentType="text/html", $filename="foo.html"){
        
        if(file_exists($path)){
            
            $fileArr = file($path);
            $content = implode("\r\n", $fileArr);
            
            $this->addFileByContent($varname, $content, $contentType, $filename);
            return true;
        }
        return false;
    }
    
   /**
    * @return void
    * @param string $name
    * @param string $value
    * @desc Adds a header to the HTTP-Request
    */
    function addHeader($name, $value){
        
        $this->http_headers[trim($name)] = trim($value);
        
    }
    
   /**
    * @return void
    * @param array $headers
    * @desc Adds associative (name => value) to the headers of the Request
    */
    function addHeaders($headers){
        
        foreach($headers as $k => $v){
            $this->http_headers[trim($k)] = trim($v);
        }
        
    }
    
   /**
    * @return void
    * @param string $name
    * @param string $value
    * @desc Adds variable by name and value to the Variables
    */
    function addVar($name, $value){
        $this->vars[] = array(
            'name'  => $name,
            'value' => $value
        );
    }
    
   /**
    * @return void
    * @param array $varsAr
    * @desc Adds associative array (name => value) to the variables of the form
    */
    function addVars($varsAr){
        foreach($varsAr as $k => $v){
            $this->addVar($k,$v);
        }
    }
    
	/**
    * @return void
    * @desc executes the HTTP Request via curl, saves errors in $error - or response in var $http_response
    */
    function executeCurlHttpRequest() {
    	
			$path = $this->http_path;
    		$_sizeVars  = sizeof($this->vars);
	        for($i=0;$i<$_sizeVars;$i++){
	            
	            $var = $this->vars[$i];
	            
	            $path .= ($i == 0 ? '?' : '&');
	            $path .= $var["name"] . "=" . $var["value"];
	        }
    		

    		$this->getHttpRequest();
    		
			$_header[] = $this->http_method . " " . $path . " " . $this->http_protocol;
			foreach($this->http_headers as $k => $v){
				$_header[] = "$k: $v";
			}
			$_header[] = "Connection: close \r\n";
        	$_header[] = $this->http_body;
            
    		$_session = curl_init();    		
			curl_setopt($_session, CURLOPT_URL,$this->http_host.$this->http_path);			
			curl_setopt($_session, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($_session, CURLOPT_CUSTOMREQUEST,'POST');
			curl_setopt($_session, CURLOPT_HEADER , 1);
			curl_setopt($_session, CURLOPT_HTTPHEADER, $_header);
    		
			$_data = curl_exec($_session);
		
			if (curl_errno($_session)) {
				$this->error = true;
	            $this->errno = 1;
	            $this->errstr = curl_error($_session);
			} else {
				$this->http_response = $_data;
    			$this->error = false;    			
	 			curl_close($_session);
			}
    }
    
   /**
    * @return void
    * @desc executes the HTTP Request, saves errors in $error - or response in var $http_response
    */
    function executeHttpRequest(){
        
    	$_http_opt = getHttpOption();
    	
		if($_http_opt=='fopen') {
    	
			$req = $this->getHttpRequest();
	
	        $socket = @fsockopen($this->http_host, $this->http_port, $errno, $errstr, 1);
	        
	        if($socket){    //  connection etablished
	
	            fwrite($socket, $req);
	            $response = '';
	            while(!feof($socket)){
	                $response .= fgets($socket, 1024);
	            }
	            fclose($socket);
	            
	            $this->http_response = $response;
	            
	        } else {    //  something wrong happened
	            
	            $this->error = true;
	            $this->errno = $errno;
	            $this->errstr = $errstr;
	        }			
			
		} else if($_http_opt == 'curl') {
    		
    		$this->executeCurlHttpRequest();
    		
    	} else {
    	    $this->error = true;
			$this->errno = 1;
			$this->errstr = 'Server error: Unable to open URL (php configuration directive allow_url_fopen=Off)';
    	}
    }
    
   /**
    * @return string
    * @desc Builds and returns the Http-Request from the given values
    */
    function getHttpRequest(){
        
        //  first build body of request, then headers
        $body = '';
        
        $_sizeFiles = sizeof($this->files);
        $_sizeVars  = sizeof($this->vars);
        
        $path = $this->http_path;
        
        if($_sizeFiles || $_sizeVars){
            
            //  it is necessary to differ from POST/GET requests
            if($this->http_method == 'POST'){   //  method 'POST'
            
                //  boundary to seperate between different content blocks
                $boundary = 'accessibility_' . (uniqid('webEdition') . time());
                
                for($i=0;$i<$_sizeFiles;$i++){
                    
                    $file = $this->files[$i];
                    
                    //  important not ot forget the leading '--'
                    $body .= '--' . $boundary . "\r\n";
                    $body .= "Content-Disposition: form-data; name=\"" . $file["varname"] . "\"; filename=\"" . $file["filename"] . "\"" . "\r\n";
                    $body .= "Content-Type: " . $file["contentType"] . "\r\n";
                    $body .= "\r\n" . $file["content"] . "\r\n";
                    
                }
                
                for($i=0;$i<$_sizeVars;$i++){
                    
                    $var = $this->vars[$i];
                    $body .= "--" . $boundary . "\r\n";
                    $body .= "Content-Disposition: form-data; name=\"" . $var["name"] . "\"" . "\r\n";
                    $body .= "\r\n" . $var["value"] . "\r\n";
                }
                //  at last boundary we must attach '--'
                $body .= "--" . $boundary . "--\r\n";
                
                //  add 2 more headers for this request
                $this->http_headers['Content-Type']   = "multipart/form-data; boundary=$boundary";
                $this->http_headers['Content-Length'] = strlen($body);
                
            } else {    //  method 'GET'
                //  all variables are joined to the path
                for($i=0;$i<$_sizeVars;$i++){
                    
                    $var = $this->vars[$i];
                    
                    $path .= ($i == 0 ? '?' : '&');
                    $path .= $var["name"] . "=" . $var["value"];
                }
            }
            
            
        } else {    //  no files or vars to submit
            
        }
        
        $this->http_body = $body;
        
        /*
            Build header for this Request
        */
        $head = $this->http_method . " " . $path . " " . $this->http_protocol . "\r\n";
        foreach($this->http_headers as $k => $v){
            $head .= "$k: $v\r\n";
        }
        $head .= "\r\n";
        
        return $head . $body;
    }
    
   /**
    * @return string
    * @desc returns the raw - httpResponse including header and content
    */
    function getHttpResponseStr(){
        
        if($this->error){
           return "";
        } else {
            return $this->http_response;
        }
    }
    
   /**
    * @return void
    * @param int $port
    * @desc sets the port for this http Request
    */
    function setPort($port=80){
        $this->http_port = $port;
    }
}
?>