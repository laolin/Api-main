<?php
// ================================
/*
*/
namespace DJApi\UserBind;

use DJApi\DB;
use DJApi\API;
use DJApi\Request\Request;

class class_steeobj{
  static $tableWX = 'api_tbl_user_wx';
  static $tableObj = 'api_tbl_stee_user';

  /**
   * 获取单人/多人的 openid
   */
  private static function getUids($type, $objid) {
    $db = DB::db();
    $uid = $db->select(self::$tableObj, 'uid', ["{$type}_can_admin[~]"=>$objid]);
    return $uid; //[$uid, $db->getShow()];
  }


  /**
   * 获取单人/多人的 openid
   */
  public static function adminid($request) {
    $type = $request->query['type'];
    $objid = $request->query['id'];
    return API::OK(['uid' => self::getUids($type, $objid)]);
  }

  /**
   * 获取多组多人的 openid
   */
  public static function adminidgroups($request) {
    $objidGroups = $request->query['group'];
    $R = [];
    foreach($objidGroups as $groupName => $group){
      $type  = $group['type' ];
      $objid = $group['objid'];
      $R[$groupName] = self::getUids($type, $objid);
    }
    return API::OK(['R'=>$R, 'objidGroups'=>$objidGroups]);
  }

}
