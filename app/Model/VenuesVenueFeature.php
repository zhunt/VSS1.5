<?php
App::uses('AppModel', 'Model');
/**
 * VenuesVenueFeature Model
 *
 * @property Venue $Venue
 * @property VenueFeature $VenueFeature
 */
class VenuesVenueFeature extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'venue_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'venue_feature_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Venue' => array(
			'className' => 'Venue',
			'foreignKey' => 'venue_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'VenueFeature' => array(
			'className' => 'VenueFeature',
			'foreignKey' => 'venue_feature_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
