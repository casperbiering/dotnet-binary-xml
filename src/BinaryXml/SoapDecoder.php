<?php

namespace CasperBiering\Dotnet\BinaryXml;

/**
 * SOAP message decoder (MC-NBFS).
 */
class SoapDecoder extends Decoder
{
    public function __construct($options = array())
    {
        parent::__construct(array_merge(array(
            'dictionary' => SoapConstants::buildDictionary(),
        ), $options));
    }
}
