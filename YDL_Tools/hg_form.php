<?php
require_once('./header.php');
?>
<title>Hypergeometric form</title>

<?php 
if($_GET['pval'] == 'CALCULATE'){
$seta = $_GET['n'];
$setb = $_GET['M'];
$intersect = $_GET['m'];
$total = $_GET['N'];
}else{
$seta = '100';
$setb = '70';
$intersect = '22';
$total = '4600';
}
?>

<h1>Over-representation calculator </h1>

<fieldset title="Hypergeometric calculator">

<table class="box-table-a" summary="">
	<tr align='left'>
	<td>
<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>"name="hypergeo_dist" target="">
<b>SET A</b> <br />
<input name="n" type="text" value="<?php echo $seta;?>" size="3" maxlength="4" />
 Enter the number of genes in the "gene-list of interest" eg Phenotype 1.<br />
	</td>
	</tr>
	<tr align='left'>
	<td>

<b>SET B</b> <br />
<input name="M" type="text" value="<?php echo $setb;?>" size="3" maxlength="4" />
 Enter the number of genes in the "comparison list" eg a GO ontology, Phenotype 2, etc<br />
	</td>
	</tr>
	<tr align='left'>
	<td>

<b>Genes in the INTERSECTION of SET A and SET B </b><br />
<input name="m" type="text" value="<?php echo $intersect;?>" size="3" maxlength="4" />
 The number of genes in the intersection of the two lists<br />
	</td>
	</tr>
	<tr align='left'>
	<td>

<b>Genes in the background distribution </b><br />
<input name="N" type="text" value="<?php echo $total;?>" size="4" maxlength="4" />
 Enter the total number of genes in the genome or available in the Yeast Deletion Library<br />
	</td>
	</tr>
	<tr align='left'>
	<td>
<br /> 
<input name="pval" class="submitbutton" type="submit" value="CALCULATE" />
<br /> 
<br /> 

This tool calculates a p-value (based on a hypergeometric distribution) to indicate whether your gene-list of interest is over-represented in another gene-list. <br /> 

A high p-value (e.g. > 0.05) indicates that the intersection may occur simply by chance alone, whereas a low p value ( e.g < 0.05) may indicates that the genes are over-represented. <br /><br />

	</td>
	</tr>
	</table>
	

<?php

echo '<a href="?">reset page</a><br /><br />';
echo '<input name="post_title" type="hidden" value="'.$post_title.'" />';
?>

</form>
</fieldset>

<?php
if($_GET['pval'] == 'CALCULATE'){

	$n = $_GET[n];
	$m = $_GET[m];
	$N = $_GET[N];
	$M = $_GET[M];
	$lh = log_hypergeometric($m,$n,$M,$N);
	$h = exp($lh);
	$p = pvalue($N,$M,$n,$m);
	
	echo '<fieldset title="Hypergeometric calculator">';
	
if( ($intersect > $seta) or ($intersect > $setb) or ($intersect > $total) ) echo '<h3><font color="red">ERROR The number of genes in the intersection cannot be greater than in either of the sets or the background distribution</font></h3>';

if( ($seta > $total) or ($setb > $total) or ($intersect > $total) ) echo '<h3><font color="red">ERROR The number of genes in the background distribution is too small</font></h3>';

	echo '<br /><h2>';
	echo 'The calculated pvalue = ';
	printf("%.4e\n", $p);
	echo '</h2>';
	echo '</fieldset>';
}
?>	

<?php
require_once('footer.php');
?>	