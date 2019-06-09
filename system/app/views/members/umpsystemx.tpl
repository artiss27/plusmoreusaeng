{include file="header.tpl"}

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
		  <article>
          
{if $transaction eq 'y'}
<div class="success msg">
				<strong>PIF Transaction Done:</strong> Your transaction was succesfully recorded on the System.
			</div>
				
{/if}

{if $transaction_error eq 'y'}
<div class="error msg">
				<strong>PIF Transaction Error:</strong> Your don't have enough comissions to buy selected PIF amount.
			</div>
				
{/if}

{if $transaction_error_external eq 'y'}
<div class="error msg">
				<strong>PIF Transaction Error:</strong> Your Transaction was cancelled.
			</div>
				
{/if}
         
			<h2>PIF System</h2>
			<p><br />
		    PIF Available : <strong>{$pif_available}</strong></p>
			<p>PIF Placed : <strong>{$pif_placed}</strong></p>
			<p><a href="/members/mypendings">View My Pending Members</a></p>
			<p><br />
			  <br />
		    Commisions on your Account right Now: <strong>${$total_cash}</strong></p>
			<p>- Buy PIF using My Commisions : (<strong>${$pif_price}</strong>) each.<br />
		
		    
			<form id="form1" name="form1" method="post" action="">
            
            How Many PIF : 
		      <label for="textfield"></label>
		      <input name="ump" type="text" id="textfield" size="4" maxlength="2" />
			  <input type="submit" name="buyump" id="button" value=" Buy " />
			</form> 
			</p>
			<br />
		    <br />
		    - Buy PIF using Payment Processor : (<strong>${$pif_price}</strong>) each.
		    <br />
		    <br />
<form id="form1" name="form1" method="post" action="/members/buyump/">
            
          How Many PIF : 
	      <label for="textfield"></label>
		      <input name="ump" type="text" id="textfield" size="4" maxlength="2" />
			  <input type="submit" name="buyumpx" id="button" value=" Buy " />
			</form> 
<br />
<br />
</p>
            * PIF: Pay it Forward
          </article>
		</section>
		{include file="side.tpl"}
	</section>
</section>
{include file="footer.tpl"}
