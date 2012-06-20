<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of edidangerous
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
require_once 'edielement.php';

class EdiFTX extends EdiElement{
    var $name = 'Free Text';
    var $identifier = 'FTX';
    protected $txtQualifier;
    protected $txtFuncCode;
    protected $txtRef;
    protected $txtLiteral;
    protected $langNameCode;
    protected $freeTxtFormatCode;
    protected $txtQualifierDesc = array(
        'AAA' =>  'Goods Description',
        'AAC' =>  'Dangerous Goods Additional Info',
        'AAD' =>  'Dangerous Goods Technical Name',
        'AAN' =>  'Handling descriptions'
    );
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->txtQualifier = $this->getSegmentValByKey(1);
        $this->txtFuncCode = $this->getSegmentValByKey(2);
        $this->txtRef = $this->getSegmentValByKey(3);
        $this->txtLiteral = $this->getSegmentValByKey(4);
        $this->langNameCode = $this->getSegmentValByKey(5);
        $this->freeTxtFormatCode = $this->getSegmentValByKey(6);
    }
    
    public function qualifierCodeToString(){
        return $this->txtQualifierDesc[$this->txtQualifier];
    }
    
    public function stringElement(){
        return 
            $this->identifier.'+'.
                $this->txtQualifier.'+'.
            $this->txtFuncCode.'+'.
            $this->txtRef.'+'.
            $this->txtLiteral.'+'.
            $this->langNameCode.'+'.
            $this->freeTxtFormatCode.'\'';
    }
}
?>
