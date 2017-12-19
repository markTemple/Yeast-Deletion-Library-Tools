<?  
// To make sure all the values are up to date, all the data
// in the holding table is dropped. These are then repopulated
// later on in the script
   	$table="interaction_data";
	$sql = "TRUNCATE TABLE `$table`";
	mysql_query($sql);
	
// This line sets the the allowed memory usage of the script to 64M
// to allow the script to run properly on the server when the default
// is set too low
	ini_set("memory_limit","128M");
	
// the following statement opens the files called interactions_data.tab
// and reads each line of the file into an array called $readfile

      $readfile = file("./Raw_files_for_DB/interaction_data.tab");
	  
// Each line will be accessed by it's position in the array
// $readfile[0] would be the first line because the array begins at 0
// rather than 1

// Create a loop that will read all elements of the array and print out
// each field of the tab-delimited text file

for ($k=0; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);
	
// SGD Features Headings taken from the interactions_data.tab file
	$feat_bait = addslashes("$fields[0]");
// addaslashes are used to overcome the problem with quotation marks in data
// causing problems with insertion into the database
	$std_gene_bait = addslashes("$fields[1]");
	$feat_hit = addslashes("$fields[2]");
	$std_gene_hit = addslashes("$fields[3]");
	$exp_type = addslashes("$fields[4]");
	$interaction = addslashes("$fields[5]");
	$source = addslashes("$fields[6]");
	$interact_by = addslashes("$fields[7]");
	$notes = addslashes("$fields[8]");
	$phenotype = addslashes("$fields[9]");
	$reference = addslashes("$fields[10]");
	$citation_temp = addslashes("$fields[11]");
	$citation = trim($citation_temp);

// Values are inserted into their respective rows in the holding table.
// If an error occurs the sql query is killed
	$insert = mysql_query("INSERT INTO interaction_data (feat_bait, std_gene_bait, feat_hit, std_gene_hit, exp_type, interaction, source, interact_by, notes, phenotype, reference, citation) VALUES ('$feat_bait', '$std_gene_bait', '$feat_hit', '$std_gene_hit', '$exp_type', '$interaction', '$source', '$interact_by', '$notes', '$phenotype', '$reference', '$citation')")or
	die(mysql_error());
	
// Prints the values that are inserted into the database.
// This can be removed or changed to show another message such as a completion
	//print("$fields[0] $fields[1] $fields[2] $fields[3] $fields[4] $fields[5] $fields[6] $fields[7] $fields[8] $fields[9] $fields[10] $fields[11] $fields[12] $fields[13] $fields[14] $fields[15]<br>");
}
	print "<p>Data has been sucessfully updated to the database!</p>";

?>
