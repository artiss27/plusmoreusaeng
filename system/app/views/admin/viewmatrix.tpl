{include file='header.tpl'}
{include file='menu.tpl'}
<div id="wrapper">
<div class="content animate-panel">
	<div class="row">
		<div class="normalheader transition animated fadeIn">
			<div class="hpanel">
				<div class="panel-body">
					<a class="small-header-action" href="">
						<div class="clip-header">
							<i class="fa fa-arrow-up"></i>
						</div>
					</a>
					<div id="hbreadcrumb" class="pull-right m-t-lg">
						<ol class="hbreadcrumb breadcrumb">
						</ol>
					</div>
					<h2 class="font-light m-b-xs">
						View Member Matrix
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">
							{foreach $errors as $error}
							<div class="alert alert-danger">
								
								<p><strong>{$error@key}</strong> {$error}</p>
							</div>
							{/foreach}    
							<div class="content-box">
								<div class="box-body">
									<div class="box-wrap clear">
									{$links}<br /><br />
    
									{$content}
		
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
	</div>
</div>
{include file='footer_scripts.tpl'}
{include file='footer.tpl'}