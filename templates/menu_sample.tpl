{strip}
<ul>
{if $gBitUser->hasPermission( 'bit_p_read_sample')}
	<li><a class="item" href="{$gBitLoc.SAMPLE_PKG_URL}index.php">{tr}Samples Home{/tr}</a></li>
{/if}
{if $gBitUser->hasPermission( 'bit_p_read_sample')  || $gBitUser->hasPermission( 'bit_p_remove_sample' ) }
	<li><a class="item" href="{$gBitLoc.SAMPLE_PKG_URL}list_samples.php">{tr}List Samples{/tr}</a></li>
{/if}
{if $gBitUser->hasPermission( 'bit_p_create_sample' ) || $gBitUser->hasPermission( 'bit_p_edit_sample' ) }
	<li><a class="item" href="{$gBitLoc.SAMPLE_PKG_URL}edit.php">{tr}Create/Edit a Sample{/tr}</a></li>
{/if}
</ul>
{/strip}
