<?php

namespace CasperBiering\Dotnet\BinaryXml;

use XMLReader;

/**
 * Binary XML encoder.
 */
class Encoder
{
    private $options;

    /**
     * Constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge([
            'dictionary' => [],
        ], $options);
    }

    /**
     * Encode a XML message.
     *
     * @param string $xml The XML document
     *
     * @throws EncodingException if the message can not be encoded
     *
     * @return string
     */
    public function encode($xml)
    {
        if (empty($xml)) {
            return '';
        }

        libxml_clear_errors();
        $reader = new XMLReader();
        $reader->xml($xml);

        $binary = '';
        while (@$reader->read()) {
            switch ($reader->nodeType) {
                case XMLReader::NONE:
                    break;

                case XMLReader::ELEMENT:
                    $index = $this->getDictionaryIndex($reader->localName);
                    if ($reader->prefix && $index !== false) {
                        $binary .= chr(Constants::RECORD_TYPE_DICTIONARY_ELEMENT);
                        $this->writeString($binary, $reader->prefix);
                        $this->writeDictionaryString($binary, $index);
                    } elseif ($reader->prefix) {
                        $binary .= chr(Constants::RECORD_TYPE_ELEMENT);
                        $this->writeString($binary, $reader->prefix);
                        $this->writeString($binary, $reader->localName);
                    } elseif ($index !== false) {
                        $binary .= chr(Constants::RECORD_TYPE_SHORT_DICTIONARY_ELEMENT);
                        $this->writeDictionaryString($binary, $index);
                    } else {
                        $binary .= chr(Constants::RECORD_TYPE_SHORT_ELEMENT);
                        $this->writeString($binary, $reader->localName);
                    }
                    $emptyElement = $reader->isEmptyElement;
                    $this->writeAttributes($binary, $reader);
                    if ($emptyElement) {
                        $binary .= chr(Constants::RECORD_TYPE_END_ELEMENT);
                    }
                    break;

                case XMLReader::TEXT:
                    $this->writeTextRecord($binary, $reader->value);
                    break;

                case XMLReader::COMMENT:
                    $binary .= chr(Constants::RECORD_TYPE_COMMENT);
                    $this->writeString($binary, $reader->value);
                    break;

                case XMLReader::WHITESPACE:
                    break;

                case XMLReader::SIGNIFICANT_WHITESPACE:
                    $this->writeTextRecord($binary, $reader->value);
                    break;

                case XMLReader::END_ELEMENT:
                    // TODO: Use *_WITH_END_ELEMENT if possible
                    $binary .= chr(Constants::RECORD_TYPE_END_ELEMENT);
                    break;

                case XMLReader::ATTRIBUTE:
                    throw new EncodingException('Invalid encoding state.');
                case XMLReader::DOC:
                case XMLReader::DOC_TYPE:
                case XMLReader::DOC_FRAGMENT:
                case XMLReader::NOTATION:
                case XMLReader::XML_DECLARATION:
                case XMLReader::CDATA:
                case XMLReader::ENTITY:
                case XMLReader::ENTITY_REF:
                case XMLReader::END_ENTITY:
                case XMLReader::PI:
                default:
                    throw new EncodingException(sprintf('Unsupported XML node type %d.', $reader->nodeType));
            }
        }

        $last_error = libxml_get_last_error();
        if ($last_error !== false) {
            throw new EncodingException(sprintf('XML Parsing Error "%s".', rtrim($last_error->message)));
        }

        return $binary;
    }

