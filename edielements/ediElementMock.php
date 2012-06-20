<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ediElementMock
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */

require_once 'edielement.php';

class ediElementMock extends EdiElement {
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function sanitizeVar($var, $type = 'alphaNum') {
        return parent::sanitizeVar($var, $type);
    }


    public function getSegmentValByKey($key, $subkey = null) {
        $this->buildElement();
        return parent::getSegmentValByKey($key, $subkey);
    }
    
}
?>
