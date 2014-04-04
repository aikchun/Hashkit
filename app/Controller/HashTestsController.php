
<?php
App::uses('AppController', 'Controller');
App::uses('HashingLib', 'Lib/Hashing');

/**
 * HashTests Controller
 *
 * @property HashTest $HashTest
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class HashTestsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Email'); 
	public $helpers=array('Html','Form','Session');

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
		);
		$this->Auth->allow($allowedActions);
	 }

/**
 * Basic Hashing method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */

/**
 * User is to choose the algorithms that he/she wants to hash the plaintext.
 */
	public function basic_hashing() {
		if($this->request->is('post')) {
			if(empty($this->request->data['HashTests']['HashAlgorithm'])) {
				$this->Session->setFlash('You did not select any algorithms!');
				return $this->redirect(array('action' => 'basic_hashing'));
			}
			$data = $this->request->data['HashTests'];
			$HashAlgorithmModel = ClassRegistry::init('HashAlgorithm');
			$selectedAlgorithms = array();
			foreach ($data as $key => $hashId) {
				$searchCondition = array(
					'conditions' => array(
						'HashAlgorithm.id' => $data['HashAlgorithm'] 
					),
					'fields' => array('id','name')
				);
				$selectedAlgorithms = $HashAlgorithmModel->find('all', $searchCondition);
			}
			$this->Session->write('selectedAlgorithms' , $selectedAlgorithms);
			$this->log("before basic hashing");
			return $this->redirect(array('controller' => 'HashTests' ,'action' => 'basic_hashing_input'));
			
		}
		$conditions = array(
			'fields' => array('name', 'id' ),
			'order' => array('name ASC')
		);
			

		$this->Session->write('selectedAlgorithms' , '');
		$HashAlgorithmModel = ClassRegistry::init('HashAlgorithm');
		$data = $HashAlgorithmModel->find('all', $conditions);
		$this->set('data', $data);
	}

	/**
	 * Allow user to input plaintext that is to be hashed.
	 */
	public function basic_hashing_input() {
		$this->log("Enter basic hashing");
		$selectedAlgorithms = $this->Session->read('selectedAlgorithms');
		if($this->request->is('post')) {
			$data = $this->request->data;
			$output = HashingLib::computeDigests($selectedAlgorithms, $data['HashTests']);

			$this->Session->write('output', $output);
			$this->redirect(array('controller' => 'HashResults', 'action' => 'basic_hashing_result'));

		}
	}

/**
 * To allow the user choose the algorithms that is to analyzed.
 */
	public function compute_and_compare() {
		if($this->request->is('post')) {
			if(empty($this->request->data['HashTests']['HashAlgorithm'])) {
				$this->Session->setFlash('You did not select any algorithms!');
				return $this->redirect(array('action' => 'computeAndCompare'));
			}
			$data = $this->request->data['HashTests'];
			$HashAlgorithmModel = ClassRegistry::init('HashAlgorithm');
			$selectedAlgorithms = array();
			foreach ($data as $key => $hashId) {
				$searchCondition = array(
					'conditions' => array(
						'HashAlgorithm.id' => $data['HashAlgorithm'] 
					),
					'fields' => array('id','name')
				);
				$selectedAlgorithms = $HashAlgorithmModel->find('all', $searchCondition);
			}
			$this->Session->write('selectedAlgorithms' , $selectedAlgorithms);
			return $this->redirect(array('controller' => 'HashTests' ,'action' => 'computeAndCompareInput'));
			
		}
		$conditions = array(
			'fields' => array('name', 'id' ),
			'order' => array('name ASC')
		);

		$this->Session->write('selectedAlgorithms' , '');
		$HashAlgorithmModel = ClassRegistry::init('HashAlgorithm');
		$data = $HashAlgorithmModel->find('all', $conditions);
		$this->set('data', $data);
	}

/**
 * Input page of the compute and compare functionality of the project.
 */
	public function computeAndCompareInput() {
		$selectedAlgorithms = $this->Session->read('selectedAlgorithms');
		if($this->request->is('post')) {
			$data = $this->request->data;
			$output = $this->computeDigests($selectedAlgorithms, $data['HashTests']);
			$outputResult = $this->compareDigests($output);

			$this->Session->write('output', $outputResult);
			$this->redirect(array('controller' => 'HashResults', 'action' => 'computeAndCompareResult'));

		}

	}

/**
 * Compute the hashed value of the input plaintext.
 */
	protected function computeDigests($selectedAlgorithms, $hashTestForm) {
		$computed = array();
		$output = array();
		foreach($selectedAlgorithms as $key => $algorithm ) {
			$messageDigest = hash(strtolower($algorithm['HashAlgorithm']['name']), $hashTestForm['plaintext']);

			$computed['HashResult']['plaintext'] = $hashTestForm['plaintext'];
			$computed['HashResult']['message_digest'] = $messageDigest;
			$computed['HashResult']['hash_algorithm_id'] = $algorithm['HashAlgorithm']['id'];
			$computed['HashResult']['hash_algorithm_name'] = $algorithm['HashAlgorithm']['name'];
			$computed['HashResult']['user_id'] = $hashTestForm['id'];
			array_push($output, $computed);
		}
		// $output['HashAlgorithm'] = $selectedAlgorithms['HashAlgorithm'];
		// $output['HashResult']['plaintext'] = $plaintext;
		// $output['HashResult']['message_digest'] = $listOfMessageDigests;
		
		return $output;
	}

/**
 * Compare the message digests to come up with an analysis
 *
 */
	protected function compareDigests($output) {
		$hashResultModel = ClassRegistry::init('HashResult');
		$analysis = array();
		foreach($output as $key => $hashResult) {
			$conditions = array(
				'conditions' => array('HashResult.message_digest' => $hashResult['HashResult']['message_digest']),
				'fields' => 'id'
			);
			$result = $hashResultModel->find('first', $conditions);
			$this->log('This is result.');
			$this->log($result);


			if(!empty($result['HashResult']['id'])) {
				$hashResult['HashResult']['analysis'] = 'This input is a very common hash value for the algorithm: '. $hashResult['HashResult']['hash_algorithm_name'];
			} else {
				$hashResult['HashResult']['analysis'] = 'This is not a common hash value for algorithm: '. $hashResult['HashResult']['hash_algorithm_name'];
			}
			array_push($analysis, $hashResult);
		}
		return $analysis;
	}

/**
 * To look up plaintext equivalent when entering message digest
 *
 */
	public function reverseHashLookUp() {

	}
}
