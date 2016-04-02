<?php

namespace Home\Model;
use Think\Model;
/**
 * 专家团操作模型
 * 
 * @author Yu
 */
//DROP TABLE IF EXISTS `myexports`;
//CREATE TABLE `myexports` (
//  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//  `UserId` int(10) unsigned NOT NULL COMMENT '用户ID',
//  `ExpertId` int(10) unsigned NOT NULL COMMENT '专家ID',
//  PRIMARY KEY (`Id`)
//) ENGINE=MyISAM DEFAULT CHARSET=gbk;

class MyExportsModel extends Model{
    
    
        public function addExpert($UserId,$ExpertId)
        {   
            
        $data=array();
        $data['UserId']=$UserId;
        $data['ExpertId']=$ExpertId;
        return $this->add($data);
        
        
        }
        
        public function delExpert($UserId,$ExpertId)
        {   
        $condition=array();
        $condition['UserId']=$UserId;
        $condition['ExpertId']=$ExpertId; 
        return $this->where($condition)->delete();
        }
        
        public function showExpert($UserId)
        {   
        $condition=array();
        $condition['UserId']=$UserId;
        return $this->field("ExpertId")->where($condition)->distinct(true)->select();// 只需要获取ExpertId
        
        }
        
        
    }

