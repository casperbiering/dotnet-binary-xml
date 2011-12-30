<?php

require 'phpBinaryXml.php';

if($_SERVER['argc'] < 2) {
    echo "Syntax: php ".$_SERVER['argv'][0]." <filename>\n";
    exit(1);
}

if(!is_readable($_SERVER['argv'][1])) {
    echo "The file '".$_SERVER['argv'][1]."' does not exist or is not readable\n";
    exit(2);
}

$content = file_get_contents($_SERVER['argv'][1]);
$output = phpBinaryXml::decode($content);

$xml = new DOMDocument();
$xml->loadXML($output);
$xml->preserveWhiteSpace = false;
$xml->formatOutput = true;
echo $xml->saveXML();

exit(0);