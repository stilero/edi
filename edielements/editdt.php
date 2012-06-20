<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of messagedetailsoftransp
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
require_once 'edielement.php';

class EdiTDT extends EdiElement{
    var $name = 'Details of Transport';
    var $identifier = 'TDT';
    protected $stageQualifier;
    protected $convRefNr;
    protected $mode;
    protected $means;
    protected $carrier;
    protected $carrierCodeQualifier;
    protected $carrirerCodeAgency;
    protected $transitDir;
    protected $excessInfo;
    protected $transId;
    protected $transIdCodeQual;
    protected $tranIdRespAgency;
    protected $transIdTransport;
    protected $transOwnership;
    static $stageQualifiers = array(
        '20'    =>  'Main-Carriage Transport'
    );
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->stageQualifier = $this->getSegmentValByKey(1);
        $this->convRefNr = $this->getSegmentValByKey(2);
        $this->mode = $this->getSegmentValByKey(3);
        $this->means = $this->getSegmentValByKey(4);
        $this->carrier = $this->getSegmentValByKey(5,0);
        $this->carrierCodeQualifier = $this->getSegmentValByKey(5,1);
        $this->carrirerCodeAgency  = $this->getSegmentValByKey(5,2);
        $this->transitDir = $this->getSegmentValByKey(6);
        $this->excessInfo = $this->getSegmentValByKey(7);
        $this->transId = $this->getSegmentValByKey(8,0);
        $this->transIdCodeQual = $this->getSegmentValByKey(8,1);
        $this->tranIdRespAgency = $this->getSegmentValByKey(8,2);
        $this->transIdTransport = $this->getSegmentValByKey(8,3);
        $this->transOwnership = $this->getSegmentValByKey(9);
    }
    
    public function translateStageQualifier(){
        return parent::translateCode($this->stageQualifiers, $this->stageQualifier);
    }
    
    public function stringElement(){
        return 
            $this->identifier.'+'.
                $this->stageQualifier.'+'.
            $this->convRefNr.'+'.
            $this->mode.'+'.
            $this->means.'+'.
            $this->carrier.':'.$this->carrierCodeQualifier.':'.$this->carrirerCodeAgency.'+'.
            //$this->transitDir.':'.$this->excessInfo.'+'.
            $this->transId.':'.$this->transIdCodeQual.':'.$this->tranIdRespAgency.':'.$this->transIdTransport.
            //'+'.$this->transOwnership.
            '\'';
    }
    
}

?>
