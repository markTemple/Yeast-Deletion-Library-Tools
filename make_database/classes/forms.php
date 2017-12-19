<?php
function form_dropdown_listALL2($papers_phe_array, $paperID, $postdata){

?>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<?php
	if(isset($postdata)){
		echo post_options($postdata);
	}
	?>
	</form>

	<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<select name="paperID" id="paperID" onchange="this.form.submit()">
	<?php
	foreach($papers_phe_array as $k => $paper){
		$short_cit = substr($paper[0]['citation'], 0, 150);	
		if (isset($postdata['paperID'])) {
			if($k == $paperID){ $stickyForm ='selected="selected"'; }
		}
		echo "<option $stickyForm".' value="'.$k.'">'.$short_cit.' </option>';
		$stickyForm = '';
	}
	
	?>	
	</select>
	</form> 
<?php
}


function form_dropdown_listALL($papers_phe_array, $paperID, $postdata){

?>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<?php
	if(isset($postdata)){
		echo post_options($postdata);
	}
	?>
	<select name="paperID">
	<?php
	foreach($papers_phe_array as $k => $paper){
	
		$short_cit = substr($paper[0]['citation'], 0, 150);	
		
		if (isset($postdata['paperID'])) {
			if($k == $paperID){ $stickyForm ='selected="selected"'; }
		}
		echo "<option $stickyForm".' value="'.$k.'">'.$short_cit.' </option>';
		$stickyForm = '';
	}
	?>	
	</select>
	<br />
	<br />
	<input class="submitbutton" type="submit" value="Select Paper" name="submit">
	<input class="submitbutton" type="submit" value="Phenotypes" name="submit">
	</form> 
<?php
}



//Phenotypes
function all_phenotype_one_paper_summary($row_comb_paper_data, $this_many){

	foreach($row_comb_paper_data as $k => $v){

		$numb = $k+1;
		echo '<fieldset>';
		
		?>   
		<a href="javascript:;" onClick="toggle_it('pheSum<?php echo $k?>')" >Show/Hide +/-</a>
		<?php
		
		echo '<h3>Phenotype '.$numb. " of  $this_many".' - <font color="red">'.$v['phenotype'].'</font>';
		echo ' (<font color="blue"><b>'.$v['count'].'</b></font> genes)</h3>';
		//echo $k;
		if($k == 0)
			{
			echo '<div id="pheSum'.$k.'" name="list" style="display :inline;">';
		}else
			{
			echo '<div id="pheSum'.$k.'" name="list" style="display :none;">';
		}

		echo '<font color="blue"><h3>Geneset';
		echo '</h3></font>';
		echo '<font color="grey"><i>';
		echo 'Here is a summary of genes listed in the phenotype';
		echo '</i></font>';	
		echo '<br />';	
		echo $v['genelist'];
		?>
<!--		<form method="get" action="./queryLOOP.php">
		<input name="paperID" type="hidden" value="<?php echo $v['paperID'];?>">
		<input name="phenotypeID" type="hidden" value="<?php echo $v['phenotypeID'];?>">
		<input class="submitbutton" type="submit" value="GeneSet" name="submit">
		</form> 
-->		<?php
		echo '<hr />';
		
		echo '<font color="blue">';
		echo '<h3>Gene Ontology</h3>';
		echo '</font>';
		echo '<font color="grey"><i>';
		echo 'Here is a summary of Gene Ontology terms that map repeatedly to this geneset 
		(the number in brackets referes to the number of mappings)';
		echo '</i></font>';	
		echo '<br />';	
		
		echo '<h4>GO Biological Process (slim) </h4>';
		echo $v['Phenotype_GO_P_terms_lists'];
		echo '<h4>GO Biological Function (slim) </h4>';
		echo $v['Phenotype_GO_F_terms_lists'];
		echo '<h4>GO Component (slim) </h4>';
		echo $v['Phenotype_GO_C_terms_lists'];
		echo '<hr />';

		echo '<font color="blue">';			
		echo '<h3>Protein-protein interactions</h3>';
		echo '</font>';
		
		echo '<font color="grey"><i>';
		echo 'Here is a summary of proteins/genes that are highly connected to the phenotypic geneset 
		(the number in brackets referes only to how many genes of the phenotypic geneset it is connected, multiple connections between any neighbor and phenotypic gene pair is counted only as a single interaction). Listings in <font color="red">red</font> are essential and therefore were not tested in any homozygous deletant screen, those in <font color="blue">blue</font> are not available to be tested';
		echo '</i></font>';
		echo '<br />';	
		
		echo '<h4>Physical Interactions (nearest neighbors) </h4>';
		echo $v['Phenotype_PPI_Phy_NN_unique_lists'];
		echo '<br />';	
		echo '<h4>Genetic Interactions (nearest neighbors) </h4>';
		echo $v['Phenotype_PPI_Gen_NN_unique_lists'];
		
		echo '</div>';//end hide geneList

		echo '</fieldset>';
	}
}


