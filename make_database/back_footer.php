		<!-- col_main end -->
		</div>
<!--here is the left hand menu of tools-->		
<di class="col_left">
<!-- Left column heading? start -->

<fieldset style="width:140px">
<h2>Backend Tools</h2>

<br />
<b>INDEX</b> <br />
<a href="./backend_index.php">Index</a> 
<br />
<br />
<a href="query_comb_data.php">COMBINED</a>
<br />
<br />
<a href="query_intersection_data.php">INTERSECT</a>
<br />
<br />
<a href="index_backend.php">MAKE TABLES</a>
<br />
<br />
	<a href="./index_make_tables.php">COMBINE & INTERSECT</a>
<br />
<br />
<b>FRONTEND</b> <br />
<a href="../YDL_Tools/index.php">YDL Tools</a> 
<br />

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
	<td align="center">UWS - Bioinformatics</td>
	<td align="center"><?php echo 'Greatings from Sydney: ';echo $time; ?></td>
    <td> <div align="center">&copy; 2013 Temple Lab UWS</div></td>
  </tr>
</table>
</div> <!-- end of footer -->

<?php	
	close_database();
?>