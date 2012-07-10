{$table_attr = 'border=1 cellpadding=5 cellspacing=0 style="margin: 20px; border=1px; text-align: center; "'}
{if (isset($smarty.get.print))}
	{$td_attr = 'style="border: solid black 1px;"'}
	{$td_attr = ''}
{/if}
<form name="fibersplice" onsubmit="return false">
<div>
	{html_table loop=$data cols=$cols td_attr=$td_attr tr_attr=$tr_attr table_attr=$table_attr caption="Таблица сварок для узла &quot;$nodeName&quot; $printLink"}
</div>
</form>