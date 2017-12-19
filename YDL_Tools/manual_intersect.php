<?php
require_once('./header.php');

$papers_phe_array = all_paper_to_phe_array();

if (!isset($postdata['paperID_1'])) {
$postdata['paperID_1'] = '132';
//$postdata['phenotypeID_1'] = '173';
$postdata['paperID_2'] = '83';
//$postdata['phenotypeID_2'] = '173';
$postdata['submit'] = 'Manual Intersect';
}
if(!isset($postdata['pvalue'])){
$postdata['pvalue'] = '0.000001';
}

if ( (isset($postdata['paperID_1'])) and (isset($postdata['paperID_2'])) ) {

//drop_table('man_intersect_data');
//create_MYSQL_man_intersect_data();


/*	while ($array_1 = current($papers_phe_array[$postdata['paperID_1']])) {
	//show_array($array_1);
		if($array['phenotypeID'] == $postdata['phenotypeID_1']) {
			$phe_key = key($papers_phe_array[$postdata['phenotype_1']]);//capture key of choosen phenotype
			$phe_name = $papers_phe_array[$postdata['phenotypeID_1']][$phe_key]['phenotype'];//capture name of choosen phenotype
		}
		next($papers_phe_array[$postdata['paperID_1']]);
	}
*/	$paperID_1 = $postdata['paperID_1'];
	
//	while ($array_2 = current($papers_phe_array[$postdata['paperID_2']])) {
//	//show_array($array_2);
//		if($array['phenotypeID'] == $postdata['phenotypeID_2']) {
//			$phe_key = key($papers_phe_array[$postdata['phenotype_2']]);//capture key of choosen phenotype
//			$phe_name = $papers_phe_array[$postdata['phenotypeID_2']][$phe_key]['phenotype'];//capture name of choosen phenotype
//		}
//		next($papers_phe_array[$postdata['paperID_2']]);
//	}
	$paperID_2 = $postdata['paperID_2'];
}
//show_array($postdata);
?>

<head><title></title></head>
<body>
<?php

echo '<h1>Manual Intersection Tool</h1>';
//<font color= "blue"> -> </font><font color= "red">' . $postdata['submit'] . '</font>	

echo '<fieldset>';
	?>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<?php
	if(isset($postdata)){
		//created a hidden form value of previous selected options (don't loos the previously selected options)
		//use this in all forms (needs to placed early in form - not sure why???)
		echo post_options($postdata);
	}
	?>
	
	<br />
	<b>Select Publication 1</b>
	<br />
	<select name="paperID_1">
	<?php
	foreach($papers_phe_array as $k => $paper){
	
		$short_cit = substr($paper[0]['citation'], 0, 150);	
		
		if (isset($postdata['paperID_1'])) {
			if($k == $paperID_1){ $stickyForm ='selected="selected"'; }
		}
		echo "<option $stickyForm".' value="'.$k.'">'.$short_cit.'</option>';
		$stickyForm = '';
	}
	echo '</select>';
	echo '<font color="red"><h3>' . $papers_phe_array["$paperID_1"][0]['citation'] . '</h3></font>';	
	echo '<a href="http://www.ncbi.nlm.nih.gov/pubmed?term=' . $papers_phe_array["$paperID_1"][0]['PubMed_ID']
	.'" target="_blank">PubMed</a>';
	?>
	<hr>
	<br />
	<b>Select Publication 2</b>
	<br />
	<select name="paperID_2">
	<?php
	foreach($papers_phe_array as $k => $paper){
	
		$short_cit = substr($paper[0]['citation'], 0, 150);	
		
		if (isset($postdata['paperID_2'])) {
			if($k == $paperID_2){ $stickyForm ='selected="selected"'; }
		}
		echo "<option $stickyForm".' value="'.$k.'">'.$short_cit.'</option>';
		$stickyForm = '';
	}
	echo '</select>';
	echo '<font color="red"><h3>' . $papers_phe_array["$paperID_2"][0]['citation'] . '</h3></font>';	
	echo '<a href="http://www.ncbi.nlm.nih.gov/pubmed?term=' . $papers_phe_array["$paperID_2"][0]['PubMed_ID']
	.'" target="_blank">PubMed</a>';

	echo '<hr>';
	
	$pval_array = array(
	'0.1' => '0.1',
	'0.01' => '0.01',
	'0.001' => '0.001',
	'0.000001' => '10E-6',
	'0.000000001' => '10E-9',
	'0.000000000001' => '10E-12',
	'0.000000000000001' => '10E-15',
	'0.00000000000000000001' => '10E-20',
	'0.000000000000000000000000000001' => '10E-30')
	?>
	Select a p value for the intersection<br />
	<select name="pvalue">
	<?php
	echo '<b> Select p value for intersection </b>';
	foreach($pval_array as $k => $pvalue){
		if($k == $postdata['pvalue']){ 
			$stickyForm ='selected="selected"'; 
		}
		echo "<option $stickyForm".' value="'.$k.'">'.$pvalue.'</option>';
		$stickyForm = '';
	}
	?>	
	</select>
	<input class="submitbutton" type="submit" value="Manual Intersect" name="submit">
	</form> 	
	<?php
		
