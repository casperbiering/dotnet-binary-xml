<?php

/*
 * Not yet implemented:
 * int64
 * decimal
 * datetime
 * uniqueid
 * timespan
 * uuid
 * uint64
 */

/**
 * Main exeception for phpBinaryXml
 *
 * @author Casper Biering
 */
class phpBinaryXmlException extends Exception {}

/**
 * Main class for phpBinaryXml
 *
 * @author Casper Biering
 */
class phpBinaryXml {
    const RECORD_TYPE_END_ELEMENT = 0x01;
    const RECORD_TYPE_COMMENT = 0x02;
    const RECORD_TYPE_ARRAY = 0x03;
    const RECORD_TYPE_SHORT_ATTRIBUTE = 0x04;
    const RECORD_TYPE_ATTRIBUTE = 0x05;
    const RECORD_TYPE_SHORT_DICTIONARY_ATTRIBUTE = 0x06;
    const RECORD_TYPE_DICTIONARY_ATTRIBUTE = 0x07;
    const RECORD_TYPE_SHORT_XMLNS_ATTRIBUTE = 0x08;
    const RECORD_TYPE_XMLNS_ATTRIBUTE = 0x09;
    const RECORD_TYPE_SHORT_DICTIONARY_XMLNS_ATTRIBUTE = 0x0A;
    const RECORD_TYPE_DICTIONARY_XMLNS_ATTRIBUTE = 0x0B;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_A = 0x0C;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_B = 0x0D;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_C = 0x0E;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_D = 0x0F;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_E = 0x10;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_F = 0x11;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_G = 0x12;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_H = 0x13;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_I = 0x14;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_J = 0x15;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_K = 0x16;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_L = 0x17;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_M = 0x18;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_N = 0x19;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_O = 0x1A;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_P = 0x1B;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_Q = 0x1C;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_R = 0x1D;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_S = 0x1E;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_T = 0x1F;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_U = 0x20;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_V = 0x21;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_W = 0x22;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_X = 0x23;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_Y = 0x24;
    const RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_Z = 0x25;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_A = 0x26;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_B = 0x27;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_C = 0x28;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_D = 0x29;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_E = 0x2A;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_F = 0x2B;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_G = 0x2C;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_H = 0x2D;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_I = 0x2E;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_J = 0x2F;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_K = 0x30;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_L = 0x31;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_M = 0x32;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_N = 0x33;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_O = 0x34;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_P = 0x35;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_Q = 0x36;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_R = 0x37;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_S = 0x38;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_T = 0x39;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_U = 0x3A;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_V = 0x3B;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_W = 0x3C;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_X = 0x3D;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_Y = 0x3E;
    const RECORD_TYPE_PREFIX_ATTRIBUTE_Z = 0x3F;
    const RECORD_TYPE_SHORT_ELEMENT = 0x40;
    const RECORD_TYPE_ELEMENT = 0x41;
    const RECORD_TYPE_SHORT_DICTIONARY_ELEMENT = 0x42;
    const RECORD_TYPE_DICTIONARY_ELEMENT = 0x43;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_A = 0x44;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_B = 0x45;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_C = 0x46;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_D = 0x47;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_E = 0x48;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_F = 0x49;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_G = 0x4A;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_H = 0x4B;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_I = 0x4C;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_J = 0x4D;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_K = 0x4E;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_L = 0x4F;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_M = 0x50;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_N = 0x51;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_O = 0x52;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_P = 0x53;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_Q = 0x54;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_R = 0x55;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_S = 0x56;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_T = 0x57;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_U = 0x58;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_V = 0x59;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_W = 0x5A;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_X = 0x5B;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_Y = 0x5C;
    const RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_Z = 0x5D;
    const RECORD_TYPE_PREFIX_ELEMENT_A = 0x5E;
    const RECORD_TYPE_PREFIX_ELEMENT_B = 0x5F;
    const RECORD_TYPE_PREFIX_ELEMENT_C = 0x60;
    const RECORD_TYPE_PREFIX_ELEMENT_D = 0x61;
    const RECORD_TYPE_PREFIX_ELEMENT_E = 0x62;
    const RECORD_TYPE_PREFIX_ELEMENT_F = 0x63;
    const RECORD_TYPE_PREFIX_ELEMENT_G = 0x64;
    const RECORD_TYPE_PREFIX_ELEMENT_H = 0x65;
    const RECORD_TYPE_PREFIX_ELEMENT_I = 0x66;
    const RECORD_TYPE_PREFIX_ELEMENT_J = 0x67;
    const RECORD_TYPE_PREFIX_ELEMENT_K = 0x68;
    const RECORD_TYPE_PREFIX_ELEMENT_L = 0x69;
    const RECORD_TYPE_PREFIX_ELEMENT_M = 0x6A;
    const RECORD_TYPE_PREFIX_ELEMENT_N = 0x6B;
    const RECORD_TYPE_PREFIX_ELEMENT_O = 0x6C;
    const RECORD_TYPE_PREFIX_ELEMENT_P = 0x6D;
    const RECORD_TYPE_PREFIX_ELEMENT_Q = 0x6E;
    const RECORD_TYPE_PREFIX_ELEMENT_R = 0x6F;
    const RECORD_TYPE_PREFIX_ELEMENT_S = 0x70;
    const RECORD_TYPE_PREFIX_ELEMENT_T = 0x71;
    const RECORD_TYPE_PREFIX_ELEMENT_U = 0x72;
    const RECORD_TYPE_PREFIX_ELEMENT_V = 0x73;
    const RECORD_TYPE_PREFIX_ELEMENT_W = 0x74;
    const RECORD_TYPE_PREFIX_ELEMENT_X = 0x75;
    const RECORD_TYPE_PREFIX_ELEMENT_Y = 0x76;
    const RECORD_TYPE_PREFIX_ELEMENT_Z = 0x77;
    const RECORD_TYPE_ZERO_TEXT = 0x80;
    const RECORD_TYPE_ZERO_TEXT_WITH_END_ELEMENT = 0x81;
    const RECORD_TYPE_ONE_TEXT = 0x82;
    const RECORD_TYPE_ONE_TEXT_WITH_END_ELEMENT = 0x83;
    const RECORD_TYPE_FALSE_TEXT = 0x84;
    const RECORD_TYPE_FALSE_TEXT_WITH_END_ELEMENT = 0x85;
    const RECORD_TYPE_TRUE_TEXT = 0x86;
    const RECORD_TYPE_TRUE_TEXT_WITH_END_ELEMENT = 0x87;
    const RECORD_TYPE_INT8_TEXT = 0x88;
    const RECORD_TYPE_INT8_TEXT_WITH_END_ELEMENT = 0x89;
    const RECORD_TYPE_INT16_TEXT = 0x8A;
    const RECORD_TYPE_INT16_TEXT_WITH_END_ELEMENT = 0x8B;
    const RECORD_TYPE_INT32_TEXT = 0x8C;
    const RECORD_TYPE_INT32_TEXT_WITH_END_ELEMENT = 0x8D;
    const RECORD_TYPE_INT64_TEXT = 0x8E;
    const RECORD_TYPE_INT64_TEXT_WITH_END_ELEMENT = 0x9F;
    const RECORD_TYPE_FLOAT_TEXT = 0x90;
    const RECORD_TYPE_FLOAT_TEXT_WITH_END_ELEMENT = 0x91;
    const RECORD_TYPE_DOUBLE_TEXT = 0x92;
    const RECORD_TYPE_DOUBLE_TEXT_WITH_END_ELEMENT = 0x93;
    const RECORD_TYPE_DECIMAL_TEXT = 0x94;
    const RECORD_TYPE_DECIMAL_TEXT_WITH_END_ELEMENT = 0x95;
    const RECORD_TYPE_DATETIME_TEXT = 0x96;
    const RECORD_TYPE_DATETIME_TEXT_WITH_END_ELEMENT = 0x97;
    const RECORD_TYPE_CHARS8_TEXT = 0x98;
    const RECORD_TYPE_CHARS8_TEXT_WITH_END_ELEMENT = 0x99;
    const RECORD_TYPE_CHARS16_TEXT = 0x9A;
    const RECORD_TYPE_CHARS16_TEXT_WITH_END_ELEMENT = 0x9B;
    const RECORD_TYPE_CHARS32_TEXT = 0x9C;
    const RECORD_TYPE_CHARS32_TEXT_WITH_END_ELEMENT = 0x9D;
    const RECORD_TYPE_BYTES8_TEXT = 0x9E;
    const RECORD_TYPE_BYTES8_TEXT_WITH_END_ELEMENT = 0x9F;
    const RECORD_TYPE_BYTES16_TEXT = 0xA0;
    const RECORD_TYPE_BYTES16_TEXT_WITH_END_ELEMENT = 0xA1;
    const RECORD_TYPE_BYTES32_TEXT = 0xA2;
    const RECORD_TYPE_BYTES32_TEXT_WITH_END_ELEMENT = 0xA3;
    const RECORD_TYPE_START_LIST_TEXT = 0xA4;
    const RECORD_TYPE_END_LIST_TEXT = 0xA6;
    const RECORD_TYPE_EMPTY_TEXT = 0xA8;
    const RECORD_TYPE_EMPTY_TEXT_WITH_END_ELEMENT = 0xA9;
    const RECORD_TYPE_DICTIONARY_TEXT = 0xAA;
    const RECORD_TYPE_DICTIONARY_TEXT_WITH_END_ELEMENT = 0xAB;
    const RECORD_TYPE_UNIQUEID_TEXT = 0xAC;
    const RECORD_TYPE_UNIQUEID_TEXT_WITH_END_ELEMENT = 0xAD;
    const RECORD_TYPE_TIMESPAN_TEXT = 0xAE;
    const RECORD_TYPE_TIMESPAN_TEXT_WITH_END_ELEMENT = 0xAF;
    const RECORD_TYPE_UUID_TEXT = 0xB0;
    const RECORD_TYPE_UUID_TEXT_WITH_END_ELEMENT = 0xB1;
    const RECORD_TYPE_UINT64_TEXT = 0xB2;
    const RECORD_TYPE_UINT64_TEXT_WITH_END_ELEMENT = 0xB3;
    const RECORD_TYPE_BOOL_TEXT = 0xB4;
    const RECORD_TYPE_BOOL_TEXT_WITH_END_ELEMENT = 0xB5;
    const RECORD_TYPE_UNICODECHARS8_TEXT = 0xB6;
    const RECORD_TYPE_UNICODECHARS8_TEXT_WITH_END_ELEMENT = 0xB7;
    const RECORD_TYPE_UNICODECHARS16_TEXT = 0xB8;
    const RECORD_TYPE_UNICODECHARS16_TEXT_WITH_END_ELEMENT = 0xB9;
    const RECORD_TYPE_UNICODECHARS32_TEXT = 0xBA;
    const RECORD_TYPE_UNICODECHARS32_TEXT_WITH_END_ELEMENT = 0xBB;
    const RECORD_TYPE_QNAMEDICTIONARY_TEXT = 0xBC;
    const RECORD_TYPE_QNAMEDICTIONARY_TEXT_WITH_END_ELEMENT = 0xBD;
    
