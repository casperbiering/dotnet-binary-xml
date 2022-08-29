<?php

namespace CasperBiering\Dotnet\Tests\BinaryXml;

use CasperBiering\Dotnet\BinaryXml\SoapEncoder;

class SoapEncoderTest extends \PHPUnit\Framework\TestCase
{
    public function testSample()
    {
        $xml = file_get_contents(__DIR__.'/soap2.xml');
        $expected = file_get_contents(__DIR__.'/soap2.bin'); // Manual verification needed if output changes
        $encoder = new SoapEncoder();

        $actual = $encoder->encode($xml);

        $this->assertEquals($expected, $actual);
    }
}
