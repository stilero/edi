<?php
require_once 'edimessage.php';

class EdiBaplie extends EdiMessage {
    
    private $mandHeaderElements = array(
        'UNH', 'BGM', 'DTM'
    );
    private $mandGroup1Elements = array(
        'TDT', 'LOC', 'DTM' 
    );
    private $mandGroup2Elements = array(
        'LOC', 'MEA', 'RFF', 'EQD'
    );
    private $mandFooterElements = array(
        'UNT', 'UNZ'
    );
    
    private $portsOfLoading;
    private $portsOfDischarge;
    
    public function __construct($ediData) { 
        $bodyClassName = 'LOC';
        $bodyClassAttr = '147';
        $footerClassName  = 'UNT';
        $elementSeparator = "'";
        $subElementSeparator = "+";
        $attrSeparator = ":";
        parent::__construct($ediData, $bodyClassName, $bodyClassAttr, $footerClassName, $elementSeparator, $subElementSeparator, $attrSeparator);
    }
    
    
    public function convertToMovins($portOfLoading="", $handInstr = 'LOA', $senderID='EDICONVERTER'){
        $hanClass = new EdiHan('HAN', "HAN+".$handInstr."'");
        $header = $this->createHeader($senderID, 'MOVINS');
        $body = $this->body();
        $footer = $this->footer();
        $catch = FALSE;
        $movinsBody='';
        $newBody = array();
        $i = 0;
        foreach ($body as $value) {
            foreach ($value->getItems() as $item){
                if( isset($item->locQualifier) && isset($item->locId) ){
                    if($item->locQualifier == '9' && $item->locId == $portOfLoading){
                        $catch = TRUE;
                        break;
                    }                   
                }
                //print $item->stringElement();
            }
            if($catch){ 
                $body[$i]->addItem($hanClass);
                //$items = $value->getItems();
//                array_reverse($items);
//                array_push($items, $hanClass);
//                array_reverse($items);
                $newBody[] = $body[$i];
                $catch = FALSE;
                //break;
            }
            $i++;
        }
        $movinsHeader = $this->elementToString($header);
        $movinsBody = $this->elementToString($newBody);
        $movinsMessage = $movinsHeader.$movinsBody.$movinsFooter;
        $messageLength = $this->countMessageLength($movinsMessage);
        $footer[0]->setSegmentsCount($messageLength);
        $movinsFooter = $this->elementToString($footer);
        return $movinsHeader.$movinsBody.$movinsFooter;
    }
    
    private function elementToString($element){
        $string = '';
        foreach ($element as $part) {
            $string .= $part->stringElement();
        }
        return $string;
    }
    
    public function getPortsOfLoading(){
        if(isset($this->portsOfLoading)){
            return $this->portsOfLoading;
        }
        $elementID = 'LOC';
        $elementQualifier = '9';
        $this->portsOfLoading = $this->fetchPorts($elementID, $elementQualifier);
        return $this->portsOfLoading;
    }

    public function getPortsOfDischarge(){
        if(isset($this->portsOfDischarge)){
            return $this->portsOfDischarge;
        }
        $elementID = 'LOC';
        $elementQualifier = '11';
        $this->portsOfDischarge = $this->fetchPorts($elementID, $elementQualifier);
        return $this->portsOfDischarge;
    }
    
    public function fetchPortsOfLoading(){
        return $this->getPortsOfLoading();
    }
    
    public function fetchPortsOfDischarge(){
        return $this->getPortsOfDischarge();
    }
    
    public function inPortsOfDischarge($port){
        $ports = $this->getPortsOfDischarge();
        return in_array($port, $ports);
    }
    
    public function inPortsOfLoading($port){
        $ports = $this->getPortsOfLoading();
        return in_array($port, $ports);
    }
}
?>
