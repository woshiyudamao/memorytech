<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Home\Model;
use Think\Model;
/**
 * Description of UserModel
 *
 * @author Yu
 */
class ConsulationModel extends Model {
   protected $tableName = 'Consulation';
   protected $tablePrefix = ''; 
   protected $fields = array(
       'Id', 
       'Describo', 
       'Datetime', 
       'Teltime', 
       'SelfIntro',
       'Voice', 
       'UserId', 
       'ExpId',
         '_type'=>array(
             'Id'=>'int', 
       'Describo'=>'varchar',
       'Datetime'=>'date',
       'Teltime'=>'int',
       'SelfIntro'=>'varchar',
       'Voice'=>'varchar', 
       'UserId'=>'int', 
       'ExpId'=>'int',
             )
     );

}
