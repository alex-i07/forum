<?php
/**
 * Created by PhpStorm.
 * User: Саня
 * Date: 03.12.2018
 * Time: 13:55
 */

namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{

    /**
     * @var Request
     */
    protected $request, $builder;

    protected $filters = [];

    /**
     * ThreadFilters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     * @return mixed
     */
    public function apply($builder)
    {
        $this->builder = $builder;

//        dd($this->getFilters());

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;

    }

    /**
     * @return array
     */
    protected function getFilters()
    {
        return $this->request->only($this->filters);
    }
}