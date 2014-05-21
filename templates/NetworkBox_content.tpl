<form name="boxtypevalue" onsubmit="return false">
<div>
	{html_table table_attr='id="contable"' loop=$data cols="<a href=\"NetworkBox.php?sort=$sort\">Инв. номер</a>,Тип ящика,Узел,Изм.,Удал." caption="Список ящиков"}
	<p style="margin: 20px;">Страницы: {$pages}</p>
</div>
</form>
