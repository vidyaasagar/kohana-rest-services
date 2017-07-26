<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Services extends Controller_Rest {

	public function action_index()
	{
		$this->response->body('hello, world!');
        
	}
    	/**
	 * Initialize the example model.
	 */
	public function before()
	{
		parent::before();
		$this->_rest = Model_RestAPI::factory('RestUserSignup', $this->_user);
	}
    /**
	 * Handle POST requests.
	 */
	public function action_create()
	{
		try
		{
			$this->rest_output( $this->_rest->create( $this->_params ) );
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

    public function action_login()
    {
        try
		{
			$this->rest_output( $this->_rest->login( $this->_params ) );
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

} // End Welcome
