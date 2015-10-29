<?php

namespace CasperBiering\Dotnet\Tests\BinaryXml;

use CasperBiering\Dotnet\BinaryXml\Decoder;

class DecoderTest extends \PHPUnit_Framework_TestCase
{
    public function testIndent()
    {
        $binary = $this->convertToBinary('40 03 64 6F 63 40 03 61 62 63 01 01');
        $expected = "<doc>\n <abc></abc>\n</doc>\n";

        $decoder = new Decoder(array('indent' => true));
        $actual = $decoder->decode($binary);

        $this->assertEquals($expected, $actual);
    }

    public function testDictionary()
    {
        $binary = $this->convertToBinary('42 40 01');
        $expected = '<test></test>';

        $decoder = new Decoder(array('dictionary' => array(0x40 => 'test')));
        $actual = $decoder->decode($binary);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \CasperBiering\Dotnet\BinaryXml\DecodingException
     * @expectedExceptionMessage Invalid DictionaryString 0x40.
     */
    public function testInvalidDictionaryString()
    {
        $binary = $this->convertToBinary('42 40 01');
        $expected = '<test></test>';

        $decoder = new Decoder(array('dictionary' => array()));
        $decoder->decode($binary);
    }

    /**
     * @expectedException \CasperBiering\Dotnet\BinaryXml\DecodingException
     */
    public function testEmpty()
    {
        $decoder = new Decoder();
        $decoder->decode('');
    }

    /**
     * @expectedException \CasperBiering\Dotnet\BinaryXml\DecodingException
     * @expectedExceptionMessage Invalid MultiByteInt31 at position 1.
     */
    public function testInvalidMultiByteInt31()
    {
        $binary = $this->convertToBinary('40 80 80 80 80 80');
        $decoder = new Decoder();

        $decoder->decode($binary);
    }

    /**
     * @expectedException \CasperBiering\Dotnet\BinaryXml\DecodingException
     * @expectedExceptionMessage Unknown record type 0xF0 at position 3.
     */
    public function testInvalidRecordType()
    {
        $binary = $this->convertToBinary('40 01 61 F0 F1 F2');
        $decoder = new Decoder();

        $decoder->decode($binary);
    }

    /**
     * @expectedException \CasperBiering\Dotnet\BinaryXml\DecodingException
     * @expectedExceptionMessage Unknown record type 0xF0 at position 7.
     */
    public function testInvalidArrayElementRecordType()
    {
        $binary = $this->convertToBinary('03 40 01 61 01 F0 F1 F2');
        $decoder = new Decoder();

        $decoder->decode($binary);
    }

    /**
     * @expectedException \CasperBiering\Dotnet\BinaryXml\DecodingException
     * @expectedExceptionMessage Unknown boolean value 0xF0 at position 5.
     */
    public function testInvalidBoolean()
    {
        $binary = $this->convertToBinary('40 01 61 B5 F0');
        $decoder = new Decoder();

        $decoder->decode($binary);
    }

    /**
     * @dataProvider specExamples
     */
    public function testSpecExample($hexcodes, $expected)
    {
        $binary = $this->convertToBinary($hexcodes);
        $decoder = new Decoder(array('dictionary' => 'str%d'));

        $actual = $decoder->decode($binary);

        $this->assertEquals($expected, $actual);
    }

    public function specExamples()
    {
        return array(
            array('40 03 64 6F 63 01', '<doc></doc>'),
            array('02 07 63 6F 6D 6D 65 6E 74', '<!--comment-->'),
            array('40 03 64 6F 63 04 04 61 74 74 72 84 01', '<doc attr="false"></doc>'),
            array('40 03 64 6F 63 09 01 70 0A 68 74 74 70 3A 2F 2F 61 62 63 01', '<doc xmlns:p="http://abc"></doc>'),
            array('40 03 64 6F 63 09 03 70 72 65 0A 68 74 74 70 3A 2F 2F 61 62 63 05 03 70 72 65 04 61 74 74 72 84 01', '<doc xmlns:pre="http://abc" pre:attr="false"></doc>'),
            array('40 03 64 6F 63 0A 04 01', '<doc xmlns="str4"></doc>'),
            array('40 03 64 6F 63 0B 01 70 04 01', '<doc xmlns:p="str4"></doc>'),
            array('40 03 64 6F 63 06 08 86 01', '<doc str8="true"></doc>'),
            array('40 03 64 6F 63 09 03 70 72 65 0A 68 74 74 70 3A 2F 2F 61 62 63 07 03 70 72 65 00 86 01', '<doc xmlns:pre="http://abc" pre:str0="true"></doc>'),
            array('03 40 03 61 72 72 01 8B 03 33 33 88 88 DD DD', '<arr>13107</arr><arr>-30584</arr><arr>-8739</arr>'),
            array('40 03 64 6F 63 09 01 66 0A 68 74 74 70 3A 2F 2F 61 62 63 11 0B 98 05 68 65 6C 6C 6F 01', '<doc xmlns:f="http://abc" f:str11="hello"></doc>'),
            array('40 03 64 6F 63 09 01 78 0A 68 74 74 70 3A 2F 2F 61 62 63 23 15 98 05 77 6F 72 6C 64 01', '<doc xmlns:x="http://abc" x:str21="world"></doc>'),
            array('40 03 64 6F 63 09 01 6B 0A 68 74 74 70 3A 2F 2F 61 62 63 30 04 61 74 74 72 86 01', '<doc xmlns:k="http://abc" k:attr="true"></doc>'),
            array('40 03 64 6F 63 09 01 7A 0A 68 74 74 70 3A 2F 2F 61 62 63 3F 03 61 62 63 98 03 78 79 7A 01', '<doc xmlns:z="http://abc" z:abc="xyz"></doc>'),
            array('41 03 70 72 65 03 64 6F 63 09 03 70 72 65 0A 68 74 74 70 3A 2F 2F 61 62 63 01', '<pre:doc xmlns:pre="http://abc"></pre:doc>'),
            array('42 0E 01', '<str14></str14>'),
            array('43 03 70 72 65 0E 09 03 70 72 65 0A 68 74 74 70 3A 2F 2F 61 62 63 01', '<pre:str14 xmlns:pre="http://abc"></pre:str14>'),
            array('44 0A 09 01 61 0A 68 74 74 70 3A 2F 2F 61 62 63 01', '<a:str10 xmlns:a="http://abc"></a:str10>'),
            array('56 26 09 01 73 0A 68 74 74 70 3A 2F 2F 61 62 63 01', '<s:str38 xmlns:s="http://abc"></s:str38>'),
            array('5E 05 68 65 6C 6C 6F 09 01 61 0A 68 74 74 70 3A 2F 2F 61 62 63 01', '<a:hello xmlns:a="http://abc"></a:hello>'),
            array('70 09 4D 79 4D 65 73 73 61 67 65 09 01 73 0A 68 74 74 70 3A 2F 2F 61 62 63 01', '<s:MyMessage xmlns:s="http://abc"></s:MyMessage>'),
            array('40 03 64 6F 63 06 A0 03 80 01', '<doc str416="0"></doc>'),
            array('40 03 64 6F 63 06 00 82 01', '<doc str0="1"></doc>'),
            array('42 9A 01 89 7F', '<str154>127</str154>'),
            array('40 03 61 62 63 81', '<abc>0</abc>'),
            array('40 03 61 62 63 83', '<abc>1</abc>'),
            array('40 03 61 62 63 85', '<abc>false</abc>'),
            array('40 03 61 62 63 87', '<abc>true</abc>'),
            array('40 03 64 6F 63 06 EC 01 88 DE 01', '<doc str236="-34"></doc>'),
            array('40 03 64 6F 63 06 EC 01 8A 00 80 01', '<doc str236="-32768"></doc>'),
            array('42 9A 01 8B FF 7F', '<str154>32767</str154>'),
            array('40 03 64 6F 63 06 EC 01 8C 15 CD 5B 07 01', '<doc str236="123456789"></doc>'),
            array('42 9A 01 8D FF FF FF 7F', '<str154>2147483647</str154>'),
            array('40 03 64 6F 63 04 01 61 90 CD CC 8C 3F 01', '<doc a="1.1000000238419"></doc>'),
            array('40 05 50 72 69 63 65 91 CD CC 01 42', '<Price>32.450000762939</Price>'),
            array('40 03 64 6F 63 04 01 61 92 74 57 14 8B 0A BF 05 40 01', '<doc a="2.718281828459"></doc>'),
            array('40 02 50 49 93 11 2D 44 54 FB 21 09 40', '<PI>3.1415926535898</PI>'),
            array('40 03 64 6F 63 98 05 68 65 6C 6C 6F 01', '<doc>hello</doc>'),
            array('40 01 61 99 05 68 65 6C 6C 6F', '<a>hello</a>'),
            array('40 03 64 6F 63 9A 05 00 68 65 6C 6C 6F 01', '<doc>hello</doc>'),
            array('40 01 61 9B 05 00 68 65 6C 6C 6F', '<a>hello</a>'),
            array('40 03 64 6F 63 9C 05 00 00 00 68 65 6C 6C 6F 01', '<doc>hello</doc>'),
            array('40 01 61 9D 05 00 00 00 68 65 6C 6C 6F', '<a>hello</a>'),
            array('40 03 64 6F 63 9E 08 00 01 02 03 04 05 06 07 01', '<doc>AAECAwQFBgc=</doc>'),
            array('40 06 42 61 73 65 36 34 9F 08 00 01 02 03 04 05 06 07', '<Base64>AAECAwQFBgc=</Base64>'),
            array('40 03 64 6F 63 A0 08 00 00 01 02 03 04 05 06 07 01', '<doc>AAECAwQFBgc=</doc>'),
            array('40 06 42 61 73 65 36 34 A1 08 00 00 01 02 03 04 05 06 07', '<Base64>AAECAwQFBgc=</Base64>'),
            array('40 03 64 6F 63 A2 08 00 00 00 00 01 02 03 04 05 06 07 01', '<doc>AAECAwQFBgc=</doc>'),
            array('40 06 42 61 73 65 36 34 A3 08 00 00 00 00 01 02 03 04 05 06 07', '<Base64>AAECAwQFBgc=</Base64>'),
            array('40 03 64 6F 63 04 01 61 A4 88 7B 98 05 68 65 6C 6C 6F 86 A6 01', '<doc a="123 hello true"></doc>'),
            array('40 03 64 6F 63 04 01 61 A8 01', '<doc a=""></doc>'),
            array('40 03 64 6F 63 A9', '<doc></doc>'),
            array('40 03 64 6F 63 04 02 6E 73 AA 38 01', '<doc ns="str56"></doc>'),
            array('40 04 54 79 70 65 AB C4 01', '<Type>str196</Type>'),
            array('40 03 64 6F 63 B4 01 01', '<doc>true</doc>'),
            array('03 40 03 61 72 72 01 B5 05 01 00 01 00 01', '<arr>true</arr><arr>false</arr><arr>true</arr><arr>false</arr><arr>true</arr>'),
            array('40 03 64 6F 63 04 01 75 B6 06 75 00 6E 00 69 00 01', '<doc u="&#x7500;&#x6E00;&#x6900;"></doc>'),
            array('40 01 55 B7 06 75 00 6E 00 69 00', '<U>甀渀椀</U>'),
            array('40 03 64 6F 63 04 03 75 31 36 B8 08 00 75 00 6E 00 69 00 32 00 01', '<doc u16="&#x7500;&#x6E00;&#x6900;&#x3200;"></doc>'),
            array('40 03 55 31 36 B9 08 00 75 00 6E 00 69 00 32 00', '<U16>甀渀椀㈀</U16>'),
            array('40 03 64 6F 63 04 03 75 33 32 BA 04 00 00 00 33 00 32 00 01', '<doc u32="&#x3300;&#x3200;"></doc>'),
            array('40 03 55 33 32 BB 04 00 00 00 33 00 32 00', '<U32>㌀㈀</U32>'),
            array('40 03 64 6F 63 06 F0 06 BC 08 8E 07 01', '<doc str880="i:str910"></doc>'),
            array('40 04 54 79 70 65 BD 12 90 07', '<Type>s:str912</Type>'),
            array('40 03 64 6F 63 06 6E 96 FF 3F 37 F4 75 28 CA 2B 01', '<doc str110="9999-12-31T23:59:59.9999999"></doc>'),
            array('42 6C 97 00 40 8E F9 5B 47 C8 08', '<str108>2006-05-17</str108>'),
            array('40 03 64 6F 63 04 03 69 6E 74 94 00 00 06 00 00 00 00 00 80 2D 4E 00 00 00 00 00 01', '<doc int="5.123456"></doc>'),
            array('40 08 4D 61 78 56 61 6C 75 65 95 00 00 00 00 FF FF FF FF FF FF FF FF FF FF FF FF', '<MaxValue>79228162514264337593543950335</MaxValue>'),
            array('42 0E 01', '<str14></str14>'),
            array('42 91 2B 01', '<str5521></str5521>'),
            array('42 80 80 01 01', '<str16384></str16384>'),
            array('42 80 80 80 01 01', '<str2097152></str2097152>'),
            array('42 80 80 80 80 01 01', '<str268435456></str268435456>'),
            array('40 03 64 6F 63 06 EC 01 8E 00 00 00 80 00 00 00 00 01', '<doc str236="2147483648"></doc>'),
            array('42 9A 01 8F 00 00 00 00 00 01 00 00', '<str154>1099511627776</str154>'),
            array('40 03 64 6F 63 B2 FF FF FF FF FF FF FF FF 01', '<doc>18446744073709551615</doc>'),
            array('42 9A 01 B3 FE FF FF FF FF FF FF FF', '<str154>18446744073709551614</str154>'),
            array('40 03 64 6F 63 AC 00 11 22 33 44 55 66 77 88 99 AA BB CC DD EE FF 01', '<doc>urn:uuid:33221100-5544-7766-8899-aabbccddeeff</doc>'),
            array('42 1A AD 00 11 22 33 44 55 66 77 88 99 AA BB CC DD EE FF', '<str26>urn:uuid:33221100-5544-7766-8899-aabbccddeeff</str26>'),
            array('40 03 64 6F 63 AE 00 C4 F5 32 FF FF FF FF 01', '<doc>-PT5M44S</doc>'),
            array('42 94 07 AF 00 B0 8E F0 1B 00 00 00', '<str916>PT3H20M</str916>'),
            array('40 03 64 6F 63 B0 00 01 02 03 04 05 06 07 08 09 0A 0B 0C 0D 0E 0F 01', '<doc>03020100-0504-0706-0809-0a0b0c0d0e0f</doc>'),
            array('40 02 49 44 B1 00 01 02 03 04 05 06 07 08 09 0A 0B 0C 0D 0E 0F', '<ID>03020100-0504-0706-0809-0a0b0c0d0e0f</ID>'),
        );
    }

    private function convertToBinary($hexString)
    {
        return pack('H*', preg_replace('/\s+/', '', $hexString));
    }
}
