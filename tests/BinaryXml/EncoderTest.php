<?php

namespace CasperBiering\Dotnet\Tests\BinaryXml;

use CasperBiering\Dotnet\BinaryXml\Encoder;

class EncoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException CasperBiering\Dotnet\BinaryXml\EncodingException
     * @expectedExceptionMessage Unsupported XML node type 7.
     */
    public function testUnsupportedProcessingInstruction()
    {
        $encoder = new Encoder();

        $encoder->encode('<?abc?><doc></doc>');
    }

    /**
     * @expectedException CasperBiering\Dotnet\BinaryXml\EncodingException
     * @expectedExceptionMessage Unsupported XML node type 4.
     */
    public function testUnsupportedCdata()
    {
        $encoder = new Encoder();

        $encoder->encode('<doc><![CDATA[abc]]></doc>');
    }

    /**
     * @expectedException CasperBiering\Dotnet\BinaryXml\EncodingException
     * @expectedExceptionMessage Unsupported XML node type 10.
     */
    public function testUnsupportedDoctype()
    {
        $encoder = new Encoder();

        $encoder->encode('<?xml version="1.0"?><!DOCTYPE foo SYSTEM "./foo.dtd"><doc />');
    }

    /**
     * @dataProvider samples
     */
    public function testSamples($xml, $expectedHex)
    {
        $expectedHex = strtoupper(preg_replace('/\s+/', '', $expectedHex));
        $encoder = new Encoder(array(
            'dictionary' => array('dict0', 'dict1', 'dict2', 'http://dict3'),
        ));

        $actual = $encoder->encode($xml);

        $actualHex = strtoupper(bin2hex($actual));
        $this->assertEquals($expectedHex, $actualHex);
    }

    public function samples()
    {
        return array(
            array('<doc></doc>', '40 03 64 6F 63 01'),
            array('<doc><!--abc--></doc>', '40 03 64 6F 63 02 03 61 62 63 01'),
            array('<doc>0</doc>', '40 03 64 6F 63 80 01'),
            array('<doc>1</doc>', '40 03 64 6F 63 82 01'),
            array('<doc>true</doc>', '40 03 64 6F 63 86 01'),
            array('<doc>false</doc>', '40 03 64 6F 63 84 01'),
            array('<doc>abc</doc>', '40 03 64 6F 63 98 03 61 62 63 01'),
            array('<doc>dict2</doc>', '40 03 64 6F 63 AA 02 01'),
            array('<doc>   </doc>', '40 03 64 6F 63 98 03 20 20 20 01'),
            array('<doc attr="abc"></doc>', '40 03 64 6F 63 04 04 61 74 74 72 98 03 61 62 63 01'),
            array('<doc attr=""></doc>', '40 03 64 6F 63 04 04 61 74 74 72 A8 01'),
            array('<doc attr="dict2"></doc>', '40 03 64 6F 63 04 04 61 74 74 72 AA 02 01'),
            array('<doc attr="false"></doc>', '40 03 64 6F 63 04 04 61 74 74 72 84 01'),
            array('<doc dict1="abc"></doc>', '40 03 64 6F 63 06 01 98 03 61 62 63 01'),
            array('<doc xmlns="http://abc"></doc>', '40 03 64 6F 63 08 0A 68 74 74 70 3A 2F 2F 61 62 63 01'),
            array('<doc xmlns="http://dict3"></doc>', '40 03 64 6F 63 0A 03 01'),
            array('<doc xmlns:abc="http://def"></doc>', '40 03 64 6F 63 09 03 61 62 63 0A 68 74 74 70 3A 2F 2F 64 65 66 01'),
            array('<doc xmlns:abc="http://dict3"></doc>', '40 03 64 6F 63 0B 03 61 62 63 03 01'),
            array('<doc xmlns:abc="http://dict3" abc:def="ghi"></doc>', '40 03 64 6F 63 0B 03 61 62 63 03 05 03 61 62 63 03 64 65 66 98 03 67 68 69 01'),
            array('<doc xmlns:abc="http://dict3" abc:dict2="ghi"></doc>', '40 03 64 6F 63 0B 03 61 62 63 03 07 03 61 62 63 02 98 03 67 68 69 01'),
            array('<doc xmlns:abc="http://dict3"><abc:def /></doc>', '40 03 64 6F 63 0B 03 61 62 63 03 41 03 61 62 63 03 64 65 66 01 01'),
            array('<abc><def /><ghi /></abc>', '40 03 61 62 63 40 03 64 65 66 01 40 03 67 68 69 01 01'),
            array('<dict2></dict2>', '42 02 01'),
        );
    }
}
