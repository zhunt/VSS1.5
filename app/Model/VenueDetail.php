<?php
App::uses('AppModel', 'Model');
/**
 * VenueDetail Model
 *
 * @property Venue $Venue
 */
class VenueDetail extends AppModel {
    
var $actsAs = array(
        'MeioUpload.MeioUpload' => 
            array(
                
                'profile_image' => array(
                    
                    'thumbsizes' => array(
                                            'small' => array('width' => 50,'height' => 50, 'zoomCrop' => 'C' ),
                                            'medium' => array('width' => 371,'height' => 375, 'zoomCrop' => 'C' ), 
                                            'large' => array('width' => 400,'height' => 400, 'zoomCrop' => 'C' ), 
                                        ),
                    'thumbnailQuality' => 100
                    )
                )
    );

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
		'profile_image' => array(
			'Empty' => array(
				'check' => false,
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
		)
	);
}
