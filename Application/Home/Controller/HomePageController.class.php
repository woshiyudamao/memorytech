<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;
use Think\Controller;

/**
 * Description of HomePageController
 *
 * @author Kroaity
 */
class HomePageController extends Controller {
    //put your code here

    private $SelectList;

    public function test()
    {
        $U=D('user');
        $ret=$U->where(' RealName="于小猫" ')->find();
        dump($ret);
    }
    
    public function ClearRecord()
    {
        $this->SelectList=array();
    }
   
    /*
     * 
     * 以后要加分页的改进
     * 
     * @api {get} expertInfo 返回全部专家的信息
     * @apiName expertInfo
     * @apiGroup HomePage
     * 
     * @apiSuccess {int} err_no 错误码
     * @apiSuccess {String} msg  错误描述
     * 
     * @apiSuccessExample
     * {
     *       "err_no":0,
     *       "msg":"咨询添加成功"
     * }
     * 
     * @apiError 参数不完整
     * 
     * @apiErrorExample
     * {
     *  "err_no":-1,
     *  "msg":"参数错误 "
     * }
     */
    
    public function expertInfo()
    {
        $this->ClearRecord();
        /*
         * 实例化用户列表,取得其中的专家列表
         * 
         */
            $LimitRegion = $_GET['City'];
            $LimitType = $_GET['Type'];

        
            $User = D('user'); 
          
            if( isset($LimitRegion) ) {
                $Exp=$Exp->where("Region=$LimitRegion");
            }

            if( isset($LimitType) ) {
                $Exp=$Exp->where("Type=$LimitType");
               
            }
            $Exp=$User->where(' IsExp=1')->getField('Id',true);    
            
            
            do{
                $insertId = array_rand($Exp);
                
            }while( in_array($Exp[$insertId],$this->SelectList) );

            
            $this->SelectList[]=$insertId;
            $Ret=$User->where("Id=$insertId")->find();
            
            $rjson['Name']=$Ret['RealName'];
            $rjson['Avatar']=$Ret['Avatar'];
            $rjson['Title']=$Ret['Title'];
            $rjson['Motto']=$Ret['Motto'];
            $rjson['ID']=$insertId;

            echo json_encode($rjson,JSON_UNESCAPED_UNICODE);
    }
    
    /*
     * 返回指定专家的信息
     * GET方式提交参数 http://localhost/index.php/Home/HomePage/specifiedExp?id=专家编号
     * @return string json 
     * @para Name string 名字
     * @para Avatar url 头像链接
     * @para Title string 头像
     * @para Motto string 座右铭
    
     */

    
    public function specifiedExp()
    {
        if( IS_GET )
        {
            
            $User = D('user'); 
            $insertId=I("get.id");

         
            $Ret=$User->where("Id=$insertId")->find();

            $rjson['Name']=$Ret['RealName'];
            $rjson['Avatar']=$Ret['Avatar'];
            $rjson['Title']=$Ret['Title'];
            $rjson['Motto']=$Ret['Motto'];
            $rjson['ID']=$insertId;

            echo json_encode($rjson,JSON_UNESCAPED_UNICODE);
        }
    }
    
    /*
     * 
     * 返回城市列表,已经去重,五位编号
     * 无输入参数
     * @return json string
     * 0 => 01235
     * 1 => 12334
     */
    
    public function CityList()
    {
        $City=D('citylist');
        $City = $City->getField('CityName',true);
        
        echo json_encode($City,JSON_UNESCAPED_UNICODE);
    }
    
     /*
     * 
     * 返回类型列表,已经去重
     * 无输入参数
     * @return json string
     * 0 => 互联网
     * 1 => blablabla
     */
    
    public function TypeList()
    {
      // $type=D('typelist','','mysql://memory:Jc001122@rdsy3674506w15suu3r2.mysql.rds.aliyuncs.com:3306');
       $type = D('typelist');
       $type = $type->getField('TypeName',true);
       
       echo json_encode($type,JSON_UNESCAPED_UNICODE);
    }
    
    
    
}
