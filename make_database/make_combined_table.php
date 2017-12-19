<body>
<h2>Make big file</h2>
<p>
<?php

drop_table('combined_data');
create_MYSQL_combined_data();// create mysql table	
//show_one_table('combined_data');

$select_data_file = array(
17710403 => 'UWS_Del_Lib_Screen',
17164236 => 'phenotype_data',
17220322 => 'gene_literature',
17151231 => 'phenotype_data',
17314135 => 'UWS_Del_Lib_Screen',
17461973 => 'UWS_Del_Lib_Screen',
17308930 => 'UWS_Del_Lib_Screen',
17314395 => 'phenotype_data',
16467474 => 'UWS_Del_Lib_Screen',
16879425 => 'UWS_Del_Lib_Screen',
16911514 => 'UWS_Del_Lib_Screen',
16251356 => 'phenotype_data',
16598687 => 'phenotype_data',
15993632 => 'UWS_Del_Lib_Screen',
16380504 => 'phenotype_data',
15994967 => 'phenotype_data',
15645503 => 'gene_literature',
15489514 => 'UWS_Del_Lib_Screen',
16234568 => 'phenotype_data',
15908144 => 'UWS_Del_Lib_Screen',
15937126 => 'phenotype_data',
14871844 => 'UWS_Del_Lib_Screen',
14594803 => 'phenotype_data',
15334557 => 'UWS_Del_Lib_Screen',
14993228 => 'phenotype_data',
15299026 => 'phenotype_data',
12586695 => 'phenotype_data',
12754197 => 'UWS_Del_Lib_Screen',
12972632 => 'UWS_Del_Lib_Screen',
12663529 => 'UWS_Del_Lib_Screen',
14671320 => 'UWS_Del_Lib_Screen',
14657499 => 'phenotype_data',
12829295 => 'phenotype_data',
12615994 => 'UWS_Del_Lib_Screen',
12134085 => 'UWS_Del_Lib_Screen',
12482937 => 'phenotype_data',
11830665 => 'phenotype_data',
12089449 => 'phenotype_data',
12477387 => 'phenotype_data',
11726929 => 'UWS_Del_Lib_Screen',
11452010 => 'phenotype_data',
15087496 => 'UWS_Del_Lib_Screen',
15883361 => 'UWS_Del_Lib_Screen',
16027361 => 'phenotype_data',
16365294 => 'UWS_Del_Lib_Screen',
12096123 => 'phenotype_data',
18629161 => 'UWS_Del_Lib_Screen',
16168084 => 'UWS_Del_Lib_Screen',
15695358 => 'UWS_Del_Lib_Screen',
12543677 => 'UWS_Del_Lib_Screen',
15509654 => 'phenotype_data',
15371366 => 'gene_literature',
17093137 => 'phenotype_data',
16582425 => 'phenotype_data',
17107617 => 'phenotype_data',
16061773 => 'phenotype_data',
17559411 => 'UWS_Del_Lib_Screen',
16507139 => 'UWS_Del_Lib_Screen',
17644632 => 'phenotype_data',
19004804 => 'phenotype_data',
18657191 => 'UWS_Del_Lib_Screen',
16552446 => 'UWS_Del_Lib_Screen',
19055778 => 'UWS_Del_Lib_Screen',
19116312 => 'phenotype_data',
18562670 => 'UWS_Del_Lib_Screen',
12702675 => 'phenotype_data',
16989656 => 'phenotype_data',
15161972 => 'phenotype_data',
19638689 => 'phenotype_data',
20043226 => 'phenotype_data',
20202201 => 'phenotype_data',
17873082 => 'phenotype_data',
16361226 => 'phenotype_data',
16157669 => 'phenotype_data',
12016207 => 'phenotype_data',
11907266 => 'phenotype_data',
18250201 => 'phenotype_data',
18156287 => 'phenotype_data',
16600900 => 'phenotype_data',
19390089 => 'phenotype_data',
15806102 => 'phenotype_data',
19064668 => 'phenotype_data',
18314501 => 'phenotype_data',
18612650 => 'phenotype_data',
19047157 => 'phenotype_data',
18755837 => 'phenotype_data',
15837808 => 'phenotype_data',
19793921 => 'phenotype_data',
19619495 => 'phenotype_data',
18455128 => 'phenotype_data',
19751518 => 'phenotype_data',
19521502 => 'phenotype_data',
15911569 => 'phenotype_data',
19220866 => 'phenotype_data',
18936161 => 'phenotype_data',
15641941 => 'phenotype_data',
20157578 => 'phenotype_data',
16418483 => 'UWS_Del_Lib_Screen',
16330752 => 'phenotype_data',
19004802 => 'phenotype_data',
14605211 => 'phenotype_data',
16251355 => 'phenotype_data',
12686616 => 'phenotype_data',
18394190 => 'phenotype_data',
18216282 => 'phenotype_data',
17995956 => 'UWS_Del_Lib_Screen',
18514590 => 'phenotype_data',
16839886 => 'UWS_Del_Lib_Screen',
16630279 => 'phenotype_data',
18093937 => 'phenotype_data',
19129474 => 'phenotype_data',
19633105 => 'phenotype_data',
20210661 => 'phenotype_data',
16820484 => 'phenotype_data',
19067491 => 'phenotype_data',
19466415 => 'phenotype_data',
19503795 => 'phenotype_data',
17158920 => 'phenotype_data',
16240455 => 'phenotype_data',
18056469 => 'UWS_Del_Lib_Screen',
19054128 => 'phenotype_data',
17403898 => 'phenotype_data',
20206679 => 'phenotype_data',
19631266 => 'phenotype_data',
23026396 => 'phenotype_data',
22687516 => 'UWS_Del_Lib_Screen',
22970195 => 'UWS_Del_Lib_Screen',
22747191 => 'phenotype_data',
22181064 => 'phenotype_data',
22177309 => 'UWS_Del_Lib_Screen',
21810245 => 'phenotype_data',
21724935 => 'phenotype_data',
21212869 => 'phenotype_data',
21807938 => 'UWS_Del_Lib_Screen',
21840858 => 'phenotype_data',
21193549 => 'phenotype_data',
21960436 => 'phenotype_data',
22384317 => 'phenotype_data',
20960220 => 'phenotype_data',
21167225 => 'gene_literature',
21193664 => 'phenotype_data',
21252230 => 'UWS_Del_Lib_Screen',
21947398 => 'UWS_Del_Lib_Screen',
21912603 => 'phenotype_data',
21601516 => 'phenotype_data',
21035538 => 'UWS_Del_Lib_Screen',
21136082 => 'phenotype_data',
21341307 => 'UWS_Del_Lib_Screen',
20337531 => 'UWS_Del_Lib_Screen',
20520766 => 'UWS_Del_Lib_Screen',
19915041 => 'UWS_Del_Lib_Screen',
20641020 => 'UWS_Del_Lib_Screen',
21179023 => 'phenotype_data',
20695822 => 'phenotype_data',
20973990 => 'UWS_Del_Lib_Screen',
20675578 => 'phenotype_data',
20457874 => 'UWS_Del_Lib_Screen',
19433630 => 'phenotype_data',
19260806 => 'UWS_Del_Lib_Screen',
20007368 => 'phenotype_data',
18212113 => 'phenotype_data',
18160327 => 'UWS_Del_Lib_Screen',
18471310 => 'UWS_Del_Lib_Screen',
18192430 => 'UWS_Del_Lib_Screen',
18323404 => 'UWS_Del_Lib_Screen',
23467670 => 'UWS_Del_Lib_Screen',
21423800 => 'UWS_Del_Lib_Screen'

);

