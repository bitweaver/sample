{* $Header$ *}
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

					<th>{tr}Actions{/tr}</th>
				</tr>

				{foreach item=sample from=$sampleList}
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

						<td class="actionicon">
						{if $gBitUser->hasPermission( 'p_sample_update' )}
							{smartlink ititle="Edit" ifile="edit.php" booticon="icon-edit" sample_id=$sample.sample_id}
						{/if}
						{if $gBitUser->hasPermission( 'p_sample_expunge' )}
							<input type="checkbox" name="checked[]" title="{$sample.title|escape}" value="{$sample.sample_id}" />
						{/if}
						</td>
					</tr>
				{foreachelse}
					<tr class="norecords"><td colspan="16">
						{tr}No records found{/tr}
					</td></tr>
				{/foreach}
			</table>

			{if $gBitUser->hasPermission( 'p_sample_expunge' )}
				<div style="text-align:right;">
					<script type="text/javascript">/* <![CDATA[ check / uncheck all */
						document.write("<label for=\"switcher\">{tr}Select All{/tr}</label> ");
						document.write("<input name=\"switcher\" id=\"switcher\" type=\"checkbox\" onclick=\"BitBase.BitBase.switchCheckboxes(this.form.id,'checked[]','switcher')\" /><br />");
					/* ]]> */</script>

					<select name="submit_mult" onchange="this.form.submit();">
						<option value="" selected="selected">{tr}with checked{/tr}:</option>
						<option value="remove_sample_data">{tr}remove{/tr}</option>
					</select>

					<noscript><div><input type="submit" class="btn" value="{tr}Submit{/tr}" /></div></noscript>
				</div>
			{/if}
		{/form}

		{pagination}
	</div><!-- end .body -->
</div><!-- end .admin -->
{/strip}
