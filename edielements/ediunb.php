<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ediheader
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */

require_once 'edielement.php';

class EdiUNB extends EdiElement{
    var $name = 'Interchange header';
    var $identifier = 'UNB';
    protected $syntaxId;
    protected $syntaxVers;
    protected $senderId;
    protected $recipentId;
    protected $prepareDate;
    protected $prepareTime;
    protected $controlRef;
    protected $commId;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    protected function buildElement() {
        parent::buildElement();
        $this->syntaxId = $this->getSegmentValByKey(1, 0);
        $this->syntaxVers = $this->getSegmentValByKey(1, 1);
        $this->senderId = $this->getSegmentValByKey(2);
        $this->recipentId = $this->getSegmentValByKey(3);
        $this->prepareDate = $this->getSegmentValByKey(4, 0);
        $this->prepareTime = $this->getSegmentValByKey(4, 1);
        $this->controlRef = $this->getSegmentValByKey(5);
        $this->commId = $this->getSegmentValByKey(10);
    }
    
    public function getMessageID(){
        return $this->controlRef;
    }
    
    public function setMessageID($id){
        $this->controlRef = $id;
    }
    
    public function stringElement(){
        return 
            $this->identifier.'+'.
            $this->syntaxId.':'.$this->syntaxVers.'+'.
            $this->senderId.'+'.
            $this->recipentId.'+'.
            $this->prepareDate.':'.$this->prepareTime.'+'.
            $this->controlRef.'+'.
            '+'.'+'.'+'.'+'.    
            $this->commId.'\'';
    }
    
}

?>
