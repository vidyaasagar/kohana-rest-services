<?php
class Controller_Main extends Controller_REST{
    
    protected $_rest;
    /**
	 * Initialize the example model.
	 */
	public function before()
	{
		parent::before();
		$this->_rest = Model_RestAPI::factory('RestBusiness', $this->_user);
	}
    		/*
				urls : 

				For searching based on business name
				http://localhost/kohana_rest_services/index.php/v1/main?main=business&search=m
				
				To Get all business
				http://localhost/kohana_rest_services/index.php/v1/main?main=business
				
				To create a business
				http://localhost/kohana_rest_services/index.php/v1/main?main=business&name=Microsoft&description=S/w Company&location=hyderabad
				
				To create a customer
				http://localhost/kohana_rest_services/index.php/v1/main?main=customer&name=sagar1&phone_no=2700297996&email=ggg@l.com&business_id=1
				
				To create a staff
				http://localhost/kohana_rest_services/index.php/v1/main?main=staff&name=sagar&phone_no=1700297996&email=ggg@l.com&business_id=1
				
				To get all customers based on business code
				http://localhost/kohana_rest_services/index.php/v1/main?main=customer&code=MS
				
				To get all customers based on business idTo get all customers based on business id
				http://localhost/kohana_rest_services/index.php/v1/main?main=customer&id=1
				
				to check whether a customer is of particular business based on id of business
				http://localhost/kohana_rest_services/index.php/v1/main?main=customer&check_customer=1&id=1
				
				to check whether a customer is of particular business based on code of business
				http://localhost/kohana_rest_services/index.php/v1/main?main=customer&check_customer=1&code=MS
				 
			*/
    public function action_index()
    {
        
    	try
		{
			$main = $this->_params['main'];
			$output=NULL;
			if($main=='business'){
			
			$model = new Model_RestBusiness();
			}
            else if($main=='business_id')
            {
			$model = new Model_RestBusiness();
			}
			
			else if($main=='customer')
			{
				$model = new Model_RestCustomer();
				
			}
			else if($main=='staff')
			{
				$model = new Model_RestStaff();
			}

			//render output
			$output = $model->getData($this->_params);
			$this->rest_output( $output );
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
    /*
    Method POST
    example Url :
    http://localhost/kohana_rest_services_/index.php/v1/business?name=MIcrosoft&description=S/w Company&location=Hyderabad
    returns 
    {"business":{"id":1,"name":"MIcrosoft"}}
    */
    public function action_create(){
        try
		{
			$main = $this->_params['main'];
			$output=NULL;
			if($main=='business'){
			
			$model = new Model_RestBusiness();
			
			}
            else if($main=='customer')
			{
				$model = new Model_RestCustomer();
			}
			else if($main=='staff')
			{
				$model = new Model_RestStaff();
			}
			$output = $model->create($this->_params);
			//render output
			$this->rest_output( $output );
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
	public function action_update(){
        try
		{
			$this->rest_output( $this->_rest->update( $this->_params) );
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