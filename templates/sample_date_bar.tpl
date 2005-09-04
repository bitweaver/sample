<div class="floaticon">
  {if $lock}
    {biticon ipackage="wiki" iname="locked" iexplain="locked"}{$info.editor|userlink}
  {/if}
  {if $print_page ne 'y'}
    {if !$lock}
      {if $bit_p_edit eq 'y' or $page eq 'SandBox'}
		<a href="edit.php?sample_id={$gContent->mInfo.sample_id}" {if $beingEdited eq 'y'}{popup_init src="`$smarty.const.THEMES_PKG_URL`overlib.js"}{popup text="$semUser" width="-1"}{/if}>{biticon ipackage=liberty iname="edit" iexplain="edit"}</a>
      {/if}
    {/if}
    <a title="{tr}print{/tr}" href="print.php?sample_id={$gContent->mInfo.sample_id}">{biticon ipackage=liberty iname="print" iexplain="print"}</a>
    {if $user and $gBitSystemPrefs.package_notepad eq 'y' and $bit_p_notepad eq 'y'}
      <a title="{tr}Save{/tr}" href="index.php?page={$page|escape:"url"}&amp;savenotepad=1">{biticon ipackage="wiki" iname="save" iexplain="save"}</a>
    {/if}
      {if $bit_p_remove eq 'y'}
        <a title="{tr}remove this page{/tr}" href="remove_sample.php?sample_id={$gContent->mInfo.sample_id}">{biticon ipackage=liberty iname="delete" iexplain="delete"}</a>
      {/if}
  {/if} {* end print_page *}
</div> {*end .floaticon *}
<div class="date">
	{tr}Created by{/tr} {displayname user=$gContent->mInfo.creator_user user_id=$gContent->mInfo.creator_user_id real_name=$gContent->mInfo.creator_real_name}, {tr}Last modification by{/tr} {displayname user=$gContent->mInfo.modifier_user user_id=$gContent->mInfo.modifier_user_id real_name=$gContent->mInfo.modifier_real_name} on {$gContent->mInfo.last_modified|bit_long_datetime}
</div>
