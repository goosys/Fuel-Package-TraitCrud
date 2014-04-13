{% extends "template.twig.php" %}

{% block header_title %}
{% endblock %}{# /header_title #}

{% block content %}
<h2>{{lang('trait-crud.message.Listing_MODEL',{'model':'<?php echo \Str::ucfirst($plural_name); ?>'})}}</h2>
<br>
{% if items %}

<table class="table table-striped">
	<thead>
		<tr>
			<th style="width:3em;"><br></th>
<?php foreach ($fields as $field): ?>
			<th><?php echo "{{ lang('model.{$singular_name}.{$field['name']}') }}"; ?></th>
<?php endforeach; ?>
			<th style="width:10em;"><br></th>
		</tr>
	</thead>
	<tbody>
{% for item in items %}
		<tr>
			<th>{{item.id}}</th>

<?php foreach ($fields as $field): ?>
			<td>{{item<?php echo '.'.$field['name']; ?>}}</td>
<?php endforeach; ?>
			<td>
				
			</td>
		</tr>
{% endfor %}
	</tbody>
</table>

{% if pagination %}{{ pagination }}{% endif %}

{% else %}

<p>{{ lang('trait-crud.message.No_MODEL',{'model':'<?php echo \Str::ucfirst($plural_name); ?>'}) }}</p>

{% endif %}
<p>
	{{ html_anchor('<?php echo $uri; ?>/create', lang('trait-crud.button.Add_new_MODEL',{'model':'<?php echo \Inflector::humanize($singular_name); ?>'}), {'class':'btn btn-success'}) }}
</p>

{% endblock %}{# /content #}
