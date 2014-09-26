		$options = $this->get_options();
		$params = \Arr::get($options,'where',array());
		$this->_action_create($params);
		
		$data = array('item'=> $this->stash['model'], 'url_base'=>static::$url_base );
		$this->template->content = View::forge( static::$url_base. '/create',$data);
