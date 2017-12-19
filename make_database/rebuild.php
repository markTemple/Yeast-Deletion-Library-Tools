<?php
require_once('./back_header.php');
?>

<?php
if (isset($_GET['run'])) $linkchoice=$_GET['run'];
else $linkchoice='';
?>

<head>
	<title></title>
</head>

<body>

<!--Currently the following tables exist:<br />
--><?php
//$show_tables = "SHOW tables";
//$tables = get_assoc_array($show_tables);
//$x = 1;
//foreach($tables as $v1)
//	{
//	foreach($v1 as $v2)
//		{
//		echo "$x)  $v2 <br />";
//		}
//	$x++;
//	}
////show_array($tables);
//
//?>

<h1>Drop or Create Tables</h1>
	
<fieldset>
			<b>ORFlist_homo_dip Table</b> 
			<a href="?run=ORFlist_drop">Drop</a>
			<a href="?run=ORFlist_edit_create">Create</a>
			<a href="?run=ORFlist_edit_update">Update</a>
			<a href="?run=ORFlist_ALL">ALL</a><br />
			<?php
			if($linkchoice == 'ORFlist_drop') drop_table('ORFlist_homo_dip');
			if($linkchoice == 'ORFlist_edit_create') create_ORFlist_edit();
			if($linkchoice == 'ORFlist_edit_update') include('include_updates/update_ORFlist_homo_dip.php');//update option
			if($linkchoice == 'ORFlist_edit_create') print(show_one_table('ORFlist_homo_dip'));//print on create
			if($linkchoice == 'ORFlist_edit_update') print(show_one_table('ORFlist_homo_dip'));//print on update
			if($linkchoice == 'ORFlist_ALL') drop_table('ORFlist_homo_dip');
			if($linkchoice == 'ORFlist_ALL') create_ORFlist_edit();
			if($linkchoice == 'ORFlist_ALL') print(show_one_table('ORFlist_homo_dip'));
			if($linkchoice == 'ORFlist_ALL') include('include_updates/update_ORFlist_homo_dip.php');
			if($linkchoice == 'ORFlist_ALL') print(show_one_table('ORFlist_homo_dip'));
			?>	
</fieldset>		

<fieldset>
		
			<b>Keith_PubMed_ID Table</b> 
			<a href="?run=KeiPub_drop">Drop</a> 
			<a href="?run=KeiPub_create">Create</a> 
			<a href="?run=KeiPub_update">Update</a> 
			<a href="?run=KeiPub_ALL">ALL</a> - note gene_literature' must exist<br />
			<?php
			if($linkchoice == 'KeiPub_drop') drop_table('Keith_PubMed_ID');
			if($linkchoice == 'KeiPub_create') create_Keith_PubMed_ID();
			if($linkchoice == 'KeiPub_update') include('include_updates/update_Keith_PubMed_ID.php');
			if($linkchoice == 'KeiPub_create') print(show_one_table('Keith_PubMed_ID'));
			if($linkchoice == 'KeiPub_update') print(show_one_table('Keith_PubMed_ID'));
			if($linkchoice == 'KeiPub_ALL') drop_table('Keith_PubMed_ID');
			if($linkchoice == 'KeiPub_ALL') create_Keith_PubMed_ID();
			if($linkchoice == 'KeiPub_ALL') print(show_one_table('Keith_PubMed_ID'));
			if($linkchoice == 'KeiPub_ALL') include('include_updates/update_Keith_PubMed_ID.php');
			if($linkchoice == 'KeiPub_ALL') print(show_one_table('Keith_PubMed_ID'));

			?>
