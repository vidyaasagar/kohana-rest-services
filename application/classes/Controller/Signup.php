<?php

class Controller_Signup extends Controller_REST{
    
    protected $_rest;

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
    $this->rest_output(array(
            'message' => 'working',
    ));
    }
    public function action_create(){
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
}