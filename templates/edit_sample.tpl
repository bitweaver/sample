{* $Header: /cvsroot/bitweaver/_bit_sample/templates/edit_sample.tpl,v 1.17 2009/01/19 17:03:08 dansut Exp $ *}
{strip}
<div class="floaticon">{bithelp}</div>

<div class="admin sample">
	{if $smarty.request.preview}
		<h2>Preview {$gContent->mInfo.title|escape}</h2>
		<div class="preview">
			{include file="bitpackage:sample/sample_display.tpl" page=`$gContent->mInfo.sample_id`}
		</div>
	{/if}

	<div class="header">
		<h1>
			{if $gContent->mInfo.sample_id}
				{tr}Edit {$gContent->mInfo.title|escape}{/tr}
			{else}
				{tr}Create New Record{/tr}
			{/if}
		</h1>
	</div>

	<div class="body">
		{form enctype="multipart/form-data" id="editsampleform"}
			{jstabs}
				{jstab title="Record"}
					{legend legend="Sample Record"}
						<input type="hidden" name="sample[sample_id]" value="{$gContent->mInfo.sample_id}" />

						<div class="row">
							{formlabel label="Title" for="title"}
							{forminput}
								<input type="text" size="50" name="sample[title]" id="title" value="{$gContent->mInfo.title|escape}" />
							{/forminput}
						</div>

						<div class="row">
							{formlabel label="Description" for="description"}
							{forminput}
								<input type="text" size="50" maxlength="160" name="sample[description]" id="description" value="{$gContent->mInfo.description|escape}" />
								{formhelp note="Brief description of the page."}
							{/forminput}
						</div>

						{textarea name="sample[edit]"}{/textarea}

						{* any simple service edit options *}
						{include file="bitpackage:liberty/edit_services_inc.tpl serviceFile=content_edit_mini_tpl}

						<div class="row submit">
							<input type="submit" name="preview" value="{tr}Preview{/tr}" /> 
							<input type="submit" name="save_sample" value="{tr}Save{/tr}" />
						</div>
					{/legend}
				{/jstab}

				{* any service edit template tabs *}
				{include file="bitpackage:liberty/edit_services_inc.tpl serviceFile=content_edit_tab_tpl}
			{/jstabs}
		{/form}
	</div><!-- end .body -->
</div><!-- end .sample -->

{/strip}
