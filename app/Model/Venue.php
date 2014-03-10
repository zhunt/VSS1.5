<?php
App::uses('AppModel', 'Model');
/**
 * Venue Model
 *
 * @property City $City
 * @property Province $Province
 * @property BusinessType1 $BusinessType1
 * @property BusinessType2 $BusinessType2
 * @property Chain $Chain
 * @property PublishState $PublishState
 * @property VenueFeature $VenueFeature
 */
class Venue extends AppModel {
    

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';
        
    var $virtualFields = array(
        'full_name' => 'CONCAT(Venue.name, " ", Venue.sub_name)'
    );
        
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
			'isUnique' => array(
				'rule' => array('isUnique'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'address' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'city' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
		
		'business_type_1_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'seo_title' => array(
			'seo_title_r1' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'seo_title_r2' => array(
                            'rule' => array('maxLength', 140),
                            'message' => 'SEO title must be less than 140 chars.'
                        )
		),
		'seo_desc' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
                'city_region_id' => array( 'rule' => 'numeric', 'allowEmpty' => true ),
                'city_neighbourhood_id' => array( 'rule' => 'numeric', 'allowEmpty' => true ),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Region' => array(
			'className' => 'Region',
			'foreignKey' => 'region_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
                        'counterCache' => true,
                        'counterScope' => array('Venue.publish_state_id' => VENUE_PUBLISHED )
		),
		'CityRegion' => array(
			'className' => 'CityRegion',
			'foreignKey' => 'city_region_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CityNeighbourhood' => array(
			'className' => 'CityNeighbourhood',
			'foreignKey' => 'city_neighbourhood_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Intersection' => array(
			'className' => 'Intersection',
			'foreignKey' => 'intersection_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'Intersection.name'
		),
		'Province' => array(
			'className' => 'Province',
			'foreignKey' => 'province_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BusinessType1' => array(
			'className' => 'BusinessType',
			'foreignKey' => 'business_type_1_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BusinessType2' => array(
			'className' => 'BusinessType',
			'foreignKey' => 'business_type_2_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BusinessType3' => array(
			'className' => 'BusinessType',
			'foreignKey' => 'business_type_3_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),            
		'Chain' => array(
			'className' => 'Chain',
			'foreignKey' => 'chain_id',
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
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'VenueFeature' => array(
			'className' => 'VenueFeature',
			'joinTable' => 'venues_venue_features',
			'foreignKey' => 'venue_id',
			'associationForeignKey' => 'venue_feature_id',
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

/**
 * hasOne associations
 *
 * @var array
 */        
        var $hasOne = array(
            'VenueDetail' => array(
                'className' => 'VenueDetail',
                'foreignKey' => 'venue_id',
                'dependent' => true

            )
        );       

        
// =============================================================================
    /* based on the latt/long passed in, get a list of venues a distance from that point
     * fucntion returns distance in Km
     */
    function getNearbyVenues( $lat, $lng, $venueId = null) {
            $distance = 10; // 1 = 1000 metres, 10 = 10km 
            $limit = 10;

            $venueLat = floatval($lat);
            $venueLng = floatval($lng);

            $result = $this->find('all',
                    array('fields' => array(
                        'Venue.id', 'Venue.name', 'Venue.sub_name', 'Venue.slug',
                            'Venue.address', 'Venue.geo_lat',
                            'Venue.geo_lng',
                        '(6371 * acos( cos( radians(' . $venueLat . ') ) * cos( radians( geo_lat ) ) *
                                cos( radians( geo_lng ) - radians('. $venueLng .') ) + sin( radians(' . $venueLat . ') ) *
                                sin( radians( geo_lat ) ) ) ) AS distance'

                    ),
                    'conditions' => array(
                        'Venue.publish_state_id' => VENUE_PUBLISHED,
                        'Venue.id !=' => $venueId
                        ),
                    'group' => array( "Venue.id HAVING distance <= $distance"),
                    'order' => 'distance',
                    'limit' => $limit,
                    'contain' => array('City.name', 'CityRegion.name',  'CityNeighbourhood.name', 'BusinessType1.name' ) // 'VenueType.name', 'VenueSubtype.name'
                    ) );

                   //debug($result); exit;
            if ($result) {
                    return($result);
            } else {
                    return false;
            }
    }
	
    /* based on the latt/long passed in, get a list of venues and their city_region and intersection
     * fucntion returns distance in Km
	 * Used when adding new venue to guess the nearest intersection / city_region / neighbourhood
     */
    function getNearbyVenueIntersection( $lat, $lng, $venueId = null) {
            $distance = 10; // 1 = 1000 metres, 10 = 10km 
            $limit = 10;

            $venueLat = floatval($lat);
            $venueLng = floatval($lng);

            $result = $this->find('all',
                    array('fields' => array(
                        'Venue.id', 'Venue.name', 'Venue.slug',
                            'Venue.address', 'Venue.geo_lat',
                            'Venue.geo_lng',
                        '(6371 * acos( cos( radians(' . $venueLat . ') ) * cos( radians( geo_lat ) ) *
                                cos( radians( geo_lng ) - radians('. $venueLng .') ) + sin( radians(' . $venueLat . ') ) *
                                sin( radians( geo_lat ) ) ) ) AS distance'

                    ),
                    'conditions' => array(
                        'Venue.publish_state_id' => VENUE_PUBLISHED,
                        'Venue.id !=' => $venueId
                        ),
                    'group' => array( "Venue.id HAVING distance <= $distance"),
                    'order' => 'distance',
                    'limit' => $limit,
                    'contain' => array('City.name', 'CityRegion.name',  'CityNeighbourhood.name', 'Intersection.name' )
                    ) );

                   //debug($result); exit;
            if ($result) {
                    return($result);
            } else {
                    return false;
            }
    }

    // source: http://www.amityadav.name/cakephp-paginate-count-with-group-by/
    public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		$parameters = compact('conditions', 'recursive');
 
		if (isset($extra['group'])) {
			$parameters['fields'] = $extra['group'];
 
			if (is_string($parameters['fields'])) {
				// pagination with single GROUP BY field
				if (substr($parameters['fields'], 0, 9) != 'DISTINCT ') {
					$parameters['fields'] = 'DISTINCT ' . $parameters['fields'];
				}
				unset($extra['group']);
				$count = $this->find('count', array_merge($parameters, $extra));
			} else {
				// resort to inefficient method for multiple GROUP BY fields
				$count = $this->find('count', array_merge($parameters, $extra));
				$count = $this->getAffectedRows();
			}
		} else {
			// regular pagination
			$count = $this->find('count', array_merge($parameters, $extra));
		}
		return $count;
	}
    
        
}
