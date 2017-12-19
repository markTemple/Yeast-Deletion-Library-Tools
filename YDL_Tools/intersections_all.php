<?php
require_once('./header.php');
//show_array($_GET);
?>

<head><title></title></head>
<body>
<h1>Intersection Details</h1>
The most similar phenotypes in the database. 
<p>

<?php
if(!isset($postdata['pvalue'])){
$postdata['pvalue'] = '0.00000000000000000000000000000000000000000000000001';
}

// function //
echo '<b> Select p value for intersection </b>';
form_dropdown_intersection($postdata);// print dropdown list of papers to webpage
// returns "Select Paper" "Phenotypes" buttons

$query = sprintf("
SELECT 
	*
FROM 
	intersection_data
WHERE
	pvalue < '".$postdata['pvalue']."'
ORDER BY pvalue
");

$intersection_data = get_assoc_array($query);

echo '<h2>For the given \'p value\' there are <font color="red">';
echo count($intersection_data);
echo '</font> phenotypes that pass the test</h2>';


//show_array($intersection_data);
	echo '<fieldset>';

echo "<table class=\"box-table-a\" summary=\"\">";

echo "<th align='center' width='5%'>Venn</th>";
echo "<th align='center' width='40%'>A Citation / Phenotype </th>";
echo "<th align='center' width='5%'>Intersection count</th>";
echo "<th align='center' width='40%'>B Citation / Phenotype</th>";		
echo "<th align='center' width='10%'>p value</th>";		

$count_ppi=0;
foreach($intersection_data as $v){
$count_ppi++;
	
	echo "<tr>";
	
	echo "<td align='left'>";
		$var_graph = '';
		$venn_label_int = '';
		$venn_sets_int = '';
		$venn_label_int .= '{"sets": [0], "label": "A", "size": '.$v["setA_count"].'},';
		$venn_label_int .= '{"sets": [1], "label": "B", "size": '.$v["setB_count"].'},';
		$venn_sets_int .= '{"sets": [0, 1], "size": '.$v["Intersection_count"].'}';
		$var_graph = 'var sets = ['.$venn_label_int.$venn_sets_int.']';
		echo '<script>'.$var_graph.'</script>';
		$wdth = 150;
		$hght = 150;
		$divID = $v['intdatID'];
		include('./D3_venn.php');	
	echo "</td>";
	
	echo "<td align='left'>". '<b>Citation </b>' .$v['setA_citation'] .'<br />'
	.'<b>Phenotype </b>'. $v['setA_phenotype'].'<br />';
	
	
		echo "<table>";
		echo "<tr align='left'>";
		echo " ". '<b>Genes </b>' .$v['setA_count'].' ';
		echo "</tr>";
		echo "<tr align='left'>";
	$paperID = SEL_A_FROM_comb_paper_data_B('paperID', "WHERE phenotypeID = '".$v['setA_phenotypeID']."'" );
	?>
		<form method="get" action="./queryLOOP.php">
		<input name="phenotypeID" type="hidden" value="<?php echo $v['setA_phenotypeID'];?>">
		<input name="paperID" type="hidden" value="<?php echo $paperID[0]['paperID'];?>">
		<input name="Intersects" type="hidden" value="value">
		<input class="submitbutton" type="submit" value="Intersects" name="submit">
		</form>
	<?php
		echo "</tr>";
		echo "</table>";
		
	echo "<td align='center'>". $v['Intersection_count'] . "</td>";
		
		
	echo "</td>";
	echo "<td align='left'>". '<b>Citation </b>' . $v['setB_citation']  .'<br />'
	.'<b>Phenotype </b>'. $v['setB_phenotype'].'<br />';
	
		echo "<table>";
		echo "<tr align='left'>";
		echo " ". '<b>Genes </b>' .$v['setB_count'].' ';
		echo "</tr>";
		echo "<tr align='left'>";
	//echo $v['setA_phenotypeID']
	$paperID = SEL_A_FROM_comb_paper_data_B('paperID', "WHERE phenotypeID = '".$v['setB_phenotypeID']."'" );
	//echo $paperID[0]['paperID'];
	?>
		<form method="get" action="./queryLOOP.php">
		<input name="phenotypeID" type="hidden" value="<?php echo $v['setB_phenotypeID'];?>">
		<input name="paperID" type="hidden" value="<?php echo $paperID[0]['paperID'];?>">
		<input name="Intersects" type="hidden" value="value">
		<input class="submitbutton" type="submit" value="Intersects" name="submit">
		</form>
	<?php		
		echo "</tr>";
		echo "</table>";

	
	echo "</td>";
	echo "<td align='center'>". $v['pvalue'] . "</td>";
	echo "</tr>";	
	
}
echo "</table>";
	echo '</fieldset>';	
echo '<br />';	

?>

</p>
</body>

<?php
require_once('./footer.php');
?>	
