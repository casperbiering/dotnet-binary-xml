<?php

namespace CasperBiering\Dotnet\BinaryXml;

use DateTime;
use DateTimeZone;
use XMLWriter;

class Decoder
{
    private $options;

    public function __construct($options = [])
    {
        $this->options = array_merge([
            'indent'     => false,
            'dictionary' => [],
        ], $options);
    }

    public function decode($content)
    {
        if (empty($content)) {
            throw new DecodingException('Empty content');
        }

        $pos = 0;
        $contentLength = strlen($content);

        $writer = new XMLWriter();
        $writer->openMemory();
        if ($this->options['indent']) {
            $writer->setIndent(true);
        }

        while ($pos < $contentLength) {
            $currentRecordType = $this->peekByte($content, $pos);
            switch ($currentRecordType) {
                case Constants::RECORD_TYPE_END_ELEMENT:
                    $pos += 1;

                    $writer->fullEndElement();
                    break;
                case Constants::RECORD_TYPE_COMMENT:
                    $pos += 1;

                    $comment = $this->readString($content, $pos);
                    $writer->writeComment($comment);

                    break;
                case Constants::RECORD_TYPE_ARRAY:
                    $pos += 1;

                    // Element
                    $this->readByte($content, $pos); // expect it to be 0x40
                    $element = $this->readString($content, $pos);
                    $this->readByte($content, $pos); // expect it to be 0x01

                    // Record type
                    $recordType = $this->readByte($content, $pos);

                    // Length
                    $length = $this->readByte($content, $pos);

                    // Entries
                    for ($entry = 0; $entry < $length; $entry++) {
                        $value = $this->readTextRecordInner($content, $pos, $recordType);
                        $writer->writeElement($element, $value);
                    }

                    break;
                case Constants::RECORD_TYPE_SHORT_ATTRIBUTE:
                    $pos += 1;

                    $name = $this->readString($content, $pos);
                    $value = $this->readTextRecord($content, $pos);

                    $writer->writeAttribute($name, $value);

                    break;
                case Constants::RECORD_TYPE_ATTRIBUTE:
                    $pos += 1;

                    $prefix = $this->readString($content, $pos);
                    $name = $this->readString($content, $pos);
                    $value = $this->readTextRecord($content, $pos);

                    $writer->writeAttribute($prefix.':'.$name, $value);

                    break;
                case Constants::RECORD_TYPE_SHORT_DICTIONARY_ATTRIBUTE:
                    $pos += 1;

                    $name = $this->readDictionaryString($content, $pos);
                    $value = $this->readTextRecord($content, $pos);

                    $writer->writeAttribute($name, $value);

                    break;
                case Constants::RECORD_TYPE_DICTIONARY_ATTRIBUTE:
                    $pos += 1;

                    $prefix = $this->readString($content, $pos);
                    $name = $this->readDictionaryString($content, $pos);
                    $value = $this->readTextRecord($content, $pos);

                    $writer->writeAttribute($prefix.':'.$name, $value);

                    break;
                case Constants::RECORD_TYPE_SHORT_XMLNS_ATTRIBUTE:
                    $pos += 1;

                    $value = $this->readString($content, $pos);

                    $writer->writeAttribute('xmlns', $value);

                    break;
                case Constants::RECORD_TYPE_XMLNS_ATTRIBUTE:
                    $pos += 1;

                    $name = $this->readString($content, $pos);
                    $value = $this->readString($content, $pos);

                    $writer->writeAttribute('xmlns:'.$name, $value);

                    break;
                case Constants::RECORD_TYPE_SHORT_DICTIONARY_XMLNS_ATTRIBUTE:
                    $pos += 1;

                    $value = $this->readDictionaryString($content, $pos);

                    $writer->writeAttribute('xmlns', $value);

                    break;
                case Constants::RECORD_TYPE_DICTIONARY_XMLNS_ATTRIBUTE:
                    $pos += 1;

                    $name = $this->readString($content, $pos);
                    $value = $this->readDictionaryString($content, $pos);

                    $writer->writeAttribute('xmlns:'.$name, $value);

                    break;
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_A:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_B:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_C:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_D:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_E:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_F:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_G:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_H:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_I:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_J:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_K:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_L:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_M:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_N:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_O:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_P:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_Q:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_R:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_S:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_T:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_U:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_V:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_W:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_X:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_Y:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_Z:
                    $char = chr(85 + $this->readByte($content, $pos));

                    $name = $this->readDictionaryString($content, $pos);
                    $value = $this->readTextRecord($content, $pos);

                    $writer->writeAttribute($char.':'.$name, $value);
                    break;
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_A:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_B:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_C:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_D:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_E:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_F:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_G:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_H:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_I:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_J:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_K:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_L:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_M:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_N:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_O:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_P:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_Q:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_R:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_S:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_T:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_U:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_V:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_W:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_X:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_Y:
                case Constants::RECORD_TYPE_PREFIX_ATTRIBUTE_Z:
                    $char = chr(59 + $this->readByte($content, $pos));

                    $name = $this->readString($content, $pos);
                    $value = $this->readTextRecord($content, $pos);

                    $writer->writeAttribute($char.':'.$name, $value);
                    break;
                case Constants::RECORD_TYPE_SHORT_ELEMENT:
                    $pos += 1;

                    $name = $this->readString($content, $pos);
                    $writer->startElement($name);
                    break;
                case Constants::RECORD_TYPE_ELEMENT:
                    $pos += 1;

                    $prefix = $this->readString($content, $pos);
                    $name = $this->readString($content, $pos);
                    $writer->startElement($prefix.':'.$name);
                    break;
                case Constants::RECORD_TYPE_SHORT_DICTIONARY_ELEMENT:
                    $pos += 1;

                    $name = $this->readDictionaryString($content, $pos);
                    $writer->startElement($name);
                    break;
                case Constants::RECORD_TYPE_DICTIONARY_ELEMENT:
                    $pos += 1;

                    $prefix = $this->readString($content, $pos);
                    $name = $this->readDictionaryString($content, $pos);
                    $writer->startElement($prefix.':'.$name);
                    break;
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_A:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_B:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_C:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_D:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_E:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_F:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_G:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_H:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_I:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_J:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_K:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_L:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_M:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_N:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_O:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_P:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_Q:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_R:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_S:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_T:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_U:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_V:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_W:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_X:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_Y:
                case Constants::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_Z:
                    $char = chr(29 + $this->readByte($content, $pos));

                    $name = $this->readDictionaryString($content, $pos);

                    $writer->startElement($char.':'.$name);
                    break;
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_A:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_B:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_C:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_D:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_E:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_F:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_G:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_H:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_I:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_J:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_K:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_L:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_M:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_N:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_O:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_P:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_Q:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_R:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_S:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_T:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_U:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_V:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_W:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_X:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_Y:
                case Constants::RECORD_TYPE_PREFIX_ELEMENT_Z:
                    $char = chr(3 + $this->readByte($content, $pos));

                    $name = $this->readString($content, $pos);

                    $writer->startElement($char.':'.$name);
                    break;
                case Constants::RECORD_TYPE_ZERO_TEXT:
                case Constants::RECORD_TYPE_ONE_TEXT:
                case Constants::RECORD_TYPE_FALSE_TEXT:
                case Constants::RECORD_TYPE_TRUE_TEXT:
                case Constants::RECORD_TYPE_INT8_TEXT:
                case Constants::RECORD_TYPE_INT16_TEXT:
                case Constants::RECORD_TYPE_INT32_TEXT:
                case Constants::RECORD_TYPE_INT64_TEXT:
                case Constants::RECORD_TYPE_FLOAT_TEXT:
                case Constants::RECORD_TYPE_DOUBLE_TEXT:
                case Constants::RECORD_TYPE_DECIMAL_TEXT:
                case Constants::RECORD_TYPE_DATETIME_TEXT:
                case Constants::RECORD_TYPE_CHARS8_TEXT:
                case Constants::RECORD_TYPE_CHARS16_TEXT:
                case Constants::RECORD_TYPE_CHARS32_TEXT:
                case Constants::RECORD_TYPE_BYTES8_TEXT:
                case Constants::RECORD_TYPE_BYTES16_TEXT:
                case Constants::RECORD_TYPE_BYTES32_TEXT:
                case Constants::RECORD_TYPE_EMPTY_TEXT:
                case Constants::RECORD_TYPE_DICTIONARY_TEXT:
                case Constants::RECORD_TYPE_UNIQUEID_TEXT:
                case Constants::RECORD_TYPE_TIMESPAN_TEXT:
                case Constants::RECORD_TYPE_UUID_TEXT:
                case Constants::RECORD_TYPE_UINT64_TEXT:
                case Constants::RECORD_TYPE_BOOL_TEXT:
                case Constants::RECORD_TYPE_UNICODECHARS8_TEXT:
                case Constants::RECORD_TYPE_UNICODECHARS16_TEXT:
                case Constants::RECORD_TYPE_UNICODECHARS32_TEXT:
                case Constants::RECORD_TYPE_QNAMEDICTIONARY_TEXT:
                    $record = $this->readTextRecord($content, $pos);

                    $writer->text($record);
                    break;
                case Constants::RECORD_TYPE_ZERO_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_ONE_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_FALSE_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_TRUE_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_INT8_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_INT16_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_INT32_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_INT64_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_FLOAT_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_DOUBLE_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_DECIMAL_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_DATETIME_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_CHARS8_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_CHARS16_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_CHARS32_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_BYTES8_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_BYTES16_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_BYTES32_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_EMPTY_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_DICTIONARY_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_UNIQUEID_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_TIMESPAN_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_UUID_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_UINT64_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_BOOL_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_UNICODECHARS8_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_UNICODECHARS16_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_UNICODECHARS32_TEXT_WITH_END_ELEMENT:
                case Constants::RECORD_TYPE_QNAMEDICTIONARY_TEXT_WITH_END_ELEMENT:
                    $record = $this->readTextRecord($content, $pos);

                    $writer->text($record);
                    $writer->fullEndElement();
                    break;
                default:
                    throw new DecodingException(sprintf('Unknown record type 0x%02X at position %d.', $currentRecordType, $pos));
                    break;
            }
        }

        return $writer->flush(true);
    }

