<?php

namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {

    public function index() {
        
            import("Org.Getui.Tui");
            //dump(pushMessageToApp("嘿嘿嘿","嘻嘻嘻"));
            //向所有用户推送消息
            
             dump(pushMessageToSingle("552e20f1baf515df2e3780b49c75eb24","嘿嘿嘿","嘻嘻嘻"));
           //向指定用户推送消息
            //返回内容
            //             array(3) {
            //  ["taskId"] => string(41) "OSS-0402_8fb2483d0b31809f14a32f81686510ff"
            //  ["result"] => string(2) "ok"
            //  ["status"] => string(16) "successed_online"
            //}
            $this->display();
        }
    
 

}
