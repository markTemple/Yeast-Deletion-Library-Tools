<?php

function show_one_table($v)
{

	$table_desc = (describe($v));
	echo '<b>Table Description : </b><br />';
	$index_array = show_index($v);
		foreach($index_array as $index){
		echo $index['Column_name'].' Key_name ='.$index['Key_name'].'<br />';
		}
		foreach($table_desc as $desc){
			echo "[Field] = $desc[Field] ";
			echo "[Type] = $desc[Type] ";
		//	echo "[Null] = $desc[Null] ";
			if($desc['Key'] == 'PRI') echo "[Key] = $desc[Key] ";
		//	echo "[Default] = $desc[Default] ";
			if($desc['Extra'] == 'auto_increment') echo "[Extra] = $desc[Extra] ";
			echo '<br />';
//	echo $v;
		}
		$numb_rows = (select_count($v));
		//show_array($numb_rows);
		echo '<b>Number of rows : </b>';
		foreach($numb_rows as $numb){
			foreach($numb as $v){
			echo '<font color="red"><b>'.$v.'</b><br /></font>';
			}
		}
}

function genename_lookup($feature_name){
//add scripts to replace funny characters that make mysql fail eg '
	$feature_name = trim($feature_name);

	if(preg_match("/[Y][A-Z][A-Z]\d\d\d[W|C]/", $feature_name)){ //lookup as ORF

	$query = sprintf(" SELECT Feature_Name, Standard_gene_name FROM SGD_features WHERE Feature_Name = '$feature_name' ");	
	$Standard_gene_name = get_assoc_array($query);
	
		if($Standard_gene_name[0] != ''){
			return $Standard_gene_name;
		}else{
			//return 'there is no matching Feature_Name';
		}
	}else{
	//lookup as GENE
	$query = sprintf(" SELECT Feature_Name, Standard_gene_name FROM SGD_features WHERE Standard_gene_name = '$feature_name' ");	
	$Standard_gene_name = get_assoc_array($query);
	
		if($Standard_gene_name[0] != ''){
			return $Standard_gene_name;
		}else{
			//return 'there is no matching Standard_gene_name';
		}
	}
	
//	//lookup as ALIAS
//	$query = sprintf(" SELECT Feature_Name, Standard_gene_name FROM SGD_features WHERE Alias = '$feature_name' ");	
//	$Standard_gene_name = get_assoc_array($query);
//	
//		if($Standard_gene_name[0] != ''){
//			return $Standard_gene_name;
//		}else{
//			return 'there is no matching Standard_gene_name';
//		}
//	}
}




//write this as a function
//pass to the function an ordered array
//get from this a series of genelists (and attributes)
//push genelists through some analyses eg lookup or output GO, pathways, position , composition etc
//flag genesets that are interesting (the dreded p-value?)

//$start = 0;
//$window = 0;
//
//for ( $start; $start <= 20; $start += 5) {
////	echo 'start = '.$start;
//	echo "<br />";
//	$window = $start + 1;
//	if($window <= 50){
//		$end = $window + 9;
//		}
//	//echo "<hr />";
//	for ( $window; $window <= $end; $window += 1) {
//	//	echo "<br />";
//		echo 'row = '.$window;
//		echo "<br />";
//	}
//	echo "<br />";
//}
//	echo "<br />";


?>