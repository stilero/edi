<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of edireference
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
require_once 'edielement.php';

class EdiRFF extends EdiElement{
    var $name = 'Reference';
    var $identifier = 'RFF';
    protected $qualifier;
    protected $number;
    protected $lineNumber;
    protected $versionNumber;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
        $this->qualifier = $this->getSegmentValByKey(1, 0);
        $this->number = $this->getSegmentValByKey(1, 1);
        $this->lineNumber = $this->getSegmentValByKey(1, 2);
        $this->versionNumber = $this->getSegmentValByKey(1, 3);
    }
    
    public function stringElement(){
            return $this->arrayToString().'\'';
    }
        
    public function getArray(){
        $this->segmentsArray = array(
            $this->identifier,
            array(
                $this->qualifier,
                $this->number,
                $this->lineNumber,
                $this->versionNumber
            )
        );
        return $this->segmentsArray;
    }
    
}

?>