echo '</fieldset>';

$two_paperID = array($postdata['paperID_1'], $postdata['paperID_2']);

foreach($two_paperID as $k => $paperID){

	//echo 'paperID = '. $k .' to ' . $paperID . '<br />';

	$MYSQLquery01 = "
	SELECT DISTINCT phenotypeID, PubMed_ID_link, PubMed_ID, PheChem, citation FROM combined_data
	WHERE paperID = '".$paperID."'
	";
	
	$result = mysql_query($MYSQLquery01)or die(mysql_error()); 
	
	while ($array_eachPHE_combData = mysql_fetch_assoc($result))
	{
	
		$array_eachPHE_combData['PheChem'] = mysql_real_escape_string($array_eachPHE_combData['PheChem']);
		$PheChem_lists[$k][] = $array_eachPHE_combData['PheChem'];
		$PubMed_ID_lists[$k][] = $array_eachPHE_combData['PubMed_ID'];//changed from link at this point
		$citation_lists[$k][] = $array_eachPHE_combData['citation'];
		$phenotypeID_lists[$k][] = $array_eachPHE_combData['phenotypeID'];//new to be used to simplify lookups and passing data
	
		//echo $array_eachPHE_combData['phenotypeID'] . '<br />';
		
		$MYSQLquery02 = "SELECT
		phenotypeID, Gene_Name, Feature_Name, PubMed_ID_link, 
		OneGeneGO_F_terms, OneGeneGO_P_terms, OneGeneGO_C_terms
		FROM combined_data
		WHERE phenotypeID = '".$array_eachPHE_combData['phenotypeID']."'";
		
		$result02 = mysql_query($MYSQLquery02)or die(mysql_error()); 
		
		unset($gene_list);
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
		$phenotype_gene_lists[$k][] = $gene_list;
		$Phenotype_GO_P_terms_lists[$k][] = $OneGeneGO_P_terms_list; 
		$Phenotype_GO_F_terms_lists[$k][] = $OneGeneGO_F_terms_list; 
		$Phenotype_GO_C_terms_lists[$k][] = $OneGeneGO_C_terms_list; 
	}
}
	
	
//show_array($phenotype_gene_lists[0]); //one array of phenotype results for each paper (we are in a loop!)
//show_array($phenotype_gene_lists[0]);
//
//echo '<hr>';
//echo '<hr>';
//echo '<hr>';
//echo '<hr>';
//
//show_array($phenotype_gene_lists[1]);

		//show_array($PheChem_lists);


$db_row_count = 1;
$cutoff = $postdata['pvalue'];
//echo 'p value cutoff = '.$cutoff = 0.9;
$N = 4600;

