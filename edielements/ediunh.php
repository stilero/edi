<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of messageheader
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */

require_once 'edielement.php';

class EdiUNH extends EdiElement{
    var $name = 'Message Header';
    var $identifier = 'UNH';
    protected $refNr;
    protected $messageType;
    protected $messageVersion;
    protected $messageReleaseNr;
    protected $contrAgency;
    protected $assCode;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    protected function buildElement() {
        parent::buildElement();
        $this->refNr = $this->getSegmentValByKey(1);
        $this->messageType = $this->getSegmentValByKey(2, 0);
        $this->messageVersion = $this->getSegmentValByKey(2, 1);
        $this->messageReleaseNr = $this->getSegmentValByKey(2, 2);
        $this->contrAgency = $this->getSegmentValByKey(2, 3);
        $this->assCode = $this->getSegmentValByKey(2, 4);
    }
    
    public function getMessageType(){
        return $this->messageType;
    }
    
    public function getMessageVersion(){
        return $this->messageVersion;
    }
    
    public function getMessageReleaseNr(){
        return $this->messageReleaseNr;
    }
    
    public function stringElement(){
        return 
            $this->identifier.'+'.
                $this->refNr.'+'.
            $this->messageType.':'.$this->messageVersion.':'.$this->messageReleaseNr.':'.$this->contrAgency.':'.$this->assCode.'\'';
    }
}
?>