    static function decode($content) {
        
        $pos = 0;
        $content_length = strlen($content);
        
        $xmlwriter = new XMLWriter();
        $xmlwriter->openMemory();
        
        while($pos < $content_length) {
            switch(ord($content{$pos})) {
                case self::RECORD_TYPE_END_ELEMENT:
                    $pos += 1;
                    
                    $xmlwriter->fullEndElement();
                break;
                case self::RECORD_TYPE_COMMENT:
                    $pos += 1;
                    
                    $comment = self::getString($content, $pos);
                    $xmlwriter->writeComment($comment);
                    
                break;
                case self::RECORD_TYPE_ARRAY:
                    $pos += 1;
                    
                    // Element
                    $pos += 1; // expect it to be 0x40
                    $element = self::getString($content, $pos);
                    $pos += 1; // expect it to be 0x01
                    
                    // Record type
                    $record_type = ord($content{$pos});
                    $pos += 1;
                    
                    // Length
                    $length = ord($content{$pos});
                    $pos += 1; 
                    
                    // Entries
                    for($entry = 0; $entry < $length; $entry++) {
                        $value = self::getTextRecordInner($content, $pos, $record_type);
                        $xmlwriter->writeElement($element, $value);
                    }
                    
                break;
                case self::RECORD_TYPE_SHORT_ATTRIBUTE:
                    $pos += 1;
                    
                    $name = self::getString($content, $pos);
                    $value = self::getTextRecord($content, $pos);
                    
                    $xmlwriter->writeAttribute($name, $value);
                    
                break;
                case self::RECORD_TYPE_ATTRIBUTE:
                    $pos += 1;
                    
                    $prefix = self::getString($content, $pos);
                    $name = self::getString($content, $pos);
                    $value = self::getTextRecord($content, $pos);
                    
                    $xmlwriter->writeAttribute($prefix.':'.$name, $value);
                    
                break;
                case self::RECORD_TYPE_SHORT_DICTIONARY_ATTRIBUTE:
                    $pos += 1;
                    
                    $name = self::getDictionaryString($content, $pos);
                    $value = self::getTextRecord($content, $pos);
                    
                    $xmlwriter->writeAttribute('str'.$name, $value);
                    
                break;
                case self::RECORD_TYPE_DICTIONARY_ATTRIBUTE:
                    $pos += 1;
                    
                    $prefix = self::getString($content, $pos);
                    $name = self::getDictionaryString($content, $pos);
                    $value = self::getTextRecord($content, $pos);
                    
                    $xmlwriter->writeAttribute($prefix.':str'.$name, $value);
                    
                break;
                case self::RECORD_TYPE_SHORT_XMLNS_ATTRIBUTE:
                    $pos += 1;
                    
                    $value = self::getString($content, $pos);
                    
                    $xmlwriter->writeAttribute('xmlns', $value);
                    
                    break;
                case self::RECORD_TYPE_XMLNS_ATTRIBUTE:
                    $pos += 1;
                    
                    $name = self::getString($content, $pos);
                    $value = self::getString($content, $pos);
                    
                    $xmlwriter->writeAttribute('xmlns:'.$name, $value);
                    
                    break;
                case self::RECORD_TYPE_SHORT_DICTIONARY_XMLNS_ATTRIBUTE:
                    $pos += 1;
                    
                    $value = self::getDictionaryString($content, $pos);
                    
                    $xmlwriter->writeAttribute('xmlns', $value);
                    
                break;
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_A:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_B:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_C:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_D:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_E:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_F:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_G:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_H:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_I:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_J:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_K:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_L:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_M:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_N:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_O:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_P:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_R:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_S:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_T:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_U:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_V:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_W:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_X:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_Y:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ATTRIBUTE_Z:
                    $char = chr(85+ord($content{$pos}));
                    $pos += 1;
                    
                    $name = self::getDictionaryString($content, $pos);
                    $value = self::getTextRecord($content, $pos);
                    
                    $xmlwriter->writeAttribute($char.':str'.$name, $value);
                break;
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_A:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_B:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_C:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_D:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_E:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_F:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_G:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_H:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_I:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_J:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_K:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_L:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_M:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_N:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_O:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_P:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_R:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_S:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_T:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_U:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_V:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_W:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_X:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_Y:
                case self::RECORD_TYPE_PREFIX_ATTRIBUTE_Z:
                    $char = chr(59+ord($content{$pos}));
                    $pos += 1;
                    
                    $name = self::getString($content, $pos);
                    $value = self::getTextRecord($content, $pos);
                    
                    $xmlwriter->writeAttribute($char.':'.$name, $value);
                break;
                case self::RECORD_TYPE_SHORT_ELEMENT:
                    $pos += 1;
                    
                    $name = self::getString($content, $pos);
                    $xmlwriter->startElement($name);
                break;
                case self::RECORD_TYPE_ELEMENT:
                    $pos += 1;
                    
                    $prefix = self::getString($content, $pos);
                    $name = self::getString($content, $pos);
                    $xmlwriter->startElement($prefix.':'.$name);
                break;
                case self::RECORD_TYPE_SHORT_DICTIONARY_ELEMENT:
                    $pos += 1;
                    
                    $name = self::getDictionaryString($content, $pos);
                    $xmlwriter->startElement('str'.$name);
                break;
                case self::RECORD_TYPE_DICTIONARY_ELEMENT:
                    $pos += 1;
                    
                    $prefix = self::getString($content, $pos);
                    $name = self::getDictionaryString($content, $pos);
                    $xmlwriter->startElement($prefix.':str'.$name);
                break;
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_A:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_B:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_C:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_D:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_E:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_F:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_G:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_H:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_I:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_J:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_K:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_L:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_M:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_N:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_O:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_P:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_R:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_S:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_T:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_U:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_V:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_W:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_X:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_Y:
                case self::RECORD_TYPE_PREFIX_DICTIONARY_ELEMENT_Z:
                    $char = chr(29+ord($content{$pos}));
                    $pos += 1;
                    
                    $name = self::getDictionaryString($content, $pos);
                    
                    $xmlwriter->startElement($char.':str'.$name);
                break;
                case self::RECORD_TYPE_PREFIX_ELEMENT_A:
                case self::RECORD_TYPE_PREFIX_ELEMENT_B:
                case self::RECORD_TYPE_PREFIX_ELEMENT_C:
                case self::RECORD_TYPE_PREFIX_ELEMENT_D:
                case self::RECORD_TYPE_PREFIX_ELEMENT_E:
                case self::RECORD_TYPE_PREFIX_ELEMENT_F:
                case self::RECORD_TYPE_PREFIX_ELEMENT_G:
                case self::RECORD_TYPE_PREFIX_ELEMENT_H:
                case self::RECORD_TYPE_PREFIX_ELEMENT_I:
                case self::RECORD_TYPE_PREFIX_ELEMENT_J:
                case self::RECORD_TYPE_PREFIX_ELEMENT_K:
                case self::RECORD_TYPE_PREFIX_ELEMENT_L:
                case self::RECORD_TYPE_PREFIX_ELEMENT_M:
                case self::RECORD_TYPE_PREFIX_ELEMENT_N:
                case self::RECORD_TYPE_PREFIX_ELEMENT_O:
                case self::RECORD_TYPE_PREFIX_ELEMENT_P:
                case self::RECORD_TYPE_PREFIX_ELEMENT_R:
                case self::RECORD_TYPE_PREFIX_ELEMENT_S:
                case self::RECORD_TYPE_PREFIX_ELEMENT_T:
                case self::RECORD_TYPE_PREFIX_ELEMENT_U:
                case self::RECORD_TYPE_PREFIX_ELEMENT_V:
                case self::RECORD_TYPE_PREFIX_ELEMENT_W:
                case self::RECORD_TYPE_PREFIX_ELEMENT_X:
                case self::RECORD_TYPE_PREFIX_ELEMENT_Y:
                case self::RECORD_TYPE_PREFIX_ELEMENT_Z:
                    $char = chr(3+ord($content{$pos}));
                    $pos += 1;
                    
                    $name = self::getString($content, $pos);
                    
                    $xmlwriter->startElement($char.':'.$name);
                break;
                case self::RECORD_TYPE_ZERO_TEXT:
                case self::RECORD_TYPE_ONE_TEXT:
                case self::RECORD_TYPE_FALSE_TEXT:
                case self::RECORD_TYPE_TRUE_TEXT:
                case self::RECORD_TYPE_INT8_TEXT:
                case self::RECORD_TYPE_INT16_TEXT:
                case self::RECORD_TYPE_INT32_TEXT:
                case self::RECORD_TYPE_FLOAT_TEXT:
                case self::RECORD_TYPE_DOUBLE_TEXT:
                case self::RECORD_TYPE_DECIMAL_TEXT:
                case self::RECORD_TYPE_DATETIME_TEXT:
                case self::RECORD_TYPE_CHARS8_TEXT:
                case self::RECORD_TYPE_CHARS16_TEXT:
                case self::RECORD_TYPE_CHARS32_TEXT:
                case self::RECORD_TYPE_BYTES8_TEXT:
                case self::RECORD_TYPE_BYTES16_TEXT:
                case self::RECORD_TYPE_BYTES32_TEXT:
                case self::RECORD_TYPE_EMPTY_TEXT:
                case self::RECORD_TYPE_DICTIONARY_TEXT:
                case self::RECORD_TYPE_BOOL_TEXT:
                case self::RECORD_TYPE_UNICODECHARS8_TEXT:
                case self::RECORD_TYPE_UNICODECHARS16_TEXT:
                case self::RECORD_TYPE_UNICODECHARS32_TEXT:
                case self::RECORD_TYPE_QNAMEDICTIONARY_TEXT:
                    $record = self::getTextRecord($content, $pos);
                    
                    $xmlwriter->writeRaw($record);
                break;
                case self::RECORD_TYPE_ZERO_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_ONE_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_FALSE_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_TRUE_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_INT8_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_INT16_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_INT32_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_FLOAT_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_DOUBLE_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_DECIMAL_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_DATETIME_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_CHARS8_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_CHARS16_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_CHARS32_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_BYTES8_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_BYTES16_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_BYTES32_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_EMPTY_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_DICTIONARY_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_BOOL_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_UNICODECHARS8_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_UNICODECHARS16_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_UNICODECHARS32_TEXT_WITH_END_ELEMENT:
                case self::RECORD_TYPE_QNAMEDICTIONARY_TEXT_WITH_END_ELEMENT:
                    $record = self::getTextRecord($content, $pos);
                    
                    $xmlwriter->writeRaw($record);
                    $xmlwriter->fullEndElement();
                break;
                default:
                    throw new phpBinaryXmlException('Unknown element type <'.bin2hex($content{$pos}).'> on pos <'.$pos.'>');
                break;
            }
        }
        
        return $xmlwriter->flush();
    }
    
