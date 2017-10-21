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

    private function getLikeQuery($column, $key){
        $drive = config('database.default');
        return  $drive === 'pgsql'  ? [$column, 'ilike', '%'.$key.'%'] :
            $drive === 'mysql'  ? [DB::raw('UPPER('.$column.')'), 'like', '%'.($key ? strtoupper($key) : '').'%']
                : [$column, 'like', '%'.$key.'%'];
    }
    public function search($key){
        $tags = Tag::where([$this->getLikeQuery('name', $key)])->take(10)->pluck('name');
        return $tags;
    }
    public function findForce($name){
        $tag = Tag::where('name', $name)->first();
        if($tag == null) {
            $tag = Tag::create(['name' => $name]);
        }
        return $tag;
    }
}
