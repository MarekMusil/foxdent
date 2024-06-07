<?php

namespace App\Helpers;

class PaginationHelper
{
    public static function createPagination($request, $model , $sortBy = 'id', $sortOrder = 'DESC')
    {
        $__model = $model;

        if ($request->getGet('sortBy') && $request->getGet('sortOrder'))
        {
            $__model->setSortBy($request->getGet('sortBy'));
            $__model->setSortOrder($request->getGet('sortOrder'));
        }
        else {
            $__model->setSortBy($sortBy);
            $__model->setSortOrder($sortOrder);
        }

        if ($request->getGet('pageLimit') && ctype_digit($request->getGet('pageLimit')) === TRUE && $request->getGet('pageLimit') <= MAX_pageLimit)
        {
            $__model->setPageLimit($request->getGet('pageLimit'));
        }
        elseif ($request->getGet('pageLimit') == 'all')
        {
            $__model->setPageLimit(MAX_pageLimit);
        }

        if ($request->getGet('pageNumber') && ctype_digit($request->getGet('pageNumber')))
        {
            $__model->setPageNumber($request->getGet('pageNumber'));
        }

        if ($request->getGet('q') && strlen($request->getGet('q')) >= 3)
        {
            $__model->setSearchQuery($request->getGet('q'));
        }

        $__model->setOnlyCount(TRUE);
        $countRecords = $__model->getRecord();

        $__model->setOnlyCount(FALSE);

        $pageLimit = $__model->getPageLimit();
        $pageNumber = $__model->getPageNumber();

        if (!is_null($pageLimit))
        {
            try
            {
                $countPages = floor($countRecords / $pageLimit);
                if ($countRecords % $pageLimit > 0)
                {
                    $countPages++;
                }
            }
            catch (Exception $e)
            {
                $countPages = 1;
            }
        }
        else
        {
            $countPages = 1;
        }

        $pageNextNumber = $pageNumber + 1;
        if ($pageNextNumber > $countPages)
        {
            $pageNextNumber = $countPages;
        }

        $countNextRecords = $countRecords - ($pageNumber * $pageLimit);
        if ($countNextRecords < 1)
        {
            $countNextRecords = 0;
        }

        $pagination = [
            'countRecords' => (int)$countRecords,
            'countNextRecords' => $countNextRecords,
            'countPages' => $countPages,
            'pageLimit' => $pageLimit,
            'pageNextNumber' => $pageNextNumber,
            'pageNumber' => $pageNumber,
        ];

        return $pagination;
    }

}