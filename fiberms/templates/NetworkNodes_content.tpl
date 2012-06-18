	<form name="NetworkNode" id="NetworkNode" onsubmit="return false">
		{if ($smarty.get.sort == 1)}
			{$sort = 0}
		{else}
			{$sort = 1}
		{/if}
		{html_table table_attr='id="contable"' loop=$data cols="ID,<a href=\"NetworkNodes.php?sort=$sort&FSort=name\">Имя</a>,Ящик (инв. номер), Ящик (тип),К-во сварок,OpenGIS,SettlementGeoSpatial,Здание,Квартира,Изм.,Удал." caption="Список узлов"}
		<p style="margin: 20px;">Страницы: {$pages}</p>
	</form>
