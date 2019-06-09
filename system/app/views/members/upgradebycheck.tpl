{include file="header.tpl"}

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
			<article>
			<h2>Pay by Check</h2>
            
            
{foreach $errors as $error}

<div class="error msg">
<strong>{$error@key}</strong> {$error}
</div>
  
{/foreach}    
            
				<table border="0" cellspacing="0" cellpadding="0">
  <tr valign="top" align="left">
   <td width="27" height="8"><img src="/assets/images/autogen/clearpixel.gif" width="27" height="1" border="0" alt=""></td>
   <td width="49"><img src="/assets/images/autogen/clearpixel.gif" width="49" height="1" border="0" alt=""></td>
   <td width="403"><img src="/assets/images/autogen/clearpixel.gif" width="403" height="1" border="0" alt=""></td>
   <td width="78"><img src="/assets/images/autogen/clearpixel.gif" width="78" height="1" border="0" alt=""></td>
   <td width="129"><img src="/assets/images/autogen/clearpixel.gif" width="129" height="1" border="0" alt=""></td>
   <td width="27"><img src="/assets/images/autogen/clearpixel.gif" width="27" height="1" border="0" alt=""></td>
  </tr>
  <tr valign="top" align="left">
   <td></td>
   <td colspan="5" class="TextObject">
    <p style="text-align: left;"><b><span style="font-family: Verdana,Tahoma,Arial,Helvetica,Sans-serif;">Online Check</span></b></p>
    <p style="text-align: left;"><span style="font-family: Verdana,Tahoma,Arial,Helvetica,Sans-serif;">Fill out the form below.&nbsp; USA Bank accounts only.&nbsp; Your check will be drafted and verified by our check processing company.&nbsp; You are authorizing a onetime deduction to your checking account.&nbsp; We will manually verify your account and marl your membership within 24 hours of payment received.</span></p>
    <p style="text-align: left; margin-bottom: 0px;"><span style="font-family: Verdana,Tahoma,Arial,Helvetica,Sans-serif;">USA Banking accounts only.&nbsp; Make sure you have the amount in your account when you submit your checking information.&nbsp; All fields are required.</span></p>
   </td>
  </tr>
  <tr valign="top" align="left">
   <td colspan="6" height="26"></td>
  </tr>
  <tr valign="top" align="left">
   <td colspan="2" height="888"></td>
   <td colspan="3" width="610">
    <table border="0" cellspacing="0" cellpadding="0" style="background-image: url('{$site_url}assets/images/bak894.png'); height: 888px;">
     <tr align="left" valign="top">
      <td>
       <form name="numberoncheck" enctype="multipart/form-data" action="/members/upgradebycheck" method="post">
        <input type="hidden" name="_nof_param_file" value="FormInfo_numberoncheck_144028625_14685.XML">
        <table border="0" cellspacing="0" cellpadding="0">
         <tr valign="top" align="left">
          <td width="6" height="11"><img src="/assets/images/autogen/clearpixel.gif" width="6" height="1" border="0" alt=""></td>
          <td width="12"><img src="/assets/images/autogen/clearpixel.gif" width="12" height="1" border="0" alt=""></td>
          <td width="6"><img src="/assets/images/autogen/clearpixel.gif" width="6" height="1" border="0" alt=""></td>
          <td width="56"><img src="/assets/images/autogen/clearpixel.gif" width="56" height="1" border="0" alt=""></td>
          <td width="76"><img src="/assets/images/autogen/clearpixel.gif" width="76" height="1" border="0" alt=""></td>
          <td width="263"><img src="/assets/images/autogen/clearpixel.gif" width="263" height="1" border="0" alt=""></td>
          <td width="101"><img src="/assets/images/autogen/clearpixel.gif" width="101" height="1" border="0" alt=""></td>
          <td width="9"><img src="/assets/images/autogen/clearpixel.gif" width="9" height="1" border="0" alt=""></td>
          <td width="14"><img src="/assets/images/autogen/clearpixel.gif" width="14" height="1" border="0" alt=""></td>
          <td width="3"><img src="/assets/images/autogen/clearpixel.gif" width="3" height="1" border="0" alt=""></td>
          <td width="5"><img src="/assets/images/autogen/clearpixel.gif" width="5" height="1" border="0" alt=""></td>
          <td width="18"><img src="/assets/images/autogen/clearpixel.gif" width="18" height="1" border="0" alt=""></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="2"></td>
          <td colspan="8" width="528" class="TextObject">
           <p style="margin-bottom: 0px;"><b>Purchasing Upgrade : </b>{$membership} Membership<br>
           <b>Amount:</b> ${$signupfee} + ${$processing_fee} Processing = ${$total_amount} Total</p>
          </td>
          <td colspan="2"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="21"></td>
         </tr>
         <tr valign="top" align="left">
          <td></td>
          <td colspan="7" class="TextObject">
           <p style="margin-bottom: 0px;"><b><input type="text" id="FormsEditField1" name="firstname" value="{$firstname}" size="40" maxlength="60" style="width: 316px; white-space: pre;">&nbsp;Name On Check</b></p>
          </td>
          <td colspan="4"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="10"></td>
         </tr>
         <tr valign="top" align="left">
          <td></td>
          <td colspan="7" class="TextObject">
           <p style="margin-bottom: 0px;"><b><input type="text" id="FormsEditField2" name="addressoncheck" value="{$addressoncheck}" size="40" maxlength="60" style="width: 316px; white-space: pre;">&nbsp;Address On Check</b></p>
          </td>
          <td colspan="4"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="11"></td>
         </tr>
         <tr valign="top" align="left">
          <td></td>
          <td colspan="5" width="413" class="TextObject">
           <p style="margin-bottom: 0px;"><b><input type="text" id="FormsEditField3" name="cityoncheck" value="{$cityoncheck}" size="30" maxlength="30" style="width: 236px; white-space: pre;">&nbsp;City On Check</b></p>
          </td>
          <td colspan="6"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="11"></td>
         </tr>
         <tr valign="top" align="left">
          <td></td>
          <td colspan="5" width="413" class="TextObject">
           <p style="margin-bottom: 0px;"><b><input type="text" id="FormsEditField4" name="stateoncheck" value="{$stateoncheck}" size="10" maxlength="30" style="width: 76px; white-space: pre;">&nbsp;State On Check</b></p>
          </td>
          <td colspan="6"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="11"></td>
         </tr>
         <tr valign="top" align="left">
          <td></td>
          <td colspan="5" width="413" class="TextObject">
           <p style="margin-bottom: 0px;"><b><input type="text" id="FormsEditField5" name="ziponcheck" value="{$ziponcheck}" size="9" maxlength="30" style="width: 68px; white-space: pre;">&nbsp;Zip Code On Check</b></p>
          </td>
          <td colspan="6"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="11"></td>
         </tr>
         <tr valign="top" align="left">
          <td></td>
          <td colspan="5" width="413" class="TextObject">
           <p style="margin-bottom: 0px;"><b><input type="text" id="FormsEditField6" name="phoneoncheck" value="{$phoneoncheck}" size="15" maxlength="30" style="width: 116px; white-space: pre;">&nbsp;Phone Number On Check</b></p>
          </td>
          <td colspan="6"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="30"></td>
         </tr>
         <tr valign="top" align="left">
          <td></td>
          <td colspan="10" width="545" class="TextObject">
           <p style="margin-bottom: 0px;"><b><input type="text" id="FormsEditField7" name="banknameoncheck" value="{$banknameoncheck}" size="40" maxlength="60" style="width: 316px; white-space: pre;">&nbsp;Bank Name On Check</b></p>
          </td>
          <td></td>
         </tr>
         <tr valign="top" align="left">

          <td colspan="12" height="10"></td>
         </tr>
         <tr valign="top" align="left">
          <td></td>
          <td colspan="10" width="545" class="TextObject">
           <p style="margin-bottom: 0px;"><b><input type="text" id="FormsEditField12" name="bankphoneoncheck" value="{$bankphoneoncheck}" size="15" maxlength="60" style="width: 116px; white-space: pre;">&nbsp;Bank Phone Number On Check</b></p>
          </td>
          <td></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="10"></td>
         </tr>
         <tr valign="top" align="left">
          <td></td>
          <td colspan="10" width="545" class="TextObject">
           <p style="margin-bottom: 0px;"><b><input type="text" id="FormsEditField8" name="routingoncheck" value="{$routingoncheck}" size="9" maxlength="9" style="width: 68px; white-space: pre;">&nbsp;Bank Routing Number On Check</b></p>
          </td>
          <td></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="11"></td>
         </tr>
         <tr valign="top" align="left">
          <td></td>
          <td colspan="10" width="545" class="TextObject">
           <p style="margin-bottom: 0px;"><b><input type="text" id="FormsEditField9" name="accountoncheck" value="{$accountoncheck}" size="15" maxlength="60" style="width: 116px; white-space: pre;">&nbsp;Bank Account Number On Check</b></p>
          </td>
          <td></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="11"></td>
         </tr>
         <tr valign="top" align="left">
          <td></td>
          <td colspan="10" width="545" class="TextObject">
           <p style="margin-bottom: 0px;"><b><input type="text" id="FormsEditField10" name="nextchecknumber" value="{$nextchecknumber}" size="15" maxlength="60" style="width: 116px; white-space: pre;">&nbsp;Next Check Number</b></p>
          </td>
          <td></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="21"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="4" height="250"></td>
          <td colspan="3" width="440"><img id="Picture21" height="250" width="440" src="/assets/images/check1.png" border="0" alt="check1" title="check1"></td>
          <td colspan="5"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="14"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="3"></td>
          <td colspan="6" width="519" class="TextObject">
           <p style="margin-bottom: 0px;">I agree I am the owner of the checking account listed.&nbsp; I authorize a onetime deduction for the amount listed.&nbsp; I agree to pay $25 if the the check is returned for any reason above the listed deduction and authorize you to resubmit check if it was returned for any reason including NSF.</p>
          </td>
          <td colspan="3"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="8"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="3"></td>
          <td colspan="9" width="545" class="TextObject">
           <p style="margin-bottom: 0px;"><b><input type="text" id="FormsEditField11" name="agree" value="{$agree}" size="15" maxlength="60" style="width: 116px; white-space: pre;">&nbsp;Agree To Authorize Check...Type &#8220;AGREE&#8221;</b></p>
          </td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="12" height="40"></td>
         </tr>
         <tr valign="top" align="left">
          <td colspan="3" height="24"></td>
          <td colspan="2" width="132">
          <input type="hidden" name="member_id" value="{$member_id}">
          <input type="hidden" name="membership" value="{$membership}">
          <input type="hidden" name="total_amount" value="{$total_amount}">
          
         <input type="hidden" name="signupfee" value="{$signupfee}">
         <input type="hidden" name="processing_fee" value="{$processing_fee}"> 
            <input type="submit" id="FormsButton1" name="submit" class="nof_form_input_submit" value="Submit Check" style="height: 24px; width: 132px;"></td>
          <td colspan="7"></td>
         </tr>
        </table>
        
       </form>
      </td>
     </tr>
    </table>
   </td>
   <td></td>
  </tr>
  <tr valign="top" align="left">
   <td colspan="6" height="261"></td>
  </tr>
  <tr valign="top" align="left">
   <td colspan="3"></td>
   <td width="78" class="TextObject">
    <p style="margin-bottom: 0px;">&nbsp;</p>
   </td>
   <td colspan="2"></td>
  </tr>
 </table>
		</article>
		</section>
		{include file="side.tpl"}
	</section>
</section>
{include file="footer.tpl"}
