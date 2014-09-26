		$options = $this->get_options();
		$this->_action_index($options);
		
		$data = array('items'=> $this->stash['models'], 'url_base'=>static::$url_base );
		$this->template->content = View::forge( static::$url_base. '/index',$data);