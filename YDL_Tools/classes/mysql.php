
<?php
//
//Ran this on command line as root to allow scripts permissions
//
//mysql> GRANT ALL PRIVILEGES ON SGDtables.* TO yeastbase01 @'%' IDENTIFIED BY 'yeastpass01';
//Query OK, 0 rows affected (0.16 sec)
//
//mysql> FLUSH PRIVILEGES;
//Query OK, 0 rows affected (0.13 sec)

function drop_table($tab)
{
	$query = sprintf("
	DROP TABLE $tab;
	");
	mysql_query($query);
	echo '<p><b>'.$tab.'</b> has been<font color="red"> dropped </font>';
//	echo '<a href="./show_tables.php"> .....Show Tables</a></p>';
}

function show_tables()
{
	$query = sprintf("
	SHOW TABLES 
	");
	return 	get_assoc_array($query);
}

function select_all($tablename)
{
	$query = sprintf("
	SELECT * FROM $tablename
	");
	return 	get_assoc_array($query);
}

//this function works as cut/paste in mysql command line but not in script - permissions??
//
// need to play with GRANT PRIVILEGES to enable browser/scripts to have create, drop etc
//

function create_csv_Table()
{
	$query = "CREATE TABLE csv_Table
	(
	csvID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(csvID),
	Feature_Name varchar(40) NOT NULL,
	Gene_Name varchar(10)
	) ENGINE = MYISAM";
	mysql_query($query);
}


function create_interaction_lists()
{
	$query="CREATE TABLE interaction_lists
	(
	intlistID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(intlistID),
	Feature_Name varchar(40) NOT NULL,
	Gene_Name varchar(10),
	SGDID varchar(10) NOT NULL,
	OneGenePPI_Phy_cnt int(3), 
	OneGenePPI_Phy_NN text, 
	OneGenePPI_Phy_NN_unique text, 
	OneGenePPI_Phy_NN_uniqueB text, 
	OneGenePPI_Gen_cnt int(3), 
	OneGenePPI_Gen_NN text, 
	OneGenePPI_Gen_NN_unique text,
	OneGenePPI_Gen_NN_uniqueB text
	) ENGINE = MYISAM";
	
	mysql_query($query);
}

function create_registry_genenames()
{
	$query = "CREATE TABLE registry_genenames
	(
	reggen_id integer NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (reggen_id),
	Locus_name varchar(20),
	Other_name varchar(100),
	Description varchar(900),
	Gene_product varchar(900),
	Phenotype varchar(900),
	ORF varchar(20),
	SGDID varchar(8)
	) ENGINE = MYISAM";
	mysql_query($query);
	echo '<p><b>registry_genenames</b> has been <font color="green">created </font></p>';
}

function create_biochemical_pathways()
{
	$query = "CREATE TABLE biochemical_pathways
	(
	biopat_id integer NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (biopat_id),
	biochemical_pathway_common_name varchar(80) NOT NULL,
	enzyme_name varchar(100),
	EC_number_of_reaction varchar(12),
	gene_name varchar(10),
	Reference varchar(34) NOT NULL
	) ENGINE = MYISAM";
	mysql_query($query);
	echo '<p><b>biochemical_pathways</b> has been <font color="green">created </font></p>';
}

function create_interaction_data()
{
	$query = "CREATE TABLE interaction_data
	(
	intdat_id integer NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (intdat_id),
	Feature_Name_Bait varchar(40) NOT NULL,
	Standard_Gene_Name_Bait varchar(10),
	Feature_Name_Hit varchar(40) NOT NULL,
	Standard_Gene_Name_Hit varchar(10),
	Experiment_Type varchar(40) NOT NULL,
	Genetic_or_Physical_Interaction text(23) NOT NULL,
	Source text(10) NOT NULL,
	Manually_curated_or_High_throughput varchar(17) NOT NULL,
	Notes varchar(200),
	Phenotype varchar(30),
	Reference varchar(34) NOT NULL, 
	Citation varchar(480) NOT NULL,
	DeletantFNH char(5),
	DeletantFNB char(5) 
	) ENGINE = MYISAM";
	mysql_query($query);
	echo '<p><b>interaction_data</b> has been <font color="green">created </font></p>';
	
	$index="CREATE INDEX FNB_index ON interaction_data (Feature_Name_Bait)";
	mysql_query($index);
	
	$index="CREATE INDEX FNH_index ON interaction_data (Feature_Name_Hit)";
	mysql_query($index);
}

//split entrys not unitary
function create_go_protein_complex_slim()
{
	$query = "CREATE TABLE go_protein_complex_slim
	(
	gpcs_id integer NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (gpcs_id),
	Ontology_details varchar(100) NOT NULL,
	gene_complex_details varchar(1000)
	) ENGINE = MYISAM";
	mysql_query($query);
	echo '<p><b>go_protein_complex_slim</b> has been <font color="green">created </font></p>';
}

function create_go_terms()
{
	$query = "CREATE TABLE go_terms
	(
	GOID int(5) NOT NULL,
	PRIMARY KEY (GOID),
	GO_Term	varchar(200), 
	GO_Aspect text(1), 
	GO_Term_Definition varchar(2000)
	) ENGINE = MYISAM";
	mysql_query($query);
	echo '<p><b>go_terms</b> has been <font color="green">created </font></p>';
}

function create_go_slim_mapping()
{
	$query = "CREATE TABLE go_slim_mapping
	(
	gsm_id integer NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (gsm_id),
	ORF varchar(10) NOT NULL,
	Gene varchar(10),
	SGDID varchar(10) NOT NULL,
	GO_Aspect text(1) NOT NULL,
	GO_Slim_term varchar(80) NOT NULL,
	GOID varchar(10),
	Feature_type varchar(30) NOT NULL 
	) ENGINE = MYISAM";
	mysql_query($query);
	echo '<p><b>go_slim_mapping</b> has been <font color="green">created </font></p>';

	$index="CREATE INDEX SGDID_index ON go_slim_mapping (SGDID)";
	mysql_query($index);
}


function create_sgd_features()
{
	$query="CREATE TABLE SGD_features
	(
	sgdfeaID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (sgdfeaID),
	sgd_id varchar(11) NOT NULL,
	Feature_Type varchar(40) NOT NULL,
	Feature_qualifier varchar(40),
	Feature_Name varchar(40) NOT NULL,
	Standard_gene_name varchar(10),
	Alias varchar(240),
	Parent_feature_name varchar(20), 
	Secondary_SGDID varchar(11),
	Chromosome varchar(8),
	Start_coordinate int(10),
	Stop_coordinate int(10),
	Strand text(1),
	Genetic_position varchar(8),
	Coordinate_version varchar(10),
	Sequence_version varchar(10),
	Description varchar(240),
	feature_link varchar(100)
	) ENGINE = MYISAM";
	mysql_query($query);
	
	
	$index="CREATE INDEX FeatName_index ON SGD_features (Feature_Name)";
	mysql_query($index);
	$index="CREATE INDEX GeneName_index ON SGD_features (Standard_gene_name)";
	mysql_query($index);
	
	echo '<p><b>SGD_features</b> has been <font color="green">created </font></p>';
}

function create_Keith_PubMed_ID()
{
	$query="CREATE TABLE Keith_PubMed_ID
	(
	KeiPub int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(KeiPub),
	PubMed_ID int(10),
	PubMed_ID_link varchar(100),
	citation varchar(480)
	) ENGINE = MYISAM";
	mysql_query($query);
	echo '<p><b>Keith_PubMed_ID</b> has been <font color="green">created </font></p>';
}

//function create_genlit()
//{
//	$query="CREATE TABLE gene_literature
//	(
//	genlitID int NOT NULL AUTO_INCREMENT,
//	PRIMARY KEY(genlitID),
//	PubMed_ID int(10),
//	citation varchar(480) NOT NULL,
//	gene_name varchar(10),
//	feature varchar(40),
//	literature_topic varchar(200) NOT NULL,
//	SGDID varchar(10) NOT NULL
//	)";  
//	mysql_query($query);
//	echo '<p><b>gene_literature</b> has been <font color="green">created </font></p>';
//}
//	add ENGINE = MYISAM";


function create_genlit_edit()
{
	$query="CREATE TABLE gene_literature
	(
	genlitID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(genlitID),
	PubMed_ID int(10),
	citation_link varchar(480),
	citation varchar(480) NOT NULL,
	gene_name varchar(10),
	feature varchar(40),
	literature_topic varchar(200) NOT NULL,
	SGDID varchar(10) NOT NULL,
	feature_link varchar(100) NOT NULL
	) ENGINE = MYISAM";
	mysql_query($query);
	
	$index="CREATE INDEX SGDID_index ON gene_literature (SGDID)";
	mysql_query($index);
	$index="CREATE INDEX PubMed_index ON gene_literature (PubMed_ID)";
	mysql_query($index);

	echo '<p><b>gene_literature</b> has been <font color="green">created </font></p>';
}
function create_ORFlist_edit()
{
	$query="CREATE TABLE ORFlist_homo_dip
	(
	orflistID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(orflistID),
	Feature_Name varchar(40)
	) ENGINE = MYISAM";
	mysql_query($query);
	
	echo '<p><b>The Table create_ORFlist_edit</b> has been <font color="green">created </font></p>';
}

function create_genlit_edit_refOnly()
{
	$query="CREATE TABLE gene_literature
	(
	genlitID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(genlitID),
	PubMed_ID int(10),
	citation_link varchar(480),
	citation varchar(480) NOT NULL
	) ENGINE = MYISAM";
	mysql_query($query);
	echo '<p><b>gene_literature</b> has been <font color="green">created </font></p>';
}

function create_phedat()
{
	$query="CREATE TABLE phenotype_data
	(
	phedatID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(phedatID),
	Feature_Name varchar(40) NOT NULL,
	Feature_Type varchar(40) NOT NULL,
	Gene_Name varchar(10),
	SGDID varchar(10) NOT NULL,
	feature_link varchar(100) NOT NULL,
	Ref_PMID  varchar(12) NOT NULL,
	PMID_link varchar(100),
	Ref_SGD_REF varchar(12) NOT NULL,
	Experiment_Type varchar(100) NOT NULL,
	Mutant_Type varchar(100) NOT NULL,
	Allele varchar(200),
	Strain_Background varchar(10),
	Phenotype varchar(80) NOT NULL,
	Chemical varchar(200),
	Cond_Mut varchar(200),
	Details varchar(260),
	Reporter varchar(200)
	) ENGINE = MYISAM";
	mysql_query($query);
	echo '<p><b>phenotype_data</b> has been <font color="green">created </font></p>';
}

function create_phedat_edit()
{
	$query="CREATE TABLE phenotype_data
	(
	phedatID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(phedatID),
	Feature_Name varchar(40) NOT NULL,
	Gene_Name varchar(10),
	SGDID varchar(10) NOT NULL,
	feature_link varchar(100) NOT NULL,
	Ref_PMID  varchar(12) NOT NULL,
	PMID_link varchar(100),
	Ref_SGD_REF varchar(12) NOT NULL,
	Experiment_Type varchar(100) NOT NULL,
	Phenotype varchar(80) NOT NULL,
	Chemical varchar(480)
	) ENGINE = MYISAM";
	mysql_query($query);
	
	$index="CREATE INDEX SGDID_index ON phenotype_data (SGDID)";
	mysql_query($index);
	$index="CREATE INDEX PMID_index ON phenotype_data (Ref_PMID)";
	mysql_query($index);

	echo '<p><b>phenotype_data</b> has been <font color="green">created </font></p>';
}

function create_UWS_Del_Lib_Screen()
{
	$query="CREATE TABLE UWS_Del_Lib_Screen
	(
	keinewID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(keinewID),
	Feature_Name varchar(40),
	Gene_Name varchar(10),
	SGDID varchar(10),
	feature_link varchar(100),
	Ref_PMID  varchar(12),
	citation_link varchar(480),
	Experiment_Type varchar(100),
	Phenotype varchar(80),
	Chemical varchar(200),
	citation varchar(200)
	) ENGINE = MYISAM";
	mysql_query($query);
	
	$index="CREATE INDEX SGDID_index ON UWS_Del_Lib_Screen (SGDID)";
	mysql_query($index);
	$index="CREATE INDEX PMID_index ON UWS_Del_Lib_Screen (Ref_PMID)";
	mysql_query($index);
	$index="CREATE INDEX Feat_index ON UWS_Del_Lib_Screen (Feature_Name)";
	mysql_query($index);

	echo '<p><b>UWS_Del_Lib_Screen</b> has been <font color="green">created </font></p>';
}


function create_MYSQL_combined_data()
{
	$query="CREATE TABLE combined_data
	(
	comdatID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(comdatID),
	paperID int(4),
	phenotypeID int(4),
	Feature_Name varchar(40) NOT NULL,
	Gene_Name varchar(10),
	SGDID varchar(10) NOT NULL,
	feature_link varchar(100) NOT NULL,
	PubMed_ID varchar(12) NOT NULL,
	PubMed_ID_link varchar(100),
	PheChem varchar(480) NOT NULL,
	Flatfile varchar(20) NOT NULL,
	citation varchar(480),
	SGD_Parent_feature_name varchar (20), 
	SGD_Start_coordinate int(10), 
	SGD_Stop_coordinate int(10), 
	SGD_Strand tinytext, 
	SGD_Description varchar(240), 
	SGD_Feature_qualifier varchar(20), 
	Gene_len_bp int(10), 
	OneGeneGO_Fcnt int(3), 
	OneGeneGO_F_terms text, 
	OneGeneGO_Pcnt int(3), 
	OneGeneGO_P_terms text, 
	OneGeneGO_Ccnt int(3), 
	OneGeneGO_C_terms text, 
	OneGenePPI_Phy_cnt int(3), 
	OneGenePPI_Phy_NN text, 
	OneGenePPI_Gen_cnt int(3), 
	OneGenePPI_Gen_NN text, 
	OneGenePPI_Phy_NN_unique text, 
	OneGenePPI_Gen_NN_unique text,
	OneGenePPI_Phy_NN_uniqueB text, 
	OneGenePPI_Gen_NN_uniqueB text,
	Protein_Abundance MEDIUMINT,
	Occurence int(3)
	) ENGINE = MYISAM";
	
	mysql_query($query);

	$index="CREATE INDEX Feat_index ON combined_data (Feature_Name)";
	mysql_query($index);
	
	$index="CREATE INDEX SGDID_index ON combined_data (SGDID)";
	mysql_query($index);

	$index="CREATE INDEX phenotypeID_index ON combined_data (phenotypeID)";
	mysql_query($index);

	echo '<p>MYSQL <b>combined_data</b> has been <font color="green">created </font></p>';
}

function create_MYSQL_intersection_data()
{
	$query="CREATE TABLE intersection_data
	(
	intdatID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(intdatID),
	setA_phenotypeID int(4),
	setB_phenotypeID int(4),
	db_row_count int(4),
	setA_PubMed_ID varchar(100),
	setA_citation  varchar(480),
	setA_phenotype varchar(480) NOT NULL,
	setA_count int(4),
	setA_genelist TEXT,
	setB_PubMed_ID varchar(100),
	setB_citation  varchar(480),
	setB_phenotype varchar(480) NOT NULL, 
	setB_count int(4),
	setB_genelist TEXT,
	Intersection_count int(4),
	Intersection_genes TEXT,
	inter_Phenotype_GO_P_terms_lists TEXT,
	inter_Phenotype_GO_F_terms_lists TEXT,
	inter_Phenotype_GO_C_terms_lists TEXT,
	pvalue DOUBLE
	) ENGINE = MYISAM";
	
	mysql_query($query);
	
	$index="CREATE INDEX rowCount_index ON intersection_data (db_row_count)";
	mysql_query($index);

	echo '<p>MYSQL <b>intersection_data</b> has been <font color="green">created </font></p>';

}

function create_MYSQL_man_intersect_data()
{
	$query="CREATE TABLE man_intersect_data
	(
	intdatID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(intdatID),
	setA_phenotypeID int(4),
	setB_phenotypeID int(4),
	db_row_count int(4),
	setA_PubMed_ID varchar(100),
	setA_citation  varchar(480),
	setA_phenotype varchar(480) NOT NULL,
	setA_count int(4),
	setA_genelist TEXT,
	setB_PubMed_ID varchar(100),
	setB_citation  varchar(480),
	setB_phenotype varchar(480) NOT NULL, 
	setB_count int(4),
	setB_genelist TEXT,
	Intersection_count int(4),
	Intersection_genes TEXT,
	inter_Phenotype_GO_P_terms_lists TEXT,
	inter_Phenotype_GO_F_terms_lists TEXT,
	inter_Phenotype_GO_C_terms_lists TEXT,
	pvalue DOUBLE
	) ENGINE = MYISAM";
	
	mysql_query($query);
	
	$index="CREATE INDEX rowCount_index ON man_intersect_data (db_row_count)";
	mysql_query($index);

	echo '<p>MYSQL <b>man_intersect_data</b> has been <font color="green">created </font></p>';

}

function create_MYSQL_comb_paper_data()
{
	$query="CREATE TABLE comb_paper_data 
	(
	compapID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(compapID),
	paperID int(4),
	phenotypeID int(4),
	PubMed_ID varchar(100),
	citation  varchar(480),
	phenotype varchar(480) NOT NULL,
	count int(4),
	genelist TEXT,
	Phenotype_GO_P_terms_lists TEXT,
	Phenotype_GO_F_terms_lists TEXT,
	Phenotype_GO_C_terms_lists TEXT,
	Phenotype_PPI_Phy_NN_unique_lists TEXT,
	Phenotype_PPI_Gen_NN_unique_lists TEXT,
	similar_phe int(3)
	) ENGINE = MYISAM";
	
	mysql_query($query);
	
	echo '<p><b>comb_paper_data</b> has been <font color="green">created </font></p>';

}

function create_protein_properties()
{
//	proproID int NOT NULL AUTO_INCREMENT, causes failure in create table???

	$query="CREATE TABLE protein_properties
	(
	FEATURE varchar(40) NOT NULL, 
	SGDID varchar(10) NOT NULL,
	MOLECULAR_WEIGHT int(6),
	PI float(4), 
	CAI float(5), 
	PROTEIN_LENGTH int(4),
	N_TERM_SEQ char(7) NOT NULL,
	C_TERM_SEQ char(7) NOT NULL,
	CODON_BIAS float(5),
	ALA int(3) NOT NULL, 
	ARG int(3) NOT NULL, 
	ASN int(3) NOT NULL, 
	ASP int(3) NOT NULL, 
	CYS int(3) NOT NULL, 
	GLN int(3) NOT NULL, 
	GLU int(3) NOT NULL, 
	GLY int(3) NOT NULL, 
	HIS int(3) NOT NULL, 
	ILE int(3) NOT NULL, 
	LEU int(3) NOT NULL, 
	LYS int(3) NOT NULL, 
	MET int(3) NOT NULL, 
	PHE int(3) NOT NULL, 
	PRO int(3) NOT NULL, 
	SER int(3) NOT NULL, 
	THR int(3) NOT NULL, 
	TRP int(3) NOT NULL, 
	TYR int(3) NOT NULL, 
	VAL int(3) NOT NULL, 
	FOP_SCORE float(4), 
	GRAVY_SCORE float(8), 
	AROMATICITY float(8)
	) ENGINE = MYISAM";
	
	mysql_query($query);

	$index="CREATE INDEX SGDID_index ON protein_properties (SGDID)";
	mysql_query($index);

	echo '<p>MYSQL <b>protein_properties</b> has been <font color="green">created </font></p>';
}

function return_tables()
{
	$query = sprintf("
	SHOW TABLES
	");
	return 	get_assoc_array($query);
}

function describe($table)
{
	$query = sprintf("
	DESCRIBE $table
	");
	return 	get_assoc_array($query);
}

function show_index($table)
{
	$query = sprintf("
	SHOW INDEX FROM $table
	");
	return 	get_assoc_array($query);
}

function select_count($table)
{
	$query = sprintf("
	SELECT COUNT(*) FROM $table
	");
	return 	get_assoc_array($query);
}

function get_Sc_GeneList()
{
	$query = sprintf("
	SELECT DISTINCT `Standard_gene_name`, `Feature_Name` FROM `SGD_features` WHERE `Feature_Type` ='ORF' ORDER BY `Standard_gene_name`
	");
	return 	get_assoc_array($query);
}

function get_YDL_GeneList()
{
	$query = sprintf("
	SELECT DISTINCT `Gene_name`, `Feature_Name` FROM `combined_data` ORDER BY `Gene_name`
	");
	return 	get_assoc_array($query);
}


function get_chemical()
{
	$query = sprintf("
	SELECT DISTINCT `Chemical` FROM `phenotype_data` ORDER BY `Chemical`
	");
	return 	get_assoc_array($query);
}

function get_literature()
{
	$query = sprintf("
	SELECT DISTINCT `gene_name` FROM `gene_literature` ORDER BY `gene_name`
	");
	return 	get_assoc_array($query);
}

function get_SGD_features()
{
	$query = sprintf("
	SELECT DISTINCT `Standard_gene_name` FROM `SGD_features` ORDER BY `Standard_gene_name`
	");
	return 	get_assoc_array($query);
}


function SEL_A_FROM_comb_paper_data_B($A, $B)
{
	$query = sprintf("
	SELECT ".$A." FROM comb_paper_data ".$B."
	");
	return 	get_assoc_array($query);
}

function get_all_papers()
{
	$query = sprintf("
	SELECT DISTINCT paperID, phenotypeID, citation, PubMed_ID FROM comb_paper_data ORDER BY citation
	");
	return 	get_assoc_array($query);
}


function all_paper_to_phe_array()
{
	$query = sprintf("
	SELECT DISTINCT paperID, citation FROM comb_paper_data ORDER BY citation
	");
	$distinct_papers_number = get_assoc_array($query);
	//show_array($distinct_papers_number);
	
	foreach($distinct_papers_number as $v){
		$paperID = $v['paperID'];
		$query = sprintf("
		SELECT paperID, phenotypeID, citation, PubMed_ID, phenotype, similar_phe FROM comb_paper_data 
		WHERE paperID = '".$paperID."' ORDER BY phenotypeID
		");
		$phe_details = get_assoc_array($query);
		
		$array["$paperID"] = $phe_details;
	}
		
	return 	$array;
}

function get_row_from_comb_paper_data($feild, $value)
{
	$query = sprintf("
	SELECT * FROM comb_paper_data WHERE ".$feild." = '".$value."'
	");
	$result = get_assoc_array($query);
	return $result;
}

function get_row_from_SGD_features($feild, $value)
{
	$query = sprintf("
	SELECT * FROM SGD_features WHERE ".$feild." = '".$value."'
	");
	$result = get_assoc_array($query);
	return $result;
}

function get_distinct_citation($phenotypeID)
{
	$query = sprintf("
	SELECT citation FROM comb_paper_data WHERE phenotypeID = '".$phenotypeID."'
	");
	$result = get_assoc_array($query);
	return $result[0]['citation'];
}


//function get_intersection_data_05($phenotypeID)
//{
//	$query = sprintf("
//	SELECT * FROM comb_paper_data WHERE phenotypeID = '".$phenotypeID."'
//	");
//	return 	get_assoc_array($query);
//}


//return all phenotypes for a paper as array
function get_phenotypes($PubMed_ID)
{
	$query = sprintf("
	SELECT DISTINCT phenotype, phenotypeID FROM comb_paper_data WHERE PubMed_ID = '".$PubMed_ID."'
	");
	return 	get_assoc_array($query);
}

//function get_intersection_data_04($phenotype, $PuMed_ID)
//{
//	$phenotype = str_replace('%', '%%', $phenotype);		
//
//	$query = sprintf("
//	SELECT setA_citation, setA_phenotype, setA_count, setB_citation, setB_phenotype, setB_count, setB_PubMed_ID, Intersection_genes, Intersection_count, pvalue  FROM intersection_data WHERE setA_phenotype = '".$phenotype."'  AND setA_PubMed_ID = '".$PuMed_ID."' ORDER BY pvalue ASC 
//	");
//	return 	get_assoc_array($query);
//}
//
function get_intersection_data_04A($phenotypeID)
{
	$query = sprintf("
	SELECT intdatID, setB_phenotypeID AS phenotypeID, setB_citation AS cit, setB_phenotype AS phe, setB_count AS cnt, setB_PubMed_ID AS pmid, Intersection_genes, Intersection_count, pvalue, setB_genelist AS genelist
	FROM intersection_data 
	WHERE setA_phenotypeID = '".$phenotypeID."'
	ORDER BY pvalue ASC 
	");
	return 	get_assoc_array($query);
}

function get_intersection_data_04B($phenotypeID)
{
	$query = sprintf("
	SELECT intdatID, setA_phenotypeID AS phenotypeID, setA_citation AS cit, setA_phenotype AS phe, setA_count AS cnt, setA_PubMed_ID AS pmid, Intersection_genes, Intersection_count, pvalue, setA_genelist AS genelist
	FROM intersection_data 
	WHERE setB_phenotypeID = '".$phenotypeID."'
	ORDER BY pvalue ASC 
	");
	return 	get_assoc_array($query);
}

function get_intersection_data_mainA($phenotypeID)
{
	$query = sprintf("
	SELECT setA_phenotypeID AS phenotypeID, setA_citation AS cit, setA_phenotype AS phe, setA_count AS cnt, setA_PubMed_ID AS pmid, setA_genelist AS genelist
	FROM intersection_data 
	WHERE setA_phenotypeID = '".$phenotypeID."'
	ORDER BY pvalue ASC 
	");
	return 	get_assoc_array($query);
}

function get_intersection_data_mainB($phenotypeID)
{
	$query = sprintf("
	SELECT setB_phenotypeID AS phenotypeID, setB_citation AS cit, setB_phenotype AS phe, setB_count AS cnt, setB_PubMed_ID AS pmid, setB_genelist AS genelist
	FROM intersection_data 
	WHERE setB_phenotypeID = '".$phenotypeID."'
	ORDER BY pvalue ASC 
	");
	return 	get_assoc_array($query);
}

function get_row_from_intersection_data($feild, $value)
{
	$query = sprintf("
	SELECT *  
	FROM intersection_data 
	WHERE ".$feild." = '".$value."'
	");
	return 	get_assoc_array($query);
}

function get_row_from_combined_data($feild, $value)
{
	$query = sprintf("
	SELECT * FROM combined_data WHERE ".$feild." = '".$value."'
	ORDER BY Feature_Name ASC");
	$result = get_assoc_array($query);
	return $result;
}


function count_similar_phe( $phenotypeID )
{

	$query = sprintf("
	SELECT count(setA_PubMed_ID) AS countPhe
	FROM intersection_data 
	WHERE (setA_phenotypeID = '".$phenotypeID."')
	OR (setB_phenotypeID = '".$phenotypeID."')
	");
	
	return 	get_assoc_array($query);
}

function get_intersection_data_06()
{

	$query = sprintf("
	SELECT DISTINCT PubMed_ID, citation FROM comb_paper_data ORDER BY citation ASC 
	");
	$papers = get_assoc_array($query);
	
	foreach($papers as $v){
		$query = sprintf("
		SELECT DISTINCT citation, PubMed_ID, phenotype, count FROM comb_paper_data WHERE PubMed_ID = '".$v['PubMed_ID']."'
		");
		$phenotypes[] = get_assoc_array($query);
	}
	
	return 	$phenotypes;
}

function get_intersection_data_07($phenotypeID)
{

	$query = sprintf("
	SELECT DISTINCT 
		Feature_Name, 
		Gene_Name,
		feature_link,
		PubMed_ID_link,
		OneGeneGO_Pcnt,
		OneGeneGO_P_terms,
		OneGeneGO_Fcnt,
		OneGeneGO_F_terms,
		OneGeneGO_Ccnt,
		OneGeneGO_C_terms,
		OneGenePPI_Phy_cnt,
		OneGenePPI_Phy_NN,
		OneGenePPI_Gen_cnt,
		OneGenePPI_Gen_NN,
		SGD_Description,
		Gene_len_bp,
		SGD_Parent_feature_name,
		Protein_Abundance
	FROM 
		combined_data WHERE phenotypeID = '".$phenotypeID."'
	");
	return 	get_assoc_array($query);
}


?>