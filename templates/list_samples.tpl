{* $Header: /cvsroot/bitweaver/_bit_sample/templates/Attic/list_samples.tpl,v 1.11 2008/10/20 21:40:11 spiderr Exp $ *}
{strip}
<div class="floaticon">{bithelp}</div>

<div class="listing sample">
	<div class="header">
		<h1>{tr}Sample Records{/tr}</h1>
	</div>

	<div class="body">
		{minifind sort_mode=$sort_mode}

		{form id="checkform"}
			<input type="hidden" name="offset" value="{$control.offset|escape}" />
			<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />

			<table class="data">
				<tr>
					{if $gBitSystem->isFeatureActive( 'sample_list_sample_id' ) eq 'y'}
						<th>{smartlink ititle="Sample Id" isort=sample_id offset=$control.offset iorder=desc idefault=1}</th>
					{/if}

					{if $gBitSystem->isFeatureActive( 'sample_list_title' ) eq 'y'}
						<th>{smartlink ititle="Title" isort=title offset=$control.offset}</th>
					{/if}

					{if $gBitSystem->isFeatureActive( 'sample_list_description' ) eq 'y'}
						<th>{smartlink ititle="Description" isort=description offset=$control.offset}</th>
					{/if}

					{if $gBitSystem->isFeatureActive( 'sample_list_data' ) eq 'y'}
						<th>{smartlink ititle="Text" isort=data offset=$control.offset}</th>
					{/if}

					{if $gBitUser->hasPermission( 'p_sample_update' )}
						<th>{tr}Actions{/tr}</th>
					{/if}
				</tr>

				{foreach item=sample from=$samplesList}
					<tr class="{cycle values="even,odd"}">
						{if $gBitSystem->isFeatureActive( 'sample_list_sample_id' )}
							<td><a href="{$smarty.const.SAMPLE_PKG_URL}index.php?sample_id={$sample.sample_id|escape:"url"}" title="{$sample.sample_id}">{$sample.sample_id}</a></td>
						{/if}

						{if $gBitSystem->isFeatureActive( 'sample_list_title' )}
							<td>{$sample.title|escape}</td>
						{/if}

						{if $gBitSystem->isFeatureActive( 'sample_list_description' )}
							<td>{$sample.description|escape}</td>
						{/if}

						{if $gBitSystem->isFeatureActive( 'sample_list_data' )}
							<td>{$sample.data|escape}</td>
						{/if}

						{if $gBitUser->hasPermission( 'p_sample_update' )}
							<td class="actionicon">
								{smartlink ititle="Edit" ifile="edit.php" ibiticon="icons/accessories-text-editor" sample_id=$sample.sample_id}
								<input type="checkbox" name="checked[]" title="{$sample.title|escape}" value="{$sample.sample_id}" />
							</td>
						{/if}
					</tr>
				{foreachelse}
					<tr class="norecords"><td colspan="16">
						{tr}No records found{/tr}
					</td></tr>
				{/foreach}
			</table>

			{if $gBitUser->hasPermission( 'p_sample_update' )}
				<div style="text-align:right;">
					<script type="text/javascript">/* <![CDATA[ check / uncheck all */
						document.write("<label for=\"switcher\">{tr}Select All{/tr}</label> ");
						document.write("<input name=\"switcher\" id=\"switcher\" type=\"checkbox\" onclick=\"switchCheckboxes(this.form.id,'checked[]','switcher')\" /><br />");
					/* ]]> */</script>

					<select name="submit_mult" onchange="this.form.submit();">
						<option value="" selected="selected">{tr}with checked{/tr}:</option>
						{if $gBitUser->hasPermission( 'p_sample_update' )}
							<option value="remove_samples">{tr}remove{/tr}</option>
						{/if}
					</select>

					<noscript><div><input type="submit" value="{tr}Submit{/tr}" /></div></noscript>
				</div>
			{/if}
		{/form}

		{pagination}
	</div><!-- end .body -->
</div><!-- end .admin -->
{/strip}
