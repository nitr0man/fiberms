<form name="cablelineinfo" action="CableLine.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table id="contable">
		<tr>
		<td><label class="events_anonce">OpenGIS</label></td><td> <input type="text" value="{$OpenGIS}" name="OpenGIS"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">CableType</label></td><td> <select name="cabletypes">
			{html_options values=$combobox_cabletype_values selected=$combobox_cabletype_selected output=$combobox_cabletype_text}
			</select></td>
		</tr>
		<td><label class="events_anonce">length</label></td><td> <input type="text" value="{$length}" name="length"></td>
		</tr>
		</tr>
		<td><label class="events_anonce">name</label></td><td> <input type="text" value="{$name}" name="name"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">comment</label></td><td> <textarea name="comment"></textarea></td>
		</tr>
		<tr>
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
		</tr>
</div>
</form>
