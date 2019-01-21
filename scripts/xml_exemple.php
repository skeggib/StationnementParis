<?php

require_once("xml.php");

if (!isset($argv) || count($argv) < 3)
{
    print("Usage: php " . $argv[0] . " <xml_path> <xsd_path>\n");
    return;
}
$xml_path = $argv[1];
$xsd_path = $argv[2];

$doc = createxml();
$doc = addAddresse($doc, '18', 'bis', 'rue Georges Bizet', '13', '63.202', '57.20', '1', '0.7', '0.8');
$doc = addAddresse($doc, '263', '', 'rue de Paname', '15', '63.202', '57.20', '1', '0.7', '0.8');
if(validate($doc, $xsd_path)){
    saveXMLDocument($doc, $xml_path);
} else {
    //Do something else
}

?>