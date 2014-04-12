		$this->_action_index();
		
		$data = array('items'=> $this->stash['models']);
		$this->template->content = View::forge('<?php echo $view_path ?>/index',$data);