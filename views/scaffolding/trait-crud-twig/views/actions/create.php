{% extends "template.twig.php" %}

{% block header_title %}
{% endblock %}{# /header_title #}

{% block content %}
<h2>{{ lang('trait-crud.message.New_MODEL', {'model':'<?php echo \Str::ucfirst($singular_name); ?>'}) }}</h2>
<br>

{% include('animal/_form.php') %}


<p>{{ html_anchor('<?php echo $uri ?>', lang('trait-crud.button.Back')) }}</p>

{% endblock %}{# /content #}