<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_lupus = "localhost";
$database_lupus = "lupus";
$username_lupus = "root";
$password_lupus = "";
$lupus = mysql_pconnect($hostname_lupus, $username_lupus, $password_lupus) or trigger_error(mysql_error(),E_USER_ERROR); 
?>