    protected function writeAttributes(&$binary, XMLReader $reader)
    {
        if (!$reader->hasAttributes) {
            return;
        }

        while ($reader->moveToNextAttribute()) {
            if ($reader->prefix == 'xmlns') {
                $index = $this->getDictionaryIndex($reader->value);
                if ($index !== false) {
                    $binary .= chr(Constants::RECORD_TYPE_DICTIONARY_XMLNS_ATTRIBUTE);
                    $this->writeString($binary, $reader->localName);
                    $this->writeDictionaryString($binary, $index);
                } else {
                    $binary .= chr(Constants::RECORD_TYPE_XMLNS_ATTRIBUTE);
                    $this->writeString($binary, $reader->localName);
                    $this->writeString($binary, $reader->value);
                }
            } elseif (!$reader->prefix && $reader->localName == 'xmlns') {
                $index = $this->getDictionaryIndex($reader->value);
                if ($index !== false) {
                    $binary .= chr(Constants::RECORD_TYPE_SHORT_DICTIONARY_XMLNS_ATTRIBUTE);
                    $this->writeDictionaryString($binary, $index);
                } else {
                    $binary .= chr(Constants::RECORD_TYPE_SHORT_XMLNS_ATTRIBUTE);
                    $this->writeString($binary, $reader->value);
                }
            } elseif ($reader->prefix) {
                $index = $this->getDictionaryIndex($reader->localName);
                if ($index !== false) {
                    $binary .= chr(Constants::RECORD_TYPE_DICTIONARY_ATTRIBUTE);
                    $this->writeString($binary, $reader->prefix);
                    $this->writeDictionaryString($binary, $index);
                } else {
                    $binary .= chr(Constants::RECORD_TYPE_ATTRIBUTE);
                    $this->writeString($binary, $reader->prefix);
                    $this->writeString($binary, $reader->localName);
                }
                $this->writeTextRecord($binary, $reader->value);
            } else {
                $index = $this->getDictionaryIndex($reader->localName);
                if ($index !== false) {
                    $binary .= chr(Constants::RECORD_TYPE_SHORT_DICTIONARY_ATTRIBUTE);
                    $this->writeDictionaryString($binary, $index);
                } else {
                    $binary .= chr(Constants::RECORD_TYPE_SHORT_ATTRIBUTE);
                    $this->writeString($binary, $reader->localName);
                }
                $this->writeTextRecord($binary, $reader->value);
            }
        }
    }

    protected function writeDictionaryString(&$binary, $index)
    {
        return $this->writeMultiByteInt31($binary, $index);
    }

    protected function writeString(&$binary, $string)
    {
        $this->writeMultiByteInt31($binary, strlen($string));
        $binary .= $string;
    }

    protected function writeTextRecord(&$binary, $string)
    {
        $length = strlen($string);
        if ($string === '') {
            $binary .= chr(Constants::RECORD_TYPE_EMPTY_TEXT);
        } elseif ($string === '0') {
            $binary .= chr(Constants::RECORD_TYPE_ZERO_TEXT);
        } elseif ($string === '1') {
            $binary .= chr(Constants::RECORD_TYPE_ONE_TEXT);
        } elseif ($string === 'false') {
            $binary .= chr(Constants::RECORD_TYPE_FALSE_TEXT);
        } elseif ($string === 'true') {
            $binary .= chr(Constants::RECORD_TYPE_TRUE_TEXT);
        } elseif (($index = $this->getDictionaryIndex($string)) !== false) {
            $binary .= chr(Constants::RECORD_TYPE_DICTIONARY_TEXT);
            $this->writeDictionaryString($binary, $index);
        } elseif ($length <= 0xFF) {
            $binary .= chr(Constants::RECORD_TYPE_CHARS8_TEXT);
            $binary .= pack('C', $length);
            $binary .= $string;
        } elseif ($length <= 0xFFFF) {
            $binary .= chr(Constants::RECORD_TYPE_CHARS16_TEXT);
            $binary .= pack('v', $length);
            $binary .= $string;
        } else {
            $binary .= chr(Constants::RECORD_TYPE_CHARS32_TEXT);
            $binary .= pack('V', $length);
            $binary .= $string;
        }
        // TODO: Use more efficient encodings for numbers, UUIDs and times
    }

    protected function writeMultiByteInt31(&$binary, $number)
    {
        if ($number < 0) {
            throw new EncodingException('Signed numbers are not supported.');
        }

        if ($number == 0) {
            $binary .= chr(0);

            return;
        }

        for ($i = 0; $i < 5 && $number > 0; $i++) {
            $binary .= chr(($number & 0x7F) + ($number > 0x7F ? 0x80 : 0));
            $number >>= 7;
        }
    }

    protected function getDictionaryIndex($string)
    {
        return array_search($string, $this->options['dictionary'], true);
    }
}
