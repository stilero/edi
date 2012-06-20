<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ediunt
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
require_once 'edielement.php';

class EdiUNT extends EdiElement {
    var $name = 'Message Trailer';
    var $identifier = 'UNT';
    protected $segmentsCount;
    protected $messageRefNr;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
        $this->segmentsCount = $this->getSegmentValByKey(1);
        $this->messageRefNr = $this->getSegmentValByKey(2);
    }
    
    public function getMessageID(){
        return $this->messageRefNr;
    }
    
    public function setMessageID($id){
        $this->messageRefNr = $id;
    }
    
    public function setSegmentsCount($count){
        $this->segmentsCount = $count;
    }
    
    public function stringElement(){
        return 
            $this->identifier.'+'.
                $this->segmentsCount.'+'.
            $this->messageRefNr.'\'';
    }
}

?>
