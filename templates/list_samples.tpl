{* $Header: /cvsroot/bitweaver/_bit_sample/templates/Attic/list_samples.tpl,v 1.1 2005/07/02 14:56:31 bitweaver Exp $ *}
<div class="floaticon">
	{if $gBitUser->hasPermission( 'bit_p_admin_sample' )}
		<a title="{tr}configure listing{/tr}" href="{$gBitLoc.KERNEL_PKG_URL}admin/index.php?page=sample">{biticon ipackage=liberty iname="config" iexplain="configure"}</a>
	{/if}
	{bithelp}
</div>

<div class="admin wiki">
<div class="header">
<h1><a href="{$gBitLoc.SAMPLE_PKG_URL}list_samples.php">{tr}Sample Records{/tr}</a></h1>
</div>

<div class="body">

<form name="checkform" method="post" action="{$smarty.server.PHP_SELF}">
<input type="hidden" name="offset" value="{$control.offset|escape}" />
<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />
<table class="data">
<tr>
{*  at the moment, the only working option to use the checkboxes for is deleting pages. so for now the checkboxes are visible iff $bit_p_remove is set. Other applications make sense as well (categorize, convert to pdf, etc). Add necessary corresponding permission here: *}

{if $gBitUser->hasPermission( 'bit_p_remove_sample' )}              {* ... "or $gBitUser->hasPermission( 'bit_p_other_sufficient_condition_for_checkboxes' )"  *}
  {assign var='checkboxes_on' value='y'}
{else}
  {assign var='checkboxes_on' value='n'}
{/if}
{if $checkboxes_on eq 'y'}
	<th>&nbsp;</th>{/if}
{if $sample_list_sample_id eq 'y'}
	<th><a href="{$gBitLoc.SAMPLE_PKG_URL}list_samples.php?offset={$control.offset}&amp;sort_mode={if $control.sort_mode eq 'sample_id_desc'}sample_id_asc{else}sample_id_desc{/if}">{tr}Sample Id{/tr}</a></th>
{/if}{if $sample_list_title eq 'y'}
	<th style="text-align:center;"><a href="{$gBitLoc.SAMPLE_PKG_URL}list_samples.php?offset={$control.offset}&amp;sort_mode={if $control.sort_mode eq 'name_desc'}title_asc{else}title_desc{/if}">{tr}Title{/tr}</a></th>
{/if}{if $sample_list_description eq 'y'}
	<th style="text-align:center;"><a href="{$gBitLoc.SAMPLE_PKG_URL}list_samples.php?offset={$control.offset}&amp;sort_mode={if $control.sort_mode eq 'description_desc'}description_asc{else}description_desc{/if}">{tr}Description{/tr}</a></th>
{/if}
</tr>

{cycle values="even,odd" print=false}
{section name=changes loop=$list}
<tr class="{cycle}">
{if $checkboxes_on eq 'y'}
	<td><input type="checkbox" name="checked[]" value="{$list[changes].sample_id|escape}" /></td>
{/if}
{if $sample_list_sample_id eq 'y'}
	<td><a href="{$gBitLoc.SAMPLE_PKG_URL}index.php?sample_id={$list[changes].sample_id|escape:"url"}" title="{$list[changes].sample_id}">{$list[changes].sample_id|truncate:20:"...":true}</a>
		{if $gBitUser->hasPermission( 'bit_p_edit_sample' )}
			(<a href="{$gBitLoc.SAMPLE_PKG_URL}edit.php?sample_id={$list[changes].sample_id|escape:"url"}">{tr}edit{/tr}</a>)
		{/if}
	</td>
{/if}
{if $sample_list_title eq 'y'}
	<td style="text-align:center;">{$list[changes].title}</td>
{/if}
{if $sample_list_description eq 'y'}
	<td style="text-align:center;">{$list[changes].data}</td>
{/if}
</tr>
{sectionelse}
	<tr class="norecords"><td colspan="16">
		{tr}No records found{/tr}
	</td></tr>
{/section}

{if $checkboxes_on eq 'y'}
<tr><td colspan="16">
  <script language="Javascript" type="text/javascript">
  <!--
  // check / uncheck all.
  // in the future, we could extend this to happen serverside as well for the convenience of people w/o javascript.
  document.write("<tr><td><input name=\"switcher\" type=\"checkbox\" onclick=\"switchCheckboxes(this.form.name,'checked[]','switcher')\" /></td>");
  document.write("<td colspan=\"15\">{tr}All{/tr}</td></tr>");
  //-->
  </script>
</td></tr>
{/if}
</table>

{if $checkboxes_on eq 'y'} {* what happens to the checked items *}
  <select name="submit_mult" onchange="this.form.submit();">
    <option value="" selected="selected">{tr}with checked{/tr}:</option>
    {if $gBitUser->hasPermission( 'bit_p_remove_sample' )}
      <option value="remove_samples">{tr}remove{/tr}</option>
    {/if}
    {* add here e.g. <option value="categorize">{tr}categorize{/tr}</option> *}
  </select>
  <script language="Javascript" type="text/javascript">
  <!--
  // Fake js to allow the use of the <noscript> tag (so non-js-users kenn still submit)
  //-->
  </script>
  <noscript>
    <input type="submit" value="{tr}ok{/tr}" />
  </noscript>
{/if}
</form>

</div> {* end .body *}

{pagination_c}
{minifind sort_mode=$sort_mode}

</div> {* end .admin *}
