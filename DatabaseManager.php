<?php

class DatabaseManager
{
	private static $pdoInstance;

	private function __construct()
	{
	}

	public static function getPdoInstance()
	{
		if (self::$pdoInstance === null) {
			self::$pdoInstance = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');
		}

		return self::$pdoInstance;
	}
}
