<form name="LoggingIs" onsubmit="return false">
	{html_table table_attr='id="contable"' loop=$data cols="ID,Таблица,Запись,Время,Действие,Описание,Пользователь" caption="Журнал"}
	<p style="margin: 20px;">Страницы: {$pages}</p>
</form>