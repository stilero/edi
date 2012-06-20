<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of edielement
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
abstract class EdiElement {
    public $identifier;
    protected $elementData;
    public $name;
    public $desc;
    protected $segments;
    protected $segmentSeparator = "+";
    protected $attrSeparator = ":";
    
    
    public function __construct($identifier, $elementData) {
        $this->identifier = strtoupper( $this->sanitizeVar($identifier, 'alpha') );
        $this->elementData = $this->sanitizeVar($elementData, 'element');
        $this->buildElement();
    }
    
    protected function sanitizeVar($var, $type='alphaNum'){
        $allowedChars = $this->createRegExpForType($type);
        $sanitizedData = preg_replace($allowedChars, '', $var);
        return $sanitizedData;
    }
    
    protected function createRegExpForType($type){
        $regExp = "";
        switch ($type) {
            case 'alphaNum':
                $regExp = '/[^a-zA-Z0-9]/';
                break;
             case 'alpha':
                $regExp = '/[^a-zA-Z]/';
                break;
            case 'num':
                $regExp = '/[^0-9]/';
                break;
             case 'element':
                $regExp = "/[^A-Z0-9\,\+\:\.\-]/";
                break;
            case 'temp':
                $regExp = "/[^0-9\+\.\,\-]/";
                break;
            default:
                break;
        }
        return $regExp;
    }
    
    protected function setVar($classVar, $var, $type="alhpaNum"){
        if(!isset($classVar)) throw new Exception("var not set");
        $classVar = $this->sanitizeVar($var, $type);
    }
    
    public function getIdentifier(){
        return $this->identifier;
    }
    
    public function setIdentifier( $identifier ){
        if( !is_string($identifier) ){
           throw new Exception("Identifier must be string");
        }else{
            $this->identifier = strtoupper($identifier);
        }
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setName( $name ){
        if( !is_string($name) ){
           throw new Exception("Name must be string");
        }else{
            $this->name = $name;
        }
    }
    
    public function getDesc(){
        return $this->desc;
    }
    
    public function setDesc( $desc ){
        if( !is_string($desc) ){
          throw new Exception("Description must be string");
        }else{
            $this->desc = $desc;
        }
    }
    
    protected function buildElement(){
        $this->segments = explode($this->segmentSeparator, $this->elementData);
    }
    
    protected function getSegmentValByKey($key, $subkey=null){
        $val = null;
        if(isset($subkey)){
            if(!isset($this->segments[$key])){
                return null;
            }
            $subSegments = explode($this->attrSeparator, $this->segments[$key]);
            if (isset($subSegments[$subkey])){
                $val = $subSegments[$subkey];
            }
        }else{
            if( isset($this->segments[$key]) ){
                if( $this->hasSubSegments($this->segments[$key], $this->attrSeparator) ){
                    $val = $this->subSegment($this->segments[$key], $this->attrSeparator);
                } else{
                    $val = (isset($this->segments[$key])) ? $this->segments[$key] : null;
                }
            }
        }
        return $val;
    }
    
    protected function hasSubSegments($segment, $delimiter){
        $subSegments = explode($delimiter, $segment);
        if( isset($subSegments[0]) ){
            return TRUE;
        }
        return FALSE;
    }
    
    protected function subSegment($segment, $delimiter, $key=0){
        $subSegments = explode($delimiter, $segment);
        if( isset($subSegments[$key]) ){
            return $subSegments[$key];
        }
        return null;
    }
    
    public function toString(){
        print "<pre>";
        print_r($this);
        print "</pre>";
    }
    
    public function translateCode($codeArray, $code){
        return $codeArray[$code];
    }
    
    public function stringElement(){
        return;
    }
}

?>
