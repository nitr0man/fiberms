<form name="fsot" onsubmit="return false">
<div>
	{html_table table_attr='id="contable"' loop=$data cols="ID,Тип кассеты,Производитель,Узел,К-во сварок,Изм.,Удал." caption="Список кассет"}
	<p style="margin: 20px;">Страницы: {$pages}</p>
</div>
</form>