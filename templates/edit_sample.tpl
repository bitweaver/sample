{* $Header$ *}
{strip}
<div class="floaticon">{bithelp}</div>

<div class="admin sample">
	{if $smarty.request.preview}
		<h2>Preview {$gContent->mInfo.title|escape}</h2>
		<div class="preview">
			{include file="bitpackage:sample/sample_display.tpl" page=$gContent->mInfo.sample_id}
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
						{formfeedback warning=$errors.store}

						<div class="form-group">
							{formfeedback warning=$errors.title}
							{formlabel label="Title" for="title"}
							{forminput}
								<input type="text" size="50" name="title" id="title" value="{$gContent->mInfo.title|escape}" />
							{/forminput}
						</div>

						<div class="form-group">
							{formlabel label="Description" for="description"}
							{forminput}
								<input type="text" size="50" maxlength="160" name="sample[description]" id="description" value="{$gContent->mInfo.description|escape}" />
								{formhelp note="Brief description of the page."}
							{/forminput}
						</div>

						{textarea name="edit" edit=$gContent->mInfo.data}

						{* any simple service edit options *}
						{include file="bitpackage:liberty/edit_services_inc.tpl" serviceFile="content_edit_mini_tpl"}

						<div class="form-group submit">
							<input type="submit" class="btn btn-default" name="preview" value="{tr}Preview{/tr}" />
						</div>
					{/legend}
				{/jstab}

				{* any service edit template tabs *}
				{include file="bitpackage:liberty/edit_services_inc.tpl" serviceFile="content_edit_tab_tpl"}
			{/jstabs}
			<div class="form-group submit">
				<input type="submit" class="btn btn-default" name="save_sample" value="{tr}Save{/tr}" />
			</div>
		{/form}
	</div><!-- end .body -->
</div><!-- end .sample -->

{/strip}
