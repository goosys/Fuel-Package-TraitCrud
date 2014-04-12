		$this->_action_view($id);
		
		$data = array('item'=> $this->stash['model']);
		$this->template->content = View::forge('<?php echo $view_path ?>/view',$data);
