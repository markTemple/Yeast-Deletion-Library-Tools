<?php

$readfile = file("./Raw_files_for_DB/nature02046-s2.txt");

for ($k=0; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);

	$ORF = addslashes(trim("$fields[0]"));
//	$Observed = $fields[1];
	$Expression = $fields[2];
//	$Molecules_Cell = $fields[3];
//	$STD_Dev = addslashes(trim("$fields[4]"));
//	$CEC = 	addslashes("$fields[5]");
//	$Spurious = addslashes("$fields[6]");

	$Bad=(array("Â", "â€“"));
	$Good=(array("", "-"));
	$ORF = str_replace($Bad, $Good, $ORF);

	mysql_query("
	UPDATE
	combined_data 
	SET 
	Protein_Abundance = '".$Expression."' 
	WHERE
	Feature_Name = '".$ORF."'	
	")or die(mysql_error());
}	

$query = sprintf("
	SELECT DISTINCT
		Feature_Name,
		COUNT(Feature_Name) AS numb
	FROM 
		combined_data
	Group BY
		Feature_Name
	")or die(mysql_error());
	
	$result = get_assoc_array($query);
//show_array($result);

foreach($result as $v){
	mysql_query("
	UPDATE
	combined_data 
	SET 
	Occurence = '".$v['numb']."' 
	WHERE
	Feature_Name = '".$v['Feature_Name']."'	
	")or die(mysql_error());

}
?>
