{include file="header.tpl"}

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
			<article>
			<h3>{$lang.this_feature_is_disabled_for_free_members}</h3>

<h2>{$lang.upgrade_your_free_membership}</h2>

<form action="/members/paymember/" method="post">
    <h2>{$lang.choose_membership}</h2>
      <ul id="contactform">
      <li>
        <label for="username">{$lang.membership}: &nbsp;&nbsp;&nbsp;
        <select name="membership" id="select">
        {foreach key=obj item=name from=$memberships}
        
{capture assign=comm}{$name}_signup_fee{/capture}    
	{if $sett.$comm ne 0}
    	{if $sett.$comm ne '0.00'}
          <option value="{$name}" {if $name eq "1_STAR"}selected="selected"{/if}>
        
		{$name|replace:"_":" "} ($<b>{$sett.$comm|string_format:"%.2f"}</b>)          
          </option>
          {/if}{/if}
          {/foreach}
        </select>
        </label> </li>
    </ul>
    

 <br />
    
   <small> {$lang.monetary}{$signupfee} {$lang.processing_fee}</small>
          
     
    <p>&nbsp;</p>
    <input type="submit" value=" Pay " id="sendbutton" name="sendbutton"/>
</form>

<br />   

		
		</article>
		</section>
		{include file="side.tpl"}
	</section>
</section>
{include file="footer.tpl"}
