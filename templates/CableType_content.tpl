<form name="cabletype" onsubmit="return false">
			{html_table table_attr='id="contable"' loop=$data cols="ID,<a href=\"CableType.php?sort=$sort\">Маркировка</a>,Производитель,К-во туб,К-во волокон в тубе,Допустимая нагрузка,Диаметр,К-во кабелей,Изм.,Удал." caption="Список типов кабелей"}
			<p style="margin: 20px;">Страницы: {$pages}</p>
</form>
