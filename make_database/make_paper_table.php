<?php
ini_set("memory_limit","1500M");
set_time_limit (0);

$db_row_count = 0;

drop_table('comb_paper_data');
create_MYSQL_comb_paper_data();// create mysql table	

//select each and every distince phenotype
$MYSQLquery01 = "
	SELECT 
	DISTINCT paperID, phenotypeID, PubMed_ID_link, PubMed_ID, PheChem, citation
	FROM combined_data
";

$result = mysql_query($MYSQLquery01)or die(mysql_error()); 
while ($array = mysql_fetch_assoc($result))
{
	$array['PheChem'] = mysql_real_escape_string($array['PheChem']);
	$PheChem_lists[] = $array['PheChem'];
	$PubMed_ID_lists[] = $array['PubMed_ID'];//changed from link at this point
	$citation_lists[] = $array['citation'];

	
	$MYSQLquery02 = "
	SELECT Gene_Name, Feature_Name, PubMed_ID_link, OneGeneGO_F_terms, OneGeneGO_P_terms, OneGeneGO_C_terms, OneGenePPI_Gen_NN_unique, OneGenePPI_Gen_cnt, OneGenePPI_Gen_NN, OneGenePPI_Phy_NN_unique, OneGenePPI_Phy_cnt, OneGenePPI_Phy_NN 
	FROM combined_data
	WHERE phenotypeID = '".$array['phenotypeID']."'";
		
	unset($gene_list);
	unset($OneGenePPI_Phy_NN_unique_list);
	unset($OneGenePPI_Gen_NN_unique_list);
	unset($OneGeneGO_P_terms_list);
	unset($OneGeneGO_F_terms_list);
	unset($OneGeneGO_C_terms_list);
	
	unset($phenotypeID_list);

	$result02 = mysql_query($MYSQLquery02)or die(mysql_error());
		 	
	while ($array02 = mysql_fetch_assoc($result02))
	{		
	//echo $array02['OneGenePPI_Phy_cnt'];
			
		if(!empty($array02['Gene_Name'])){
		$gene_list[] = $array02['Gene_Name'];
		}else{
		$gene_list[] = $array02['Feature_Name'];
		}

		$PubMed_ID_link_list[] = $array02['PubMed_ID_link']; 
		$OneGeneGO_F_terms_list[] = $array02['OneGeneGO_F_terms'];
//		$OneGeneGO_Pcnt_list[] = $array02['OneGeneGO_Pcnt'];
		$OneGeneGO_P_terms_list[] = $array02['OneGeneGO_P_terms'];
//		$OneGeneGO_Ccnt_list[] = $array02['OneGeneGO_Ccnt'];
		$OneGeneGO_C_terms_list[] = $array02['OneGeneGO_C_terms'];
//		$Protein_Abundance_list[] = $array02['Protein_Abundance']; 
		$OneGenePPI_Phy_cnt_list[] = $array02['OneGenePPI_Phy_cnt'];
		$OneGenePPI_Gen_cnt_list[] = $array02['OneGenePPI_Gen_cnt'];
		$OneGenePPI_Phy_NN_list[] = $array02['OneGenePPI_Phy_NN'];
		$OneGenePPI_Gen_NN_list[] = $array02['OneGenePPI_Gen_NN']; 	
		$OneGenePPI_Gen_NN_unique_list[] = $array02['OneGenePPI_Gen_NN_unique'];//changes to B no html
		$OneGenePPI_Phy_NN_unique_list[] = $array02['OneGenePPI_Phy_NN_unique']; 
	}
	
	$phenotype_gene_lists[] = $gene_list;
	$Phenotype_PPI_Phy_NN_unique_lists[] = $OneGenePPI_Phy_NN_unique_list; 
	$Phenotype_PPI_Gen_NN_unique_lists[] = $OneGenePPI_Gen_NN_unique_list; 
	$Phenotype_GO_P_terms_lists[] = $OneGeneGO_P_terms_list; 
	$Phenotype_GO_F_terms_lists[] = $OneGeneGO_F_terms_list; 
	$Phenotype_GO_C_terms_lists[] = $OneGeneGO_C_terms_list; 
	
	$phenotypeID_lists[] = $array['phenotypeID']; 
	$paperID_lists[] = $array['paperID']; 
	
}

//show_array($Phenotype_PPI_Phy_NN_unique_lists);

//i think there is one row for each gene
for ( $counter = 1; $counter <= count($phenotype_gene_lists); $counter += 1) {//scroll through each geneset
	$count = $counter-1;
	
	mysql_query("
	INSERT INTO comb_paper_data (phenotypeID) 
	VALUES ('".$phenotypeID_lists["$count"]."' )  
	")or die(mysql_error());

	$phenotype_gene_lists["$count"] = array_unique($phenotype_gene_lists["$count"]);
	$n = count($phenotype_gene_lists["$count"]);

	$gene_strA = implode(', ', $phenotype_gene_lists["$count"]);
	$gene_strA = mysql_real_escape_string($gene_strA);
	
	//show_array($phenotype_gene_lists["$count"] );
	
	
	$attributes_array = array(
	'Phenotype_GO_P_terms_lists',
	'Phenotype_GO_F_terms_lists',
	'Phenotype_GO_C_terms_lists'
	);
		
	$keys = array_keys($phenotype_gene_lists["$count"]);

	$N = 4600;
	$M_new = $n;//ie no change!
	$GOterm_pfilter = 0.1;
	$man_patch = 'n';

	//$type = 'GO';
	foreach($attributes_array as $k => $v){
		$GOintersect = get_list(${$v}, $keys, $count, $N, $M_new, $GOterm_pfilter, $man_patch);
		//				echo $GOintersect;
		//				echo '<br />';
		//collect term count here
//		$v = 'inter_'.$v;
		
		mysql_query("
		UPDATE
		comb_paper_data 
		SET 
		".$v." = '".$GOintersect."' 
		WHERE
		phenotypeID = '".$phenotypeID_lists["$count"]."'
		")or die(mysql_error());
	}

//will need their own ppi lookup not in GO terms query!!!!!
	$attributes_array = NULL;
	$attributes_array = array(
	'Phenotype_PPI_Phy_NN_unique_lists', 
	'Phenotype_PPI_Gen_NN_unique_lists'	
	);

//	$type = 'PPI';
	foreach($attributes_array as $k => $v){
		$PPIintersect = get_list_interaction(${$v}, $keys, $count, $N, $M_new, $GOterm_pfilter, $man_patch);
						//echo $PPIintersect;
						//echo '<br />';
		//collect term count here
//		$v = 'inter_'.$v;
		
		//echo $PPIintersect;
		
		mysql_query("
		UPDATE
		comb_paper_data 
		SET 
		".$v." = '".$PPIintersect."' 
		WHERE
		phenotypeID = '".$phenotypeID_lists["$count"]."'
		")or die(mysql_error());
	}

	$phe_counts = count_similar_phe($phenotypeID_lists["$count"]);

	//collect most data for MySQL database (comb_data intersection)
	mysql_query("
	UPDATE
	comb_paper_data 
	SET 
	paperID = '".$paperID_lists["$count"]."',
	PubMed_ID = '".$PubMed_ID_lists["$count"]."',
	citation = '".$citation_lists["$count"]."', 
	phenotype = '".$PheChem_lists["$count"]."', 
	count = '".$n."',
	genelist = '".$gene_strA."',
	similar_phe = '".$phe_counts[0]['countPhe']."'
	WHERE
	phenotypeID = '".$phenotypeID_lists["$count"]."'
	")or die(mysql_error());

$db_row_count++;		
}
		
	
?>
