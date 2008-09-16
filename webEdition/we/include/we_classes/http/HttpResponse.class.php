<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

class HttpResponse{
    
    var $response = ""; // raw response, containing all headers and body
    
    var $http_answer = array(
                        'prot' => '',
                        'code' => 0,
                        'msg'  => ''); // possibility to check the answercode
    
    var $http_headers = array();  // http headers in associative array
    var $http_body = ""; // http body
    
    
    
    var $error = false;
    
    function HttpResponse($response){
        
        $this->response = $response;
        $this->_segmentResponse($response);
    }
    
   /**
    * @return void
    * @param string $response
    * @desc segments the response in header (associative array(name => value)) and body (str).
    *                Sets error, when lineendigs are not recognized
    */
    function _segmentResponse($response){

        // segment response in headers and body
        // known seperators are "\r\n\r\" or "\n\n"
        if( $pos = strpos($response, "\r\n\r\n") ){
            $lbr = "\r\n";
        } else if ($pos = strpos($response, "\n\n")){
            $lbr = "\n";
        } else {    //  line ends not supported
            $this->error = true;
        }
        
        if(!$this->error){  //  $lbr is recognized seems to be a correct HttpResponse
            /*
                First seperate the header and fill it in array $this->headers of object.
            */
            $headerstr = substr($response, 0, $pos);    //  string containing the whole header
            $headerList = explode($lbr, $headerstr);    //  each headerline is entry in array
            
            $headers = array();
            
            for($i=0;$i<sizeof($headerList);$i++){
                
                $_line = explode(":", $headerList[$i]);
                
                if(isset($_line[1])){   //  normal header
                
                    $headers[trim($_line[0])] = trim($_line[1]);
                    
                } else {                //  this is first line with http answer

                    if(preg_match('/(.+) (.+) (.+)/sie', $headerList[$i], $matches)){
                    
                        $this->http_answer['prot'] = $matches[1];
                        $this->http_answer['code'] = $matches[2];
                        $this->http_answer['msg']  = $matches[3];
                    }
                }
            }
            $this->http_headers = $headers;
            
            $this->http_body = $response;
            
            /*
                Next take the remaining body and save in object-var: $this->body
                If transfer encoding is set to chunk, rejoin the body
            */
             // ltrim: removes leading \r\n to simplify, $pos is start of body
            $bodyStr = ltrim(substr($response, $pos));
            
            //  is output chunked ?
            //temporary disabled
            if(false && isset($this->http_headers['Transfer-Encoding']) && $this->http_headers['Transfer-Encoding'] == 'chunked'){
                
                $body = "";
                
                //  chunkseperator is $lbr<LENGTH>$lbr
                do{
                	
                    $chunkhex = substr($bodyStr,0,strpos($bodyStr,$lbr));   //  hex value of chunksize
                    $chunkdec = hexdec($chunkhex);  //  dec size fo chunk
                    
                    $body .= substr($bodyStr, (strlen($chunkhex) + strlen($lbr)), ($chunkdec) );
                    $bodyStr = substr($bodyStr, ($chunkdec + strlen($chunkhex) + 2*strlen($lbr)));
                    
                } while($chunkhex !== "0");
                
                $this->http_body = $body;
            } else {
                $this->http_body = $bodyStr;
            }
        }
    }
    
   /**
    * @return string
    * @param string $what
    * @desc Returns the answercode of the http-response
    */
    function getHttp_answer($what=''){
        
        switch($what){
            case 'code':
                return $this->http_answer['code'];
                break;
            case 'prot':
                return $this->http_answer['prot'];
                break;
            case 'msg':
                return $this->http_answer['msg'];
                break;
            default:
                return $this->http_answer['prot'] . " " . $this->http_answer['code'] . " " . $this->http_answer['msg'];
                break;
            
        }
    }

   /**
    * @return string
    * @desc Beschreibung eingeben...
    */
    function getHttp_body(){
        return $this->http_body;
    }
    
   /**
    * @return array
    * @desc returns headers as associative array.
    */
    function getHttp_headers(){
        return $this->http_headers;
    }
}
?>