</fieldset>		
<fieldset>
		
			<b>sgd_features Table</b> 
			<a href="?run=sgdfea_drop">Drop</a> 
			<a href="?run=sgdfea_create">Create</a> 
			<a href="?run=sgdfea_update">Update</a> 
			<a href="?run=sgdfea_BY">Add_BY_detail</a> 
			<a href="?run=sgdfea_ALL">ALL</a><br />
			<?php
			if($linkchoice == 'sgdfea_drop') drop_table('SGD_features');
			if($linkchoice == 'sgdfea_create') create_sgd_features();
			if($linkchoice == 'sgdfea_update') include('include_updates/update_sgd_features.php');//update option
			if($linkchoice == 'sgdfea_BY') include('include_updates/add_BYdetail2SGD.php');//update option for use in make random table
			if($linkchoice == 'sgdfea_create') print(show_one_table('SGD_features'));//print on create
			if($linkchoice == 'sgdfea_update') print(show_one_table('SGD_features'));//print on update
			if($linkchoice == 'sgdfea_BY') print(show_one_table('SGD_features'));//print on update
			if($linkchoice == 'sgdfea_ALL') drop_table('SGD_features');
			if($linkchoice == 'sgdfea_ALL') create_sgd_features();
			if($linkchoice == 'sgdfea_ALL') print(show_one_table('SGD_features'));//print on create
			if($linkchoice == 'sgdfea_ALL') include('include_updates/update_sgd_features.php');//update option
			if($linkchoice == 'sgdfea_ALL') print(show_one_table('SGD_features'));//print on update
			if($linkchoice == 'sgdfea_ALL') include('include_updates/add_BYdetail2SGD.php');//update option in make random table
			if($linkchoice == 'sgdfea_ALL') print(show_one_table('SGD_features'));//print on update
			?>		
</fieldset>		

<fieldset>

			<b>registry_genenames Table</b> 
			<a href="?run=reggen_drop">Drop</a> 
			<a href="?run=reggen_create">Create</a> 
			<a href="?run=reggen_update">Update</a> 
			<a href="?run=reggen_ALL">ALL</a><br />
			<?php
			if($linkchoice == 'reggen_drop') drop_table('registry_genenames');
			if($linkchoice == 'reggen_create') create_registry_genenames();
			if($linkchoice == 'reggen_update') include('include_updates/update_registry_genenames.php');//update option
			if($linkchoice == 'reggen_create') print(show_one_table('registry_genenames'));//print on create
			if($linkchoice == 'reggen_update') print(show_one_table('registry_genenames'));//print on update
			if($linkchoice == 'reggen_ALL') drop_table('registry_genenames');
			if($linkchoice == 'reggen_ALL') create_registry_genenames();
			if($linkchoice == 'reggen_ALL') print(show_one_table('registry_genenames'));//print on update
			if($linkchoice == 'reggen_ALL') include('include_updates/update_registry_genenames.php');//update option
			if($linkchoice == 'reggen_ALL') print(show_one_table('registry_genenames'));//print on create
			?>		
</fieldset>		
<fieldset>

			<b>biochemical_pathways Table</b> 
			<a href="?run=biopat_drop">Drop</a> 
			<a href="?run=biopat_create">Create</a> 
			<a href="?run=biopat_update">Update</a> 
			<a href="?run=biopat_ALL">ALL</a><br />
			<?php
			if($linkchoice == 'biopat_drop') drop_table('biochemical_pathways');
			if($linkchoice == 'biopat_create') create_biochemical_pathways();
			if($linkchoice == 'biopat_update') include('include_updates/update_biochemical_pathways.php');//update option
			if($linkchoice == 'biopat_create') print(show_one_table('biochemical_pathways'));//print on create
			if($linkchoice == 'biopat_update') print(show_one_table('biochemical_pathways'));//print on update
			if($linkchoice == 'biopat_ALL') drop_table('biochemical_pathways');
			if($linkchoice == 'biopat_ALL') create_biochemical_pathways();
			if($linkchoice == 'biopat_ALL') print(show_one_table('biochemical_pathways'));//print on update
			if($linkchoice == 'biopat_ALL') include('include_updates/update_biochemical_pathways.php');//update option
			if($linkchoice == 'biopat_ALL') print(show_one_table('biochemical_pathways'));//print on create
			?>		
