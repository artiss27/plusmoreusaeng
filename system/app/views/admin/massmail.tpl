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
							{foreach $errors as $error}
							<div class="alert alert-danger">
								<p><strong>{$error@key}</strong> {$error}</p>
							</div>
							{/foreach} <br />
                    {if $emails_sent eq 'y'}
							<div class="alert alert-success">
								<p><strong>Emails Sent:</strong> All emails sent succesfully.</p>
							</div>
							{/if}  
							{if $select_membership eq 'y'}
							<div class="alert alert-success">
								<p><strong>Select Membership:</strong> Select at least one membership to send the emailing.</p>
							</div>
							{/if}
							{foreach $errors as $error}
							<div class="alert alert-danger">
								<p><strong>{$error@key}</strong> {$error}</p>
							</div>
							{/foreach} <br />
					<h2 class="font-light m-b-xs">
						Mass Mailing
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">							   
							<div class="content-box">
								<div class="box-body">
									<div class="box-wrap clear">
										<br>
										<form id="form1" name="form1" method="post" action="/admin/massmail" onsubmit="return postForm()">
											<table width="80%" border="0" cellspacing="1" cellpadding="1">
												<tr>
													<td>Select Group/s: <br>(ctrl+click to choose multiple)</td>
													<td>
														<select id="select-multi" MULTIPLE name="memberships[]" size="5" class="form-control">
															{foreach key=obj item=name from=$memberships}    
															<option value="{$name}">{$name|replace:"_":" "}</option>
															{/foreach}
														</select>
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>
												<tr>
												<tr>
													<td>Email Subject: </td>
													<td>
														<label for="textfield"></label>
														<input name="subject" type="text" id="textfield" size="50" value="{$subject}" class="form-control" />
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>
												<tr>
												<tr colspan="3">
													<td>Email Body: </td>
													<td>
														<textarea name="content" id="summernote" class="summernote" cols="75" rows="15"></textarea>
													</td>
													<td><table class="m-l">
												<tr>
													<td><strong>Replacements:</strong></td>
												</tr>
												<tr>
													<td><br>
														<p>[<a href="#" onclick="$('.summernote').code($('.summernote').code()+'[FirstName]');">FirstName</a>]<br /><br>
															[<a href="#" onclick="$('.summernote').code($('.summernote').code()+'[LastName]');">LastName</a>]<br /><br>
															[<a href="#" onclick="$('.summernote').code($('.summernote').code()+'[MemberID]');">MemberID</a>]<br /><br>
															[<a href="#" onclick="$('.summernote').code($('.summernote').code()+'[Username]');">Username</a>]<br /><br>
															[<a href="#" onclick="$('.summernote').code($('.summernote').code()+'[Password]');">Password</a>]<br /><br>
															[<a href="#" onclick="$('.summernote').code($('.summernote').code()+'[SiteTitle]');">SiteTitle</a>]
														</p>
													</td>
													<td>&nbsp;</td>
												</tr>
												</table></td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td><input type="submit" class="btn btn-primary" name="send" value="Send" />
													
													</td>
													<td>&nbsp;</td>
												</tr>
												
											</table>
										</form>
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
<script type="text/javascript">
    $(document).ready(function(){        
		 $('.summernote').summernote({
		   height: 300,
		   });
    });
	function postForm() {
        var content = $('textarea[name="content"]').html($('#summernote').code());
     }
</script>
{include file='footer.tpl'}