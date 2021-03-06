<?php
	require_once('./back_header.php');
?>	

<?php
if (isset($_GET['run'])) $linkchoice=$_GET['run'];
else $linkchoice='';
?>

<body>
<h1>Make Tables for Bioinformatic analyses</h1>

<fieldset><legend>combined_data</legend>
<h2>Make "combine_data" Table</h2>
	<a href="?run=make_combined_table"> Drop, Create and Update </a> 
	"combined_data" table from data within "gene_literature.tab", "phenotype_data.tab" and "UWS_Del_Lib_Screen.txt" files. <br />
	 <br />
	 <b>Alternatively</b>, 
	<a href="?run=make_random_table"> Drop, Create and Update </a> 
	"combined_data" table from RANDOM DATA generated by scripts (to deternime the chance intersections and an appropriate p value to use as a cut-off for real data)
	<br />
	
<?php
if($linkchoice == 'make_combined_table') {
	include('./make_combined_table.php');//update option
	echo 'The new combined_data table has been made (REAL EXPERIMENTAL DATA) ......';
	echo '<br />';
	echo '<br />';
	print(show_one_table('combined_data'));
	echo '<br />';
}
if($linkchoice == 'make_random_table') {
	include('./make_random_table.php');//update option
	echo 'The new combined_data table has been made (RANDOM DATA) ......';
	echo '<br />';
	echo '<br />';
	print(show_one_table('combined_data'));// now full of random genesets
	echo '<br />';
}
?>		
<br />	
<!--	<a href="?run=add_sets_to_comb_data"> Add MARKS sets of interest to comb_data</a> 
--><br />
<?php
if($linkchoice == 'add_sets_to_comb_data') {
	include('./add_sets_to_comb_data.php');//update option
	echo 'Marks super dooper data has been added to comb_data ......';
	echo '<br />';
	echo '<br />';
	print(show_one_table('combined_data'));
	echo '<br />';
}
?>	

<br />	
	<a href="?run=add_SGD_attributes2comb"> Add attributes to empty feilds of combined_data table.....</a> 
	Populate the empty columns in "combined_data" table from SGD attributes, GO P/F/C Slim terms and adds PPI (Physical and Genetic interactions). 
	(slow) <br />
<?php
if($linkchoice == 'add_SGD_attributes2comb') {
	include('./add_SGD_attributes2comb.php');//update option
	echo 'The empty feilds of combined_data table have been populated ......';
	echo '<br />';
	echo '<br />';
	print(show_one_table('combined_data'));
	echo '<br />';
}
?>	
<br />	
	<a href="?run=add_protein_abundance2comb"> Add protein abundance and count phe to combined_data table.....</a> 
	This link also adds protein abundance to "combined_data" table. <br /> <br /> 
<?php
if($linkchoice == 'add_protein_abundance2comb') {
	include('./add_protein_abundance2comb.php');//update option
	echo 'The empty feilds of combined_data table have been populated ......';
	echo '<br />';
	echo '<br />';
	print(show_one_table('combined_data'));
	echo '<br />';
}
?>	
</fieldset>

<fieldset><legend>intersect_data</legend>
<h2>Make "intersect_data" Table</h2>
	<a href="?run=make_intersect_table"> Make Intersect Table</a> by processing the "combined_data" Table
	<br />
<?php
if($linkchoice == 'make_intersect_table') {
	include('./make_intersect_table.php');//update option
	echo 'The new intersection_data table has been made (all phenotypes in comb_data have been intersected and results further processed ......';
	echo '<br />';
	echo '<br />';
	print(show_one_table('intersection_data'));// now full of random genesets
	echo '<br />';
}
?>		
</fieldset>

<fieldset><legend>Papers</legend>
<h2>Make "Combined paper" Table</h2>
<br />
	<a href="?run=make_paper_table">Make list of Paper and Phenotypes for web browser</a>
<?php
if($linkchoice == 'make_paper_table') {
	include('./make_paper_table.php');//update option
	echo 'The new comb_paper_data table has been made ......';
	echo '<br />';
	echo '<br />';
	print(show_one_table('comb_paper_data'));
}
?>	

</fieldset>
</body>
  
<?php
	require_once('./back_footer.php');
?>	

