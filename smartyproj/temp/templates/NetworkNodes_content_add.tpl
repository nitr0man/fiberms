<form id="NetworkNode" name="NetworkNode" action="NetworkNodes.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table id="contable">
		<tr>
			<td><label>Имя</label></td><td><input name="name" type="text" value=""/></td>
		</tr>
		<tr>
			<td><label>Ящик:</label></td><td><select name="boxes">
			{html_options values=$combobox_box_values selected=$combobox_box_selected output=$combobox_box_text}
			</select>
			</td>
		</tr>
		<tr>
			<td><label>Примечание:</label></td><td><textarea name="note" form="NetworkNode"></textarea></td>
		</tr>
		<tr>
			<td><label>OpenGIS:</label></td><td><input name="OpenGIS" type="text" value="" /></td>
		</tr>
		<tr>
			<td><label>GeoSpartical:</label></td><td> <input name="SettlementGeoSpatial" type="text" value="" /></td>
		</tr>
		<tr>
			<td><label>Дом</label></td><td><input name="Building" type="text" value="" /></td>
		</tr>
		<tr>
			<td><label>Квартира:</label></td><td><input name="Apartment" type="text" value="" /></td>
		</tr>		
		<tr>
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
		</tr>
	</table>
</div>
</form>
