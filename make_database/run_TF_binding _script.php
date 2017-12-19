<?php
require_once('./back_header.php');

ini_set("memory_limit","512M");
?>

<head>
	<title></title>
</head>

<body>
	<h2>Are you sure you want to run TF_binding script??? </h2>
	<h3>These scripts will rebuild the MySQL table of TF pairs, this take a while to run, sit back and grab yourself a coffee!</h3>
	<p>

<a href="./index.php">NO</a> Back to index <br><br>
<a href="./TF_binding.php">YES</a> Run TF_binding scripts <br>


</p>
</body>

<?php
require_once('./back_footer.php');
?>	
