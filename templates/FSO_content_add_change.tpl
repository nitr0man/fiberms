<form name="fso" action="FSO.php" method="post">
<div>
<input type="hidden" value="{$mod}" name="mode" />
<input type="hidden" value="{$back}" name="back" />
	<table id="contable">
		<tr>
			<td> <input type="hidden" value="{$id}" name="id"></td>
		</tr>		
		<tr>
		<td><label class="events_anonce">Тип кассеты</label></td><td> <select name="FSOT">
			{html_options values=$FSOT_values selected=$FSOT_selected output=$FSOT_text}
			</select>
		</td>
		</tr>
		<tr>
			<th colspan="2">
				<input value="OK" type="submit" name="OkButton" />
			</th>
		</tr>
	</table>
</div>
</form>