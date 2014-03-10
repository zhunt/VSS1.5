<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 * @property Category $Category
 * @property RelatedBusinessType $RelatedBusinessType
 * @property Province $Province
 * @property PostCategory $PostCategory
 * @property PostAuthor $PostAuthor
 * @property Venue $Venue
 * @property City $City
 * @property PublishState $PublishState
 * @property PostTag $PostTag
 */
class Post extends AppModel {
    
    var $actsAs = array(
        'MeioUpload.MeioUpload' => 
            array(
                
                'image_1' => array(                    
                    'thumbsizes' => array(
                                            'small' => array('width' => 100,'height' => 100, 'zoomCrop' => 'C' ),
                                            'half' =>  array('width' => 370,'height' => 185, 'zoomCrop' => 'C' ),
                                            'half2' =>  array('width' => 370,'height' => 370, 'zoomCrop' => 'C' ),
                                            'medium' => array('width' => 270,'height' => 135, 'zoomCrop' => 'C' ), 
                                            'medium2' => array('width' => 270,'height' => 270, 'zoomCrop' => 'C' ), 
                                            'large' => array('width' => 770,'height' => 385, 'zoomCrop' => 'C' ), 
                                            'facebook' => array('width' => 200,'height' => 200, 'zoomCrop' => 'C' ) 
                                        )
                    ),

                'image_2' => array(
                    'thumbsizes' => array(
                                            'small' => array('width' => 100,'height' => 100, 'zoomCrop' => 'C' ),
                                            'half' =>  array('width' => 370,'height' => 185, 'zoomCrop' => 'C' ),
                                            'half2' =>  array('width' => 370,'height' => 370, 'zoomCrop' => 'C' ),
                                            'medium' => array('width' => 270,'height' => 135, 'zoomCrop' => 'C' ), 
                                            'medium2' => array('width' => 270,'height' => 270, 'zoomCrop' => 'C' ), 
                                            'large' => array('width' => 770,'height' => 385, 'zoomCrop' => 'C' ),
                                            'facebook' => array('width' => 200,'height' => 200, 'zoomCrop' => 'C' ) 
                                        )                   
                ),

                'image_3' => array(
                    'thumbsizes' => array(
                                            'small' => array('width' => 100,'height' => 100, 'zoomCrop' => 'C' ),
                                            'half' =>  array('width' => 370,'height' => 185, 'zoomCrop' => 'C' ),
                                            'half2' =>  array('width' => 370,'height' => 370, 'zoomCrop' => 'C' ),
                                            'medium' => array('width' => 270,'height' => 135, 'zoomCrop' => 'C' ), 
                                            'medium2' => array('width' => 270,'height' => 270, 'zoomCrop' => 'C' ), 
                                            'large' => array('width' => 770,'height' => 385, 'zoomCrop' => 'C' ), 
                                            'facebook' => array('width' => 200,'height' => 200, 'zoomCrop' => 'C' ) 
                                        )                    
                ),
                
                'image_4' => array(
                    'thumbsizes' => array(
                                            'small' => array('width' => 100,'height' => 100, 'zoomCrop' => 'C' ),
                                            'half' =>  array('width' => 370,'height' => 185, 'zoomCrop' => 'C' ),
                                            'half2' =>  array('width' => 370,'height' => 370, 'zoomCrop' => 'C' ),
                                            'medium' => array('width' => 270,'height' => 135, 'zoomCrop' => 'C' ), 
                                            'medium2' => array('width' => 270,'height' => 270, 'zoomCrop' => 'C' ), 
                                            'large' => array('width' => 770,'height' => 385, 'zoomCrop' => 'C' ), 
                                            'facebook' => array('width' => 200,'height' => 200, 'zoomCrop' => 'C' )     
                                        )                   
                ),

                'image_5' => array(
                    'thumbsizes' => array(
                                            'small' => array('width' => 100,'height' => 100, 'zoomCrop' => 'C' ),
                                            'half' =>  array('width' => 370,'height' => 185, 'zoomCrop' => 'C' ),
                                            'half2' =>  array('width' => 370,'height' => 370, 'zoomCrop' => 'C' ),
                                            'medium' => array('width' => 270,'height' => 135, 'zoomCrop' => 'C' ), 
                                            'medium2' => array('width' => 270,'height' => 270, 'zoomCrop' => 'C' ), 
                                            'large' => array('width' => 770,'height' => 385, 'zoomCrop' => 'C' ), 
                                            'facebook' => array('width' => 200,'height' => 200, 'zoomCrop' => 'C' ) 
                                        )                  
                ),
                
                'image_6' => array(
                    'thumbsizes' => array(
                                            'small' => array('width' => 100,'height' => 100, 'zoomCrop' => 'C' ),
                                            'half' =>  array('width' => 370,'height' => 185, 'zoomCrop' => 'C' ),
                                            'half2' =>  array('width' => 370,'height' => 370, 'zoomCrop' => 'C' ),
                                            'medium' => array('width' => 270,'height' => 135, 'zoomCrop' => 'C' ), 
                                            'medium2' => array('width' => 270,'height' => 270, 'zoomCrop' => 'C' ), 
                                            'large' => array('width' => 770,'height' => 385, 'zoomCrop' => 'C' ), 
                                            'facebook' => array('width' => 200,'height' => 200, 'zoomCrop' => 'C' )     
                                        )                  
                )                
                
                ) ); 
    
   

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'slug' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		
		'post_category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'post_author_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'publish_state_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'image_1' => array(
			'Empty' => array(
				'check' => false,
			),
		),              
		'image_2' => array(
			'Empty' => array(
				'check' => false,
			),
		),   
		'image_3' => array(
			'Empty' => array(
				'check' => false,
			),
		), 
		'image_4' => array(
			'Empty' => array(
				'check' => false,
			),
		),              
		'image_5' => array(
			'Empty' => array(
				'check' => false,
			),
		),   
		'image_6' => array(
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
		
		'RelatedBusinessType' => array(
			'className' => 'BusinessType',
			'foreignKey' => 'related_business_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Province' => array(
			'className' => 'Province',
			'foreignKey' => 'province_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PostCategory' => array(
			'className' => 'PostCategory',
			'foreignKey' => 'post_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PostAuthor' => array(
			'className' => 'PostAuthor',
			'foreignKey' => 'post_author_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Venue' => array(
			'className' => 'Venue',
			'foreignKey' => 'venue_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PublishState' => array(
			'className' => 'PublishState',
			'foreignKey' => 'publish_state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Map' => array(
			'className' => 'Map',
			'foreignKey' => 'map_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)            
	);

/**
 * hasMany associations
 *
 * @var array
 */


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'PostTag' => array(
			'className' => 'PostTag',
			'joinTable' => 'posts_post_tags',
			'foreignKey' => 'post_id',
			'associationForeignKey' => 'post_tag_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
