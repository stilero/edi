<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of collection
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
class Collection {
    protected $members = array();
    
    public function addItem( $obj, $key = null ){
        if($key){
            if(isset($this->members[$key])){
                throw new Exception('Key $key already in use');
            }  else {
                $this->members[$key] = $obj;
            }
        }  else {
            $this->members[] = $obj;
        }
    }
    
    public function removeItem($key){
        if(isset($this->members[$key])){
            unset($this->members[$key]);
        }  else {
            throw new Exception("Invalid key ".$key);
        }
    }
    
    public function getItem($key){
        if(isset($this->members[$key])){
            return $this->members[$key];
        }else{
            throw new Exception("Invalid key ".$key);
        }
    }
    
    public function length(){
        return sizeof($this->members);
    }
    
    public function keys(){
        return array_keys($this->members);
    }
    
    public function getItems(){
        return $this->members;
    }
    
    public function stringElement(){
        $string = '';
        foreach ($this->members as $member) {
            $string .= $member->stringElement();
        }
        return $string;
    }
    
    public function outputString(){
        print"<pre>";
        print_r($this->members);
        print"</pre>";
    }
}

?>
