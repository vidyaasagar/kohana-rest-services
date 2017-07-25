<?php
class Model_BusinessModel{

    public function create($params)
    {
        // Enforce and validate some parameters.
		if (!isset($params['name']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing name'),
				'field' => 'name',
			));
		}
		if (!Valid::min_length($params['name'], 2) || !Valid::alpha_numeric($params['name']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('The name must contain at least 2 characters and have alpha-numeric characters only'),
				'field' => 'name',
			));
		}
        // Enforce and validate some parameters.
		if (!isset($params['description']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing description'),
				'field' => 'password',
			));
		}
		if (!isset($params['location']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing location'),
				'field' => 'location',
			));
		}
		// Process the request and create a new object.
        $business = ORM::factory('business');
        $business->name = $params['name'];
        $business->description = $params['description']; 
        $business->location = $params['location']; 
        try
        {       
            if($business->save())
            {
               
                // Returning a mock object.
                return array(
                    'business' => array('id' => $business->id, 'name' => $business->'name'),
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
     
}