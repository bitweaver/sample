{strip}
{form}
	{jstabs}
		{jstab title="Sample Settings"}
			{legend legend="Sample Settings"}
				<input type="hidden" name="page" value="{$page}" />
				<div class="row">
					{formlabel label="Home Sample" for="homeSample"}
					{forminput}
						<select name="sample_home_id" id="homeSample">
							{section name=ix loop=$samples}
								<option value="{$samples[ix].sample_id|escape}" {if $samples[ix].sample_id eq $sample_home_id}selected="selected"{/if}>{$samples[ix].title|escape|truncate:20:"...":true}</option>
							{sectionelse}
								<option>{tr}No records found{/tr}</option>
							{/section}
						</select>
						{formhelp note="This is the sample that will be displayed when viewing the sample homepage"}
					{/forminput}
				</div>
			{/legend}
		{/jstab}

		{jstab title="List Settings"}
			{legend legend="List Settings"}
				<input type="hidden" name="page" value="{$page}" />
				{foreach from=$formSampleLists key=item item=output}
					<div class="row">
						{formlabel label=`$output.label` for=$item}
						{forminput}
							{html_checkboxes name="$item" values="y" checked=$gBitSystem->getConfig($item) labels=false id=$item}
							{formhelp note=`$output.note` page=`$output.page`}
						{/forminput}
					</div>
				{/foreach}
			{/legend}
		{/jstab}

		<div class="row submit">
			<input type="submit" name="sample_settings" value="{tr}Change preferences{/tr}" />
		</div>
	{/jstabs}
{/form}
{/strip}
