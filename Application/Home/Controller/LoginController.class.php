<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 登陆相关
 * @author Yu
 */
class LoginController extends Controller{
    const USER_LOGIN_OK              =      0; //登陆成功
    const USER_NOT_EXIST             =     -1; //用户不存在
    const USER_TOKEN_ERR             =     -2; //TOKEN错误
    const PARAM_ERR                  =     -100;//参数错误
    
   /**
    * 默认登陆函数
    * GET方式提交参数 http://localhost/Login?username=手机号&token=登陆参数&cid=客户id
    * @return string 返回类型是json数据 err_no->错误代码 msg->消息
    */ 
    
    
       /**
        * @api {get} /Login 登陆
        * @apiVersion 1.0.0
        * @apiName Login
        * @apiGroup Login
        * @apiParam {String} username 手机号
        * @apiParam {String} token 登陆参数
        * @apiParam {String} cid 客户id，由个推获取 不设置无法使用消息推送
        * @apiSuccess {int} err_no 错误码
        * @apiSuccess {String} msg  错误描述
        *
        * @apiSuccessExample 登陆成功
        *     {
        *       "err_no":0,
        *       "msg":"登陆成功"
        *      } 
        *
        * @apiError Error 手机号/Token不符合规则
        *
        * @apiErrorExample 参数错误
        *    {
        *        "err_no":-100,
        *        "msg":"参数错误"
        *    }
        * 
        * @apiErrorExample TOKEN错误
        *   {
        *       "err_no":-2,
        *       "msg":"TOKEN错误"
        *   }
        * @apiErrorExample 用户不存在
        *   {
        *       "err_no":-1,
        *       "msg":"用户不存在"
        *   }
        */
    
  public function index()
  {
     
      if(IS_GET)
      {
      $return=  array();    
      $username=I("get.username","",'/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/');   //手机号
      $token=I("get.token","",'/^[A-Za-z0-9]{32}$/'); //MD5类型TOKEN
      $cid=I("get.cid");        //获取cid 个推使用 如果不设置将无法使用推送服务
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
                   session("Login",true);       //设置 login为真
                   session("Uid",$Ret['Id']);   //设置登录用户的ID 为之后需要Uid的操作做准备
                   session("Cid",$cid);         //设置个推clientid
                   $return['err_no']=  self::USER_LOGIN_OK;
                   $return['msg'] ="登陆成功";
                   //echo json_encode($return);
              }
              else
              {
                  $return['err_no']=  self::USER_TOKEN_ERR;
                  $return['msg'] ="TOKEN错误";
                  //echo $Ret['LoginToken'];
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
