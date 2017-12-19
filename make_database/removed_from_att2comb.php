<?php
drop_table('interaction_lists');
create_interaction_lists();
print(show_one_table('interaction_lists'));	
echo '<br>';
	
$MYSQLquery = 'SELECT DISTINCT Feature_Name, Gene_Name, SGDID FROM combined_data';

$result_comb_data = mysql_query($MYSQLquery)or die(mysql_error()); 
//while ($array_comb_data = mysql_fetch_assoc($result_comb_data))
//{
//	if( (empty($array_comb_data['Feature_Name'])) and (empty($array_comb_data['Gene_Name'])) ){
//		mysql_query("
//		DELETE FROM combined_data  
//		WHERE comdatID = '".$array_comb_data['comdatID']."'
//		")or die(mysql_error());	
//	}
//}



$result_comb_data = mysql_query($MYSQLquery)or die(mysql_error()); 

////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
///////////////////////////////////////////////////////
//    lookup genename/alias and replace from SGD      //
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////


//begin to lookup other data that can be added to existing database 'combined_data'
while ($array_comb_data = mysql_fetch_assoc($result_comb_data))
{

$ORF = $array_comb_data['Feature_Name'];
$Gene_Name = $array_comb_data['Gene_Name'];
$SGDID = $array_comb_data['SGDID'];
	mysql_query("
	INSERT INTO interaction_lists
	(Feature_Name, Gene_Name, SGDID) VALUES ('".$ORF."','".$Gene_Name."','".$SGDID."')
	") or die(mysql_error()); 	



//count the number of interaction on a gene by gene basis	
//for each gene in conm_data lookup this... ie do this whole script 32,000 times!!!
	$result_Interaction_data = mysql_query("
	SELECT 
		Feature_Name_Bait,
		Standard_Gene_Name_Bait, 
		Feature_Name_Hit,
		Standard_Gene_Name_Hit,
		Experiment_Type,
		Genetic_or_Physical_Interaction,
		DeletantFNH,
		DeletantFNB
	FROM 
		interaction_data
	WHERE 
		interaction_data.Feature_Name_Bait = '".$ORF."'
	OR 	interaction_data.Feature_Name_Hit = '".$ORF."'
	")or die(mysql_error()); 
	
/*	this was removed from above query to only show gene of interest as bait
	basically to speed up query
	Also all but y2h and sl have been purged when makinh table in first place
	
	
	ORDER BY 
		Genetic_or_Physical_Interaction
*/	
	unset($array_Interaction_data);
	
	while ($array_Interaction_data = mysql_fetch_assoc($result_Interaction_data))
	{
		$colour = 'Grey';
		
		switch ($array_Interaction_data['Genetic_or_Physical_Interaction']) {
			case 'physical interactions':
				if($array_Interaction_data['Feature_Name_Bait'] == "$ORF"){
					$colour = $array_Interaction_data['DeletantFNH'];
					//grab only feature name
					//interactiopn has now been processed to put orf into gene name if gene name was null
					//therfore no longer need to wast time doing this here!!
					//if(!empty($array_Interaction_data['Standard_Gene_Name_Hit'])){
						$physical = $array_Interaction_data['Standard_Gene_Name_Hit'];
					//}else{
					//	$physical = $array_Interaction_data['Feature_Name_Hit'];
					//}
				}
				//remove this as not selecting interactions if gene is hit only collecting relative to the bait - centre spoke of wheel
				if($array_Interaction_data['Feature_Name_Hit'] == "$ORF"){
					$colour = $array_Interaction_data['DeletantFNB'];
//					if(!empty($array_Interaction_data['Standard_Gene_Name_Bait'])){
						$physical = $array_Interaction_data['Standard_Gene_Name_Bait'];
//					}else{
//						$physical = $array_Interaction_data['Feature_Name_Bait'];
//					}
				}

	//			$phy_array[] = $physical;
				$phy_array[] = '<font color="'.$colour.'">'.$physical.'</font>';
				$phy_array_nocolour[] = $physical;
				$colour = '';
			break;	
			
			case 'genetic interactions':
				if($array_Interaction_data['Feature_Name_Bait'] == "$ORF"){
					$colour = $array_Interaction_data['DeletantFNH'];//grab only feature name
					//if(!empty($array_Interaction_data['Standard_Gene_Name_Hit'])){
						$genetic = $array_Interaction_data['Standard_Gene_Name_Hit'];
					//}else{
					//	$genetic = $array_Interaction_data['Feature_Name_Hit'];
					//}
				}
				if($array_Interaction_data['Feature_Name_Hit'] == "$ORF"){
					$colour = $array_Interaction_data['DeletantFNH'];//grab only feature name
//				
//					if(!empty($array_Interaction_data['Standard_Gene_Name_Bait'])){
						$genetic = $array_Interaction_data['Standard_Gene_Name_Bait'];
//					}else{
//						$genetic = $array_Interaction_data['Feature_Name_Bait'];
//					}
				}

	//			$gen_array[] = $genetic;
				$gen_array[] = '<font color="'.$colour.'">'.$genetic.'</font>';
				$gen_array_nocolour[] = $genetic;
				$colour = '';
			break;	
		}	
	}	
	
//		unset($kv);
//		unset($str);
//		unset($str_k);
//		unset($str_nohtml);
//		unset($sort_by_gene_nc);
		
		$kv = '';
		$str = '';
		$str_k = '';
		$str_nohtml = '';
		$sort_by_gene_nc = '';

	//show_array($phe_array);
	
	//if(count($phy_array) < 1){ 
	if(! isset($phe_array)){
		$Phy_count = 0;
		$str = '';
	}else{
		$Phy_count = count($phy_array);
		//show_array($phy_array);
		$sort_by_gene = array_count_values($phy_array);
		array_multisort($sort_by_gene, SORT_DESC);
		//show_array($sort_by_gene);
		foreach($sort_by_gene as $k => $v){
			$kv = $k.' ('.$v.'), ';
			$str .= $kv;
			$str_k .= $k.', ';
			//add simple (unque gene list)
		}
		
		//put list of ppi to be used to match against ppi to calc p vale later
		$sort_by_gene_nc = array_count_values($phy_array_nocolour);
		array_multisort($sort_by_gene_nc, SORT_DESC);
		
		foreach($sort_by_gene_nc as $k => $v){
			$str_nohtml .= $k.', ';
			//add simple (unque gene list)
		}
		$str = mysql_real_escape_string($str);
		$str_k = mysql_real_escape_string($str_k);
		$str_nohtml = mysql_real_escape_string($str_nohtml);
	}

	mysql_query("
	UPDATE interaction_lists SET 
	OneGenePPI_Phy_cnt = '".$Phy_count."',
	OneGenePPI_Phy_NN = '".$str."',
	OneGenePPI_Phy_NN_unique = '".$str_k."',
	OneGenePPI_Phy_NN_uniqueB = '".$str_nohtml."'
	WHERE Feature_Name = '".$ORF."'
	") or die(mysql_error()); 	

	unset($phy_array);
	unset($phy_array_nocolour);
	
//		unset($kv);
//		unset($str);
//		unset($str_k);
//		unset($str_nohtml);
//		unset($sort_by_gene_nc);
		
		$kv = '';
		$str = '';
		$str_k = '';
		$str_nohtml = '';
		$sort_by_gene_nc = '';


//no do the same for the genetic interactiopns
	//if(count($gen_array) < 1){ 
	if(! isset($gen_array)){
		$Gen_count = 0;
		$str = '';
	}else{
		$Gen_count = count($gen_array);
		$sort_by_gene = array_count_values($gen_array);
		array_multisort($sort_by_gene, SORT_DESC);
		
		foreach($sort_by_gene as $k => $v){
			$kv = $k.' ('.$v.'), ';
			$str .= $kv;
			$str_k .= $k.', ';
		}
		
		//put list of ppi to be used to match against ppi to calc p vale later
		$sort_by_gene_nc = array_count_values($gen_array_nocolour);
		array_multisort($sort_by_gene_nc, SORT_DESC);
		
		foreach($sort_by_gene_nc as $k => $v){
			$str_nohtml .= $k.', ';
			//add simple (unque gene list)
		}
		$str = mysql_real_escape_string($str);
		$str_k = mysql_real_escape_string($str_k);
		$str_nohtml = mysql_real_escape_string($str_nohtml);
	}
	
	mysql_query("
	UPDATE interaction_lists SET 
	OneGenePPI_Gen_cnt = '".$Gen_count."',
	OneGenePPI_Gen_NN = '".$str."',
	OneGenePPI_Gen_NN_unique = '".$str_k."',
	OneGenePPI_Gen_NN_uniqueB = '".$str_nohtml."'
	WHERE Feature_Name = '".$ORF."'
	") or die(mysql_error()); 	
	
	unset($gen_array);
	unset($gen_array_nocolour);

}
//print(show_one_table('interaction_lists'));	


//Delete rows if there are no entries in both phy and gen interactions
$MYSQLqueryI = 'SELECT OneGenePPI_Phy_cnt, OneGenePPI_Gen_cnt, intlistID FROM interaction_lists';

$result_int_list = mysql_query($MYSQLqueryI)or die(mysql_error()); 
while ($array_int_list = mysql_fetch_assoc($result_int_list))
{
	if( ( ($array_int_list['OneGenePPI_Phy_cnt'] == '0') ) and ( ($array_int_list['OneGenePPI_Gen_cnt'] == '0') ) ){
		mysql_query("
		DELETE FROM interaction_lists  
		WHERE intlistID = '".$array_int_list['intlistID']."'
		")or die(mysql_error());	
	}
}
//print(show_one_table('interaction_lists'));	


?>	