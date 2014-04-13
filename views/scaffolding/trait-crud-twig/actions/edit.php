		$this->_action_edit($id);
		
		$data = array('item'=> $this->stash['model']);
		return Response::forge( View_Twig::forge('<?php echo $view_path ?>/edit.twig',$data) );