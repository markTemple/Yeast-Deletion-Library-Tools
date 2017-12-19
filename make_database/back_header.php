<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<?php
require_once("../SGD_DBconstants.inc");
require_once("./classes/mysql.php");
require_once('./classes/php_func.php');
require_once('./classes/db_ToolFunc.php');
require_once('./classes/forms.php');

open_database(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

foreach($_GET as $key => $selected){// put in to function avoid repitition
	if(isset($selected)){
		$postdata["$key"] = $selected;
	}
}
?>	

<head>
	<title>Title</title>
	<link rel="stylesheet" type="text/css" href="./index_new.css" media="screen" />
</head>

<div id="header">
	<h1>YDL BACKEND Tools</h1>
</div>		

<div id="centeredmenu">
   <ul>
			<li><a href="./backend_index.php">| HOME |</a> </li>
		
  </ul>
</div>
<div class="colmask leftmenu">
	<div class="colleft">
		<div class="col_main">

<!--these divs are closed in the footer
also note that the left hand menu is contained in the footer also
this is because the divs have to be loaded in a certain order to work properly-->