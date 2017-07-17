<?php

class RestUser  extends Kohana_RestUser{
    protected $userData;

    protected function _find(){
        $api_key = ORM::factory('APIKeys')
		->where('token', '=', $this->_api_key)
		->find();
		if ($api_key->loaded())
		{
			$this->_id = $api_key->user_id;
            $this->_roles = array();
            $login_role = ORM::factory('role', array('name' => 'login'));
            $admin_role = ORM::factory('role', array('name' => 'admin'));
            $user = ORM::factory('user', array('id' => $api_key->user_id));
            //$user->username='admin1';
            //$user->save();
            if($user->has('roles',$login_role)){
               array_push($this->_roles,'login');
            }
            if($user->has('roles',$admin_role)){
                 array_push($this->_roles,'admin');
            }
            $this->userData=array(
						'username'=>$user->username,
						'email'=>$user->email,
                        'loginRole'=>$this->is_a('login'),
                        'adminRole'=>$this->is_a('admin'),
					);

            
		}
		else
		{
			$this->_id = NULL;
		}

    }
    public function getUser(){
       
		return $this->userData;
    }
    public function getUsers()
    {
        if($this->is_a('admin')){
            $user = ORM::factory('user');
            $users = $user->find_all();
            $data=array();
            $i=0;
            foreach ($users as $key => $value) {
                # code...
                $data[$i]['username']=$value->username;
                $data[$i]['email']=$value->email;
                $i++;
            }
            return $data;
        }else{
            return array('error'=>'unauthorized');
        }

    }
}