<form name="cabletype" onsubmit="return false">
	{if ($smarty.get.sort == 1)}
		{$sort = 0}
	{else}
		{$sort = 1}
	{/if}
	{html_table table_attr='id="contable"' loop=$data cols="<a href=\"CableLine.php?sort=$sort\">Имя</a>,Тип кабеля,Производитель,Длина,Изм.,Удал." caption="Список линий"}
	<p style="margin: 20px;">Страницы: {$pages}</p>
</form>
