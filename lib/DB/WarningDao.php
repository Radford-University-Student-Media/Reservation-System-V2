<?php

require_once './lib/DB/Database.php';
require_once './lib/DB/Warning.php';

class WarningDao{

	const table_name = 'warnings';
	
	private static function buildWarning($row){
		return new Warning($row['warn_id'], $row['user_id'], $row['reason'], $row['type'], $row['time']);
	}
	
	public static function warnUser($userId, $reason, $type){
		$userId = Database::makeStringSafe($userId);
		$reason = Database::makeStringSafe($reason);
		$type = Database::makeStringSafe($type);
		$datetype = Database::CurrentMySQLDateTime();
		
		Database::doQuery("INSERT INTO ".Database::addPrefix(WarningDao::table_name).
		" SET user_id = '".$userId."', reason = '".$reason."', type = '".$type."',".
		" time = '".$datetype."'");
		
		return WarningDao::getWarningByID(mysql_insert_id());
	}
	
	public static function deleteWarning($id){
		$id = Database::makeStringSafe($id);
		Database::doQuery("DELETE FROM ".Database::addPrefix(WarningDao::table_name)." WHERE warn_id = '".$id."' LIMIT 1");
	}
	
	public static function getWarningByID($id){
		$id = Database::makeStringSafe($id);
		$result = Database::doQuery("SELECT * FROM ".Database::addPrefix(WarningDao::table_name)." WHERE warn_id = '".$id."'");
		if(mysql_num_rows($result) > 0)
			return WarningDao::buildWarning(mysql_fetch_assoc($result));
		else
			return null;
	}
	
	public static function getAllWarningsForUser($userId){
		$userId = Database::makeStringSafe($userId);
		$result = Database::doQuery("SELECT * FROM ".Database::addPrefix(WarningDao::table_name)." WHERE user_id = '".$userId."'");
		$warnings = array();
		while($row = mysql_fetch_assoc($result)){
			$warnings[] = WarningDao::buildWarning($row);
		}
		return $warnings;
	}
	
	public static function getWarningsForUserByType($userId, $type){
		$userId = Database::makeStringSafe($userId);
		$type = Database::makeStringSafe($type);
		$result = Database::doQuery("SELECT * FROM ".Database::addPrefix(WarningDao::table_name)." WHERE user_id = '".$userId."' and type = '".$type."'");
		$warnings = array();
		while($row = mysql_fetch_assoc($result)){
			$warnings[] = WarningDao::buildWarning($row);
		}
		return $warnings;
	}
	
	public static function getWarningCountForUser($userId){
		$result = Database::doQuery("SELECT * FROM ".Database::addPrefix(WarningDao::table_name)." WHERE user_id = '".$userId."'");
		return mysql_num_rows($result);
	}
	
	public static function getWarningCountForUserByType($userId, $type){
		$result = Database::doQuery("SELECT * FROM ".Database::addPrefix(WarningDao::table_name)." WHERE user_id = '".$userId."' and type = '".$type."'");
		return mysql_num_rows($result);
	}
	
}

?>