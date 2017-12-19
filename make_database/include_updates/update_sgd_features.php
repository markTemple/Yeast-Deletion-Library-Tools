<?php
// To make sure all the values are up to date, all the data
// in the holding table is dropped. These are then repopulated
// later on in the script
   	$table = 'SGD_features';
	$sql = "TRUNCATE TABLE `$table`";
	mysql_query($sql);
	
// the following statement opens the files called SGD_features.tab
// and reads each line of the file into an array called $readfile

// This line sets the the allowed memory usage of the script to 64M
// to allow the script to run properly on the server when the default
// is set too low
	ini_set("memory_limit","512M");

      $readfile = file("./Raw_files_for_DB/SGD_features.tab");
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

$sgd_id = $fields[0];
$Feature_Type = addslashes("$fields[1]");
$Feature_qualifier = addslashes("$fields[2]");
$Feature_Name = addslashes("$fields[3]");
$Standard_gene_name = addslashes("$fields[4]");
$Alias = addslashes("$fields[5]");
$Parent_feature_name = addslashes("$fields[6]");
$Secondary_SGDID = addslashes("$fields[7]");
$Chromosome = addslashes("$fields[8]");
$Start_coordinate = addslashes("$fields[9]");
$Stop_coordinate = addslashes("$fields[10]");
$Strand = addslashes("$fields[11]");
$Genetic_position = addslashes("$fields[12]");
$Coordinate_version = addslashes("$fields[13]");
$Sequence_version = addslashes("$fields[14]");
$Description = trim(addslashes("$fields[15]"));

$feature_link = '<a href="http://www.yeastgenome.org/cgi-bin/locus.fpl?dbid='.$sgd_id.'">'.$Feature_Name.'</a>';
//$feature_link = 'http://www.yeastgenome.org/cgi-bin/locus.fpl?dbid='.$SGDID;
				
		if($Feature_Name == 'YIL154C') {$Standard_gene_name = 'IMP2';}
		if($Feature_Type == 'ORF') {// insert only ORFs into database

		$insert = mysql_query("
		INSERT INTO SGD_features (sgd_id, Feature_Type, Feature_qualifier, Feature_Name, Standard_gene_name, Alias, Parent_feature_name, Secondary_SGDID, Chromosome, Start_coordinate, Stop_coordinate, Strand, Genetic_position, Coordinate_version, Sequence_version, Description, feature_link) 
		VALUES ('$sgd_id', '$Feature_Type', '$Feature_qualifier', '$Feature_Name', '$Standard_gene_name', '$Alias', '$Parent_feature_name', '$Secondary_SGDID', '$Chromosome', '$Start_coordinate', '$Stop_coordinate', '$Strand', '$Genetic_position', '$Coordinate_version', '$Sequence_version', '$Description', '$feature_link')
		")or die(mysql_error());	
		}
}
	print "<p>Data has been sucessfully updated to the database!</p>";

?>
