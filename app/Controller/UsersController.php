<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UsersController extends AppController {


/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Email'); 
	// public $helpers=array('Html','Form','Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->_configureAllowedActions();
	}

/**
 * determine which actions require authentication or allow anonymous access
 *
 * @return void
 **/
 protected function _configureAllowedActions() {
 	$allowedActions = array(
 	 'login',
 	 'logout',
 	 'admin_login',
 	 'admin_logout',
 	 'forget_password',
 	 'reset_password',
	 'register',
 	);
 	$this->Auth->allow($allowedActions);
 }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		/* $this->set('users', $this->Paginator->paginate()); */
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	public function login() {
		if($this->request->is('post')) {
			$this->log($this->request->data);
			if($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
			} else {
				$log = $this->User->getDataSource()->getLog(false, false);
				$this->log($log);
				$this->Session->setFlash(__('Your username or password was incorrect.'));
			}
		}
	}

	public function logout() {
		$this->Session->setFlash("Goodbye.");
		$this->redirect($this->Auth->logout());

	}

	public function register() {
		$this->layout = 'admin';
		if($this->request->is('post')) {
			$data = $this->request->data;
			try{
				if(!($data['User']['password'] == $data['User']['confirm_password'])) {
					throw new Exception ('Please the password\'s does not match!');
				}
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}

			} catch(Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
	}

	public function forget_password() {
		$this->layout = 'admin';
		$this->User->recursive=-1;
	}

	public function home() {
		
	}

}

