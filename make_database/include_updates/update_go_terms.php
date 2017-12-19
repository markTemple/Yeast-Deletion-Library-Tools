<?php
// To make sure all the values are up to date, all the data
// in the holding table is dropped. These are then repopulated
// later on in the script
   	$table = 'go_terms';
	$sql = "TRUNCATE TABLE `$table`";
	mysql_query($sql);
	
// the following statement opens the files called SGD_features.tab
// and reads each line of the file into an array called $readfile

// This line sets the the allowed memory usage of the script to 64M
// to allow the script to run properly on the server when the default
// is set too low
	ini_set("memory_limit","512M");

      $readfile = file("./Raw_files_for_DB/go_terms.tab");
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

	$GOID = addslashes("$fields[0]");
	$GO_Term = addslashes("$fields[1]");
	$GO_Aspect = addslashes("$fields[2]");
	$GO_Term_Definition = addslashes("$fields[3]");
	

		$insert = mysql_query("
		INSERT INTO go_terms (GOID, GO_Term, GO_Aspect, GO_Term_Definition) 
		VALUES ('$GOID', '$GO_Term', '$GO_Aspect', '$GO_Term_Definition')
		")or die(mysql_error());	

}
	print "<p>Data has been sucessfully updated to the database!</p>";

?>
