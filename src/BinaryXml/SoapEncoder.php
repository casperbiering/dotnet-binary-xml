<?php

namespace CasperBiering\Dotnet\BinaryXml;

/**
 * SOAP message encoder (MC-NBFS).
 */
class SoapEncoder extends Encoder
{
    public function __construct($options = array())
    {
        parent::__construct(array_merge(array(
            'dictionary' => SoapConstants::buildDictionary(),
        ), $options));
    }
}
