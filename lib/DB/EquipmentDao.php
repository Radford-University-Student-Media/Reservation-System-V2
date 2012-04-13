<?php

require_once './lib/DB/Database.php';
require_once './lib/DB/Equipment.php';

class EquipmentDao{

	const table_name = 'equipment';

	public static function getEquipmentByID($equipId){

		$result = Database::doQuery("SELECT * FROM ".Database::addPrefix(EquipmentDao::table_name)." WHERE equip_id = '".Database::makeStringSafe($equipId)."'");

		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);
			$equipment = new Equipment($row['equip_id'], $row['name'], $row['type'], $row['serial'], $row['description'], $row['max_length'], $row['picture'], $row['min_user_level'], $row['checkoutfrom']);
			return $equipment;
		}else{
			return null;
		}

	}

	public static function getAllEquipment(){

		$result = Database::doQuery("SELECT * FROM ".Database::addPrefix(EquipmentDao::table_name));

		$equipment = array();
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_assoc($result)){
				$equipment[] = new Equipment($row['equip_id'], $row['name'], $row['type'], $row['serial'], $row['description'], $row['max_length'], $row['picture'], $row['min_user_level'], $row['checkoutfrom']);
			}
		}
		return $equipment;

	}

}

?>