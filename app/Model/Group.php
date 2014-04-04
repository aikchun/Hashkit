<?php
App::uses('AppModel', 'Model');
/**
 * Group Model
 *
 */
class Group extends AppModel {

	public $hasMany = array(

	);
	public $actAs = array('Acl' => array('type' => 'requester'));
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'group';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public function parentNode() {
		return null;
	}

}
