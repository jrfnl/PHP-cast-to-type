PHP-cast-to-type
================

PHP Class to easily cast variables to a specific type.

Returns either the value in the specified type or null

Features:
- Optionally allow/disallow empty strings/arrays
- Optionally recursively cast all values in an array to the choosen type (similar to filter_var_array() behaviour)
- Optionally implode an array when cast to string
- Will succesfully cast any of the following string values to their boolean counterpart (similar to filter_var() behaviour, but less case-sensitive)
  True: '1', 'true', 'True', 'TRUE', 'y', 'Y', 'yes', 'Yes', 'YES', 'on', 'On', 'On'
  False: '0', 'false', 'False', 'FALSE', 'n', 'N', 'no', 'No', 'NO', 'off', 'Off', 'OFF'


###Some Usage examples:

`
$value = 'example';
$value = CastToType::_bool( $value ); // null

$value = 'true';
$value = CastToType::_bool( $value ); // true

$value = '123';
$value = CastToType::_int( $value ); // 123

$value = array( '123' );
$value = CastToType::_int( $value ); // null
$value = CastToType::_int( $value, $array2null = false ); // array( 123 )

`

###Available methods:

- `CastToType::cast( $value, $type, $allow_empty = true, $array2null = true, $implode_array = false, $explode_string = false );`

- `CastToType::_bool( $value, $array2null = true, $allow_empty = true );`
- `CastToType::_int( $value, $array2null = true, $allow_empty = true );`
- `CastToType::_float( $value, $array2null = true, $allow_empty = true );`
- `CastToType::_string( $value, $allow_empty = true, $array2null = true, $implode_array = false );`
- `CastToType::_array( $value, $allow_empty = true );`
- `CastToType::_object( $value );`
- `CastToType::_null( $value );`

All methods are static.
