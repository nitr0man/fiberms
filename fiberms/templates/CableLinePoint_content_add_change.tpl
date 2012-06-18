<form name="cablelineinfo" action="CableLinePoint.php" method="post">
<div>
<input type="hidden" value="{$mod}" name="mode" />
<input type="hidden" value="{$cablelineid}" name="cablelineid" />
<input type="hidden" value="{$back}" name="back" />
	<table id="contable">
		<tr>
		<td> <input type="hidden" value="{$id}" name="id"></td>
		</tr>				
		<!--tr>
		<!--td><label class="events_anonce">Кабель</label></td><td> <select name="cablelines" {$disabled}>
			{html_options values=$combobox_cableline_values selected=$combobox_cableline_selected output=$combobox_cableline_text}
			</select></td-->
		</tr-->
		<tr>
		<td><label class="events_anonce">Узел</label></td><td> <select name="networknodes" {$disabled}>
			{html_options values=$combobox_networknode_values selected=$combobox_networknode_selected output=$combobox_networknode_text}
			</select></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Отметка (м)</label></td><td> <input type="text" value="{$meterSign}" name="meterSign"></td>
		<br />
		</tr>	
		
		<tr>
		<td><label class="events_anonce">OpenGIS</label></td><td> <input type="text" value="{$OpenGIS}" name="OpenGIS"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Квартира</label></td><td> <input type="text" value="{$Apartment}" name="Apartment"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Здание</label></td><td> <input type="text" value="{$Building}" name="Building"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">SettlementGeoSpatial</label></td><td> <input type="text" value="{$SettlementGeoSpatial}" name="SettlementGeoSpatial"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Примечание</label></td><td> <textarea name="note">{$note}</textarea></td>
		</tr>
		<tr>
		<th colspan="2"><input value="OK" type="submit" name="OkButton" /></th>
		</tr>
	</table>
</div>
</form>