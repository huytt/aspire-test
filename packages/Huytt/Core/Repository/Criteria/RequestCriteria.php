<?php

namespace Huytt\Core\Repository\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

class RequestCriteria extends \Prettus\Repository\Criteria\RequestCriteria
{
    /**
     * Apply criteria in query repository
     *
     * @param         Builder|Model     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $searchGroup = $this->request->get('searchGroup', null);
        if(!empty($searchGroup)) {
            foreach ($searchGroup as $group) {
                $search = $group['search'] ?? null;
                $searchFields = $group['searchFields'] ?? null;
                $searchJoin = $group['searchJoin'] ?? null;

                $fieldsSearchable = $repository->getFieldsSearchable();
                if ($search && is_array($fieldsSearchable) && count($fieldsSearchable)) {

                    $searchFields = is_array($searchFields) || is_null($searchFields) ? $searchFields : explode(';', $searchFields);
                    $isFirstField = true;
                    $searchData = $this->parserSearchData($search);
                    $fields = $this->parserFieldsSearch($fieldsSearchable, $searchFields, array_keys($searchData));
                    $search = $this->parserSearchValue($search);
                    $modelForceAndWhere = strtolower($searchJoin) === 'and';


                    $model = $model->where(function ($query) use ($fields, $search, $searchData, $isFirstField, $modelForceAndWhere) {
                        /** @var Builder $query */

                        foreach ($fields as $field => $condition) {

                            if (is_numeric($field)) {
                                $field = $condition;
                                $condition = "=";
                            }

                            $value = null;

                            $condition = trim(strtolower($condition));

                            if (isset($searchData[$field])) {
                                $value = ($condition == "like" || $condition == "ilike") ? "%{$searchData[$field]}%" : $searchData[$field];
                            } else {
                                if (!is_null($search) && !in_array($condition,['in','between'])) {
                                    $value = ($condition == "like" || $condition == "ilike") ? "%{$search}%" : $search;
                                }
                            }

                            $relation = null;
                            if(stripos($field, '.')) {
                                $explode = explode('.', $field);
                                $field = array_pop($explode);
                                $relation = implode('.', $explode);
                            }
                            if($condition === 'in'){
                                $value = explode(',',$value);
                                if( trim($value[0]) === "" || $field == $value[0]){
                                    $value = null;
                                }
                            }
                            if($condition === 'between'){
                                $value = explode(',',$value);
                                if(count($value) < 2){
                                    $value = null;
                                }
                            }
                            $modelTableName = $query->getModel()->getTable();
                            if ( $isFirstField || $modelForceAndWhere ) {
                                if (!is_null($value)) {
                                    if(!is_null($relation)) {
                                        $query->whereHas($relation, function($query) use($field,$condition,$value) {
                                            if($condition === 'in'){
                                                $query->whereIn($field,$value);
                                            }elseif($condition === 'between'){
                                                $query->whereBetween($field,$value);
                                            }else{
                                                $query->where($field,$condition,$value);
                                            }
                                        });
                                    } else {
                                        if($condition === 'in'){
                                            $query->whereIn($modelTableName.'.'.$field,$value);
                                        }elseif($condition === 'between'){
                                            $query->whereBetween($modelTableName.'.'.$field,$value);
                                        }else{
                                            $query->where($modelTableName.'.'.$field,$condition,$value);
                                        }
                                    }
                                    $isFirstField = false;
                                }
                            } else {
                                if (!is_null($value)) {
                                    if(!is_null($relation)) {
                                        $query->orWhereHas($relation, function($query) use($field,$condition,$value) {
                                            if($condition === 'in'){
                                                $query->whereIn($field,$value);
                                            }elseif($condition === 'between'){
                                                $query->whereBetween($field, $value);
                                            }else{
                                                $query->where($field,$condition,$value);
                                            }
                                        });
                                    } else {
                                        if($condition === 'in'){
                                            $query->orWhereIn($modelTableName.'.'.$field, $value);
                                        }elseif($condition === 'between'){
                                            $query->whereBetween($modelTableName.'.'.$field,$value);
                                        }else{
                                            $query->orWhere($modelTableName.'.'.$field, $condition, $value);
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }

            $filter = $this->request->get(config('repository.criteria.params.filter', 'filter'), null);
            $orderBy = $this->request->get(config('repository.criteria.params.orderBy', 'orderBy'), null);
            $sortedBy = $this->request->get(config('repository.criteria.params.sortedBy', 'sortedBy'), 'asc');
            $with = $this->request->get(config('repository.criteria.params.with', 'with'), null);
            $withCount = $this->request->get(config('repository.criteria.params.withCount', 'withCount'), null);
            $sortedBy = !empty($sortedBy) ? $sortedBy : 'asc';

            if (isset($orderBy) && !empty($orderBy)) {
                $orderBySplit = explode(';', $orderBy);
                if(count($orderBySplit) > 1) {
                    $sortedBySplit = explode(';', $sortedBy);
                    foreach ($orderBySplit as $orderBySplitItemKey => $orderBySplitItem) {
                        $sortedBy = isset($sortedBySplit[$orderBySplitItemKey]) ? $sortedBySplit[$orderBySplitItemKey] : $sortedBySplit[0];
                        $model = $this->parserFieldsOrderBy($model, $orderBySplitItem, $sortedBy);
                    }
                } else {
                    $model = $this->parserFieldsOrderBy($model, $orderBySplit[0], $sortedBy);
                }
            }

            if (isset($filter) && !empty($filter)) {
                if (is_string($filter)) {
                    $filter = explode(';', $filter);
                }

                $model = $model->select($filter);
            }

            if ($with) {
                $with = explode(';', $with);
                $model = $model->with($with);
            }

            if ($withCount) {
                $withCount = explode(';', $withCount);
                $model = $model->withCount($withCount);
            }

            return $model;
        }

        return parent::apply($model, $repository);
    }
}
