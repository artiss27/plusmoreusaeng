{include file="header.tpl"}

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
			<article id="dashboard">
				<h1>{$lang.news}</h1>


<div class="clear"></div>                
                
				<h2>{$lang.latest_news}</h2>
				<ul class="comments">
                
{foreach key=obj item=name from=$news}                
					<li>
						<div class="comment-body clearfix">
						  <img class="comment-avatar" src="/assets/members/images/icons/dummy.gif" />
							<a href="#">{$lang.by_administrator}</a> - <a href="#">{$name.title}</a>:
							<div>{$name.body|replace:"\n":"<br>"}</div>
						</div>
						<div class="links">
						<span class="date">{$name.date}</span></div>
					</li>
			
{/foreach}					
					
					
				</ul>
			
			</article>
		</section>
		
		{include file="side.tpl"}
	</section>
</section>

{include file="footer.tpl"}
