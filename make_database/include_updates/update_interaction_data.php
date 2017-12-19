<?php
// To make sure all the values are up to date, all the data
// in the holding table is dropped. These are then repopulated
// later on in the script
   	$table = 'interaction_data';
	$sql = "TRUNCATE TABLE `$table`";
	mysql_query($sql);
	
// the following statement opens the files called SGD_features.tab
// and reads each line of the file into an array called $readfile

// This line sets the the allowed memory usage of the script to 64M
// to allow the script to run properly on the server when the default
// is set too low
	ini_set("memory_limit","512M");

      $readfile = file("./Raw_files_for_DB/interaction_data.tab");
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

	$Feature_Name_Bait = addslashes("$fields[0]");
	$Standard_Gene_Name_Bait = addslashes("$fields[1]");
	
		if(empty($Standard_Gene_Name_Bait)){
		$Standard_Gene_Name_Bait = $Feature_Name_Bait;
	}

	
	$Feature_Name_Hit = addslashes("$fields[2]");
	$Standard_Gene_Name_Hit = addslashes("$fields[3]");
		if(empty($Standard_Gene_Name_Hit)){
		$Standard_Gene_Name_Hit = $Feature_Name_Hit;
	}

	
	$Experiment_Type = addslashes("$fields[4]");
	$Genetic_or_Physical_Interaction = addslashes("$fields[5]");
	//$Source = addslashes("$fields[6]");
	//$Manually_curated_or_High_throughput = addslashes("$fields[7]");
	//$Notes = addslashes("$fields[8]");
	//$Phenotype = addslashes("$fields[9]");
	//$Reference = addslashes("$fields[10]");
	$Citation = addslashes("$fields[11]");
	
	
	//if($Experiment_Type == "Two-hybrid" or $Experiment_Type == "Synthetic Lethality"){
		
		$insert = mysql_query("
		INSERT INTO interaction_data (Feature_Name_Bait, Standard_Gene_Name_Bait, Feature_Name_Hit,	Standard_Gene_Name_Hit, Experiment_Type, Genetic_or_Physical_Interaction, Citation) 
		VALUES ('$Feature_Name_Bait', '$Standard_Gene_Name_Bait', '$Feature_Name_Hit', '$Standard_Gene_Name_Hit', '$Experiment_Type', '$Genetic_or_Physical_Interaction', '$Citation')  
		")or die(mysql_error());
			
	//}
}
	print "<p>Data has been sucessfully updated to the database!</p>";
	
	
	//switch IMP2' to IMP2
$MYSQLqueryI = 'SELECT Feature_Name_Bait, Standard_Gene_Name_Bait, Feature_Name_Hit, Standard_Gene_Name_Hit, intdat_id FROM interaction_data';

$result_int_data = mysql_query($MYSQLqueryI)or die(mysql_error()); 
while ($array_int_data = mysql_fetch_assoc($result_int_data))
{
	if( ( ($array_int_data['Feature_Name_Bait'] == 'YIL154C') ) ){
		mysql_query("
		UPDATE 
		interaction_data 
		SET 
		Standard_Gene_Name_Bait = 'IMP2' 
		WHERE 
		intdat_id = '".$array_int_data['intdat_id']."'  
		")or die(mysql_error());	
	}
	if( ( ($array_int_data['Feature_Name_Hit'] == 'YIL154C') ) ){
		mysql_query("
		UPDATE 
		interaction_data 
		SET 
		Standard_Gene_Name_Hit = 'IMP2' 
		WHERE 
		intdat_id = '".$array_int_data['intdat_id']."'  
		")or die(mysql_error());	
	}
}	


		//INSERT INTO interaction_data (Feature_Name_Bait, Standard_Gene_Name_Bait, Feature_Name_Hit, Standard_Gene_Name_Hit, Experiment_Type, Genetic_or_Physical_Interaction, Source, Manually_curated_or_High_throughput, Notes, Phenotype, Reference, Citation) 
		//VALUES ('$Feature_Name_Bait', '$Standard_Gene_Name_Bait', '$Feature_Name_Hit', '$Standard_Gene_Name_Hit', '$Experiment_Type', '$Genetic_or_Physical_Interaction', '$Source', '$Manually_curated_or_High_throughput', '$Notes', '$Phenotype', '$Reference', '$Citation')

?>
