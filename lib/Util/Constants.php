<?php

define('LOGIN_TYPE_DB', 'db');
define('LOGIN_TYPE_LDAP', 'ldap');

define('LDAP_TYPE_LOCAL', 'local');
define('LDAP_TYPE_REMOTE', 'remote');

define('ERROR_OUTPUT_NONE', 'none');
define('ERROR_OUTPUT_PHP', 'php');
define('ERROR_OUTPUT_DBID', 'dbid');
define('ERROR_OUTPUT_BOTH', 'both');

define('RES_USERLEVEL_NOLOGIN', 0);
define('RES_USERLEVEL_USER', 1);
define('RES_USERLEVEL_LEADER', 2);
define('RES_USERLEVEL_PROFESSOR', 3);
define('RES_USERLEVEL_ADMIN', 6);

define('RES_USERLEVEL_STRING_NOLOGIN', 'Disabled');
define('RES_USERLEVEL_STRING_USER', 'Student');
define('RES_USERLEVEL_STRING_LEADER', 'Research Student');
define('RES_USERLEVEL_STRING_PROFESSOR', 'Professor');
define('RES_USERLEVEL_STRING_ADMIN', 'Admin');

define('RES_STATUS_PENDING', 0);
define('RES_STATUS_CONFIRMED', 1);
define('RES_STATUS_DENIED', 2);
define('RES_STATUS_CHECKED_IN', 3);
define('RES_STATUS_CHECKED_OUT', 4);

define('RES_WARNING_ACTIVE', 1);
define('RES_WARNING_NOTE', 2);
define('RES_WARNING_INACTIVE', 3);

define('RES_WARNING_MAX_ACTIVE', 2);

define('RES_ERROR_LOGIN_NO_USER', 1);
define('RES_ERROR_LOGIN_USER_PASS', 2);

?>