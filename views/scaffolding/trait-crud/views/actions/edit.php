<?php echo '<?php'; ?> echo render('include/crud_title',array('item'=>$item,'uri'=>'<?php echo $uri; ?>', 'model'=>'<?php echo $singular_name; ?>', 'show'=>'E' )); <?php echo '?>';?>


<?php echo '<?php'; ?> echo render('<?php echo $view_path; ?>/_form',$__data); ?>

<?php echo '<?php'; ?> echo render('include/crud_pager',array('item'=>$item,'uri'=>'<?php echo $uri; ?>','show'=>'LV' )); <?php echo '?>';?>