</fieldset>		
<fieldset>

			<b>go_protein_complex_slim Table</b> 
			<a href="?run=gpcs_drop">Drop</a> 
			<a href="?run=gpcs_create">Create</a> 
			<a href="?run=gpcs_update">Update</a> 
			<a href="?run=gpcs_ALL">ALL</a><br />
			<?php
			if($linkchoice == 'gpcs_drop') drop_table('go_protein_complex_slim');
			if($linkchoice == 'gpcs_create') create_go_protein_complex_slim();
			if($linkchoice == 'gpcs_update') include('include_updates/update_go_protein_complex_slim.php');//update option
			if($linkchoice == 'gpcs_create') print(show_one_table('go_protein_complex_slim'));//print on create
			if($linkchoice == 'gpcs_update') print(show_one_table('go_protein_complex_slim'));//print on update
			if($linkchoice == 'gpcs_ALL') drop_table('go_protein_complex_slim');
			if($linkchoice == 'gpcs_ALL') create_go_protein_complex_slim();
			if($linkchoice == 'gpcs_ALL') print(show_one_table('go_protein_complex_slim'));//print on update
			if($linkchoice == 'gpcs_ALL') include('include_updates/update_go_protein_complex_slim.php');//update option
			if($linkchoice == 'gpcs_ALL') print(show_one_table('go_protein_complex_slim'));//print on create
			?>		
</fieldset>		
<fieldset>

			<b>go_terms Table</b> 
			<a href="?run=goter_drop">Drop</a> 
			<a href="?run=goter_create">Create</a> 
			<a href="?run=goter_update">Update</a> 
			<a href="?run=goter_ALL">ALL</a><br />
			<?php
			if($linkchoice == 'goter_drop') drop_table('go_terms');
			if($linkchoice == 'goter_create') create_go_terms();
			if($linkchoice == 'goter_update') include('include_updates/update_go_terms.php');//update option
			if($linkchoice == 'goter_create') print(show_one_table('go_terms'));//print on create
			if($linkchoice == 'goter_update') print(show_one_table('go_terms'));//print on update
			if($linkchoice == 'goter_ALL') drop_table('go_terms');
			if($linkchoice == 'goter_ALL') create_go_terms();
			if($linkchoice == 'goter_ALL') print(show_one_table('go_terms'));//print on update
			if($linkchoice == 'goter_ALL') include('include_updates/update_go_terms.php');//update option
			if($linkchoice == 'goter_ALL') print(show_one_table('go_terms'));//print on create
			?>		
</fieldset>		
<fieldset>
			<b>go_slim_mapping Table</b> 
			<a href="?run=gsm_drop">Drop</a> 
			<a href="?run=gsm_create">Create</a> 
			<a href="?run=gsm_update">Update</a> 
			<a href="?run=gsm_ALL">ALL</a><br />
			<?php
			if($linkchoice == 'gsm_drop') drop_table('go_slim_mapping');
			if($linkchoice == 'gsm_create') create_go_slim_mapping();
			if($linkchoice == 'gsm_update') include('include_updates/update_go_slim_mapping.php');//update option
			if($linkchoice == 'gsm_create') print(show_one_table('go_slim_mapping'));//print on create
			if($linkchoice == 'gsm_update') print(show_one_table('go_slim_mapping'));//print on update
			if($linkchoice == 'gsm_ALL') drop_table('go_slim_mapping');
			if($linkchoice == 'gsm_ALL') create_go_slim_mapping();
			if($linkchoice == 'gsm_ALL') print(show_one_table('go_slim_mapping'));//print on update
			if($linkchoice == 'gsm_ALL') include('include_updates/update_go_slim_mapping.php');//update option
			if($linkchoice == 'gsm_ALL') print(show_one_table('go_slim_mapping'));//print on create
			?>		
