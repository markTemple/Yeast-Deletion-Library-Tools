<?php
require_once('./header.php');
//show_array($_GET);
?>

<head><title></title></head>
<body>

<p>

<?php

$x=1;


$node_for_query = 'YML007W';//default value prior to select
//set dropbox to selected value otherwise the default value is used
if(isset($_GET['YDL_node'])){
	$node_for_query = $_GET['YDL_node'];
}
//simple independent lookup of SGD table for gene details
	$SGD_gene = get_row_from_SGD_features('Feature_Name', $node_for_query);
	echo '<h1>Gene Details of <font color="red">'.$SGD_gene[0]['Standard_gene_name'].' '.$SGD_gene[0]['Feature_Name'].'</font></h1>';
	//echo '<h1>Gene Details of <font color="red">'.$SGD_gene[0]['Gene_Name'].' '.$SGD_gene[0]['Feature_Name'].'</font></h1>';

echo "<fieldset>";
//gets dropdown genelist from by calling second function "get_YDL_GeneList" that calls combined_data
form_select_YDL_gene($node_for_query);
//if($_GET['submit'] == 'Gene Details'){


/*$verified_gene = genename_lookup($node_for_query);
$node_for_query = $verified_gene[0]['Feature_Name'];
$verified_gene[0]['Standard_gene_name'];
show_array($verified_gene);
?>
<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="text" name="YDL_node">
<?php //echo (!isset($_GET['node_for_query']))?(""):($_GET['node_for_query']) ?>
<br>
<input type="submit" value="<?php echo 'Gene Details';?>" name="submit">
</input>
<br>
<?php
*/


	/////////////////////////////////////////
	$query = sprintf("
		SELECT 
			sgd_id,
			Standard_gene_name,
			Feature_Name,
			Feature_Type,
			Feature_qualifier,	
			Parent_feature_name,
			Genetic_position,
			Description
		FROM 
			SGD_features
		WHERE
			SGD_features.Feature_Name = '".$SGD_gene[0]['Feature_Name']."'	
			");
	$sgd_features = get_assoc_array($query);
		echo "<table width='100%' border='0' cellpadding='2' cellspacing='2'>";
		
			echo "<th align='center' width='5%'>sgd_id.</th>";
			echo "<th align='center' width='10%'>Standard_gene_name</th>";
			echo "<th align='center' width='10%'>Feature_Name</th>";		
			echo "<th align='center' width='5%'>Feature_Type.</th>";
			echo "<th align='center' width='10%'>Feature_qualifier</th>";
			echo "<th align='center' width='10%'>Parent_feature_name</th>";		
	
				echo "<tr>";
				echo "<td align='center'>". $sgd_features[0]['sgd_id'] . "</td>";
				echo "<td align='center'>". $sgd_features[0]['Standard_gene_name'] .'</a>'. "</td>";
				echo "<td align='center'>". $sgd_features[0]['Feature_Name'] . "</td>";
				echo "<td align='center'>". $sgd_features[0]['Feature_Type'] . "</td>";
				echo "<td align='center'>". $sgd_features[0]['Feature_qualifier'] .'</a>'. "</td>";
				echo "<td align='center'>". $sgd_features[0]['Parent_feature_name'] . "</td>";
				echo "</tr>";
				
		echo "</table>";
			echo '<br />';
			echo '<b>Description</b> '.$sgd_features[0]['Description'];
			echo '<br />';
	
//	echo '</fieldset>';	
//	echo '<br />';	
	
	/////////////////////////////////////////
	$query = sprintf("
		SELECT 
			phenotypeID,
			paperID,
			PheChem AS Phenotype,
			citation
		FROM 
			combined_data
		WHERE
			combined_data.Feature_Name = '".$SGD_gene[0]['Feature_Name']."'	
		ORDER BY citation ASC, Phenotype ASC
			");
	$combined_data = get_assoc_array($query);
			
//	echo "<fieldset>";
	echo '<h2>This gene is present in <font color="blue">'; echo count($combined_data); echo "</font> Phenotypes</h2>";
	echo '<fieldset>';	
	//show_array($combined_data);
	?>   
	<a href="javascript:;" onClick="toggle_it('Phenotypes<?php echo $x;?>')">Show/Hide +/- Phenotypes</a>
			<?php

			
			echo '<div id="Phenotypes'.$x.'" style="display :none;">';
	
		echo "<table class=\"box-table-a\" summary=\"\">";
		if (!empty($combined_data)){
			echo "<th align='center' width='5%'></th>";
			echo "<th align='center' width='10%'>Link</th>";
			echo "<th align='center' width='35%'>Phenotype</th>";
			echo "<th align='center' width='50%'>Citation</th>";		
			$x=1;
			foreach($combined_data as $cd){
				echo "<tr>";
				echo "<td align='left'>";
				echo $x;
				echo "</td>";
				
				echo "<td align='left'>";

				?>
				<form method="get" action="./queryLOOP.php">
				<input name="phenotypeID" type="hidden" value="<?php echo $cd['phenotypeID'];?>">
				<input name="paperID" type="hidden" value="<?php echo $cd['paperID'];?>">
				<input name="Intersects" type="hidden" value="value">
				<input class="submitbutton" type="submit" value="Intersects" name="submit">
				</form> 

				<?php 
				echo "</td>";
				echo "<td align='left'>". $cd['Phenotype'] .'</a>'. "</td>";
				echo "<td align='left'>". $cd['citation'] . "</td>";
				echo "</tr>";
				$x++;
			}
		}else{ 
			echo "<tr><td>This gene does not occur in any phenotype!</td></tr>";
		}
		echo "</table>";
	
	echo '</div>';//end hide Phenotypes
	echo '</fieldset>';	

	echo '</fieldset>';	
	
	/////////////////////////////////////////
	$query = sprintf("
			SELECT 
				SGDID, GO_Aspect, GO_Slim_term, GOID	
			FROM 
				go_slim_mapping		
			WHERE
				go_slim_mapping.ORF = '".$SGD_gene[0]['Feature_Name']."'		
				");
	$go_slim_mapping = get_assoc_array($query);
			
	echo "<fieldset>";
	echo '<h2>Details of <font color="red">'.$SGD_gene[0]['Standard_gene_name'].' '.$SGD_gene[0]['Feature_Name'].'</font> from go_slim_mapping</h2>';
	
		echo "<table class=\"box-table-a\" summary=\"\">";

		if (count($go_slim_mapping) > 0){
			echo "<th align='center'>GO_Aspect</th>";
			echo "<th align='center'>GO_Slim_term</th>";
			echo "<th align='center'>GOID</th>";		
	
			foreach($go_slim_mapping as $gsm){
			
			if($gsm['GO_Aspect'] == 'P') $gsm['GO_Aspect'] = 'Process';
			if($gsm['GO_Aspect'] == 'F') $gsm['GO_Aspect'] = 'Function';
			if($gsm['GO_Aspect'] == 'C') $gsm['GO_Aspect'] = 'Component';

				echo "<tr>";
				echo "<td align='center'>". $gsm['GO_Aspect'] . "</td>";
				echo "<td align='center'>". $gsm['GO_Slim_term'] .'</a>'. "</td>";
				echo "<td align='center'>". $gsm['GOID'] . "</td>";
				echo "</tr>";
			}
		}else{ 
			echo "<tr><td>No Results found!</td></tr>";
		}
		echo "</table>";
	
	echo '</fieldset>';	
	echo '<br />';	
//}

?>


<?php 
//foreach($MYSQLquerys as $k => $v){
//	$query = $v[1];
//	$tables["$k"] = get_assoc_array($query);
//	//show_array($tables);
////	$result = mysql_query($query);
////	print_result_table($result);		
//}


	
//	show_array($tables['combined_data']);
//	
//	show_array($tables['go_slim_mapping']);

	

//echo "This is line " . __LINE__ ." of file " . __FILE__;

?>
	</p>


</body>

<?php
require_once('./footer.php');
?>	
