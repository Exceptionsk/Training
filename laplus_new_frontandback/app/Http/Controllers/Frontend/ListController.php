<?php
/**
 * Created by PhpStorm.
 * User: william
 * Author: Wai Yan Aung
 * Date: 1/14/2017
 * Time: 10:55 AM
 */

namespace App\Http\Controllers\Frontend;

use Auth;
use Redirect;
use App\Frontend\Post\Post;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Frontend\Post\PostRepositoryInterface;
use Event;
use App\Events\UserAction;


class ListController extends Controller
{
    private $postRepository;
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public  function index()
    {
      $id = Auth::guard('User')->id();
      $posts = $this->postRepository->getPostsByUserID($id);
      $cur_time   = Carbon::now();
      return view('frontend.post.list')->with('posts', $posts)->with('cur_time',
          $cur_time);
    }

    public function create(){
        if (Auth::guard('User')->check()) {
            return view('frontend.post.post');
        }
         return redirect('/frontend/login');
    }

    public function store(Request $request)
    {
        $name            = trim(Input::get('name'));
        $descriptions    = trim(Input::get('descriptions'));
        $user_id         = Auth::guard('User')->id();
        $postObj = new Post();
        $postObj->name = $name;
        $postObj->user_id = $user_id;
        $postObj->descriptions = $descriptions;
        $this->postRepository->create($postObj);
        $id = Auth::guard('User')->id();
        $cur_time   = Carbon::now();
        Event::fire(new UserAction('Post', 'post created', $id, $cur_time));
        return redirect('/frontend/post');
    }

    public function edit($id){
      if (Auth::guard('User')->check()) {
          $user = $this->postRepository->getObjByID($id);
          return view('frontend.post.post')->with('post', $user);
      }
       return redirect('/frontend/login');
    }

    public function update(Request $request){
        $id                 = Input::get('id');
        $name               = Input::get('name');
        $descriptions       = Input::get('descriptions');

        $postObj            = Post::find($id);
        $postObj->name      = $name;
        $postObj->descriptions = $descriptions;
        $this->postRepository->update($postObj);
        $id = Auth::guard('User')->id();
        $cur_time   = Carbon::now();
        Event::fire(new UserAction('Post', 'post updated', $id, $cur_time));
        return redirect('/frontend/post');
    }

    public function destroy($id){
      // dd("delete");

        $this->postRepository->delete_posts($id);
        // $new_string = explode(',', $id);
        // foreach($new_string as $id){
        //     $this->postRepository->delete_posts($id);
        // }
        $id = Auth::guard('User')->id();
        $cur_time   = Carbon::now();
        Event::fire(new UserAction('Post', 'post deleted', $id, $cur_time));
        return redirect('/frontend/post');
        // return redirect()->action('Core\UserController@index');

    }
}
