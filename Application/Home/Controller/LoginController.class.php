<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;
use Think\Controller;
/**
 * Description of LoginController
 *
 * @author Yu
 */
class LoginController extends Controller{
    const USER_LOGIN_OK              =      0;
    const USER_NOT_EXIST             =     -1;
    const USER_TOKEN_ERR             =     -2;
    const PARAM_ERR                  =     -100;
    
    
  public function index()
  {
     
      if(IS_GET)
      {
      $return=  array();    
      $username=I("get.username","",'/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/');   //手机号
      $token=I("get.token","",'/^[A-Za-z0-9]{32}$/'); //MD5类型TOKEN
     // echo $token;
      if(!empty($username) && !empty($token)) //
      {     
          $User = D("User"); // 实例化User对象
          $condition=array();
          $condition['Mobile']=$username;
          $Ret=$User->where($condition)->find();
          //dump($Ret);
          if(!empty($Ret)) //如果不为空说明找到了用户 ，现在去判断TOKEN 是否相等
          {
              if(strcmp($token, $Ret['LoginToken'])==0) //匹配到TOKEN 相等
              {
                   session("Login",true); //设置 login为真
                   $return['err_no']=  self::USER_LOGIN_OK;
                   $return['msg'] ="登陆成功";
                   //echo json_encode($return);
              }
              else
              {
                  $return['err_no']=  self::USER_TOKEN_ERR;
                  $return['msg'] ="TOKEN错误";
                  echo $Ret['LoginToken'];
              }
              
              
          }
          else
          {
          $return['err_no']=  self::USER_NOT_EXIST;
          $return['msg'] ="用户不存在";
          //
          }
          
      }
      else
      {
           $return['err_no']=  self::PARAM_ERR;
           $return['msg'] ="参数错误";
          
      }
      echo json_encode($return,JSON_UNESCAPED_UNICODE); //不转义中文 5.4以上
      }
  }
  
  
}
