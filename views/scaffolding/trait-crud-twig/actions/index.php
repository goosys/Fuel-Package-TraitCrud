		$this->_action_index();
		
		$data = array('items'=> $this->stash['models']);
		return Response::forge( View_Twig::forge('<?php echo $view_path ?>/index.twig',$data) );