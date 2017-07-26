<?php

class Model_RestUserSignup extends Model_RestAPI {

    public function create($params)
	{
		// Enforce and validate some parameters.
		if (!isset($params['username']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing name'),
				'field' => 'username',
			));
		}
		if (!Valid::min_length($params['username'], 2) || !Valid::alpha_numeric($params['username']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('The name must contain at least 2 characters and have alpha-numeric characters only'),
				'field' => 'username',
			));
		}
        // Enforce and validate some parameters.
		if (!isset($params['password']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing name'),
				'field' => 'password',
			));
		}
		if (!Valid::min_length($params['password'], 5))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('The name must contain at least 2 characters and have alpha-numeric characters only'),
				'field' => 'password',
			));
		}
        if (!isset($params['email']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing name'),
				'field' => 'email',
			));
		}
		// Process the request and create a new object.
        $user = ORM::factory('user');
        $user->username = $params['username'];
        $user->password = $params['password']; 
        $user->email = $params['email']; 
        try
        {       
            if($user->save())
            {
                $user->add('roles', ORM::factory('role', array('name' => 'login')));
                //creating api Token
                 $api_token = ORM::factory('APITokens');
                 do
                {
                    $token = sha1(uniqid(Text::random('alnum', 32), TRUE));
                }
                while (ORM::factory('APITokens', array('token' => $token))->loaded());
                $api_token->user_id = $user->id;
                $api_token->token = $token;
                $api_token->save();
                // Returning a mock object.
                return array(
                    'user' => array('id' => $user->id, 'name' => $params['username'],'apikey'=>$token),
                );
            }else{
                throw HTTP_Exception::factory(400, array(
                    'error' => __('Unable to store data '),
                    'field' => '',
                ));
            }
        }
        catch (ORM_Validation_Exception $e)
        {
            $errors = $e->errors();
            return $errors;
            
        }
        
		
	}

    public function login()
    {
        if (!isset($params['username']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing name'),
				'field' => 'username',
			));
		}
        if (!isset($params['password']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing name'),
				'field' => 'password',
			));
		}
        //to generate token
        $remember= TRUE;

        $flag = Auth::instance()->login($params['username'],$params['password'],$remember);
        if($flag)
        {
            return array(
                'message'=>'Success',
                'code'=>200
            );
        }
        else
        {
            return array(
                'message'=>'Invalid Username or password',
                'code'=>401
            );
        }
    }

}