</fieldset>		
<fieldset>
			<b>protein_properties Table</b> 
			<a href="?run=PP_drop">Drop</a> 
			<a href="?run=PP_create">Create</a> 
			<a href="?run=PP_update">Update</a> 
			<a href="?run=PP_ALL">ALL</a><br />
			<?php
			if($linkchoice == 'PP_drop') drop_table('protein_properties');
			if($linkchoice == 'PP_create') create_protein_properties();
			if($linkchoice == 'PP_update') include('include_updates/update_protein_properties.php');//update option
			if($linkchoice == 'PP_create') print(show_one_table('protein_properties'));//print on create
			if($linkchoice == 'PP_update') print(show_one_table('protein_properties'));//print on update
			if($linkchoice == 'PP_ALL') drop_table('protein_properties');
			if($linkchoice == 'PP_ALL') create_protein_properties();
			if($linkchoice == 'PP_ALL') print(show_one_table('protein_properties'));//print on update
			if($linkchoice == 'PP_ALL') include('include_updates/update_protein_properties.php');//update option
			if($linkchoice == 'PP_ALL') print(show_one_table('protein_properties'));//print on create
			?>		

</fieldset>	
All of the above ...
<fieldset>	<b>DROP create UPDATE ALL above Tables</b> 
			<a href="?run=DROPcreateUPDATE_ALL">DROP create UPDATE ALL Tables</a> <br />

			<?php
			if($linkchoice == 'DROPcreateUPDATE_ALL') drop_table('ORFlist_homo_dip');
			if($linkchoice == 'DROPcreateUPDATE_ALL') create_ORFlist_edit();
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('ORFlist_homo_dip'));
			if($linkchoice == 'DROPcreateUPDATE_ALL') include('include_updates/update_ORFlist_homo_dip.php');
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('ORFlist_homo_dip'));
			if($linkchoice == 'DROPcreateUPDATE_ALL') drop_table('Keith_PubMed_ID');
			if($linkchoice == 'DROPcreateUPDATE_ALL') create_Keith_PubMed_ID();
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('Keith_PubMed_ID'));
			if($linkchoice == 'DROPcreateUPDATE_ALL') include('include_updates/update_Keith_PubMed_ID.php');
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('Keith_PubMed_ID'));
			if($linkchoice == 'DROPcreateUPDATE_ALL') drop_table('SGD_features');
			if($linkchoice == 'DROPcreateUPDATE_ALL') create_sgd_features();
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('SGD_features'));//print on create
			if($linkchoice == 'DROPcreateUPDATE_ALL') include('include_updates/update_sgd_features.php');//update option
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('SGD_features'));//print on update
			if($linkchoice == 'DROPcreateUPDATE_ALL') include('include_updates/add_BYdetail2SGD.php');//update in make random table
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('SGD_features'));//print on update
			if($linkchoice == 'DROPcreateUPDATE_ALL') drop_table('registry_genenames');
			if($linkchoice == 'DROPcreateUPDATE_ALL') create_registry_genenames();
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('registry_genenames'));//print on update
			if($linkchoice == 'DROPcreateUPDATE_ALL') include('include_updates/update_registry_genenames.php');//update option
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('registry_genenames'));//print on create
			if($linkchoice == 'DROPcreateUPDATE_ALL') drop_table('biochemical_pathways');
			if($linkchoice == 'DROPcreateUPDATE_ALL') create_biochemical_pathways();
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('biochemical_pathways'));//print on update
			if($linkchoice == 'DROPcreateUPDATE_ALL') include('include_updates/update_biochemical_pathways.php');//update option
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('biochemical_pathways'));//print on create
			if($linkchoice == 'DROPcreateUPDATE_ALL') drop_table('go_protein_complex_slim');
			if($linkchoice == 'DROPcreateUPDATE_ALL') create_go_protein_complex_slim();
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('go_protein_complex_slim'));//print on update
			if($linkchoice == 'DROPcreateUPDATE_ALL') include('include_updates/update_go_protein_complex_slim.php');//update option
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('go_protein_complex_slim'));//print on create
			if($linkchoice == 'DROPcreateUPDATE_ALL') drop_table('go_terms');
			if($linkchoice == 'DROPcreateUPDATE_ALL') create_go_terms();
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('go_terms'));//print on update
			if($linkchoice == 'DROPcreateUPDATE_ALL') include('include_updates/update_go_terms.php');//update option
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('go_terms'));//print on create
			if($linkchoice == 'DROPcreateUPDATE_ALL') drop_table('go_slim_mapping');
			if($linkchoice == 'DROPcreateUPDATE_ALL') create_go_slim_mapping();
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('go_slim_mapping'));//print on update
			if($linkchoice == 'DROPcreateUPDATE_ALL') include('include_updates/update_go_slim_mapping.php');//update option
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('go_slim_mapping'));//print on create
			if($linkchoice == 'DROPcreateUPDATE_ALL') drop_table('protein_properties');
			if($linkchoice == 'DROPcreateUPDATE_ALL') create_protein_properties();
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('protein_properties'));//print on update
			if($linkchoice == 'DROPcreateUPDATE_ALL') include('include_updates/update_protein_properties.php');//update option
			if($linkchoice == 'DROPcreateUPDATE_ALL') print(show_one_table('protein_properties'));//print on create
			?>		
	
