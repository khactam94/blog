<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use InfyOm\Generator\Common\BaseRepository;

class TagRepository extends BaseRepository
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
        return Tag::class;
    }

    public function search($key){

        if(config('database.default') == 'pgsql'){
            $statement = ['name', 'ilike', '%'.$key.'%'];
        }
        elseif(config('database.default') == 'mysql'){
            $statement = [DB::raw('upper(name)'), 'like', '%'.strtoupper($key).'%'];
        }
        else{
            $statement = ['name', 'like', '%'.$key.'%'];
        }
        $tags = Tag::where([$statement])->limit(10)->pluck('name');
        return $tags;
    }
}
