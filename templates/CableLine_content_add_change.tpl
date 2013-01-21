<form name="cablelineinfo" action="CableLine.php" method="post">
<div>
<input type="hidden" value="{$mod}" name="mode" />
<input type="hidden" value="{$back}" name="back" />
	<table id="contable">
		<tr>
		<td> <input type="hidden" value="{$id}" name="id"></td>
		</tr>				
		<tr>
		<td><label class="events_anonce">Тип кабеля</label></td><td> <select name="cabletypes">
			{html_options values=$combobox_cabletype_values selected=$combobox_cabletype_selected output=$combobox_cabletype_text}
			</select></td>
		</tr>
		<td><label class="events_anonce">Длина</label></td><td> <input type="text" value="{$length}" name="length"></td>
		</tr>
		</tr>
		<td><label class="events_anonce">Имя</label></td><td> <input type="text" value="{$name}" name="name"></td>
		</tr>
		<tr>
		<tr>
		<td><label class="events_anonce">Примечание</label></td><td> <textarea name="comment">{$comment}</textarea></td>
		</tr>
		<tr>
			<th colspan="2">
				<input value="OK" type="submit" name="OkButton" />
			</th>
		</tr>
	</table>
</div>
</form>