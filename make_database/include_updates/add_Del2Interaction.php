<?php
$readfile = file("./Raw_files_for_DB/YDL/Essential_ORFs.txt");

//$k0, $k1 refer to header crap
for ($k=2; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);

	if(! isset( $fields[1]) ){
		$fields[1] = null;
	}

	$Ess_ORF = strtoupper(trim($fields[1]));
	
	mysql_query("
	UPDATE
		interaction_data 
	SET 
		DeletantFNH = 'Red'
	WHERE
		Feature_Name_Hit = '".$Ess_ORF."'	
	")or die(mysql_error());
}	
for ($k=2; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);

	if(! isset( $fields[1]) ){
		$fields[1] = null;
	}

	$Ess_ORF = strtoupper(trim($fields[1]));
	
	mysql_query("
	UPDATE
		interaction_data 
	SET 
		DeletantFNB = 'Red'
	WHERE
		Feature_Name_Bait = '".$Ess_ORF."'	
	")or die(mysql_error());
}	


$readfile = file("./Raw_files_for_DB/YDL/ORFs_not_available.txt");

//$k0-$k5 refer to header crap
for ($k=5; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);

	$NA_ORF = strtoupper(trim($fields[0]));
	
	mysql_query("
	UPDATE
		interaction_data 
	SET 
		DeletantFNH = 'Blue'
	WHERE
		Feature_Name_Hit = '".$NA_ORF."'	
	")or die(mysql_error());
}	
for ($k=5; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);

	$NA_ORF = strtoupper(trim($fields[0]));
	
	mysql_query("
	UPDATE
		interaction_data 
	SET 
		DeletantFNB = 'Blue'
	WHERE
		Feature_Name_Bait = '".$NA_ORF."'	
	")or die(mysql_error());
}	

$readfile = file("./Raw_files_for_DB/YDL/strain_homozygous_diploid.txt");

//$k0, $k1 refer to header crap
for ($k=2; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);

	$HO_dip = strtoupper(trim($fields[1]));
	
	mysql_query("
	UPDATE
		interaction_data 
	SET 
		DeletantFNH = 'Black'
	WHERE
		Feature_Name_Hit = '".$HO_dip."'	
	")or die(mysql_error());
}	
for ($k=2; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);

	$HO_dip = strtoupper(trim($fields[1]));
	
	mysql_query("
	UPDATE
		interaction_data 
	SET 
		DeletantFNB = 'Black'
	WHERE
		Feature_Name_Bait = '".$HO_dip."'	
	")or die(mysql_error());
}
	
