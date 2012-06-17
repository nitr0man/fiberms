<form name="boxinfo" action="NetworkBox.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table id="contable">
		<tr>
			<td>
			<label class="events_anonce">Тип</label></td><td> <select name="networkboxtypes" onChange="javascript: GetTypeBoxInfo(document.boxtypevalue.networkboxtypes.value,1);">
			{html_options values=$combobox_boxtype_values selected=$combobox_boxtype_selected output=$combobox_boxtype_text}
			</select>
			</td>
		</tr>
		<tr>
			<td>
			<label class="events_anonce">Инв. номер</label></td><td> <input type="text" value="{$invNum}" name="invnum" />
			</td>
		</tr>
		<tr>
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
		</tr>
</div>
</form>
