		$this->_action_edit($id);
		
		$data = array('item'=> $this->stash['model']);
		$this->template->content = View::forge('<?php echo $view_path ?>/edit',$data);