[![GitHub license](https://img.shields.io/badge/license-GPLv2-blue.svg)](https://raw.githubusercontent.com/jrfnl/PHP-cheat-sheet-extended/master/LICENSE.md)
[![Build Status](https://travis-ci.org/jrfnl/PHP-cast-to-type.svg?branch=master)](https://travis-ci.org/jrfnl/PHP-cast-to-type)
[![Build Status](https://scrutinizer-ci.com/g/jrfnl/PHP-cast-to-type/badges/build.png?b=master)](https://scrutinizer-ci.com/g/jrfnl/PHP-cast-to-type/build-status/master)

PHP-cast-to-type
================

PHP Class to easily and consistently cast variables to a specific type.

Returns either the value in the specified type or `null`.

### Features:
-   Consistent results across PHP versions.
-	Compatible with PHP4, PHP5 and PHP7 which makes it extra useful if you're coding for open source software where you don't know the library user's PHP version and the `filter_var()` functions may not be available.
-	Optionally recursively cast all values in an array to the choosen type (similar to `filter_var_array()` behaviour).
-	Optionally allow/disallow empty strings/arrays.
-	Will succesfully cast any of the following string values to their boolean counterpart (similar to `filter_var()` behaviour, but less case-sensitive).
	* True: `'1', 'true', 'True', 'TRUE', 'y', 'Y', 'yes', 'Yes', 'YES', 'on', 'On', 'On'`.
	* False: `'0', 'false', 'False', 'FALSE', 'n', 'N', 'no', 'No', 'NO', 'off', 'Off', 'OFF'`.
-   Support for casting of `SplType` objects.


### Some Usage examples:

```php
$value = 'example';
$value = CastToType::_bool( $value ); // null

$value = 'true';
$value = CastToType::_bool( $value ); // true

$value = '123';
$value = CastToType::_int( $value ); // 123

$value = array( '123' );
$value = CastToType::_int( $value ); // null
$value = CastToType::_int( $value, $array2null = false ); // array( 123 )
```

### Available methods:

All methods are static.

- `CastToType::cast( $value, $type, $array2null = true, $allow_empty = true, $implode_array = false );`

- `CastToType::_bool( $value, $array2null = true, $allow_empty = true );`
- `CastToType::_int( $value, $array2null = true, $allow_empty = true );`
- `CastToType::_float( $value, $array2null = true, $allow_empty = true );`
- `CastToType::_string( $value, $array2null = true, $allow_empty = true );`
- `CastToType::_array( $value, $allow_empty = true );`
- `CastToType::_object( $value, $allow_empty = true );`
- `CastToType::_null( $value );`

#### Parameters:

Param | Type | Description
----- | ---- | -----------
`$value` | mixed | Value to cast.
`$type`  | string | Type to cast to. Valid values: `'bool'`, `'boolean'`, `'int'`, `'integer'`, `'float'`, `'num'`, `'string'`, `'array'`, `'object'`.
`$array2null` | bool | Optional. Whether to return `null` for arrays when casting to bool, int, float, num or string. If false, the individual values held in the array will recursively be cast to the specified type. Defaults to `true`.
`$allow_empty` | bool | Optional. Whether to allow empty strings, empty arrays, empty objects. If false, `null` will be returned instead of the empty string/array/object. Defaults to `true`.


### Installation

1. Head to the [Releases](https://github.com/jrfnl/PHP-cast-to-type/releases) page and download the latest release zip.
2. Extract the files and place them somewhere in your project hierarchy.
3. Require the class loader using `require_once '/path/to/cast-to-type.php';`.

#### Composer

If you are using PHP5+ (as you should), PHP-Cast-to_Type is also available as a [package](https://packagist.org/packages/jrfnl/PHP-cast-to-type) installable via Composer:

~~~sh
composer require jrfnl/PHP-cast-to-type
~~~


### Changelog:

#### 2.0.1 (Jan 2018)
* Bugfix for PHP cross-version compatibility. This affected use of this class on PHP < 5.2.7.
* General housekeeping.

#### 2.0 (Jun 2015)
* Updated the object casting to be in line with the way this is done in PHP7 for cross-version compatibility.
  Previously arrays with numerical keys cast to objects would be added to the object as a property called `array` with the value being the complete array. Now - as in PHP7 - each numerical array key will be cast to an individual property.
  This breaks backward-compatibility with v1.0 for array to object cast results, so please review your code if you relied on the old behaviour.
* Fixed a bug in the object casting which would return `null` for non-objects cast to objects in PHP <= 5.1.
* Fixed a bug in the object casting where an empty string would not return `null` while `$allow_empty` was set to `false`.


#### 1.0 (2006 / Sept 2013)
* Initial release.
