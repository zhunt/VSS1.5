<?php
App::uses('AppModel', 'Model');
/**
 * Chain Model
 *
 * @property Venue $Venue
 */
class Chain extends AppModel {
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Venue' => array(
			'className' => 'Venue',
			'foreignKey' => 'chain_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
        
    /*
     * returns Id of chain, adding venue chain to table if nessassary
     */
    function updateChain($chain) {
        if ( empty($chain)) return false;
        //debug($neighbourhood);
        $this->Containable = false;
        $result = $this->findByName($chain);

        if (!$result) {
            $this->create();
            $data = array('Chain' => array('name' => $chain ) );
            //$this->containable = false;
            $this->save( $data);
            $id = $this->id;
        } else {
            $id = $result['Chain']['id'];
        }

        return($id);
    }
        

}
