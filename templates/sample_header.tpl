<div class="header">
{if $is_categorized eq 'y' and $gBitSystemPrefs.package_categories eq 'y' and $gBitSystemPrefs.feature_categorypath eq 'y'}
<div class="category">
  <div class="path">{$display_catpath}</div>
</div> {* end category *}
{/if}

	<h1>{$gContent->mInfo.title}</h1>
	<div class="description">{$gContent->mInfo.description}</div>

</div> {* end .header *}
