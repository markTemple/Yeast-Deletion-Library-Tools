<?php

//if(!isset($postdata['occur'])){
//$postdata['occur'] = '40';
//}

//show_array($_GET);

//$SGD_ID_array = array('S000000001','S000000024','S000000048','S000000099','S000000150','S000000222','S000000333','S000000444','S000000445','S000000446','S000000403','S000006003','S000000003');

foreach($SGD_ID_array as $v)
	{
	//echo $v;
	$query = sprintf("
	SELECT 
		sgd_id, Feature_Name, Standard_gene_name, Chromosome, Start_coordinate, Stop_coordinate, Strand
	FROM 
		SGD_features
	WHERE
		sgd_id =  '".$v."'
	");
	
	$array_data[] = get_assoc_array($query);
}

show_array($array_data);

foreach($array_data as $k => &$v)//pass as reference so it can be changed
	{
	if($v[0]['Strand'] == 'C')
		{
		$stop = $v[0]['Stop_coordinate'];	
		$v[0]['Stop_coordinate'] = $v[0]['Start_coordinate'];
		$v[0]['Start_coordinate'] = $stop;
	}
	$array_startCo[] = $v[0]['Start_coordinate'];
	$array_format_new[$k] = $v[0];
	$plot_dataset_x[] = $v[0]['Chromosome'];
	$plot_dataset_y[] = $v[0]['Start_coordinate'];
	$plot_gene_name[] = $v[0]['Standard_gene_name'];
}
$array_data = '';

//asort($array_startCo);
$county = count($array_startCo);
//show_array($array_startCo);

//show_array($array_format_new);
array_multisort($array_startCo, SORT_ASC, $array_format_new);
//show_array($array_format_new);
//show_array($plot_dataset);
		
//echo $plotString;

include("./D3plotcanvas.html");

?>
