<?php
require_once('./back_header.php');

//if (isset($_GET['query'])) $submit=$_GET['query'];
//else $submit='';
ini_set("memory_limit","512M");


//show_array($_POST);
//show_array($_GET);
//echo "submit = $submit";
?>
<head><title>Backend to Database scripts</title></head>
<body>
<p>

<h1>Backend scripts to download/create and modify Tables </h1>


<fieldset><legend>Download</legend>
<h2>Download SGD files</h2>
	<a href="./download_SGD.php">Download SGD files from the web</a> (SGD download area)
</fieldset>
<br />
<fieldset><legend>Show</legend>
<h2>Show all to the existing tables in Database</h2>
	<a href="./show_tables.php">Show existing tables in Database</a> (raw data and processed data tables)
</fieldset>
<br />
<fieldset><legend>Rebuild</legend>
<h2>Rebuild raw tables from downloaded files</h2>
	<a href="./rebuild.php">Run scripts to rebuild raw tables from downloaded files </a>(in addition extra feilds may be added and some data from source may be ommited )
</fieldset>
<br />

<p>
<body>



<?php

?>


<?php
require_once('./back_footer.php');
?>	
