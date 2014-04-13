		$this->_action_view($id);
		
		$data = array('item'=> $this->stash['model']);
		return Response::forge( View_Twig::forge('<?php echo $view_path ?>/view.twig',$data) );
