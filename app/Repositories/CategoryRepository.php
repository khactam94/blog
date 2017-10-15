<?php

namespace App\Repositories;

use App\Models\Category;
use InfyOm\Generator\Common\BaseRepository;

class CategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
    }

    public function search($key){

        if(config('database.default') =='pgsql'){
            $statement = ['name', 'ilike', '%'.$key.'%'];
        }
        elseif(config('database.default') =='mysql'){
            $statement = [DB::raw('upper(name)'), 'like', '%'.strtoupper($key).'%'];
        }
        else{
            $statement = ['name', 'like', '%'.$key.'%'];
        }
        $categories = Category::where([$statement])->limit(10)->pluck('name');
        return $categories;
    }
}
