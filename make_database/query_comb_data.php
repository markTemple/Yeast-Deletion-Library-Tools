<?php
require_once('./back_header.php');

//if (isset($_GET['query'])) $submit=$_GET['query'];
//else $submit='';
ini_set("memory_limit","512M");


//show_array($_POST);
//show_array($_GET);
//echo "submit = $submit";

?>
<head><title></title></head>
<body>
<h2>Run MySQL Querys</h2>
<p>

<?php
echo "<br />";

$ORF = 'YLR295C';

$MYSQLquerys = array(			

'q1' => array('01/ GO term', 
		'SELECT DISTINCT
			GO_Aspect, GO_Slim_term, GOID, Count(GO_Slim_term)
		FROM 
			go_slim_mapping
		GROUP BY
			GO_Slim_term
		ORDER BY 
			GO_Aspect, GO_Slim_term
	'),

'q2' => array('02/ Interaction', 
	"SELECT 
		count(Genetic_or_Physical_Interaction) AS HowMany
	FROM 
		interaction_data
	WHERE 
		interaction_data.Feature_Name_Bait = '".$ORF."'
	OR 
		interaction_data.Feature_Name_Hit = '".$ORF."'
	ORDER BY 
		Genetic_or_Physical_Interaction"
	),
    
'q3' => array('03/ treatment type', 
	"SELECT 
		Feature_Name, Gene_Name, PubMed_ID_link, PheChem
	FROM 
		combined_data
	WHERE 
		combined_data.PheChem Like '%nystatin%'
	ORDER BY 
		combined_data.PheChem"
	),
    
'q4' => array('04/ treatment type', 
	"SELECT 
		Feature_Name, Gene_Name, PubMed_ID_link, PheChem
	FROM 
		combined_data
	WHERE 
		combined_data.PheChem Like '%Amphotericin%'
	ORDER BY 
		combined_data.PheChem"
	),
	
'q5' => array('05/ all genes', 
	'SELECT Gene_Name, COUNT(Gene_Name) 
	FROM combined_data 
	WHERE Gene_Name IS NOT NULL
	GROUP BY Gene_Name
	ORDER BY COUNT(Gene_Name) DESC'
	),
	
'q6' => array('06/ papers and genesets', 
	'SELECT paperID, PubMed_ID_link, Flatfile, SUBSTRING(citation,1,500), 
	COUNT(Feature_Name) 
	FROM combined_data 
	GROUP BY paperID
	ORDER BY paperID'
	),
	
'q7' => array('07/ papers and genesets', 
	'SELECT SUBSTRING(citation,1,50), 
	COUNT(phenotype) 
	FROM comb_paper_data 
	GROUP BY paperID
	ORDER BY citation'
	),
	
'q8' => array('08/ identify duplicate papers', 
	'SELECT KeiPub, PubMed_ID, 
	COUNT(KeiPub) as cnt
	FROM Keith_PubMed_ID 
	GROUP BY PubMed_ID HAVING cnt > 1'
	),
	
'q9' => array('09/ replace null UWS_Del_Lib_Screen', 
	'UPDATE UWS_Del_Lib_Screen SET Gene_Name = Feature_Name WHERE Gene_Name = "" '
	),
	
'q10' => array('10/ replace null combined_data', 
	'UPDATE combined_data SET Gene_Name = Feature_Name WHERE Gene_Name = "" '
	),
	
'q11' => array('11/ duplicate genes in uws', 
	'SELECT Feature_Name, Gene_Name, COUNT(Gene_Name) AS GN, Phenotype, Chemical, Ref_PMID, COUNT(Ref_PMID) AS ID
	FROM UWS_Del_Lib_Screen 
	GROUP BY Phenotype, Chemical, Gene_Name
	HAVING COUNT(Gene_Name) >= 2
	ORDER BY Phenotype DESC'
	),
	
'q12' => array('12/ all genes', 
	'SELECT comdatID, PubMed_ID, PheChem, Flatfile, Feature_Name, Gene_Name, COUNT(Gene_Name) AS GN
	FROM combined_data 
	GROUP BY paperID, PheChem, Gene_Name, Ref_PMID
	ORDER BY GN DESC'
	), 
	
'q13' => array('13/ remove duplicate rows if same phenotypeID Feature_Name', 	
	'SELECT * FROM combined_data WHERE SGDID = "" '
	),
	
'q14' => array('14/ check link', 	
	'SELECT citation_link FROM UWS_Del_Lib_Screen'
	)
		
);
//	WHERE Ref_PMID = 15087496
//15087496
//18629161


//show_array($MYSQLquerys);

if (isset($_GET['query'])) $querychoice=$_GET['query'];
else $querychoice='';
?>


<?php 




foreach($MYSQLquerys as $k => $v){
	echo "<fieldset><legend>$v[0]</legend>";

	echo '<a href="?query='.$k.'">"'.$v[1].'"</a><br />';

	if(($querychoice == $k) and ($querychoice !== '')){	
		$query = $v[1];
//		$tables = get_assoc_array($query);
//		show_array($tables);
		echo '<fieldset>';
		echo '<a href="?">reset page</a><br /><br />';
		$result = mysql_query($query);		
		print_result_table($result);
		
		$result2 = get_assoc_array($query);
		foreach($result2 as $val1){
			foreach($val1 as $val2){
			//echo $val2.' ';
			}
		};
		
		
		echo '</fieldset>';	
	}
	echo '</fieldset>';	
	echo '<br />';	
}

//echo "This is line " . __LINE__ ." of file " . __FILE__;

?>
	</p>


</body>

<?php
require_once('./back_footer.php');
?>	
