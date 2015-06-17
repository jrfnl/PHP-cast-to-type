<?php
/**
 * CastToType.
 *
 * Class to easily cast variables to a specific type.
 *
 * Features:
 * - Optionally allow/disallow empty strings/arrays.
 * - Optionally recursively cast all values in an array to the choosen type (similar to filter_var_array() behaviour).
 * - Optionally implode an array when cast to string.
 *
 * File:       class.cast-to-type-php4.php
 *
 * @package   CastToType
 * @version   1.0
 * @link      https://github.com/jrfnl/PHP-cast-to-type.git
 * @author    Juliette Reinders Folmer, {@link http://www.adviesenzo.nl/ Advies en zo} -
 *            <casttotype@adviesenzo.nl>
 * @copyright (c) 2006-2015, Advies en zo, Meedenken en -doen <casttotype@adviesenzo.nl> All rights reserved.
 * @license   http://www.opensource.org/licenses/lgpl-license.php GNU Lesser General Public License.
 * @since     2006
 */

if ( ! class_exists( 'CastToType' ) ) {
	/**
	 * CastToType
	 *
	 * @package   CastToType
	 * @version   1.0
	 * @link      https://github.com/jrfnl/PHP-cast-to-type.git
	 * @author    Juliette Reinders Folmer, {@link http://www.adviesenzo.nl/ Advies en zo} -
	 *            <casttotype@adviesenzo.nl>
	 * @copyright (c) 2013, Advies en zo, Meedenken en -doen <casttotype@adviesenzo.nl>
	 *            All rights reserved.
	 * @license   http://www.opensource.org/licenses/lgpl-license.php GNU Lesser General Public License.
	 */
	class CastToType {


		/**
		 * Cast a value to specific variable type.
		 *
		 * @static
		 *
		 * @param mixed  $value       Value to cast.
		 * @param string $type        Type to cast to.
		 * @param bool   $array2null  (Optional) Whether to return null for arrays when casting to
		 *                            bool, int, float, num or string.
		 *                            If false, the individual values held in the array will recursively
		 *                            be cast to the specified type.
		 *                            Defaults to true.
		 * @param bool   $allow_empty (Optional) Whether to allow empty strings, empty arrays, empty objects.
		 *                            If false, null will be returned instead of the empty string/array/object.
		 *                            Defaults to true.
		 * @return mixed|null
		 */
		function cast( $value, $type, $array2null = true, $allow_empty = true ) {

			// Have the expected variables been passed ?
			if ( isset( $value ) === false || isset( $type ) === false ) {
				return null;
			}

			$type        = strtolower( trim( $type ) );
			$valid_types = array(
				'bool'    => 1,
				'boolean' => 1,
				'int'     => 1,
				'integer' => 1,
				'float'   => 1,
				'num'     => 1,
				'string'  => 1,
				'array'   => 1,
				'object'  => 1,
			);

			// Check if the typing passed is valid, if not return NULL.
			if ( ! isset( $valid_types[ $type ] ) ) {
				return null;
			}

			switch ( $type ) {
				case 'bool':
				case 'boolean':
					return CastToType::_bool( $value, $array2null, $allow_empty );

				case 'integer':
				case 'int':
					return CastToType::_int( $value, $array2null, $allow_empty );

				case 'float':
					return CastToType::_float( $value, $array2null, $allow_empty );

				case 'num':
					if ( is_numeric( $value ) ) {
						$value = ( ( (float) $value != (int) $value ) ? (float) $value : (int) $value );
					}
					else {
						$value = null;
					}
					return $value;

				case 'string':
					return CastToType::_string( $value, $array2null, $allow_empty );

				case 'array':
					return CastToType::_array( $value, $allow_empty );

				case 'object':
					return CastToType::_object( $value, $allow_empty );

				case 'null':
				default:
					return null;
			}
		}


		/**
		 * Cast a value to bool.
		 *
		 * @static
		 *
		 * @param mixed $value       Value to cast.
		 * @param bool  $array2null  (Optional) Whether to return null for an array or to cast the
		 *                           individual values within the array to the chosen type.
		 * @param bool  $allow_empty (Optional) Whether to allow empty arrays. Only has effect
		 *                           when $array2null = false.
		 * @return bool|array|null
		 */
		function _bool( $value, $array2null = true, $allow_empty = true ) {
			$true = array(
				'1',
				'true', 'True', 'TRUE',
				'y', 'Y',
				'yes', 'Yes', 'YES',
				'on', 'On', 'On',

			);
			$false = array(
				'0',
				'false', 'False', 'FALSE',
				'n', 'N',
				'no', 'No', 'NO',
				'off', 'Off', 'OFF',
			);

			if ( is_bool( $value ) ) {
				return $value;
			}
			else if ( is_int( $value ) && ( $value === 0 || $value === 1 ) ) {
				return (bool) $value;
			}
			else if ( ( is_float( $value ) && ! is_nan( $value ) ) && ( $value === (float) 0 || $value === (float) 1 ) ) {
				return (bool) $value;
			}
			else if ( is_string( $value ) ) {
				$value = trim( $value );
				if ( in_array( $value, $true, true ) ) {
					return true;
				}
				else if ( in_array( $value, $false, true ) ) {
					return false;
				}
				else {
					return null;
				}
			}
			else if ( $array2null === false && is_array( $value ) ) {
				return CastToType::recurse( $value, '_bool', $allow_empty );
			}
			else if ( is_object( $value ) && get_class( $value ) === 'SplBool' ) {
				if ( $value == true ) {
					return true;
				}
				else if ( $value == false ) {
					return false;
				}
				else {
					return null;
				}
			}
			else if ( is_object( $value ) && get_parent_class( $value ) === 'SplType' ) {
				switch ( get_class( $value ) ) {
					case 'SplInt':
						return CastToType::_bool( (int) $value, $array2null, $allow_empty );

					case 'SplFloat':
						return CastToType::_bool( (float) $value, $array2null, $allow_empty );

					case 'SplString':
						return CastToType::_bool( (string) $value, $array2null, $allow_empty );

					default:
						return null;
				}
			}
			return null;
		}


		/**
		 * Cast a value to integer.
		 *
		 * @static
		 *
		 * @param mixed $value       Value to cast.
		 * @param bool  $array2null  (Optional) Whether to return null for an array or to cast the
		 *                           individual values within the array to the chosen type.
		 * @param bool  $allow_empty (Optional) Whether to allow empty arrays. Only has effect
		 *                           when $array2null = false.
		 * @return int|array|null
		 */
		function _int( $value, $array2null = true, $allow_empty = true ) {

			if ( is_int( $value ) ) {
				return $value;
			}
			else if ( is_float( $value ) ) {
				if ( (int) $value == $value && ! is_nan( $value ) ) {
					return (int) $value;
				}
				else {
					return null;
				}
			}
			else if ( is_string( $value ) ) {
				$value = trim( $value );
				if ( $value === '' ) {
					return null;
				}
				else if ( ctype_digit( $value ) ) {
					return (int) $value;
				}
				else if ( strpos( $value, '-' ) === 0 && ctype_digit( substr( $value, 1 ) ) ) {
					return (int) $value;
				}
				else {
					return null;
				}
			}
			else if ( $array2null === false && is_array( $value ) ) {
				return CastToType::recurse( $value, '_int', $allow_empty );
			}
			else if ( is_object( $value ) && get_class( $value ) === 'SplInt' ) {
				if ( (int) $value == $value ) {
					return (int) $value;
				}
				else {
					return null;
				}
			}
			else if ( is_object( $value ) && ( get_class( $value ) === 'SplBool' || get_class( $value ) === 'SplFloat' || get_class( $value ) === 'SplString' ) ) {
				switch ( get_class( $value ) ) {
					case 'SplBool':
						return CastToType::_int( (bool) $value, $array2null, $allow_empty );

					case 'SplFloat':
						return CastToType::_int( (float) $value, $array2null, $allow_empty );

					case 'SplString':
						return CastToType::_int( (string) $value, $array2null, $allow_empty );

					default:
						return null;
				}
			}
			return null;
		}


		/**
		 * Cast a value to float.
		 *
		 * @static
		 *
		 * @param mixed $value       Value to cast.
		 * @param bool  $array2null  (Optional) Whether to return null for an array or to cast the
		 *                           individual values within the array to the chosen type.
		 * @param bool  $allow_empty (Optional) Whether to allow empty arrays. Only has effect
		 *                           when $array2null = false.
		 * @return float|array|null
		 */
		function _float( $value, $array2null = true, $allow_empty = true ) {
			if ( is_float( $value ) ) {
				return $value;
			}
			else if ( $array2null === false && is_array( $value ) ) {
				return CastToType::recurse( $value, '_float', $allow_empty );
			}
			else if ( is_scalar( $value ) && ( is_numeric( trim( $value ) ) && ( floatval( $value ) == trim( $value ) ) ) ) {
				return floatval( $value );
			}

			else if ( is_object( $value ) && get_class( $value ) === 'SplFloat' ) {
				if ( (float) $value == $value ) {
					return (float) $value;
				}
				else {
					return null;
				}
			}
			else if ( is_object( $value ) && ( get_class( $value ) === 'SplBool' || get_class( $value ) === 'SplInt' || get_class( $value ) === 'SplString' ) ) {
				switch ( get_class( $value ) ) {
					case 'SplBool':
						return CastToType::_float( (bool) $value, $array2null, $allow_empty );

					case 'SplInt':
						return CastToType::_float( (int) $value, $array2null, $allow_empty );

					case 'SplString':
						return CastToType::_float( (string) $value, $array2null, $allow_empty );

					default:
						return null;
				}
			}
			return null;
		}


		/**
		 * Cast a value to string.
		 *
		 * @static
		 *
		 * @param mixed $value       Value to cast.
		 * @param bool  $array2null  (Optional) Whether to return null for an array or to cast the
		 *                           individual values within the array to the chosen type.
		 * @param bool  $allow_empty (Optional) Whether to allow empty strings/arrays/objects.
		 *
		 * @return string|array|null
		 */
		function _string( $value, $array2null = true, $allow_empty = true ) {
			if ( is_string( $value ) && ( $value !== '' || $allow_empty === true ) ) {
				return $value;
			}
			else if ( is_int( $value ) || is_float( $value ) ) {
				return strval( $value );
			}
			else if ( $array2null === false && is_array( $value ) ) {
				return CastToType::recurse( $value, '_string', $allow_empty );
			}
			else if ( is_object( $value ) && get_parent_class( $value ) === 'SplType' ) {
				if ( (string) $value == $value ) {
					return (string) $value;
				}
				else {
					return null;
				}
			}
			else if ( is_object( $value ) && method_exists( $value, '__toString' ) ) {
				return (string) $value;
			}
			return null;
		}


		/**
		 * Cast a value to array.
		 *
		 * @static
		 *
		 * @param mixed $value       Value to cast.
		 * @param bool  $allow_empty (Optional) Whether to allow empty strings/arrays/objects.
		 *
		 * @return array|null
		 */
		function _array( $value, $allow_empty = true ) {
			if ( is_array( $value ) !== true ) {
				$value = (array) $value;
			}

			if ( count( $value ) > 0 || $allow_empty === true ) {
				return $value;
			}
			return null;
		}


		/**
		 * Cast a value to object.
		 *
		 * Please note: in a normal array to object cast pre-PHP7, array values with numerical keys are 'lost'.
		 * This method checks whether the array contains numerical keys, if it doesn't it will do a
		 * normal array to object cast. If it does, it will cast each numerically indexes value to a numerical
		 * property, similar to the behaviour in PHP7.
		 *
		 * @static
		 *
		 * @param mixed $value       Value to cast.
		 * @param bool  $allow_empty (Optional) Whether to allow empty strings/arrays/objects.
		 *
		 * @return object|null
		 */
		function _object( $value, $allow_empty = true ) {
			if ( is_array( $value ) === true ) {
				$has_num_keys = false;
				foreach ( $value as $k => $v ) {
					if ( is_int( $k ) ) {
						$has_num_keys = true;
						break;
					}
				}

				if ( $has_num_keys === false ) {
					$value = (object) $value;
				}
				else {
					$new_value = new stdClass();
					foreach ( $value as $k => $v ) {
						$new_value->$k = $v;
					}
					$value = $new_value;
					unset( $new_value, $k, $v );
				}
			}
			else if ( is_object( $value ) !== true ) {
				$value = (object) $value;
			}

			if ( $allow_empty === false ) {
				$methods    = get_class_methods( $value );
				$properties = get_object_vars( $value );
				if ( ( is_null( $methods ) || count( $methods ) === 0 ) && ( is_null( $properties ) || count( $properties ) === 0 ) ) {
					// No methods or properties found.
					$value = null;
				}
			}

			return $value;
		}


		/**
		 * Cast a value to null (for completeness).
		 *
		 * @static
		 *
		 * @return null
		 */
		function _null() {
			return null;
		}


		/**
		 * Recurse through an array.
		 *
		 * @static
		 * @internal
		 *
		 * @param array  $value       Array holding values to cast.
		 * @param string $method      Calling method, i.e. cast to which type of variable.
		 *                            Can only be _bool, _int, _float or _string.
		 * @param bool   $allow_empty (Optional) Whether to allow empty arrays in the return.
		 *
		 * @return array|null
		 */
		function recurse( $value, $method, $allow_empty = true ) {
			if ( is_array( $value ) ) {
				if ( count( $value ) === 0 ) {
					if ( $allow_empty === true ) {
						return $value;
					}
					else {
						return null;
					}
				}
				else {
					foreach ( $value as $k => $v ) {
						$value[ $k ] = CastToType::$method( $v, false, $allow_empty );
					}
					return $value;
				}
			}
			return null;
		}
	}

}
