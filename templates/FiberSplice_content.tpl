{$table_attr = 'border=1 cellpadding=5 cellspacing=0 style="margin: 20px; border=1px; text-align: center; "'}
<form name="fibersplice" onsubmit="return false">
<div>
	<table id="contable" {$table_attr}>
		<caption>Таблица сварок для узла &quot;{$nodeName}&quot; {$printLink}</caption>
		{$table}
	</table>
</div>
</form>