    static public function getDictionaryString(&$content, &$pos) {
        
        // Parsed as MultiByteInt31:
        // http://msdn.microsoft.com/en-us/library/cc219227(v=PROT.10)
        
        $part_a = ord($content{$pos});
        $value_a = substr(str_pad(decbin($part_a),8,"0",STR_PAD_LEFT), 1, 7);
        if($part_a <= 0x7F) {
            $pos += 1;
            return bindec($value_a);
        }
        
        $part_b = ord($content{$pos+1});
        $value_b = substr(str_pad(decbin($part_b),8,"0",STR_PAD_LEFT), 1, 7);
        if($part_b <= 0x7F) {
            $pos += 2;
            return bindec($value_b . $value_a);
        }
        
        $part_c = ord($content{$pos+2});
        $value_c = substr(str_pad(decbin($part_c),8,"0",STR_PAD_LEFT), 1, 7);
        if($part_c <= 0x7F) {
            $pos += 3;
            return bindec($value_c . $value_b . $value_a);
        }
        
        $part_d = ord($content{$pos+3});
        $value_d = substr(str_pad(decbin($part_d),8,"0",STR_PAD_LEFT), 1, 7);
        if($part_d <= 0x7F) {
            $pos += 4;
            return bindec($value_d . $value_c . $value_b . $value_a);
        }
        
        $part_e = ord($content{$pos+4});
        $value_e = substr(str_pad(decbin($part_e),8,"0",STR_PAD_LEFT), 1, 7);
        if($part_e <= 0x7F) {
            $pos += 5;
            return bindec($value_e . $value_d . $value_c . $value_b . $value_a);
        }
        
        throw new phpBinaryXmlException("Unallowed multibyte int");
    }
    
