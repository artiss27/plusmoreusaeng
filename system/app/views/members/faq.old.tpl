{include file="header.tpl"}

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
			<article>
			
            <h2>{$lang.faq}</h2>
            <form>
           <table id="table1" class="gtable sortable">
							<tbody>
<tr><td>	
<ul>						
{foreach key=obj item=name from=$faq}

<li><strong>
{$name.question}</strong><br />

{$name.answer|replace:"\n":"<br>"}
</li>
<hr />
{/foreach}   
</ul>                         
						</td></tr>	</tbody>
							</table></form>
				
		</article>
		</section>
		{include file="side.tpl"}
	</section>
</section>
{include file="footer.tpl"}
