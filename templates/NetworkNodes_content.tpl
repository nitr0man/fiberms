	<form name="NetworkNode" id="NetworkNode" onsubmit="return false">
		{html_table table_attr='id="contable"' loop=$data cols="ID,<a href=\"NetworkNodes.php?sort=$sort&FSort=name\">Имя</a>,Ящик (инв. номер), Ящик (тип),К-во сварок,Координаты,SettlementGeoSpatial,Здание,Квартира,Изм.,Удал." caption="Список узлов"}
		<p style="margin: 20px;">Страницы: {$pages}</p>
	</form>
