<?php
$var = $_GET['var'];
$filter = [];
var_dump((bool)date_create($var));
mysqli_connect('localhost','root','','');