{{ form_open({"class":"form-horizontal","role":"form"}) }}

{% set errors = session_get_flash('error') %}
{% set val    = session_get_flash('validation') %}

<?php foreach ($fields as $field): ?>

		<div class="form-group{% if (errors and val.error(<?php echo "'${field['name']}'";?>)) %} has-error{% endif %}">
			<?php echo "{{ form_label(lang('model.{$singular_name}.{$field['name']}'), '{$field['name']}', {'class':'control-label'}) }}\n"; ?>

<?php switch($field['type']):

				case 'text':
					echo "\t\t\t{{ form_textarea('{$field['name']}', input_post('{$field['name']}', item.{$field['name']}), ".
						"{'class' :'col-md-8 form-control', 'rows' :8, 'placeholder':'".\Inflector::humanize($field['name'])."'}) }}\n";
				break;

				default:
					echo "\t\t\t{{ form_input('{$field['name']}', input_post('{$field['name']}', item.{$field['name']}), ".
						"{'class' :'col-md-4 form-control', 'placeholder':'".\Inflector::humanize($field['name'])."'}) }}\n";

endswitch; ?>

		</div>
<?php endforeach; ?>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			{{ form_submit('submit', lang('trait-crud.button.Save'), {'class': 'btn btn-primary'}) }}
			
		</div>
		
<?php if ($csrf): ?>
	{{ form_hidden(config('security.csrf_token_key'), Security::fetch_token()) }}
<?php endif; ?>
{{ form_close()}}
