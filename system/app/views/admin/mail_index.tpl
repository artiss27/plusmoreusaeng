{include file='header.tpl'}

<div class="breadcrumb">
	<div class="bread-links pagesize">
		<ul class="clear">
		<li class="first">You are here:</li>
		<li><a href="#">Mail Boxes</a></li>
		</ul>
	</div>
</div>

          

<div class="main pagesize"> <!-- *** mainpage layout *** -->
	<div class="main-wrap">
    
     {if $member_added eq 'y'}
<div class="alert alert-success">
				
				<p><strong>Member Added:</strong> New member was added succesfully to database.</p>
			</div>
{/if}  
{foreach $errors as $error}

   <div class="alert alert-success">
				
				<p><strong>{$error@key}</strong> {$error}</p>
			</div>
{/foreach}    
    
    {$content}
    
    
	</div>
</div>   
        
{include file='footer.tpl'}            