<form name="NetworkNode" id="NetworkNode" action="NetworkNodes.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>
		<tr>
		<select name="nodeid">
		{html_options values=$combobox_netnode_values selected=$combobox_netnode_selected output=$combobox_netnode_name}
		</select>

			<!--td><label></label>Идентификатор:</td><td>{$id}</td-->
		</tr>
		<!--tr>
			<td><label class="events_anonce"><input type="radio" name="group1" id="rb1" checked="checked" onClick="javascript: GetNodeInfo(0,1); document.NetworkNode.addchangebutton.value = 'Изменить';"> Изменить</label><br />   
			<label class="events_anonce"><input type="radio" name="group1" id="rb2" onClick="javascript: document.NetworkNode.addchangebutton.value = 'Добавить';"> Добавить новый тип</label></td>
		</tr-->
		<tr>
			<td><label>Имя</label></td><td><input name="name" type="text" value="{$name}"/></td>
		</tr>
		<tr>
			<td><label>Тип ящика:</label></td><td><input name="NetworkBox" type="text" value="{$NetworkBox}" /></td>
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
			<input value="Изменить" type="submit" name="ChangeButton" /><br /><!--td><input type="submit" -->
			</tr>	</table>
</form>
