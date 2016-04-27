<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;

use Think\Controller;

class ConsulationController extends Controller {

    const CONS_ADD_OK = 0; //添加成功
    const PARAM_ERR = -1; //参数错误

    /**
     * @api {get} /Consulation/Voice 语音咨询
     * @apiVersion 1.0.0
     * @apiName Voice
     * @apiGroup Consulation
     * 
     * @apiSuccess {int} err_no 错误码
     * @apiSuccess {String} msg  错误描述
     * 
     * @apiSuccessExample
     * {
     *       "err_no":0,
     *       "msg":"咨询添加成功"
     * }
     * 
     * @apiError     Error 参数不完整
     * 
     * @apiErrorExample
     * {
     *  "err_no":-1,
     *  "msg":"参数错误 "
     * }
     */

    public function Voice() {

        if (IS_GET) {
            $return = array();
            $describo = I("get.describo");
            $voice = I("get.voice");

            if (!empty($describo) && !empty($voice)) { //
                $Consult = D("consulation"); // 实例化User对象
                $condition = array();
                $condition['Describo'] = $describo;
                $condition['Voice'] = $voice;
                $condition['IsComfirm'] = 0;
                $Consult->add($condition);

                $return['err_no'] = self::CONS_ADD_OK;
                $return['msg'] = "咨询添加成功";
            } else {
                $return['err_no'] = self::PARAM_ERR;
                $return['msg'] = "参数错误";
            }

            echo json_encode($return, JSON_UNESCAPED_UNICODE); //不转义中文 5.4以上
        }
    }

    /**
     * @api {get} /Consulation/Tel 电话咨询
     * @apiVersion 1.0.0
     * @apiName Tel
     * @apiGroup Consulation
     * 
     * @apiSuccess {int} err_no 错误码
     * @apiSuccess {String} msg  错误描述
     * 
     * @apiSuccessExample
     * {
     *       "err_no":0,
     *       "msg":"咨询添加成功"
     * }
     * 
     * @apiError Error 参数不完整
     * 
     * @apiErrorExample
     * {
     *  "err_no":-1,
     *  "msg":"参数错误 "
     * }
     */
    public function Tel() {
        if (IS_GET) {
            $return = array();
            $describo = I("get.describo");
            $teltime = I("get.teltime");

            if (!empty($describo) && !empty($teltime)) { //
                $Consult = D("Consulation"); // 实例化User对象
                $condition = array();
                $condition['Describo'] = $describo;
                $condition['Teltime'] = $teltime;
                $condition['IsComfirm'] = 0;
                $Consult->add($condition);

                $return['err_no'] = self::CONS_ADD_OK;
                $return['msg'] = "咨询添加成功";
            } else {
                $return['err_no'] = self::PARAM_ERR;
                $return['msg'] = "参数错误";
            }
            echo json_encode($return, JSON_UNESCAPED_UNICODE); //不转义中文 5.4以上
        }
    }

    /**
     * @api {get} /Consulation/meet 见面咨询
     * @apiVersion 1.0.0
     * @apiName meet
     * @apiGroup Consulation
     * 
     * @apiSuccess {int} err_no 错误码
     * @apiSuccess {String} msg  错误描述
     * 
     * @apiSuccessExample
     * {
     *       "err_no":0,
     *       "msg":"咨询添加成功"
     * }
     * 
     * @apiError Error 参数不完整
     * 
     * @apiErrorExample
     * {
     *  "err_no":-1,
     *  "msg":"参数错误 "
     * }
     */
    public function meet() {
        if (IS_GET) {
            $return = array();
            $describo = I("get.describo");
            $selfintro = I("get.selfintro");

            if (!empty($describo) && !empty($selfintro)) { //
                $Consult = D("Consulation"); // 实例化User对象
                $condition = array();
                $condition['Describo'] = $describo;
                $condition['SelfIntro'] = $$selfintro;
                $condition['IsComfirm'] = 0;
                $Consult->add($condition);

                $return['err_no'] = self::CONS_ADD_OK;
                $return['msg'] = "咨询添加成功";
            } else {
                $return['err_no'] = self::PARAM_ERR;
                $return['msg'] = "参数错误";
            }
            echo json_encode($return, JSON_UNESCAPED_UNICODE); //不转义中文 5.4以上
        }
    }

}
