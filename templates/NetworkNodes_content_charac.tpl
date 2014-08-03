<form name="NetworkNode" id="NetworkNode" action="NetworkNodes.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<center> <table id="contable">
		<tr>
			<td><label class="events_anonce">ID</label></td><td> <label class="events_anonce">{$id}</label> </td>
		</tr>
		<tr>
			<td><label class="events_anonce">Имя</label></td><td> <label class="events_anonce">{$name}</label> </td>
		</tr>
		<tr>
			<td><label class="events_anonce">Ящик</label></td><td> <label class="events_anonce">{$NetworkBox}</label> </td>
		</tr>
		<tr>
			<td><label class="events_anonce">К-во сварок</label></td><td> <label class="events_anonce">{$FiberSpliceCount}</label> </td>
		</tr>		
		<tr>
			<td><label class="events_anonce">Координаты</label></td><td> <label class="events_anonce">{$OpenGIS}</label> </td>
		</tr>
		<tr>
			<td><label class="events_anonce">Расположение</label></td><td> <label class="events_anonce">{$place}</label> </td>
		</tr>
		<tr>
			<td><label class="events_anonce">Примечание</label></td><td><label class="events_anonce">{$note}</label></td>
		</tr>
	</table>
	{html_table table_attr='id="contable"' loop=$CableLinePoints cols="ID,Кабельная линия,Отметка (м),Изм.,Удал." caption="Список точек на линии"}
	{html_table table_attr='id="contable"' loop=$FSO cols="ID,Тип кассеты,Производитель,К-во сварок,Изм.,Удал." caption="Список кассет"}
	</center>
	<td>
		{$ChangeDeleteFiberSplice}
	</td>
</form>