</fieldset>		
Do these individually...
<fieldset>
		
			<b>UWS_Del_Lib_Screen Table</b> 
			<a href="?run=keinew_drop">Drop</a> 
			<a href="?run=keinew_create">Create</a> 
			<a href="?run=keinew_update">Update</a>
			<a href="?run=keinew_patch_fromSGD">Patch</a> 
			<a href="?run=keinew_ALL">ALL</a><br />
			Note MUST create/update sgd_features Table first!<br />
			<?php
			if($linkchoice == 'keinew_drop') drop_table('UWS_Del_Lib_Screen');
			if($linkchoice == 'keinew_create') create_UWS_Del_Lib_Screen();
			if($linkchoice == 'keinew_update') include('include_updates/update_UWS_Del_Lib_Screen.php');
			if($linkchoice == 'keinew_patch_fromSGD') get_SGD_feature();
			if($linkchoice == 'keinew_create') print(show_one_table('UWS_Del_Lib_Screen'));//print on create
			if($linkchoice == 'keinew_update') print(show_one_table('UWS_Del_Lib_Screen'));//print on update
			if($linkchoice == 'keinew_patch_fromSGD') print(show_one_table('UWS_Del_Lib_Screen'));//print on update
			if($linkchoice == 'keinew_ALL') drop_table('UWS_Del_Lib_Screen');
			if($linkchoice == 'keinew_ALL') create_UWS_Del_Lib_Screen();
			if($linkchoice == 'keinew_ALL') print(show_one_table('UWS_Del_Lib_Screen'));//print on update
			if($linkchoice == 'keinew_ALL') include('include_updates/update_UWS_Del_Lib_Screen.php');
			if($linkchoice == 'keinew_ALL') print(show_one_table('UWS_Del_Lib_Screen'));//print on update
			if($linkchoice == 'keinew_ALL') get_SGD_feature();
			if($linkchoice == 'keinew_ALL') print(show_one_table('UWS_Del_Lib_Screen'));//print on create
			?>
