<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/21/2016
 * Time: 3:51 PM
 */
namespace App\Core\Log;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\Log\Log;
// use App\Core\Permission\PermissionRepository;
use App\Core\Utility;

class LogRepository implements LogRepositoryInterface
{
    public function create($userObj)
    {
        $tempObj = Utility::addCreatedBy($userObj);
        $tempObj->save();
    }

    public function update($userObj)
    {
        $tempObj = Utility::addUpdatedBy($userObj);
        $tempObj->save();
    }

    public function getlogs()
    {
        $logs = Log::whereNull('deleted_at')->get();
        return $logs;
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

    public function delete_users($id){
        if($id != 1){
            //DB::table('core_users')->where('id',$id)->update(['deleted_at'=> date('Y-m-d H:m:i')]);
            $userObj = User::find($id);
            $userObj = Utility::addDeletedBy($userObj);
            $userObj->deleted_at = date('Y-m-d H:m:i');
            $userObj->save();
        }
    }

    public function getObjByID($id){
        $user = User::find($id);
        return $user;
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
