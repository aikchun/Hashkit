<?php
App::uses('AppModel', 'Model');
/**
 * HashResult Model
 *
 */
class HashResult extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'hash_result';
	public $hasOne = array(
		'HashAlgorithm' => array(
			'className' => 'HashAlgorithm',
			'foreignKey' => 'id',
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'id',
			'counterCache' => true
		)
	);

}
