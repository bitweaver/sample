<div class="display sample">
	<div class="floaticon">
		{if $print_page ne 'y'}
			{if $gBitUser->hasPermission( 'bit_p_remove_sample' )}
				<a title="{tr}Remove this sample{/tr}" href="{$smarty.const.SAMPLE_PKG_URL}remove_sample.php?sample_id={$gContent->mInfo.sample_id}">{biticon ipackage=liberty iname="delete" iexplain="delete"}</a>
			{/if}
		{/if}<!-- end print_page -->
	</div><!-- end .floaticon -->

	<div class="header">
		<h1>{$gContent->mInfo.title|default:"Sample"}</h1>
		<h2>{$gContent->mInfo.description}</h2>
		<div class="date">
			{tr}Created by{tr}: {displayname user=$gContent->mInfo.creator_user user_id=$gContent->mInfo.creator_user_id real_name=$gContent->mInfo.creator_real_name}, {tr}Last modification by{/tr}: {displayname user=$gContent->mInfo.modifier_user user_id=$gContent->mInfo.modifier_user_id real_name=$gContent->mInfo.modifier_real_name}, {$gContent->mInfo.last_modified|bit_long_datetime}
		</div>
	</div><!-- end .header -->

	<div class="body">
		<div class="content">
			{$gContent->mInfo.parsed_data}
		</div><!-- end .content -->
	</div><!-- end .body -->
</div><!-- end .sample -->
