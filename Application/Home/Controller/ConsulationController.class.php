<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;
use Think\Controller;

class ConsulationController extends Controller 
{
    const CONS_ADD_OK              =        0; //添加成功
    const PARAM_ERR                  =     -1;//参数错误
    /*
     * 
     * 语音咨询
     * GET方式提交参数 http://localhost/index.php/Home/Consulation/Voice?describo=文字说明&voice=语音文件地址(待商榷)
     * @return string 返回类型是json数据 err_no->错误代码 msg->消息
     */
    
    public function Voice ()
    {
   
      if(IS_GET)
      {
        $return=  array();    
        $describo=I("get.describo");
        $voice=I("get.voice");

        if(!empty($describo) && !empty($voice)) //
        {     
            $Consult = D("Consulation"); // 实例化User对象
            $condition=array();
            $condition['Describo']=$describo;
            $condition['Voice']=$voice;
            $Consult->add($condition);
                            
            $return['err_no']=  self::CONS_ADD_OK;
            $return['msg'] ="咨询添加成功";


      }
      else
      {
           $return['err_no']=  self::PARAM_ERR;
           $return['msg'] ="参数错误";
          
      }
      //echo $return;
      return json_encode($return,JSON_UNESCAPED_UNICODE); //不转义中文 5.4以上
      }
    
    }
    
     /*
     * 
     * 电话
     * GET方式提交参数 http://localhost/index.php/Home/Tel?describo=文字说明&teltime=电话时间长度
     * @return string 返回类型是json数据 err_no->错误代码 msg->消息
     */
    
    public function Tel()  
    {
      if(IS_GET)
      {
        $return=  array();    
        $describo=I("get.describo");
        $teltime=I("get.teltime");

        if(!empty($describo) && !empty($teltime)) //
        {     
            $Consult = D("Consulation"); // 实例化User对象
            $condition=array();
            $condition['Describo']=$describo;
            $condition['Teltime']=$teltime;
            $Consult->add($condition);
                            
            $return['err_no']=  self::CONS_ADD_OK;
            $return['msg'] ="咨询添加成功";


      }
      else
      {
           $return['err_no']=  self::PARAM_ERR;
           $return['msg'] ="参数错误";
          
      }
      return json_encode($return,JSON_UNESCAPED_UNICODE); //不转义中文 5.4以上
      }
    }
    
     /*
     * 
     * 见面咨询
     * GET方式提交参数http://localhost/index.php/Home/meet?describo=文字说明&selfintro=自我介绍
     * @return string 返回类型是json数据 err_no->错误代码 msg->消息
     */
    
    public function meet()  
    {
      if(IS_GET)
      {
        $return=  array();    
        $describo=I("get.describo");
        $selfintro=I("get.selfintro");

        if(!empty($describo) && !empty($selfintro)) //
        {     
            $Consult = D("Consulation"); // 实例化User对象
            $condition=array();
            $condition['Describo']=$describo;
            $condition['SelfIntro']=$$selfintro;
            $Consult->add($condition);
                            
            $return['err_no']=  self::CONS_ADD_OK;
            $return['msg'] ="咨询添加成功";


      }
      else
      {
           $return['err_no']=  self::PARAM_ERR;
           $return['msg'] ="参数错误";
          
      }
      return json_encode($return,JSON_UNESCAPED_UNICODE); //不转义中文 5.4以上
      }
    }
    
    
    
}

