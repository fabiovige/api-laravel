<?php

namespace App\Filters;

use DeepCopy\Exception\PropertyException;
use Exception;
use Illuminate\Http\Request;

abstract class Filter
{
    protected array $allowedOperatorsFilders = [];

    protected array $translateOperatorsFields = [
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'eq' => '=',
        'ne' => '!=',
        'in' => 'in'
    ];

    public function filter(Request $request)
    {
        $where = [];
        $whereIn = [];

        if(empty($this->allowedOperatorsFilders)){
            throw new PropertyException("Propriedades de filtro vazias");
        }

        foreach($this->allowedOperatorsFilders as $param => $operators){
            $queryOperator = $request->query($param);
            if($queryOperator){
                foreach($queryOperator as $operator => $value){
                    if(!in_array($operator, $operators)){
                        throw new Exception("O operador $operator não existe para o parâmetro {$param}");
                    }
                    if(str_contains($value,'[')){
                        $whereIn[] = [
                            $param,
                            explode(',',str_replace(['[',']'],'',$value))
                        ];
                    } else {
                        $where[] = [
                            $param,
                            $this->translateOperatorsFields[$operator],
                            $value
                        ];
                    }
                }
            }
        }

        if(empty($where) && empty($whereIn)){
            return [];
        }

        return [
            'where' => $where,
            'whereIn' => $whereIn
        ];

    }
}
