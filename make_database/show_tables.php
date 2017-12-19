<?php
require_once('./back_header.php');
?>

<head>
	<title></title>
</head>

<body>

<h1>Show Tables</h1>
	
	<p>
<?php
$table_list = (return_tables());
//show_array($table_list);
foreach($table_list as $tab){
	foreach($tab as $v){
		echo "<fieldset><legend>Tables name : <b> $v </b></legend>";
		$table_desc = (describe($v));
	//	show_array($table_desc);
		$index_array = show_index($v);
	//	show_array($index_array);
		foreach($index_array as $index){
			echo 'Column_name = '.$index['Column_name'].' Key_name ='.$index['Key_name'].'<br />';
		}
		echo '<b>Table Description : </b><br />';
		foreach($table_desc as $desc){
			echo "[Field] = $desc[Field] ";
			echo "[Type] = $desc[Type] ";
		//	echo "[Null] = $desc[Null] ";
			if($desc['Key'] == 'PRI'){ echo "[Key] = $desc[Key] ";}
		//	echo "[Default] = $desc[Default] ";
			if($desc['Extra'] == 'auto_increment') {echo "[Extra] = $desc[Extra] ";}
			echo '<br />';
		//	echo $v;
		}
		$numb_rows = (select_count($v));
		//show_array($numb_rows);
		echo '<b>Number of rows : </b>';
		foreach($numb_rows as $numb){
			foreach($numb as $v){
				echo '<font color="red"><b>'.$v.'</b></font>';
			}
		}
	echo '</fieldset>';	
	}
}

?>
	</p>
</body>

<?php
require_once('./back_footer.php');
?>	
