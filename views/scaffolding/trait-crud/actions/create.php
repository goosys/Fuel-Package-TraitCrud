		$this->_action_create();
		
		$data = array('item'=> $this->stash['model']);
		$this->template->content = View::forge('<?php echo $view_path ?>/create',$data);
