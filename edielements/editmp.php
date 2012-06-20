<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of editmp
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
require_once 'edielement.php';

class EdiTMP extends EdiElement{
    var $name = 'Temperature';
    var $identifier = 'TMP';
    protected $tempQual;
    protected $tempSetting;
    protected $tempUnitQual;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
        $this->tempQual = $this->getSegmentValByKey(1);
        $this->tempSetting = $this->getSegmentValByKey(2,0);
        $this->tempUnitQual = $this->getSegmentValByKey(2,1);
    }
    
    public function stringElement(){
        return 
            $this->identifier.'+'.
                $this->tempQual.'+'.
            $this->tempSetting.':'.$this->tempUnitQual.'\'';
    }
}

?>
