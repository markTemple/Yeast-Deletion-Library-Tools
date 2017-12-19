<?php
// To make sure all the values are up to date, all the data
// in the holding table is dropped. These are then repopulated
// later on in the script
   	$table = 'protein_properties';
	$sql = "TRUNCATE TABLE `$table`";
	mysql_query($sql);
	
// the following statement opens the files called SGD_features.tab
// and reads each line of the file into an array called $readfile

// This line sets the the allowed memory usage of the script to 64M
// to allow the script to run properly on the server when the default
// is set too low
	ini_set("memory_limit","512M");

      $readfile = file("./Raw_files_for_DB/protein_properties.tab");
//	  show_array($readfile); //good
// Each line will be accessed by it's position in the array
// $readfile[0] would be the first line because the array begins at 0
// rather than 1

// Create a loop that will read all elements of the array and print out
// each field of the tab-delimited text file

for ($k=0; $k<=count($readfile)-1; $k++) {
    $fields = explode("\t",$readfile[$k]);
	
$FEATURE = addslashes("$fields[0]");
$SGDID = addslashes("$fields[1]");
$MOLECULAR_WEIGHT = addslashes("$fields[2]");
$PI = addslashes("$fields[3]");
$CAI = addslashes("$fields[4]");
$PROTEIN_LENGTH = addslashes("$fields[5]");
$N_TERM_SEQ = addslashes("$fields[6]");
$C_TERM_SEQ = addslashes("$fields[7]");
$CODON_BIAS = addslashes("$fields[8]");
$ALA = addslashes("$fields[9]");
$ARG = addslashes("$fields[10]");
$ASN = addslashes("$fields[11]");
$ASP = addslashes("$fields[12]");
$CYS = addslashes("$fields[13]");
$GLN = addslashes("$fields[14]");
$GLU = addslashes("$fields[15]");
$GLY = addslashes("$fields[16]");
$HIS = addslashes("$fields[17]");
$ILE = addslashes("$fields[18]");
$LEU = addslashes("$fields[19]");
$LYS = addslashes("$fields[20]");
$MET = addslashes("$fields[21]");
$PHE = addslashes("$fields[22]");
$PRO = addslashes("$fields[23]");
$SER = addslashes("$fields[24]");
$THR = addslashes("$fields[25]");
$TRP = addslashes("$fields[26]");
$TYR = addslashes("$fields[27]");
$VAL = addslashes("$fields[28]");
$FOP_SCORE = addslashes("$fields[29]");
$GRAVY_SCORE = addslashes("$fields[30]");
$AROMATICITY = addslashes("$fields[31]");

		$insert = mysql_query("
		INSERT INTO protein_properties (FEATURE, SGDID, MOLECULAR_WEIGHT, PI, CAI, PROTEIN_LENGTH, N_TERM_SEQ, C_TERM_SEQ, CODON_BIAS, ALA, ARG, ASN, ASP, CYS, GLN, GLU, GLY, HIS, ILE, LEU, LYS, MET, PHE, PRO, SER, THR, TRP, TYR, VAL, FOP_SCORE, GRAVY_SCORE, AROMATICITY) 
		VALUES ('$FEATURE', '$SGDID', '$MOLECULAR_WEIGHT', '$PI', '$CAI', '$PROTEIN_LENGTH', '$N_TERM_SEQ', '$C_TERM_SEQ', '$CODON_BIAS', '$ALA', '$ARG', '$ASN', '$ASP', '$CYS', '$GLN', '$GLU', '$GLY', '$HIS', '$ILE', '$LEU', '$LYS', '$MET', '$PHE', '$PRO', '$SER', '$THR', '$TRP', '$TYR', '$VAL', '$FOP_SCORE', '$GRAVY_SCORE', '$AROMATICITY')
		")or die(mysql_error());	

}
	print "<p>Data has been sucessfully updated to the database!</p>";

?>
