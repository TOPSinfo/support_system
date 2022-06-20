<?php
if (!function_exists('nextId')) {
	function nextId($table)
	{
		$DB = DB::connection()->getDatabaseName();
		$table = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$DB."' AND TABLE_NAME = '".$table."'");
		if (!empty($table)) {
			return $table[0]->AUTO_INCREMENT;
		}
	}
}

if (!function_exists('hashSalt')) {
	function hashSalt($table)
	{
		$id = nextId($table);
		$tmp_id = Hash::make($id);
		return md5($tmp_id);
	}
}