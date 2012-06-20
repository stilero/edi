<?php

/**
 * Description of edimessage
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
foreach (glob("edielements/*.php") as $filename)
{
    require_once $filename;
}
require_once 'collection.php';
require_once 'group.php';

class EdiMessage extends Collection{
    protected $ediData;
    protected $messageID;
    protected $messageRef;
    protected $elementSeparator;
    protected $subElementSeparator;
    protected $attrSeparator;
    protected $footerClassName;
    protected $bodyClassName;
    protected $bodyClassAttr;
    protected $grouping = FALSE;
    protected $group;
    protected $cargoIndex;
    protected $footerIndex;
    protected $bodyLength;
    protected $footerLength;
    protected $messageLength;
    protected $messsageTypeVersion = array();
    protected $headerLength;
    protected $body;
    protected $firstGroupElementAttr;
    
    public function __construct($ediData, $bodyClassName, $bodyClassAttr, $footerClassName, $elementSeparator="'", $subElementSeparator="+", $attrSeparator=":", $firstGroupElementAttr='locQualifier') {
        $this->ediData = $this->sanitizeData($ediData);
        $this->setElementSeparator($elementSeparator);
        $this->setAttrSeparator($attrSeparator);
        $this->setSubElementSeparator($subElementSeparator);
        $this->bodyClassName = $bodyClassName;
        $this->bodyClassAttr = $bodyClassAttr;
        $this->footerClassName = $footerClassName;
        $this->firstGroupElementAttr = $firstGroupElementAttr;
        $this->buildMessage();
    }
    
    protected function sanitizeData($data){
        $allowedChars = "/[^A-Z0-9\,\'\+\:\.\-]/";
        $cleanedData = preg_replace($allowedChars, '', $data);
        return $cleanedData;
    }
    
    protected function buildMessage(){
        $elements = explode($this->elementSeparator, $this->ediData);
        array_pop($elements);
        foreach ($elements as $element) {
            $segments = explode($this->subElementSeparator, $element);
            $elementKey = ( isset($segments[0]) ) ? $segments[0] : null ;
            $segmentKey = ( isset($segments[1]) ) ? $segments[1] : null ;
            if(isset($elementKey)){
                $elementClassName = 'Edi'.$elementKey;
                if(class_exists($elementClassName)){
                    $Element = new $elementClassName($elementKey, $element);
                    if($elementClassName == 'EdiUNH' && is_string($Element->getMessageType())){
                        $messType = $Element->getMessageType();
                        $messVersion = $Element->getMessageVersion();
                        $messRelNr = $Element->getMessageReleaseNr();
                        $this->setMessageTypeVersion($messType, $messVersion, $messRelNr);
                    }
                    if($elementClassName == 'EdiUNB' && is_string($Element->getMessageID())){
                        $this->messageID = $Element->getMessageID();
                    }
                }
                 $this->addItem($Element);
            }
        }
    }
    
    public function addItem($obj, $key = null) {
        if( ($obj->identifier == $this->bodyClassName) ){
            $attrName = $this->firstGroupElementAttr;
            if( $obj->$attrName == $this->bodyClassAttr){
                if( isset($this->group)){
                    parent::addItem($this->group);
                    unset($this->group);
                }
                $this->group = new Group();
                $this->grouping = TRUE;
            }
        }elseif($obj->identifier == $this->footerClassName){
            $this->grouping = FALSE;
             if( isset($this->group)){
                parent::addItem($this->group);
                unset($this->group);
            }
        }
        if($this->grouping){
            $this->group->addItem($obj);
        }else{
            parent::addItem($obj);
        }
    }

    public function header(){
        $header = array();
        $bodyIndex = $this->getBodyIndex();
        for($i = 0 ; $i <$bodyIndex ; $i++){
            $header[] = $this->getItem($i);
        }
        return $header;
    }
    
    public function createHeader($senderID='EDICONVERTER', $messageType='BAPLIE'){
        $date = date('Ymd');
        $time = date('hi');
        $unbData = 'UNB+UNOA:1+'.  strtoupper($senderID).'+PUBLIC+'.$date.':'.$time.'+'.$this->messageID.'+++++UNKNOWN';
        $unb = new EdiUNB('UNB', $unbData);
        $uniqID = strtoupper( uniqid( strtoupper($senderID) ));
        $this->messageRef = substr($uniqID, 0, 13);
        $unhData = 'UNH+'.$this->messageRef.'+'.$messageType.':D:95B:UN:SMDG20';
        $unh = new EdiUNH('UNH', $unhData);
        $header = array($unb, $unh);
        $bodyIndex = $this->getBodyIndex();
        for($i = 2 ; $i <$bodyIndex ; $i++){
            $header[] = $this->getItem($i);
        }
        return $header;
    }
    
    public function getMessageRef(){
        return $this->messageRef;
    }
    
    public function body(){
        if(isset($this->body)){
            return $this->body;
        }
        $bodyArr = array();
        $bodyIndex = $this->getBodyIndex();
        $footerIndex = $this->getFooterIndex();
        for($i = $bodyIndex ; $i < $footerIndex ; $i++){
            $bodyArr[] = $this->getItem($i);
        }
        return $bodyArr;
    }
        
    private function findIndexForElementClass($className){
        $i = 0;
        while( $i < $this->length() ){
            $segment = $this->getItem($i);
            if(is_a($segment, $className)){
                return $i;
            }
            $i++;
        }   
        return null;
    }
    
    protected function getFooterIndex(){
        if(isset($this->footerIndex) ){
            return $this->footerIndex;
        }
        return $this->findIndexForElementClass('Edi'.$this->footerClassName);
    }
    
    protected function getBodyIndex(){
        if(isset($this->bodyIndex) ){
            return $this->bodyIndex;
        }
        return $this->findIndexForElementClass('Group');
    }
    
    public function footer(){
       $footer = array();
       $footerIndex = $this->getFooterIndex();
        for($i = $footerIndex ; $i < $this->length() ; $i++){
            $footer[] = $this->getItem($i);
        }
        return $footer;
    }
    
    public function getUpdatedFooter(){
        $arrayLength = $this->length();
//        $unt = $this->getItem($arrayLength-2);
//        $unz = $this->getItem($arrayLength-1);
        $unt = new EdiUNT('UNT', 'UNT+'.$this->getMessageLength(true).'+'.$this->messageRef);
        $unz = new EdiUNZ('UNZ', 'UNZ+1+'.$this->messageID);
        $footer = array($unt, $unz);
        return $footer;
    }
    
    public function countMessageLength($stringMessage){
        return substr_count($stringMessage, "'") -2 ;
    }
    
    protected function fetchCargo($identifier, $qualifier, $locID){
        $cargoForPOD = array();
        $totalCargo = $this->body();
        $fetch = FALSE;
        foreach ($totalCargo as $cargo) {
            $fetch = FALSE;
            foreach ($cargo as $unit) {
                foreach ($unit as $unitElement) {
                    $lmntIdentifier = isset($unitElement->identifier) ? $unitElement->identifier : null;
                    $lmntQual = isset($unitElement->locQualifier) ? $unitElement->locQualifier : null;
                    $lmntlocID = isset($unitElement->locId) ? $unitElement->locId : null;
                    if($lmntIdentifier == strtoupper($identifier) && $lmntQual == strtoupper($qualifier) && $lmntlocID == strtoupper($locID)){
                        $fetch = TRUE;
                    } 
                }
            }
            if($fetch){
                $cargoForPOD[] = $cargo;
                $fetch = FALSE;
            }   
        }
        return $cargoForPOD;
    }
    
    protected function fetchPorts($identifier, $qualifier){
        $portsArray = array();
        $totalCargo = $this->body();
        $fetch = FALSE;
        foreach ($totalCargo as $cargo) {
            $fetch = FALSE;
            foreach ($cargo as $unit) {
                foreach ($unit as $unitElement) {
                    $lmntIdentifier = isset($unitElement->identifier) ? $unitElement->identifier : null;
                    $lmntQual = isset($unitElement->locQualifier) ? $unitElement->locQualifier : null;
                    $lmntlocID = isset($unitElement->locId) ? $unitElement->locId : null;
                    if($lmntIdentifier == strtoupper($identifier) && $lmntQual == strtoupper($qualifier)){
                        $fetch = $unitElement->locId;
                    } 
                }
            }
            if($fetch){
                if(!in_array($fetch, $portsArray)){
                    $portsArray[] = $fetch;
                }
                $fetch = FALSE;
            }   
        }
        sort($portsArray);
        return $portsArray;
    }
   
    public function fetchCargoForPort($portCode, $operationType){
        $identifier = 'LOC';
        $qualifier = $this->qualifierForOperationType($operationType);
        return $this->fetchCargo($identifier, $qualifier, $portCode);
    }
    
    public function countCargoForPort($portCode, $operationType){
        return count($this->fetchCargoForPort($portCode, $operationType));
    }
    
    private function qualifierForOperationType($operationType){
        $operationType = strtoupper($operationType);
        if($operationType == 'DIS'){
            $qualifier = '11';
        }elseif($operationType == 'LOA'){
            $qualifier = '9';
        }
        return $qualifier;
    }
    
    public function getBodyLength($reCount=false){
        if(isset($this->bodyLength) && !$reCount){
            return $this->bodyLength;
        }
        $body = $this->body();
        $bodyCount = 0;
        foreach ($body as $bodyElement) {
            $bodyCount += $bodyElement->length();
        }
        $this->bodyLength = $bodyCount;
        return $this->bodyLength;
    }
    
    public function getHeaderLength(){
        if(isset($this->headerLength)){
            return $this->headerLength;
        }
        $this->headerLength = $this->getBodyIndex();
        return $this->headerLength;
    }
    
    public function getMessageLength($reCount = false){
        if(isset($this->messageLength) && !$reCount){
            return $this->messageLength;
        }
        $this->messageLength = $this->getHeaderLength() + $this->getBodyLength();
        return $this->messageLength;
    }
    
    public function setElementSeparator($separator){
        $this->elementSeparator = $separator;
    }
    
    public function setSubElementSeparator( $separator ){
        $this->subElementSeparator = $separator;
    }

    public function setAttrSeparator( $separator ){
        $this->attrSeparator = $separator;
    }
    
    public function setMessageTypeVersion($type, $version, $release){
        if($type == "" || !is_string($type)){
            return;
        }
        $this->messsageTypeVersion = array(
            'type' => strtoupper($type),
            'version' => $version,
            'release' => $release
            );
    }
    
    public function getMessageType(){
        return $this->messsageTypeVersion['type'];
    }
    
    public function getMessageVersion(){
        return $this->messsageTypeVersion['version'];
    }
    
    public function getMessageRelNr(){
        return $this->messsageTypeVersion['release'];
    }
    
    public function getMessageID(){
        return $this->messageID;
    }
}
?>