    protected function readMultiByteInt31(&$content, &$pos)
    {
        $start = $pos;
        $value = 0;
        $last = 0x80;
        for ($i = 0; $i < 4 && ($last & 0x80); $i++) {
            $last = $this->readByte($content, $pos);
            $value += ($last & 0x7F) << ($i * 7);
        }
        if ($i == 4 && $last & 0x80) {
            $last = $this->readByte($content, $pos);
            if (($last & 0x7) !== $last) {
                throw new DecodingException(sprintf('Invalid MultiByteInt31 at position %d.', $start));
            }
            $value += ($last & 0x7) << 28;
        }

        return $value;
    }

    protected function readDictionaryString(&$content, &$pos)
    {
        $index = $this->readMultiByteInt31($content, $pos);

        return $this->getDictionaryString($index);
    }

    protected function readString(&$content, &$pos)
    {
        $recordLength = $this->readMultiByteInt31($content, $pos);

        $record = $this->readBytes($content, $pos, $recordLength);

        return $record;
    }

    protected function readTextRecord(&$content, &$pos)
    {
        $recordType = $this->readByte($content, $pos);

        return $this->readTextRecordInner($content, $pos, $recordType);
    }

    protected function readTextRecordInner(&$content, &$pos, $recordType)
    {
        switch ($recordType) {
            case Constants::RECORD_TYPE_ZERO_TEXT:
            case Constants::RECORD_TYPE_ZERO_TEXT_WITH_END_ELEMENT:
                return '0';
                break;
            case Constants::RECORD_TYPE_ONE_TEXT:
            case Constants::RECORD_TYPE_ONE_TEXT_WITH_END_ELEMENT:
                return '1';
                break;
            case Constants::RECORD_TYPE_FALSE_TEXT:
            case Constants::RECORD_TYPE_FALSE_TEXT_WITH_END_ELEMENT:
                return 'false';
                break;
            case Constants::RECORD_TYPE_TRUE_TEXT:
            case Constants::RECORD_TYPE_TRUE_TEXT_WITH_END_ELEMENT:
                return 'true';
                break;
            case Constants::RECORD_TYPE_INT8_TEXT:
            case Constants::RECORD_TYPE_INT8_TEXT_WITH_END_ELEMENT:
                return (string) $this->readInt8($content, $pos);
                break;
            case Constants::RECORD_TYPE_INT16_TEXT:
            case Constants::RECORD_TYPE_INT16_TEXT_WITH_END_ELEMENT:
                return (string) $this->readInt16LE($content, $pos);
                break;
            case Constants::RECORD_TYPE_INT32_TEXT:
            case Constants::RECORD_TYPE_INT32_TEXT_WITH_END_ELEMENT:
                return (string) $this->readInt32LE($content, $pos);
                break;
            case Constants::RECORD_TYPE_INT64_TEXT:
            case Constants::RECORD_TYPE_INT64_TEXT_WITH_END_ELEMENT:

                if (!function_exists('gmp_init')) {
                    throw new DecodingException('Int64 requires GMP extension');
                }

                $value = $this->readUInt64LE($content, $pos);
                if (gmp_cmp($value, gmp_pow(2, 63)) >= 0) {
                    $value = gmp_sub($value, gmp_pow(2, 64));
                }

                return (string) gmp_strval($value, 10);
                break;
            case Constants::RECORD_TYPE_FLOAT_TEXT:
            case Constants::RECORD_TYPE_FLOAT_TEXT_WITH_END_ELEMENT:
                $record = unpack('g', $this->readBytes($content, $pos, 4));

                return (string) $record[1];
                break;
            case Constants::RECORD_TYPE_DOUBLE_TEXT:
            case Constants::RECORD_TYPE_DOUBLE_TEXT_WITH_END_ELEMENT:
                $record = unpack('e', $this->readBytes($content, $pos, 8));

                return (string) $record[1];
                break;
            case Constants::RECORD_TYPE_DECIMAL_TEXT:
            case Constants::RECORD_TYPE_DECIMAL_TEXT_WITH_END_ELEMENT:

                if (!function_exists('gmp_init')) {
                    throw new DecodingException('Decimal requires GMP extension');
                }

                $this->readBytes($content, $pos, 2); // First 2 bytes reserved

                $scale = $this->readByte($content, $pos);

                $sign = $this->readByte($content, $pos);

                list(, $hi32Hex) = unpack('H*', strrev($this->readBytes($content, $pos, 4)));
                $hi32 = gmp_init($hi32Hex, 16);

                list(, $lo64Hex) = unpack('H*', strrev($this->readBytes($content, $pos, 8)));
                $lo64 = gmp_init($lo64Hex, 16);

                $value = gmp_add(gmp_mul($hi32, gmp_pow(2, 64)), $lo64);

                $record = gmp_strval($value, 10);

                if ($scale > 0) {
                    if ($scale > strlen($record)) {
                        $record = str_repeat('0', $scale - strlen($record)).$record;
                    }

                    $record = substr($record, 0, strlen($record) - $scale).'.'.substr($record, $scale * -1);

                    $record = trim($record, '0');
                    if ($record === '' || $record[0] == '.') {
                        $record = '0'.$record;
                    }
                }

                if ($sign == 0x80) {
                    $record = '-'.$record;
                }

                return $record;

                break;
            case Constants::RECORD_TYPE_DATETIME_TEXT:
            case Constants::RECORD_TYPE_DATETIME_TEXT_WITH_END_ELEMENT:

                if (!function_exists('gmp_init')) {
                    throw new DecodingException('Datetime requires GMP extension');
                }

                $binary = '';
                for ($i = 0; $i < 8; $i++) {
                    list(, $byteint) = unpack('C*', $this->readBytes($content, $pos, 1));
                    $binary = sprintf('%08b', $byteint).$binary;
                }

                $value = gmp_init(substr($binary, 2, 62), 2);

                // Only calc with seconds, since PHP datetime doesn't support fractions
                $secsRemaining = gmp_div($value, '10000000');

                // Compensate for using unix timestamp
                $epochSecsRemaining = gmp_sub($secsRemaining, '62135596800');

                // Load PHP datetime with seconds remaining
                $datetime = new DateTime('@'.gmp_strval($epochSecsRemaining, 10), new DateTimeZone('UTC'));
                $date = $datetime->format('Y-m-d');
                $time = $datetime->format('H:i:s');

                // Get fractions
                $fraction = substr(gmp_strval($value, 10), -7);

                // Join different time elements
                if ($fraction !== '0000000') {
                    $record = "{$date}T{$time}.{$fraction}";
                } elseif ($time !== '00:00:00') {
                    $record = "{$date}T{$time}";
                } else {
                    $record = "{$date}";
                }

                // Add timezone info
                $tz = gmp_intval(gmp_init(substr($binary, 0, 2), 2));
                if ($tz == 2) {
                    // TODO: local time handling
                } elseif ($tz == 1) {
                    $record .= 'Z';
                }

                return $record;
                break;
            case Constants::RECORD_TYPE_CHARS8_TEXT:
            case Constants::RECORD_TYPE_CHARS8_TEXT_WITH_END_ELEMENT:
                $recordLength = $this->readByte($content, $pos);

                $record = $this->readBytes($content, $pos, $recordLength);

                return $record;
                break;
            case Constants::RECORD_TYPE_CHARS16_TEXT:
            case Constants::RECORD_TYPE_CHARS16_TEXT_WITH_END_ELEMENT:
                $recordLength = $this->readUInt16LE($content, $pos);

                $record = $this->readBytes($content, $pos, $recordLength);

                return $record;
                break;
            case Constants::RECORD_TYPE_CHARS32_TEXT:
            case Constants::RECORD_TYPE_CHARS32_TEXT_WITH_END_ELEMENT:
                $recordLength = $this->readUInt32LE($content, $pos);

                $record = $this->readBytes($content, $pos, $recordLength);

                return $record;
                break;
            case Constants::RECORD_TYPE_BYTES8_TEXT:
            case Constants::RECORD_TYPE_BYTES8_TEXT_WITH_END_ELEMENT:
                $recordLength = $this->readByte($content, $pos);

                $record = $this->readBytes($content, $pos, $recordLength);

                return base64_encode($record);
                break;
            case Constants::RECORD_TYPE_BYTES16_TEXT:
            case Constants::RECORD_TYPE_BYTES16_TEXT_WITH_END_ELEMENT:
                $recordLength = $this->readUInt16LE($content, $pos);

                $record = $this->readBytes($content, $pos, $recordLength);

                return base64_encode($record);
                break;
            case Constants::RECORD_TYPE_BYTES32_TEXT:
            case Constants::RECORD_TYPE_BYTES32_TEXT_WITH_END_ELEMENT:
                $recordLength = $this->readUInt32LE($content, $pos);

                $record = $this->readBytes($content, $pos, $recordLength);

                return base64_encode($record);
                break;
            case Constants::RECORD_TYPE_START_LIST_TEXT:

                $record = '';
                while ($this->peekByte($content, $pos) != Constants::RECORD_TYPE_END_LIST_TEXT) {
                    if ($record !== '') {
                        $record .= ' ';
                    }
                    $record .= $this->readTextRecord($content, $pos);
                }

                $pos += 1; // skip 1 for end list

                return $record;
                break;
            case Constants::RECORD_TYPE_EMPTY_TEXT:
            case Constants::RECORD_TYPE_EMPTY_TEXT_WITH_END_ELEMENT:
                return '';
                break;
            case Constants::RECORD_TYPE_DICTIONARY_TEXT:
            case Constants::RECORD_TYPE_DICTIONARY_TEXT_WITH_END_ELEMENT:
                return $this->readDictionaryString($content, $pos);
                break;
            case Constants::RECORD_TYPE_UNIQUEID_TEXT:
            case Constants::RECORD_TYPE_UNIQUEID_TEXT_WITH_END_ELEMENT:
            case Constants::RECORD_TYPE_UUID_TEXT:
            case Constants::RECORD_TYPE_UUID_TEXT_WITH_END_ELEMENT:

                list(, $data1) = unpack('H*', strrev($this->readBytes($content, $pos, 4)));

                list(, $data2) = unpack('H*', strrev($this->readBytes($content, $pos, 2)));

                list(, $data3) = unpack('H*', strrev($this->readBytes($content, $pos, 2)));

                list(, $data4) = unpack('H*', $this->readBytes($content, $pos, 2));

                list(, $data5) = unpack('H*', $this->readBytes($content, $pos, 6));

                $record = "{$data1}-{$data2}-{$data3}-{$data4}-{$data5}";

                if ($recordType == Constants::RECORD_TYPE_UNIQUEID_TEXT ||
                    $recordType == Constants::RECORD_TYPE_UNIQUEID_TEXT_WITH_END_ELEMENT) {
                    $record = 'urn:uuid:'.$record;
                }

                return $record;
                break;
            case Constants::RECORD_TYPE_TIMESPAN_TEXT:
            case Constants::RECORD_TYPE_TIMESPAN_TEXT_WITH_END_ELEMENT:
                if (!function_exists('gmp_init')) {
                    throw new DecodingException('Timespan requires GMP extension');
                }

                $value = '';
                for ($i = 0; $i < 8; $i++) {
                    list(, $byte) = unpack('C*', $this->readBytes($content, $pos, 1));
                    $value = sprintf('%08b', $byte).$value;
                }

                $value = gmp_init($value, 2);

                $minus = false;
                if (gmp_testbit($value, 63)) {
                    $minus = true;
                    $mask = gmp_init(str_repeat('1', 64), '2');
                    $value = gmp_and(gmp_com($value), $mask);
                    $value = gmp_add($value, 1);
                }

                $remaining = gmp_abs($value);
                list($days, $remaining) = gmp_div_qr($remaining, gmp_init('864000000000'));
                list($hours, $remaining) = gmp_div_qr($remaining, gmp_init('36000000000'));
                list($mins, $remaining) = gmp_div_qr($remaining, gmp_init('600000000'));
                list($secs, $remaining) = gmp_div_qr($remaining, gmp_init('10000000'));
                $fracs = $remaining;

                $days = gmp_intval($days);
                $hours = gmp_intval($hours);
                $mins = gmp_intval($mins);
                $secs = gmp_intval($secs);
                $fracs = gmp_intval($fracs);

                $record = ($minus ? '-P' : 'P');
                if ($days > 0) {
                    $record .= $days.'D';
                }
                if ($hours > 0 || $mins > 0 || $secs > 0 || $fracs > 0) {
                    $record .= 'T';
                    if ($hours > 0) {
                        $record .= $hours.'H';
                    }
                    if ($mins > 0) {
                        $record .= $mins.'M';
                    }
                    if ($secs > 0 || $fracs > 0) {
                        $record .= $secs;
                        if ($fracs > 0) {
                            $record .= '.'.str_pad((string) $fracs, 7, '0', STR_PAD_LEFT);
                        }
                        $record .= 'S';
                    }
                }

                return $record;
                break;
            case Constants::RECORD_TYPE_UINT64_TEXT:
            case Constants::RECORD_TYPE_UINT64_TEXT_WITH_END_ELEMENT:

                if (!function_exists('gmp_init')) {
                    throw new DecodingException('Uint64 requires GMP extension');
                }

                return (string) gmp_strval($this->readUInt64LE($content, $pos), 10);
                break;
            case Constants::RECORD_TYPE_BOOL_TEXT:
            case Constants::RECORD_TYPE_BOOL_TEXT_WITH_END_ELEMENT:
                $record = $this->readByte($content, $pos);
                switch ($record) {
                    case 0:
                        return 'false';
                        break;
                    case 1:
                        return 'true';
                        break;
                }

                throw new DecodingException(sprintf('Unknown boolean value 0x%02X at position %d.', $record, $pos));
                break;
            case Constants::RECORD_TYPE_UNICODECHARS8_TEXT:
            case Constants::RECORD_TYPE_UNICODECHARS8_TEXT_WITH_END_ELEMENT:
                $recordLength = $this->readByte($content, $pos);

                $record = $this->readBytes($content, $pos, $recordLength);

                return mb_convert_encoding($record, 'UTF-8', 'UTF-16');
                break;
            case Constants::RECORD_TYPE_UNICODECHARS16_TEXT:
            case Constants::RECORD_TYPE_UNICODECHARS16_TEXT_WITH_END_ELEMENT:
                $recordLength = $this->readUInt16LE($content, $pos);

                $record = $this->readBytes($content, $pos, $recordLength);

                return mb_convert_encoding($record, 'UTF-8', 'UTF-16');
                break;
            case Constants::RECORD_TYPE_UNICODECHARS32_TEXT:
            case Constants::RECORD_TYPE_UNICODECHARS32_TEXT_WITH_END_ELEMENT:
                $recordLength = $this->readUInt32LE($content, $pos);

                $record = $this->readBytes($content, $pos, $recordLength);

                return mb_convert_encoding($record, 'UTF-8', 'UTF-16');
                break;
            case Constants::RECORD_TYPE_QNAMEDICTIONARY_TEXT:
            case Constants::RECORD_TYPE_QNAMEDICTIONARY_TEXT_WITH_END_ELEMENT:
                $prefix = chr(97 + $this->readByte($content, $pos));

                $name = $this->readDictionaryString($content, $pos);

                return $prefix.':'.$name;
                break;
            default:
                throw new DecodingException(sprintf('Unknown record type 0x%02X at position %d.', $recordType, $pos));
                break;
        }
    }

