<?php
require_once('./header.php');
set_time_limit(100);
//// get unique list of Phenotypes (by ID only)
$Phe_query = sprintf("
SELECT DISTINCT
phenotypeID, PheChem
FROM 
combined_data
ORDER BY
phenotypeID ASC
");
$header_pheID = get_assoc_array($Phe_query);
//show_array($header_pheID);

//number of phenotypes
$array_pheIDCnt = count($header_pheID);

//// get unique list of genes
$ALLgenes_query = sprintf("
SELECT DISTINCT
Gene_Name
FROM 
combined_data
ORDER BY
Gene_Name ASC
");
$leftColumn = get_assoc_array($ALLgenes_query);
//show_array($leftColumn);
foreach($leftColumn as $k => $v){
	$Gene_N = str_replace(',', '-', $v['Gene_Name']);
	$genesArr[] = $Gene_N;
}
$genesString['Gene_Names'] = implode(',',$genesArr);
show_array($genesString);

//// get genes of each Phenotype
$gene_in_Phe_query = sprintf("
SELECT DISTINCT
phenotypeID, genelist
FROM 
comb_paper_data
ORDER BY
phenotypeID ASC
");
$gene_in_Phe = get_assoc_array($gene_in_Phe_query);
//show_array($gene_in_Phe);

foreach($header_pheID as $k => $v){// use @ because genenames have comma's
	$genes_inPhenotype[$k] = explode(', ', $gene_in_Phe[$k]['genelist']);
}

foreach($header_pheID as $k => $v){
	$header[] = $v['PheChem'];
}
show_array($header);

//for($i =0; $i< 100; $i++){//testing

for($i =0; $i< $array_pheIDCnt; $i++){
	foreach($genes_inPhenotype[$i] as $gene_of_Phe){
		foreach($leftColumn as $k => $v){
			foreach($v as $left_gene){
				if($gene_of_Phe == $left_gene){
					$matched[$k] = 1;
					break;
				}
			}	
		if(empty($matched[$k])){$matched[$k] = 0 ;}		
		}
	}
	$set[] = implode(',',$matched);
	$matched = '';
}

show_array($set);


require_once('./footer.php');
?>	