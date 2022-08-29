<?php

namespace CasperBiering\Dotnet;

use CasperBiering\Dotnet\BinaryXml\Decoder;
use CasperBiering\Dotnet\BinaryXml\Encoder;

class BinaryXml
{
    public static function decode($content, $indent = false)
    {
        $decoder = new Decoder([
            'indent'     => $indent,
            'dictionary' => 'str%d',
        ]);

        return $decoder->decode($content);
    }

    public static function encode($content)
    {
        $encoder = new Encoder();

        return $encoder->encode($content);
    }
}
