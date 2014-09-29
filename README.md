# Trait-Crud

* Version: 2.0

## Information

* PHP >= 5.4
* FuelPHP = 1.7/master

## Description

FuelPHPのコントローラーにCRUDを提供します。

標準のscaffoldで作成されるcontrollerを共通化し、traitで提供します。
簡単なCRUDのコントローラーはより簡便な記述で実装でき、複雑なコントローラーはオーバーライド可能なメソッド群で柔軟にカスタマイズ可能です。

* ver.2.0 子モデルを同時にバリデーション及び保存できるようになりました。（１階層のみ）

## Install

* git clone https://github.com/goosys/Fuel-Package-TraitCrud.git fuel/packages/trait-crud
* vi fuel/app/config.php

		always_load => 
			packages => 'trait-crud',
			language => 'trait-crud'

* ln -s ../../../trait-crud/views/scaffolding/trait-crud fuel/packages/oil/views/scaffolding/trait-crud

## Example

### Default
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

### Twig
* Unsupported

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
				static::$url_base         = 'animal';
				/*static::$exclude_keys     = array();*/
				parent::before();
			}
			
			//機能を利用
			public function action_index()
			{
				$this->_action_index();
				
				$data = array('items'=> $this->stash['models'], 'url_base'=>static::$url_base );
				$this->template->content = View::forge( static::$url_base. '/index',$data);
			}
			
			//保存値のセットメソッドをオーバライド
			public function _set_model_from_validation( $params )
			{
				$this->_set_model_from_validation0( $params );
				
				//子モデルの保存値をセット
				$this->_set_related_model_from_validation( 'foods', $params );
			}

### Model

#### Parent

		class Model_Animal extends Model
		{
			...
			
			protected static $_has_many= array(
				'foods'
			);
			
			public static function validate($factory)
			{
				$val = Validation::forge($factory);
				$val->add_field('name'       , __('model.animal.name'       ), 'required|max_length[255]');
				$val->add_field('kana'       , __('model.animal.kana'       ), 'required|max_length[255]');
				$val->add_field('description', __('model.animal.description'), 'required');
				$val->add_field('flag'       , __('model.animal.flag'       ), 'required');

				//子モデルを一緒にバリデーション
				if( Input::post('food') ){
					foreach( Input::post('food') as $id => $p ){
						$val = Model_Food::validate_relation($val,$id);
					}
				}
				
				return $val;
			}

#### Child

		class Model_Food extends Model
		{
			...
			
			//リレーション用のバリデーション
			public static function validate_relation($val,$id)
			{
				//$val->add_field('food.'.$id.'.animal_id'  , __('model.food.animal_id'  ), 'required|valid_string[numeric]');
				$val->add_field('food.'.$id.'.name'       , __('model.food.name'       ), 'required|max_length[255]');
				$val->add_field('food.'.$id.'.description', __('model.food.description'), 'required');
				$val->add_field('food.'.$id.'.flag'       , __('model.food.flag'       ), 'required');
				
				return $val;
			}

### View

#### Parent (_form.php)

		<!-- 子モデルのフォームをレンダリング（relationモード） -->
		<div class="form-group">
			<?php echo Form::label(__('model.food._name'), 'foods', array('class'=>'control-label')); ?>
				<?php echo render('food/_form', array('relation'=>true,'items'=>isset($item)? $item->foods:array()) ); ?>
		</div>

### Asset(js)

必要であれば子フォーム用Javascript（jQuery)をコピー

* cp fuel/packages/trait-crud/assets/trait-crud/js/form.js /public/assets/js/

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
		public function _set_related_model_from_validation( $relation_name, $params ){}
		public function _render_edit(){}
		
		public function _deleted( $params ){}
		public function _could_not_delete( $params ){}
		public function _render_delete(){}

## Preview

![animal](https://cloud.githubusercontent.com/assets/4225334/4438668/7a3cf468-47af-11e4-8089-b709a28bd9ae.PNG)
![animal_edit](https://cloud.githubusercontent.com/assets/4225334/4438671/7e41432a-47af-11e4-80cc-0a733bbb2d28.PNG)

## Customize

### Scaffoldのテンプレートをカスタマイズ
* cp fuel/packages/trait-crud/views/scaffolding/trait-crud fuel/app/views/

### 「詳細｜編集｜削除」ボタンのテンプレートを編集
* cp -r fuel/packages/trait-crud/views/include fuel/app/views/

## More Information

[Fuel-Package-TraitPagination](https://github.com/goosys/Fuel-Package-TraitPagination)と組み合わせることで、より簡単に検索とページャー付きのCRUDが作成できます。

## License

MIT License