    static protected function getString(&$content, &$pos) {
        $record_length = ord($content{$pos});
        $pos += 1;
        
        $record = substr($content, $pos, $record_length);
        $pos += $record_length;
        
        return $record;
    }
    
    static protected function getTextRecord(&$content, &$pos) {
        $record_type = ord($content{$pos});
        $pos += 1;
        return self::getTextRecordInner($content, $pos, $record_type);
    }
    
    static protected function getTextRecordInner(&$content, &$pos, $record_type) {
        switch($record_type) {
            case self::RECORD_TYPE_ZERO_TEXT:
            case self::RECORD_TYPE_ZERO_TEXT_WITH_END_ELEMENT:
                return '0';
            break;
            case self::RECORD_TYPE_ONE_TEXT:
            case self::RECORD_TYPE_ONE_TEXT_WITH_END_ELEMENT:
                return '1';
            break;
            case self::RECORD_TYPE_FALSE_TEXT:
            case self::RECORD_TYPE_FALSE_TEXT_WITH_END_ELEMENT:
                return 'false';
            break;
            case self::RECORD_TYPE_TRUE_TEXT:
            case self::RECORD_TYPE_TRUE_TEXT_WITH_END_ELEMENT:
                return 'true';
            break;
            case self::RECORD_TYPE_INT8_TEXT:
            case self::RECORD_TYPE_INT8_TEXT_WITH_END_ELEMENT:
                $record = unpack("c*", $content{$pos});
                $pos += 1;
                return (string) $record[1];
            break;
            case self::RECORD_TYPE_INT16_TEXT:
            case self::RECORD_TYPE_INT16_TEXT_WITH_END_ELEMENT:
                $record = unpack("s*", substr($content, $pos, 2));
                $pos += 2;
                return (string) $record[1];
            break;
            case self::RECORD_TYPE_INT32_TEXT:
            case self::RECORD_TYPE_INT32_TEXT_WITH_END_ELEMENT:
                $record = unpack("l*", substr($content, $pos, 4));
                $pos += 4;
                return (string) $record[1];
            break;
            case self::RECORD_TYPE_FLOAT_TEXT:
            case self::RECORD_TYPE_FLOAT_TEXT_WITH_END_ELEMENT:
                $record = unpack("f*", substr($content, $pos, 4));
                $pos += 4;
                return (string) $record[1];
            break;
            case self::RECORD_TYPE_DOUBLE_TEXT:
            case self::RECORD_TYPE_DOUBLE_TEXT_WITH_END_ELEMENT:
                $record = unpack("d*", substr($content, $pos, 8));
                $pos += 8;
                return (string) $record[1];
            break;
            case self::RECORD_TYPE_DECIMAL_TEXT:
            case self::RECORD_TYPE_DECIMAL_TEXT_WITH_END_ELEMENT:
                
                if(PHP_INT_SIZE < 8) throw new phpBinaryXmlException('Decimal requires 64-bit support');
                
                // http://msdn.microsoft.com/en-us/library/cc219250(v=PROT.10).aspx
                
                $pos += 16;
                
                return '999';
            break;
            case self::RECORD_TYPE_DATETIME_TEXT:
            case self::RECORD_TYPE_DATETIME_TEXT_WITH_END_ELEMENT:
                
                if(PHP_INT_SIZE < 8) throw new phpBinaryXmlException('Datetime requires 64-bit support');
                
                // http://stackoverflow.com/questions/2629983/binary-to-date-c-64-bit-format
                // http://msdn.microsoft.com/en-us/library/cc219251(v=PROT.10).aspx
                
                $pos += 62;
                $pos += 2;
                
                return '999';
            break;
            case self::RECORD_TYPE_CHARS8_TEXT:
            case self::RECORD_TYPE_CHARS8_TEXT_WITH_END_ELEMENT:
                list(,$record_length) = unpack("C*", $content{$pos});
                $pos += 1;
                
                $record = substr($content, $pos, $record_length);
                $pos += $record_length;
                
                return $record;
            break;
            case self::RECORD_TYPE_CHARS16_TEXT:
            case self::RECORD_TYPE_CHARS16_TEXT_WITH_END_ELEMENT:
                list(,$record_length) = unpack("S*", substr($content, $pos, 2));
                $pos += 2;
                
                $record = substr($content, $pos, $record_length);
                $pos += $record_length;
                
                return $record;
            break;
            case self::RECORD_TYPE_CHARS32_TEXT:
            case self::RECORD_TYPE_CHARS32_TEXT_WITH_END_ELEMENT:
                list(,$record_length) = unpack("L*", substr($content, $pos, 4));
                $pos += 4;
                
                $record = substr($content, $pos, $record_length);
                $pos += $record_length;
                
                return $record;
            break;
            case self::RECORD_TYPE_BYTES8_TEXT:
            case self::RECORD_TYPE_BYTES8_TEXT_WITH_END_ELEMENT:
                list(,$record_length) = unpack("C*", $content{$pos});
                $pos += 1;
                
                $record = substr($content, $pos, $record_length);
                $pos += $record_length;
                
                return base64_encode($record);
            break;
            case self::RECORD_TYPE_BYTES16_TEXT:
            case self::RECORD_TYPE_BYTES16_TEXT_WITH_END_ELEMENT:
                list(,$record_length) = unpack("S*", substr($content, $pos, 2));
                $pos += 2;
                
                $record = substr($content, $pos, $record_length);
                $pos += $record_length;
                
                return base64_encode($record);
            break;
            case self::RECORD_TYPE_BYTES32_TEXT:
            case self::RECORD_TYPE_BYTES32_TEXT_WITH_END_ELEMENT:
                list(,$record_length) = unpack("L*", substr($content, $pos, 4));
                $pos += 4;
                
                $record = substr($content, $pos, $record_length);
                $pos += $record_length;
                
                return base64_encode($record);
            break;
            case self::RECORD_TYPE_START_LIST_TEXT:
                
		$record = "";
                while(ord($content{$pos}) != self::RECORD_TYPE_END_LIST_TEXT) {
			if($record !== "") $record .= " ";
			$record .= self::getTextRecord($content, $pos);
		}

		$pos += 1; // skip 1 for end list
                
                return $record;
            break;
            case self::RECORD_TYPE_EMPTY_TEXT:
            case self::RECORD_TYPE_EMPTY_TEXT_WITH_END_ELEMENT:
                return '';
            break;
            case self::RECORD_TYPE_DICTIONARY_TEXT:
            case self::RECORD_TYPE_DICTIONARY_TEXT_WITH_END_ELEMENT:
                return 'str'.self::getDictionaryString($content, $pos);
            break;
            case self::RECORD_TYPE_BOOL_TEXT:
            case self::RECORD_TYPE_BOOL_TEXT_WITH_END_ELEMENT:
		$record = ord($content{$pos});
		$pos += 1;
		switch($record) {
			case 0:
				return 'false';
			break;
			case 1:
				return 'true';
			break;
		}
                throw new phpBinaryXmlException('Unknown value for bool <'.dechex($record).'> on pos <'.$pos.'>');
            break;
            case self::RECORD_TYPE_UNICODECHARS8_TEXT:
            case self::RECORD_TYPE_UNICODECHARS8_TEXT_WITH_END_ELEMENT:
                list(,$record_length) = unpack("C*", $content{$pos});
                $pos += 1;
                
                $record = substr($content, $pos, $record_length);
                $pos += $record_length;
                
                return mb_convert_encoding($record, "UTF-8", "UTF-16");
            break;
            case self::RECORD_TYPE_UNICODECHARS16_TEXT:
            case self::RECORD_TYPE_UNICODECHARS16_TEXT_WITH_END_ELEMENT:
                list(,$record_length) = unpack("S*", substr($content, $pos, 2));
                $pos += 2;
                
                $record = substr($content, $pos, $record_length);
                $pos += $record_length;
                
                return mb_convert_encoding($record, "UTF-8", "UTF-16");
            break;
            case self::RECORD_TYPE_UNICODECHARS32_TEXT:
            case self::RECORD_TYPE_UNICODECHARS32_TEXT_WITH_END_ELEMENT:
                list(,$record_length) = unpack("L*", substr($content, $pos, 4));
                $pos += 4;
                
                $record = substr($content, $pos, $record_length);
                $pos += $record_length;
                
                return mb_convert_encoding($record, "UTF-8", "UTF-16");
            break;
            case self::RECORD_TYPE_QNAMEDICTIONARY_TEXT:
            case self::RECORD_TYPE_QNAMEDICTIONARY_TEXT_WITH_END_ELEMENT:
		$prefix = chr(97+ord($content{$pos}));
		$pos += 1;

		$name = self::getDictionaryString($content, $pos);
                return $prefix.':str'.$name;
            break;
            default:
                throw new phpBinaryXmlException('Unknown value type <'.dechex($record_type).'> on pos <'.$pos.'>');
            break;
        }
    }
    
}

?>