function get_gene_properties($comb_data_all, $row_comb_paper_data){

	echo '<fieldset>';	
	?>   
	<a href="javascript:;" onClick="toggle_it('geneGraph')">Show/Hide +/-</a>
	<?php
	
	echo '<h3>GeneSet Graph - gene location on chromosomes</h3>';
	echo 'The location of each deleted gene of the <font color="red">'.$row_comb_paper_data[0]['phenotype'].'</font> phenotype is indicated across each of the 16 yeast chromosomes in the chart below. Genes close together may be overlapping and may appear darker in colour. ';
	
	
	echo '<div id="geneGraph" name="graph">';
		
		foreach($comb_data_all as $k => $v){
			$SGD_ID_array[]= $v['SGDID'];
		}
		//show_array($SGD_ID_array);
		include('./gene_location.php');
		
	echo 'Genes in the table below are ordered by their chromosomal location and systematic name';
	
	echo '</div>';//end hide graph
	echo '</fieldset>';	

	echo '<fieldset >';
	?>   
	<a href="javascript:;" onClick="toggle_it('geneList')">Show/Hide +/-</a>
	<?php
	echo '<h3>GeneSet Summary - ';
	echo '<font color="red"><b>';
	echo $row_comb_paper_data[0]['phenotype'].'</font> 
	(<font color="blue"><b>'.$row_comb_paper_data[0]['count'].'</b></font> genes)';
	echo '</b></h3>';
	echo '<hr />';
	
	echo '<div id="geneList" name="list">';
	
	$rows = count($comb_data_all);
	echo "<table class=\"box-table-a\" summary=\"\">";
	
	if ($rows > 0){
		echo "<th align='center' width='5%'>Chromosome</th>";
		echo "<th align='center' width='10%'>Feature_Name</th>";
		echo "<th align='center' width='5%'>Gene_Name</th>";
		echo "<th align='center' width='10%'>Link to ...</th>";
		echo "<th align='center' width='5%'>Occurences in all Phenotypes</th>";
		echo "<th align='center' width='10%'>GO count (P/F/C)</th>";
		echo "<th align='center' width='10%'>PPI count (Phy/Gen)</th>";
		echo "<th align='center' width='10%'>Start coordinate (Gene lenth)</th>";
		
		//display the data
		foreach($comb_data_all as $k => $v){
			$count = $k+1;
			echo "<tr>";
			echo "<td align='center'>". substr($v['SGD_Parent_feature_name'], -2) . "</td>";
			echo "<td align='center'>". $v['Feature_Name'] . "</td>";
			echo "<td align='center'>". $v['Gene_Name']. "</td>";
			?>
			<td align='center'>
			<form method="get" action="./GeneDetails.php">
			<input name="YDL_node" type="hidden" value="<?php echo $v['Feature_Name'];?>">
			<input class="submitbutton" type="submit" value="Gene Details" name="submit">
			</form> 
			</td>
			<?php
			if( ($v['Occurence'] > 1) and ($v['Occurence'] < 20) ){ $colour = 'green';}
			if( ($v['Occurence'] > 21) and ($v['Occurence'] < 50) ){ $colour = 'blue';}
			if( ($v['Occurence'] > 51) and ($v['Occurence'] < 100) ){ $colour = 'red';}
			echo "<td align='center'>".'<font color="'.$colour.'">'. $v['Occurence'] . "</font></td>";			
			echo "<td align='center'>". $v['OneGeneGO_Pcnt'] 
			.'/'. $v['OneGeneGO_Fcnt'] .'/'. $v['OneGeneGO_Ccnt'] . "</td>";
			echo "<td align='center'>". $v['OneGenePPI_Phy_cnt'] .'/'. $v['OneGenePPI_Gen_cnt'] . "</td>";
			echo "<td align='center'>". $v['SGD_Start_coordinate'].' ('.$v['Gene_len_bp'] . ")</td>";
			echo "</tr>";
		}
	}else{ 
		echo "<tr><td>No Results found!</td></tr>";
	}
	
	echo "</table>";
	echo '</div>';//end hide geneList
	echo '</fieldset>';	
	
	echo '<fieldset>';	
	?>   
	<a href="javascript:;" onClick="toggle_it('geneDetails')">Show/Hide +/-</a>
	<?php

	echo '<h3>Individual Gene Details</h3> ';

	echo '<div id="geneDetails" name="list">';
	
	foreach($comb_data_all as $k => $v){
		$count = $k+1;
		echo '<fieldset>';	
		
		
		echo "<table class=\"box-table-a\" summary=\"\">";
		echo "<th align='left' width='10%'>";
		echo "<font color=".'"blue"'."><b>". $count . ') </b></font>';
		echo '<b> Gene of Interest : <font color="red">';
			if($v['Gene_Name']!= ''){
				echo $v['Gene_Name'].' / '.$v['Feature_Name'];				
			}else{
				echo $v['Feature_Name'];				
			}
		echo '</font></b>';
		echo "</th>";
		
		echo "<th align='left' width='10%'>";
		?>
		<form method="get" action="./GeneDetails.php">
		<input name="YDL_node" type="hidden" value="<?php echo $v['Feature_Name'];?>">
		<input class="submitbutton" type="submit" value="Gene Details" name="submit">
		</form> 
		<?php
		echo "</th>";
		echo "<th align='left' width='10%'>";
		?>
		<form method="get" action="./PPI_Browser.php">
		<input name="PPI_node" type="hidden" value="<?php echo $v['Feature_Name'];?>">
		<input class="submitbutton" type="submit" value="PPI Details" name="submit">
		</form> 
		<?php
		
		echo "</th>";
		echo "</table>";
		
		echo "<table class=\"box-table-a\" summary=\"\">";
		echo "<tr>";
		echo "<td align='left' width='100%'>";
		echo '<b>SGD Description </b>'.$v['SGD_Description'].'<br />';
		echo '<b>GO slim Process ('.$v['OneGeneGO_Pcnt'].') </b>'.$v['OneGeneGO_P_terms'].'<br />';
		echo '<b>GO slim Function ('.$v['OneGeneGO_Fcnt'].') </b>'.$v['OneGeneGO_F_terms'].'<br />';
		echo '<b>GO slim Component ('.$v['OneGeneGO_Ccnt'].') </b>'.$v['OneGeneGO_C_terms'];
		echo '</td>';
		echo "</tr>";
		echo "</table>";
		
		echo "<table class=\"box-table-a\" summary=\"\">";
		echo "<tr>";
		echo "<td align='left' width='100%'>";
		echo '<font color="black">';			
		echo '<h3>Protein-protein interactions</h3>';
		echo '</font>';
		
		echo '<font color="grey"><i>';
		echo 'Here is a summary of proteins/genes that are connected to the gene of interest. 
		(the number in brackets referes to how many interactions have been documented between the neighbor and phenotypic gene). Listings in 
		<font color="red">red</font> 
		are essential and therefore were not tested in any homozygous deletant screen, those in 
		<font color="blue">blue</font> are not available to be tested';
		echo '</i></font>';
		echo '</td>';
		echo "</tr>";

		echo "<tr>";
		echo "<td align='left' width='100%'>";
		echo '<b>Physical Interactions ('.$v['OneGenePPI_Phy_cnt'].') </b>'.$v['OneGenePPI_Phy_NN'];
		echo '</td>';
		echo "</tr>";
		
		echo "<tr>";
		echo "<td align='left' width='100%'>";
		echo '<b>Genetic Interactions ('.$v['OneGenePPI_Gen_cnt'].') </b>'.$v['OneGenePPI_Gen_NN'];
		echo '</td>';
		echo "</tr>";
		echo "</table>";
		echo '</fieldset>';	
	}
	
	echo '</div>';//end hide geneList

	echo '</fieldset>';	
	echo '<br />';
}

