<?php
// To make sure all the values are up to date, all the data
// in the holding table is dropped. These are then repopulated
// later on in the script
   	$table = 'gene_literature';
	$sql = "TRUNCATE TABLE `$table`";
	mysql_query($sql);
	
// the following statement opens the files called SGD_features.tab
// and reads each line of the file into an array called $readfile

// This line sets the the allowed memory usage of the script to 64M
// to allow the script to run properly on the server when the default
// is set too low
	ini_set("memory_limit","512M");

      $readfile = file("./Raw_files_for_DB/gene_literature.tab");
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
	$PubMed_ID = $fields[0];
	
	$cit_no_quote = str_replace("'", "", $fields[1]);
	$citation = addslashes("$cit_no_quote");
	
	$gene_name = addslashes("$fields[2]");
	$feature = addslashes("$fields[3]");
	$literature_topic = addslashes("$fields[4]");
	$SGDID = trim($fields[5]);
	
	

$feature_link = '<a href="http://www.yeastgenome.org/cgi-bin/locus.fpl?dbid='.$SGDID.'">'.$SGDID.'</a>';
$citation_link = '<a href="http://www.ncbi.nlm.nih.gov/pubmed?term='.$PubMed_ID.'">'.$PubMed_ID.'</a>';
//$feature_link = 'http://www.yeastgenome.org/cgi-bin/locus.fpl?dbid='.$SGDID;
//$citation_link = 'http://www.ncbi.nlm.nih.gov/pubmed?term='.$PubMed_ID;

// Values are inserted into their respective rows in the holding table.
// If an error occurs the sql query is killed

// native table - direct copy of input file
//	$insert = mysql_query("
//	INSERT INTO gene_literature (PubMed_ID, citation, gene_name, feature, literature_topic, SGDID) 
//	VALUES ($PubMed_ID, $citation, $gene_name, $feature, $literature_topic, $SGDID)
//	")or die(mysql_error());

//	value added table - direct copy of input file plus http links


// edit table to add refs to phenotype table		

//remove this loop to include the GENES
//	if($_POST['PubMed_ID_old'] !== $PubMed_ID){

		$insert = mysql_query("
		INSERT INTO gene_literature (PubMed_ID, citation, gene_name, feature, literature_topic, SGDID, citation_link, feature_link) 
		VALUES ('$PubMed_ID', '$citation', '$gene_name', '$feature', '$literature_topic', '$SGDID', '$citation_link', '$feature_link')
		")or die(mysql_error());	
		
//		$insert = mysql_query("
//		INSERT INTO gene_literature (PubMed_ID, citation, citation_link) 
//		VALUES ('$PubMed_ID', '$citation', '$citation_link')
//		")or die(mysql_error());	
			
//	}
//	$_POST['PubMed_ID_old'] = $PubMed_ID;

}
	print "<p>Data has been sucessfully updated to the database!</p>";

?>
