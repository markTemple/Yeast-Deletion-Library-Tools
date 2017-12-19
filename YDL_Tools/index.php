<?php
require_once('./header.php');
//include('./database.java');

if (!isset($postdata['filter'])) {
$postdata['filter'] = 'show_with_int';
}	

//show_array($postdata);

echo '<h1>Summary of all Papers in the Database</h1>';
$papers_phe_array = all_paper_to_phe_array();
if($postdata['filter'] == 'show_all'){$check1 = 'checked'; $txt = " (including those phenotypes <b><font color=red>without</font></b> intersections)";}else{$check1 ='';}
if($postdata['filter'] == 'show_with_int'){$check2 = 'checked';$txt = " (including only phenotypes <b><font color=red>with</font></b> intersections)";}else{$check2 ='';}

?>
<form method="get" action="./index.php">
<input type="radio" name="filter" onclick="submit();" value="show_all" <?php echo $check1;?>> Show all papers and phenotypes <br />
<input type="radio" name="filter" onclick="submit();" value="show_with_int"<?php echo $check2;?> /> Only show papers or phenotypes with common genes (hide 'No Intersects')
</form> 
<?php

$countPhe=0;
foreach($papers_phe_array as $v)
	{
	foreach($v as $v2)
		{
		$countPhe++;
	}
}
$countPapers = count($papers_phe_array);

if($postdata['filter'] == 'show_with_int'){
	$countPhe=0;
	foreach($papers_phe_array as &$v)
		{
		foreach($v as $k => &$v2)
			{
			if($v2['similar_phe'] == 0)
				{
  				unset($v[$k]);			
			}
		}
	}

	foreach($papers_phe_array as $k => &$v)
		{
		if(count($v) == 0)
			{
			unset($papers_phe_array[$k]);			
		}
	}
	foreach($papers_phe_array as &$v)
		{
		$newa[] = array_values($v);
		foreach($v as $v2)
			{
			$countPhe++;
		}
	}
	$papers_phe_array = $newa;
	unset($newa);
	$countPapers = count($papers_phe_array);
}
//echo $countPhe;
echo '<hr><h3>Table shows phenotypes for <b><font color="red">'.$countPapers.'</font></b> papers and <b><font color="red">'.$countPhe. '</font></b> phenotypes'. $txt.'</h3> ';

	$boho = 1;
	foreach($papers_phe_array as $k => $paper){
	
		echo '<fieldset>';	
		echo "<table class=\"box-table-a\" summary=\"\">";
		echo "<th align='left' width='5%'>";
		echo $boho;
		echo "</th>";
		echo "<th align='left' width='75%'>";
		
		echo $paper[0]['citation'].' ';
		echo '<a href="http://www.ncbi.nlm.nih.gov/pubmed?term='
		.$paper[0]['PubMed_ID'].'"target="_blank">
		PubMed</a>';
		
		echo "</th>";
		echo "<th align='center' width='20%'>";
		?>
		<form method="get" action="./queryLOOP.php">
		<input type="hidden" value="<?php echo $paper[0]['paperID'];?>" name="paperID">
		<input class="submitbutton" type="submit" value="Phenotypes" name="submit">
		</form> 
		<?php
		echo "</th>";
		echo "</table>";

		foreach($paper as $k2 => $phe){
			//$phe_counts = count_similar_phe($phe['phenotypeID']);
			$row_comb_paper_data = get_row_from_comb_paper_data('phenotypeID', $phe['phenotypeID']);
			
			//show_array($row_comb_paper_data);
			//echo $phenotype['phenotype'];
			$phe_numb = $k2+1;
			
			echo "<table class=\"box-table-a\" summary=\"\">";
			echo "<tr>";
			echo "<td align='left' width='60%'>";
			echo $phe_numb.' ) ';
			echo truncate_text($phe['phenotype'], 100);
			echo "</td>";
			
			echo "<td align='left' width='20%'>";
			echo '<font color="blue">[</font>Genes (<font color="blue">'.$row_comb_paper_data[0]['count'].'</font>), ';
			if($phe['similar_phe'] == 1){$string = 'Show intersect';}else{$string = 'Show intersects';}
			
			if($phe['similar_phe'] > 0){
				echo 'Intersects <font color="blue">('.$phe['similar_phe'].'</font>)]';
			}else{
				echo ' No Intersects<font color="blue">]</font>';
			}

		echo "</td>";
	
		echo "<td align='center' width='20%'>";
			if($phe['similar_phe'] > 0){
				?>
				<form method="get" action="./queryLOOP.php">
				<input name="phenotypeID" type="hidden" value="<?php echo $phe['phenotypeID'];?>">
				<input name="paperID" type="hidden" value="<?php echo $paper[0]['paperID'];?>">
				<input name="Intersects" type="hidden" value="value">
				<input class="submitbutton" type="submit" value="Intersects" name="submit">
				</form> 
				<?php
			}else{
				echo ' - ';
			}
		echo "</td>";
	echo "</tr>";	
echo "</table>";

		}
	echo '</fieldset>';	
	$boho++;
	}
//}
?></body>

<?php
require_once('./footer.php');
?>	