</fieldset>		
<fieldset>

			<b>interaction_data Table</b> 
			<a href="?run=intdat_drop">Drop</a> 
			<a href="?run=intdat_create">Create</a> 
			<a href="?run=intdat_update">Update</a> 
			<a href="?run=intdat_addDel">Add Deletion Library as Colour</a> 
			<a href="?run=intdat_ALL">ALL</a><br />
			<?php
			if($linkchoice == 'intdat_drop') drop_table('interaction_data');
			if($linkchoice == 'intdat_create') create_interaction_data();
			if($linkchoice == 'intdat_update') include('include_updates/update_interaction_data.php');//update option
			if($linkchoice == 'intdat_addDel') include('include_updates/add_Del2Interaction.php');//update option
			if($linkchoice == 'intdat_create') print(show_one_table('interaction_data'));//print on create
			if($linkchoice == 'intdat_update') print(show_one_table('interaction_data'));//print on update
			if($linkchoice == 'intdat_addDel') print(show_one_table('interaction_data'));//print on update
			if($linkchoice == 'intdat_ALL') drop_table('interaction_data');
			if($linkchoice == 'intdat_ALL') create_interaction_data();
			if($linkchoice == 'intdat_ALL') print(show_one_table('interaction_data'));//print on update
			if($linkchoice == 'intdat_ALL') include('include_updates/update_interaction_data.php');//update option
			if($linkchoice == 'intdat_ALL') print(show_one_table('interaction_data'));//print on update
			if($linkchoice == 'intdat_ALL') include('include_updates/add_Del2Interaction.php');//update option
			if($linkchoice == 'intdat_ALL') print(show_one_table('interaction_data'));//print on create
			?>		
</fieldset>		
<fieldset>
			<b>gene_literature Table</b> 
			<a href="?run=genlit_drop">Drop</a> 
			<a href="?run=genlit_edit_create">Create (EDIT for hyperlinks)</a> 
			<a href="?run=genlit_edit_update">Update</a> 
			<a href="?run=genlit_edit_ALL">ALL</a><br />
			<?php
			if($linkchoice == 'genlit_drop') drop_table('gene_literature');
			if($linkchoice == 'genlit_edit_create') create_genlit_edit();
			if($linkchoice == 'genlit_edit_update') include('include_updates/update_gene_literature_SysyMS.php');//update option
			if($linkchoice == 'genlit_edit_create') print(show_one_table('gene_literature'));//print on create
			if($linkchoice == 'genlit_edit_update') print(show_one_table('gene_literature'));//print on update
			if($linkchoice == 'genlit_edit_ALL') drop_table('gene_literature');
			if($linkchoice == 'genlit_edit_ALL') create_genlit_edit();
			if($linkchoice == 'genlit_edit_ALL') print(show_one_table('gene_literature'));
			if($linkchoice == 'genlit_edit_ALL') include('include_updates/update_gene_literature_SysyMS.php');
			if($linkchoice == 'genlit_edit_ALL') print(show_one_table('gene_literature'));
			?>	
</fieldset>		
<fieldset>
			<b>phenotype_data Table</b> 
			<a href="?run=phedat_drop">Drop</a> 
			<a href="?run=phedat_edit_create">Create (EDIT reduced fields)</a> 
			<a href="?run=phedat_edit_update">Update</a> 
			<a href="?run=phedat_edit_ALL">ALL</a><br />
			<?php
			if($linkchoice == 'phedat_drop') drop_table('phenotype_data');
			if($linkchoice == 'phedat_edit_create') create_phedat_edit();
			if($linkchoice == 'phedat_edit_update') include('include_updates/update_phenotype_data_SysyMS.php');//update option
			if($linkchoice == 'phedat_edit_create') print(show_one_table('phenotype_data'));//print on create
			if($linkchoice == 'phedat_edit_update') print(show_one_table('phenotype_data'));//print on update
			if($linkchoice == 'phedat_edit_ALL') drop_table('phenotype_data');
			if($linkchoice == 'phedat_edit_ALL') create_phedat_edit();
			if($linkchoice == 'phedat_edit_ALL') print(show_one_table('phenotype_data'));
			if($linkchoice == 'phedat_edit_ALL') include('include_updates/update_phenotype_data_SysyMS.php');
			if($linkchoice == 'phedat_edit_ALL') print(show_one_table('phenotype_data'));
			?>		
</fieldset>		

</body>

<?php
require_once('./back_footer.php');
?>	
