{include file='header.tpl'}

<div class="breadcrumb">
	<div class="bread-links pagesize">
		<ul class="clear">
		<li class="first">You are here:</li>
		<li><a href="#">Cycle Settings</a></li>
		</ul>
	</div>
</div>

          

<div class="main pagesize"> <!-- *** mainpage layout *** -->
	<div class="main-wrap">

<div class="content-box">
			<div class="box-body">
				<div class="box-header clear">
					<h2>Cycle Membership Settings</h2>
				</div>
				
				<div class="box-wrap clear">

 {if $cycle_saved eq 'y'}
<div class="alert alert-success">
				
				<p><strong>Cycle Data Saved:</strong> Cycle data was saved succesfully to database.</p>
			</div>
{/if}  


{foreach $errors as $error}

   <div class="alert alert-success">
				
				<p><strong>{$error@key}</strong> {$error}</p>
			</div>
{/foreach}   
					
					
					<div class="columns clear bt-space15">
					
                    
						
  <h2>Edit Cycle</h2>
						<form id="form1" name="form1" method="post" action="/admin/cyclesettings/">
						  
						 <label for="textfield" class="form-label size-120 fl-space2">Title: <span class="required">*</span></label>
				<input name="title" type="text" value="{$data.title}" />
                          <br /><br />
                          <label for="textfield" class="form-label size-120 fl-space2">Hoster Reward: <span class="required">*</span></label>
				
				$ 
				<input name="host_reward" type="text" value="{$data.host_reward}" size="6" />
                          <br /><br />
                          <label for="textfield" class="form-label size-120 fl-space2">Enroller Reward: <span class="required">*</span></label>
                          
				          $ 
				          <input name="enr_reward" type="text" value="{$data.enr_reward}" size="6" />
                          <br /><br />
                          
                          <label for="textfield" class="form-label size-120 fl-space2">Hoster PIF Reward: <span class="required">*</span></label>
                          <input name="host_pif" type="text" value="{$data.host_pif}" size="6" />
                          <br /><br />
                          <label for="textfield" class="form-label size-120 fl-space2">Enroller PIF  Reward: <span class="required">*</span></label>
                          <input name="enr_pif" type="text" value="{$data.enr_pif}" size="6" />
                          <br /><br />
                          
                          <label for="textfield" class="form-label size-120 fl-space2">Width: <span class="required">*</span></label>
				<input name="width" type="text" value="{$data.width}" size="6" />
                          <br /><br />
                          <label for="textfield" class="form-label size-120 fl-space2">Depth: <span class="required">*</span></label>
				<input name="depth" type="text" value="{$data.depth}" size="6" />
                        
                        <input name="type_id" type="hidden" value="{$data.type_id}" />  
                          <br /><br /><input type="submit" class="button red fr" name="save_edit" value="Save" />
  </form>
						<p>&nbsp;</p>

										
			  <div class="form-field clear"></div>
			  <br /><br />
                          
</div><!-- /.form-field -->																								
					
				
					
	  </div><!-- end of box-wrap -->
			</div> <!-- end of box-body -->
			</div>
        </div>
        </div>   
        
{include file='footer.tpl'}            