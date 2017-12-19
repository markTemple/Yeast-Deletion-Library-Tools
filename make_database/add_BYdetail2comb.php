<?php
	require_once('./header.php');
?>	

<?php
echo '<br />';
echo '<br />';
	
$query = 'ALTER TABLE sgd_features ADD COLUMN Deletant char(13)'; 
mysql_query($query)or die(mysql_error()); 


$readfile = file("../Raw_files_for_DB/YDL/Essential_ORFs.txt");

//$k0, $k1 refer to header crap
for ($k=2; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);

	$Ess_ORF = strtoupper(trim($fields[1]));
	
	mysql_query("
		UPDATE
			sgd_features 
		SET 
			Deletant = 'Essential'
		WHERE
			Feature_Name = '".$Ess_ORF."'	
		")or die(mysql_error());
}	

$readfile = file("../Raw_files_for_DB/YDL/ORFs_not_available.txt");

//$k0-$k5 refer to header crap
for ($k=5; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);

	$NA_ORF = strtoupper(trim($fields[0]));
	
	mysql_query("
		UPDATE
			sgd_features 
		SET 
			Deletant = 'not available'
		WHERE
			Feature_Name = '".$NA_ORF."'	
		")or die(mysql_error());
}	

$readfile = file("../Raw_files_for_DB/YDL/strain_homozygous_diploid.txt");

//$k0, $k1 refer to header crap
for ($k=2; $k<=count($readfile)-1; $k++) {
echo $k;
    $fields = explode("\t",$readfile[$k]);

	$HO_dip = strtoupper(trim($fields[1]));
	
	mysql_query("
		UPDATE
			sgd_features 
		SET 
			Deletant = 'Not Essential'
		WHERE
			Feature_Name = '".$HO_dip."'	
		")or die(mysql_error());
}	

?>
<?php
	require_once('./footer.php');
?>	
