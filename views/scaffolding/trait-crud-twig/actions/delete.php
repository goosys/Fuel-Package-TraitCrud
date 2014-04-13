		$this->_action_delete($id);
		
		$data = array('item'=> $this->stash['model']);
		return Response::forge( View_Twig::forge('<?php echo $view_path ?>/index.twig',$data) );
