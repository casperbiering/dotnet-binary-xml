<?php

namespace CasperBiering\Dotnet\BinaryXml;

/**
 * SOAP message encoder (MC-NBFS).
 */
class SoapEncoder extends Encoder
{
    public function __construct($options = [])
    {
        parent::__construct(array_merge([
            'dictionary' => SoapConstants::buildDictionary(),
        ], $options));
    }
}
