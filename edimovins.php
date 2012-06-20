<?php
require_once 'edimessage.php';

class EdiMovins extends EdiMessage {
    
    private $mandHeaderElements = array(
        'UNB','UNH', 'BGM', 'DTM'
    );
    private $mandGroup1Elements = array(
        'TDT', 'LOC', 'DTM' 
    );
    private $mandGroup2Elements = array(
        'HAN', 'LOC', 'MEA', 'RFF', 'EQD'
    );
    private $mandFooterElements = array(
        'UNT', 'UNZ'
    );

    public function __construct($ediData) { 
        $bodyClassName = 'HAN';
        $bodyClassAttr = 'LOA';
        $footerClassName  = 'UNT';
        $elementSeparator = "'";
        $subElementSeparator = "+";
        $attrSeparator = ":";
        $firstGroupElementAttr = 'hanInstr';
        parent::__construct($ediData, $bodyClassName, $bodyClassAttr, $footerClassName, $elementSeparator, $subElementSeparator, $attrSeparator, $firstGroupElementAttr);
    }
    
    public function convertToBaplie(){
        
    }
}
?>
