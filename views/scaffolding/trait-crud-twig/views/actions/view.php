{% extends "template.twig.php" %}

{% block header_title %}
{% endblock %}{# /header_title #}

{% block content %}
<h2>{{lang('trait-crud.message.Viewing_MODEL_NUM',{'model':'<?php echo \Str::ucfirst($plural_name); ?>','id':item.id})}}</h2>
<br>

<?php foreach ($fields as $field): ?>
<p>
	<strong>{{ lang('model.<?php echo $singular_name; ?>.<?php echo $field['name']; ?>') }}:</strong>
	{{ item.<?php echo $field['name']; ?> }}
</p>
<?php endforeach; ?>

<p>
{{ html_anchor('<?php echo $uri ?>/edit/'~ item.id, lang('trait-crud.button.Edit')) }} |
{{ html_anchor('<?php echo $uri ?>', lang('trait-crud.button.Back')) }}
</p>

{% endblock %}{# /content #}