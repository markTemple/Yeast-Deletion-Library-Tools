<?php
require_once('./back_header.php'); 
//echo '<h2>Who are we?</h2>';
//echo 'I am current user <b>'.get_current_user().'</b><br />';
//$processUser = posix_getpwuid(posix_geteuid());
//echo 'As a script I am <b>';
//print $processUser['name'];
//echo "</b><hr />";

//make this change with terminal
//Mark-Temple:XAMPP marktemple$ sudo chown -R nobody:admin htdocs/*
//this got rid of the permission denied error I was having with fopen
//echo '<h2>Write data to file test</h2>';
//
//$folder = './Raw_files_for_DB/';
//$file_name = 'stipidfile.txt';
//$folder_file = $folder.$file_name;
//$handle = fopen("$folder_file", 'w') 
//or die("here we go again stupid");
//
//$text = <<<_END
//happy happy joy joy
//i think i got this bloody thing to work
//_END;
//
//echo 'Here is some text contained in a variable that has just been written to a file<br />';
//echo 'Text = '.$text.'<br />';
//echo 'File Name = '.$file_name.'<br />';
//
//fwrite($handle, $text)
//or die("no write");
//fclose($handle);
//echo 'Here is the actual text read from the file<br />';
//echo '<pre>';
//readfile($folder_file);
//echo '</pre>';
//echo '<hr />';
//
echo '<h1> Automatically download updated datafiles from SGD </h1>';

//http://forums.digitalpoint.com/showthread.php?t=242255
$SGD_files = array(
'curation/literature/' 
=> array('biochemical_pathways.tab', 'gene_literature.tab','go_protein_complex_slim.tab','go_slim_mapping.tab','go_terms.tab', 'interaction_data.tab','phenotype_data.tab'),
'curation/chromosomal_feature/' 
=> array('SGD_features.tab','chromosome_length.tab'),
'curation/calculated_protein_info/' 
=> array('protein_properties.tab')
);
?>
 
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

<?php
foreach($SGD_files as $k => $v){
	echo "<fieldset><legend>$k</legend>";
	foreach($v as $k1 =>$v1){
	/*** create the options ***/
	?><input name="select file[<?php echo $k;?>][<?php echo $k1;?>]" type="checkbox" value="<?php echo $v1;?>" />
	<?php	echo $v1.'<br />';
	}
	echo'</fieldset><br />';
}
?>

<input name="submit" class="submitbutton" type="submit" value="download file" />
<a href="?"><?php echo "reset page"; ?></a>
</form>


<?php
//simple use the following two lines of code to bypass the UWS proxy
////scripts work without these lines outside of UWS
//$opts = array('http' => array('proxy' => 'tcp://proxy.uws.edu.au:3128', 'request_fulluri' => true));
//$context = stream_context_create($opts);

$web_address = 'http://downloads.yeastgenome.org/';

if(($_POST["submit"] == 'download file') and ($_POST['select_file'] != null)){
	foreach($_POST['select_file'] as $k => $v){
	$web_folder = $k;
		foreach($v as $k1 => $web_file){
		echo $web_address.$web_folder.$web_file;
		echo '<br />';
		$web_file_as_string_to_write = file_get_contents($web_address.$web_folder.$web_file, false, $context);
		$local_file_name = './Raw_files_for_DB/'.$web_file;
		$handle = fopen("$local_file_name", 'w') or die("here we go again stupid");
		fwrite($handle, $web_file_as_string_to_write)or die("no write");
		fclose($handle);
		}	
	}
}
//echo 'Here is the actual text read from the file<br />';
//echo '<pre>';
//readfile("$local_file_name");
//echo '</pre>';
//echo '<hr />';

require_once('./back_footer.php');
?>	
