<?php

class RestUser extends Kohana_RestUser {
	protected $name='';

	protected function _find()
	{
		//generally these are stored in databases 
		$api_keys=array('abc','123','testkey');
		
		$users['abc']['name']='Sam';
		$users['abc']['roles']=array('admin','login');

		$users['123']['name']='John';
		$users['123']['roles']=array('login');
        
		$users['testkey']['name']='';
		$users['testkey']['roles']=array('login');

		foreach ($api_keys as $key => $value) {
			if($value==$this->_api_key){
				//the key is validated which is authorized key
				$this->_id = $key;//if this not null then controller thinks it is validated
				//$this->_id must be set if key is valid.
				//setting name
				$this->name = $users[$value];
				$this->_roles = $users[$value]['roles']; 
				break;

			}
		}

		



		/*$api_key = ORM::factory('APITokens')
		->where('token', '=', $this->_api_key)
		->find();
		if ($api_key->loaded())
		{
			$this->_id = $api_key->user_id;
			$this->_roles = array('login');
		}
		else
		{
			$this->_id = NULL;
		}*/
		

	}
	public function get_user_id()
	{
		return $this->_id;
	}
	public function get_name()
	{
		return $this->name;
	}
}