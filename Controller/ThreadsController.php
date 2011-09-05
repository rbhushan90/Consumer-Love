<?php
class ThreadsController extends AppController {
	
	public $paginate = array(
		'Thread' => array(
			'limit' => 25,
			'order' => 'LastPost.created DESC'
		),
		'Post' => array(
			'limit' => 10,
			'order' => 'Post.created ASC'
		)
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('all', 'view'));
	}
	
	public function all($productSlug) {
		$product = $this->Thread->Product->justGetProductBySlug($productSlug);
		
		$threads = $this->paginate('Thread', array('product_id' => $product['Product']['id']));
		
		$title_for_layout = $product['Product']['name']. ' Forum';
		$this->set(compact('product', 'threads', 'title_for_layout'));
	}
	
	public function create($productId = null) {
		// Check Product
		$this->Thread->Product->id = $productId ?: $this->data['Thread']['product_id'];
		$this->Thread->Product->contain('Category');
		$product = $this->Thread->Product->read();
		
		if(empty($product)) {
			$this->cakeError('error404');
		}
		
		if(!empty($this->data)) {
			$this->data['Thread']['user_id'] = $this->userData['User']['id'];
			$this->data['Thread']['user_ip'] = $this->RequestHandler->getClientIp();
			
			// Spam check goes here
			$this->data['Thread']['published'] = 1;
			
			if($threadId = $this->Thread->addThread($this->data)) {
				$this->Session->setFlash('Your thread has been saved successfully.');
				if(!$this->isApiCall()) {
					$this->redirect(array('controller' => 'products', 'action' => 'view', $product['Product']['slug']));
				}
			} else {
				$this->Session->setFlash('Please correct the errors below.');
			}
		}
		
		$title_for_layout = 'New Thread';
		$this->set(compact('product', 'title_for_layout'));
	}
	
	public function view($productSlug, $threadSlug = null) {
		// Get product, it should always exist thanks to our route
		$product = $this->Thread->Product->justGetProductBySlug($productSlug);
		
		if(empty($product)) {
			$this->cakeError('error404');
		}
		
		$thread = $this->Thread->getThreadForViewing($threadSlug);
		
		$posts = $this->paginate('Post', array('thread_id' => $thread['Thread']['id']));
		
		$this->set('title_for_layout', $thread['Thread']['title']);
		$this->set(compact('product', 'thread', 'posts'));
	}
	
}