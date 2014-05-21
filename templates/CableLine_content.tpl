<form name="cabletype" onsubmit="return false">
	{html_table table_attr='id="contable"' loop=$data cols="<a href=\"CableLine.php?sort=$sort\">Имя</a>,Тип кабеля,Производитель,Длина,Изм.,Удал." caption="Список линий"}
	<p style="margin: 20px;">Страницы: {$pages}</p>
</form>
