<?php

namespace App\Models\ImportantMessage;

use CodeIgniter\Model;
use App\Models\System\SystemUpdateModel;
use App\Helpers\CustomHelper;

class ImportantMessageModel extends Model
{   
    private $data = NULL;
    protected $table = 'important_messages';

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

        $contactData = [
            'id' => (int)$q['id'],
            'name' => $q['name'],
            'content' => htmlspecialchars_decode($q['content']),
            'isVisible' => (int)$q['is_visible']
        ];
        return $contactData;
    }
}