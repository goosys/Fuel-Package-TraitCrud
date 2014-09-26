		$options = $this->get_options();
		$this->_action_view($id,$options);
		
		$data = array('item'=> $this->stash['model'], 'url_base'=>static::$url_base );
		$this->template->content = View::forge( static::$url_base. '/view',$data);