function radio_list_Phenotypes($papers_phe_array, $paperID, $postdata){
	?>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<?php
    $first_intersection = 0;
	echo post_options($postdata);
	foreach($papers_phe_array[$paperID] as $k => $row){
		/*** create the options ***/	
		$stickyForm = '';	
		$phe_counts = count_similar_phe($row['phenotypeID']);
		if(($phe_counts[0]['countPhe'] >= 1) and ($first_intersection == 0) )
			{
			if(isset($postdata['phenotypeID']))
				{//echo 'do nothing';
			}else{
				$first_intersection = 1;
				//echo 'stickyForm = set it';
				$stickyForm ='checked';
				}
		}
		if($row['phenotypeID'] == $postdata['phenotypeID']){
			$stickyForm ='checked';
		}
		if(!isset($postdata['phenotypeID']) and ($first_intersection == 0) ){
			$stickyForm ='checked';
		}

				
	echo "<table class=\"box-table-a\" summary=\"\">";
	echo "<tr>";
	echo "<td align='left' width='100%'>";
		echo '<input type="radio" name="phenotypeID" value="'.$row['phenotypeID'].
		'"'.$stickyForm.'> ';
		
		echo '<b>'.$row['phenotype'].'</b></option>';
		$row_comb_paper_data = get_row_from_comb_paper_data('phenotypeID', $row['phenotypeID']);
		echo ' [Genes (<font color="blue">'.$row_comb_paper_data[0]['count'].'</font>), ';
		echo ' Intersects (<font color="blue">'.$phe_counts[0]['countPhe'].'</font>)]';
		
		
		
	echo "</td>";
	echo "</tr>";	
	echo "</table>";
		$row = '';	
	}	
	?>	
	<br />
    
	<input class="submitbutton" type="submit" value="Intersects" name="submit">
	<input class="submitbutton" type="submit" value="GeneSet" name="submit">
	<input class="submitbutton" type="submit" value="Phenotypes" name="submit">
	</form> 
	<?php
}

