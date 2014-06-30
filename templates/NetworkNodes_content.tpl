	<form name="NetworkNode" id="NetworkNode" onsubmit="return false">
		{html_table table_attr='id="contable"' loop=$data cols="ID,<a href=\"NetworkNodes.php{if $sort && $sort == 'name'}{else}?sort=name{/if}\">Имя</a>,Ящик (инв. номер), Ящик (тип),К-во сварок,Координаты,Изм.,Удал." caption="Список узлов"}
		<p style="margin: 20px;">Страницы: {$pages}</p>
	</form>
