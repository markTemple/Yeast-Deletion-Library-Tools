<?php
ini_set("memory_limit","1500M");
set_time_limit (0);

echo 'p value cutoff = '.$cutoff = 0.000000000001;
//echo 'p value cutoff = '.$cutoff = 0.1;
echo '<br />';
echo 'genes in total = '.$N = 4600;
$db_row_count = 1;
drop_table('intersection_data');
create_MYSQL_intersection_data();// create mysql table	
echo'<br />';

//select each and every distince phenotype
$MYSQLquery01 = "SELECT DISTINCT phenotypeID, PubMed_ID_link, PubMed_ID, PheChem, citation FROM  combined_data"; 

//for testing purpose limit query to run faster ie swith to query 02 below
//$MYSQLquery02 = "SELECT DISTINCT phenotypeID, PubMed_ID_link, PubMed_ID, PheChem, 
//citation FROM combined_data LIMIT 50";

$result = mysql_query($MYSQLquery01)or die(mysql_error()); 

while ($array_eachPHE_combData = mysql_fetch_assoc($result))
{

	$array_eachPHE_combData['PheChem'] = mysql_real_escape_string($array_eachPHE_combData['PheChem']);
	$PheChem_lists[] = $array_eachPHE_combData['PheChem'];
	$PubMed_ID_lists[] = $array_eachPHE_combData['PubMed_ID'];//changed from link at this point
	$citation_lists[] = $array_eachPHE_combData['citation'];
	$phenotypeID_lists[] = $array_eachPHE_combData['phenotypeID'];//new to be used to simplify lookups and passing data

	$MYSQLquery02 = "SELECT
	phenotypeID, Gene_Name, Feature_Name, PubMed_ID_link, 
	OneGeneGO_F_terms, OneGeneGO_P_terms, OneGeneGO_C_terms, 
	OneGenePPI_Gen_NN_unique, OneGenePPI_Phy_NN_unique
	FROM combined_data
	WHERE phenotypeID = '".$array_eachPHE_combData['phenotypeID']."'";
	
	$result02 = mysql_query($MYSQLquery02)or die(mysql_error()); 
	
	unset($gene_list);
	unset($OneGenePPI_Phy_NN_unique_list);
	unset($OneGenePPI_Gen_NN_unique_list);
	unset($OneGeneGO_P_terms_list);
	unset($OneGeneGO_F_terms_list);
	unset($OneGeneGO_C_terms_list);
	unset($phenotypeID_list);
	
	while ($OneGene_attributes_from_combData = mysql_fetch_assoc($result02))
	{
		if(!empty($OneGene_attributes_from_combData['Gene_Name'])){
			$gene_list[] = $OneGene_attributes_from_combData['Gene_Name'];
		}else{
			$gene_list[] = $OneGene_attributes_from_combData['Feature_Name'];
		}
		$PubMed_ID_link_list[] = $OneGene_attributes_from_combData['PubMed_ID_link']; 
		$OneGeneGO_F_terms_list[] = $OneGene_attributes_from_combData['OneGeneGO_F_terms'];
		$OneGeneGO_P_terms_list[] = $OneGene_attributes_from_combData['OneGeneGO_P_terms'];
		$OneGeneGO_C_terms_list[] = $OneGene_attributes_from_combData['OneGeneGO_C_terms'];
		$phenotypeID_list[] = $OneGene_attributes_from_combData['phenotypeID']; 
	}
	$phenotype_gene_lists[] = $gene_list;
	$Phenotype_GO_P_terms_lists[] = $OneGeneGO_P_terms_list; 
	$Phenotype_GO_F_terms_lists[] = $OneGeneGO_F_terms_list; 
	$Phenotype_GO_C_terms_lists[] = $OneGeneGO_C_terms_list; 
}
for ( $counter = 1; $counter <= count($phenotype_gene_lists); $counter += 1) {//scroll through each geneset
	$count = $counter-1;

	for ( $counter02 = 1; $counter02 <= count($phenotype_gene_lists); $counter02 += 1) {//scroll through each geneset again
		$count02 = $counter02-1;
		
		//don't intersect geneset with itself eg do 1-2, 1-3, 1-4, 2-3, 2-4, 3-4 but not 2-1, 3-1 etc (or 1-1, 2-2 etc)
		//and don't intersect genesets that were published in the same paper (these would have been considered by authers already?)
		if( ($count < $count02) and ($PubMed_ID_lists["$count"] != $PubMed_ID_lists["$count02"]) ){

			$phenotype_gene_lists["$count"] = array_unique($phenotype_gene_lists["$count"]);
			$phenotype_gene_lists["$count02"] = array_unique($phenotype_gene_lists["$count02"]);
			
			$intersect = array_intersect($phenotype_gene_lists["$count"], $phenotype_gene_lists["$count02"]);//keys of set A
			
			$gene_strA = implode(', ', $phenotype_gene_lists["$count"]);
			$gene_strA = mysql_real_escape_string($gene_strA);
			$gene_strB = implode(', ', $phenotype_gene_lists["$count02"]);
			$gene_strB = mysql_real_escape_string($gene_strB);
			
			if(!empty ($intersect)){
				//show_array($intersect);
			}else{
				//unset($intersect);
				$intersect = array('no intersection result');
				//show_array($intersect);
			}
			//repeat to get keys of common genes from set B
			$intersect_other_key = array_intersect($phenotype_gene_lists["$count02"], $phenotype_gene_lists["$count"]);
				
			$n = count($phenotype_gene_lists["$count"]);
			$M = count($phenotype_gene_lists["$count02"]);
			$m = count($intersect);
			
			$p = pvalue($N,$M,$n,$m);
			
			$arrayKeys = array_keys($intersect);
			$NIR = $intersect[$arrayKeys[0]];
			
				if($NIR == 'no intersection result'){
					//echo 'intersect = '.$intersect[0];
					$m = 0;
					$p = 1;				
				}
				if( (count($phenotype_gene_lists["$count"]) <=3) or (count($phenotype_gene_lists["$count02"]) <=3) ){
					$m = 0;
					$p = 1;		
				}
			if($p <= $cutoff){
			
			mysql_query("
			INSERT INTO intersection_data (db_row_count) 
			VALUES ('".$db_row_count."' )  
			")or die(mysql_error());

				//key for current multi dimensional arrays being intersected
				$keys = array_keys($intersect);
				//now need to capture which sub keys
				//key keys that correspond to intersected genes are removed
				//show_array($Phenotype_PPI_Phy_NN_unique_lists["$count"]);
				//show_array($Phenotype_PPI_Phy_NN_unique_lists["$count02"]);
				sort($intersect);
				$inter_str = implode(', ', $intersect);
				$intersect_str = mysql_real_escape_string($inter_str);

				$intersection_array = array(
				'Phenotype_GO_P_terms_lists',
				'Phenotype_GO_F_terms_lists',
				'Phenotype_GO_C_terms_lists');
				
				$M_new = $m;//intersetion result in now the set to be queried to calculat pval for go term
				$GOterm_pfilter = 0.005;
				$man_patch = 'n';
				//$type = 'GO';
				//$keys are those of the genes that intersect.....
				foreach($intersection_array as $k => $v){
					$GOintersect = get_list(${$v}, $keys, $count, $N, $M_new, $GOterm_pfilter, $man_patch);
	//				echo $GOintersect;
					$v = 'inter_'.$v;
					mysql_query("
					UPDATE
					intersection_data 
					SET 
					".$v." = '".$GOintersect."' 
					WHERE
					db_row_count = '".$db_row_count."'
					")or die(mysql_error());
				}
			$pq = sprintf("%.3e\n", $p);
			mysql_query("
			UPDATE
			intersection_data 
			SET 
			setA_PubMed_ID = '".$PubMed_ID_lists["$count"]."',
			setA_citation = '".$citation_lists["$count"]."', 
			setA_phenotype = '".$PheChem_lists["$count"]."', 
			setA_phenotypeID = '".$phenotypeID_lists["$count"]."',
			setA_count = '".$n."',
			setA_genelist = '".$gene_strA."', 
			setB_PubMed_ID = '".$PubMed_ID_lists["$count02"]."', 
			setB_citation = '".$citation_lists["$count02"]."',
			setB_phenotype = '".$PheChem_lists["$count02"]."', 
			setB_phenotypeID = '".$phenotypeID_lists["$count02"]."', 
			setB_count = '".$M."', 
			setB_genelist = '".$gene_strB."', 
			Intersection_count = '".$m."', 
			Intersection_genes = '".$intersect_str."', 
			pvalue = '".$pq."'	
			WHERE
			db_row_count = '".$db_row_count."'
			")or die(mysql_error());
			}//end of ip pval loop
		$db_row_count++;		
		}
	}
}
?>