//show_array($select_data_file);
$x=0;
foreach($select_data_file as $keyPMid => $file_name){
$x++;
	
	switch ($file_name) {
	case 'UWS_Del_Lib_Screen':
		$query = "
		SELECT 
		UWS_Del_Lib_Screen.Feature_Name,
		UWS_Del_Lib_Screen.Gene_Name,
		UWS_Del_Lib_Screen.Chemical,
		UWS_Del_Lib_Screen.Phenotype,
		UWS_Del_Lib_Screen.Ref_PMID as PubMed_ID,
		UWS_Del_Lib_Screen.SGDID,
		'$file_name' as Flatfile,
		UWS_Del_Lib_Screen.feature_link,
		UWS_Del_Lib_Screen.citation_link as PubMed_ID_link,
		Keith_PubMed_ID.citation
		FROM 
		UWS_Del_Lib_Screen, Keith_PubMed_ID
		WHERE 
		UWS_Del_Lib_Screen.Ref_PMID = '$keyPMid' and
		Keith_PubMed_ID.PubMed_ID = '$keyPMid' 
		ORDER BY 4,3
		";			
		$result = mysql_query($query)or die(mysql_error()); 
			
		while ($arrayUWS_data = mysql_fetch_assoc($result))
		{
			$data_array["$x"][] = $arrayUWS_data;	
		}
	break;	
	case 'phenotype_data':
		
		$query = "
		SELECT 
		phenotype_data.Feature_Name,
		phenotype_data.Gene_Name,
		phenotype_data.Chemical,
		phenotype_data.Phenotype,
		phenotype_data.Ref_PMID as PubMed_ID,
		phenotype_data.SGDID,
		'$file_name' as Flatfile,
		phenotype_data.feature_link,
		phenotype_data.PMID_link as PubMed_ID_link,
		Keith_PubMed_ID.citation
		FROM 
		phenotype_data, Keith_PubMed_ID
		WHERE 
		phenotype_data.Ref_PMID = '$keyPMid'and
		Keith_PubMed_ID.PubMed_ID = '$keyPMid' 
		ORDER BY 4,3

		";			
		$result = mysql_query($query)or die(mysql_error()); 
			
		while ($array_phenotype_data = mysql_fetch_assoc($result))
		{
			$data_array["$x"][] = $array_phenotype_data;	
		}
	break;
	case 'gene_literature':
		if($keyPMid == 17220322){
			$Chemical = 'transformation with cytolethal distending toxins';
			$Phenotype = 'altered phenotype';
		}
		if($keyPMid == 15645503){
			$Chemical = 'hydroxyurea';
			$Phenotype = 'altered filamentous growth';
		}
		if($keyPMid == 15371366){
			$Chemical = 'X ray exposure';
			$Phenotype = 'sensitive';
		}		
		if($keyPMid == 21167225){
			$Chemical = 'endoglucanase gene';
			$Phenotype = 'enhanced endoglucanase activity';
		}		
		//yes dufus I know this should now be in an array
		
		$query = "
		SELECT 
		gene_literature.feature as Feature_Name,
		gene_literature.gene_name as Gene_Name,
		'$Chemical' as Chemical,
		'$Phenotype' as Phenotype,
		gene_literature.PubMed_ID,
		gene_literature.SGDID,
		'$file_name' as Flatfile,
		gene_literature.feature_link,
		gene_literature.citation_link as PubMed_ID_link,
		Keith_PubMed_ID.citation
		FROM 
		gene_literature, Keith_PubMed_ID
		WHERE 
		gene_literature.PubMed_ID = '$keyPMid'and
		Keith_PubMed_ID.PubMed_ID = '$keyPMid' 
		ORDER BY 4,3		
		";			
		$result = mysql_query($query)or die(mysql_error()); 
		
		while ($array_genLit = mysql_fetch_assoc($result))
		{
			$data_array["$x"][] = $array_genLit;	
		}
	break;
	}
}
		
