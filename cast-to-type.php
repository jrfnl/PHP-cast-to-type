<?php
/**
 * CastToType - a class to easily cast variables to a specific type.
 *
 * Features:
 * - Optionally allow/disallow empty strings/arrays.
 * - Optionally recursively cast all values in an array to the choosen type (similar to filter_var_array() behaviour).
 *
 * File:      cast-to-type.php
 *
 * @package   CastToType
 * @version   2.0.1
 * @link      https://github.com/jrfnl/PHP-cast-to-type.git
 * @author    Juliette Reinders Folmer, {@link http://www.adviesenzo.nl/ Advies en zo} -
 *            <casttotype@adviesenzo.nl>
 * @copyright (c) 2006-2018, Advies en zo, Meedenken en -doen <casttotype@adviesenzo.nl> All rights reserved.
 * @license   http://www.opensource.org/licenses/lgpl-license.php GNU Lesser General Public License.
 * @since     1.0
 */

if ( version_compare( phpversion(), '5.0.0', '>=' ) ) {
	include dirname( __FILE__ ) . '/class.cast-to-type.php';
}
else {
	include dirname( __FILE__ ) . '/class.cast-to-type-php4.php';
}
