# dotnet-binary-xml

[![Build Status](https://travis-ci.org/casperbiering/dotnet-binary-xml.png?branch=master)](https://travis-ci.org/casperbiering/dotnet-binary-xml)

**dotnet-binary-xml** is a PHP implementation of the [.NET Binary Format: XML Data Structure (MC-NBFX)](http://msdn.microsoft.com/en-us/library/cc219210.aspx).


## Installation

Just install [Composer](http://getcomposer.org) and run `composer require casperbiering/dotnet-binary-xml` in your project directory.

### Requirements

* XMLWriter (PHP extension)
* MBString (PHP extension)
* GMP (PHP extension)


## Known/Missing Issues

* only decoding is supported
* local timezone offset in datetime

### Specification Inconsistencies

1) http://msdn.microsoft.com/en-us/library/cc219251(v=PROT.10).aspx says that
"If the hour, minutes, seconds, and fraction of second parts are zero, the date MUST
be interpreted as the following characters. yyyy-MM-dd". That does not
match the examples.

2) http://msdn.microsoft.com/en-us/library/cc219270(v=PROT.10).aspx says that
UnicodeChars32TextRecord MUST be encoded using MultiByteInt31. That does not
match the examples.


## License

MIT
