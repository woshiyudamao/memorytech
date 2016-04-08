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
    * 对应空操作
    */
    public function _empty()
    {
        $this->error("nothing to do ！");
        
    }
    /**
     * 收藏专家
     * GET方式提交参数 http://localhost/MyExports/add?Id=专家的ID
     */
    
     /**
        * @api {get} /MyExports/add 收藏专家
        * @apiVersion 1.0.0
        * @apiName add
        * @apiParam {int} Id 专家的ID
        * @apiSuccess {int} err_no 错误码
        * @apiSuccess {String} msg  错误描述
        *
        * @apiSuccessExample 添加成功
        *     {
        *       "err_no":0,
        *       "msg":"添加成功"
        *      } 
        *
        * @apiError Error ID参数不正确
        *
        * @apiErrorExample 添加失败
        *    {
        *        "err_no":-1,
        *        "msg":"添加失败"
        *    }
        */
    
    
    
   public function add()
   {
       $exp_id=  intval(I("get.Id")); //获取Get参数 Id
       if(empty($exp_id)) exit("Id为空注意大小写");
       $ret=$this->model->addExpert($this->Uid,$exp_id);
       $return=array();
       if ($ret!=false)
       {
           $return['err_no']=  0;
           $return['msg'] ="添加成功";
           
       }
       else
       {
           $return['err_no']=  -1;
           $return['msg'] ="添加失败"; //失败的原因是参数不正确
       }
       echo json_encode($return,JSON_UNESCAPED_UNICODE);
   }
      /**
        * 取消收藏专家
        * GET方式提交参数 http://localhost/MyExports/del?Id=专家的ID
        */
   
       
       /**
        * @api {get} /MyExports/del 取消收藏专家
        * @apiVersion 1.0.0
        * @apiName del
        * @apiParam {int} Id 专家的ID
        * @apiSuccess {int} err_no 错误码
        * @apiSuccess {String} msg  错误描述
        *
        * @apiSuccessExample 删除成功
        *     {
        *       "err_no":0,
        *       "msg":"删除成功"
        *      } 
        *
        * @apiError Error ID参数不正确
        *
        * @apiErrorExample 参数错误
        *    {
        *        "err_no":-1,
        *        "msg":"删除失败"
        *    }
        */
   
   public function del()
   {   $exp_id=  intval(I("get.Id")); //获取Get参数 Id
          if(empty($exp_id)) exit("Id为空注意大小写");
       $ret=$this->model->delExpert($this->Uid,$exp_id);
       $return=array();
       if ($ret!=false)
       {
           $return['err_no']=  0;
           $return['msg'] ="删除成功";
           
       }
       else
       {
           $return['err_no']=  -1;
           $return['msg'] ="删除失败"; //失败的原因是参数不正确
       }
       echo json_encode($return,JSON_UNESCAPED_UNICODE);
    }
      /**
     * 显示收藏的专家
     * GET方式提交参数 http://localhost/MyExports/show?Id=专家的ID
     */
    
    
       /**
        * @api {get} /MyExports/showlist 收藏列表
        * @apiVersion 1.0.0
        * @apiName showlist
        * @apiSuccess {int} err_no 错误码
        * @apiSuccess {String} msg  错误描述
        *
        * @apiSuccessExample 成功列表
        *     {
        *       "err_no":0,
        *       "list":
        *           [
        *               {"ExpertId":"1"},
        *               {"ExpertId":"2"}
        *           ]
        *       }
        *
        * @apiError Error 获取失败
        *
        * @apiErrorExample 获取失败
        *    {
        *        "err_no":-1,
        *        "msg":"获取失败"
        *    }
        */
    
    
    
    
    
    
    
   public function showlist()
   {   //以后要加入分页的功能
       //毕竟不能把已收藏的专家全部发送过去 当然是当用户量大的时候
      $ret=$this->model->showExpert($this->Uid);
       $return=array();
       if (!empty($ret))
       {
           $return['err_no']=  0;
           
           $return['list'] =$ret;
           
       }
       else
       {
           $return['err_no']=  -1;
           $return['msg'] ="获取失败";  
       }
       echo json_encode($return,JSON_UNESCAPED_UNICODE);
   }
   
}
