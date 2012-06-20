//<?php
//
///*
// * To change this template, choose Tools | Templates
// * and open the template in the editor.
// */
//
///**
// * Description of edi
// *
// * @author Daniel Eliasson (joomla at stilero.com)
// */
//foreach (glob("edielements/*.php") as $filename)
//{
//    require_once $filename;
//}
//
//require_once 'edibaplie.php';
//
//class EdiDocument {
//    protected $ediData;
//    protected $ediElements = array();
//    protected $elementSeparator;
//    protected $subElementSeparator;
//    protected $attrSeparator;
//    protected $groupFound = FALSE;
//    protected $groupElement;
//    protected $groupSubElement;
//    protected $elements = array();
//    protected $xml;
//    protected $baplie;
//
//
//    public function __construct($ediData, $elementSeparator, $subElementSeparator, $attrSeparator) {
//        $this->ediData = $ediData;
//        $this->setElementSeparator($elementSeparator);
//        $this->setSubElementSeparator($subElementSeparator);
//        $this->setAttrSeparator($attrSeparator);
//        $this->sanitizeData();
//        $this->baplie = new EdiBaplie();
//    }
//    
//    public function setElementSeparator($separator){
//        $this->elementSeparator = $separator;
//    }
//    
//    public function getElementSeparator(){
//        return $this->elementSeparator;
//    }
//    
//    public function setSubElementSeparator( $separator ){
//        $this->subElementSeparator = $separator;
//    }
//    
//    public function getSubElementSeparator(){
//        return $this->subElementSeparator;
//    }
//    
//    public function setAttrSeparator( $separator ){
//        $this->attrSeparator = $separator;
//    }
//    
//    public function getAttrSeparator(){
//        return $this->attrSeparator;
//    }
//    
//    public function setGroupElements($groupElement, $groupSubElement){
//        $this->groupElement = $groupElement;
//        $this->groupSubElement = $groupSubElement;
//    }
//    
//    public function buildMessage(){
//        $elements = explode($this->elementSeparator, $this->ediData);
//        array_pop($elements);
//        foreach ($elements as $element) {
//            $segments = explode($this->subElementSeparator, $element);
//            $elementKey = ( isset($segments[0]) ) ? $segments[0] : null ;
//            //$elementKey = ( isset ($this->elements[$elementKey]) ) ? $elementKey.count($this->elements[$elementKey]) : $elementKey;
//            $segmentKey = ( isset($segments[1]) ) ? $segments[1] : null ;
//            
//            if(isset($elementKey)){
//            $className = 'Edi'.$elementKey;
//            if(class_exists($className)){
//                $class = new $className($elementKey, $element);
//            }
//             $this->baplie->addItem($class);
//            }
//        }
//        
//        //foreach ($this->ediElements as $class) {
//            //$this->baplie->toString();
//        //}
//    }
//    
//    private function addElement($child, $parent = null ){
//        if(!is_string($child) || $child == ""){
//            return;
//        }
//        if(isset($parent)){
//            return $parent->addChild($child);
//        }else{
//            return $this->xml->addChild($child);
//        }
//    }
//    
//    protected function sanitizeData(){
//        $allowedChars = "/[^A-Z0-9\,\'\+\:\.\-]/";
//        $cleanedData = preg_replace($allowedChars, '', $this->ediData);
//        $this->ediData = $cleanedData;
//    }
//    
//    public function toString(){
//        var_dump($this->baplie->getMessageLength());
//    }
//       
//}
//
//?>