$x = '';
for ( $counter = 1; $counter <= count($phenotype_gene_lists[0]); $counter += 1) {//scroll through each geneset
	$count = $counter-1;

	for ( $counter02 = 1; $counter02 <= count($phenotype_gene_lists[1]); $counter02 += 1) {//scroll through other geneset
		$count02 = $counter02-1;
		
		//don't intersect geneset with itself eg do 1-2, 1-3, 1-4, 2-3, 2-4, 3-4 but not 2-1, 3-1 etc (or 1-1, 2-2 etc)
		//and don't intersect genesets that were published in the same paper (these would have been considered by authers already?)
			if( $phenotypeID_lists[0]["$count"] != $phenotypeID_lists[1]["$count02"]){

			$phenotype_gene_lists[0]["$count"] = array_unique($phenotype_gene_lists[0]["$count"]);
			$phenotype_gene_lists[1]["$count02"] = array_unique($phenotype_gene_lists[1]["$count02"]);
			
			$intersect = array_intersect($phenotype_gene_lists[0]["$count"], $phenotype_gene_lists[1]["$count02"]);//keys of set A
			
			$gene_strA = implode(', ', $phenotype_gene_lists[0]["$count"]);
			$gene_strA = mysql_real_escape_string($gene_strA);
			$gene_strB = implode(', ', $phenotype_gene_lists[1]["$count02"]);
			$gene_strB = mysql_real_escape_string($gene_strB);
			
			if(!empty ($intersect)){
				//show_array($intersect);
				//key for current multi dimensional arrays being intersected
				$keys = array_keys($intersect);
			}else{
				$intersect = '';
				//$intersect = array('no intersection result');
				//show_array($intersect);	
				$keys = NULL;
			}
			//repeat to get keys of common genes from set B
			//$intersect_other_key = array_intersect($phenotype_gene_lists[1]["$count02"], $phenotype_gene_lists[0]["$count"]);
				
			$n = count($phenotype_gene_lists[0]["$count"]);
			$M = count($phenotype_gene_lists[1]["$count02"]);
			$m = count($intersect);
			
			//show_array($intersect);
			
			$p = pvalue($N,$M,$n,$m);
				if($intersect == ''){
					$m = 0;
					$p = 1;				
				}
				if( (count($phenotype_gene_lists[0]["$count"]) <=1) or (count($phenotype_gene_lists[1]["$count02"]) <=1) ){
					$m = 0;
					$p = 1;		
				}
			if($p <= $cutoff){
			
			//echo $db_row_count;

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
				//$keys are those of the genes that intersect.....
				
				//show_array($intersect);
				//echo $count;
		$x++;
				
				if($keys !== NULL){
				$M_new = $m;//intersetion result in now the set to be queried to calculat pval for go term
				$GOterm_pfilter = 0.005;
				$man_patch = 'y';
				//$type = 'GO';
					foreach($intersection_array as $k => $v){
					//$v = $val[0];
						$GOintersect = get_list(${$v}, $keys, $count, $N, $M_new, $GOterm_pfilter, $man_patch);
						//echo $GOintersect;
						
						$v = 'inter_'.$v;
						$array_go[] = $GOintersect;
			$man_intersect_results[$x]["$v"] = $GOintersect;
					}
				}
				//show_array($citation_lists[0]);
				
				//echo $citation_lists[0]["$count"];

			$pq = sprintf("%.3e\n", $p);
						

			$man_intersect_results[$x]['citationA'] = $citation_lists[0]["$count"];
			$man_intersect_results[$x]['PheChemA'] = $PheChem_lists[0]["$count"];
			$man_intersect_results[$x]['n'] = $n;
			$man_intersect_results[$x]['citationB'] = $citation_lists[1]["$count02"];
			$man_intersect_results[$x]['PheChemB'] = $PheChem_lists[1]["$count02"];
			$man_intersect_results[$x]['M'] = $M;
			$man_intersect_results[$x]['pq'] = $pq;
			$man_intersect_results[$x]['intersect_str'] = $intersect_str;
			$man_intersect_results[$x]['m'] = $m;

			}//end of ip pval loop
		$db_row_count++;		
			}
	}
}

