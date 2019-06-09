<?php /* Smarty version Smarty-3.0.8, created on 2019-06-03 09:53:31
         compiled from "system/app/plugins/unilevel/views/member_levels.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15315541605cf5508b03b577-98475569%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9828616f86c4f6e37ad3406dc207e7ab659dbc9a' => 
    array (
      0 => 'system/app/plugins/unilevel/views/member_levels.tpl',
      1 => 1503705083,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15315541605cf5508b03b577-98475569',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('views/members/header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('views/members/menu.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<link rel="stylesheet" href="/assets/admin/css/themes/proton/style.css" />
<style>
.container-tree {
  background: #FFF;
  float: left;
  width: 100%;
  padding: 20px;
  margin-top: 15px;
}
.container-tree .wrapper {
  padding: 10px;
  background: #FFF;
  float: left;
  width:auto;
}
.container-tree .wrapper #tree-simple {
  margin: 0px;
}
.profilepic {
    width: 15px;
    height: 15px;
    border-radius: 50%;
}
</style>
<!-- Main Wrapper -->
<div id="wrapper">
   <div class="normalheader transition animated fadeIn">
      <div class="hpanel">
         <div class="panel-body">
            <a class="small-header-action" href="">
               <div class="clip-header">
                  <i class="fa fa-arrow-up"></i>
               </div>
            </a>
<?php $_template = new Smarty_Internal_Template('views/members/breadcrumb.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>            
            <h2 class="font-light m-b-xs">
               <?php echo $_smarty_tpl->getVariable('plugin_lang')->value['geneaology'];?>

            </h2>
            <small><?php echo $_smarty_tpl->getVariable('plugin_lang')->value['geneaology'];?>
</small>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="normalheader transition animated fadeIn">
         <div class="hpanel">
            <div class="panel-body">
               <a class="small-header-action" href="">
                  <div class="clip-header">
                     <i class="fa fa-arrow-up"></i>
                  </div>
               </a>
            <?php if ($_SESSION['message']){?>
            <p class="alert alert-success">
               <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('message'), null, null);?>
               <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

            </p>
            <br />
            <?php }?> 
            <?php if ($_SESSION['error']){?>
            <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('error'), null, null);?>            	
            <?php if (is_array($_smarty_tpl->getVariable('message_var')->value)){?>
            <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('message_var')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
            <p class="alert alert-danger">
               <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

            </p>
            <br />
            <?php }} ?> 
            <?php }else{ ?>
            <p class="alert alert-danger">
               <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

            </p>
            <br />
            <?php }?>
            <?php }?>   
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                        	<div class="container-tree">
                            	<div class="wrapper"><br />
                                    <div id="container">
                                    </div>    
                                    <br /><br />
                            	</div>
                        	</div>                         
                        </div>
                     </div>
                     <!-- end of box-wrap -->
                  </div>
                  <!-- end of box-body -->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END -->       
<!-- Right sidebar -->
<?php $_template = new Smarty_Internal_Template('views/members/right_sidebar.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>   
<!-- Vendor scrits -->
<?php $_template = new Smarty_Internal_Template('views/members/vendor_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?> 
<!-- App scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.0.9/jstree.min.js"></script>
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
   		$('#container').jstree({
    		'core' : {
				'themes': {
           			'name': 'proton',
            		'responsive': true
        		},
      		'data' : {
       		 "url" : "/plugins/unilevel/unimember/childs/&lazy",
			 "type": 'POST',
       		 "data" : function (node) {
         		 return { "id" : node.id };
        		}
     		 }
    		},
			"plugins" : [ "themes", "html_data" ]
  		});
	  	
   });
   
   $("#container").bind("loaded.jstree", function (event, data) {
	   //alert('loaded');
		$("[data-toggle=popover]").popover({ trigger: "manual" , html: true, animation:false, container: 'body'})
		.on("mouseenter", function () {
			if (!$(".popover:hover").length) {
				$('*').popover("destroy");
			}
			var _this = this;
			$(this).popover("show");
			$(".popover").on("mouseleave", function () {
				$(_this).popover('hide');
			});
		}).on("mouseleave", function () {
			var _this = this;
			setTimeout(function () {
				if (!$(".popover:hover").length) {
					$(_this).popover("hide");
				}
			}, 1);
		});	
	});
   $("#container").bind("open_node.jstree", function (event, data) {
	   //alert('opened');
		$("[data-toggle=popover]").popover({ trigger: "manual" , html: true, animation:false, container: 'body'})
		.on("mouseenter", function () {
			if (!$(".popover:hover").length) {
				$('*').popover("destroy");
			}
			var _this = this;
			$(this).popover("show");
			$(".popover").on("mouseleave", function () {
				$(_this).popover('hide');
			});
		}).on("mouseleave", function () {
			var _this = this;
			setTimeout(function () {
				if (!$(".popover:hover").length) {
					$(_this).popover("hide");
				}
			}, 1);
		});		
	});
  	
	/*	last = '';
		function showPopover(id) {		
			$('#'+id).popover({
				trigger: 'manual', html: true, animation:false, container: 'body'});				
			$('#'+id).popover('show');
			last = id;
      	};
    	function hidePopover(id) {
			$('#'+id).popover('hide');
      	};
		
		$("#container").bind("open_node.jstree", function (event, data) {
			$('*').popover('hide');
			alert('here');
		});*/

</script>

<?php $_template = new Smarty_Internal_Template('views/members/footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
