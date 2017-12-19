<?php
//change ie add directly into combined table.... easy!!!!!
$top_100_occurence = array(
'YEL051W', 'YPL045W', 'YKL080W', 'YGR020C', 'YDL185W', 'YLR240W', 'YGR105W', 'YKL212W', 'YEL027W', 'YGL095C', 'YLR396C', 'YOR036W', 'YLR148W', 'YDR129C', 'YLR322W', 'YPR036W', 'YPR173C', 'YPR135W', 'YOR331C', 'YPL161C', 'YCR009C', 'YLR447C', 'YOR332W', 'YBR127C', 'YHR183W', 'YEL044W', 'YDR027C', 'YPL002C', 'YLR417W', 'YDR323C', 'YOL072W', 'YPL084W', 'YGR036C', 'YGL071W', 'YKL119C', 'YDR264C', 'YEL031W', 'YML112W', 'YDR378C', 'YML097C', 'YML008C', 'YPL254W', 'YOR106W', 'YPR159W', 'YBR279W', 'YBL058W', 'YPL234C', 'YDR069C', 'YHR039C-A', 'YJR104C', 'YPR139C', 'YAL021C', 'YNL280C', 'YNL064C', 'YJL029C', 'YGL246C', 'YPL031C', 'YHR010W', 'YLR025W', 'YGL167C', 'YER095W', 'YLR386W', 'YJL176C', 'YDR388W', 'YHR030C', 'YGR262C', 'YDL106C', 'YDR080W', 'YLR242C', 'YLR039C', 'YKR001C', 'YHR191C', 'YNL229C', 'YHR011W', 'YJL140W', 'YGL012W', 'YDL006W', 'YLR262C', 'YGL025C', 'YDR207C', 'YKR085C', 'YGL070C', 'YHR026W', 'YIL065C', 'YLR056W', 'YMR202W', 'YDR065W', 'YOR043W', 'YHL025W', 'YGR078C', 'YDL191W', 'YIL029C', 'YDR200C', 'YGL058W', 'YNL250W', 'YGL206C', 'YIL053W', 'YDR204W', 'YAL026C', 'YNR052C'
);

$x=1;
foreach($top_100_occurence as $Feature_Name){

	$paperID = '501';
	$PheCount = '1001';
	$SGDID = 'blah';
	$feature_link = 'blah';
	$PubMed_ID = '11111111';
	$PubMed_ID_link = 'blah';
	$PheChem = 'top100';
	$Flatfile = 'computer_generated';
	$citation = 'Mark Temple';

	$lookup = genename_lookup($Feature_Name);
	//show_array($lookup);
	$Feature_Name = $lookup[0]['Feature_Name'];
	$Gene_Name = $lookup[0]['Standard_gene_name'];




	$insert = mysql_query("
	INSERT INTO combined_data 
	(paperID, phenotypeID, Feature_Name, Gene_Name, SGDID, feature_link, PubMed_ID, 
	PubMed_ID_link, PheChem, Flatfile, citation) 
	VALUES 
	('$paperID', '$PheCount', '$Feature_Name', '$Gene_Name', '$SGDID', '$feature_link', '$PubMed_ID', 
	'$PubMed_ID_link', '$PheChem', '$Flatfile', '$citation')  
	")or die(mysql_error());
		
echo $x;
echo ', ';
$x=$x+1;

}	
print "<p>Data has been sucessfully updated to the database!</p>";

?>
