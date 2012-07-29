<form name="boxinfo" action="NetworkBox.php" method="post">
<div>
<input type="hidden" value="{$mod}" name="mode" />
<input type="hidden" value="{$back}" name="back" />
<input type="hidden" value="{$back}" name="back" />
<input type="hidden" value="{$id}" name="boxid">
	<table id="contable">
		<tr>
			<td>
			<label class="events_anonce">Тип</label></td><td> <select name="networkboxtypes">
			{html_options values=$combobox_boxtype_values selected=$combobox_boxtype_selected output=$combobox_boxtype_text}
			</select>
			</td>
		</tr>
		<tr>
			<td>
			<label class="events_anonce">Инв. номер</label></td><td> <input type="text" value="{$invNum}" name="invnum">
			</td>
		</tr>
		<tr>
			<th colspan="2">
				<input value="ОК" type="submit" name="OkButton" />
			</th>
		</tr>
</div>
</form>