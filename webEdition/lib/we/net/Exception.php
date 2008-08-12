<?php

include_once (dirname(dirname(__FILE__)) . '/../we/core/autoload.php');

/**
 * @see we_Exception
 */
Zend_Loader::loadClass('we_Exception');

class we_net_Exception extends we_Exception
{}