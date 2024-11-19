<?php

namespace App\Models\ContactData;

use CodeIgniter\Model;
use App\Models\System\SystemUpdateModel;
use App\Helpers\CustomHelper;

class ContactDataModel extends Model
{   
    private $data = NULL;
    protected $table = 'contact_data';

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function updateRecord()
    { 
        $this->db->transStart();
        $this->data['update_time'] = date('Y-m-d H:i:s');

        $builder = $this->db->table($this->table);
        $builder->update($this->data);

        $__systemUpdate = new SystemUpdateModel;
        $__systemUpdate->updateRecord();

        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE; 
    }

    public function getRecord()
    {
        $contactData = [];
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->limit(1);
        $q = $builder->get()->getResultArray()[0];

        $phone1Format = CustomHelper::processPhoneNumber($q['phone_1']);
        $phone2Format = CustomHelper::processPhoneNumber($q['phone_2']);

        $contactData = [
            'id' => (int)$q['id'],
            'email1' => $q['email_1'],
            'email2' => $q['email_2'],
            'phone1Format' => $q['phone_1'],
            'phone1' => $phone1Format,
            'phone2Format' => $q['phone_2'],
            'phone2' => $phone2Format,
            'facebook' => $q['fb'],
            'instagram' => $q['ig'],
            'address' => htmlspecialchars_decode($q['address']),
            'officeHours' => [
                'stomatology' => htmlspecialchars_decode($q['office_hours_stomatology']),
                'dentalHygiene' => htmlspecialchars_decode($q['office_hours_dental_hygiene']),
            ],
        ];
        return $contactData;
    }
}