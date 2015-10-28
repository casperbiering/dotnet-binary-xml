<?php

namespace CasperBiering\Dotnet;

class BinaryXml
{
    public static function decode($content)
    {
        $decoder = new Decoder();

        return $decoder->decode($content);
    }
}
