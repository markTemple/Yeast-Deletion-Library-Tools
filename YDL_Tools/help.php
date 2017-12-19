<?php require_once('header.php');

$query = sprintf(" SELECT COUNT(Feature_Name) AS Total_Genes,
COUNT(DISTINCT Feature_Name) AS Distinct_Genes, COUNT(DISTINCT
PubMed_ID) AS Publications, COUNT(DISTINCT phenotypeID) AS Phenotypes FROM
combined_data "); $combined_data = get_assoc_array($query);
//show_array($combined_data);
?>

<h1>Welcome to the Yeast Deletion Library tools</h1>

This is a website for the analyses of deletion library screens of
<i>Saccharomyces cerevisiae,</i> a model organism for the study of
fundemental cellular processes. The various tools are accessed from the
left hand menu and are described below.

<p><a href="index.php">ALL PAPERS</a><br /> This page is simply a landing page that provides a summary of all the research articles in the database. At the time of writing the database contains 
<?php echo '<b>'.$combined_data[0]['Publications'].'</b>';?> papers and each is hyperlinked to its occurrence in PubMed. Listed below each paper title are the responsive deletants reported by the paper, the number of genes contained in that phenotypic geneset and importantly the number of intersections with other phenotypic geneset. There are <b><?php echo
$combined_data[0]['Phenotypes'].'</b>';?> gene-sets in total. 
To the right of the publication title is a 'Phenotypes' link that launches a summary page listing all genes names of that phenotype, a summary of the gene ontology (slim terms) that are overrepresented in the set and a summary of protein-protein interactions that are highly connected to the phenotypic geneset. Additionally, to the right of the publication title is an 'Intersect' link that launches the results of the intersection tool (see below) for that phenotypic geneset.</p>

<p><a href="queryLOOP.php">INTERSECT TOOL</a><br /> The intersect tool page allows users to run and show the results of the intersection of a chosen phenotype (geneset) against all other genesets in the database. There are two methods to run the intersection scripts on this page. Firstly the phenotype of interest can be chosen from list of all papers (from a dropdown box) and this presents a selectable list of phenotypes from which the intersection tool can be run using the 'Intersect' button. Secondly phenotypic genesets can be piped across from other pages using 'Intersect' buttons on other tool pages. Following the query the page presents a summary list of each significant intersection, including the name of the parent publication and phenotype, the number of genes in each list and the list of the intersecting genes. All intersections lists are filtered and have a p-value of less than 0.05 determined by a hyper geometric distribution to filter out gene-sets who's similarity occurs by chance alone. A simple Venn intersection diagram is generated that indicates the relative sizes of the 'Selected Phenotype' (geneset A) against the found set (geneset B) and the extent of intersection. Below the intersection diagram are nested 'Summary' and another 'Intersect' buttons. The  summary button provides the identity of genes in the lists and a brief GO term summary of the intersecting (common) genes. The nested 'Intersect' button re-runs the intersect script with geneset B as the selected phenotype. 
Additionally, this page presents a 'Geneset' button and a 'Phenotypes' button, that respectively link to more information about the individual genes or about the selected phenotype as a whole. The 'Geneset' button presents a table indicating the location of each gene of the selected phenotype on each of the 16 yeast chromosomes. Below this is a summary table indicating how frequently each gene occurs in all phenotypes and how connected the gene is in various protein-protein interactions networks. Below is a more exhaustive table catalogue detailing the physical interactions and genetic interactions for each gene. Within these lists the availability of each gene in the deletant collection is indicated (baring in mind that some interacting partners may not be available in the yeast deletant library as they may be essential (coloured red) or not available (coloured blue) to be tested). Each entry in the exhaustive table also has a link button to both the 'Gene Details' and 'PPI Details' pages.</p>

<p><a href="intersections_all.php">ALL INTERSECTIONS</a><br /> This page was generated using a script to show the most similar phenotypes in the database, that is those with the lowest p-values according to a hyper geometric distribution. The page reports only the paper and phenotype names, however, either set of the intersections can be used to run another intersection enquiry. Additionally the user can change the p-value based filter to show additional intersections.  </p>

<p><a href="enter_geneset.php">ENTER GENESET</a><br /> This page allows users to enter their own geneset of interest and to intersect this against the database to identify similar genes that are responsive to another treatment. The page accepts ORF names or gene names. The filtering p-value can be adjusted depending on the extent of similarity found. A summary of each query gene  of the geneset of interest is also provided to verify that the geneset has been properly parsed by the scripts and links from each ORF name to the comprehensive Saccharomyces Genome Database (SGD) database is given. Additionally a 'Gene Details' button is provided that links to a summary gene information page.</p>

<p><a href="manual_intersect.php">MANUAL INTERSECTIONS</a><br />
This page gives the user the ability to manually select any two papers from the database and perform an intersection of the phenotypes of one against those of the other. The paper lists are presented as two selectable dropdown boxes. The p-value used to filter these results can be set arbitrarily high to show intersections that would not normally be considered significant. This allows the user to at least be aware of the commonality between two sets of genes and to make an informed decision as to the significance of the result.</p>

<p><a href="gene_occurence_all.php">GENE OCCURENCE</a><br />This page shows the results of a pre-run query to show the genes that occur most frequently in the phenotypes of the database. The list is sorted to show those that occur in the most phenotypes first and the extent of the list can be filtered by the minimum number of occurrences. Each gene is linked to the Gene Details page (see  below). Additionally the page reports the total number of publications. phenotypes, distinct genes and total gene entries in the database. Clearly these genes, or deletant strains, are the most sensitive to a wide range of treatments and may be the subject of further review.</p>

<h3>Other Tools</h3> 
<p><a href="GeneDetails.php">GENE DETAILS</a><br />
Typically, this page is linked to from other pages in the website with a prior selected gene, however a gene of interest may be selected from a dropdown list to begin a new query. The results of this page show basic gene summary information and importantly it reports all of the different phenotypes in which the gene occurs. As part of the user workflow, any phenotype on this list can be pushed directly to the intersection tool for further enquiry using the 'intersect' button. </p> 

<p><a href="PPI_Browser.php">PPI DETAILS</a><br /> 
This page is ancillary to the site and it simply indicates the degree to which the selected gene/protein is connected within the cell. It is thought to be useful to highlight genes that are highly connected to a geneset but that may be absent from the deletion library. A gene/protein of interest can be piped to the page from the exhaustive table on the Genesets page (available via the intersection tool page) using the 'PPI details' button or selected directly from the dropdown list at the top of the actual page itself. The tool generates a table containing an entry for each physical or genetic interaction associated with the selected gene. Each protein/gene entry in the table contains additional 'PPI Details' and 'Gene Details' buttons to either re-run the tool or link to the previously described gene details page, respectively. </p> 

<!--<p><a href="hg_form.php">P VALUE
CALCULATOR</a><br /> Calculate a p-value using the hypergeometric
distribution </p>-->


<?php require_once('footer.php'); ?>	