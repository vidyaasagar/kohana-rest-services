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
				http://localhost/rest_services_kohana/index.php/v1/main?main=business&search=m
				For searching based on business name
				http://localhost/rest_services_kohana/index.php/v1/main?main=business
				To Get all business
				http://localhost/rest_services_kohana/index.php/v1/main?main=business&name=Microsoft&description=S/w Company&location=hyderabad
				To create a business
				http://localhost/rest_services_kohana/index.php/v1/main?main=business&name=TCS&description=S/w Company&location=hyderabad&code=TCS
				To create a customer
				http://localhost/rest_services_kohana/index.php/v1/main?main=staff&name=Gireesh&phone_no=9700297966&email=ggg@l.com&business_id=1
				To create a staff
				http://localhost/rest_services_kohana/index.php/v1/main?main=customer&code=MS
				To get all customers based on business code
				http://localhost/rest_services_kohana/index.php/v1/main?main=customer&id=1
				To get all customers based on business id
				http://localhost/rest_services_kohana/index.php/v1/main?main=customer&check_customer=1&id=1
				to check whether a customer is of particular business based on id of business
				http://localhost/rest_services_kohana/index.php/v1/main?main=customer&check_customer=1&code=MS
				to check whether a customer is of particular business based on code of business 
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
    http://localhost/rest_services_kohana/index.php/v1/business?name=MIcrosoft&description=Big Company&location=Hyderabad
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