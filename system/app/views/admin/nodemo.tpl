{include file='header.tpl'}

<div class="breadcrumb">
	<div class="bread-links pagesize">
		<ul class="clear">
		<li class="first">You are here:</li>
		<li><a href="#">Demo</a></li>
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
    <div id="table">
    
    <div class="box-wrap clear">
 <br />
 <br />
 <br />
 Feature available on next release. <br />
	<br />
	<br />
	<br />
	<br />
    </div>
    
    </div>
    
	</div>
</div>   
        
{include file='footer.tpl'}            