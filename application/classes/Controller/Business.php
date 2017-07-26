<?php
class Controller_Business extends Controller_REST{
    
    protected $_rest;
    /**
	 * Initialize the example model.
	 */
	public function before()
	{
		parent::before();
		$this->_rest = Model_RestAPI::factory('RestBusiness', $this->_user);
	}
    //get all bussiness
    public function action_index()
    {
        if(isset($this->_params['search']))
        {
            $business = ORM::factory('business')
            ->where('name', 'like', '%'.$this->_params['search'].'%')
		    ->find_all();
        }
        else{
            $business = ORM::factory('business')
		    ->find_all();
        }
        
        $array_data=array();
        $i=0;
        foreach ($business as $key => $value) {
            # code...
            $array_data[$i]['name']=$value->name;
            $array_data[$i]['description']=$value->description;
            $array_data[$i]['location']=$value->location;
            $i++;

        }
    	$this->rest_output( $array_data );
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