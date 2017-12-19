<?php
require_once('./header.php');

//if (isset($_GET['query'])) $submit=$_GET['query'];
//else $submit='';
ini_set("memory_limit","512M");


//show_array($_POST);
//show_array($_GET);
//echo "submit = $submit";
?>
<head><title>MySQL Queries</title></head>
<body>
<p>

<h1>MySQL Queries for Bioinformatic analyses</h1>

<h2>Make "combine_data" Table</h2>

<fieldset><legend>general</legend>
<a href="querySGD.php">Query</a> general properties of SGD tables
</fieldset>
<br />
<fieldset><legend>raw</legend>
<a href="GeneDetails.php">Query</a> raw SGD tables
</fieldset>
<br />
<fieldset><legend>combined</legend>
<a href="query_comb_data.php">Query</a> "combined_data" tables
</fieldset>
<br />
<fieldset><legend>intersect</legend>
<a href="query_intersection_data.php">Query</a> "intersect_data" table
</fieldset>

<p>
<body>


<?php
require_once('./footer.php');
?>	
