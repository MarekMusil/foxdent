<?php

namespace App\Controllers\ContactData;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Log\LogModel;

use App\Helpers\PaginationHelper;
use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;
use App\Models\ContactData\ContactDataModel;
use CodeIgniter\HTTP\Client;


class ContactDataController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); 
    }
    
    public function __destruct()
    {
       exit;
    }

    public function get()
    {
        $__contactData = new ContactDataModel; 
        $contactData = $__contactData->getRecord();
        $data['contactData'] = $contactData;
        return $this->respond($data, 200, lang('Response.200'));
    }

    public function update()
    {
        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'contactDataEmail1'     => 'permit_empty|max_length[200]',
            'contactDataEmail2'     => 'permit_empty|max_length[200]',
            'contactDataPhone1'     => 'permit_empty|max_length[20]',
            'contactDataPhone2'     => 'permit_empty|max_length[20]',
            'contactDataFacebook'   => 'permit_empty|max_length[255]',
            'contactDataInstagram'  => 'permit_empty|max_length[255]',
            'contactDataAddress'    => 'permit_empty',

        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors']=$errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        $contactDataData = [
            'email_1'      => $inputData['contactDataEmail1'],
            'email_2'      => $inputData['contactDataEmail2'],
            'phone_1'      => $inputData['contactDataPhone1'],
            'phone_2'      => $inputData['contactDataPhone2'],
            'fb'      => $inputData['contactDataFacebook'],
            'ig'      => $inputData['contactDataInstagram'],
            'office_hours_stomatology'      => htmlspecialchars($inputData['contactDataOfficeHoursStomatology']),
            'office_hours_dental_hygiene'      => htmlspecialchars($inputData['contactDataOfficeHoursDentalHygiene']),
            'address'      => htmlspecialchars($inputData['contactDataAddress']),
        ];

        $__contactData = new ContactDataModel;
        $__contactData->setData($contactDataData);
        if ($__contactData->updateRecord() === FALSE)
        {
            return $this->respond(NULL, 500, lang('Response.500'));
        }

        return $this->respond(null, 200, lang('Response.200'));
    }
}