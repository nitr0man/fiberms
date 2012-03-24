<form name="cablelineinfo" action="CableLinePoint.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>
		<tr>
		<td> <input type="hidden" value="{$id}" name="id"></td>
		<br />
		</tr>		
		<tr>
		<td><label class="events_anonce">OpenGIS</label></td><td> <input type="text" value="{$OpenGIS}" name="OpenGIS"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">CableLine</label></td><td> <select name="cablelines">
			{html_options values=$combobox_cableline_values selected=$combobox_cableline_selected output=$combobox_cableline_text}
			</select></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">meterSign</label></td><td> <input type="text" value="{$meterSign}" name="meterSign"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">NetworkNode</label></td><td> <select name="networknodes">
			{html_options values=$combobox_networknode_values selected=$combobox_networknode_selected output=$combobox_networknode_text}
			</select></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">note</label></td><td> <textarea name="note">{$note}</textarea></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Apartment</label></td><td> <input type="text" value="{$Apartment}" name="Apartment"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Building</label></td><td> <input type="text" value="{$Building}" name="Building"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">SettlementGeoSpatial</label></td><td> <input type="text" value="{$SettlementGeoSpatial}" name="SettlementGeoSpatial"></td>
		<br />
		</tr>
		<tr>
		<td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr>
	</table>
</div>
</form>