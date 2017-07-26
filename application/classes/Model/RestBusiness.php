<?php

class Model_RestBusiness extends Model_RestAPI {

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
		if (!Valid::min_length($params['name'], 2))
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
				'field' => 'description',
			));
		}
		if (!isset($params['location']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing location'),
				'field' => 'location',
			));
		}
        if (!isset($params['code']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing code'),
				'field' => 'code',
			));
		}
		// Process the request and create a new object.
        $business = ORM::factory('business');
        $business->name = $params['name'];
        $business->description = $params['description']; 
        $business->location = $params['location']; 
        $business->code = $params['code']; 
        try
        {       
            if($business->save())
            {
               
                // Returning a mock object.
                return array(
                    'business' => array('id' => $business->id, 'name' => $business->name, 'code' => $business->code),
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

   

    public function update($params)
    {
        // Enforce and validate some parameters.
        $update_name=FALSE;
        $update_description=FALSE;
        $update_location=FALSE;
        $data_update=FALSE;
		if (!isset($params['id']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing ID'),
				'field' => 'ID',
			));
		}
        $business = ORM::factory('business')
		->where('id', '=', $params['id'])
		->find();
		if ($business->loaded())
		{
                if (isset($params['name']))
                {
                    $data_update=TRUE;
                    $update_name=TRUE;
                }
                if (isset($params['description']))
                {
                    $data_update=TRUE;
                    $update_description=TRUE;
                }
                if (isset($params['location']))
                {
                    $data_update=TRUE;
                    $update_location=TRUE;
                }
                if($data_update===FALSE)
                {
                    throw HTTP_Exception::factory(400, array(
                            'error' => __('No data to update'),
                            'field' => '',
                        ));
                }
                if($update_name)
                {
                    $business->name=$params['name'];
                }
                if($update_description)
                {
                    $business->description=$params['description'];
                }
                if($update_location)
                {
                    $business->location=$params['location'];
                }
                //now save data
                try
                {       
                    if($business->save())
                    {
                        
                        return array(
                            'business' => array('id' => $business->id, 'name' => $business->name,
                             'location' => $business->location,
                            'description' => $business->description,
                            'message'=>'successfully updated'),
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
		else
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid ID'),
				'field' => 'ID',
			));
		}
        
    }

    public function getData($params)
    {
        //used for searching the business based on name
        if(isset($params['search']))
        {
            $business = ORM::factory('business')
            ->where('name', 'like', '%'.$params['search'].'%')
		    ->find_all();
        }
        else if(isset($params['id']))
        {
            $business = ORM::factory('business')
            ->where('id', '=', $params['id'])
		    ->find_all();
        }
        else{
            //to get all businesses
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
        return $array_data;
    }
    
}