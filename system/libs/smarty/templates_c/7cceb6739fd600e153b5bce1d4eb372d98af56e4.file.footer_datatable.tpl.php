<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 14:09:25
         compiled from "system/app/views/admin/footer_datatable.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2194539785cf82f85614ea1-80736712%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7cceb6739fd600e153b5bce1d4eb372d98af56e4' => 
    array (
      0 => 'system/app/views/admin/footer_datatable.tpl',
      1 => 1503704414,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2194539785cf82f85614ea1-80736712',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<script src="/assets/common/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="/assets/common/vendor/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

<script>
    $(document).ready( function() {  
		 <?php if ($_smarty_tpl->getVariable('list')->value){?>$('#transaction').dataTable({
        	"order": [[ 0, "desc" ]]
    	});<?php }?> 

    });
</script>