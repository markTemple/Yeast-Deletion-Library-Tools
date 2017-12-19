		<!-- col_main end -->
		</div>
<!--here is the left hand menu of tools-->		
<di class="col_left">
<!-- Left column heading? start -->

<fieldset style="width:140px">
<table class="box-table-b" >
	<th align='left'>
	<b>YDL Tools</b>
	</th>
	<tr>
		<td align='left'><a href="index.php"><b>ALL PAPERS</b></a>
		<br /><small>List all papers in the database that are available for intersection</small><br />
		</td>
	</tr>
	<tr>
		<td align='left'><a href="queryLOOP.php"><b>INTERSECT TOOL</b></a>
		<br /><small>Select a paper and show all similar phenotypes</small><br />
		</td>
	</tr>
	<tr>
		<td align='left'><a href="intersections_all.php"><b>ALL INTERSECTIONS</b></a>
		<br /><small>Show the most similar phenotypes in the database</small><br />
		</td>
	</tr>	
	<tr>
		<td align='left'><a href="enter_geneset.php"><b>ENTER GENESET</b></a>
		<br /><small>Enter your own geneset and find similar phenotypes</small><br />
		</td>
	</tr>	
	<tr>
		<td align='left'><a href="manual_intersect.php"><b>MANUAL INTERSECTIONS</b></a>
		<br /><small>Manually show the similarity between any two papers</small><br />
		</td>
	</tr>
	<tr>
		<td align='left'><a href="gene_occurence_all.php"><b>GENE OCCURENCE</b></a>
		<br /><small>Show the most frequently occuring genes in the database</small><br />
		</td>
	</tr>
	<th align='left'>
	<b>Other Tools</b>
	</th>
	<tr>
		<td align='left'><a href="GeneDetails.php"><b>GENE DETAILS</b></a>
		<br /><small>Show all occurences of a specific gene in the database</small><br />
		</td>
	</tr>
	<tr>
		<td align='left'><a href="PPI_Browser.php"><b>PPI DETAILS</b></a>
		<br /><small>Show the protein protein-interactions for a gene</small><br />
		</td>
	</tr>
<!--	<tr>
		<td align='left'><a href="hg_form.php"><b>P VALUE CALCULATOR</b></a>
		<br /><small>Calculate a p-value using the hypergeometric distribution</small><br />
		</td>
	</tr>
-->	
</table>
</fieldset>


<br />
<br />


<!-- col_left end -->
</div>
		
<!--here is the close of the div tags that start in the header-->	
	</div>
	<!-- colleft end -->
</div>
<!-- colmask end -->
</body>
</html>

<?php 
date_default_timezone_set("Australia/Sydney");
$time = date('jS F, h:i:a'); 
?>

<div id="footer">

<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFEBCD">
  <tr> 
	<td align="center">Western Sydney University</td>
	<td align="center"><?php echo 'Greatings from Sydney: ';echo $time; ?></td>
    <td> <div align="center">&copy; 2017 Mark Temple</div></td>
  </tr>
</table>
</div> <!-- end of footer -->

<?php	
	close_database();
?>