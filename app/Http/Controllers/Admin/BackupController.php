<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Post;
use App\Models\Category;
use App\Models\CategoriesPost;
use DB;

class BackupController extends Controller
{

    /**
     * Download data in database.
     *
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request)
    {
        $posts = Post::all();
        $attrs = get_object_vars($posts[0])['fillable'];
        $content = '[';
        
        echo $content;
        foreach($posts as $post){
            $content = $content.'{';
            foreach($attrs as $attr){
                $content = $content.$attr.' : '.$post->{$attr}.',';
            }
            $content = $content.'},';
            
        }
        $content = $content.']';
        echo htmlentities($content);
    }

    /**
     * Upload data to database
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
    }
}