<?php  
/**
* UsersController
*/
class UsersController extends AppController {
		public $uses = array('User');
		public function beforeFilter(){
			parent::beforeFilter();
			$this->autoRender = false;
		}

		function login() {
			$data = $this->request->input('json_decode',true);
			if(isset($data['app_token']) && $data['app_token'] == "c4d959bbc0dd4332affc1b83539cd72d") {
				unset($data['app_token']);
				$datas = $this->User->find('count',array(
						'fields' => array('User.email','User.password'),
						'conditions' => array(
							'User.email' => $data['User']['email'],
							'User.password' => AuthComponent::password($data['User']['password'])
						),
						'limit' => 1
					)
				);
				if($this->User->validates() && $data){
					return $this->apiResult(array("error" => false,"message" => "Successfully Logged-in"));
				}
				else{
					$errors = $this->User->validationErrors;
					return $this->apiResult(array("error" => true,"message" => $errors));
				}
			}
			else{
				return $this->apiResult(array("error" => true,"message" => "Api token error"));
			}
		}


		function register() {
			$data = $this->request->input('json_decode',true);
			if(isset($data['app_token']) && $data['app_token'] == "c4d959bbc0dd4332affc1b83539cd72d") {
				unset($data['app_token']);
				$this->User->set($data);
				if($this->User->save()){
					return $this->apiResult(array("error" => false,"message" => "Successfully Registered"));
				}
				else{
					$errors = $this->User->validationErrors;
					return $this->apiResult(array("error" => true,"message" => $errors));
				}
			}
			else{
				return $this->apiResult(array("error" => true,"message" => "Api token error"));
			}
		}
}
?>