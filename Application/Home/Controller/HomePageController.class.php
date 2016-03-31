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
     */
    
    
    public function ExpertInfo()
    {
        /*
         * 实例化用户列表,取得其中的专家列表
         * 
         */
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
        
        $rjson['Name']=$User->where("id=$insertId")->getField('RealName');
        $rjson['Avatar']=$User->where("id=$insertId")->getField('Avatar');
        $rjson['Title']=$User->where("id=$insertId")->getField('Title');
        $rjosn['Motto']=$User->where("id=$insertId")->getField('Motto');
        
        return json_encode($rjosn);
           
    }
    
    /*
     * 
     * 返回城市列表,已经去重,五位编号
     * 无输入参数
     * @return json string
     * 0 => 01235
     * 1 => 12334
     */
    
    public function  CityList()
    {
        $User = M('User');
        $city = $User->getField('id,Region');
        $city = array_unique($city);
        
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
       $type = array_unique($type);
       
       return json_encode($type);
    }
    
}
