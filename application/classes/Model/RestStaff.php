<?php

class Model_RestStaff extends Model_RestAPI {

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
            if (!Valid::min_length($params['name'], 2))
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
            $staff = ORM::factory('staff');
            $staff->name = $params['name'];
            $staff->email = $params['email']; 
            $staff->phone_no = $params['phone_no'];
            $staff->business_id = $params['business_id']; 
            try
            {       
                if($staff->save())
                {
                
                    // Returning a mock object.
                    return array(
                        'staff' => array('id' => $staff->id, 'name' => $staff->name),
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
        $staff = ORM::factory('staff')
		->where('id', '=', $params['id'])
		->find();
		if ($staff->loaded())
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
                    $staff->business_id=$params['business_id'];
                }
                if($update_name)
                {
                    $staff->name=$params['name'];
                }
                if($update_email)
                {
                    $staff->email=$params['email'];
                }
                if($update_phone_no)
                {
                    $staff->phone_no=$params['phone_no'];
                }
                //now save data
                try
                {       
                    if($staff->save())
                    {
                        
                        return array(
                            'staff' => array('id' => $staff->id, 'name' => $staff->name,'message'=>'successfully updated'),
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
        // Find out if a particular person is a staff in a business
        //http://localhost/rest_services_kohana/index.php/v1/staff?id=1&check_staff=2
        if(isset($params['check_staff']))
        {
            $staff = ORM::factory('staff')
            ->where('business_id', '=', $params['id'])
            ->where('id', '=', $params['check_staff'])
            ->find();
            if ($staff->loaded())
            {
                if($staff->business_id==$params['id'])
                return array('message'=>$staff->name.' Is a staff');
            }
            else{
                return array('message'=>'Invalid staff ID/Bussiness ID/not a staff');
            }

        }
        $business = ORM::factory('staff')
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