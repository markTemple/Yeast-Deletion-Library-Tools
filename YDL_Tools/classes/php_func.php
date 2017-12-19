 <?php
////////////////////////print neat array to webpage for inspection
function show_array($array)
{ 
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

function get_SGD_feature()
{ 
//edit updata sgd feature remove if not ORF
//$count_lookup = 0;

$query = "SELECT sgd_id, Alias FROM SGD_features";
$alia_result = mysql_query($query)or die(mysql_error()); 

while ($alias_line = mysql_fetch_assoc($alia_result))
	{
		if(!empty($alias_line['Alias']))
			{
	
			//echo $alias_line['Alias'];
			//echo '<br />';
			
			$alias = explode('|', $alias_line['Alias']);
			foreach($alias as $v)
				{
					$stlen = strlen($v);
					if ( ($stlen < 10) and ($stlen > 3) ){
					//echo $stlen;
					//echo $v;
					//echo '<br />';
					$v = trim($v);	
					$v = preg_replace('/[^A-Za-z0-9\. -]/', '', $v);	
					$alias_array[] = array($alias_line['sgd_id'] => $v);
				}
			}
		}
}
//show_array($alias_array);

$query = "SELECT keinewID, Ref_PMID, Feature_Name, Gene_Name FROM UWS_Del_Lib_Screen";
$UWSdata_result = mysql_query($query)or die(mysql_error()); 

while ($UWSdata_line = mysql_fetch_assoc($UWSdata_result)) 
	{
//	$count_lookup++;
//echo $UWSdata_line['Feature_Name'];
//echo $UWSdata_line['Gene_Name'];
//echo '<br>';
	$sgd_ID_found = '';
	$SGD_ID_lookup = '';
	$switch_value = '';
	$query = '';
	$SGD_ID_result = '';
	$sgd_ID_found_array = '';
	
	if($UWSdata_line['Feature_Name'] == '') 
		{
		$switch_value = 'Feature_Name_blank';	
	}
	else{
		$switch_value = 'Feature_Name_present';	
	}
	$sgd_ID_found = '';

	switch ($switch_value) 
		{
			
		case 'Feature_Name_present':
		$query = "
		SELECT sgd_id
		FROM SGD_features 
		WHERE SGD_features.Feature_Name = '".$UWSdata_line['Feature_Name']."'
		";
		$SGD_ID_result = mysql_query($query)or die(mysql_error()); 
			
//		echo $count_lookup.' ';
		
		// might not have been matched
		//if Feature_Name is not matched lookup as alias
		//sometines alias has a old feature name
		
		$SGD_ID_lookup = mysql_fetch_assoc($SGD_ID_result);
		
		if($SGD_ID_lookup['sgd_id'])
			{
			$sgd_ID_found = $SGD_ID_lookup['sgd_id'];
		}else
			{
			foreach($alias_array as $v)
				{
				foreach($v as $k => $v2)
					{
					if($v2 == $UWSdata_line['Feature_Name'])
						{
						$sgd_ID_found = $k;
					}
				}
			}
			
			if($sgd_ID_found == '')	// not found in sgd
				{	
				$sgd_ID_found = 'delete';
			}
		}
		break;	
	
		case 'Feature_Name_blank':
		//look for genename and check it in SGD
		$query = "
		SELECT sgd_id 
		FROM SGD_features 
		WHERE SGD_features.Standard_gene_name = '".$UWSdata_line['Gene_Name']."'
		";
		$SGD_ID_result = mysql_query($query)or die(mysql_error()); 
			
		$SGD_ID_lookup = mysql_fetch_assoc($SGD_ID_result);
				
		if($SGD_ID_lookup['sgd_id'])//use the found SGD id
			{
			$sgd_ID_found = '';
			$sgd_ID_found = $SGD_ID_lookup['sgd_id'];
		}else
			{
			//Gene_Name (could be ORF name) not matched look up Feature_Name
			$query = "
			SELECT sgd_id
			FROM SGD_features 
			WHERE SGD_features.Feature_Name = '".$UWSdata_line['Gene_Name']."'
			";
			$SGD_ID_result2 = mysql_query($query)or die(mysql_error()); 
			$SGD_ID_lookup2 = mysql_fetch_assoc($SGD_ID_result2);

			if($SGD_ID_lookup2['sgd_id'])
				{
				//'yes Feature name found - paper used ORF rather than genename
				$sgd_ID_found = $SGD_ID_lookup2['sgd_id'];
			}else
				{
				//Did paper use Alias rather than proper Gene Name
				foreach($alias_array as $v)
					{
					foreach($v as $k => $v2)
						{							
						if($v2 == $UWSdata_line['Gene_Name'])
							{
							//Yes Alias was used - replace with SDG details
							$sgd_ID_found_array[] = $k;
							//show_array($sgd_ID_found_array);
						}
					}
					//else{ $sgd_ID_found = 'not_found';}
				}
				
				if(count($sgd_ID_found_array) < 1)
					{	
					//delete if Alias mapps to more than one gene
					$sgd_ID_found = 'delete';
				}else{
					//keep is Alias maps to single Gene Name
					if(!empty ($sgd_ID_found_array)){
					
					$sgd_ID_found = $sgd_ID_found_array[0];//ERROR
					
					}
					//show_array($UWSdata_line);
					//echo $sgd_ID_found;
				}
				if( ($sgd_ID_found_array == '') and (!$SGD_ID_lookup2['sgd_id']) )
					{
					$sgd_ID_found = 'delete';// author error not present in SGD file
				}
			}
		}
	
		break;	
	}

if($sgd_ID_found == ''){//move to after query!
		echo 'genename = '.$UWSdata_line['Gene_Name'];
		echo '<br>';
		show_array($UWSdata_line);
		//show_array($sgd_ID_found_array);
		
//		echo '<br>';
		//check output for blanks
}

	if($sgd_ID_found == 'delete'){//could also delete ''s
		mysql_query("
		DELETE FROM UWS_Del_Lib_Screen  
		WHERE keinewID = '".$UWSdata_line['keinewID']."'
		")or die(mysql_error());	
	}
		
	$feature_link = '<a href="http://www.yeastgenome.org/cgi-bin/locus.fpl?dbid='.$sgd_ID_found.'">'.$sgd_ID_found.'</a>';
		
	$SGD_feature_result = mysql_query("
	SELECT Standard_gene_name, Feature_Name, sgd_id FROM SGD_features Where sgd_id = '".$sgd_ID_found."'
	")or die(mysql_error());	
	while ($SGD_feature_line = mysql_fetch_assoc($SGD_feature_result)) 
		{									
		mysql_query("
		UPDATE UWS_Del_Lib_Screen 
		SET 
		Gene_Name = '".$SGD_feature_line['Standard_gene_name']."',
		Feature_Name = '".$SGD_feature_line['Feature_Name']."',
		SGDID =  '".$SGD_feature_line['sgd_id']."',
		feature_link = '".$feature_link."'
		WHERE keinewID = '".$UWSdata_line['keinewID']."'
		")or die(mysql_error());	
	}
	
	$pmids[] = $UWSdata_line['Ref_PMID'];
}
$unique_pmids = array_unique($pmids);
//show_array($unique_pmids);

foreach($unique_pmids as $v){
	$gene_literature_result = mysql_query("
	SELECT citation, citation_link, PubMed_ID 
	FROM gene_literature Where PubMed_ID = '".$v."'
	")or die(mysql_error());	

	while ($gene_literature_line = mysql_fetch_assoc($gene_literature_result)) {	
		mysql_query("
		UPDATE UWS_Del_Lib_Screen SET 
		citation = '".$gene_literature_line['citation']."', 
		citation_link = '".$gene_literature_line['citation_link']."',
		Experiment_Type = 'Yeast deletion library screen 96 well plates' 
		WHERE Ref_PMID = '".$gene_literature_line['PubMed_ID']."'
		")or die(mysql_error());	
	}
}
mysql_query("
UPDATE UWS_Del_Lib_Screen SET Gene_Name = Feature_Name WHERE Gene_Name = ".'""'." 
")or die(mysql_error());	
}

function open_database($hostname, $username, $password, $database) {
	//opening mySQL database
	@mysql_connect($hostname, $username, $password);
	@mysql_select_db($database) or die("Unable to select database");
}

function close_database() {
	mysql_close();
}

// query the database and get result
function query_database($query) {
	$result = mysql_query($query);
	if (!$result) {
		die ('Could not query:' . mysql_error());
	} else {
		return $result;
	}
}

// return result as an assoc array
function get_assoc_array($query,$key=null) {
	$res = query_database($query);
	$result = array();
	while ($row = mysql_fetch_assoc($res)) {
		if ($key) {
			$result[$row[$key]] = $row;
		} else {
			$result[] = $row;
		}
	}
	return $result;
}

// return result as an assoc array
function get_p_value() {
	$result = array("0.0001", '0.000001', '0.00000001', '0.0000000001', '0.000000000001');
	
	return $result;
}

function print_result_table($result) {
	if (($result)||(mysql_errno == 0))
	{
	$rowCount=1;
	
	  echo "<table width='100%' border='0' cellpadding='2' cellspacing='2'><tr>";
	  if (mysql_num_rows($result)>0)
	  {
			  //loop thru the field names to print the correct headers
			 echo "<th align='center'> Row </th>";
			  $i = 0;
			  while ($i < mysql_num_fields($result))
			  {
		   echo "<th align='center'>". mysql_field_name($result, $i) . "</th>";
		   $i++;
		}
		echo "</tr>";
	   
		//display the data
		while ($rows = mysql_fetch_array($result,MYSQL_ASSOC))
		{
		  echo "<tr>";
		echo "<th align='center'>".$rowCount."</th>";
			$rowCount++;
		  foreach ($rows as $data)
		  {
			echo "<td align='center'>". $data . "</td>";
		  }
		}
	  }else{
		echo "<tr><td colspan='" . ($i+1) . "'>No Results found!</td></tr>";
	  }
	  echo "</table>";
	}else{
	  echo "Error in running query :". mysql_error();
	} 
}

function form_ONE_query_from_array($fieldset_legend, $MySQL_value_01, $MySQL_value_02, $form_select_name_01, $options_array, $options_array_feild_01, $options_array_feild_02, $input_value, $SQL_01, $SQL_02, $SQL_03, $SQL_04, $SQL_05, $SQL_06)
{ 
	//set dropbox to selected value otherwise the default value is used
		if($_POST['submit'] == $input_value){
			$MySQL_value_01 = $_POST["$form_select_name_01"];
		}
	?>	
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<fieldset><legend><?php echo $fieldset_legend;?> </legend>
	<select name="<?php echo "$form_select_name_01";?>" size=1 >
	<?php	
	//search by feature name (ORF) and grab gene name for display
		foreach($options_array as $row){
			if($row["$options_array_feild_02"] == "$MySQL_value_01"){
				$Standard_gene_name = $row["$options_array_feild_01"];
			}
			/*** create the options ***/
		echo '<option value="'.$row["$options_array_feild_02"].'"';
			if($row["$options_array_feild_02"] == "$MySQL_value_01"){
				echo ' selected';
			}
		echo '>'.$row["$options_array_feild_01"].' '.$row["$options_array_feild_02"].'</option>';
		}
	?>
	</select>
	<input class="submitbutton" type="submit" value="<?php echo "$input_value";?>" name="submit">
	<a href="?"><?php echo "reset page"; ?></a><br />
	</form> 
	<br />
	<?php
	$print_query = $SQL_01.$SQL_02.$SQL_03.'<font size="3" color="red">'.$MySQL_value_01.'</font>'.$SQL_04.'<font size="3" color="red">'.$MySQL_value_01.'</font>'.$SQL_05;
	echo $print_query;
	echo '<br />';
		if($_POST['submit'] == $input_value){
			//format string for MySQL query
			$MySQL_value_01 = "'".$_POST["$form_select_name_01"]."'";
			$query = $SQL_01.$SQL_02.$SQL_03.$MySQL_value_01.$SQL_04.$MySQL_value_01.$SQL_05;
			echo 
			'The following query was performed using <font size="3" color="red">'
			.$Standard_gene_name
			.'</font>'
			.' ('
			.$MySQL_value_01
			.')';
			echo '<br /><br />';
			$result = mysql_query($query);
			print_result_table($result);
		}else{
			//format string for MySQL query
			$MySQL_value_01 = "'".$MySQL_value_01."'";
		}
	echo '</fieldset>';
}


function form_query_01($fieldset_legend, $MySQL_value_01, $form_select_name_01, $options_array, $options_array_feild_01, $options_array_feild_02, $input_value, $SQL_01, $SQL_02, $SQL_03, $SQL_05, $SQL_06)
{ 
	?>
	<fieldset><legend> 
	<?php echo $fieldset_legend;?> 
	</legend>
	<?php	
	//set dropbox to selected value otherwise the default value is used
		if($_POST['submit'] == $input_value){
			$MySQL_value_01 = $_POST['data_for_form_query_01'];
		}
	?>	
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<select name="<?php echo "$form_select_name_01";?>" size=1 >
	<?php	
		//search by feature name and grab gene name for display
		foreach($options_array as $row){
//			if($row["$options_array_feild_01"] == $MySQL_value_01){
//				$Standard_gene_name = $row["$options_array_feild_01"];
//			}
			/*** create the options ***/
		echo '<option value="'.$row["$options_array_feild_01"].'"';
			if($row["$options_array_feild_01"] == $MySQL_value_01){
				echo ' selected';
			}
		echo '>'.$row["$options_array_feild_01"].'</option>';
		}
	?>
	</select>
	<input class="submitbutton" type="submit" value="<?php echo "$input_value";?>" name="submit">
	<a href="?"><?php echo "reset page"; ?></a><br />
	</form> 
	<br />
	<?php
	$print_query = $SQL_01.$SQL_02.$SQL_03.'<font size="3" color="red">'.$MySQL_value_01.'</font>'.$SQL_05;
	echo $print_query;
	echo '<br />';
		if($_POST['submit'] == $input_value){
			//format string for MySQL query
			$MySQL_value_01 = $_POST['data_for_form_query_01'];
			$query = $SQL_01.$SQL_02.$SQL_03.$MySQL_value_01.$SQL_05.$SQL_06;
			//echo $query;
//			echo 
//			'The following query was performed using 
//			<font size="3" color="red">'.$MySQL_value_01.'</font>';
//			echo '<br /><br />';
			$result = mysql_query($query);
			print_result_table($result);
		}else{
			//format string for MySQL query
		//	$MySQL_value_01 = "'".$MySQL_value_01."'";
		}
	echo '</fieldset>';
}

function pvalue($N,$M,$n,$k)
{
	if ($M < $n)
	{
		$min = $M;	
	}
	else
	{
		$min = $n;	
	}

	$pval = 0.0;

	for ($i = $k; $i <= $min; $i++)
	{
		$pval += exp(log_hypergeometric($i, $n, $M, $N));
	}
	return $pval;
}

function log_fact($n) {
	if (!isset($_SESSION['log_fact'][$n])) {
		if (!isset($_SESSION['log_fact'])) {
			$_SESSION['log_fact'] = array();
			$_SESSION['log_fact'][0] = 0; 
			$_SESSION['log_fact'][1] = 0;
		}
		$m = count($_SESSION['log_fact']);
		for ($i = $m; $i <= $n; $i++) {
			$_SESSION['log_fact'][$i] = $_SESSION['log_fact'][$i-1] + log($i);
		}
	}
	return $_SESSION['log_fact'][$n];
}

function nCr($n,$r)
{
	if ($r == 0)
	{
		return log(1.0);
	}
	if ($n == $r)
	{	
		return log(1.0);
	}
        return log_fact($n) -
			( log_fact($r) + log_fact($n-$r) );
}

function
log_hypergeometric($x,$n,$M,$N)
{
	$log_p = nCr($M,$x) +
		 nCr($N - $M, $n - $x) -
		 nCr($N, $n);
	return $log_p;
}

function calculate_pvalue($x,$n,$M,$N)
{
	if ($M < $n)
	{
		$min = $M;	
	}
	else
	{
		$min = $n;	
	}

	$pval = 0.0;

	for ($i = $x; $i <= $min; $i++)
	{
		$pval += exp(log_hypergeometric($i, $n, $M, $N));
	}

	return $pval;
}

function collapse_v($array_multi)
{
	foreach($array_multi as $v){
	//show_array($v);
		foreach($v as $v2){
		//show_array($v);
		//collapse many arrays for a set of genes in one array	
		$array_single[] =  $v2;
		}
	}
	
	return $array_single;
}
	

function string_to_top_hit($string_array, $set)
{
	foreach($string_array as $v){
	//show_array($v);
	$nearestPPI[] = explode(', ', $v);//turn strings into arrays
	}
//		if(!empty($nearPPIall)){
			$nearPPIall = collapse_v($nearestPPI);//see above function
			//this has the effect of making the genename the key
			//and the number of occurences becomes the value
			$ppi_count = array_count_values($nearPPIall);
			
			array_filter($nearPPIall); //no effect?? remove??

			$g = count($ppi_count);//number of connected genes
			$c = array_sum($ppi_count);//number of gene connections
			
			//show_array($ppi_count);	
			
			if($g > 100){
			$cut_val = (round($c/$g)*2);
			}else{
			$cut_val = round($c/$g);
			}
			
//			$cut_val = '2';
			
			switch ($g) {
				case "> 2000":
					$cut_val = (round($c/$g)*8);
					break;
				case "> 900":
					$cut_val = (round($c/$g)*6);
					break;
				case "> 500":
					$cut_val = (round($c/$g)*5);
					break;
				case "> 300":
					$cut_val = (round($c/$g)*4);
					break;
				case "> 150":
					$cut_val = (round($c/$g)*3);
					break;
				case "> 60":
					$cut_val = (round($c/$g)*2);
					break;
				case "> 30":
					$cut_val = (round($c/$g)*1);
					break;
			}
			
			foreach($ppi_count as $ppi => $count){
				if( ($count > $cut_val) and ($ppi != '') ){
				//$key = $set_numb.$count;//delete this what does it do??? DELETED 9.5.2017
				$ppi_high[$set][][$count] = $ppi;//hear we loose the number of occurences in each list gene only passed
				}
			}
//		}
	if(! isset($ppi_high['intersec'][0])){
		$ppi_high = 0;
	}
	return $ppi_high;
}

function remove_keys($array, $count, $keys)
{
	foreach($array["$count"] as $v){
		foreach($keys as $v){
		
			if (array_key_exists("$v", $array["$count"])) {
			unset($array["$count"]["$v"]);
			}
		}
	}
	
	return $array;
}

//function get_list($v, $keys, $count)
//{
////	echo '<br />';
////	echo "$title_array[$k]";
//	foreach($keys as $intersect_keys){
//		$string[] = $v["$count"]["$intersect_keys"];
//		//echo '<br />';
//	}
//	$toplist = string_to_top_hit($string, $a ='intersec');
//	if(!empty($toplist)){
//		foreach($toplist as $set){
//			foreach($set as $numb2term){
//			
//				foreach($numb2term as $numb => $term){
//					//switch this around so that it can be sorted by value note all terms are unique
//					// and therefore to not overwrite each other
//					$term2numb[$term] = $numb;
////					$str .= $term.' ('.$numb.') ';
//				}
//			arsort($term2numb);
//			//$setNew = $term2numb;
//			}
//		}		
//		foreach($term2numb as $term => $numb){
//			$str .= $term.' ('.$numb.') ';
//		}
//			
//		$term2numb = '';
//	//	}
//	}else{
//	$str = 'nil';
//	}
//	//show_array($setNew);
//	//echo $str;
//	//echo '<hr>';
//	
//	return $str;
//}

function get_list($v, $keys, $count, $N, $M_new, $GOterm_pfilter, $man_patch)
{
//	echo '<br />';
//	echo "$title_array[$k]";
	$str = '';

	if($man_patch == 'y'){
		foreach($keys as $intersect_keys){
			$string[] = $v[0]["$count"]["$intersect_keys"];
			//echo ' y <br />';
		}
	}
	if($man_patch == 'n'){
		foreach($keys as $intersect_keys){
			$string[] = $v["$count"]["$intersect_keys"];
			//echo ' n <br />';
		}
	}
	
	//show_array($string);
	
	$toplist = string_to_top_hit($string, $a ='intersec');
	if(!empty($toplist)){
		foreach($toplist as $set){
			foreach($set as $numb2term){
			
				foreach($numb2term as $numb => $term){
					//switch this around so that it can be sorted by value note all terms are unique
					// and therefore to not overwrite each other
					$term2numb[$term] = $numb;
//					$str .= $term.' ('.$numb.') ';
				}
			arsort($term2numb);
			//$setNew = $term2numb;
			}
		}		
	
	//show_array($term2numb);//$k = term name, $v = $m i.e. new intersection numb
	// use name to look up number in actual term = $n
	
	//$n_term = get_term_numb();
		foreach($term2numb as $term => $numb){
		
//			if($type == 'GO'){
				$query = sprintf("
				SELECT DISTINCT
					Count(GO_Slim_term) AS n
				FROM 
					go_slim_mapping
				WHERE
					GO_Slim_term = '".$term."'
				GROUP BY
					GO_Slim_term
				ORDER BY 
					GO_Aspect, GO_Slim_term");
//			}

			//echo $term;

//			if($type == 'PPI'){
//				$query = sprintf("
//				SELECT 
//					count(Genetic_or_Physical_Interaction) AS n
//				FROM 
//					interaction_data
//				WHERE 
//					interaction_data.Feature_Name_Bait = '".$term."'
//				OR 
//					interaction_data.Feature_Name_Hit = '".$term."'
//				ORDER BY 
//					Genetic_or_Physical_Interaction");
//			}
				
		$result = get_assoc_array($query);
		
		if(! isset($result[0]['n']) ){
			$n = 0;}
		else{
		$n = $result[0]['n'];
		}
		$p = pvalue($N,$M_new,$n,$numb);
		$pq = sprintf("%.3e\n", $p);
		if( ($p < $GOterm_pfilter) and ($p !== 0.000e+0) ){	
//			$str .= $term.' ('.$numb.') ';
			$str .= $term.' ('.$pq.') ';
			}
		}
			
		$term2numb = '';
	//	}
	}
	if($str == ''){
		$str = 'GO terms are not considered significant (p value > '. $GOterm_pfilter. ')'; 
	}
	//show_array($setNew);
	//echo $str;
	//echo '<hr>';
	
	return $str;
}


function get_list_interaction($v, $keys, $count, $N, $M_new, $GOterm_pfilter, $man_patch)
{
	$str = '';
	if($man_patch == 'y'){
		foreach($keys as $intersect_keys){
			$string[] = $v[0]["$count"]["$intersect_keys"];
			//echo ' y <br />';
		}
	}
	if($man_patch == 'n'){
		foreach($keys as $intersect_keys){
			$string[] = $v["$count"]["$intersect_keys"];
			//echo ' n <br />';
		}
	}
	
	//show_array($string);
	
	$toplist = string_to_top_hit($string, $a ='intersec');
	if(!empty($toplist)){
		foreach($toplist as $set){
			foreach($set as $numb2term){
			
				foreach($numb2term as $numb => $term){
					//switch this around so that it can be sorted by value note all terms are unique
					// and therefore to not overwrite each other
					$term2numb[$term] = $numb;
//					$str .= $term.' ('.$numb.') ';
				}
			arsort($term2numb);
			//$setNew = $term2numb;
			}
		}		
	
	//show_array($term2numb);
		foreach($term2numb as $term => $numb){
			$str .= $term.' ('.$numb.') ';
		}
	$term2numb = '';
	}
	if($str == ''){
		$str = 'no highly connected nodes'; 
	}
	return $str;
}

function post_options($postdata)
{
	foreach($postdata as $key => $previously_selected){// put in to function avoid repitition
		if(isset($previously_selected)){
			echo $str ='<input name="'."$key".'" type="hidden" value="'."$previously_selected".'">';
			//echo $str ='input name="'."$key".'" type="hidden" value="'."$previously_selected".'"<br>';
			}else{
		}
	}
	return $str;
}

function format_text($format = 'h1', $text = 'Blah blah blah!', $colour = 'red')
{
echo '<'."$format".'><font color="'."$colour".'">'."$text".'</font></'."$format".'>';
}

function make_title($title_page, $title_append) 
{
	$start_txt = '<div align="left"><h1>';
	$tag_1 = '<span class="style2">';
	$tag_2 = '</span>';
	$end_txt = '</h1></div><br />';
	$link = ' > ';
	$title_string = $start_txt.$title_page.$tag_1.$link.$title_append.$tag_2.$end_txt;
	
	return $title_string;
}

function truncate_text($text, $nbrChar, $append='...') {
     if(strlen($text) > $nbrChar) {
          $text = substr($text, 0, $nbrChar);
          $text .= $append;
     }
     return $text;
}
 
function tag_info($var02) { 
$var02 = $var02;//to allow for the removal of 1 result (nulls) from array
	$result = get_assoc_array("
	SELECT Gene_Name, COUNT(Feature_Name), Feature_Name, Occurence, OneGeneGO_F_terms
	FROM combined_data 
	GROUP BY Gene_Name
	HAVING Occurence >= $var02
	ORDER BY Occurence DESC
	");
	return $result; 
}

function tag_cloud($var01) {
	$var02 = $var01;
	$min_size = 10;
	$max_size = 30;
	$genes_from_db = tag_info($var02);
	shuffle($genes_from_db);
	$count = '';
    foreach ($genes_from_db as $k => $v) {
    	foreach ($v as $k2 => $v2) {
  			if($k2 == 'Gene_Name'){$gene = $v2;}
  			if($k2 == 'Occurence'){$count = $v2;}
  			$tags["$gene"]=$count;
  		}	
    }
    $minimum_count = min(array_values($tags));
    $maximum_count = max(array_values($tags));
    $spread = $maximum_count - $minimum_count;
    if($spread == 0) {
        $spread = 1;
    }
    $cloud_html = '';
    $cloud_tags = array(); // create an array to hold tag code
 	//use as key to get feature name from parallel $tags_ORF array
    $x=0;  
    foreach ($tags as $tag => $count) {
        $size = $min_size + ($count - $minimum_count) 
            * ($max_size - $min_size) / $spread;
		$size = (int)$size;
		if($size >=20 && $size <=30){
			$color='red';
		}else if($size >=15 && $size <=20){
			$color='orange';
		}else if($size >=10 && $size <=15){
			$color='green'; 
		}?>               
		<style type="text/css">
        .tag_cloud
        {padding: 3px; text-decoration: none;
        font-family: verdana;	}
        
        .tag_cloud:hover { color: #FF66CC; background: #000000; }
        .tag_cloud:active { color: #6699FF;  }
        </style>
        
         <?php             
        $cloud_tags[] = 
        '<a style="color:' .$color .'; font-size: '. floor($size) . 'px' . '" class="tag_cloud" 
            target="_blank" 
            href="./GeneDetails.php?submit=Gene+Details&YDL_node=' . 
        	$genes_from_db[$x]['Feature_Name'] . 
        	'" title= ' . $genes_from_db[$x]['OneGeneGO_F_terms'] . '>' . 
        	htmlspecialchars(stripslashes($tag)) .
        '</a>';
		$x=$x+1;
		$color = '';
    }
	$cloud_html = join("\n", $cloud_tags) . "\n";
	return $cloud_html;
}
?>