<?php

namespace App\Models\Page;

use CodeIgniter\Model;
use App\Models\System\SystemUpdateModel;
use DateTime;
use App\Helpers\CustomHelper;
helper('filesystem');
helper('file');
//use App\Helpers\CustomHelper;

class PageModel extends Model
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
    private $pageTranslationId = NULL;
    private $pageId = NULL;
    private $pagesId = NULL;
    private $data = NULL;
    private $debugMode = FALSE;
    private $localization = 'cs_CZ';
    private $format = NULL;
    private $onlyCount = FALSE;
    private $pageLimit = 10;
    private $pageNumber = 1;
    private $removed = NULL;
    private $searchQuery = NULL;
    private $sortBy = 'id';
    private $sortOrder = 'ASC';
    private $withRemoved = FALSE;
    protected $sortByOptions = ['pages_translations.id','pages.rank'];
    protected $sortOrderOptions = ['ASC', 'DESC'];
    protected $table = 'pages';
    protected $tblPageTrans = 'pages_translations';

    public function getPageLimit()
    {
        return $this->pageLimit;
    }
    
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    public function getPageId()
    {
        return $this->pageId;
    }

    public function setActive($bool)
    {
        $this->active = $bool;
    }

    public function setAppType($bool)
    {
        $this->appType = $bool;
    }

    public function setPageTranslationId($pageTranslationId)
    {
        $this->pageTranslationId = $pageTranslationId;
    }

    public function setPageId($pageId)
    {
        $this->pageId = $pageId;
    }

    public function setPagesId($pagesId)
    {
        $this->pagesId = $pagesId;
    }

    public function setLocalization($localization)
    {
        $this->localization = $localization;
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
    
    public function setRemoved($bool)
    {
        $this->removed = $bool;
    }
    
    public function setSearchQuery($searchQuery)
    {
        $this->searchQuery = $searchQuery;
    }
    
    public function setSortBy($by)
    {
        $this->sortBy = $by;
    }
    
    public function setSortOrder($order)
    {
        if (in_array($order, $this->sortOrderOptions))
        {
            $this->sortOrder = $order;
        }
    }

    public function setWithRemoved($bool)
    {
        $this->withRemoved = $bool;
    }
    
    public function existsId($pageId, $removed = 0)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('id', $pageId);
        $builder->where('removed', $removed);
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

    public function existsTransaltionForPage($pageId, $localization)
    {
        $builder = $this->db->table($this->tblPageTrans);
        $builder->select('id');
        $builder->where('page_id', $pageId);
        $builder->where('localization', $localization);
        $q = $builder->get()->getResult();

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }
        
        if (count($q) > 0)
        {
            return TRUE;
        }
        
        return FALSE;        
    }

    public function existsPageTranslationId($pageTranslationId, $removed = 0)
    {
        $builder = $this->db->table($this->tblPageTrans);
        $builder->select('id');
        $builder->where('id', $pageTranslationId);
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
        $pages = [];
        $servicePages = [];
        $technologyPages = [];
        $otherPages = [];

        if ($this->onlyCount === FALSE)
        {
            $builder->select('
                '.$this->table.'.id,
                '.$this->table.'.slug,
                '.$this->table.'.rank,
                '.$this->table.'.name,
                '.$this->table.'.active,
                '.$this->table.'.create_time,
                '.$this->table.'.update_time,
                '.$this->tblPageTrans.'.id AS translationPageId,
                '.$this->tblPageTrans.'.localization,
                '.$this->tblPageTrans.'.title,
                '.$this->tblPageTrans.'.meta_title,
                '.$this->tblPageTrans.'.meta_description,
                '.$this->tblPageTrans.'.meta_keywords,
            ');          
        }

        else
        {
            $builder->select('COUNT('.$this->table.'.id) AS count');
        } 
        
        if ($this->format == 'only-pages' || $this->format == 'only-id-for-pages')
        {
            $builder->join($this->tblPageTrans, $this->table . '.id = ' . $this->tblPageTrans . '.page_id', 'left');
        }
        else
        {
            $builder->join($this->tblPageTrans, $this->table . '.id = ' . $this->tblPageTrans . '.page_id');
        }
        
        if (!is_null($this->localization))
        {
            $builder->where($this->tblPageTrans.'.localization', $this->localization);
        }
        
        if (!is_null($this->pageTranslationId))  
        {
            $builder->where($this->tblPageTrans.'.id', $this->pageTranslationId);
        }

        if (!is_null($this->pageId))  
        {
            $builder->where($this->table.'.id', $this->pageId);
        }

        if (!is_null($this->pagesId))  
        {
            $builder->whereIn($this->table.'.id', $this->pagesId);
        }

        if (!is_null($this->searchQuery))
        {
            $builder->like($this->table.'.name', $this->searchQuery);
        }

        if (!is_null($this->active))
        {
            $builder->where($this->table.'.active', $this->active);
        }

        if ($this->accessRules === TRUE && !is_null($this->pagesId))
        {
            $builder->whereIn($this->table.'.id', $this->pagesId);
        }

        if (!is_null($this->removed))
        {
            $builder->where($this->table.'.removed', $this->removed);
        }
        else
        {
            if ($this->withRemoved === FALSE)
            {
                $builder->where($this->table.'.removed', 0);
            }
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
                    $page = [
                        'id' => (int)$row->id,
                        'name' => $row->name,   
                    ];

                    $pages[$row->id] = $page;
                }

                return $pages;
            }

            if ($this->format == 'only-id' || $this->format == 'only-id-for-pages')
            {         
                foreach ($q as $row)
                {
                    $pages[] = $row->id;
                }

                return $pages;
            }



            if ($this->format == 'only-pages')
            {          
                foreach ($q as $i => $row)
                {
                    $__createTime = new DateTime($row->create_time);
                    $__updateTime = new DateTime($row->update_time);
    
                    $page = [
                        'id' => (int)$row->id,
                        'rank' => (int)$row->rank,
                        'slug' => $row->slug,
                        'name' => $row->name,
                        'active' => [
                            'value' => (int)$row->active
                        ]       
                    ];

                    if (!is_null($row->translationPageId) && $row->localization == 'cs_CZ')
                    {
                        $page['linkForCrm'] = '/pages/texts/'.$row->translationPageId;
                    }
                    else
                    {
                        $page['linkForCrm'] = '/pages/texts/create/';
                    }
    
                    $pages[$row->id] = $page;
                }


                return $pages;
            }

            foreach ($q as $i => $row)
            {
                $__createTime = new DateTime($row->create_time);
                $__updateTime = new DateTime($row->update_time);

                $page = [
                    'id' => (int)$row->translationPageId,
                    'rank' => (int)$row->rank,
                    'slug' => $row->slug,
                    'pageId' => (int)$row->id,
                    'name' => $row->name,
                    'localization' => $row->localization,
                    'title' => $row->title,
                    'meta' => [
                        'title' => $row->meta_title,
                        'description' => $row->meta_description,
                        'keywords' => $row->meta_keywords
                    ],
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

                $pages[$row->translationPageId] = $page;
            }

            if (!is_null($this->pageTranslationId) && array_key_exists($this->pageTranslationId, $pages))
            {
                return $pages[$this->pageTranslationId];
            }
        }        

        return $pages;
    }

    public function createRecord()
    {
        $this->db->transStart();

        $builder = $this->db->table($this->tblPageTrans);

        if (!is_null($this->data))
        {
            $pages[]=$this->data;

            foreach ($pages as $i => $row)
            {
                $builder->insert($row);
                $this->pageId = $this->insertId();
            }
        }

        $__systemUpdate = new SystemUpdateModel;
        $__systemUpdate->updateRecord();
        
        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE;     
    }

    public function updateRecord()
    {
        $this->db->transStart();

        $builder = $this->db->table($this->tblPageTrans);

        if (!is_null($this->pageTranslationId))
        {
            $builder->where('id', $this->pageTranslationId);

            if (!is_null($this->data))
            {
                $builder->update($this->data);
            }
        }
        else
        {
            if (!is_null($this->data))
            {
                $builder->updateBatch($this->data, 'id');
            }
        }

        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE;   
    }

    public function updatePageRecord()
    {
        $this->db->transStart();

        $builder = $this->db->table($this->table);

        if (!is_null($this->pageId))
        {
            $builder->where('id', $this->pageId);

            if (!is_null($this->data))
            {
                $this->data['update_time'] = date('Y-m-d H:i:s');
                $builder->update($this->data);
            }
        }
        else
        {
            if (!is_null($this->data))
            {
                $builder->updateBatch($this->data, 'id');
            }
        }

        $__systemUpdate = new SystemUpdateModel;
        $__systemUpdate->updateRecord();

        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE;   
    }

    public function updatePageStructureRecord()
    {
        $builder = $this->db->table($this->table);
        $today = date('Y-m-d H:i:s');
        $this->setPageLimit(NULL);
        $this->setFormat('only-id-for-pages');
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
                    'active'        => $data['active'],
                    'slug'        => CustomHelper::createSlug($data['name']),
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
                        'active'        => $data['active'],
                        'slug'        => CustomHelper::createSlug($data['name']),
                    ];
                } 
            }
        }
        if (!empty($itemsToCreate))
        {
            $builderCreate = $this->db->table($this->table);

            foreach ($itemsToCreate as $i => $row)
            {
                $builderCreate->insert($row);
                $pageId = $this->insertId();

                $builderCreateTrans = $this->db->table($this->tblPageTrans);
                $builderCreateTrans->insert([
                    'page_id' => $pageId,
                    'localization' => 'cs_CZ',
                    'name' => $row['name'],
                    'title' => $row['name'],
                ]);
            }
        }

        if (!empty($itemsToRemove))
        {
            $builderRemove = $this->db->table($this->table);
            $builderRemove->whereIn('id', $itemsToRemove);
            $builderRemove->update(['removed' => 1]);
        }

        if (!empty($itemsToUpdate))
        {
            $builder->updateBatch($itemsToUpdate, 'id');
        }
        
        $__systemUpdate = new SystemUpdateModel;
        $__systemUpdate->updateRecord();
        
        return TRUE;
    }

    public function getCacheData($type)
    {
        helper('filesystem');
        $pages = [];
        $loadpages = FALSE;

        if ($type === 'select-option')
        {
            $filepages = CACHE_PATH . 'pages.json';

            if (file_exists($filepages) === TRUE)
            {
                $filepagesDate = filemtime($filepages);
                if (time() - $filepagesDate <= CACHE_MAX_TIME)
                {
                    $dataJson = file_get_contents($filepages);
                    $dataArray = FALSE;

                    if (!empty($dataJson))
                    {

                        $dataArray = json_decode($dataJson, TRUE);
                    }
                    
                    if (is_array($dataArray) === TRUE)
                    {

                        foreach ($dataArray as $typeName => $pageType)
                        {
                            foreach ($pageType as $data)
                            {
                                $page = [
                                    'id' => $data['id'],
                                    'name' => $data['name'],
                                ];
                                $pages[$data['id']] = $page;
                            }

                        }
                        $loadpages = TRUE;
                    }
                }
            }
        }
        else if ($type === 'data')
        {
            $filepages = CACHE_PATH . 'pages_data.json';

            if (file_exists($filepages) === TRUE)
            {
                $filepagesDate = filemtime($filepages);
                if (time() - $filepagesDate <= CACHE_MAX_TIME)
                {
                    $dataJson = get_filenames($filepages);
                    $dataArray = FALSE;
                    if (!empty($dataJson))
                    {
                        $dataArray = json_decode($dataJson, TRUE);
                    }

                    if (is_array($dataArray) === TRUE)
                    {
                        foreach ($dataArray as $data)
                        {
                            $pages[$data['id']] = $data;
                        }
                        
                        $loadpages = TRUE;
                    }
                }

            }
        }

        if ($loadpages === FALSE)
        {
            $__page = new PageModel;
            $__page->setFormat($type);
            $__page->setPageLimit(NULL);
            $pages = $__page->getRecord();

            $data_pages = json_encode(($pages), JSON_UNESCAPED_UNICODE);
            write_file($filepages, $data_pages);
        }

        return $pages;
    }
}