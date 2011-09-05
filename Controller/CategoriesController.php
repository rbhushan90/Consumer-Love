<?php
class CategoriesController extends AppController {

	 public $paginate = array(
        'Product' => array(
            'joins' => array(
                array(
                    'table' => 'categories_products', // or products_categories
                    'alias' => 'CategoryFilter',
                    'type' => 'INNER',
                    'conditions' => array(
                        'CategoryFilter.product_id = Product.id'
                    )
                )
            ),
            'limit' => 10
         )
    );
	
	
	public function beforeFilter() {
		$this->Auth->allow('index', 'view');
		parent::beforeFilter();
	}

	public function index() {
		$categories =  $this->Category->getAllThreaded();

		$this->set(compact('categories'));
	}

	public function view($slug) {
		$this->Category->contain(false);
		$category = $this->Category->findBySlug($slug);
		if(!$category) {
			$this->cakeError('error404');
		}
		
		$path = $this->Category->getPath($category['Category']['id']);
		
		// Make custom method
		if(isset($this->params['data']['sort'], $this->params['data']['order']) ) {
			$this->paginate['Product']['order'] = array($this->params['data']['sort'] => $this->params['data']['order']);
		}
		
		$products = $this->paginate($this->Category->Product, array(
			'CategoryFilter.category_id' => $category['Category']['id']
		));
		
		$this->set(compact('category', 'products', 'path'));
		$this->set('title_for_layout', $category['Category']['name']);
	}
	
	/** Admin Actions **/
	
	public function admin_index() {
		$categories = $this->Category->getAllThreaded();
		
		$title_for_layout = 'Manage Categories';
		$this->set(compact('title_for_layout', 'categories'));
	}

	public function admin_edit($id = null) {
		$this->Category->id = $id;
		
		if($id && empty($this->data)) {
			$this->data = $this->Category->read();
			$this->set('title_for_layout','Edit '.$this->data['Category']['name']);
			$this->set('pageAction', 'edit');
			if(empty($this->data)) {
				$this->Session->setFlash('Invalid category ID.');
				$this->redirect(array('action' => 'index'));
			}
		} else {
			if(!empty($this->data)) { //Saving
				if($this->Category->save($this->data)) {
					$this->Session->setFlash('Changes made to '.$this->data['Category']['name'].' have been saved.');
					$this->data = $this->Category->read();
				}
				
				$this->set('title_for_layout','Edit '.$this->data['Category']['name']);
				$this->set('pageAction', 'edit');
			} else {
				$this->set('title_for_layout', 'Add Category');
				$this->set('pageAction', 'add');
			}
		}
		
		$parents = array(0 => '[ No Parent ]') + $this->Category->generatetreelist(null,null,null," - ");
		$this->set(compact('parents'));
	}

}