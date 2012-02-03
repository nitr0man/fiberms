<form name="NetworkNode" id="NetworkNode" action="NetworkNodes.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>
		<tr>
			<td><label></label>Идентификатор:</td><td><input name="id" type="text" value="{$id}"/></td>
		</tr>
		<tr>
			<td><label>Имя</label></td><td><input name="name" type="text" value="{$name}"/></td>
		</tr>
		<tr>
			<td><label>Ящик:</label></td><td> <select name="boxes">
			{html_options values=$combobox_box_values selected=$combobox_box_selected output=$combobox_box_text}
			</select>
			</td>
		</tr>
		<tr>
			<td><label>Примечание:</label></td><td><textarea name="note" form="NetworkNode">{$note}</textarea></td>
		</tr>
		<tr>
			<td><label>OpenGIS:</label></td><td><input name="OpenGIS" type="text" value="{$OpenGIS}" /></td>
		</tr>
		<tr>
			<td><label>GeoSpartical:</label></td><td><input name="SettlementGeoSpatial" type="text" value="{$SettlementGeoSpatial}" /></td>
		</tr>
		<tr>
			<td><label>Дом</label></td><td><input name="Building" type="text" value="{$Building}" /></td>
		</tr>
		<tr>
			<td><label>Квартира:</label></td><td><input name="Apartment" type="text" value="{$Apartment}" /></td>
		</tr>
		<tr>
			<td>
			<input value="Изменить" type="submit" name="ChangeButton" /><br />
			</td>
		</tr>	</table>
</form>
