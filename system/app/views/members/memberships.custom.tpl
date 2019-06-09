{include file="header.tpl"}

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
			<article>
			

            <h2>{$lang.membership_features}: </h2>
            <a href="/members/upgradesystem">{$lang.go_to_upgrade_system}</a><br />
            <br />
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><strong>{$lang.membership}</strong></td>
    <td><strong>{$lang.pif_on_startup}</strong></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  {foreach key=obj item=name from=$memberships}
  
  {capture assign=commx}{$name}_pif_startup{/capture}
  <tr>
    <td>{$name|replace:"_":" "}</td>
    <td>{$sett.$commx}</td>
    <td></td>
  </tr>
{/foreach}
</table>
				
<br />
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><strong>{$lang.membership}</strong></td>
    <td><strong>{$lang.banner_credits_on_startup}</strong></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  {foreach key=obj item=name from=$memberships}

  {capture assign=commx}{$name}_banner_startup{/capture}
  <tr>
    <td>{$name|replace:"_":" "}</td>
    <td>{$lang.monetary}{$sett.$commx}</td>
    <td></td>
  </tr>
  {/foreach}
</table>
<br />
<br />
{foreach key=obj item=name from=$memberships}						  
<b>{$name|replace:"_":" "}</b> {$lang.comission_bonus_plan_if_this_member_type_refers_another_member}<br /><br />
                          <table width="90%" cellspacing="0" class="basic">
						
							
                             
                            <tr>
		{foreach key=objx item=namex from=$memberships}				
			<td align="center"><strong>{$namex|replace:"_":" "}</strong>
            </td>
            {/foreach}</tr><tr>
        {foreach key=objx item=namex from=$memberships}	    
            <td align="center">    
{capture assign=comm}{$name}_{$namex}_startup_bonus{/capture}             

             {$lang.monetary}{$sett.$comm}         
			</td>				
		{/foreach}					
							</tr>
                         
                            
                         
						
						  </table>
                            <br /><br /><hr>
                            
{/foreach}   
<br />                
		</article>
		</section>
		{include file="side.tpl"}
	</section>
</section>
{include file="footer.tpl"}
