<?php
// To make sure all the values are up to date, all the data
// in the holding table is dropped. These are then repopulated
// later on in the script
   	$table = 'UWS_del_lib_screen';
	$sql = "TRUNCATE TABLE `$table`";
	mysql_query($sql);
	
// the following statement opens the files called SGD_features.tab
// and reads each line of the file into an array called $readfile

// This line sets the the allowed memory usage of the script to 64M
// to allow the script to run properly on the server when the default
// is set too low
	ini_set("memory_limit","512M");


//save excel worksheel as tab delimited file txt
//open this file in text wrangler
//save as both UNIX (LF) ans UNICODE UTF-8 (not UTF-16 no BOM) or querys didn't work
//remove funny characters on case by case basis with str_replace!
//this fixed carridge line return issue from excel

      $readfile = file("./Raw_files_for_DB/UWS_Del_Lib_Screen.txt");
	  //show_array($readfile); //good
          echo "remember to set line feed to LF not CR";
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

//Feature_Name	Feature_Type	Gene_Name	SGDID	Ref_PMID	Ref_SGD_REF	Experiment_Type	Mutant_Type	Allele	Strain_Background	Phenotype	Chemical	Cond_Mut	Details	citation	


	$pre_Feature_Name = addslashes(strtoupper(trim("$fields[0]")));
	
	$Feature_Type = $fields[1];
	$Gene_Name = addslashes(strtoupper(trim("$fields[2]")));
	$SGDID = addslashes("$fields[3]");

$PMID = addslashes(trim("$fields[4]"));
$SGD_REF = 	addslashes("$fields[5]");
	
	$Experiment_Type = addslashes("$fields[6]");
	$Mutant_Type = $fields[7];
//	$Allele = addslashes("$fields[8]");
//	$Strain_Background = addslashes("$fields[9]");
	$Phenotype = addslashes("$fields[8]");
	$pre_Chem = addslashes("$fields[9]");
	$Cond_Mut = addslashes("$fields[10]");
	$Details = addslashes("$fields[11]");
	$pre_cit = trim(addslashes("$fields[12]"));
//	$citation = str_replace(array("\r\n", "\r", "\n", "\t"), "\n", $cit);
//$search  = array('�', '"');

//$Bad=(array("�", "–"));
$Bad=(array("-", "-"));
$Good=(array("", "-"));
$citation = str_replace($Bad, $Good, $pre_cit);
$Chemical = str_replace($Bad, $Good, $pre_Chem);
$Feature_Name = str_replace($Bad, $Good, $pre_Feature_Name);

if(strlen($Feature_Name) == 8){// add dash to orf name
	$Feature_Name = substr($Feature_Name,0,7).'-'.substr($Feature_Name,7,1);
	}

//$Gene_Name = str_replace("'", "", $Gene_Name);

$feature_link = '<a href="http://www.yeastgenome.org/cgi-bin/locus.fpl?dbid='.$SGDID.'">'.$SGDID.'</a>';
$citation_link = '<a href="http://www.ncbi.nlm.nih.gov/pubmed?term='.$PMID.'">'.$PMID.'</a>';
	
		$insert = mysql_query("
		INSERT INTO UWS_Del_Lib_Screen (Feature_Name, Gene_Name, SGDID, feature_link, Ref_PMID, citation_link, Experiment_Type, Phenotype, Chemical, citation) 
		VALUES ('$Feature_Name', '$Gene_Name', '$SGDID', '$feature_link', '$PMID', '$citation_link', '$Experiment_Type', '$Phenotype', '$Chemical', '$citation')
		")or die(mysql_error());
	
}

		mysql_query("
		UPDATE 
		UWS_Del_Lib_Screen 
		SET 
		Gene_Name = 'OCT1' 
		WHERE 
		Feature_Name = 'YKL134C'  
		")or die(mysql_error());	


	print "<p>Data has been sucessfully updated to the database!</p>";

?>
