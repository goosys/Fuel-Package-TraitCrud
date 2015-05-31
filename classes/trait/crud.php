<?php

trait Trait_Crud {

	protected static $model_name;
	protected static $controller_name;
	protected static $func_validate    = 'validate';
	protected static $url_base;
	protected static $properties       = array();
	protected static $exclude_keys     = array();
	
	protected $stash = array();
	
	public function _action_index( $options = array() )
	{
		$model_name = static::$model_name;
		$this->stash['models'] = $model_name::find('all',$options);
	}

	public function _action_view($id = null, $options = array() )
	{
		$model_name = static::$model_name;
		
		if( is_null($id) ){ $this->_render_404(); }

		if ( ! $this->stash['model'] = $model_name::find($id, $options ))
		{
			$this->_could_not_found_id( array( 'id'=> $id ) );
			$this->_render_404();
		}
	}

	public function _action_create( $options = array() )
	{
		$model_name = static::$model_name;
		$this->stash['model'] = $model = $model_name::forge( $options );
		
		if (Input::method() == 'POST')
		{
			$func_validate = static::$func_validate;
			$val = $model_name::$func_validate('create');
			
			if ($val->run())
			{
				$this->_set_model_from_validation( array( 'model'=> $model, 'val'=> $val ) );

				if ($model && $model->save() )
				{
					//case: create successful
					$this->_added( array( 'model'=> $model ) );
					return $this->_render_create();
				}
				else
				{
					//case: unknown error
					$this->_could_not_save( array( 'model'=> $model ) );
				}
			}
			else
			{
				//case: POST/:controller/create && input value not valid
				$this->_set_model_from_validation( array( 'model'=> $model, 'val'=> $val ) );
				$this->_validation_error( array( 'val'=>$val ) );
			}
		}
		else{
			//case: GET/:controller/create
		}
	}
	

	public function _action_edit($id = null, $options = array() )
	{
		$model_name = static::$model_name;
		$this->stash['model'] = array();
		
		if( is_null($id) ){ return $this->_render_404(); }
		
		$this->stash['model'] = $model = $model_name::find($id, $options);
		if ( !$model )
		{
			$this->_could_not_found_id( array( 'id'=> $id ) );
			$this->_render_404();
		}

		$func_validate = static::$func_validate;
		$val = $model_name::$func_validate('edit');

		if ($val->run())
		{
			$this->_set_model_from_validation( array( 'model'=> $model, 'val'=> $val ) );

			if ($model->save())
			{
				//case: edit successful
				$this->_updated( array( 'model'=> $model ) );
				return $this->_render_edit();
			}
			else
			{
				//case: unknown error
				$this->_could_not_update( array( 'model'=> $model ) );
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				//case: POST/:controller/edit/:id && input value not valid
				$this->_set_model_from_validation( array( 'model'=> $model,'val'=>$val ) );
				$this->_validation_error( array( 'val'=>$val ) );
			}
			else
			{
				//case: GET/:controller/edit
			}
		}
		
	}

	public function _action_validate()
	{
		$model_name = static::$model_name;
		
		if (Input::method() == 'POST')
		{
			$func_validate = static::$func_validate;
			$val = $model_name::$func_validate('create');
			
			if ($val->run())
			{
				$this->_validated( array() );
			}
			else
			{
				$this->_validation_error( array( 'val'=>$val ) );
			}
		}
	}

	public function _action_delete($id = null, $options = array())
	{
		$model_name = static::$model_name;
		
		if( is_null($id) ){ return $this->_render_404(); }

		$this->stash['model'] = $model =  $model_name::find($id, $options);
		if ( $model && $model->delete() )
		{
			$this->_deleted( array( 'id'=> $id ) );
		}

		else
		{
			$this->_could_not_delete( array( 'id'=> $id ) );
			$this->_render_404();
		}
		
		return $this->_render_delete();
	}
	
	
	
	
	public function _render_404(){
		throw new HttpNotFoundException;
	}
	
	
	public function _render_index(){
	
	}
	
	public function _could_not_found_id( $params ){
		$this->_set_flash_message('error','Could_not_find_model',array('id' => $params['id']));
	
	}
	
	public function _render_view(){
	
	}
	
	public function _set_model_from_input( $params ){
		foreach ( static::model_properties() as $p ){
			$params['model']->$p = Input::param( $p, $params['model']->$p );
		}
	}
	
