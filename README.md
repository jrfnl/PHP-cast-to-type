PHP-cast-to-type
================

PHP Class to easily cast variables to a specific type.

Returns either the value in the specified type or null

Features:
-	Optionally recursively cast all values in an array to the choosen type (similar to filter_var_array() behaviour)
-	Optionally allow/disallow empty strings/arrays
-	Will succesfully cast any of the following string values to their boolean counterpart (similar to filter_var() behaviour, but less case-sensitive)
	*	True: '1', 'true', 'True', 'TRUE', 'y', 'Y', 'yes', 'Yes', 'YES', 'on', 'On', 'On'
	*	False: '0', 'false', 'False', 'FALSE', 'n', 'N', 'no', 'No', 'NO', 'off', 'Off', 'OFF'
-	Compatible with both PHP4 and 5 which makes it extra useful if you're coding for open source software where you don't know the library user's PHP version and the filter_var() functions may not be available.


###Some Usage examples:

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

###Available methods:

All methods are static.

- `CastToType::cast( $value, $type, $array2null = true, $allow_empty = true, $implode_array = false, $explode_string = false );`

- `CastToType::_bool( $value, $array2null = true, $allow_empty = true );`
- `CastToType::_int( $value, $array2null = true, $allow_empty = true );`
- `CastToType::_float( $value, $array2null = true, $allow_empty = true );`
- `CastToType::_string( $value, $array2null = true, $allow_empty = true );`
- `CastToType::_array( $value, $allow_empty = true );`
- `CastToType::_object( $value, $allow_empty = true );`
- `CastToType::_null( $value );`

