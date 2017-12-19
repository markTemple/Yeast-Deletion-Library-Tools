<?php
require_once('./header.php');
include('./database.java');


//to do
//show_array($postdata);

?>	

<h1>Enter Geneset to Intersect against the Deletion Screen Database</h1>
<br />

<!--<form method="get" action="queryLOOP.php">
-->

<fieldset>

<div class="gene_wrapper">

    <div class="gene_left_box">
<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
<textarea cols="10" name="user_data" rows="20" onFocus="clearText(this)" >
<? echo (!isset($_GET['user_data']))?("MRPL13\nMRPL16\nMRPL17\nMRPL20\nMRPL13\nMRPL16\nMRPL17\nMRPL20\nMRPL22\nMRPL35\nMRPL51\nMRPL7\nMRPL9\nMRPS12\nMRPS16\nMRPS35\nMRPS8\nMSF1\nMTF2\nPET112\nQCR7\nREG1\nRIM1\nRPE1\nRRG7\nRRG8\nRSM19\nRTT109\nSKN7\nSLA1\nSRB5\nSSQ1\nSTB5\nTKL1\nYAP1\nYDL068W\nABF2\nAEP1\nARV1\nATP5\nCCC1\nCGI121\nCOQ1\nCOR1\nEOS1\nGLO3\nGND1\nHFI1\nHMI1\nIMG1\nISM1\nLCB5\nMBP1\nMCK1\nMEF2\nMGM101\nMRP10\nMRPL11"):($_GET['user_data']) ?>
</textarea>
<br>

	<?php	
	if(!isset($postdata['pvalue'])){
$postdata['pvalue'] = '0.000001';
}

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
	<b> Select p value</b>'
	<select name="pvalue">
	<?php
	
	foreach($pval_array as $k => $pvalue){
		
		if($k == $postdata['pvalue']){ 
			$stickyForm ='selected="selected"'; 
		}

		echo "<option $stickyForm".' value="'.$k.'">'.$pvalue.'</option>';
		$stickyForm = '';
	}
	?>	
<input class="submitbutton" type="submit" value="Submit GeneSet" />
</form>
		 </div>

<?php
//$postdata['user_data'] = trim($postdata['user_data']);//later validate properly?

//if ( (isset($postdata['user_data'])) and (!empty($postdata['user_data'])) ) {
		
	if(isset($_GET['user_data'])){
		$user_data_array = preg_split("/[\r\n,]+/", $_GET['user_data']);
		//show_array($user_data_array);
		sort($user_data_array);
		$user_data_array = array_unique($user_data_array);
		//show_array($user_data_array);
		$x=1;
		foreach($user_data_array as $data){
			$data = trim($data);
			if($data != ''){
				$lookup_data = genename_lookup($data);
				//show_array($lookup_data);
				//gene sgd gene details
				$User_Data['Feature_Name'][$x] = $lookup_data[0]['Feature_Name'];
				$User_Data['Standard_gene_name'][$x] = $lookup_data[0]['Standard_gene_name'];
				$result = get_row_from_SGD_features('Feature_Name', $lookup_data[0]['Feature_Name']);
				$User_Data['feature_link'][$x] = $result[0]['feature_link'];
				$User_Data['Description'][$x] = $result[0]['Description'];
				$User_Data['Feature_qualifier'][$x] = $result[0]['Feature_qualifier'];
			$x++;
			}
		}
	}

	//show_array($User_Data['Feature_Name']);
	
