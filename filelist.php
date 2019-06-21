<?php
/*
Сюда приходит get запрос, нужно вернуть html типа такого 

{% for file in files %}

	<li id="{{ file.id }}f">
		<input type="radio" id="{{ file.id }}" name="fileselector" />
		<label for="{{ file.id }}">{{ file.name }}</label>
		<a href="javascript:deletefile('#{{ file.id }}');" class="button primary small icon fa-trash">Удалить</a>
	</li>
{% endfor %}
*/
?>