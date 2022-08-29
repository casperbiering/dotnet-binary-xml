<?php

namespace CasperBiering\Dotnet\BinaryXml;

/**
 * SOAP message decoder (MC-NBFS).
 */
class SoapDecoder extends Decoder
{
    public function __construct($options = [])
    {
        parent::__construct(array_merge([
            'dictionary' => SoapConstants::buildDictionary(),
        ], $options));
    }
}
