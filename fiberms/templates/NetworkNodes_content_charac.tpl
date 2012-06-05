<form name="NetworkNode" id="NetworkNode" action="NetworkNodes.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<center> <table id="contable">
		<tr>
			<td><label>ID:</label></td><td> <label>{$id}</label> </td>
		</tr>
		<tr>
			<td><label>Имя:</label></td><td> <label>{$id}</label> </td>
		</tr>
		<tr>
			<td><label>Ящик:</label></td><td> <label>{$NetworkBox}</label> </td>
		</tr>
		<tr>
			<td><label>Примечание:</label></td><td><textarea name="note" form="NetworkNode">{$note}</textarea></td>
		</tr>
		<tr>
			<td><label>OpenGIS:</label></td><td> <label>{$OpenGIS}</label> </td>
		</tr>
		<tr>
			<td><label>SettlementGeoSpatial:</label></td><td> {$SettlementGeoSpatial} </td>
		</tr>
		<tr>
			<td><label>Дом:</label></td><td> <label>{$Building}</label> </td>
		</tr>
		<tr>
			<td><label>Квартира:</label></td><td> <label>{$Apartment}</label> </td>
		</tr>
	</table> </center>
	{html_table table_attr='id="contable"' loop=$data cols="ID,OpenGIS,CableLine,meterSign,NetworkNode,note,Apartment,Building,SettlementGeoSpatial,Change,Delete"}
	<td><a href="FiberSplice.php?networknodeid={$smarty.get.nodeid}">Отобразить сварки</a><br>
		<a href="NetworkNodes.php?mode=delete&nodeid={$smarty.get.nodeid}">Удалить</a></td>
</form>