$howmany = count($man_intersect_results);
echo '<h2>There are <font color="red">'.$howmany.'</font> intersection results for you query</h2>';
if($howmany >= 1){
	foreach($man_intersect_results as $k => $v){
		
		//show_array($v);
		echo "<fieldset>";	
		echo "<table class=\"box-table-a\" summary=\"\">";
		
		echo "<th align='center' width='10%'>"."$k"."</th>";
		echo "<th align='center' width='90%'>Manual Intersection Details</th>";
		echo '<tr>';			
		echo "<td align='left' width='10%'>";
		echo '<b>Publication 1 : </b>';
		echo "</td>";
		echo "<td align='left' width='90%'><b>";
		
		echo $v['citationA'];
		echo '</b></tr>';	
		
		echo '<tr>';			
		echo "<td align='left' width='10%'>";
		echo '<b>Phenotype 1 : </b>';
		echo "</td>";
		echo "<td align='left' width='90%'>".'<font color="red">';
		echo $v['PheChemA'];
		echo '</font> (genes : </b><font color="red">';
		echo $v['n'];
		echo '</font>) &nbsp;&nbsp;';
		echo '</tr>';	
		
		echo '<tr>';			
		echo "<td align='left' width='10%'>";
		echo '<b>Publication 2 : </b>';
		echo "</td>";
		echo "<td align='left' width='90%'><b>";
		echo $v['citationB'];
		echo '</b></tr>';	
		
		echo '<tr>';			
		echo "<td align='left' width='10%'>";
		echo '<b>Phenotype 2 : </b>';
		echo "</td>";
		echo "<td align='left' width='90%'>".'<font color="red">';
		echo $v['PheChemB'];
		echo '</font> (genes : </b><font color="red">';
		echo $v['M'];
		echo '</font>) &nbsp;&nbsp;';
		echo '</tr>';	
		
		echo '<tr>';			
		echo "<td align='left' width='10%'>";
		echo '<b>Venn Intersection: </b>';
		echo "</td>";
		echo "<td align='left' width='90%'>";
		echo '<font color="red">p Value </font>'.$v['pq'];
				
		$var_graph = '';
		$venn_label_int = '';
		$venn_sets_int = '';
		$venn_label_int .= '{"sets": [0], "label": "'.$v["PheChemA"].'", "size": '.$v["n"].'},';
		$venn_label_int .= '{"sets": [1], "label": "'.$v["PheChemB"].'", "size": '.$v["M"].'},';
		$venn_sets_int .= '{"sets": [0, 1], "size": '.$v["m"].'}';
		$var_graph = 'var sets = ['.$venn_label_int.$venn_sets_int.']';
		echo '<script>'.$var_graph.'</script>';
		$wdth = 600;
		$hght = 200;
		$divID = $k;
		include('./D3_venn.php');	
		
		echo '</tr>';	
		
		echo '<tr>';			
		echo "<td align='left' width='10%'>";
		echo '<b>Intersecting genes : </b>';		
		echo "</td>";
		echo "<td align='left' width='90%'>";
		echo $v['intersect_str'];
		echo '<b> (genes : </b>';
		echo $v['m'];
		echo ')';
		echo '</tr>';	
		
		echo '<tr>';			
		echo "<td align='left' width='10%'>";
		echo '<b>GO term Process : </b>';
		echo "</td>";
		echo "<td align='left' width='90%'>";
		echo $v['inter_Phenotype_GO_P_terms_lists'];
		echo '</tr>';	
		
		echo '<tr>';			
		echo "<td align='left' width='10%'>";
		echo '<b>GO term Function : </b>';
		echo "</td>";
		echo "<td align='left' width='90%'>";
		echo $v['inter_Phenotype_GO_F_terms_lists'];
		echo '</tr>';	
		
		echo '<tr>';			
		echo "<td align='left' width='10%'>";
		echo '<b>GO term Component : </b>';
		echo "</td>";
		echo "<td align='left' width='90%'>";
		echo $v['inter_Phenotype_GO_C_terms_lists'];
		echo '</tr>';	
		
		echo '</table>';			
		
		echo "</fieldset>";	
	}
}else{
	echo "<fieldset>";	
	echo 'There are no results,  This could be because there are no common genes or because the p value of the intersection was not lower than the filter value (try setting a larger p value?)';
	echo "</fieldset>";	
}
?>
</body>

<?php
require_once('./footer.php');
?>	
