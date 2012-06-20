<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of messagedatetime
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */

require_once 'edielement.php';

class EdiDTM extends EdiElement {
    var $name = 'Date/Time/Period';
    var $identifier = 'DTM';
    protected $qualifier;
    protected $period;
    protected $format;
    static $qualifiers = array(
        '137'   =>      'Document / Message Date-Time',
        '132'   =>      'Arrival Date-Time Estimated',
        '133'   =>      'Departure Date-Time Estimated'
    );
    static $formats = array(
        '201'   =>      'YYMMDDHHMM'
    );
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->qualifier = $this->getSegmentValByKey(1,0);
        $this->period = $this->getSegmentValByKey(1,1);
        $this->format = $this->getSegmentValByKey(1,2);
    }
    
    public function translateQualifier(){
        return parent::translateCode($this->qualifiers, $this->qualifier);
    }
    
    public function translateFormat(){
        return parent::translateCode($this->formats, $this->format);
    }
    
    public function stringElement(){
        return $this->identifier.'+'.
                $this->qualifier.':'.$this->period.':'.$this->format.'\'';
    }
}

?>
