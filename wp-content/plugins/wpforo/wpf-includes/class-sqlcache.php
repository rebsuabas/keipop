<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class wpForoSqlCache {
	/**
	 * @var array
	 */
	private static $sql_cache;

	/**
	 * wpForoSqlCache constructor.
	 */
	public function __construct() {
		$this->reset();
	}

	/**
	 * set empty array to static $sql_cache
	 */
	public function reset() {
		self::$sql_cache = array();
	}

	/**
	 * checking if this sql query already cached
	 *
	 * @param string $key string SQL query
	 *
	 * @return bool
	 */
	public function is_exist( $key ) {
		return array_key_exists( md5( $key ), self::$sql_cache );
	}

	/**
	 * return already cached SQL data
	 *
	 * @param string $key string sql query
	 *
	 * @return mixed
	 */
	public function get( $key ) {
		if( $this->is_exist($key) ){
			return self::$sql_cache[ md5( $key ) ];
		}else{
			return null;
		}
	}

	/**
	 * storing a cache of provided SQL data
	 *
	 * @param string $key string sql query
	 * @param mixed $data
	 */
	public function set( $key, $data ) {
		self::$sql_cache[ md5( $key ) ] = $data;
	}
}