    protected function peekByte(&$content, $pos)
    {
        $this->assertAvailable($content, $pos, 1);

        return ord($content[$pos]);
    }

    protected function readByte(&$content, &$pos)
    {
        $byte = $this->peekByte($content, $pos);
        $pos += 1;

        return $byte;
    }

    protected function readBytes(&$content, &$pos, $length)
    {
        $this->assertAvailable($content, $pos, $length);

        $bytes = substr($content, $pos, $length);
        $pos += $length;

        return $bytes;
    }

    protected function readInt8(&$content, &$pos)
    {
        $value = $this->readByte($content, $pos);

        return $value >= 0x80 ? $value - 0x100 : $value;
    }

    protected function readUInt16LE(&$content, &$pos)
    {
        $record = unpack('v', $this->readBytes($content, $pos, 2));

        return $record[1];
    }

    protected function readInt16LE(&$content, &$pos)
    {
        $value = $this->readUInt16LE($content, $pos);

        return $value >= 0x8000 ? $value - 0x10000 : $value;
    }

    protected function readUInt32LE(&$content, &$pos)
    {
        $record = unpack('V', $this->readBytes($content, $pos, 4));

        return $record[1];
    }

    protected function readInt32LE(&$content, &$pos)
    {
        $value = $this->readUInt32LE($content, $pos);

        return $value >= 0x80000000 ? $value - 0x100000000 : $value;
    }

    protected function readUInt64LE(&$content, &$pos)
    {
        list(, $hex) = unpack('H*', strrev($this->readBytes($content, $pos, 8)));

        return gmp_init($hex, 16);
    }

    protected function assertAvailable(&$content, $pos, $length)
    {
        if ($length < 0 || $pos < 0 || strlen($content) - $pos < $length) {
            throw new DecodingException(sprintf('Unexpected end of content at position %d.', $pos));
        }
    }

    protected function getDictionaryString($index)
    {
        if (is_string($this->options['dictionary'])) {
            return sprintf($this->options['dictionary'], $index);
        }

        if (!isset($this->options['dictionary'][$index])) {
            throw new DecodingException(sprintf('Invalid DictionaryString 0x%X.', $index));
        }

        return $this->options['dictionary'][$index];
    }
}
