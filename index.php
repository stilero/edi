<?php
require_once 'edibaplie.php';
require_once 'edimovins.php';

$ediData = file_get_contents('edifiles/baplie2.edi');
        
$baplie = new EdiBaplie($ediData);
//$baplie->toString(); 
//$cargo = $baplie->body();
var_dump($baplie->fetchPortsOfLoading());
//print $baplie->getMessageType();
 //print $baplie->countCargoForPort('firau', 'dis');
//print $movinsData = $baplie->convertToMovins('SEGOT');
//$movins = new EdiMovins($movinsData);
//$movins->outputString();
?>