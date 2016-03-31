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
class UserModel extends Model {
   protected $tableName = 'User';
   protected $tablePrefix = ''; 
   protected $fields = array(
       'Id', 
       'Mobile', 
       'Avatar', 
       'RealName', 
       'Sex',
       'Balance', 
       'Company', 
       'Job',
       'Region', 
       'Area', 
       'LoginToken',
       'Title',
       'Motto',
        'IsExp',
         '_type'=>array(
             'Id'=>'int',
             'Mobile'=>'varchar',
              'Avatar'=>'varchar',
              'RealName'=>'varchar',
              'Sex'=>'tinyint',
              'Balance'=>'float',
              'Company'=>'varchar',
              'Job'=>'varchar',
              'Region'=>'int',
              'Area'=>'int',
             'LoginToken'=>'varchar',
             'Title'=>'varchar',
             'Motto'=>'varchar',
             'IsExp'=>'int'
             )
     );

}
