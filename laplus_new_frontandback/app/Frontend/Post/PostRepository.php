<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/21/2016
 * Time: 3:51 PM
 */
namespace App\Frontend\Post;

use App\Frontend\Post\PostRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Frontend\Post\Post;
// use App\Core\Permission\PermissionRepository;
use App\Frontend\Utility;

class PostRepository implements PostRepositoryInterface
{
    public function create($postObj)
    {
        $tempObj = Utility::addCreatedBy($postObj);
        $tempObj->save();
    }

    public function update($userObj)
    {
        $tempObj = Utility::addUpdatedBy($userObj);
        $tempObj->save();
    }

    public function getPostsByUserID($id)
    {
        $users = Post::whereNull('deleted_at')->where('user_id','=', $id)->get();
        return $users;
    }

    public function getUserByEmail($email)
    {
        $user = DB::select("SELECT * FROM core_users WHERE email = '$email'");
        return $user;
    }

    public function getRoles(){
        $roles = DB::table('core_roles')->get();
        return $roles;
    }

    public function getPendingUsers()
    {
      $pending_users = User::whereNull('deleted_at')->where('status', '=', 2)->get();
      return $pending_users;
    }

    public function getApprovedUsers()
    {
      $pending_users = User::whereNull('deleted_at')->where('status', '=', 3)->get();
      return $pending_users;
    }


    public function approve($id)
    {
        DB::table('core_users')->where('id',$id)->update(['status'=>3]);
    }

    public function delete_posts($id){
        if($id != 1){

            //DB::table('core_users')->where('id',$id)->update(['deleted_at'=> date('Y-m-d H:m:i')]);
            $postObj = Post::find($id);
            $postObj = Utility::addDeletedBy($postObj);
            $postObj->deleted_at = date('Y-m-d H:m:i');
            $postObj->save();
        }
    }

    public function getObjByID($id){
        $post = Post::find($id);
        return $post;
    }

    public function changeDisableToEnable($id,$cur){
        DB::table('core_users')->where('id',$id)->update(['last_activity'=>$cur,'status'=>1]);
    }

    public function changeEnableToDisable($id)
    {
        DB::table('core_users')->where('id',$id)->update(['status'=>0]);
    }


    public function getPermissionByUserId($userId) {

        $roleId = DB::table("core_users")
            ->select('role_id')
            ->where('id' , '=' , $userId)
            ->first();

        if($roleId) {
            $permissionRepo = new PermissionRepository();
            $permissions = $permissionRepo->getPermissionsByRoleId($roleId->role_id);

            if($permissions)
                return $permissions;
        }
        return null;
    }
}
