<form name="boxinfo" action="NetworkBox.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table id="contable">
		<tr>
			<td>
			<label class="events_anonce">ID:</label></td><td> <input type="text" value="{$id}" name="boxid" readonly>
			</td>
		</tr>
		<tr>
			<td>
			<label class="events_anonce">Type:</label></td><td> <select name="networkboxtypes">
			{html_options values=$combobox_boxtype_values selected=$combobox_boxtype_selected output=$combobox_boxtype_text}
			</select>
			</td>
		</tr>
		<tr>
			<td>
			<label class="events_anonce">InvNum:</label></td><td> <input type="text" value="{$invNum}" name="invnum">
			</td>
		</tr>
		<tr>
			<td>
			<input value="Изменить" type="submit" name="ChangeButton" /><td></td>
			<!--<input value="Удалить" type="submit" name="DeleteButton" /> -->
		</tr>
</div>
</form>