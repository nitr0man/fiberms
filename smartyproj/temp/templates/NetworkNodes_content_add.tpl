<form id="NetworkNode" name="NetworkNode" action="NetworkNodes.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table>
		<!--tr>
			<td>
			<label class="events_anonce">Type:</label></td><td> <select name="networkboxtypes" onChange="javascript: GetTypeBoxInfo(document.boxtypevalue.networkboxtypes.value,1);">
			{html_options values=$combobox_boxtype_values selected=$combobox_boxtype_selected output=$combobox_boxtype_text}
			</select>
			</td>
			<br />
		</tr>
		<tr>
			<td>
			<label class="events_anonce">InvNum:</label></td><td> <input type="text" value="{$invNum}" name="invnum" />
			</td>
			<br />
		</tr-->
		<tr>
		<tr>
			<td><label>Имя</label></td><td><input name="name" type="text" value=""/></td>
		</tr>
		<tr>
			<td><label>Тип ящика:</label></td><td><input name="NetworkBox" type="text" value="" /></td>
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
			<br />
		</tr>
	</table>
</div>
</form>
