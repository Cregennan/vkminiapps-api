<?php
include 'lib/external_libraries/Mysql/Mysql.php';
include 'lib/external_libraries/Mysql/Exception.php';
include 'lib/external_libraries/Mysql/Statement.php';
include_once 'config.php';

//Connect to Database MySQL
$db = Mysql::create(DATABASE_SERVER,DATABASE_LOGIN,DATABASE_PASSWORD)
    ->setCharset('utf8');


//Checking and creating database if not exist
$database_check = $db->query("SHOW DATABASES LIKE '?s'",DATABASE_DBNAME);
if (!$database_check->fetch_assoc()){
    $db->query("CREATE DATABASE ?s",DATABASE_DBNAME);
}
$db->setDatabaseName(DATABASE_DBNAME);

//
if (GENERATE_DATABASE_SCHEMA){
    include './database/db_schema_generator.php';
}

