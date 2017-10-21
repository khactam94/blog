<?php

namespace App\Repositories;

use App\Models\Category;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\DB;
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
    private function getLikeQuery($column, $key){
        $drive = config('database.default');
        return  $drive === 'pgsql'  ? [$column, 'ilike', '%'.$key.'%'] :
            $drive === 'mysql'  ? [DB::raw('UPPER('.$column.')'), 'like', '%'.($key ? strtoupper($key) : '').'%']
                : [$column, 'like', '%'.$key.'%'];
    }
    public function search($key){
        $categories = Category::where([$this->getLikeQuery('name', $key)])->take(10)->pluck('name');
        return $categories;
    }

    public function findForce($name){
    $category = Category::where('name', $name)->first();
    if($category == null) {
        $category = Category::create(['name' => $name]);
    }
    return $category;
}
}