function Run_Intersect_Tool($phe_intersects, $phe_name, $postdata, $numb_of_intersects){
	
	
	//$intersect = function() 
//	{ 
//	//show_array(func_get_args());
//	//var_dump(func_num_args());
//	return array_intersect(func_get_arg(0), func_get_arg(1)); 
//}; 


//pull data from intersection tool
//show_array($phe_intersects);// the intersecting genesets to graph

//$mainPhe = '';
//$addSetArr = '';
//$setnumb = '';
//echo $postdata['phenotypeID'];
//echo 'numb_of_intersects = ' .$numb_of_intersects; //one less than number of genesets
$mainPheA = get_intersection_data_mainA($postdata['phenotypeID']);
$mainPheB = get_intersection_data_mainB($postdata['phenotypeID']);
//$mainPheAB[] = array_shift(array_merge($mainPheA, $mainPheB));	

//show_array($mainPheA);// original paper and all phenotypes?
//show_array($mainPheB);// original paper and all phenotypes?

if(!empty($mainPheA[0]) || !empty($mainPheB[0])){
$tmp = array_merge($mainPheA, $mainPheB);
$mainPheAB[] = array_shift($tmp);	
	}else{
$mainPheAB[] = 0;	
	}

//show_array($mainPheA);
//show_array($mainPheB);

//add query set to intersect sets
$addSetArr = array_merge($mainPheAB, $phe_intersects);	//hack
//show_array($addSetArr);

//reset value to include parent phe - merged above
$numb_of_intersects=count($addSetArr);
//if($numb_of_intersects > 3){ $numb_of_intersects = 5;}

for ($i = 0; $i <= ($numb_of_intersects-1); $i++) 
	{
	$setsarray[] = explode(", ",$addSetArr["$i"]['genelist']);
}
$setnumb=count($setsarray);
//add quotation marks to each value just in case - or ' or other symbols cause issues?
foreach($setsarray as $k => $v){
	foreach($v as $v2){
//		if(!empty($v2)){
			$setsarray_new[$k][] = "'".$v2."'";
//		}else{
//			$setsarray_new[$k][] = "'".$v2."'";
//		}
	}
}

//echo $numb_of_intersects;
$venn_label_int = '';
$venn_sets_int = '';
for ($i = 0; $i <= ($numb_of_intersects-1); $i++) 
	{
//echo $numb_of_intersects;
	if($i == '0')
		{ 
		$circleType='Phenotype';
		$venn_label_int .= '{"sets": ['.$i.'], "label": "'.$circleType.': '.$addSetArr["$i"]["phe"].'", "size": '.$addSetArr["$i"]["cnt"].'},';
	
		}else
		{ 
		$circleType='Intersection'.' '.$i;	
		$venn_label_int .= '{"sets": ['.$i.'], "label": "'.$i.'", "size": '.$addSetArr["$i"]["cnt"].'},';
}
		//circle labels and whole set counts
}

for ($i = 1; $i <= ($numb_of_intersects-1); $i++) 
		{
				
		//$set_ij = array($setsarray_new["$i"], $setsarray_new["$j"]);
		//$count_int = count((call_user_func_array($intersect, $set_ij)));
		$venn_sets_int .= '{"sets": [0, '.$i.'], "size": '.$addSetArr["$i"]["Intersection_count"].'}';
		if( ($i <= $numb_of_intersects-1) ) { $venn_sets_int .= ',';}
		
		//echo $i.', '.$j.'size '.$count_int.'<br>';

		
	}	

$var_graph = 'var sets = ['.$venn_label_int.$venn_sets_int.']';

echo '<script>'.$var_graph.'</script>';

$wdth = 600;
$hght = 250;
$divID = 'venn';

//dont show summary graph if there is only one intersect
if($numb_of_intersects > 2)
	{
	include('./D3_venn.php');
}
	if(empty($phe_intersects)){
		//echo '<h3>There are no other phenotyps (genesets) that are similar</h3>';
	}else{
		$x=1;

		foreach($phe_intersects as $v){
			//show_array($v);
		echo "<fieldset>";	
			echo "<table class=\"box-table-a\" summary=\"\">";
			echo "<th align='left' width='100%'>";
			echo '<b>Intersection '.$x.': </b><font color="red">';
			echo $v['cit'];
			echo '</font>';	
			echo '</th>';
			
			echo "<tr align='left' width='100%'>";
			echo '<td>';
			echo '<b>Phenotype : </b><font color="red">';
			echo $v['phe'];
			echo '</font><b> (genes : </b><font color="red">';
			echo $v['cnt'];
			echo '</font>) &nbsp;&nbsp;';
			echo '<b>p Value : </b>';
			echo $v['pvalue'];
									
//			echo ' . . . ';
//			echo $v['cnt'];
//			echo ' ';
//			echo $v['Intersection_count'];
//			echo ' ';
//			echo $addSetArr["0"]["cnt"];

//make small graph for each seperate phenotype
$var_graph = '';
$venn_label_int = '';
$venn_sets_int = '';
$venn_label_int .= '{"sets": [0], "label": "Selected Phenotype", "size": '.$addSetArr["0"]["cnt"].'},';
$venn_label_int .= '{"sets": [1], "label": "'.$v['phe'].'", "size": '.$v['cnt'].'},';
$venn_sets_int .= '{"sets": [0, 1], "size": '.$v['Intersection_count'].'}';
$var_graph = 'var sets = ['.$venn_label_int.$venn_sets_int.']';
//echo '<br>'.$var_graph;//looks good
echo '<script>'.$var_graph.'</script>';

$wdth = 400;
$hght = 150;
$divID = $v['phenotypeID'];

	include('./D3_venn.php');

//echo $v['phenotypeID'];

			echo '</td>';
			echo '</tr>';
			
			echo "<tr align='left' width='100%'>";
			echo '<td>';
			echo '<b>Intersecting genes : </b>';		
			echo $v['Intersection_genes'];
			echo '<b> (genes : </b>';
			echo $v['Intersection_count'];
			echo ')';
			echo '</td>';
			echo '</tr>';
			echo '</table>';

			echo "<table class=\"box-table-a\" summary=\"\">";
			echo "<tr align='left' width='100%'>";
			echo "<td align='left' width='10%'>";
			?>	
			<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<?php
			echo post_options($postdata);	
			$paperID_new = get_row_from_comb_paper_data('phenotypeID', $v['phenotypeID'])
				
			?>
			<input name="phenotypeID" type="hidden" value="<?php echo $v['phenotypeID'];?>">
			<input name="paperID" type="hidden" value="<?php echo $paperID_new[0]['paperID'];?>">
			<input name="Intersects" type="hidden" value="value">
			<input class="submitbutton" type="submit" value="Intersects" name="submit">
			</form> 
			</td>
			<td>
			<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<?php
			echo post_options($postdata);	//hidden values	
			//show_array($postdata);
			$val_intdatID = !empty($postdata['intdatID']) ? $_POST['value'] : '';
			$intersect_row_all = get_row_from_intersection_data('intdatID', $val_intdatID);
			?>
			<input name="intdatID" type="hidden" value="<?php echo $v['intdatID'];?>">
			<input name="setA_phenotypeID" type="hidden" value="<?php echo $intersect_row_all[0]['setA_phenotypeID'];?>">
			<input name="setB_phenotypeID" type="hidden" value="<?php echo $intersect_row_all[0]['setB_phenotypeID'];?>">
			<input name="phenotypeID" type="hidden" value="<?php echo $postdata['phenotypeID'];?>">
			<input name="paperID" type="hidden" value="<?php echo $postdata['paperID'];?>">
			<input name="Intersects" type="hidden" value="value">
			<input class="submitbutton" type="submit" value="Summary" name="submit">
			</form> 
			<?php
			
			echo '</td>';
			echo '</tr>';
			echo '</table>';

			$x++;
		echo "</fieldset>";	
		}
	}
}

