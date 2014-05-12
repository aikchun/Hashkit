<?php
App::uses('HashTest', 'Model');

/**
 * HashTest Test Case
 *
 */
class HashTestTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.hash_test',
		'app.user',
		'app.group',
		'app.hash_result',
		'app.dictionary'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->HashTest = ClassRegistry::init('HashTest');
		$this->HashAlgorithm = ClassRegistry::init('HashAlgorithm');
		$this->HashResult = ClassRegistry::init('HashResult');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->HashTest);
		unset($this->HashAlgorithm);
		unset($this->HashResult);

		parent::tearDown();
	}

/**
 * testSaveTestResults method
 *
 * @return void
 */
	public function testSaveTestResults() {
		// MOCK the _getUser method to always return 23 because we always expect that
		 $this->HashTest = $this->getMockForModel('HashTest', array('_getUser'));
		  $this->HashTest->expects($this->once())
		   ->method('_getUser')
		    ->will($this->returnValue(10));

		// WHEN $data = data[n]['HashResult']['fields'] && $outputResult = 'Basic Hashing'
		$plaintext = 'Enemies';
		$hashAlgorithmId = 2;
		$conditions = array(
			'conditions' => array(
				'HashAlgorithm.id' => $hashAlgorithmId
			),
			'fields' => array(
				'HashAlgorithm.name'
			)
		);
		$searchResult = $this->HashAlgorithm->find('first', $conditions);
		$hashAlgorithmName = strtolower($searchResult['HashAlgorithm']['name']);
		$data = array(
			array(
				'HashResult' => array(
					'plaintext' => $plaintext,
					'message_digest' => hash($hashAlgorithmName, $plaintext),
					'hash_algorithm_id' => $hashAlgorithmId
				)
			)

		);
		// THEN execute saveTestResults
		$saveSuccessful = $this->HashTest->saveTestResults($data);
		// EXPECT return to be true;
		$this->assertTrue($saveSuccessful);
	}

/**
 * testComputeDigests method
 *
 * @return void
 */
	public function testComputeDigests() {
		//plaintext
		$fileData = 'Hello';

		$conditions = array(
				'conditions' => array(
						'HashAlgorithm.name' => 'MD2'
				),
				'fields' => array(
					'HashAlgorithm.id',
					'HashAlgorithm.name'
				)
			);	
		
		//get hash algorithm name based on conditions
		$selectedAlgorithms = $this->HashAlgorithm->find('all', $conditions);

		//call computeDigest to get hash result
		$result = $this->HashTest->computeDigests($selectedAlgorithms,$fileData);
		$computedMD = $result[0]['HashResult']['message_digest'];

		//expected message digest
		$expectedMD = 'a9046c73e00331af68917d3804f70655';

		//check if expected and computed is the same
		$this->assertEquals($computedMD,$expectedMD);
	}

	public function testCheckDuplicatesInArray() {
		$mdData = array(
			'aaf4c61ddcc5e8a2dabede0f3b482cd9aea9434d',
			'f10e2821bbbea527ea02200352313bc059445190',
			'78c9a53e2f28b543ea62c8266acfdf36d5c63e61',
			'aaf4c61ddcc5e8a2dabede0f3b482cd9aea9434d',
			'7f550a9f4c44173a37664d938f1355f0f92a47a7',
			'f10e2821bbbea527ea02200352313bc059445190'
			);

		$result = $this->HashTest->checkDuplicatesInArray($mdData);

		$expected = array(
			'0',
			'3',
			'1',
			'5'
			);

		$this->assertEquals($result,$expected);
	}

/**
 * testCheckAndInsertIntoDictionary method
 *
 * @return void
 */
	public function testCheckAndInsertIntoDictionary() {
		// WHEN $data = 'Hello There'
		$data = 'Hello There';

		// THEN EXECUTE checkAndInsertIntoDictionary
		$saveSuccessful = $this->HashTest->checkAndInsertIntoDictionary($data);

		// EXPECT
		$this->assertFalse($saveSuccessful);
		
		// WHEN $data = 'aalksjda;lkdjwjqdalsdavsn,emwn'
		$data = 'aalksjda;lkdjwjqdalsdavsn,emwn';

		// THEN EXECUTE checkAndInsertIntoDictionary
		$saveSuccessful = $this->HashTest->checkAndInsertIntoDictionary($data);

		// EXPECT
		$this->assertTrue($saveSuccessful);

	}

}