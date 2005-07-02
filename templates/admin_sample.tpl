{strip}
{form}
	{jstabs}
		{jstab title="Home Sample"}
			{legend legend="Home Sample"}
				<input type="hidden" name="page" value="{$page}" />
				<div class="row">
					{formlabel label="Home Sample (main sample)" for="homeSample"}
					{forminput}
						<select name="homeSample" id="homeSample">
							{section name=ix loop=$samples}
								<option value="{$samples[ix].sample_id|escape}" {if $samples[ix].sample_id eq $home_sample}selected="selected"{/if}>{$samples[ix].title|truncate:20:"...":true}</option>
							{sectionelse}
								<option>{tr}No records found{/tr}</option>
							{/section}
						</select>
					{/forminput}
				</div>

				<div class="row submit">
					<input type="submit" name="homeTabSubmit" value="{tr}Change preferences{/tr}" />
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
							{html_checkboxes name="$item" values="y" checked=`$gBitSystemPrefs.$item` labels=false id=$item}
							{formhelp note=`$output.note` page=`$output.page`}
						{/forminput}
					</div>
				{/foreach}

				<div class="row submit">
					<input type="submit" name="listTabSubmit" value="{tr}Change preferences{/tr}" />
				</div>
			{/legend}
		{/jstab}
	{/jstabs}
{/form}
{/strip}