function intersection_details($postdata){
	
	$intersection_data = get_row_from_intersection_data('intdatID', $postdata['intdatID']);
	format_text('h1', 'Intersection Summary ', 'Black');
	echo '<fieldset>';
	format_text('h3', $intersection_data[0]['setA_citation'], 'red');
	format_text('h3', $intersection_data[0]['setA_phenotype'], 'blue');
	format_text('b', 'GeneSet : ', 'blue');
	echo $intersection_data[0]['setA_genelist'];
	format_text('b', ' Genes : ', 'red');
	echo $intersection_data[0]['setA_count'];
	echo '<hr />';
	format_text('h3', $intersection_data[0]['setB_citation'], 'red');
	format_text('h3', $intersection_data[0]['setB_phenotype'], 'blue');
	format_text('b', 'GeneSet : ', 'blue');
	echo $intersection_data[0]['setB_genelist'];
	format_text('b', ' Genes : ', 'red');
	echo $intersection_data[0]['setB_count'];
	echo '</fieldset>';
	echo '<br />';

	format_text('h2', 'The Intersecting Geneset (Common to both)', 'Black');
	echo '<fieldset>';
	format_text('h3', 'The Intersection GeneSet', 'red');
	format_text('b', 'Intersection GeneSet : ', 'blue');
	echo $intersection_data[0]['Intersection_genes'];
	echo '<br />';
	format_text('b', ' Genes : ', 'red');
	echo $intersection_data[0]['Intersection_count'];
	echo '<br />';
	format_text('b', ' p value : ', 'black');
	echo $intersection_data[0]['pvalue'];
	echo '<hr />';

	format_text('h3', 'GO terms for the intersection set', 'red');
	format_text('b', 'GO_P_terms : ', 'blue');
	echo $intersection_data[0]['inter_Phenotype_GO_P_terms_lists'];
	echo '<br />';
	format_text('b', 'GO_F_terms : ', 'blue');
	echo $intersection_data[0]['inter_Phenotype_GO_F_terms_lists'];
	echo '<br />';
	format_text('b', 'GO_C_terms : ', 'blue');
	echo $intersection_data[0]['inter_Phenotype_GO_C_terms_lists'];
	echo '</fieldset>';

}

