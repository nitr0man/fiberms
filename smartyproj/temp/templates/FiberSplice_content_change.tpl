<form name="fibersplice" action="FSOT.php" method="post">
	<table>
		<tr>
		<td> <input type="hidden" value="{$id}" name="id"></td>
		<br />
		</tr>		
		<tr>
		<td><label class="events_anonce">Кабель1:</label></td><td> <input type="text" value="{$cable1}" name="cable"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Волокно1:</label></td><td> <input type="text" value="{$fiber1}" name="fiber"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Кабель2:</label></td><td> <select name="CableLinePoint" onChange="javascript: GetFiber(document.fibersplice.cable.value,document.fibersplice.fiber.value,document.fibersplice.CableLinePoint.value,3);"> {html_options values=$ComboBox_CableLinePoint_values selected=$combobox_boxtype_selected output=$ComboBox_CableLinePoint_text}</select></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Волокно2:</label></td><td> <select name="CableLinePoint"> {html_options values=$ComboBox_Fibers_values selected=$combobox_boxtype_selected output=$ComboBox_Fiber_text}</select></td>
		<br />
		</tr>
		<tr>
		<td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr>
	</table>
</form>