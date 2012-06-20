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

class EdiDGS extends EdiElement{
    var $name = 'Dangerous goods';
    var $identifier = 'DGS';
    protected $dgRegulations;
    protected $hazardCode;
    protected $unCode;
    protected $flashPoint;
    protected $packingGroupCode;
    protected $packingGroupCodes = array(
        '1' =>  'Great Danger',
        '2' =>  'Medium Danger',
        '3' =>  'Minor Danger'
    );
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->dgRegulations = $this->getSegmentValByKey(1);
        $this->hazardCode = $this->getSegmentValByKey(2);
        $this->unCode = $this->getSegmentValByKey(3);
        $this->flashPoint = $this->getSegmentValByKey(4);
        $this->packingGroupCode = $this->getSegmentValByKey(5);
    }
    
    public function packingGroupCodeToString(){
        return $this->packingGroupCodes[$this->packingGroupCode];
    }
    
    public function stringElement(){
        return 
            $this->identifier.'+'.
                $this->dgRegulations.'+'.
            $this->hazardCode.'+'.
            $this->unCode.'+'.
            $this->flashPoint.'+'.
            $this->packingGroupCode.'\'';
    }
}
?>
