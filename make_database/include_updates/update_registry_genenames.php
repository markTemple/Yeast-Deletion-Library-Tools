<?php
// To make sure all the values are up to date, all the data
// in the holding table is dropped. These are then repopulated
// later on in the script
   	$table = 'registry_genenames';
	$sql = "TRUNCATE TABLE `$table`";
	mysql_query($sql);
	
// the following statement opens the files called SGD_features.tab
// and reads each line of the file into an array called $readfile

// This line sets the the allowed memory usage of the script to 64M
// to allow the script to run properly on the server when the default
// is set too low
	ini_set("memory_limit","512M");

      $readfile = file("./Raw_files_for_DB/registry_genenames.tab");
//	  show_array($readfile); //good
// Each line will be accessed by it's position in the array
// $readfile[0] would be the first line because the array begins at 0
// rather than 1

// Create a loop that will read all elements of the array and print out
// each field of the tab-delimited text file

for ($k=0; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);

// addaslashes are used to overcome the problem with quotation marks in data
// causing problems with insertion into the database
//	$genlitID; is this added by default???? as it is auto increment

$Locus_name = addslashes($fields[0]);
$Other_name = addslashes("$fields[1]");
$Description = addslashes("$fields[2]");
$Gene_product = addslashes("$fields[3]");
$Phenotype = addslashes("$fields[4]");
$ORF = addslashes("$fields[5]");
$SGDID = trim(addslashes("$fields[6]"));

		$insert = mysql_query("
		INSERT INTO registry_genenames (Locus_name, Other_name, Description, Gene_product, Phenotype, ORF, SGDID) 
		VALUES ('$Locus_name', '$Other_name', '$Description', '$Gene_product', '$Phenotype', '$ORF', '$SGDID')
		")or die(mysql_error());	
		
}
	print "<p>Data has been sucessfully updated to the database!</p>";

?>
