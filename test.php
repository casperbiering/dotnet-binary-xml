<?php

if(PHP_SAPI !== 'cli') {
    echo "Can only be run in CLI-mode.\n";
    exit(3);
}

$testdata = <<< WEBSITEDATA
40 03 64 6F 63 01
02 07 63 6F 6D 6D 65 6E 74
40 03 64 6F 63 04 04 61 74 74 72 84 01
40 03 64 6F 63 09 01 70 0A 68 74 74 70 3A 2F 2F 61 62 63 01
40 03 64 6F 63 09 03 70 72 65 0A 68 74 74 70 3A 2F 2F 61 62 63 05 03 70 72 65 04 61 74 74 72 84 01
40 03 64 6F 63 06 08 86 01
40 03 64 6F 63 09 03 70 72 65 0A 68 74 74 70 3A 2F 2F 61 62 63 07 03 70 72 65 00 86 01
03 40 03 61 72 72 01 8B 03 33 33 88 88 DD DD
40 03 64 6F 63 09 01 66 0A 68 74 74 70 3A 2F 2F 61 62 63 11 0B 98 05 68 65 6C 6C 6F 01
40 03 64 6F 63 09 01 78 0A 68 74 74 70 3A 2F 2F 61 62 63 23 15 98 05 77 6F 72 6C 64 01
40 03 64 6F 63 09 01 6B 0A 68 74 74 70 3A 2F 2F 61 62 63 30 04 61 74 74 72 86 01
40 03 64 6F 63 09 01 7A 0A 68 74 74 70 3A 2F 2F 61 62 63 3F 03 61 62 63 98 03 78 79 7A 01
41 03 70 72 65 03 64 6F 63 09 03 70 72 65 0A 68 74 74 70 3A 2F 2F 61 62 63 01
42 0E 01
43 03 70 72 65 0E 09 03 70 72 65 0A 68 74 74 70 3A 2F 2F 61 62 63 01
44 0A 09 01 61 0A 68 74 74 70 3A 2F 2F 61 62 63 01
56 26 09 01 73 0A 68 74 74 70 3A 2F 2F 61 62 63 01
5E 05 68 65 6C 6C 6F 09 01 61 0A 68 74 74 70 3A 2F 2F 61 62 63 01
70 09 4D 79 4D 65 73 73 61 67 65 09 01 73 0A 68 74 74 70 3A 2F 2F 61 62 63 01
40 03 64 6F 63 06 A0 03 80 01
40 03 64 6F 63 06 00 82 01
42 9A 01 89 7F
40 03 61 62 63 81
40 03 61 62 63 83
40 03 64 6F 63 06 EC 01 88 DE 01
40 03 64 6F 63 06 EC 01 8A 00 80 01
42 9A 01 8B FF 7F
40 03 64 6F 63 06 EC 01 8C 15 CD 5B 07 01
42 9A 01 8D FF FF FF 7F
40 03 64 6F 63 04 01 61 90 CD CC 8C 3F 01
40 05 50 72 69 63 65 91 CD CC 01 42
40 03 64 6F 63 04 01 61 92 74 57 14 8B 0A BF 05 40 01
40 02 50 49 93 11 2D 44 54 FB 21 09 40
40 03 64 6F 63 98 05 68 65 6C 6C 6F 01
40 01 61 99 05 68 65 6C 6C 6F
40 03 64 6F 63 9A 05 00 68 65 6C 6C 6F 01
40 01 61 9B 05 00 68 65 6C 6C 6F
40 03 64 6F 63 9C 05 00 00 00 68 65 6C 6C 6F 01
40 01 61 9D 05 00 00 00 68 65 6C 6C 6F
40 03 64 6F 63 9E 08 00 01 02 03 04 05 06 07 01
40 06 42 61 73 65 36 34 9F 08 00 01 02 03 04 05 06 07
40 03 64 6F 63 A0 08 00 00 01 02 03 04 05 06 07 01
40 06 42 61 73 65 36 34 A1 08 00 00 01 02 03 04 05 06 07
40 03 64 6F 63 A2 08 00 00 00 00 01 02 03 04 05 06 07 01
40 06 42 61 73 65 36 34 A3 08 00 00 00 00 01 02 03 04 05 06 07
40 03 64 6F 63 04 01 61 A4 88 7B 98 05 68 65 6C 6C 6F 86 A6 01
40 03 64 6F 63 04 01 61 A8 01
40 03 64 6F 63 A9
40 03 64 6F 63 04 02 6E 73 AA 38 01
40 04 54 79 70 65 AB C4 01
40 03 64 6F 63 B4 01 01
03 40 03 61 72 72 01 B5 05 01 00 01 00 01
40 03 64 6F 63 04 01 75 B6 06 75 00 6E 00 69 00 01
40 01 55 B7 06 75 00 6E 00 69 00
40 03 64 6F 63 04 03 75 31 36 B8 08 00 75 00 6E 00 69 00 32 00 01
40 03 55 31 36 B9 08 00 75 00 6E 00 69 00 32 00
40 03 64 6F 63 04 03 75 33 32 BA 04 00 00 00 33 00 32 00 01
40 03 55 33 32 BB 04 00 00 00 33 00 32 00
40 03 64 6F 63 06 F0 06 BC 08 8E 07 01
40 04 54 79 70 65 BD 12 90 07
40 03 64 6F 63 06 6E 96 FF 3F 37 F4 75 28 CA 2B 01
42 6C 97 00 40 8E F9 5B 47 C8 08
40 03 64 6F 63 04 03 69 6E 74 94 00 00 06 00 00 00 00 00 80 2D 4E 00 00 00 00 00 01
40 08 4D 61 78 56 61 6C 75 65 95 00 00 00 00 FF FF FF FF FF FF FF FF FF FF FF FF
42 0E 01
42 91 2B 01
42 80 80 01 01
42 80 80 80 01 01
42 80 80 80 80 01 01
40 03 64 6F 63 06 EC 01 8E 00 00 00 80 00 00 00 00 01
42 9A 01 8F 00 00 00 00 00 01 00 00
40 03 64 6F 63 B2 FF FF FF FF FF FF FF FF 01
42 9A 01 B3 FE FF FF FF FF FF FF FF
40 03 64 6F 63 AC 00 11 22 33 44 55 66 77 88 99 AA BB CC DD EE FF 01
42 1A AD 00 11 22 33 44 55 66 77 88 99 AA BB CC DD EE FF
*40 03 64 6F 63 AE 00 C4 F5 32 FF FF FF FF 01
*42 94 07 AF 00 B0 8E F0 1B 00 00 00
40 03 64 6F 63 B0 00 01 02 03 04 05 06 07 08 09 0A 0B 0C 0D 0E 0F 01
40 02 49 44 B1 00 01 02 03 04 05 06 07 08 09 0A 0B 0C 0D 0E 0F
WEBSITEDATA;

