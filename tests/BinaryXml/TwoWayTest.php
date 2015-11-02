<?php

namespace CasperBiering\Dotnet\Tests\BinaryXml;

use CasperBiering\Dotnet\BinaryXml\Decoder;
use CasperBiering\Dotnet\BinaryXml\Encoder;

class TwoWayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider samples
     */
    public function testSamples($xml)
    {
        $encoder = new Encoder();
        $decoder = new Decoder();

        $binary = $encoder->encode($xml);
        $actual = $decoder->decode($binary);

        $this->assertEquals($xml, $actual);
    }

    public function samples()
    {
        return array(
            array('<doc></doc>'),
            array('<doc attr="false"></doc>'),
            array('<doc xmlns:p="http://abc"></doc>'),
            array('<doc xmlns:pre="http://abc" pre:attr="false"></doc>'),
            array('<doc xmlns="http://dict3"></doc>'),
            array('<doc xmlns:p="str4"></doc>'),
            array('<doc str8="true"></doc>'),
            array('<doc xmlns:pre="http://abc" pre:str0="true"></doc>'),
            array('<doc xmlns:f="http://abc" f:str11="hello"></doc>'),
            array('<doc xmlns:x="http://abc" x:str21="world"></doc>'),
            array('<doc xmlns:k="http://abc" k:attr="true"></doc>'),
            array('<doc xmlns:z="http://abc" z:abc="xyz"></doc>'),
            array('<pre:doc xmlns:pre="http://abc"></pre:doc>'),
            array('<str14></str14>'),
            array('<pre:str14 xmlns:pre="http://abc"></pre:str14>'),
            array('<a:str10 xmlns:a="http://abc"></a:str10>'),
            array('<s:str38 xmlns:s="http://abc"></s:str38>'),
            array('<a:hello xmlns:a="http://abc"></a:hello>'),
            array('<s:MyMessage xmlns:s="http://abc"></s:MyMessage>'),
            array('<doc str416="0"></doc>'),
            array('<doc str0="1"></doc>'),
            array('<str154>127</str154>'),
            array('<abc>0</abc>'),
            array('<abc>1</abc>'),
            array('<abc>false</abc>'),
            array('<abc>true</abc>'),
            array('<doc str236="-34"></doc>'),
            array('<doc str236="-32768"></doc>'),
            array('<str154>32767</str154>'),
            array('<doc str236="123456789"></doc>'),
            array('<str154>2147483647</str154>'),
            array('<doc a="1.1000000238419"></doc>'),
            array('<Price>32.450000762939</Price>'),
            array('<doc a="2.718281828459"></doc>'),
            array('<PI>3.1415926535898</PI>'),
            array('<doc>hello</doc>'),
            array('<a>hello</a>'),
            array('<doc>hello</doc>'),
            array('<a>hello</a>'),
            array('<doc>hello</doc>'),
            array('<a>hello</a>'),
            array('<doc>AAECAwQFBgc=</doc>'),
            array('<Base64>AAECAwQFBgc=</Base64>'),
            array('<doc>AAECAwQFBgc=</doc>'),
            array('<Base64>AAECAwQFBgc=</Base64>'),
            array('<doc>AAECAwQFBgc=</doc>'),
            array('<Base64>AAECAwQFBgc=</Base64>'),
            array('<doc a="123 hello true"></doc>'),
            array('<doc a=""></doc>'),
            array('<doc></doc>'),
            array('<doc ns="str56"></doc>'),
            array('<Type>str196</Type>'),
            array('<doc>true</doc>'),
            array('<doc u="&#x7500;&#x6E00;&#x6900;"></doc>'),
            array('<U>甀渀椀</U>'),
            array('<doc u16="&#x7500;&#x6E00;&#x6900;&#x3200;"></doc>'),
            array('<U16>甀渀椀㈀</U16>'),
            array('<doc u32="&#x3300;&#x3200;"></doc>'),
            array('<U32>㌀㈀</U32>'),
            array('<doc str880="i:str910"></doc>'),
            array('<Type>s:str912</Type>'),
            array('<doc str110="9999-12-31T23:59:59.9999999"></doc>'),
            array('<str108>2006-05-17</str108>'),
            array('<doc int="5.123456"></doc>'),
            array('<MaxValue>79228162514264337593543950335</MaxValue>'),
            array('<str14></str14>'),
            array('<str5521></str5521>'),
            array('<str16384></str16384>'),
            array('<str2097152></str2097152>'),
            array('<str268435456></str268435456>'),
            array('<doc str236="2147483648"></doc>'),
            array('<str154>1099511627776</str154>'),
            array('<doc>18446744073709551615</doc>'),
            array('<str154>18446744073709551614</str154>'),
            array('<doc>urn:uuid:33221100-5544-7766-8899-aabbccddeeff</doc>'),
            array('<str26>urn:uuid:33221100-5544-7766-8899-aabbccddeeff</str26>'),
            array('<doc>-PT5M44S</doc>'),
            array('<str916>PT3H20M</str916>'),
            array('<doc>03020100-0504-0706-0809-0a0b0c0d0e0f</doc>'),
            array('<ID>03020100-0504-0706-0809-0a0b0c0d0e0f</ID>'),
        );
    }
}
