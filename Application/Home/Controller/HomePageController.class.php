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
    
    /*
     * 清除已显示专家的记录,在类型或者是城市切换过后使用
     * 或在连续调用ExpertInfo前使用
     * 
     * @para NULL
     * @return NULL
     * 
     */
    
    public function ClearRecord()
    {
        $this->SelectList=array();
    }
    
    /*
     * 
     * 返回主页上显示的专家的数据
     * 每次返回*一个*不重复的专家
     * 不需要参数,调用即可
     * GET方式提交参数 http://localhost/HomePage/ExpertInfo?City=专家的城市编号&Type=专家的类型
     * 无参数表示不限制
     * @api
     * @return string json 
     * @para Name string 名字
     * @para Avatar url 头像链接
     * @para Title string 头像
     * @para Motto string 座右铭
     * $para ID int 专家的ID
     */
    
    
    public function expertInfo()
    {
        /*
         * 实例化用户列表,取得其中的专家列表
         * 
         */
        if( IS_GET )
        {
            $LimitCity = $_GET['City'];
            $LimitType = $_GET['Type'];


            $User = M('User'); 
            $Exp=$User->where('IsExp=1');
            if( isset($LimitCity) ) {
                $Exp=$Exp->where("City=$LimitCity");
            }

            if( isset($LimitType) ) {
                $Exp=$Exp->where("Type=$LimitType");
            }
            $Exp=$Exp->getField('id');


            do{
                $insertId = array_rand($Exp);
            }while( in_array($insertId,$this->SelectList) );

            $this->SelectList[]=$insertId;
            $Ret=$User->where("id=$insertId")->find();

            $rjson['Name']=$Ret['RealName'];
            $rjson['Avatar']=$Ret['Avatar'];
            $rjson['Title']=$Ret['Title'];
            $rjosn['Motto']=$Ret['Motto'];
            $rjson['ID']=$insertId;

            return json_encode($rjosn);
        }
           
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
            $User = M('User'); 
            $insertId=I("get.id");

            $Ret=$User->where("id=$insertId")->find();

            $rjson['Name']=$Ret['RealName'];
            $rjson['Avatar']=$Ret['Avatar'];
            $rjson['Title']=$Ret['Title'];
            $rjosn['Motto']=$Ret['Motto'];
            $rjson['ID']=$insertId;

            return json_encode($rjosn);
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
    
    public function  cityList()
    {
        $User = M('User');
        $city = $User->getField('id,Region');
        $city = distinct($city);
        
        return json_encode($city);
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
       $User = M('User');
       $type = $User->getField('id,Type');
       $type = distinct($type);
       
       return json_encode($type);
    }
    
    
    
}
