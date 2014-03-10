<?php
App::uses('AppModel', 'Model');
/**
 * City Model
 *
 * @property Province $Province
 * @property ParentCity $ParentCity
 * @property Venue $Venue
 */
class City extends AppModel {
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
		'flag_show' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'province_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'parent_city_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => true,
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
		'Province' => array(
			'className' => 'Province',
			'foreignKey' => 'province_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ParentCity' => array(
			'className' => 'City',
			'foreignKey' => 'parent_city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'Region' => array('className' => 'Region')
	);

/**
 * hasMany associations
 *
 * @var array
 */
        
    var $hasMany = array(
        'CityNeighbourhood' => array(
            'className' => 'CityNeighbourhood',
            'foreignKey' => 'city_id',
            'dependent' => false,
           
        ),
        'CityRegion' => array(
            'className' => 'CityRegion',
            'foreignKey' => 'city_id',
            'dependent' => false,
            
        ),
        'Venue' => array(
            'className' => 'Venue',
            'foreignKey' => 'city_id',
            'dependent' => false   
        ),
        'Intersection' => array(
            'className' => 'Intersection',
            'foreignKey' => 'city_id',
            'dependent' => false,

        )
    );        
        
    /*
     * returns Id of city, adding city to table if nessassary
     * checking is done using Google's locality name
     */
    function updateCity($city, $regionId = null, $provinceId = null) {
        if ( empty($city)) return false;
        
        $this->Containable = false;
        $result = $this->findByLocality($city);

        if (!$result) {
            $this->create();
            $data = array('City' => array('name' => $city,
                                            'region_id' => $regionId ,
                                            'province_id' => $provinceId, 
                                            'locality' => $city) );
            $this->save($data);
            $cityId = $this->id;
        } else {
            $cityId = $result['City']['id'];
        }
        return($cityId);
    }        

}
