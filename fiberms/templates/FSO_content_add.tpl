<form name="fso" action="FSO.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table id="contable">
		<tr>
		<td><label class="events_anonce">Тип кассеты</label></td><td> <select name="FSOT">
			{html_options values=$FSOT_values selected=$FSOT_selected output=$FSOT_text}
			</select>
		</td>
		</tr>
		<tr>
			<td>
				<input value="Добавить" type="submit" name="AddButton" />
			</td>
		</tr>
	</table>
</div>
</form>