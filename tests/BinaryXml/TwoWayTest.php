<?php

namespace CasperBiering\Dotnet\Tests\BinaryXml;

use CasperBiering\Dotnet\BinaryXml\Decoder;
use CasperBiering\Dotnet\BinaryXml\Encoder;

class TwoWayTest extends \PHPUnit\Framework\TestCase
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
        return [
            ['<doc></doc>'],
            ['<doc attr="false"></doc>'],
            ['<doc xmlns:p="http://abc"></doc>'],
            ['<doc xmlns:pre="http://abc" pre:attr="false"></doc>'],
            ['<doc xmlns="http://dict3"></doc>'],
            ['<doc xmlns:p="str4"></doc>'],
            ['<doc str8="true"></doc>'],
            ['<doc xmlns:pre="http://abc" pre:str0="true"></doc>'],
            ['<doc xmlns:f="http://abc" f:str11="hello"></doc>'],
            ['<doc xmlns:x="http://abc" x:str21="world"></doc>'],
            ['<doc xmlns:k="http://abc" k:attr="true"></doc>'],
            ['<doc xmlns:z="http://abc" z:abc="xyz"></doc>'],
            ['<pre:doc xmlns:pre="http://abc"></pre:doc>'],
            ['<str14></str14>'],
            ['<pre:str14 xmlns:pre="http://abc"></pre:str14>'],
            ['<a:str10 xmlns:a="http://abc"></a:str10>'],
            ['<s:str38 xmlns:s="http://abc"></s:str38>'],
            ['<a:hello xmlns:a="http://abc"></a:hello>'],
            ['<s:MyMessage xmlns:s="http://abc"></s:MyMessage>'],
            ['<doc str416="0"></doc>'],
            ['<doc str0="1"></doc>'],
            ['<str154>127</str154>'],
            ['<abc>0</abc>'],
            ['<abc>1</abc>'],
            ['<abc>false</abc>'],
            ['<abc>true</abc>'],
            ['<doc str236="-34"></doc>'],
            ['<doc str236="-32768"></doc>'],
            ['<str154>32767</str154>'],
            ['<doc str236="123456789"></doc>'],
            ['<str154>2147483647</str154>'],
            ['<doc a="1.1000000238419"></doc>'],
            ['<Price>32.450000762939</Price>'],
            ['<doc a="2.718281828459"></doc>'],
            ['<PI>3.1415926535898</PI>'],
            ['<doc>hello</doc>'],
            ['<a>hello</a>'],
            ['<doc>hello</doc>'],
            ['<a>hello</a>'],
            ['<doc>hello</doc>'],
            ['<a>hello</a>'],
            ['<doc>AAECAwQFBgc=</doc>'],
            ['<Base64>AAECAwQFBgc=</Base64>'],
            ['<doc>AAECAwQFBgc=</doc>'],
            ['<Base64>AAECAwQFBgc=</Base64>'],
            ['<doc>AAECAwQFBgc=</doc>'],
            ['<Base64>AAECAwQFBgc=</Base64>'],
            ['<doc a="123 hello true"></doc>'],
            ['<doc a=""></doc>'],
            ['<doc></doc>'],
            ['<doc ns="str56"></doc>'],
            ['<Type>str196</Type>'],
            ['<doc>true</doc>'],
            ['<doc u="&#x7500;&#x6E00;&#x6900;"></doc>'],
            ['<U>甀渀椀</U>'],
            ['<doc u16="&#x7500;&#x6E00;&#x6900;&#x3200;"></doc>'],
            ['<U16>甀渀椀㈀</U16>'],
            ['<doc u32="&#x3300;&#x3200;"></doc>'],
            ['<U32>㌀㈀</U32>'],
            ['<doc str880="i:str910"></doc>'],
            ['<Type>s:str912</Type>'],
            ['<doc str110="9999-12-31T23:59:59.9999999"></doc>'],
            ['<str108>2006-05-17</str108>'],
            ['<doc int="5.123456"></doc>'],
            ['<MaxValue>79228162514264337593543950335</MaxValue>'],
            ['<str14></str14>'],
            ['<str5521></str5521>'],
            ['<str16384></str16384>'],
            ['<str2097152></str2097152>'],
            ['<str268435456></str268435456>'],
            ['<doc str236="2147483648"></doc>'],
            ['<str154>1099511627776</str154>'],
            ['<doc>18446744073709551615</doc>'],
            ['<str154>18446744073709551614</str154>'],
            ['<doc>urn:uuid:33221100-5544-7766-8899-aabbccddeeff</doc>'],
            ['<str26>urn:uuid:33221100-5544-7766-8899-aabbccddeeff</str26>'],
            ['<doc>-PT5M44S</doc>'],
            ['<str916>PT3H20M</str916>'],
            ['<doc>03020100-0504-0706-0809-0a0b0c0d0e0f</doc>'],
            ['<ID>03020100-0504-0706-0809-0a0b0c0d0e0f</ID>'],
        ];
    }
}
