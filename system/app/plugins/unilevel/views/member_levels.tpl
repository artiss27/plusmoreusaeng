{include file='views/members/header.tpl'}
{include file='views/members/menu.tpl'}
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
{include file='views/members/breadcrumb.tpl'}            
            <h2 class="font-light m-b-xs">
               {$plugin_lang.geneaology}
            </h2>
            <small>{$plugin_lang.geneaology}</small>
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
            {if $smarty.session.message}
            <p class="alert alert-success">
               {assign var=message_var value=CoreHelp::flash('message')}
               {$message_var}
            </p>
            <br />
            {/if} 
            {if $smarty.session.error}
            {assign var=message_var value=CoreHelp::flash('error')}            	
            {if $message_var|is_array}
            {foreach $message_var as $error}
            <p class="alert alert-danger">
               {$error}
            </p>
            <br />
            {/foreach} 
            {else}
            <p class="alert alert-danger">
               {$message_var}
            </p>
            <br />
            {/if}
            {/if}   
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
{include file='views/members/right_sidebar.tpl'}   
<!-- Vendor scrits -->
{include file='views/members/vendor_scripts.tpl'} 
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

{include file='views/members/footer.tpl'}
