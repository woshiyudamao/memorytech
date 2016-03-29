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
session_start();

class RegisterController extends Controller {
      
    const NUM_EXIST = -11;
    const TEXT_FAIL = -22;
    const TEXT_SUCC = -33;
    
    const ID_CODE_ERR = -1;
    const REG_SUCC = -2;

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
                    return json_encode($rjson,JSON_UNESCAPED_UNICODE);
                }

                // 若没有注册,短信验证

                import('Org.Taobao.TopSdk');
                date_default_timezone_set('Asia/Shanghai'); 

                $c = new TopClient;
                $c->appkey = '23333861';
                $c->secretKey = ' 2e05b91861bfefba9ee84050f5363df2';
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
                $resp = json_decode($resp);
                if( $resp->code==50 )
                {
                    $rjson['msg']="短信发送失败";
                    $rjson['err_no']=self::TEXT_FAIL;
                    return json_encode($rjson,JSON_UNESCAPED_UNICODE);
                }

                $rjson['ID']=$para->code;
                $rjson['err_no']=self::TEXT_SUCC;
                $rjson['msg']="发送成功";
                return json_encode($rjson,JSON_UNESCAPED_UNICODE);
            }
        }
        
    }
    
    public function CheckAndRegister()
    {
        /*
         * 
         * 接受验证码和手机号,返回注册状态
         * 注册成功返回一个32位的md5 token 
         * 
         */   
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

            $User=M("User");
            
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
