<?php

   	$table = 'ORFlist_homo_dip';
	$sql = "TRUNCATE TABLE `$table`";
	mysql_query($sql);

    $readfile = file("./Raw_files_for_DB/ORFlist_homo_dip.txt");
	
	$readfile = array_unique($readfile);
	
//show_array($readfile);

for ($k=0; $k<=count($readfile)-1; $k++) {
    
	if(! isset ($readfile[$k])) { 
	$readfile[$k] = null;}// added this to remove offset error
	//ie if missing vallue set it to null??
	
		$fields = $readfile[$k];
		$insert = mysql_query("
		INSERT INTO ORFlist_homo_dip (Feature_Name)
		VALUES ('$fields')
		")or die(mysql_error());	
}
print "<p>Data has been sucessfully updated to the database!</p>";
?>
