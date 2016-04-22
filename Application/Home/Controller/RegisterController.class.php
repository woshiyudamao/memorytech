<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of register
 *
 * @author Kroaity
 */
namespace Home\Controller;
use Think\Controller;

class RegisterController extends Controller {
      
    const NUM_EXIST = -11;
    const TEXT_FAIL = -22;
    const TEXT_SUCC = -33;
    const NUM_UNC=-44;
    
    const ID_CODE_ERR = -1;
    const REG_SUCC = -2;
    
    
    /**
        * @api {get} /TextedByPhoneNum 通过手机号码注册
        * @apiVersion 1.0.0
        * @apiName Login
        * @apiParam {String} username 手机号
        * @apiSuccess {int} err_no 错误码
        * @apiSuccess {String} msg  错误描述
        * @apiSuccess {String} id 验证码 
        *
        * @apiSuccessExample 登陆成功
        *     {
        *       "err_no":-33,
        *       "msg":"登陆成功"
        *       "id":1111
        *      } 
        *
        * @apiError Error 
        *
        * @apiErrorExample 账号已存在
        *    {
        *        "err_no":-11,
        *        "msg":"账号已经存在"
        *       
        *    }
        * 
        * @apiErrorExample 短信发送失败
        *   {
        *       "err_no":-22,
        *       "msg":"TOKEN错误"
        *   }
     *    @apiErrorExample 电话号码错误
     * {
     * "err_no":-44;
     * "msg":"电话号码错误"
     * }
}
 
        */
    

    public function TextedByPhoneNum(  )
    {
        // 接受手机号,发送短信,返回发送状态
        // 若成功返回验证码
        // ID 字段表示生成的验证码
        
           
        if( IS_GET )
        {
            $PhoneNum = I("get.username","",'/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/'); 
            $rjson = array();
         

            if( !empty($PhoneNum) )
            {
                
                $User=D("User");
                $condition=array();
                $condition['Mobile']=$PhoneNum;
                $Ret=$User->where($condition)->find();
                
                // 查询该电话号码是否已经注册
                if( !empty($Ret) )
                {
                    $rjson['err_no']=sefl::NUM_EXIST;
                    $rjson['msg']="账号已存在";
                    echo json_encode($rjson,JSON_UNESCAPED_UNICODE);
                }

                // 若没有注册,短信验证
                else
                {
                    import('Org.Taobao.TopSdk');
                    date_default_timezone_set('Asia/Shanghai'); 

                    $c = new TopClient;
                    $c->appkey = '23333861';
                    $c->secretKey = '2e05b91861bfefba9ee84050f5363df2';
                    $c->format = 'json';

                    $req = new AlibabaAliqinFcSmsNumSendRequest;
                    $req->setSmsType("normal");
                    $req->setSmsFreeSignName("注册验证");
                    $req->setRecNum($PhoneNum);
                    $req->setSmsTemplateCode("SMS_6726094");

                    //产生随机验证码
                    $para->code=rand(1000,9999);      
                    $para->product="memtech";
                    $req->setSmsParam(json_encode($para));

                    //手机与验证码关联
                    $_SESSION[$PhoneNum]=$para->code;

                    //请求发送
                    $resp = $c->execute($req);

                    if( isset($resp->msg) )
                    {
                        $rjson['msg']="短信发送失败";
                        $rjson['err_no']=self::TEXT_FAIL;
                        echo json_encode($rjson,JSON_UNESCAPED_UNICODE);
                    }
                    else 
                    {
                        $rjson['ID']=$para->code;
                        $rjson['err_no']=self::TEXT_SUCC;
                        $rjson['msg']="发送成功";
                        echo json_encode($rjson,JSON_UNESCAPED_UNICODE);
                    }
                }
            }
            else
            {
                $rjson['err_no']=self::NUM_UNC;
                $rjson['msg']='电话号码错误';
                echo json_encode($rjson,JSON_UNESCAPED_UNICODE);
            }
        }
        
    }
    
     /**
        * @api {get} CheckAndRegister 验证验证码并注册
        * @apiVersion 1.0.0
        * @apiName CheckAndRegister
        * @apiParam {String} username 手机号
      *   @apiParam {String} idcode 验证码
        * @apiSuccess {int} err_no 错误码
        * @apiSuccess {String} msg  错误描述
        * @apiSuccess {String} token 生成的token
        *
        * @apiSuccessExample 登陆成功
        *     {
        *       "err_no":-2,
        *       "msg":"注册成功"
        *       "token":202cb962ac59075b964b07152d234b70
        *      } 
        *
        * @apiError Error 
        *
        * @apiErrorExample 验证码错误
        *    {
        *        "err_no":-1,
        *        "msg":"验证码错误"
        *       
        *    }
        * 
      
        */
    
    
    public function CheckAndRegister()
    {
    
        if(IS_GET)
        {
           
            $rjson   = array();
            $PhoneNum = I("get.username","",'/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/'); 
            $IdCode   = I("get.idcode","",'/^[0-9]{4}');
            if(  $IdCode != $_SESSION[$PhoneNum] ) 
            {
                $return['err_no'] = self::ID_CODE_ERR;
                $return['msg']="验证码错误";
            }

            $User=M("user");
            
            $data['Mobile']=$PhoneNum;
            $data['LoginToken']= md5(microtime(true));
            $User->add($data);
            
            $rjson['err_no']= self::REG_SUCC;
            $rjson['msg']="注册成功";
            $rjson['token']=$data['LoginToken'];
            
            return json_encode($rjson,JSON_UNESCAPED_UNICODE);
        }
    }
    
}
