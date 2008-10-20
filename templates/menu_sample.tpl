{strip}
	<ul>
		{if $gBitUser->hasPermission( 'p_sample_view')}
			<li><a class="item" href="{$smarty.const.SAMPLE_PKG_URL}index.php">{tr}Samples Home{/tr}</a></li>
			<li><a class="item" href="{$smarty.const.SAMPLE_PKG_URL}list_samples.php">{tr}List Samples{/tr}</a></li>
		{/if}
		{if $gBitUser->hasPermission( 'p_sample_create' )}
			<li><a class="item" href="{$smarty.const.SAMPLE_PKG_URL}edit.php">{tr}Create Sample{/tr}</a></li>
		{/if}
	</ul>
{/strip}
