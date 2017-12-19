<?  
// To make sure all the values are up to date, all the data
// in the holding table is dropped. These are then repopulated
// later on in the script
   	$table="go_slim_mapping";
	$sql = "TRUNCATE TABLE `$table`";
	mysql_query($sql);
	
// the following statement opens the files called SGD_features.tab
// and reads each line of the file into an array called $readfile

      $readfile = file("./Raw_files_for_DB/go_slim_mapping.tab");
	  
// Each line will be accessed by it's position in the array
// $readfile[0] would be the first line because the array begins at 0
// rather than 1

// Create a loop that will read all elements of the array and print out
// each field of the tab-delimited text file

for ($k=0; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);
	
// SGD Features Headings taken from the SGD_Features.tab file
	$ORF = addslashes("$fields[0]");
// addaslashes are used to overcome the problem with quotation marks in data
// causing problems with insertion into the database
	
	$gene = addslashes("$fields[1]");
	$sgd_id = addslashes("$fields[2]");
	$go_aspect = addslashes("$fields[3]");
	$go_slim_term = addslashes("$fields[4]");
	$goid = addslashes("$fields[5]");
	$feature_type_temp = addslashes("$fields[6]");
	$feature_type = trim($feature_type_temp);

// Values are inserted into their respective rows in the holding table.
// If an error occurs the sql query is killed
	$insert = mysql_query("INSERT INTO go_slim_mapping (orf, gene, sgd_id, go_aspect, go_slim_term, goid, feature_type) VALUES ('$orf', '$gene', '$sgd_id', '$go_aspect', '$go_slim_term', '$goid', '$feature_type')")or
	die(mysql_error());
	
// Prints the values that are inserted into the database.
// This can be removed or changed to show another message such as a completion
	//print("$fields[0] $fields[1] $fields[2] $fields[3] $fields[4] $fields[5] $fields[6] $fields[7] $fields[8] $fields[9] $fields[10] $fields[11] $fields[12] $fields[13] $fields[14] $fields[15]<br>");
}
	print "<p>Data has been sucessfully updated to the database!</p>";

?>
