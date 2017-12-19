<?php
require_once('./back_header.php');

//if (isset($_GET['query'])) $submit=$_GET['query'];
//else $submit='';
ini_set("memory_limit","512M");


//show_array($_POST);
//show_array($_GET);
//echo "submit = $submit";

?>
<head><title></title></head>
<body>
<h2>Intersection Data Queries</h2>


What is biggest unique geneset?

<p>

<?php

//new
$fieldset_legend = 'Genes bound by TF pairs';
$MySQL_value_01 = 'SWI4';//default value prior to select
$MySQL_value_02 = 'SWI6';//default value prior to select
$form_select_name_01 = 'TF1';//key of $_POST once submitted
$form_select_name_02 = 'TF2';//key of $_POST once submitted
//$options_array = get_TF_list();//ok
$options_array_feild_01 = 'Standard_gene_name';
$options_array_feild_02 = 'Feature_Name';
$input_value = 'get_genes_bound_by_TFs';//value of submit button... submit = $input_value
$SQL_01 = "SELECT `Feature_Name_Bait`, `Standard_Gene_Name_Bait`, `Feature_Name_Hit`, `Standard_Gene_Name_Hit`, `Experiment_Type` ";
$SQL_02 = "FROM `interaction_data` ";
$SQL_03 = "WHERE `Feature_Name_Bait` = ";
$SQL_04 = " OR `Feature_Name_Hit` = ";
$SQL_05 = " ORDER BY `Experiment_Type`";

	if($_POST['submit'] == $input_value){
		$MySQL_value_01 = $_POST["$form_select_name_01"];
		$MySQL_value_02 = $_POST["$form_select_name_02"];
	}
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<fieldset><legend><?php echo $fieldset_legend;?></legend>
Select a value for <font size="3" color="red">geneName1</font> and <font size="3" color="red">geneName2</font><br /><br /> 
geneName1 = <select name='<?php echo $form_select_name_01;?>' size=1 >
<?php
        foreach($options_array as $row)
        {
			foreach($row as $v1)
			{
            /*** create the options ***/
            echo '<option value="'.$v1.'"';
				if($v1 == $MySQL_value_01)
				{
					echo ' selected';
				}
            echo '>'.$v1.'</option>';
			}
        }
?>
</select>
geneName2 = <select name='<?php echo $form_select_name_02;?>' size=1 >
<?php
        foreach($options_array as $row)
        {
			foreach($row as $v1)
			{
            /*** create the options ***/
            echo '<option value="'.$v1.'"';
				if($v1 == $MySQL_value_02)
				{
					echo ' selected';
				}
            echo '>'.$v1.'</option>';
			}
        }
?>
</select>
<input class="submitbutton" type="submit" value="<?php echo $input_value;?>" name="submit">
<a href="?"><?php echo "reset page"; ?></a><br />
<?php

if($_POST['submit'] == $input_value){
	$geneName1 = "'".$_POST["$form_select_name_01"]."'";
	$geneName2 = "'".$_POST["$form_select_name_02"]."'";
}else{
	$geneName1 = "'geneName1'";
	$geneName2 = "'geneName2'";
}

$q_2TF = "SELECT * FROM `TF_pairs` WHERE (`TF_fact_01` = $geneName1 and `TF_fact_02` = $geneName2) OR (`TF_fact_01` = $geneName2 and `TF_fact_02` = $geneName1)";

echo '<br />';
if($_POST['submit'] == "$input_value"){
echo 'The following query was performed for with <font size="3" color="red">TF1 </font>equal to <b>geneName1 = '.$geneName1.'</b><br />';
echo 'The following query was performed for with <font size="3" color="red">TF2 </font>equal to <b>geneName2 = '.$geneName2.'</b>';
		$query = "$q_2TF";
	?>	
	<?php
	
	$result = mysql_query($query);
	print_result_table($result);
}else{
echo "$q_2TF";
}
?>
</fieldset>
</form> 


<?php
//show_array($_REQUEST);

$fieldset_legend = 'Chemicals from phenotype_data';
$input_value = 'select chemical';//value of submit button... submit = $input_value
$form_select_name_01 = 'data_for_form_query_01';//key of $_POST once submitted
$MySQL_value_01 = 'hydrogen peroxide';//value of $_POST will be overwritten once submitted
$options_array = get_chemical();//MySQL values from a single field - used for dropdown box
$options_array_feild_01 = 'Chemical';//feild name from MySQL table
$options_array_feild_02 = '';
$SQL_01 = "SELECT feature_link, Gene_Name, Experiment_Type, Phenotype, Chemical ";
$SQL_02 = "FROM phenotype_data ";
$SQL_03 = " WHERE Chemical LIKE '%";
$SQL_05 = "%' ORDER BY Experiment_Type";
$SQL_06 = "";

//form_query_01($fieldset_legend, $MySQL_value_01, $form_select_name_01, $options_array, $options_array_feild_01, $options_array_feild_02, $input_value, $SQL_01, $SQL_02, $SQL_03, $SQL_05, $SQL_06);



//show_array($options_array);
echo "<br />";


echo "<h2>Do this for comb data, sort be genes showing most common genes in a bag of phenotypes eg hydrogen peroxide</h2>";


$fieldset_legend = 'Chemicals from phenotype_data';
$input_value = 'select chemical';//value of submit button... submit = $input_value
$form_select_name_01 = 'data_for_form_query_01';//key of $_POST once submitted
$MySQL_value_01 = 'hydrogen peroxide';//value of $_POST will be overwritten once submitted
$options_array = get_chemical();//MySQL values from a single field - used for dropdown box
$options_array_feild_01 = 'Chemical';//feild name from MySQL table
$options_array_feild_02 = '';
$SQL_01 = "SELECT feature_link, Gene_Name, Experiment_Type, Phenotype, Chemical ";
$SQL_02 = "FROM phenotype_data ";
$SQL_03 = " WHERE Chemical LIKE '%";
$SQL_05 = "%' ORDER BY Experiment_Type";
$SQL_06 = "";

form_query_01($fieldset_legend, $MySQL_value_01, $form_select_name_01, $options_array, $options_array_feild_01, $options_array_feild_02, $input_value, $SQL_01, $SQL_02, $SQL_03, $SQL_05, $SQL_06);


?>
</p>
</body>

<?php
require_once('./back_footer.php');
?>	
