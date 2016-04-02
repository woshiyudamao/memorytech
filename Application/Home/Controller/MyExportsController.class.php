<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 我的专家团
 * @author Yu
 */
class MyExportsController  extends Controller{
    
    
    private $Uid = 0;
    private $model= null;
    
    /**
    * 初始化操作
    * 在这里判断了用户是否登录了，这里面的操作只有用户登录后才可以使用
    */
    
    public function _initialize()
   {
        $login =  session("Login"); //在Login控制器里面有登录成功设置该 session的
        if ($login != true) { //如果没有登录就直接报错
            $this->error("未登录!");
        }

        $this->Uid=  intval(session("Uid"));
        $this->model= D("MyExports");
   }
    
    /**
     * 收藏专家
     * GET方式提交参数 http://localhost/MyExports/add?Id=专家的ID
     * @api
     * @return string json 数据
     */
   public function add()
   {
       $exp_id=  intval(I("get.Id")); //获取Get参数 Id
       $ret=$this->model->addExpert($this->Uid,$exp_id);
       echo json_encode($ret);
   }
      /**
     * 取消收藏专家
     * GET方式提交参数 http://localhost/MyExports/del?Id=专家的ID
     * @api
     * @return string json 数据
     */
   public function del()
   {
       
   }
      /**
     * 显示收藏的专家
     * GET方式提交参数 http://localhost/MyExports/show?Id=专家的ID
     * @api
     * @return string json 数据
     */
   public function show()
   {
       
       
   }
   
}
