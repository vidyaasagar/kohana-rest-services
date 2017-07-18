<?php

class Controller_User extends Controller_REST{
    
    protected $_rest;
    protected $_auth_type = RestUser::AUTH_TYPE_APIKEY;
    protected $_auth_source = RestUser::AUTH_SOURCE_GET;
    /**
	 * Initialize the example model.
	 */
	public function before()
	{
		parent::before();
		$this->_rest = Model_RestAPI::factory('SignupModel', $this->_user);
	}
    public function action_index()
    {
        try
		{
            if($this->_user->is_a('admin'))
            $this->rest_output( $this->_user->getUsers() );
            else
				$this->rest_output( $this->_user->getUser() );
		}
		catch (Kohana_HTTP_Exception $khe)
		{
			$this->_error($khe);
			return;
		}
		catch (Kohana_Exception $e)
		{
			$this->_error('An internal error has occurred', 500);
			throw $e;
		}
		
    }
	public function action_update()
    {
        try
		{
            if($this->_user->is_a('admin'))
            $this->rest_output( $this->_user->updateUser($this->_params['email']) );
            else
				$this->rest_output( $this->_user->updateUser() );
		}
		catch (Kohana_HTTP_Exception $khe)
		{
			$this->_error($khe);
			return;
		}
		catch (Kohana_Exception $e)
		{
			$this->_error('An internal error has occurred', 500);
			throw $e;
		}
		
    }
	
}
