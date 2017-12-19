<?php
set_time_limit (0);

$MYSQLquery = 'SELECT Feature_Name, Gene_Name, SGDID, comdatID FROM combined_data';

$result_comb_data = mysql_query($MYSQLquery)or die(mysql_error()); 
while ($array_comb_data = mysql_fetch_assoc($result_comb_data))
{
	if( (empty($array_comb_data['Feature_Name'])) and (empty($array_comb_data['Gene_Name'])) ){
		mysql_query("
		DELETE FROM combined_data  
		WHERE comdatID = '".$array_comb_data['comdatID']."'
		")or die(mysql_error());	
	}
}

$result_comb_data = mysql_query($MYSQLquery)or die(mysql_error()); 


////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
//    lookup genename/alias and replace from SGD      //
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////


//begin to lookup other data that can be added to existing database 'combined_data'
while ($array_comb_data = mysql_fetch_assoc($result_comb_data))
{
	$ORF = $array_comb_data['Feature_Name'];
//	$gene = $array_comb_data['Gene_Name'];
	$SGDID = $array_comb_data['SGDID'];
	

	$result2 = mysql_query("
		SELECT 
			sgd_id,
			Feature_Type,
			Feature_qualifier,	
			Feature_Name,
			Standard_gene_name,
			Parent_feature_name,
			Start_coordinate,
			Stop_coordinate,
			Strand,
			Genetic_position,
			Description,
			feature_link
		FROM 
			SGD_features
		WHERE
			SGD_features.sgd_id = '".$SGDID."'
	")or die(mysql_error()); 
	
//			SGD_features.Feature_Name = '".$ORF."'

	while ($array_sgd_feat = mysql_fetch_assoc($result2))
	{
		$array_sgd_feat['Description'] = mysql_real_escape_string($array_sgd_feat['Description']);
			
		if($array_sgd_feat['Strand'] == 'W'){
			$Gene_len_bp = ($array_sgd_feat['Stop_coordinate'] - $array_sgd_feat['Start_coordinate']);
		}
		if($array_sgd_feat['Strand'] == 'C'){
			$Gene_len_bp = ($array_sgd_feat['Start_coordinate'] - $array_sgd_feat['Stop_coordinate']);
		}
		
	mysql_query("
	UPDATE combined_data SET 
	SGD_Feature_qualifier = '".$array_sgd_feat['Feature_qualifier']."',
	SGD_Parent_feature_name = '".$array_sgd_feat['Parent_feature_name']."',
	SGD_Start_coordinate = '".$array_sgd_feat['Start_coordinate']."',
	SGD_Stop_coordinate = '".$array_sgd_feat['Stop_coordinate']."',
	SGD_Strand = '".$array_sgd_feat['Strand']."',
	SGD_Description = '".$array_sgd_feat['Description']."',
	Gene_len_bp = '".$Gene_len_bp."'	
	WHERE comdatID = '".$array_comb_data['comdatID']."'
	") or die(mysql_error()); 
	}	
	
//	$num_results = mysql_num_rows($result2); 
	
//	if($num_results < 1){ 
	//check this.... checked it does nothing!
//	}

$result_go_slim = mysql_query("
	SELECT 
		GO_Aspect, GO_Slim_term, GOID, SGDID		
	FROM 
		go_slim_mapping		
	WHERE
		go_slim_mapping.SGDID = '".$SGDID."'
	Order BY
		GO_Aspect, GO_Slim_term
	")or die(mysql_error()); 
	
	unset($array_go_slim);

	while ($array_go_slim = mysql_fetch_assoc($result_go_slim))
	{

	switch ($array_go_slim['GO_Aspect']) {
		case 'P':
			$P_aspect = 'Process';
			$P_term[] = $array_go_slim['GO_Slim_term'];
			//$P_id[] = $array_go_slim['GOID'];
		break;	
		case 'C':
			$C_aspect = 'Component';
			$C_term[] = $array_go_slim['GO_Slim_term'];
			//$C_id[] = $array_go_slim['GOID'];
		break;	
		case 'F':
			$F_aspect = 'Function';
			$F_term[] = $array_go_slim['GO_Slim_term'];
			//$F_id[] = $array_go_slim['GOID'];
		break;	
		}
	}	
	
	if(! isset ($P_term)){
	//if(count($P_term) < 1){ 
		$countP = 0;	
		$comma_separated_P = '';	
	}else{
		$countP = count($P_term);
		$comma_separated_P = implode(", ", $P_term);
	}	
	mysql_query("
	UPDATE combined_data SET 
	OneGeneGO_Pcnt = '".$countP."',
	OneGeneGO_P_terms = '".$comma_separated_P."'
	WHERE comdatID = '".$array_comb_data['comdatID']."'
	") or die(mysql_error()); 	
	unset($P_term);
	unset($comma_separated_P);
	unset($countP);

	if(! isset ($C_term)){
	//if(count($C_term) < 1){ 
		$countC = 0;	
		$comma_separated_C = '';	
	}else{
		$countC = count($C_term);
		$comma_separated_C = implode(", ", $C_term);
	}	
	mysql_query("
	UPDATE combined_data SET 
	OneGeneGO_Ccnt = '".$countC."',
	OneGeneGO_C_terms = '".$comma_separated_C."'
	WHERE comdatID = '".$array_comb_data['comdatID']."'
	") or die(mysql_error()); 	
	unset($C_term);
	unset($comma_separated_C);
	unset($countC);

	if(! isset ($F_term)){
	//if(count($F_term) < 1){ 
		$countF = 0;	
		$comma_separated_F = '';	
	}else{
		$countF = count($F_term);
		$comma_separated_F = implode(", ", $F_term);
	}	
	mysql_query("
	UPDATE combined_data SET 
	OneGeneGO_Fcnt = '".$countF."',
	OneGeneGO_F_terms = '".$comma_separated_F."'
	WHERE comdatID = '".$array_comb_data['comdatID']."'
	") or die(mysql_error()); 	
	unset($F_term);
	unset($comma_separated_F);
	unset($countF);
	
}

//again another hack to get rid of that stupis  character from the dreaded IMP2' to IMP2
mysql_query("
UPDATE 
combined_data 
SET 
Gene_Name = 'IMP2' 
WHERE 
SGDID = 'S000001416'  
")or die(mysql_error());	

// include all text from "removed_from_att2comb"
include('removed_from_att2comb.php');


mysql_query("
UPDATE combined_data
INNER JOIN interaction_lists 
ON combined_data.SGDID = interaction_lists.SGDID
SET 
	combined_data.OneGenePPI_Phy_cnt 		= interaction_lists.OneGenePPI_Phy_cnt,
	combined_data.OneGenePPI_Phy_NN 		= interaction_lists.OneGenePPI_Phy_NN,
	combined_data.OneGenePPI_Phy_NN_unique 	= interaction_lists.OneGenePPI_Phy_NN_unique,
	combined_data.OneGenePPI_Phy_NN_uniqueB = interaction_lists.OneGenePPI_Phy_NN_uniqueB,
	combined_data.OneGenePPI_Gen_cnt 		= interaction_lists.OneGenePPI_Gen_cnt,
	combined_data.OneGenePPI_Gen_NN 		= interaction_lists.OneGenePPI_Gen_NN,
	combined_data.OneGenePPI_Gen_NN_unique 	= interaction_lists.OneGenePPI_Gen_NN_unique,
	combined_data.OneGenePPI_Gen_NN_uniqueB = interaction_lists.OneGenePPI_Gen_NN_uniqueB
")or die(mysql_error());	


//for each entry simply get the list from new table and put into comb_data

//eg lookup SGDID from interactiopn list and Ccomb data
?>
