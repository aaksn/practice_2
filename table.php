<?php
/*
юда приходит get запрос, в нем id таблицы, нужно вернуть html типа такого 
{% block table %}
	<thead>		
		<tr>
			<th rowspan="2">Имя</th>
			{% for subjects in subjects_name %}
				<th colspan="{{ periodslength }}">{{ subjects }}</th>
			{% endfor %}
		</tr>
		<tr>
			{% for name in subjects_name %}
				{% for period in periods %}
					<th>{{ period }}</th>
				{% endfor %}				
			{% endfor %}
		</tr>
	</thead>
	<tbody>
		{% for student in student_list %}
			<tr>
				<td>{{student.name}}</td>
				{% for mark in student.marks %}
					<td>{{mark}}</td>
				{% endfor %}				
			</tr>
		{% endfor %}
	</tbody>
{% endblock %}
*/
?>