	public function _added( $params ){
		$this->_set_flash_message('success','Added_to_model',array('id' => $params['model']->id));
		Session::set_flash('id', $params['model']->id );
		Session::set_flash('model', $params['model'] );
	}
	
	public function _could_not_save( $params ){
		$this->_set_flash_message('error','Could_not_save',array('id' => $params['model']->id));
	}
	
	public function _validation_error( $params ){
		Session::set_flash('error' , $params['val']->error());
		Session::set_flash('validation', $params['val']);
	}
	
	public function _validated( $params ){
		$this->_set_flash_message('success','Validated');
	}
	
	public function _render_create(){
		return Response::redirect( $this->base_segments().'/view/'. $this->stash['model']['id'] );
	}
	
	public function _updated( $params ){
		$this->_set_flash_message('success','Updated_to_model',array('id' => $params['model']->id));
	}
	
	public function _could_not_update( $params ){
		$this->_set_flash_message('error','Could_not_update',array('id' =>$params['model']->id ));
	}
	
	public function _set_model_from_validation( $params ){
		foreach ( static::model_properties() as $p ){
			if( $params['val']->field($p) ){
				$params['model']->$p = $params['val']->validated($p);
			}
		}
	}
	
	/**
	 * related model
	 */
	public function _set_related_model_from_validation( $relation_name, $params )
	{
		$model_name = static::$model_name;
		
		if( !is_array($relation_name) ){
			$has_many = Arr::get( $model_name::relations(),$relation_name );
			$relation= $has_many->name;
			$singular= Inflector::singularize($relation);
			$model_to= $has_many->model_to;
			$key_to  = $has_many->key_to;
			$key_from= $has_many->key_from;
		}else{
			/* TODO closure case */
			return false;
		}
		
		$validated = $params['val']->validated( $singular )?:array();
		$related   = $params['model']->$relation?:array();
		$update = array_intersect_key($related,$validated);
		$new    = array_diff_key ($validated,$related);
		$delete = array_diff_key ($related,$validated);
		
		/* update */
		foreach( $update as $id => $r ){
			foreach( $validated[$id] as $key => $val ){
				$r->set($key,$val);
			}
		}
		/* delete */
		foreach( $delete as $id => $r ){
			unset($params['model']->$relation[$id]);
		}
		/* new */
		foreach( $new as $id => $r ){
			$r = $model_to::forge();
			foreach( $validated[$id] as $key => $val ){
				$r->set($key,$val);
			}
			foreach( $key_to as $idx => $key ){
				$kf = $key_from[$idx];
				$r->set($key,$params['model']->$kf);
			}
			Arr::set( $params['model']->$relation, $id, $r );
		}
	}
	
	public function _render_edit(){
		return Response::redirect( $this->base_segments().'/view/'. $this->stash['model']['id'] );
	}
	
	public function _deleted( $params ){
		$this->_set_flash_message('success','Deleted_to_model',array('id' =>$params['id'] ));
	}
	
	public function _could_not_delete( $params ){
		$this->_set_flash_message('error','Could_not_delete',array('id' =>$params['id'] ));
	}
	
	public function _render_delete(){
		return Response::redirect( $this->base_segments() );
	}
	
	public function _set_flash_message( $status = 'success', $message = '', $params = array() ){
		Session::set_flash( 
			$status, 
			__('trait-crud.message.'.$message, array_merge($params, $this->_lang_params())) 
		);
	}


	/**
	 *
	 */
	public function base_segments(){
		$controller = static::$controller_name;
		$segments   = str_replace('Controller_','',$controller);
		$path = strtolower(str_replace('_','/',$segments));
		return $path;
	}
	
	/**
	 *
	 */
	public function model_properties(){
		$model = static::$model_name;
		$pr = array_keys( $model::properties() );
		$pk = $model::primary_key(); 
		$ex = static::$exclude_keys; 
		return array_diff($pr,$pk,$ex);
	}
	
	/**
	 *
	 */
	protected function _lang_params(){
		$p = array(
			'controller' => static::$controller_name , 
			'model'      => static::$model_name , 
			'model_name' => strtolower(str_replace('Model_','',static::$model_name))
		);
		$p['model_L10N'] = __('model.'.$p['model_name'].'._name');
		return $p;
	}
}