$expectedresults = <<< WEBSITEDATA
<doc></doc>
<!--comment-->
<doc attr="false"></doc>
<doc xmlns:p="http://abc"></doc>
<doc xmlns:pre="http://abc" pre:attr="false"></doc>
<doc str8="true"></doc>
<doc xmlns:pre="http://abc" pre:str0="true"></doc>
<arr>13107</arr><arr>-30584</arr><arr>-8739</arr>
<doc xmlns:f="http://abc" f:str11="hello"></doc>
<doc xmlns:x="http://abc" x:str21="world"></doc>
<doc xmlns:k="http://abc" k:attr="true"></doc>
<doc xmlns:z="http://abc" z:abc="xyz"></doc>
<pre:doc xmlns:pre="http://abc"></pre:doc>
<str14></str14>
<pre:str14 xmlns:pre="http://abc"></pre:str14>
<a:str10 xmlns:a="http://abc"></a:str10>
<s:str38 xmlns:s="http://abc"></s:str38>
<a:hello xmlns:a="http://abc"></a:hello>
<s:MyMessage xmlns:s="http://abc"></s:MyMessage>
<doc str416="0"></doc>
<doc str0="1"></doc>
<str154>127</str154>
<abc>0</abc>
<abc>1</abc>
<doc str236="-34"></doc>
<doc str236="-32768"></doc>
<str154>32767</str154>
<doc str236="123456789"></doc>
<str154>2147483647</str154>
<doc a="1.1000000238419"></doc>
<Price>32.450000762939</Price>
<doc a="2.718281828459"></doc>
<PI>3.1415926535898</PI>
<doc>hello</doc>
<a>hello</a>
<doc>hello</doc>
<a>hello</a>
<doc>hello</doc>
<a>hello</a>
<doc>AAECAwQFBgc=</doc>
<Base64>AAECAwQFBgc=</Base64>
<doc>AAECAwQFBgc=</doc>
<Base64>AAECAwQFBgc=</Base64>
<doc>AAECAwQFBgc=</doc>
<Base64>AAECAwQFBgc=</Base64>
<doc a="123 hello true"></doc>
<doc a=""></doc>
<doc></doc>
<doc ns="str56"></doc>
<Type>str196</Type>
<doc>true</doc>
<arr>true</arr><arr>false</arr><arr>true</arr><arr>false</arr><arr>true</arr>
<doc u="&#x7500;&#x6E00;&#x6900;"></doc>
<U>甀渀椀</U>
<doc u16="&#x7500;&#x6E00;&#x6900;&#x3200;"></doc>
<U16>甀渀椀㈀</U16>
<doc u32="&#x3300;&#x3200;"></doc>
<U32>㌀㈀</U32>
<doc str880="i:str910"></doc>
<Type>s:str912</Type>
<doc str110="9999-12-31T23:59:59.9999999"></doc>
<str108>2006-05-17</str108>
<doc int="5.123456"></doc>
<MaxValue>79228162514264337593543950335</MaxValue>
<str14></str14>
<str5521></str5521>
<str16384></str16384>
<str2097152></str2097152>
<str268435456></str268435456>
<doc str236="2147483648"></doc>
<str154>1099511627776</str154>
<doc>18446744073709551615</doc>
<str154>18446744073709551614</str154>
<doc>urn:uuid:33221100-5544-7766-8899-aabbccddeeff</doc>
<str26>urn:uuid:33221100-5544-7766-8899-aabbccddeeff</str26>
<doc>-PT5M44S</doc>
<str916>PT3H20M</str916>
<doc>03020100-0504-0706-0809-0a0b0c0d0e0f</doc>
<ID>03020100-0504-0706-0809-0a0b0c0d0e0f</ID>
WEBSITEDATA;

require 'phpBinaryXml.php';

$results = explode("\n", $expectedresults);
foreach(explode("\n", $testdata) as $linenum => $line) {
    //if($line{0} == '*') { $line = substr($line, 1); }
    //else continue;
    if($line{0} == '*') { continue; }
    
    print($line."\n");
    $content = "";
    foreach(explode(" ", trim($line)) as $code) {
        $content .= pack("H*", $code);
    }
    try {
        $output = phpBinaryXml::decode($content);
        
        if(empty($results[$linenum])) {
            var_dump($output);
        } else if(trim($results[$linenum]) != trim($output)) {
            print("OUTPUT HAS CHANGED:\n".trim($results[$linenum])."\n".trim($output)."\n");
        }
        
    } catch(phpBinaryXmlException $e) {
        var_dump($e->getMessage());
    }
}

?>
