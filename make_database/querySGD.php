<?php
require_once('./header.php');

//if (isset($_GET['query'])) $submit=$_GET['query'];
//else $submit='';
ini_set("memory_limit","512M");


//show_array($_GET);
//echo "submit = ".$_GET['submit'];

?>
<head><title></title></head>
<body>
<h2>Properties of the YDL</h2>



<fieldset><legend>Type of Deletant</legend><br />
<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
Select class of deletion to submit<br />
<!--<input type="radio" name="YDL_selected" value="Not Essential" /> Not Essential<br />
-->
<input type="radio" name="YDL_selected" value="Essential" checked/> Essential<br />
<input type="radio" name="YDL_selected" value="not available" /> Not available<br />
<br /><input class="submitbutton" type="submit" value="Submit" name="submit">


<select name="p_val">
<option value="0.05"> 0.05</option>
<option value="0.001"> 0.001</option>
<option value="0.00001"> 0.00001</option>
<option value="0.0000001"> 0.0000001</option>
<option value="0.000000001"> 0.000000001</option>
<option value="0.00000000001"> 0.00000000001</option>
</select>

</form> 
</fieldset>

<br />
<?php
if ($_GET['submit'] == 'Submit') {
	$querychoice = $_GET['YDL_selected'];
}else{ 
	$querychoice='';
}

if($querychoice !== ''){	

//get all genes that are not sensitive to any treatment
//get go terms for these

//GO hyper query process
	$query01 = "
	SELECT DISTINCT
	go_slim_mapping.ORF, go_slim_mapping.GO_Slim_term, 	
	Count(go_slim_mapping.GO_Slim_term) AS GO_countAll
	FROM 
	go_slim_mapping
	GROUP BY
	go_slim_mapping.GO_Slim_term
	";
	$result01 = mysql_query($query01)or die(mysql_error()); 
	
	$query02 = "
	SELECT DISTINCT
	go_slim_mapping.GO_Slim_term, Count(go_slim_mapping.GO_Slim_term) AS GO_countTerm
	FROM 
	combined_data,
	go_slim_mapping
	WHERE
	combined_data.SGDID = go_slim_mapping.SGDID
	and
	Deletant = '".$querychoice."'
	GROUP BY
	go_slim_mapping.GO_Slim_term
	";
	$result02 = mysql_query($query02)or die(mysql_error()); 

	while ($array01 = mysql_fetch_assoc($result01)){
		$all['GO_Slim_term'][] = mysql_real_escape_string($array01['GO_Slim_term']);
		$all['GO_count'][] = mysql_real_escape_string($array01['GO_countAll']);
		
		while ($array02 = mysql_fetch_assoc($result02)){
			$del_type['GO_Slim_term'][] = 
			mysql_real_escape_string($array02['GO_Slim_term']);
			$del_type['GO_count'][] = 
			mysql_real_escape_string($array02['GO_countTerm']);
			
//			if($del_type['GO_Slim_term'] == $all['GO_Slim_term']){
//				echo $all['GO_Slim_term'];
//				echo '<br />';	
//				echo $all['GO_count'];
//				echo '<br />';	
//				echo $del_type['GO_count'];
//				echo '<br />';	
//			}
		}
	}
//echo "This is line " . __LINE__ ." of file " . __FILE__.'<br />';

//show_array($del_type);
//show_array($all);
			
			

	$N = 6500;
	$a=0;
	foreach($all['GO_Slim_term'] as $k => $v)
	{
		foreach($del_type['GO_Slim_term'] as $k2 => $v2)
		{
			if($v == $v2){
				$GO[$a]['term']= $v;
				$GO[$a]['members_n']= $n=$all['GO_count'][$k];
				$GO[$a]['members_M']= $M=$all['GO_count'][$k];//both sets are the GOterm full list
				$GO[$a]['del_type_m']= $m=$del_type['GO_count'][$k2];//intersection are the essentials
				$GO[$a]['p_val']= pvalue($N,$M,$n,$m);
				$a++;
			}
		}
	}

//sort multidimensional array? ...solution from stackoverflow
	foreach ($GO as $key => $row) {
		$pv[$key]  = $row['p_val']; 
	}
	array_multisort($pv, SORT_ASC, $GO);
	
//	show_array($GO);

	echo "<fieldset><legend>results</legend>";
	echo '<h2>Which GO slim mapping terms are over-represented with the <font color="red">'. $querychoice .'</font> deletants</h2>';
	echo '<h3>Selected p value = <font color="red">'.$_GET['p_val'].' </font></h3>';
	echo '<br />';	
	foreach($GO as $v){
	
	//no pval ie =0???? when Not Essential
	//show_array($GO);
	
		if($v['p_val'] < $_GET['p_val']){
				echo '<b>'.$v['term'];
				echo '</b><br />';	
				echo 'Members ='.$v['members_n'];
	//			echo '<br />';	
	//			echo $GO['members_M'][$k];
				echo '<br />';	
				echo "$querychoice =".$v['del_type_m'];
				echo '<br />';	
				echo '<b>The calculated pvalue = </b>';
				printf("%.2e\n", $v['p_val']);
//				echo '<br />';
//				echo $v['p_val'];
				echo '<br />';
				echo '<br />';
		}
	}
	echo '</fieldset>';	

}


?>

</body>

<?php
require_once('./footer.php');
?>	
