<form name="cablelineinfo" action="CableLinePoint.php" method="post">
<div>
<input type="hidden" value="{$mod}" name="mode" />
<input type="hidden" value="{$cablelineid}" name="cablelineid" />
<input type="hidden" value="{$back}" name="back" />
<input type="hidden" value="{$id}" name="id">
	<table id="contable">
		<tr>
		<td><label class="events_anonce">Кабель</label></td><td><b>{$cableline}</b></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Узел</label></td><td> <select name="networknodes" {$disabled}>
			{html_options values=$combobox_networknode_values selected=$combobox_networknode_selected output=$combobox_networknode_text}
			</select></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Отметка (м)</label></td><td> <input type="text" value="{$meterSign}" name="meterSign"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Координаты</label></td><td> <input type="text" value="{$OpenGIS}" name="OpenGIS"></td>
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