function form_select_SGD_gene($node_for_query){
?>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<select name="PPI_node" size=1 id="PPI_node" onchange="this.form.submit()">
	<?php
	//search by feature name (ORF) and grab gene name for display
	$options_array = get_Sc_GeneList();//returns ORF and genename
	foreach($options_array as $row){
		if($row['Feature_Name'] == "$node_for_query"){
			$Standard_gene_name = $row['Standard_gene_name'];
		}
		/*** create the options ***/
		echo '<option value="'.$row['Feature_Name'].'"';
		if($row['Feature_Name'] == "$node_for_query"){
			echo ' selected';
		}
		echo '>'.$row['Standard_gene_name'].' '.$row['Feature_Name'].'</option>';
	}
	?>
	</select>
<!--	<input class="submitbutton" type="submit" value="<?php echo 'PPI Details';?>" name="submit">
-->	</form> 
	<?php
}

function form_select_YDL_gene($node_for_query){
?>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<select name="YDL_node" size=1 id="YDL_node" onchange="this.form.submit()">
	<?php
	//search by feature name (ORF) and grab gene name for display
	
	$options_array = get_Sc_GeneList();//returns ORF and genename
	//$options_array = get_YDL_GeneList();//returns ORF and genename
	foreach($options_array as $row){
		if($row['Feature_Name'] == "$node_for_query"){
			$Standard_gene_name = $row['Standard_gene_name'];
		}
		/*** create the options ***/
		echo '<option value="'.$row['Feature_Name'].'"';
		if($row['Feature_Name'] == "$node_for_query"){
			echo ' selected';
		}
		echo '>'.$row['Standard_gene_name'].' '.$row['Feature_Name'].'</option>';
	}
	?>
	</select>
<!--	<input class="submitbutton" type="submit" value="Gene Details" name="submit">
-->	</form> 
    
<?php
}


