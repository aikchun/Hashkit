<?php
class HashingLib {

/**
 * Compare the message digests to come up with an analysis
 *
 */
	public static function compareDigests($output) {
		$hashResultModel = ClassRegistry::init('HashResult');
		$hashAlgorithmModel = ClassRegistry::init("HashAlgorithm");
		$analysis = array();
		$security = -1;
		$speed = 0;
		$recommendAlgo1 = '';

		$mdline = explode("\n",$output[0]['HashResult']['message_digest']);
		$ptline = explode("\n",$output[0]['HashResult']['plaintext']);

		$dup = HashingLib::checkDuplicatesInArray($mdline);

		foreach($output as $key => $hashResult) {
			$conditions = array(
				'conditions' => array('HashResult.message_digest' => $hashResult['HashResult']['message_digest']),
				'fields' => 'id'
			);
			$result = $hashResultModel->find('first', $conditions);

			$hashResult['HashResult']['collision_index'] = $dup;

			$collision_pt = array();
			$collision_md = array();
			$collision = '';
			if($dup != FALSE) {
				foreach($dup as $key => $num) {
					array_push($collision_pt,$ptline[$num]);
				 	array_push($collision_md,$mdline[$num]);
				 	$collision .= $ptline[$num] . " " . $mdline[$num] . "\n";
				}
			}

			if($dup != FALSE) {
				$hashResult['HashResult']['description'] = 'There is collision detected at: ' . "\n";
				$hashResult['HashResult']['collision_pt'] = $collision_pt;
				$hashResult['HashResult']['collision_md'] = $collision_md;
				$hashResult['HashResult']['collision'] = $collision;
			} elseif ($dup == FALSE) {
				$hashResult['HashResult']['collision'] = $collision;
				$hashResult['HashResult']['description'] = 'No collision detected';
			}

			$options = array(
				'conditions' => array(
					'HashAlgorithm.id' => $hashResult['HashResult']['hash_algorithm_id']
					),
				'fields' => array('HashAlgorithm.speed','HashAlgorithm.security',
					'HashAlgorithm.collision_resistance','HashAlgorithm.preimage_resistance',
					'HashAlgorithm.2nd_preimage_resistance','HashAlgorithm.output_length',
					'HashAlgorithm.collision_bka','HashAlgorithm.preimage_bka',
					'HashAlgorithm.2nd_preimage_bka')

				);
			$searchResult = array();
			$searchResult = $hashAlgorithmModel->find('first', $options);
	
			$hashResult['HashResult']['speed'] = $searchResult['HashAlgorithm']['speed'];
			$hashResult['HashResult']['security'] = $searchResult['HashAlgorithm']['security'];
			$hashResult['HashResult']['collision_resistance'] = $searchResult['HashAlgorithm']['collision_resistance'];
			$hashResult['HashResult']['preimage_resistance'] = $searchResult['HashAlgorithm']['preimage_resistance'];
			$hashResult['HashResult']['2nd_preimage_resistance'] = $searchResult['HashAlgorithm']['2nd_preimage_resistance'];
			$hashResult['HashResult']['output_length'] = $searchResult['HashAlgorithm']['output_length'];
			$hashResult['HashResult']['collision_bka'] = $searchResult['HashAlgorithm']['collision_bka'];
			$hashResult['HashResult']['preimage_bka'] = $searchResult['HashAlgorithm']['preimage_bka'];
			$hashResult['HashResult']['2nd_preimage_bka'] = $searchResult['HashAlgorithm']['2nd_preimage_bka'];
			
			if ($hashResult['HashResult']['security'] > $security) {
				$security = $hashResult['HashResult']['security'];
				$recommendAlgo = $hashResult['HashResult']['hash_algorithm_name'];
				$speed = $hashResult['HashResult']['speed'];
			} elseif ($hashResult['HashResult']['security'] == $security) {
				//if($hashResult['HashResult']['speed'] > $speed) {
					$recommendAlgo1 = $hashResult['HashResult']['hash_algorithm_name'];
					$recommendAlgo .= ', ' . $recommendAlgo1;
				//}
			}

			$hashResult['HashResult']['recommendation'] = $recommendAlgo;
			//if(!empty($result['HashResult']['id'])) {
			//	$hashResult['HashResult']['analysis'] = 'This input is a very common hash value for the algorithm: '. $hashResult['HashResult']['hash_algorithm_name'];
			//} else {
			//	$hashResult['HashResult']['analysis'] = 'This is not a common hash value for algorithm: '. $hashResult['HashResult']['hash_algorithm_name'];
			//}
			array_push($analysis, $hashResult);
		}
		
		//$this->log($analysis);
		return $analysis;
	}

/**
 * Find duplicate message digests within submitted entries.
 * @array containing message in this format ($key => $row)
 * @return array containing index for duplicate message digest.
 */

