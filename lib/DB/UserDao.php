<?php

require_once './lib/DB/Database.php';
require_once './lib/DB/User.php';

require_once './lib/Util/CryptoUtil.php';

class UserDao{

	const table_name = 'users';

	private static function buildUser($row){
		return new User($row['user_id'], $row['username'], $row['name'], $row['password'], $row['email'], $row['user_level'], $row['warnings'], $row['notes']);
	}

	public static function createUser($username, $name, $email, $userlevel, $password){
		$username = Database::makeStringSafe($username);
		$name = Database::makeStringSafe($name);
		$email = Database::makeStringSafe($email);
		$userlevel = Database::makeStringSafe($userlevel);
		$encPassword = Database::makeStringSafe(CryptoUtil::encrypt($password));

		Database::doQuery("INSERT INTO ".Database::addPrefix(UserDao::table_name)." SET username = '".$username."', name = '".$name."', email = '".$email."', user_level = '".$userlevel."', password = '".$encPassword."'");

		return UserDao::getUserByID(mysql_insert_id());

	}

	public static function getUserByID($userId){
		$userId = Database::makeStringSafe($userId);
		$result = Database::doQuery("SELECT * FROM ".Database::addPrefix(UserDao::table_name)." WHERE user_id = '".$userId."'");

		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);
			$user = UserDao::buildUser($row);
			return $user;
		}else{
			return null;
		}
	}

	public static function getUserByUsername($username){
		$username = Database::makeStringSafe($username);
		$result = Database::doQuery("SELECT * FROM ".Database::addPrefix(UserDao::table_name)." WHERE username = '".$username."'");

		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);
			$user = UserDao::buildUser($row);
			return $user;
		}else{
			return null;
		}
	}

	public static function authUser($username, $password){
		$user = UserDao::getUserByUsername($username);
		if($user->password == CryptoUtil::encrypt($password)){
			return true;
		}else{
			return false;
		}
	}

	public static function getAllUsersOrderByName(){
		$result = Database::doQuery("SELECT * FROM ".Database::addPrefix(UserDao::table_name)." ORDER BY name ASC");
		$users = array();
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_assoc($result)){
				$users[] = UserDao::buildUser($row);
			}
		}
		return $users;
	}

	public static function updateUserPassword($userid, $password){

		$userid = Database::makeStringSafe($userid);
		$encPass = Database::makeStringSafe(CryptoUtil::encrypt($password));

		Database::doQuery("UPDATE ".Database::addPrefix(UserDao::table_name)." SET password = '".$encPass."' WHERE user_id = '".$userid."' LIMIT 1");

	}

	public static function updateUserEmail($userid, $email){

		$userid = Database::makeStringSafe($userid);
		$email = Database::makeStringSafe($email);

		Database::doQuery("UPDATE ".Database::addPrefix(UserDao::table_name)." SET email = '".$email."' WHERE user_id = '".$userid."' LIMIT 1");

	}

	public static function updateUserLevel($userid, $level){

		$userid = Database::makeStringSafe($userid);
		$level = Database::makeStringSafe($level);

		Database::doQuery("UPDATE ".Database::addPrefix(UserDao::table_name)." SET user_level = '".$level."' WHERE user_id = '".$userid."' LIMIT 1");

	}

	public static function updateUserNotes($userid, $notes){

		$userid = Database::makeStringSafe($userid);
		$notes = Database::makeStringSafe($notes);

		Database::doQuery("UPDATE ".Database::addPrefix(UserDao::table_name)." SET notes = '".$notes."' WHERE user_id = '".$userid."' LIMIT 1");

	}

	public static function updateName($userid, $name){

		$userid = Database::makeStringSafe($userid);
		$name = Database::makeStringSafe($name);

		Database::doQuery("UPDATE ".Database::addPrefix(UserDao::table_name)." SET name = '".$name."' WHERE user_id = '".$userid."' LIMIT 1");

	}

}

?>