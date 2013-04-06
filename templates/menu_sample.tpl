{strip}
	<a class="dropdown-toggle" data-toggle="dropdown" href="#"> {tr}{$packageMenuTitle}{/tr} <b class="caret"></b></a>
<ul class="{$packageMenuClass}">
		{if $gBitUser->hasPermission( 'p_sample_view')}
			<li><a class="item" href="{$smarty.const.SAMPLE_PKG_URL}index.php">{tr}Sample Home{/tr}</a></li>
			<li><a class="item" href="{$smarty.const.SAMPLE_PKG_URL}list_sample.php">{tr}List Sample Data{/tr}</a></li>
		{/if}
		{if $gBitUser->hasPermission( 'p_sample_create' )}
			<li><a class="item" href="{$smarty.const.SAMPLE_PKG_URL}edit.php">{tr}Create Sample{/tr}</a></li>
		{/if}
	</ul>
{/strip}