	public static function checkDuplicatesInArray($array) {
		$count = 0;
		$dup = array();
		$dupIndex = array();
    	$duplicates=FALSE;
    	foreach($array as $k=>$i) {
        	if(!isset($value_{$i})) {
          	  $value_{$i}=TRUE;
        	}
        	else {
            	$duplicates|=TRUE; 
            	array_push($dup, $i);    
            	//array_push($dup, $count);  
        	}
    	}

    	foreach ($dup as $q => $w) {
    		foreach ($array as $a => $s) {
    			if($w == $s) {
    				array_push($dupIndex, $count);
    			}
    			$count += 1;
    		}
    		$count = 0;
    	}

    	if ($duplicates == TRUE) {
    		return $dupIndex;
   		} else {
   			return ($duplicates);
   		}
	}


/**
 * find plaintext with MessageDigest
 * @param $data array containing ['message_digest'] and ['hash_algorithm']
 * @return mixed false if there are no such record found in database or array containing plaintext is return
 */ 
	public static function matchPlaintextWithMessageDigest($data) {
		$dictionaryModel = ClassRegistry::init('Dictionary');
		$conditions = array(
			'conditions' => array(
				'Dictionary.'.$data['hash_algorithm_name'] => $data['message_digest'],
			),
			'fields' => array('Dictionary.plaintext')
		);
		$checkDictionaryResult = $dictionaryModel->find('all', $conditions);
		// Insert into dictionary
		if(empty($checkDictionaryResult)) {

			return false;
		} else {
			return $checkDictionaryResult;
		}
			
	}

/**
 * To calcuate the number of hashes needed to get a 99% probability of getting a collision 
 *  
 */
	public static function generate_ninety_nine_percentage_proability($N, $K){
		$check = true;

		while($check == true) :
			$firstexpEqu = (- bcpow($N,2)) / (2 * $K);
			$probability = (1 - exp($firstexpEqu)) * 100;
			if($probability < 99) {
				if($K < 100){
					$N += 1;
				}else if($K < 1000){
					$N += 10;
				}else if($K < 10000){
					$N += 100;
				}else if($K < 100000){
					$N += 1000;
				}else{
					$N += 100000000000000000000000000;	
				}
			}else {	
				$requiredsamplespace = $N;
				$check = false;
			}
		endwhile;
		$this->Session->write('requiredsamplespace', $requiredsamplespace);	
	} 

	public static function computeAvalanche($firstMD, $secondMD){
		$lengthOfMD = strlen ($firstMD);
		$bitDiff = array();
		$result = array();
		$count = 0;
		for ($i = 0; $i < $lengthOfMD; $i++){
			if (strcmp($firstMD[$i], $secondMD[$i]) != 0) {
				$count++;
			}
			else{
				array_push($bitDiff, $i);
			}
		}

		$percent = $count / $lengthOfMD * 100;
		$percent = round ($percent, 2);

		$result['Percent'] = $percent;
		$result['BitDiff'] = $bitDiff;

		return $result;
	}

}


?>
