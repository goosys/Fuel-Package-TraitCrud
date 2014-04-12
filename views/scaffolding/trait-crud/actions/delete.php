		$this->_action_delete($id);
		
		$data = array('item'=> $this->stash['model']);
		$this->template->content = View::forge('<?php echo $view_path ?>/index',$data);
