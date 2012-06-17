<form name="boxtypevalue" onsubmit="return false">
<div>
	{if ($smarty.get.sort == 1)}
		{$sort = 0}
	{else}
		{$sort = 1}
	{/if}
	{html_table table_attr='id="contable"' loop=$data cols="ID,Тип ящика,<a href=\"NetworkBox.php?sort=$sort\">Инв. номер</a>,Изм.,Удал." caption="Список ящиков"}
	<p style="margin: 20px;">Страницы: {$pages}</p>
</div>
</form>
