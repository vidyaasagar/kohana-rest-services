<?php

class Model_RestCustomer extends Model_RestAPI {

       public function create($params)
        {
            // Enforce and validate some parameters.
            if (!isset($params['business_id']))
            {
                throw HTTP_Exception::factory(400, array(
                    'error' => __('Missing name'),
                    'field' => 'business_id',
                ));
            }
            //checking if it is valid business id
            $business = ORM::factory('business')
            ->where('id', '=', $params['business_id'])
            ->find();
            if (!$business->loaded())
            {
                throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid Business ID'),
				'field' => 'business_id',
			    ));
            }
            
            
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
            if (!isset($params['email']))
            {
                throw HTTP_Exception::factory(400, array(
                    'error' => __('Missing email'),
                    'field' => 'email',
                ));
            }
            if (!isset($params['phone_no']))
            {
                throw HTTP_Exception::factory(400, array(
                    'error' => __('Missing phone_no'),
                    'field' => 'phone_no',
                ));
            }
            // Process the request and create a new object.
            $customer = ORM::factory('customer');
            $customer->name = $params['name'];
            $customer->email = $params['email']; 
            $customer->phone_no = $params['phone_no'];
            $customer->business_id = $params['business_id']; 
            try
            {       
                if($customer->save())
                {
                
                    // Returning a mock object.
                    return array(
                        'customer' => array('id' => $customer->id, 'name' => $customer->name),
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
        $update_email=FALSE;
        $update_phone_no=FALSE;
        $update_business_id=FALSE;
        $data_update=FALSE;
		if (!isset($params['id']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing ID'),
				'field' => 'ID',
			));
		}
        $customer = ORM::factory('customer')
		->where('id', '=', $params['id'])
		->find();
		if ($customer->loaded())
		{
                if (isset($params['name']))
                {
                    $data_update=TRUE;
                    $update_name=TRUE;
                }
                if (isset($params['email']))
                {
                    $data_update=TRUE;
                    $update_email=TRUE;
                }
                if (isset($params['phone_no']))
                {
                    $data_update=TRUE;
                    $update_phone_no=TRUE;
                }
                if (isset($params['business_id']))
                {
                    $data_update=TRUE;
                    $update_business_id=TRUE;
                }
                if($data_update==FALSE)
                {
                    throw HTTP_Exception::factory(400, array(
                            'error' => __('No data to update '),
                            'field' => '',
                        ));
                }
                if($update_business_id)
                {
                    //checking if it is valid business id
                    $business = ORM::factory('business')
                    ->where('id', '=', $params['business_id'])
                    ->find();
                    if (!$business->loaded())
                    {
                        throw HTTP_Exception::factory(400, array(
                        'error' => __('Invalid Business ID'),
                        'field' => 'business_id',
                        ));
                    }
                    $customer->business_id=$params['business_id'];
                }
                if($update_name)
                {
                    $customer->name=$params['name'];
                }
                if($update_email)
                {
                    $customer->email=$params['email'];
                }
                if($update_phone_no)
                {
                    $customer->phone_no=$params['phone_no'];
                }
                //now save data
                try
                {       
                    if($customer->save())
                    {
                        
                        return array(
                            'customer' => array('id' => $customer->id, 'name' => $customer->name,'message'=>'successfully updated'),
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
        if (!isset($params['id']))
		{
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing Business ID'),
				'field' => 'ID',
			));
		}
        // Find out if a particular person is a customer in a business
        //http://localhost/kohana_rest_services/index.php/v1/customer?id=1&check_customer=1
        if(isset($params['check_customer']))
        {
            $customer = ORM::factory('customer')
            ->where('business_id', '=', $params['id'])
            ->where('id', '=', $params['check_customer'])
            ->find();
            if ($customer->loaded())
            {
                if($customer->business_id==$params['id'])
                return array('message'=>$customer->name.' Is a customer');
            }
            else{
                return array('message'=>'Invalid customer ID/Bussiness ID/not a customer');
            }

        }
        $business = ORM::factory('customer')
        ->where('business_id', '=', $params['id'])
		->find_all();
        $array_data=array();
        $i=0;
        foreach ($business as $key => $value) {
            # code...
            $array_data[$i]['name']=$value->name;
            $array_data[$i]['email']=$value->email;
            $array_data[$i]['phone_no']=$value->phone_no;
            $i++;

        }
        return $array_data;
    }

}