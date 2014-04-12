<?php

trait Trait_Crud {

	protected static $model_name;
	protected static $controller_name;
	protected static $func_validate    = 'validate';
	protected static $properties       = array();
	
	protected $stash = array();
	
	public function _action_index()
	{
		$model_name = static::$model_name;
		$this->stash['models'] = $model_name::find('all');
	}

	public function _action_view($id = null)
	{
		$model_name = static::$model_name;
		
		if( is_null($id) ){ $this->_render_404(); }

		if ( ! $this->stash['model'] = $model_name::find($id))
		{
			$this->_could_not_found_id( array( 'id'=> $id ) );
			$this->_render_404();
		}
	}

	public function _action_create()
	{
		$model_name = static::$model_name;
		$this->stash['model'] = $model = $model_name::forge();
		
		if (Input::method() == 'POST')
		{
			$func_validate = static::$func_validate;
			$val = $model_name::$func_validate('create');
			
			if ($val->run())
			{
				$this->_set_model_from_input( array( 'model'=> $model ) );

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
				$this->_validation_error( array( 'val'=>$val ) );
			}
		}
		else{
			//case: GET/:controller/create
		}
	}
	

	public function _action_edit($id = null)
	{
		$model_name = static::$model_name;
		$this->stash['model'] = array();
		
		if( is_null($id) ){ return $this->_render_404(); }
		
		$this->stash['model'] = $model = $model_name::find($id);
		if ( !$model )
		{
			$this->_could_not_found_id( array( 'id'=> $id ) );
		}

		$func_validate = static::$func_validate;
		$val = $model_name::$func_validate('edit');

		if ($val->run())
		{
			$this->_set_model_from_input( array( 'model'=> $model ) );

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

	public function _action_delete($id = null)
	{
		$model_name = static::$model_name;
		
		if( is_null($id) ){ return $this->_render_404(); }

		$this->stash['model'] = $model =  $model_name::find($id);
		if ( $model && $model->delete() )
		{
			$this->_deleted( array( 'id'=> $id ) );
		}

		else
		{
			$this->_could_not_delete( array( 'id'=> $id ) );
		}
		
		return $this->_render_delete();
	}
	
	
	
	
	public function _render_404(){
		throw new HttpNotFoundException;
	}
	
	
	public function _render_index(){
	
	}
	
	public function _could_not_found_id( $params ){
		Session::set_flash('error', sprintf('Could not find %s #%d', static::$controller_name ,$params['id'] ));
	
	}
	
	public function _render_view(){
	
	}
	
	public function _set_model_from_input( $params ){
		foreach ( static::model_properties() as $p ){
			$params['model']->$p = Input::param( $p );
		}
	}
	
	public function _added( $params ){
		Session::set_flash('success', sprintf('Added %s #%d', static::$controller_name ,$params['model']->id ));
		Session::set_flash('id', $params['model']->id );
		Session::set_flash('model', $params['model'] );
	}
	
	public function _could_not_save( $params ){
		Session::set_flash('error', sprintf('Could not save %s #%d', static::$controller_name ,$params['model']->id ));
	}
	
	public function _validation_error( $params ){
		Session::set_flash('error' , $params['val']->error());
		Session::set_flash('validation', $params['val']);
	}
	
	public function _validated( $params ){
		Session::set_flash('success', sprintf('Validated ' ));
	}
	
	public function _render_create(){
		return Response::redirect( $this->base_segments().'/edit/'. $this->stash['model']['id'] );
	}
	
	public function _updated( $params ){
		Session::set_flash('success', sprintf('Added %s #%d', static::$controller_name ,$params['model']->id ));
	}
	
	public function _could_not_update( $params ){
		Session::set_flash('error', sprintf('Could not update %s #%d', static::$controller_name ,$params['model']->id ));
	}
	
	public function _set_model_from_validation( $params ){
		foreach ( static::model_properties() as $p ){
			$params['model']->$p = $params['val']->validated($p);
		}
	}
	
	public function _render_edit(){
		return Response::redirect( $this->base_segments() );
	}
	
	public function _deleted( $params ){
		Session::set_flash('success', sprintf('Deleted %s #%d', static::$controller_name ,$params['id'] ));
	}
	
	public function _could_not_delete( $params ){
		Session::set_flash('error', sprintf('Could not delete %s #%d', static::$controller_name ,$params['id']  ));
	}
	
	public function _render_delete(){
		return Response::redirect( $this->base_segments() );
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
		return array_diff($pr,$pk);
	}
}