function form_dropdown_intersection($postdata){
	
	$pval_array = array(
	'0.000000000001' => '10E-12',
	'0.000000000000001' => '10E-15',
	'0.00000000000000000001' => '10E-20',
	'0.000000000000000000000000000001' => '10E-30',
	'0.00000000000000000000000000000000000000000000000001' => '10E-50')	
	?>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<?php
//	if(isset($postdata)){
//		//use this in all forms (needs to placed early in form - not sure why???)
//		echo post_options($postdata);
//	}
	?>
	<select name="pvalue" id="pvalue" onchange="this.form.submit()">
	<?php
	
	foreach($pval_array as $k => $pvalue){
		if($k == $postdata['pvalue']){ 
			$stickyForm ='selected="selected"'; 
		}
		echo "<option $stickyForm".' value="'.$k.'">'.$pvalue.'</option>';
		$stickyForm = '';
	}
	?>	
	</select>
	</form> 
<?php
}

function form_dropdown_gene_occurrence($postdata){
	$occurrence = array(70, 60, 50, 40, 30, 20, 10, 5, 1);
	//show_array($pval_array);
	?>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<?php
//	if(isset($postdata)){
//		//created a hidden form value of previous selected options (don't loos the previously selected options)
//		//use this in all forms (needs to placed early in form - not sure why???)
//		echo post_options($postdata);
//	}
	?>
	<select name="occur" id="occur" onchange="this.form.submit()">
	<?php
	
	foreach($occurrence as $numb){
		if($numb == $postdata['occur']){ 
			$stickyForm ='selected="selected"'; 
		}
		echo "<option $stickyForm".' value="'.$numb.'">'.$numb.'</option>';
		$stickyForm = '';
	}
	?>	
	</select>
	</form> 
	<?php
}

function ManualIntersectDrop($papers_phe_array, $paperID_1, $paperID_2, $postdata){
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
	<b>Select paper 1</b>
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
	echo '<font color="red"><h3>' . $papers_phe_array["$paperID_1"][0]['citation'] . '</h3></font>PUBMED ID = ';	
	echo '<a href="http://www.ncbi.nlm.nih.gov/pubmed?term=' . $papers_phe_array["$paperID_1"][0]['PubMed_ID']
	.'" target="_blank">'.$papers_phe_array["$paperID_1"][0]['PubMed_ID'].'</a>';
	?>
	<hr>
	<br />
	<b>Select paper 2</b>
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
	echo '<font color="red"><h3>' . $papers_phe_array["$paperID_2"][0]['citation'] . '</h3></font>PUBMED ID = ';	
	echo '<a href="http://www.ncbi.nlm.nih.gov/pubmed?term=' . $papers_phe_array["$paperID_2"][0]['PubMed_ID']
	.'" target="_blank">'.$papers_phe_array["$paperID_2"][0]['PubMed_ID'].'</a>';

	echo '<hr>';

	?>	
	<br />
	<br />
	<input class="submitbutton" type="submit" value="Manual Intersect" name="submit">
	</form> 
<?php
}

?>
