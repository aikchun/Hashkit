
<?php
App::uses('AppController', 'Controller');
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
	public $components = array('Paginator', 'Session');

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function basicHashing() {
		if($this->request->is('post')) {
			if(empty($this->request->data['HashTests']['HashAlgorithm'])) {
				$this->Session->setFlash('You did not select any algorithms!');
				return $this->redirect(array('action' => 'basicHashing'));
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
			return $this->redirect(array('controller' => 'HashTests' ,'action' => 'basicHashingInput'));
			
		}
		$conditions = array(
			'fields' => array('name', 'id' ),
			'order' => array('name ASC')
		);
			

		$this->Session->destroy();
		$HashAlgorithmModel = ClassRegistry::init('HashAlgorithm');
		$data = $HashAlgorithmModel->find('all', $conditions);
		$this->set('data', $data);
	}

	public function basicHashingInput() {
		$selectedAlgorithms = $this->Session->read('selectedAlgorithms');
		if($this->request->is('post')) {
			$data = $this->request->data;
			$output = $this->computeDigests($selectedAlgorithms, $data['HashTests']);
			$this->log($output);
			// $hashResultModel->create();
			// if ($hashResultModel->save($output)) {
			// 	$this->Session->setFlash(__('The hash result has been saved.'));
			// 	return $this->redirect(array('action' => 'index'));
			// } else {
			// 	$this->Session->setFlash(__('The hash result could not be saved. Please, try again.'));
			// }

			$this->Session->write('output', $output);
			$this->redirect(array('controller' => 'HashResults', 'action' => 'basicHashingResult'));

		}
	}
	public function computeAndCompare() {
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

		$this->Session->destroy();
		$HashAlgorithmModel = ClassRegistry::init('HashAlgorithm');
		$data = $HashAlgorithmModel->find('all', $conditions);
		$this->set('data', $data);
	}

	public function computeAndCompareInput() {
		$selectedAlgorithms = $this->Session->read('selectedAlgorithms');
		if($this->request->is('post')) {
			$data = $this->request->data;
			$output = $this->computeAndCompareDigests($selectedAlgorithms, $data['HashTests']);

			$this->Session->write('output', $output);
			$this->redirect(array('controller' => 'HashResults', 'action' => 'basicHashingResult'));

		}

	}
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

	protected function compareDigests($output) {
		foreach($output as $key => $hashResult) {
			
		}
		
		
	}
}
