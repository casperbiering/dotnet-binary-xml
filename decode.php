<?php

require 'phpBinaryXml.php';

if(PHP_SAPI !== 'cli') {
    echo "Can only be run in CLI-mode.\n";
    exit(3);
}

if($_SERVER['argc'] < 2) {
    echo "Syntax: php ".$_SERVER['argv'][0]." <filename>\n";
    exit(1);
}

if(!is_readable($_SERVER['argv'][1])) {
    echo "The file '".$_SERVER['argv'][1]."' does not exist or is not readable\n";
    exit(2);
}

$content = file_get_contents($_SERVER['argv'][1]);
$output = phpBinaryXml::decode($content, true);

echo $output;

exit(0);
