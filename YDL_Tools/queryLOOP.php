<?php
require_once('./header.php');
$papers_phe_array = all_paper_to_phe_array();

if (!isset($postdata['paperID'])) {
	$postdata['paperID'] = '43';
	$postdata['phenotypeID'] = '174';
	$postdata['submit'] = 'Intersects';
}
$getPhes = '';
if( empty($postdata['phenotypeID']) && empty($postdata['submit']) ){	
	$getPhes = SEL_A_FROM_comb_paper_data_B('phenotypeID', "WHERE paperID = '".$postdata['paperID']."'");
	$postdata['phenotypeID'] = $getPhes[0]['phenotypeID'];
	$postdata['submit'] = 'Intersects';
}
//show_array($getPhes);
//var_dump($_POST);
//var_dump($postdata);

if (isset($postdata['paperID'])) {
	while ($array = current($papers_phe_array[$postdata['paperID']])) {
		if($array['phenotypeID'] == $postdata['phenotypeID']) {
			$phe_key = key($papers_phe_array[$postdata['paperID']]);//capture key of choosen phenotype
			$phe_name = $papers_phe_array[$postdata['paperID']][$phe_key]['phenotype'];//capture name of choosen phenotype
		}
		next($papers_phe_array[$postdata['paperID']]);
	}
	$paperID = $postdata['paperID'];
}//show_array($postdata);
?>
<head><title></title></head><body>
<?php
echo '<h1>'.$postdata['submit'].'</h1>';
echo '<fieldset>';
echo 'Select a paper from the drop-down box and then choose a phenotype using the radio button(s)';
form_dropdown_listALL2($papers_phe_array, $paperID, $postdata);
// print dropdown list of papers to webpage
// returns "Select Paper" "Phenotypes" buttons
//if (isset($postdata['paperID'])) {
	echo '<font color="red"><h3>';
	echo $papers_phe_array["$paperID"][0]['citation'];
	echo '</h3></font>';
	// PUBMED ID = ';	
	//echo $papers_phe_array["$paperID"][0]['PubMed_ID'];
	//echo '<a href="http://www.ncbi.nlm.nih.gov/pubmed?term='
	//.$papers_phe_array["$paperID"][0]['PubMed_ID']
	//.'" target="_blank">'.$papers_phe_array["$paperID"][0]['PubMed_ID'].'</a>';
//	echo '</fieldset>';	
//}

//if ( (isset($postdata['paperID'])) and ($postdata['submit'] !== 'Phenotypes') ) {	
//if (isset($postdata['paperID']) and ($postdata['submit'] !== 'GeneSet') ){	
if (isset($postdata['paperID']) ){	
	echo '<br /><font color="blue">Choose a Phenotype</font>';
//	echo '<fieldset>	';
	// function //
	radio_list_Phenotypes($papers_phe_array, $paperID, $postdata);
}
echo '</fieldset>';

if( ($postdata['submit'] == 'Phenotypes') or ($postdata['submit'] == null) ) {
	$row_comb_paper_data = get_row_from_comb_paper_data('paperID', $postdata['paperID']);
	$this_many = count($row_comb_paper_data);
	// function //
	all_phenotype_one_paper_summary($row_comb_paper_data, $this_many);//results for all phenotypes from paper
}

$row_comb_paper_data = get_row_from_comb_paper_data('phenotypeID', $postdata['phenotypeID']);

if ( (isset($postdata['phenotypeID'])) and ($postdata['submit'] == 'Intersects') ) {
//	echo '<h1>Intersection Results </h1>';
	$phe_intersectsA = get_intersection_data_04A($postdata['phenotypeID']);	
	$phe_intersectsB = get_intersection_data_04B($postdata['phenotypeID']);	
	$phe_intersects = array_merge($phe_intersectsA, $phe_intersectsB);	
	$numb_of_intersects = count($phe_intersects);
	echo "<fieldset>";	
	echo '<h3>Intersection Summary - There are <font color="blue">'
	.$numb_of_intersects.'</font> intersecting phenotypes for - ';
	echo '<font color="red">'
	. $phe_name . '</font> (<font color="blue">' 
	. $row_comb_paper_data[0]['count'] .'</font> genes)</h3><br />';
	// function //
	Run_Intersect_Tool($phe_intersects, $phe_name, $postdata, $numb_of_intersects);
	echo '</fieldset>';
}

if ( (isset($postdata['phenotypeID'])) and ($postdata['submit'] == 'Summary') ) {
	// function //
	intersection_details($postdata);
}

if ( (isset($postdata['phenotypeID'])) and ($postdata['submit'] == 'GeneSet') ) {
	$comb_data_all = get_row_from_combined_data('phenotypeID', $postdata['phenotypeID']);	
	$row_comb_paper_data = get_row_from_comb_paper_data('phenotypeID', $postdata['phenotypeID']);
	// function //
	get_gene_properties($comb_data_all, $row_comb_paper_data);
}

?>
</body>

<?php
require_once('./footer.php');
?>	
