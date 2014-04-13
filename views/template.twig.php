<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>{% block header_title %}Estate{% endblock %}</title>
	{{ asset_css('bootstrap.css') }}
	<style>
		body { margin: 40px; }
	</style>
</head>
<body>
	<div class="container">
			<h1></h1>
			<hr>
		<div class="col-md-12">
		</div>
		<div class="col-md-12">
{% block content %}
{% endblock %}
		</div>
		
		<hr>
		<footer>
			<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
			<p>
				<a href="http://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
				<small>Version: {{fuel_version()}}</small>
			</p>
		</footer>
	</div>
</body>
</html>
