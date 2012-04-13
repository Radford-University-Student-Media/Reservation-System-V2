<?php

class Config{

	const maint_mode = false;
	
	/**
	 * Full URL of system
	 * 
	 * @var unknown_type
	 */
	const location = 'http://mine.ramielrowe.com/res_v2/';

	const mysql_server = 'localhost';
	const mysql_user = 'res';
	const mysql_password = 'Pass1234!';
	const mysql_database = 'res';
	const mysql_table_prefix = 'res_';
	
	/**
	 * Key used for blowfish encryption. 
	 * 
	 * Values: 16 or 32 character long string of random characters.
	 * 
	 * @var String
	 */
	
	const blowfish_key = '1234567890123456';
	
	/**
	 * Determines how the system authenticates uses.
	 * 
	 * Possible values: db | ldap;
	 * 
	 * db: Authenticates against username/password in the database
	 * ldap: Authenticates against an ldap system
	 * 
	 * @var String
	 */
	
	const login_type = 'ldap';
	
	/**
	 * Determines method used to authenticate against ldap.
	 * 
	 * Possible values: local | remote
	 * 
	 * local: Uses 'ldap_server' and 'ldap_domain' to authenticate.
	 * remote: Uses a remote script at 'remote_ldap_location' to authenticate.
	 * 
	 * @var String
	 */
	const ldap_type = 'remote';
	
	/**
	 * LDAP server used for authentication. Required if 'ldap_type' = 'local'
	 * 
	 * @var String
	 */
	const ldap_server = 'interstate81.radford.edu';
	
	/**
	 * LDAP domain to authenticate against. Required if 'ldap_type' = 'local'
	 *  
	 * @var unknown_type
	 */
	const ldap_domain = 'radford.edu';
	
	/**
	 * Full URL of remote LDAP script. Required if 'ldap_type' = 'remote'
	 * 
	 * @var String
	 */
	const remote_ldap_location = 'https://php.radford.edu/~mediaequip/ldap/authUser.php';

}

?>
