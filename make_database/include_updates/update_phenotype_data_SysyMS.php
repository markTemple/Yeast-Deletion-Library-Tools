<?php
// To make sure all the values are up to date, all the data
// in the holding table is dropped. These are then repopulated
// later on in the script
   	$table = 'phenotype_data';
	$sql = "TRUNCATE TABLE `$table`";
	mysql_query($sql);
	
// the following statement opens the files called SGD_features.tab
// and reads each line of the file into an array called $readfile

// This line sets the the allowed memory usage of the script to 64M
// to allow the script to run properly on the server when the default
// is set too low
	ini_set("memory_limit","512M");

      $readfile = file("./Raw_files_for_DB/phenotype_data.tab");
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
	
	$Feature_Name = addslashes("$fields[0]");
	$Feature_Type = $fields[1];
	$Gene_Name = addslashes("$fields[2]");
	$SGDID = addslashes("$fields[3]");
	$Reference = addslashes("$fields[4]");
	$Experiment_Type = addslashes("$fields[5]");
	$Mutant_Type = $fields[6];
	$Allele = addslashes("$fields[7]");
	$Strain_Background = addslashes("$fields[8]");
	$Phenotype = mysql_real_escape_string(trim("$fields[9]"));
	$Chemical = mysql_real_escape_string(trim("$fields[10]"));
	$Cond_Mut = mysql_real_escape_string(trim("$fields[11]"));
	$Details = mysql_real_escape_string(trim("$fields[12]"));
	$Reporter = mysql_real_escape_string(trim("$fields[13]"));
		
	if(!empty($Cond_Mut)){ $Chemical .= ' '.$Cond_Mut; }
	if(!empty($Details)){ $Chemical .= ' '.$Details; }
	if(!empty($Reporter)){ $Chemical .= ' '.$Reporter; }

//PMID: 1710619|SGD_REF: S000049146
//split string by |(pipe) or ' '(space)
//show_array($Reference);
$two_refs = explode('|', $Reference);
//show_array($two_refs);

if(! isset ($two_refs[1]) ){
//only one ref present
$SGD_ref = explode(' ', $two_refs[0]);
$SGD_REF = $SGD_ref[1];
$PMID = NULL;
	}else{
//two refs present
$PMID_ref = explode(': ', $two_refs[0]);
$PMID = $PMID_ref[1];
$SGD_ref = explode(': ', $two_refs[1]);
$SGD_REF = $SGD_ref[1];
}

 $feature_link = '<a href="http://www.yeastgenome.org/cgi-bin/locus.fpl?dbid='.$SGDID.'">'.$SGDID.'</a>';
 $PMID_link = '<a href="http://www.ncbi.nlm.nih.gov/pubmed?term='.$PMID.'">'.$PMID.'</a>';

// Values are inserted into their respective rows in the holding table.
// If an error occurs the sql query is killed


//	if($Experiment_Type == 'systematic mutation set'){
//}

// native table - full with http links added
//	$insert = mysql_query("
//	INSERT INTO phenotype_data (Feature_Name, Feature_Type, Gene_Name, SGDID, Ref_PMID, Ref_SGD_REF, Experiment_Type, Mutant_Type, Allele, Strain_Background, Phenotype, Chemical, Cond_Mut, Details, Reporter, feature_link, PMID_link) 
//	VALUES ('$Feature_Name', '$Feature_Type', '$Gene_Name', '$SGDID', '$PMID', '$SGD_REF', '$Experiment_Type', '$Mutant_Type', '$Allele', '$Strain_Background', '$Phenotype', '$Chemical', '$Cond_Mut', '$Details', '$Reporter', '$feature_link', '$PMID_link')
//	")or die(mysql_error());
	
// edited table use this!!
		$insert = mysql_query("
		INSERT INTO phenotype_data (Feature_Name, Gene_Name, SGDID, Ref_PMID, Ref_SGD_REF, Experiment_Type, Phenotype, Chemical, feature_link, PMID_link) 
		VALUES ('$Feature_Name', '$Gene_Name', '$SGDID', '$PMID', '$SGD_REF', '$Experiment_Type', '$Phenotype', '$Chemical', '$feature_link', '$PMID_link')
		")or die(mysql_error());
	
	}	
	print "<p>Data has been sucessfully updated to the database!</p>";

?>
