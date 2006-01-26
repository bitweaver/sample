{* $Header: /cvsroot/bitweaver/_bit_sample/templates/edit_sample.tpl,v 1.6 2006/01/26 12:44:13 squareing Exp $ *}
{strip}
<div class="floaticon">{bithelp}</div>

<div class="admin sample">
	{if $preview}
		<h2>Preview {$gContent->mInfo.title}</h2>
		<div class="preview">
			{include file="bitpackage:sample/sample_display.tpl" page=`$gContent->mInfo.sample_id`}
		</div>
	{/if}

	<div class="header">
		<h1>
			{if $gContent->mInfo.sample_id}
				{tr}{tr}Edit{/tr} {$gContent->mInfo.title}{/tr}
			{else}
				{tr}Create New Record{/tr}
			{/if}
		</h1>
	</div>

	<div class="body">
		{form enctype="multipart/form-data" id="editsampleform"}
			{legend legend="Edit/Create Sample Record"}
				<input type="hidden" name="sample_id" value="{$gContent->mInfo.sample_id}" />

				<div class="row">
					{formlabel label="Title" for="title"}
					{forminput}
						<input type="text" size="60" maxlength="200" name="title" id="title" value="{if $preview}{$gContent->mInfo.title}{else}{$gContent->mInfo.title}{/if}" />
					{/forminput}
				</div>

				{if $gBitSystemPrefs.feature_wiki_description eq 'y'}
					<div class="row">
						{formlabel label="Description" for="description"}
						{forminput}
							<input size="60" type="text" name="description" id="description" value="{$gContent->mInfo.description|escape}" />
							{formhelp note="Brief description of the page."}
						{/forminput}
					</div>
				{/if}

				{include file="bitpackage:liberty/edit_format.tpl"}

				{if $gBitSystemPrefs.package_smileys eq 'y'}
					{include file="bitpackage:smileys/smileys_full.tpl"}
				{/if}

				{if $gBitSystemPrefs.package_quicktags eq 'y'}
					{include file="bitpackage:quicktags/quicktags_full.tpl"}
				{/if}

				<div class="row">
					{forminput}
						<textarea id="{$textarea_id}" name="data" rows="{$rows|default:20}" cols="{$cols|default:50}">{$gContent->mInfo.data|escape}</textarea>
					{/forminput}
				</div>

				<div class="row submit">
					<input type="submit" name="preview" value="{tr}Preview{/tr}" /> 
					<input type="submit" name="save_sample" value="{tr}Save{/tr}" />
				</div>
			{/legend}
		{/form}
	</div><!-- end .body -->
</div><!-- end .sample -->

{/strip}
