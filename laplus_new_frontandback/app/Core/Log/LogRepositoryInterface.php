<?php namespace App\Core\Log;

/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 5/21/2016
 * Time: 3:51 PM
 */
interface LogRepositoryInterface
{
    public function getlogs();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete_users($id);
    public function getPendingUsers();
    public function getRoles();
    public function changeDisableToEnable($id,$cur);
    public function changeEnableToDisable($id);

}