if ( (isset($postdata['user_data'])) and (!empty($postdata['user_data'])) and (!empty($User_Data['Feature_Name'][1]))) {

	$MYSQLquery01 = "
	SELECT DISTINCT phenotypeID FROM combined_data
	";
	
	$result = mysql_query($MYSQLquery01)or die(mysql_error()); 
	
	$x2 = 1;
	while ($array_eachPHE_combData = mysql_fetch_assoc($result))
	{
	
	//echo $array_eachPHE_combData['phenotypeID'];
//	echo '<br />';
	
		$MYSQLquery02 = "SELECT
		combined_data.phenotypeID, combined_data.Gene_Name, combined_data.Feature_Name, combined_data.PheChem, combined_data.citation, combined_data.paperID, comb_paper_data.count
		FROM combined_data, comb_paper_data
		WHERE combined_data.phenotypeID = '".$array_eachPHE_combData['phenotypeID']."'
		AND comb_paper_data.phenotypeID = '".$array_eachPHE_combData['phenotypeID']."'
		";
		
		$result02 = mysql_query($MYSQLquery02)or die(mysql_error()); 
	
		while ($Gene_attributes_from_combData = mysql_fetch_assoc($result02))
			{
			//echo $Gene_attributes_from_combData['phenotypeID'];
			//echo '<br />';
			$phenotypeID_list[$x2]['Feature_Name'][] = $Gene_attributes_from_combData['Feature_Name']; 
			$phenotypeID_list[$x2]['Gene_Name'][] = $Gene_attributes_from_combData['Gene_Name']; 
			$phenotypeID_list[$x2]['PheChem'] = $Gene_attributes_from_combData['PheChem']; 
			$phenotypeID_list[$x2]['citation'] = $Gene_attributes_from_combData['citation']; 
			$phenotypeID_list[$x2]['phenotypeID'] = $Gene_attributes_from_combData['phenotypeID']; 
			$phenotypeID_list[$x2]['paperID'] = $Gene_attributes_from_combData['paperID']; 
			$phenotypeID_list[$x2]['count'] = $Gene_attributes_from_combData['count']; 
			}
	$x2++;		
	unset($Gene_attributes_from_combData);
	}
	//show_array($phenotypeID_list);//phe_id to orf lists
	
	$n = count($User_Data['Feature_Name']);
	$N = 6500;

	$x = 0;
		
	foreach($phenotypeID_list as $k1 => $ORF_array){
		
		
		/////////////////////echo $count = count($ORF_array[$k1]['Feature_Name']);
		
		$ORF_array['Feature_Name'] = array_unique($ORF_array['Feature_Name']);//hack


		$int_result = array_intersect($ORF_array['Feature_Name'], $User_Data['Feature_Name']);
		$keys = array_keys($int_result);
		
		//show_array($keys);

		$intersect_genenames = '';
		foreach($keys as $index){
			$intersect_genenames[] = $ORF_array['Gene_Name'][$index];
		}
		//show_array($intersect_genenames);
		
		
		if(!empty($int_result)){
		
		
			$M = $ORF_array['count'];//count taken from mysql value
			$m = count($int_result);
			
			$p = pvalue($N,$M,$n,$m);


//			if($p <= 0.00005){
			if($p <= $postdata['pvalue']){
			$x++;
				$intersect[$x]['pval'] = $p;
				$intersect[$x]['intersection'] = implode(', ', $int_result);
				$intersect[$x]['count_intersection'] = count($int_result);
				$intersect[$x]['intersection_Gene_Name'] = implode(', ', $intersect_genenames);
				$intersect[$x]['Feature_Name'] = implode(', ', $ORF_array['Feature_Name']);
				$intersect[$x]['Gene_Name'] = implode(', ', $ORF_array['Gene_Name']);
				$intersect[$x]['PheChem'] = $ORF_array['PheChem'];
				$intersect[$x]['citation'] = $ORF_array['citation'];
				$intersect[$x]['phenotypeID'] = $ORF_array['phenotypeID'];
				$intersect[$x]['paperID'] = $ORF_array['paperID'];
				$intersect[$x]['User_gene_name'] = implode(', ', $User_Data['Standard_gene_name']);
				$intersect[$x]['User_Feature_Name'] = implode(', ', $User_Data['Feature_Name']);
				$intersect[$x]['count_genes'] = count($User_Data['Feature_Name']);
				$intersect[$x]['count_DBgenes'] = count($ORF_array['Feature_Name']);
				
			}
		}
	}
	
	
	//sort by pvalue
	//show_array($intersect);//phe_id to p val and intersecting orf lists etc
	
	if(count($intersect) >= 1){
		foreach ($intersect as $key => $row) {
			$pv[$key]  = $row['pval']; 
		}
		array_multisort($pv, SORT_DESC, $intersect);
	}
	//show_array($intersect);//phe_id to p val and intersecting orf lists etc	
	
	$howmany_g = count($User_Data['Feature_Name']);
	echo '<br /><h2>There are <font color="red">'.$howmany_g.'</font> validated genes in the query</h2>';
	if($howmany_g >= 1){
	
?>
    <div class="gene_right_box">

<?php			
			//toggle via js from sonification
			?>
			 
			<a href="javascript:;" onClick="toggle_it('genedetail')" >Show/Hide +/-</a>
			<b>Show geneset summary</b>
            			<hr>

			<div id="genedetail" name="user geneset table" style="display:none;">

			<?php
			echo "<table class=\"box-table-a\" width='680px'>";
			echo "<th align='center' width='40px'>No.</th>";
			echo "<th align='center' width='40px'> Link to SGD <br /> Gene Name</th>";
			echo "<th align='center' width='100px'>Qualifier</th>";
			echo "<th align='center' width='500px'>Description</th>";

			
			//show_array($User_Data['Standard_gene_name']);
			foreach($User_Data['Standard_gene_name'] as $ud_k => $ud_v){
			
				echo '<tr>';
				echo "<td align='left' width='40px'>";
				echo $ud_k;
				echo "</td>";
							
				echo "<td align='left' width='40px'>";
				echo $User_Data['feature_link']["$ud_k"];
				echo '<br />';
				echo $ud_v;
				echo "</td>";
							
							
				echo "<td align='left' width='100px'>";
		?>
			<form method="get" action="GeneDetails.php">
			<input name="YDL_node" type="hidden" value="<?php echo $User_Data['Feature_Name']["$ud_k"];?>">
			<input class="submitbutton" type="submit" value="Gene Details" name="submit">
			</form> 
		<?php
				echo "</td>";
							
				echo "<td align='left' width='500px'>";
				echo $User_Data['Description']["$ud_k"];
				echo "</td>";
				
				echo "</tr>";
			}
					
			echo '</table>';			
			echo '</div>';
			
?>
   </div>
    <div class="gene_footer">
    </div>
</div>


<?php			
			echo "</fieldset>";	
	}
	
	$howmany = count($intersect);
	echo '<h2>There are <font color="red">'.$howmany.'</font> intersection results for you query</h2>';
	if($howmany >= 1){
		foreach($intersect as $k => $v){
		$numb = $k+1;
			echo "<fieldset>";	
			echo "<table class=\"box-table-a\" summary=\"\">";
			
			echo "<th align='center' width='10%'>"."$numb"."</th>";
			echo "<th align='center' width='90%'>Manual Intersection Details</th>";
			
					
			echo '<tr>';			
			echo "<td align='left' width='10%'>";
			echo '<b>Publication : </b>';
			echo "</td>";
			echo "<td align='left' width='90%'><b>";
			echo $v['citation'];
			echo '</b></tr>';	
			
			echo '<tr>';			
			echo "<td align='left' width='10%'>";
			echo '<b>Phenotype : </b>';
			echo "</td>";
			echo "<td align='left' width='90%'>".'<font color="red">';
			
		$var_graph = '';
		$venn_label_int = '';
		$venn_sets_int = '';
		$venn_label_int .= '{"sets": [0], "label": "user geneset", "size": '.$v['count_genes'].'},';
		$venn_label_int .= '{"sets": [1], "label": "'.$v['PheChem'].'", "size": '.$v['count_DBgenes'].'},';
		$venn_sets_int .= '{"sets": [0, 1], "size": '.$v['count_intersection'].'}';
		$var_graph = 'var sets = ['.$venn_label_int.$venn_sets_int.']';
		echo '<script>'.$var_graph.'</script>';
		$wdth = 400;
		$hght = 150;
		$divID = $v['phenotypeID'];
		include('./D3_venn.php');	
			
			echo $v['PheChem'];
			echo '</font> (genes : </b><font color="red">';
			echo $v['count_DBgenes'];
			echo '</font>) &nbsp;&nbsp;';
			
			?>
			<form method="get" action="./queryLOOP.php">
			<input name="phenotypeID" type="hidden" value="<?php echo $v['phenotypeID'];?>">
			<input name="paperID" type="hidden" value="<?php echo $v['paperID'];?>">
			<input name="Intersects" type="hidden" value="value">
			<input class="submitbutton" type="submit" value="Intersects" name="submit">
			</form>
			<?php
			
			
			echo '</tr>';	
			
			echo '<tr>';			
			echo "<td align='left' width='10%'>";
			echo '<b>p Value : </b>';
			echo "</td>";
			echo "<td align='left' width='90%'>";
			$pv = sprintf("%.3e\n", $v['pval']);
			echo $pv;
			echo '</tr>';	
			
			echo '<tr>';			
			echo "<td align='left' width='10%'>";
			echo '<b>Intersecting genes : </b>';		
			echo "</td>";
			echo "<td align='left' width='90%'>";
			echo $v['intersection_Gene_Name'];
			echo '<b> (genes : </b>';
			echo $v['count_intersection'];
			echo ')';
			echo '</tr>';	
					
			echo '</table>';			

			echo "</fieldset>";	
		}
	}else{
		echo "<fieldset>";	
		echo 'There are no results,  This could be because there are no common genes or because the p value of the intersection was not lower than the filter value (try setting a larger p value?)';
		echo "</fieldset>";	
	}
}else{
?>


    <div class="gene_footer">
    </div>

</div>

<?php			
	if(isset($postdata['submit'])){
		if($postdata['submit'] == "Submit GeneSet"){
			echo '<h2>No valid gene or ORF names were detected in the query</h2>';
			echo "<fieldset>";	
			echo 'please try again......';
			echo "</fieldset>";	
		}
	}
}



require_once('./footer.php');
?>	