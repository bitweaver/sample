{strip}
{form legend="Home Sample"}
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
		<input type="submit" name="sampleset" value="{tr}Change preference{/tr}" />
	</div>
{/form}
{/strip}
