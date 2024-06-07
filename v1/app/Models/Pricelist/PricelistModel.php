<?php

namespace App\Models\Pricelist;

use App\Models\System\SystemUpdateModel;
use CodeIgniter\Model;
use DateTime;
helper('filesystem');
helper('file');
//use App\Helpers\CustomHelper;

class PricelistModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function __destruct()
    {
        
    }

    private $accessRules = FALSE;
    private $active = NULL;
    private $appType = NULL;
    private $pricelistId = NULL;
    private $pricelistsId = NULL;
    private $data = NULL;
    private $debugMode = FALSE;
    private $format = NULL;
    private $onlyCount = FALSE;
    private $pageLimit = 10;
    private $pageNumber = 1;
    private $searchQuery = NULL;
    private $sortBy = 'id';
    private $sortOrder = 'ASC';
    protected $sortByOptions = ['id', 'rank'];
    protected $sortOrderOptions = ['ASC', 'DESC'];
    protected $table = 'pricelist';

    public function getPageLimit()
    {
        return $this->pageLimit;
    }
    
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    public function setActive($bool)
    {
        $this->active = $bool;
    }

    public function setAppType($bool)
    {
        $this->appType = $bool;
    }

    public function setPricelistId($pricelistId)
    {
        $this->pricelistId = $pricelistId;
    }

    public function setPricelistsId($pricelistsId)
    {
        $this->pricelistsId = $pricelistsId;
    }
    
    public function setData($data)
    {
        $this->data = $data;
    }
    
    public function setDebugMode($bool)
    {
        $this->debugMode = $bool;
    }
    
    public function setFormat($format)
    {
        $this->format = $format;
    }
    
    public function setOnlyCount($bool)
    {
        $this->onlyCount = $bool;
    }
    
    public function setPageLimit($pageLimit)
    {
        $this->pageLimit = $pageLimit;
    }
    
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = $pageNumber;
    }
    
    public function setSearchQuery($searchQuery)
    {
        $this->searchQuery = $searchQuery;
    }
    
    public function setSortBy($by)
    {
        if (in_array($by, $this->sortByOptions))
        {
            $this->sortBy = $by;
        }
    }
    
    public function setSortOrder($order)
    {
        if (in_array($order, $this->sortOrderOptions))
        {
            $this->sortOrder = $order;
        }
    }
    
    public function existsId($pricelistId)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('id', $pricelistId);
        $q = $builder->get()->getResult();

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }
        
        if (count($q) == 1)
        {
            return TRUE;
        }
        
        return FALSE;        
    }

    public function getRecord()
    {
        $builder = $this->db->table($this->table);
        $pricelists = [];

        if ($this->onlyCount === FALSE)
        {
            $builder->select('*');            
        }
        else
        {
            $builder->select('COUNT(id) AS count');
        }        

        if (!is_null($this->pricelistId))  
        {
            $builder->where('id', $this->pricelistId);
        }

        if (!is_null($this->pricelistsId))  
        {
            $builder->whereIn('id', $this->pricelistsId);
        }

        if (!is_null($this->searchQuery))
        {
            $builder->like('name', $this->searchQuery);
        }

        if (!is_null($this->active))
        {
            $builder->where('active', $this->active);
        }

        if ($this->accessRules === TRUE && !is_null($this->pricelistsId))
        {
            $builder->whereIn('id', $this->pricelistsId);
        }

        if ($this->onlyCount === FALSE && !is_null($this->pageLimit))
        {
            $builder->limit($this->pageLimit, ($this->pageNumber * $this->pageLimit) - $this->pageLimit);
        }

        $builder->orderBy($this->sortBy, $this->sortOrder);    

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }

        $q = $builder->get()->getResult();

        if ($this->onlyCount === TRUE)
        {
            return $q[0]->count;
        }

        if (count($q) > 0)
        {
            if ($this->format === 'select-option')
            {
                foreach ($q as $row)
                {
                    $priceliste = [
                        'id' => (int)$row->id,
                        'name' => $row->name,
                        'shortname' => $row->shortname,
                    ];

                    $pricelists[$row->id] = $priceliste;
                }

                return $pricelists;
            }

            if ($this->format == 'only-id')
            {               
                foreach ($q as $row)
                {
                    $pricelists[] = $row->id;
                }

                return $pricelists;
            }

            foreach ($q as $i => $row)
            {
                $__createTime = new DateTime($row->create_time);
                $__updateTime = new DateTime($row->update_time);

                $pricelist = [
                    'id' => (int)$row->id,
                    'name' => $row->name,
                    'rank' => (int)$row->rank,
                    'price' => [
                        'value' => $row->price,
                    ],
                    'note' => $row->note,
                    'updateTime' => [
                        'format' => $__updateTime->format('d.m.Y H:i:s'),
                        'formatDate' => $__updateTime->format('d.m.Y'),
                        'formatShort' => $__updateTime->format('d.m.Y H:i'),
                        'formatSystem' => $__updateTime->format('Y-m-d\TH:i:s.v\Z')
                    ],
                    'createTime' => [
                        'format' => $__createTime->format('d.m.Y H:i:s'),
                        'formatDate' => $__createTime->format('d.m.Y'),
                        'formatShort' => $__createTime->format('d.m.Y H:i'),
                        'formatSystem' => $__createTime->format('Y-m-d\TH:i:s.v\Z')
                    ],          
                ];

                $pricelists[$row->id] = $pricelist;
            }

            if (!is_null($this->pricelistId) && array_key_exists($this->pricelistId, $pricelists))
            {
                return $pricelists[$this->pricelistId];
            }
        }        

        return $pricelists;
    }

    public function updateRecord()
    {
        $builder = $this->db->table($this->table);
        $today = date('Y-m-d H:i:s');
        $this->setPageLimit(NULL);
        $this->setFormat('only-id');
        $itemsInTable = $this->getRecord();
        $itemsToUpdate = [];
        $itemsToCreate = [];
        $itemsToRemove = $itemsInTable;

        foreach ($this->data as $key => $data)
        {
            if (!in_array($data['id'], $itemsInTable))
            {
                $itemsToCreate[] = [
                    'rank'      => $data['rank'],
                    'name'        => $data['name'],
                    'price'        => $data['price'],
                    'note'        => $data['note'],
                ];
            }
            else
            {
                $key = array_search($data['id'], $itemsToRemove);
    
                if ($key !== FALSE)
                {
                    unset($itemsToRemove[$key]);

                    $itemsToUpdate[] = [
                        'id'          => $data['id'],
                        'rank'      => $data['rank'],
                        'name'        => $data['name'],
                        'price'        => $data['price'],
                        'note'        => $data['note'],
                    ];
                } 
            }
        }
        if (!empty($itemsToCreate))
        {
            $builderCreate = $this->db->table($this->table);
            $builderCreate->insertBatch($itemsToCreate);
        }

        if (!empty($itemsToRemove))
        {
            $builderRemove = $this->db->table($this->table);
            $builderRemove->whereIn('id', $itemsToRemove);
            $builderRemove->delete();
        }

        if (!empty($itemsToUpdate))
        {
            $builder->updateBatch($itemsToUpdate, 'id');
        }
        
        $__systemUpdate = new SystemUpdateModel;
        $__systemUpdate->updateRecord();
        
        return TRUE;
    }
}