<?php 
	//require ('clsKdObjekt.php');
	class Article extends KdObject{
		
		public $keymap = array(
			'ID'				=> 'ID',
			'TITLE'				=> 'Title',
			'TEXT'				=> 'Text',
			'JSSORSLIDER'		=> 'JssorSlider',
			'VANITY'			=> 'Vanity',
			'METADESCRIPTION'	 => 'MetaDescription',
			'LASTUPDATEON'		=> 'LastUpdateOn'
		);
        	
        public function __construct($title = null, $text = null) {
			$this->tablename = "articles";
			$this->table_pk = "ID";
		}
		
		public function getArticles() {
			return array_reverse( KdObject::fetchAll() );
		}
		
		public function getArticleById ( $id ) {
			return KdObject::fetchObjectByID( $id );
		}
		
		public function create ( $title, $text, $jssor = null, $meta_descr ) {
			$art = new Article();
			
			$art->data['TITLE'] 			= $title;
			$art->data['TEXT'] 				= $text;
			$art->data['JSSOR'] 			= $jssor;
			$art->data['VANITY'] 			= translateToGreeklish( $title );
			$art->data['METADESCRIPTION'] 	= $meta_descr;
			$art->data['LASTUPDATEON'] 		= KdObject::now();
			/**@todo this is unsafe**/
			$art->save();
			return $art->id;
        }
		
	}
?>
