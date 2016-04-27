<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;

use Think\Controller;

/**
 * Description of MyPageController
 *
 * @author Kroaity
 */
class MyPageController extends Controller {

    const USER_NOT_EXIST = -1; //用户不存在
    const USER_NOT_LOGIN = -2; //用户未登陆
    const MESS_GET_SUCES = 100;
    const MESS_MOD_SUCES = 101;

   /**
     * @api {get} /MyInfo 获取我的资料
     * @apiName MyInfo
     * @apiGroup MyPage
     * 
     * @apiSuccess {int} err_no 错误码
     * @apiSuccess {String} msg  错误描述
     * 
     * @apiSuccessExample
     * {
     *       "err_no":100,
     *       "msg":"获取成功"
     * }
     * 
     * @apiError 用户不存在或者未登陆
     * 
     * @apiErrorExample
     * {
     *  "err_no":-1,
     *  "msg":"用户不存在 "
     * }
     * 
     * @apiErrorExample
     * {
     *  "err_no":-2,
     *  "msg":"用户未登陆"
     * }
     * 
     */
    public function MyInfo() {
        //$id=1;
        $id = seesion('Uid');
        if (!isset($id)) {
            $ret['err_no'] = USER_NOT_LOGIN;
            $ret['msg'] = "用户未登陆";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }



        $U = D('user');
        if ($Ret = $U->where("id=$id")->find()) {
            $ret['Motto'] = $Ret['Motto'];
            $ret['Name'] = $Ret['RealName'];
            $ret['Title'] = $Ret['Title'];
            $ret['ConsultNum'] = $Ret['Beconsult'];
            $ret['Becollected'] = $Ret['Becollected'];
            $ret['Introduce'] = $Ret['SelfINtro'];
            $ret['err_no'] = MESS_GET_SUCES;
            $ret['msg'] = "获取成功";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        } else {
            $ret['err_no'] = USER_NOT_EXIST;
            $ret['msg'] = "用户不存在";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * @api {get} http://localhost/memorytech/index.php/Home/MyPage/Myassess
     * @apiName Myassess
     * @apiGroup MyPage
     * 
     * @apiSuccess {int} err_no 错误码
     * @apiSuccess {String} msg  错误描述
     * @apiSuccess {Array} 0,1,2... 取得的评论
     * 
     * @apiSuccessExample
     * {
     *       "err_no":100,
     *       "msg":"获取成功"
     *      "0":{"Name":"于小猫","Motto":"隔壁老王就是我\n","text":"123"}
     * }
     * 
     * @apiError 用户不存在或者未登陆
     * 
     * @apiErrorExample
     * {
     *  "err_no":-1,
     *  "msg":"用户不存在 "
     * }
     * 
     * @apiErrorExample
     * {
     *  "err_no":-2,
     *  "msg":"用户未登陆"
     * }
     * 
     */
    public function Myassess() {
        //$id=1;
        $id = seesion('Uid');
        if (!isset($id)) {
            $ret['err_no'] = USER_NOT_LOGIN;
            $ret['msg'] = "用户未登陆";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }

        $A = D('assess');
        $U = D('user');
        if ($Ret = $A->where("ExpId=$id")->select()) {
            $len = count($Ret);

            //dump($Ret);

            for ($i = 0; $i < $len; $i++) {
                $sei = $Ret[$i]["UserId"];
                $ret[$i]["Name"] = $U->where("Id=$sei")->getField('RealName');
                $ret[$i]['Motto'] = $U->where("Id=$sei")->getField("Motto");
                $ret[$i]['text'] = $Ret[$i]['text'];
            }
            $ret['err_no'] = MESS_GET_SUCES;
            $ret['msg'] = "获取成功";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        } else {
            $ret['err_no'] = USER_NOT_EXIST;
            $ret['msg'] = "用户不存在";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * @api {get} http://localhost/memorytech/index.php/Home/MyPage/MyBalance
     * @apiName MyBalance
     * @apiGroup MyPage
     * 
     * @apiSuccess {int} err_no 错误码
     * @apiSuccess {String} msg  错误描述
     * @apiSuccess {float} balance 余额
     * 
     * @apiSuccessExample
     * {
     *       "err_no":100,
     *       "msg":"获取成功"
     *      "balance":"1000.00"
     * }
     * 
     * @apiError 用户不存在或者未登陆
     * 
     * @apiErrorExample
     * {
     *  "err_no":-1,
     *  "msg":"用户不存在 "
     * }
     * 
     * @apiErrorExample
     * {
     *  "err_no":-2,
     *  "msg":"用户未登陆"
     * }
     * 
     */
    public function MyBalance() {
        $id = 1;
        //$id=seesion('Uid');
        if (!isset($id)) {
            $ret['err_no'] = USER_NOT_LOGIN;
            $ret['msg'] = "用户未登陆";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }

        $U = D('user');
        if ($Ret = $U->where("Id=$id")->getField("Balance")) {
            $ret['err_no'] = MESS_GET_SUCES;
            $ret['msg'] = "获取成功";
            $ret['balance'] = $Ret;

            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        } else {
            $ret['err_no'] = USER_NOT_EXIST;
            $ret['msg'] = "用户不存在";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * @api {post} http://localhost/memorytech/index.php/Home/MyPage/EditMotto
     * @apiName EditMotto
     * @apiGroup MyPage
     * 
     * @apiParam {String} motto 座右铭
     * 
     * @apiSuccess {int} err_no 错误码
     * @apiSuccess {String} msg  错误描述
     * 
     * 
     * @apiSuccessExample
     * {
     *       "err_no":101,
     *       "msg":"修改成功"
     *      
     * }
     * 
     * @apiError 用户不存在或者未登陆
     * 
     * @apiErrorExample
     * {
     *  "err_no":-1,
     *  "msg":"用户不存在 "
     * }
     * 
     * @apiErrorExample
     * {
     *  "err_no":-2,
     *  "msg":"用户未登陆"
     * }
     * 
     */
    public function EditMotto() {
        $id = seesion('Uid');
        if (!isset($id)) {
            $ret['err_no'] = USER_NOT_LOGIN;
            $ret['msg'] = "用户未登陆";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        } else {
            $newMotto = I("post.motto");
            $U = D('user');
            $data['id'] = $id;
            $data['Motto'] = $newMotto;
            $U->save($data);

            $ret['err_no'] = MESS_MOD_SUCES;
            $ret['msg'] = "修改成功";

            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * @api {post} http://localhost/memorytech/index.php/Home/MyPage/EditPrice
     * @apiName EditPrice
     * @apiGroup MyPage
     * 
     * @apiParam {int} PriceMet 面谈价格
     * @apiParam {int} PriceTel 电话价格 
     * @apiParam {int} PriceTAG 图文价格

     * @apiSuccess {int} err_no 错误码
     * @apiSuccess {String} msg  错误描述
     * 
     * 
     * @apiSuccessExample
     * {
     *       "err_no":101,
     *       "msg":"修改成功"
     *      
     * }
     * 
     * @apiError 用户不存在或者未登陆
     * 
     * @apiErrorExample
     * {
     *  "err_no":-1,
     *  "msg":"用户不存在 "
     * }
     * 
     * @apiErrorExample
     * {
     *  "err_no":-2,
     *  "msg":"用户未登陆"
     * }
     * 
     */
    public function EditPrice() {
        $id = seesion('Uid');
        if (!isset($id)) {
            $ret['err_no'] = USER_NOT_LOGIN;
            $ret['msg'] = "用户未登陆";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        } else {
            $newPriceMet = I("post.PriceMet");
            $newPriceTel = I("post.PriceTel");
            $newPriceTAG = I("post.PRiceTAG");

            $U = D('user');
            $data['id'] = $id;
            $data['PriceMet'] = $$newPriceMet;
            $data['PriceTel'] = $$newPriceTel;
            $data['PriceTAG'] = $$newPriceTAG;
            $U->save($data);

            $ret['err_no'] = MESS_MOD_SUCES;
            $ret['msg'] = "修改成功";

            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     *  @api {post} http://localhost/memorytech/index.php/Home/MyPage/EditTitle
     * @apiName EditTitle
     * @apiGroup MyPage
     * 
     * @apiParam {string} title 头像  
     * @apiSuccess {int} err_no 错误码
     * @apiSuccess {String} msg  错误描述
     * 
     * 
     * @apiSuccessExample
     * {
     *       "err_no":101,
     *       "msg":"修改成功"
     *      
     * }
     * 
     * @apiError 用户不存在或者未登陆
     * 
     * @apiErrorExample
     * {
     *  "err_no":-1,
     *  "msg":"用户不存在 "
     * }
     * 
     * @apiErrorExample
     * {
     *  "err_no":-2,
     *  "msg":"用户未登陆"
     * }
     * 
     */
    public function EditTitle() {
        $id = seesion('Uid');
        if (!isset($id)) {
            $ret['err_no'] = USER_NOT_LOGIN;
            $ret['msg'] = "用户未登陆";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        } else {
            $newTitle = I("post.title");
            $U = D('user');
            $data['id'] = $id;
            $data['Title'] = $newTitle;
            $U->save($data);

            $ret['err_no'] = MESS_MOD_SUCES;
            $ret['msg'] = "修改成功";

            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * @api {post} http://localhost/memorytech/index.php/Home/MyPage/EditIntro
     * @apiName EditIntro
     * @apiGroup MyPage
     * 
     * @apiParam {string} intro 自我描述


     * @apiSuccess {int} err_no 错误码
     * @apiSuccess {String} msg  错误描述
     * 
     * 
     * @apiSuccessExample
     * {
     *       "err_no":101,
     *       "msg":"修改成功"
     *      
     * }
     * 
     * @apiError 用户不存在或者未登陆
     * 
     * @apiErrorExample
     * {
     *  "err_no":-1,
     *  "msg":"用户不存在 "
     * }
     * 
     * @apiErrorExample
     * {
     *  "err_no":-2,
     *  "msg":"用户未登陆"
     * }
     * 
     */
    public function EditIntro() {
        $id = seesion('Uid');
        if (!isset($id)) {
            $ret['err_no'] = USER_NOT_LOGIN;
            $ret['msg'] = "用户未登陆";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        } else {
            $newIntro = I("post.intro");
            $U = D('user');
            $data['id'] = $id;
            $data['SelfIntro'] = $newIntro;
            $U->save($data);

            $ret['err_no'] = MESS_MOD_SUCES;
            $ret['msg'] = "修改成功";

            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * @api {get} http://localhost/memorytech/index.php/Home/MyPage/EditAvatar
     * @apiName EditAvatar
     * @apiGroup MyPage
     * 
     * @apiParam {string} Avatar 头像图片的url


     * @apiSuccess {int} err_no 错误码
     * @apiSuccess {String} msg  错误描述
     * 
     * 
     * @apiSuccessExample
     * {
     *       "err_no":101,
     *       "msg":"修改成功"
     *      
     * }
     * 
     * @apiError 用户不存在或者未登陆
     * 
     * @apiErrorExample
     * {
     *  "err_no":-1,
     *  "msg":"用户不存在 "
     * }
     * 
     * @apiErrorExample
     * {
     *  "err_no":-2,
     *  "msg":"用户未登陆"
     * }
     * 
     */
    public function EditAvatar() {
        $id = seesion('Uid');
        if (!isset($id)) {
            $ret['err_no'] = USER_NOT_LOGIN;
            $ret['msg'] = "用户未登陆";
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        } else {
            $newAvatar = I("get.Avatar");
            $U = D('user');
            $data['id'] = $id;
            $data['Avatar'] = $newAvatar;
            $U->save($data);

            $ret['err_no'] = MESS_MOD_SUCES;
            $ret['msg'] = "修改成功";

            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }
    }

}
