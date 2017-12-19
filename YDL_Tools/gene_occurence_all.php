<?php
require_once('./header.php');
?>

<head><title></title></head>
<body>
<p>

<?php

if(!isset($postdata['occur'])){
$postdata['occur'] = '40';
}

//show_array($_GET);

//$query02 = sprintf("
//SELECT 
//	Occurence, ROUND( count(Occurence) / Occurence) AS Count
//FROM 
//	combined_data
//GROUP BY
//	Occurence
//ORDER BY Occurence DESC");
//
//$intersection_data_count = get_assoc_array($query02);
////show_array($intersection_data_count);
//
//echo '<h2>Summary of gene occurrence</h2>';
//echo '<br />';
//foreach($intersection_data_count as $v){
//
//	if( ($v['Count'] == 1) and ($v['Occurence'] > 1) ){ 	
//		echo $v['Count'] . ' gene occur ' . $v['Occurence'] . ' times. ';
//	}
//	
//	if( ($v['Count'] > 1) and ($v['Occurence'] == 1) ){ 	
//		echo $v['Count'] . ' genes occur once. ';
//	}
//	
//	if( ($v['Count'] > 1) and ($v['Occurence'] > 1) ){ 	
//		echo $v['Count'] . ' genes occur ' . $v['Occurence'] . ' times. ';
//	}	
//}

$query = sprintf("
SELECT 
	COUNT(Feature_Name) AS Total_Genes,
	COUNT(DISTINCT Feature_Name) AS Distinct_Genes,
	COUNT(DISTINCT PubMed_ID) AS Publications,
	COUNT(DISTINCT PheChem) AS Phenotypes
FROM 
	combined_data
");

$combined_data = get_assoc_array($query);

echo '<h1>The most frequently occurring genes in all YDL phenotypes</h1>';
	echo '<fieldset>';	
echo "<table class=\"box-table-a\" summary=\"\">";
	echo "<th align='center' width='100%'>";
		echo 'Basic database summary';
	echo "</th>";
echo "</table>";



echo "<table class=\"box-table-a\" summary=\"\">";

echo "<tr>";
echo "<td align='left' width='10%'>";
echo 'Number of Publications in the database';
echo "</td>";
echo "<td align='left' width='10%'>";
echo $combined_data[0]['Publications'];
echo "</td>";
echo "</tr>";	

echo "<tr>";
echo "<td align='left'>";
echo 'Number of Phenotypes in the database';
echo "</td>";
echo "<td align='left'>";
echo $combined_data[0]['Phenotypes'];
echo "</td>";
echo "</tr>";	

echo "<tr>";
echo "<td align='left'>";
echo 'Number of Distinct Genes in the database';
echo "</td>";
echo "<td align='left'>";
echo $combined_data[0]['Distinct_Genes'];
echo "</td>";
echo "</tr>";	

echo "<tr>";
echo "<td align='left'>";
echo 'Number of Gene entries in the database';
echo "</td>";
echo "<td align='left'>";
echo $combined_data[0]['Total_Genes'];
echo "</td>";
echo "</tr>";	

echo "</table>";
	echo '</fieldset>';	
echo '<h3>Use the dropdown box to select the frequence of genes occurrence to show. <br />
Only a few genes occur in many phenotypes whilst there are many genes that occur in only a few </h3>';
echo '<br />';

form_dropdown_gene_occurrence($postdata);

$query01 = sprintf("
SELECT 
	Feature_Name, Gene_Name, Occurence, SGD_Description, SGDID
FROM 
	combined_data
WHERE
	Occurence >= '". $postdata['occur'] ."'
GROUP BY
	SGDID
ORDER BY Occurence DESC");

$intersection_data_genes = get_assoc_array($query01);
	
echo '<h2>There are <font color="red">';
echo count($intersection_data_genes);
echo '</font> genes that occurrence in more than <font color="red">';
echo $postdata['occur'];
echo '</font> phenotype(s)</h2>';
echo '<br />';

/////////////////
echo '<fieldset>';	
?>  
<a href="javascript:;" onClick="toggle_it('tag')">Show/Hide +/- gene cloud</a>
<?php
echo '<div id="tag" style="display :inline;">';
?>
    <div id="wrapper">
        <?php 
        print tag_cloud($postdata['occur']); 
        ?>
    </div>
</div>
<?php
echo '</fieldset>';	

//show_array($intersection_data_genes);
	echo '<fieldset>';	

echo "<table class=\"box-table-a\" summary=\"\">";
echo "<th align='center' width='5%'>No.</th>";
echo "<th align='center' width='10%'>Feature /Gene Name</th>";
echo "<th align='center' width='10%'>Link to ...</th>";		
echo "<th align='center' width='5%'>Occurrence</th>";
echo "<th align='center' width='65%'>SGD_Description</th>";		
echo "<th align='center' width='5%'>SGDID</th>";		
$count_ppi=0;
foreach($intersection_data_genes as $v){
$count_ppi++;

	if($v['Occurence'] >= $postdata['occur']){
		echo "<tr>";
		echo "<td align='center'>". $count_ppi . "</td>";
		echo "<td align='center'>" . $v['Feature_Name'] .'<br /><font color= "Red"><b>'. $v['Gene_Name'] . "</b></font></td>";
		echo "<td align='center'>";
		
		?>
			<form method="get" action="GeneDetails.php">
			<input name="YDL_node" type="hidden" value="<?php echo $v['Feature_Name'];?>">
			<input class="submitbutton" type="submit" value="Gene Details" name="submit">
			</form> 
		<?php
		echo "</td>";
		echo "<td align='center'>". $v['Occurence'] . "</td>";
		echo "<td align='left'>". $v['SGD_Description'] . "</td>";
		echo "<td align='center'>". $v['SGDID'] . "</td>";
		echo "</tr>";	
	}
}
echo "</table>";
	echo '</fieldset>';	
?>

</p>
</body>

<?php
require_once('./footer.php');
?>	
