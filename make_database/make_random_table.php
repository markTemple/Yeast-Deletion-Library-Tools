<?php

//will replace all data with random data for testing
//
drop_table('combined_data');
create_MYSQL_combined_data();// create mysql table	
//show_one_table('combined_data');

$query = sprintf("
SELECT Standard_gene_name, sgdfeaID, Feature_Name, Deletant, sgd_id, feature_link FROM SGD_features WHERE Deletant = 'Not Essential'
");
$SGD_non_essentials = get_assoc_array($query);
//show_array($SGD_non_essentials);

$number_of_phenotypes = 10;
for($i = 1; $i <= $number_of_phenotypes; $i++){
	$PubMed_ID["$i"] = rand(10000000, 20000000);//fake pubmed id
	$phenotype_set["$i"] = rand(20, 100);//number of genes in set
	$phenotypeID["$i"] = "$i";//number of genes in set
}
//sort($phenotype_set);//use so that set number (key) is related to number of genes
//look for effect of set size on intersection and p values
//eg bigger sets lower p val etc

//show_array($phenotype_set);

foreach($phenotype_set as $PheSet_numb => $number_of_genes){
	$sgdfeaID = '';
	for($i = 1; $i <= $number_of_genes; $i++){
	$sgdfeaID[] = rand(1, 4872);//map to key of array not sgdfeaID we have removed the essentials etc....
	}
	$UNIQUE_sgdfeaID = array_unique($sgdfeaID);
	$random_PHE_generefs["$PheSet_numb"] = $UNIQUE_sgdfeaID;
}
//show_array($random_PHE_generefs);

foreach($random_PHE_generefs as $PheSet_numb => $key_of_genes){
	foreach($key_of_genes as $k => $key_for_sgd_array){
	$k++;
	$random_PHE_genesets["$PheSet_numb"]["$k"] = $SGD_non_essentials["$key_for_sgd_array"];
	$random_PHE_genesets["$PheSet_numb"]["$k"]['PubMed_ID'] = $PubMed_ID["$PheSet_numb"];
	$random_PHE_genesets["$PheSet_numb"]["$k"]['phenotypeID'] = $phenotypeID["$PheSet_numb"];
	}
}
//show_array($random_PHE_genesets);
//show_array($PubMed_ID);


foreach($random_PHE_genesets as $set_numb => $v){
	foreach($v as $v2 => $random_geneset){
		$Feature_Name = $random_geneset['Feature_Name'];
		$Gene_Name = mysql_real_escape_string($random_geneset['Standard_gene_name']);
		$SGDID = $random_geneset['sgd_id'];
		$feature_link = $random_geneset['feature_link'];
		$PubMed_ID = $random_geneset['PubMed_ID'];
		$PubMed_ID_link = $random_geneset['PubMed_ID'];//just number!!
		
		$PheCount = $random_geneset['phenotypeID'];//just number!!
		
		$Flatfile = 'made_by_script';
		$citation = 'random_citation_'.$set_numb;
		$PheChem = 'random_phenotype_'.$set_numb;
			
		$insert = mysql_query("
		INSERT INTO combined_data 
		(paperID, phenotypeID, Feature_Name, Gene_Name, SGDID, feature_link, PubMed_ID, 
		PubMed_ID_link, PheChem, Flatfile, citation) 
		VALUES 
		('$set_numb', '$PheCount', '$Feature_Name', '$Gene_Name', '$SGDID', '$feature_link', '$PubMed_ID', 
		'$PubMed_ID_link', '$PheChem', '$Flatfile', '$citation')  
		")or die(mysql_error());
	}
}
?>
