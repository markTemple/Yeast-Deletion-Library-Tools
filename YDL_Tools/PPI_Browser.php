<?php
require_once('./header.php');
//show_array($_GET);

?>
<head><title></title></head>
<body>
<p>

<?php
$node_for_query = 'YLR182W';//default value prior to select
//set dropbox to selected value otherwise the default value is used
if(isset($_GET['PPI_node'])){
	$node_for_query = $_GET['PPI_node'];
}


$row_from_SGD_features = get_row_from_SGD_features('Feature_Name', $node_for_query);



echo '<h1>Interaction Details <font color= "red">'.$row_from_SGD_features[0]['Standard_gene_name'].'</font> ('.$node_for_query.')</h1>';
echo '<fieldset>';
form_select_SGD_gene($node_for_query);
echo '<br />';

//if($_GET['submit'] == 'PPI Details'){
echo '<b>Standard_gene_name</b> '.$row_from_SGD_features[0]['Standard_gene_name'];
echo ' / ';
echo '<b>Feature_Name</b> '.$row_from_SGD_features[0]['Feature_Name'];
echo ' / ';
echo '<b>Alias</b> '.str_replace ('|' , ', ' , $row_from_SGD_features[0]['Alias']);

//if($row_from_SGD_features[0]['Alias'] == ''){ echo 'none';}
	echo '<hr />';
	echo '<b>Description</b> '.$row_from_SGD_features[0]['Description'];
	echo '<hr />';
	echo '<b>Feature_Type</b> '.$row_from_SGD_features[0]['Feature_Type'];
	echo ' / ';
	echo '<b>Feature_qualifier</b> '.$row_from_SGD_features[0]['Feature_qualifier'];
	echo ' / ';
	echo '<b>Parent_feature_name</b> '.$row_from_SGD_features[0]['Parent_feature_name'];
	echo '<hr />';
	echo '<b>Deletant</b> <font color= "Red"> '.$row_from_SGD_features[0]['Deletant'].'</font>';
	echo ' / ';
	
	echo '<b>SGD link </b><a href="http://www.yeastgenome.org/cgi-bin/locus.fpl?dbid='
	.$row_from_SGD_features[0]['sgd_id']
	.'" target="_blank">'
	.$row_from_SGD_features[0]['sgd_id']
	.'</a>';

	$query_pi1 = sprintf("
	SELECT 
	intdat_id, Feature_Name_Hit AS Feature_Name, Standard_Gene_Name_Hit AS Standard_Gene_Name, Experiment_Type, Genetic_or_Physical_Interaction, Citation, DeletantFNH AS BlackRed
	FROM `interaction_data`  
	WHERE `Feature_Name_Bait` = '"
	.$node_for_query."' AND
	Genetic_or_Physical_Interaction = 'physical interactions'
	");		

	$query_pi2 = sprintf("
	SELECT 
	intdat_id, Feature_Name_Bait AS Feature_Name, Standard_Gene_Name_Bait AS Standard_Gene_Name, Experiment_Type, Genetic_or_Physical_Interaction, Citation, DeletantFNB AS BlackRed
	FROM `interaction_data`  
	WHERE `Feature_Name_Hit` = '"
	.$node_for_query."' AND
	Genetic_or_Physical_Interaction = 'physical interactions'
	");		

	$query_gi1 = sprintf("
	SELECT 
	intdat_id, Feature_Name_Hit AS Feature_Name, Standard_Gene_Name_Hit AS Standard_Gene_Name, Experiment_Type, Genetic_or_Physical_Interaction, Citation, DeletantFNH AS BlackRed
	FROM `interaction_data`  
	WHERE `Feature_Name_Bait` = '"
	.$node_for_query."' AND
	Genetic_or_Physical_Interaction = 'genetic interactions'
	");
	
	$query_gi2 = sprintf("
	SELECT 
	intdat_id, Feature_Name_Bait AS Feature_Name, Standard_Gene_Name_Bait AS Standard_Gene_Name, Experiment_Type, Genetic_or_Physical_Interaction, Citation, DeletantFNB AS BlackRed
	FROM `interaction_data`  
	WHERE `Feature_Name_Hit` = '"
	.$node_for_query."' AND
	Genetic_or_Physical_Interaction = 'genetic interactions'
	");
	
/////////////////////
	$query_PPI_all = sprintf("
	SELECT Genetic_or_Physical_Interaction, Experiment_Type, count(Experiment_Type) AS count FROM `interaction_data`  
	WHERE (`Feature_Name_Bait` = '"
	.$node_for_query."' OR `Feature_Name_Hit` = '"
	.$node_for_query."' ) 
	GROUP BY Experiment_Type
	ORDER BY 1, 2
	");
	
	$result_pi1 = get_assoc_array($query_pi1);	
	$result_pi2 = get_assoc_array($query_pi2);	
	$result_pi= array_merge($result_pi1,$result_pi2);
	$result_gi1 = get_assoc_array($query_gi1);
	$result_gi2 = get_assoc_array($query_gi2);
	$result_gi= array_merge($result_gi1,$result_gi2);
	
	
	//1 = hit and 2 = bail for pi and gi
	
	//sort by [Standard_Gene_Name]
	//show_array($result_pi);
	//show_array($result_gi);

	
	$tmp = Array(); 
	foreach($result_pi as &$ma) 
		{
    $tmp[] = &$ma["Standard_Gene_Name"]; 
	}	
	array_multisort($tmp, $result_pi); 
	
	$tmp = Array(); 
	foreach($result_gi as &$ma) 
		{
    $tmp[] = &$ma["Standard_Gene_Name"]; 
	}	
	array_multisort($tmp, $result_gi); 
	
	//show_array($result_pi);
	$results_all = array($result_pi, $result_gi);
	//show_array($results_all);

	$result_PPI_all = get_assoc_array($query_PPI_all);	
	//show_array($result_PPI_all);
	
	echo '<br />';
	echo '<br />';
echo "<table class=\"box-table-a\" summary=\"\">";
	echo "<th align='center' width='48%'>Physical Interaction ";echo count($result_pi);echo"</th>";
	echo "<th align='center' width='48%'>Genetic Interaction ";echo count($result_gi);echo"</th>";
	echo "<tr>";
	echo "<td align='center'>";
		foreach($result_PPI_all as $v){
			if($v['Genetic_or_Physical_Interaction'] == 'physical interactions'){
				echo $v['Experiment_Type'];
				echo ' = ';
				echo $v['count'];
				echo '<br />';
			}
		}
	echo "</td>";
	echo "<td align='center'>";
		foreach($result_PPI_all as $v){
			if($v['Genetic_or_Physical_Interaction'] == 'genetic interactions'){
				echo $v['Experiment_Type'];
				echo ' = ';
				echo $v['count'];
				echo '<br />';
			}
		}		
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo '</fieldset>';	
	
	$x=0;	

	foreach ($results_all as $result) {
		
		$x++;
		if($x == '1'){ $PPPorGI = 'Physical Interaction(s)';}
		if($x == '2'){ $PPPorGI = 'Genetic Interaction(s)';}
		
		$count_ppi = count($result);
			echo 
			"<h1><font color= \"red\">".$row_from_SGD_features[0]['Standard_gene_name'].'</font> ('.$node_for_query
			.") displays <font color= \"red\"> ".$count_ppi." </font><font color= \"blue\"> "
			.($PPPorGI)
			."</font> as listed below "
			.'</h1>';
	
			echo '<fieldset>';
			
			?>   
			<a href="javascript:;" onClick="toggle_it('physInt<?php echo $x;?>')">Show/Hide +/- <?php echo $PPPorGI;?></a>
			<?php

			
			echo '<div id="physInt'.$x.'" style="display :none;">';

			
			if($count_ppi > 0){
			$count_ppi = 0;
			foreach ($result as $k => $data) {
			//show_array($data);
				$count_ppi++;
					$type = 'BlackRed';
					$feature = 'Feature_Name';
					$gene = 'Standard_Gene_Name';
				
			echo "<table class=\"box-table-a\" summary=\"\">";
				echo "<th align='left'>";
				
				echo $count_ppi.') ';
				echo "<b>$feature </b><font color= \"red\">".$data["$feature"].'</font> ';
				echo "<font color= \"blue\"><b>".$data["$gene"].'</b></font>';
				if($data[$type] == 'Red') 
					{echo '<font color = "Red"> (Essential, not in YDL homozygous screen data) </font>';}
				echo "</th>";
			echo "</table>";

	echo "<table class=\"box-table-a\" summary=\"\">";
		echo "<tr>";
		echo "<td align='left' width='30%'>";
	
				echo '<b>Experiment_Type </b>'.$data['Experiment_Type'];
	
		echo "</td>";
		echo "<td align='center' width='10%'>";
	
		?>
				<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<input name="PPI_node" type="hidden" value="<?php echo $data["$feature"];?>">
				<input class="submitbutton" type="submit" value="PPI Details" name="submit">
				</form> 
		
		<?php
		echo "</td>";
		echo "<td align='center' width='10%'>";
		?>
				<form method="get" action="GeneDetails.php">
				<input name="YDL_node" type="hidden" value="<?php echo $data["$feature"];?>">
				<input class="submitbutton" type="submit" value="Gene Details" name="submit">
				</form> 
		
		<?php
		echo "</td>";
	echo "</table>";
	
	echo "<table class=\"box-table-a\" summary=\"\">";
		echo "<td align='left' width='30%'>";
				echo '<b>Citation </b>'.$data['Citation'];
		echo "</td>";
	echo "</table>";
				
			}
		}else{
		echo 'no interactions';
		}
		
		echo '</div>';//end hide physInt

	echo '</fieldset>';
	}
	//print_result_table($result);
//}else{
//	//format string for MySQL query
//	$node_for_query = "'".$node_for_query."'";
//}

?>	
</p>
</body>

<?php
require_once('./footer.php');
?>	