$PheCount = 0;


//show_array($data_array);
foreach($data_array as $paperID => $v){
	foreach($v as $MYSQL_data_from_files){
		
		$Feature_Name = $MYSQL_data_from_files['Feature_Name'];
		$Gene_Name = mysql_real_escape_string($MYSQL_data_from_files['Gene_Name']);
		$SGDID = $MYSQL_data_from_files['SGDID'];
		$feature_link = addslashes($MYSQL_data_from_files['feature_link']);
		$PubMed_ID = $MYSQL_data_from_files['PubMed_ID'];
		$PubMed_ID_link = addslashes($MYSQL_data_from_files['PubMed_ID_link']);
		$Flatfile = $MYSQL_data_from_files['Flatfile'];
		$citation = $MYSQL_data_from_files['citation'];
		$Phenotype = trim($MYSQL_data_from_files['Phenotype']);
		$Chemical = mysql_real_escape_string(trim($MYSQL_data_from_files['Chemical']));				
		$PheChem = $Phenotype;
		
		//echo '<br />';
		if(!empty($Chemical))	{ $PheChem .=' '.$Chemical; }// combine
		$PheChem = str_replace('', '"', $PheChem);		
		
		//If PheChem changes increment count....
		if("$PheChem" == "$previous_PheChem"){
		//dont increment PheCount
		}else{
		$PheCount++;
		}
		
		
		$insert = mysql_query("
		INSERT INTO combined_data 
		(paperID, phenotypeID, Feature_Name, Gene_Name, SGDID, feature_link, PubMed_ID, 
		PubMed_ID_link, PheChem, Flatfile, citation) 
		VALUES 
		('$paperID', '$PheCount', '$Feature_Name', '$Gene_Name', '$SGDID', '$feature_link', '$PubMed_ID', 
		'$PubMed_ID_link', '$PheChem', '$Flatfile', '$citation')  
		")or die(mysql_error());
		
		//echo $PheCount.' - '.$PheChem.'<br />';
		
		$previous_PheChem = $PheChem;

	}
	
	
	$insert = mysql_query("
	UPDATE combined_data SET Gene_Name = Feature_Name WHERE Gene_Name = ".'""'."  
	")or die(mysql_error());

	
	
}

?>

