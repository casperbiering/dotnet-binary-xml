<?php

namespace CasperBiering\Dotnet\Tests\BinaryXml;

use CasperBiering\Dotnet\BinaryXml\SoapDecoder;

class SoapDecoderTest extends \PHPUnit_Framework_TestCase
{
    public function testSample()
    {
        $binary = file_get_contents(__DIR__.'/soap1.bin');
        $expected = file_get_contents(__DIR__.'/soap1.xml');
        $decoder = new SoapDecoder();

        $actual = $decoder->decode($binary);

        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }
}
