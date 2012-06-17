<form name="fsot" onsubmit="return false">
<div>
	{html_table table_attr='id="contable"' loop=$data cols="ID,Тип кассеты,Изм.,Удал." caption="Список типов кассет"}
	<p style="margin: 20px;">Страницы: {$pages}</p>
</div>
</form>