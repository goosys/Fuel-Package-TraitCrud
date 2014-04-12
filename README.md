# Trait-Crud

* Version: 1.0

## Information

* PHP >= 5.4
* FuelPHP = 1.7/master

## Description

FuelPHPのコントローラーにCRUDを提供します。

## Install

* git clone https://github.com/goosys/Fuel-Package-TraitCrud.git fuel/packages/trait-crud
* vi fuel/app/config.php

		always_load => 
			packages => 'trait-crud',
			language => 'trait-crud'

* ln -s ../../../trait-crud/views/scaffolding/trait-crud fuel/packages/oil/views/scaffolding/trait-crud
* oil g scaffold/trait-crud animal name:varchar kana:varchar description:text flag:bool
* vi fuel/app/lang/ja/model.php

		return array(
			'animal' => array(
				'name'   => '名称',
				'kana'   => 'ヨミ',
				'description'   => '説明',
				'flag'   => 'フラグ',
			),
		);

* cp fuel/app/lang/{ja,en}/model.php

## Usage

### Controller

		class Controller_Animal extends Controller_Template{
			//CRUDを提供
			use Trait_Crud;
			
			//初期化
			public function before(){
				static::$model_name       = 'Model_Animal';
				static::$controller_name  = 'Controller_Animal';
				static::$func_validate    = 'validate';
				parent::before();
			}
			
			//機能を利用
			public function action_index()
			{
				$this->_action_index();
				
				$data = array('items'=> $this->stash['models']);
				$this->template->content = View::forge('animal/index',$data);
			}
		}

## Overwritable Methods

		public function _action_index(){}
		public function _action_view($id = null){}
		public function _action_create(){}
		public function _action_edit($id = null){}
		public function _action_validate(){}
		public function _action_delete($id = null){}
		
		public function _render_404(){}
		public function _render_index(){}
		public function _could_not_found_id( $params ){}
		
		public function _render_view(){}
		
		public function _set_model_from_input( $params ){}
		public function _added( $params ){}
		
		public function _could_not_save( $params ){}
		public function _validation_error( $params ){}
		public function _validated( $params ){}
		public function _render_create(){}
		
		public function _updated( $params ){}
		public function _could_not_update( $params ){}
		public function _set_model_from_validation( $params ){}
		public function _render_edit(){}
		
		public function _deleted( $params ){}
		public function _could_not_delete( $params ){}
		public function _render_delete(){}

## Customize

### Scaffoldのテンプレートをカスタマイズ
* cp fuel/packages/trait-crud/views/scaffolding/trait-crud fuel/app/views/

### 「詳細｜編集｜削除」ボタンのテンプレートを編集
* cp -r fuel/packages/trait-crud/views/include fuel/app/views/

## More Informations

[Fuel-Package-TraitPagination](https://github.com/goosys/Fuel-Package-TraitPagination)と組み合わせることで、より簡単に検索とページャー付きのCRUDが作成できます。

## License

MIT License

