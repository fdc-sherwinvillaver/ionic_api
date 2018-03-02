<?php  
/**
* 
*/
class User extends AppModel{
	public $validate = array(
		'first_name' => array(
			'notEmpty' => array(
				'rule' => 'notBlank',
				'required' => true,
				'message' => 'Firstname must not be empty'
			),
			'length' => array(
				'rule' => array('maxLength',50),
				'message' => 'Firstname must not exceed 50 characters'
			)
		),
		'last_name' => array(
			'notEmpty' => array(
				'rule' => 'notBlank',
				'required' => true,
				'message' => 'Lastname must not be empty'
			),
			'length' => array(
				'rule' => array('maxLength',50),
				'message' => 'Lastname must not exceed 50 characters'
			)
		),
		'middle_name' => array(
			'notEmpty' => array(
				'rule' => 'notBlank',
				'required' => true,
				'message' => 'Middlename must not be empty'
			),
			'length' => array(
				'rule' => array('maxLength',50),
				'message' => 'Middlename must not exceed 50 characters'
			)
		),
		'email' => array(
			'notEmpty' => array(
				'rule' => 'notBlank',
				'required' => true,
				'message' => 'Email must not be empty'
			),
			'length' => array(
				'rule' => array('maxLength',50),
				'message' => 'Email must not exceed 50 characters'
			),
			'email' => array(
				'rule' => array('email', true),
				'message' => 'Please supply a valid email address'
			),
			'is_unique' => array(
				'rule' => 'isUnique',
				'required' => true,
				'message' => 'Email is already taken'
			)
		),
		'username' => array(
			'notEmpty' => array(
				'rule' => 'notBlank',
				'required' => true,
				'message' => 'Username must not be empty'
			),
			'length' => array(
				'rule' => array('maxLength',10),
				'message' => 'Username must not exceed 50 characters'
			),
			'is_unique' => array(
				'rule' => 'isUnique',
				'required' => true,
				'message' => 'Username is already taken'
			)
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => 'notBlank',
				'required' => true,
				'message' => 'Password must not be empty'
			),
			'length' => array(
				'rule' => array('minLength',8),
				'message' => 'Password must be 8 characters above'
			),
			'password_case' => array(
				'rule' => '((?=.*[A-Z])(?=.*[a-z]))',
				'message' => 'Password must have 1 uppercase and 1 lowercase'
			)
		),
		'confirm_password' => array(
			'confirm_notBlank' => array(
				'rule' => 'notBlank',
				'required' => true,
				'message' => 'Confirm password field must not be empty'
			),
			'same_password' => array(
				'rule' => array('validate_passwords'),
				'message' => 'Confirm password not match the password'
			)
		)
	);

	public function validate_passwords() {
	    return $this->data[$this->alias]['password'] === $this->data[$this->alias]['confirm_password'];
	}

	public function beforeSave($options = array()){
		if(isset($this->data[$this->alias]['password'])){
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
}
?>