<?php

namespace CasperBiering\Dotnet;

use CasperBiering\Dotnet\BinaryXml\Decoder;

class BinaryXml
{
    public static function decode($content, $indent = false)
    {
        $decoder = new Decoder(array(
            'indent' => $indent,
            'dictionary' => 'str%d',
        ));

        return $decoder->decode($content);
    }
}
