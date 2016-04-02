<?php
header("Content-Type: text/html; charset=utf-8");
require_once(dirname(__FILE__) . '/' . 'IGt.Push.php');
require_once(dirname(__FILE__) . '/' . 'igetui/IGt.AppMessage.php');
require_once(dirname(__FILE__) . '/' . 'igetui/IGt.APNPayload.php');
require_once(dirname(__FILE__) . '/' . 'igetui/template/IGt.BaseTemplate.php');
require_once(dirname(__FILE__) . '/' . 'IGt.Batch.php');
require_once(dirname(__FILE__) . '/' . 'igetui/utils/AppConditions.php');

//http的域名
define('HOST','http://sdk.open.api.igexin.com/apiex.htm');
//https的域名
//define('HOST','https://api.getui.com/apiex.htm');
define('APPKEY','6WZwi9AWko8vzYgaWFStj2');
define('APPID','J219MhUOK68kaFlvSJneC9');
define('MASTERSECRET','HFFzX430Qq99gjIBSYcgj');
define('CID','');
define('DEVICETOKEN','');
//define('BEGINTIME','2015-03-06 13:18:00');
//define('ENDTIME','2015-03-06 13:24:00');


function pushAPN(){

    //APN简单推送
        $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
        $template = new IGtAPNTemplate();
        $apn = new IGtAPNPayload();
        $alertmsg=new SimpleAlertMsg();
        $alertmsg->alertMsg="";
        $apn->alertMsg=$alertmsg;
//        $apn->badge=2;
        $apn->sound="";
        $apn->add_customMsg("payload","payload");
        $apn->contentAvailable=1;
        $apn->category="ACTIONABLE";
        $template->set_apnInfo($apn);
        $message = new IGtSingleMessage();

    //APN高级推送
//        $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
//        $template = new IGtAPNTemplate();
//        $apn = new IGtAPNPayload();
//        $alertmsg=new DictionaryAlertMsg();
//        $alertmsg->body="body";
//        $alertmsg->actionLocKey="ActionLockey";
//        $alertmsg->locKey="LocKey";
//        $alertmsg->locArgs=array("locargs");
//        $alertmsg->launchImage="launchimage";
////        IOS8.2 支持
//        $alertmsg->title="Title";
//        $alertmsg->titleLocKey="TitleLocKey";
//        $alertmsg->titleLocArgs=array("TitleLocArg");
//
//        $apn->alertMsg=$alertmsg;
//        $apn->badge=7;
//        $apn->sound="test1.wav";
//        $apn->add_customMsg("payload","payload");
//        $apn->contentAvailable=1;
//        $apn->category="ACTIONABLE";
//        $template->set_apnInfo($apn);
//        $message = new IGtSingleMessage();

    //PushApn老方式传参
//    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
//    $template = new IGtAPNTemplate();
//    $template->set_pushInfo("actionLocKey", 6, "body", "", "payload", "locKey", "locArgs", "launchImage",1);
//    $message = new IGtSingleMessage();
////
//    $message->set_data($template);
   $ret = $igt->pushAPNMessageToSingle(APPID, DEVICETOKEN, $message);
    var_dump($ret);
}

function pushAPNL(){

    //APN简单推送
//        $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
//        $template = new IGtAPNTemplate();
//        $apn = new IGtAPNPayload();
//        $alertmsg=new SimpleAlertMsg();
//        $alertmsg->alertMsg="";
//        $apn->alertMsg=$alertmsg;
////        $apn->badge=2;
////        $apn->sound="";
//        $apn->add_customMsg("payload","payload");
//        $apn->contentAvailable=1;
//        $apn->category="ACTIONABLE";
//        $template->set_apnInfo($apn);
//        $message = new IGtSingleMessage();

    //APN高级推送
    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    $template = new IGtAPNTemplate();
    $apn = new IGtAPNPayload();
//        $alertmsg=new DictionaryAlertMsg();
//        $alertmsg->body="body";
//        $alertmsg->actionLocKey="ActionLockey";
//        $alertmsg->locKey="LocKey";
//        $alertmsg->locArgs=array("locargs");
//        $alertmsg->launchImage="launchimage";
////        IOS8.2 支持
//        $alertmsg->title="Title";
//        $alertmsg->titleLocKey="TitleLocKey";
//        $alertmsg->titleLocArgs=array("TitleLocArg");
//        $apn->alertMsg=$alertmsg;

//        $apn->badge=7;
//        $apn->sound="com.gexin.ios.silence";
    $apn->add_customMsg("payload","payload");
//        $apn->contentAvailable=1;
//        $apn->category="ACTIONABLE";
    $template->set_apnInfo($apn);
    $message = new IGtSingleMessage();

    //PushApn老方式传参
//    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
//    $template = new IGtAPNTemplate();
//    $template->set_pushInfo("", 4, "", "", "", "", "", "");
//    $message = new IGtSingleMessage();

    //多个用户推送接口
    putenv("needDetails=true");
    $listmessage = new IGtListMessage();
    $listmessage->set_data($template);
    $contentId = $igt->getAPNContentId(APPID, $listmessage);
    //$deviceTokenList = array("3337de7aa297065657c087a041d28b3c90c9ed51bdc37c58e8d13ced523f5f5f");
    $deviceTokenList = array(DEVICETOKEN);
    $ret = $igt->pushAPNMessageToList(APPID, $contentId, $deviceTokenList);
    var_dump($ret);
}


/**
 * 推送任务停止
 * @param string $taskId
 */
function stoptask($taskId){

    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    $igt->stop($taskId);
}

 
 
/**
 * 推送消息到单个用户
 * @param string $CID 用户CID 用户登录后可以从session里面获取到
 * @param string $title 推送的标题
 * @param string $text  推送的内容
 * @return array 返回的结果
 */
function pushMessageToSingle($CID= '' ,$title='',$text=''){
    //$igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    $igt = new IGeTui(NULL,APPKEY,MASTERSECRET,false);
     $template =  new IGtNotificationTemplate();
    $template->set_appId(APPID);//应用appid
    $template->set_appkey(APPKEY);//应用appkey
   // $template->set_transmissionType(1);//透传消息类型
   // $template->set_transmissionContent("测试离线");//透传内容
    $template->set_title($title);//通知栏标题
    $template->set_text($text);//通知栏内容
   // $template->set_logo("http://wwww.igetui.com/logo.png");//通知栏logo
    $template->set_isRing(true);//是否响铃
    $template->set_isVibrate(true);//是否震动
    $template->set_isClearable(true);//通知栏是否可清除
    //个推信息体
    $message = new IGtSingleMessage();

    $message->set_isOffline(true);//是否离线
    $message->set_offlineExpireTime(3600*12*1000);//离线时间
    $message->set_data($template);//设置推送消息类型
    //$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
    //接收方
    $target = new IGtTarget();
    $target->set_appId(APPID);
    $target->set_clientId($CID);
    try {
        $rep = $igt->pushMessageToSingle($message, $target);
        return $rep;

    }catch(RequestException $e){
        $requstId =e.getRequestId();
        $rep = $igt->pushMessageToSingle($message, $target,$requstId);
        return $rep;
    }

}

 
 
/**
 * 对所有的用户都进行推送
 * 用于推送更新什么的
 * @param string $title 推送的标题
 * @param string $text  推送的内容
 * @return array 返回的结果
 */
function pushMessageToApp($title='',$text=''){
    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    $template =  new IGtNotificationTemplate();
    $template->set_appId(APPID);//应用appid
    $template->set_appkey(APPKEY);//应用appkey
   // $template->set_transmissionType(1);//透传消息类型
   // $template->set_transmissionContent("测试离线");//透传内容
    $template->set_title($title);//通知栏标题
    $template->set_text($text);//通知栏内容
    $template->set_isRing(true);//是否响铃
    $template->set_isVibrate(true);//是否震动
    $template->set_isClearable(true);//通知栏是否可清除
    $message = new IGtAppMessage();
    $message->set_isOffline(true);
    $message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
    $message->set_data($template);

    $appIdList=array(APPID);
    //用户属性
    //$age = array("0000", "0010");


    //$cdt = new AppConditions();
   // $cdt->addCondition(AppConditions::PHONE_TYPE, $phoneTypeList);
   // $cdt->addCondition(AppConditions::REGION, $provinceList);
    //$cdt->addCondition(AppConditions::TAG, $tagList);
    //$cdt->addCondition("age", $age);

    $message->set_appIdList($appIdList);
    //$message->set_conditions($cdt->getCondition());

    $rep = $igt->pushMessageToApp($message,"任务组名");
    return $rep;
    
}

//所有推送接口均支持四个消息模板，依次为通知弹框下载模板，通知链接模板，通知透传模板，透传模板
//注：IOS离线推送需通过APN进行转发，需填写pushInfo字段，目前仅不支持通知弹框下载功能

function IGtNotyPopLoadTemplateDemo(){
    $template =  new IGtNotyPopLoadTemplate();

    $template ->set_appId(APPID);//应用appid
    $template ->set_appkey(APPKEY);//应用appkey
    //通知栏
    $template ->set_notyTitle("个推");//通知栏标题
    $template ->set_notyContent("个推最新版点击下载");//通知栏内容
    $template ->set_notyIcon("");//通知栏logo
    $template ->set_isBelled(true);//是否响铃
    $template ->set_isVibrationed(true);//是否震动
    $template ->set_isCleared(true);//通知栏是否可清除
    //弹框
    $template ->set_popTitle("弹框标题");//弹框标题
    $template ->set_popContent("弹框内容");//弹框内容
    $template ->set_popImage("");//弹框图片
    $template ->set_popButton1("下载");//左键
    $template ->set_popButton2("取消");//右键
    //下载
    $template ->set_loadIcon("");//弹框图片
    $template ->set_loadTitle("地震速报下载");
    $template ->set_loadUrl("http://dizhensubao.igexin.com/dl/com.ceic.apk");
    $template ->set_isAutoInstall(false);
    $template ->set_isActived(true);
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息

    return $template;
}

function IGtLinkTemplateDemo(){
    $template =  new IGtLinkTemplate();
    $template ->set_appId(APPID);//应用appid
    $template ->set_appkey(APPKEY);//应用appkey
    $template ->set_title("请输入通知标题");//通知栏标题
    $template ->set_text("请输入通知内容");//通知栏内容
    $template ->set_logo("");//通知栏logo
    $template ->set_isRing(true);//是否响铃
    $template ->set_isVibrate(true);//是否震动
    $template ->set_isClearable(true);//通知栏是否可清除
    $template ->set_url("http://www.igetui.com/");//打开连接地址
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    //iOS推送需要设置的pushInfo字段
//        $apn = new IGtAPNPayload();
//        $apn->alertMsg = "alertMsg";
//        $apn->badge = 11;
//        $apn->actionLocKey = "启动";
//    //        $apn->category = "ACTIONABLE";
//    //        $apn->contentAvailable = 1;
//        $apn->locKey = "通知栏内容";
//        $apn->title = "通知栏标题";
//        $apn->titleLocArgs = array("titleLocArgs");
//        $apn->titleLocKey = "通知栏标题";
//        $apn->body = "body";
//        $apn->customMsg = array("payload"=>"payload");
//        $apn->launchImage = "launchImage";
//        $apn->locArgs = array("locArgs");
//
//        $apn->sound=("test1.wav");;
//        $template->set_apnInfo($apn);
    return $template;
}

function IGtNotificationTemplateDemo(){
    $template =  new IGtNotificationTemplate();
    $template->set_appId(APPID);//应用appid
    $template->set_appkey(APPKEY);//应用appkey
   // $template->set_transmissionType(1);//透传消息类型
   // $template->set_transmissionContent("测试离线");//透传内容
    $template->set_title("专家");//通知栏标题
    $template->set_text("您有一个消息");//通知栏内容
   // $template->set_logo("http://wwww.igetui.com/logo.png");//通知栏logo
    $template->set_isRing(true);//是否响铃
    $template->set_isVibrate(true);//是否震动
    $template->set_isClearable(true);//通知栏是否可清除
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    //iOS推送需要设置的pushInfo字段
//        $apn = new IGtAPNPayload();
//        $apn->alertMsg = "alertMsg";
//        $apn->badge = 11;
//        $apn->actionLocKey = "启动";
//    //        $apn->category = "ACTIONABLE";
//    //        $apn->contentAvailable = 1;
//        $apn->locKey = "通知栏内容";
//        $apn->title = "通知栏标题";
//        $apn->titleLocArgs = array("titleLocArgs");
//        $apn->titleLocKey = "通知栏标题";
//        $apn->body = "body";
//        $apn->customMsg = array("payload"=>"payload");
//        $apn->launchImage = "launchImage";
//        $apn->locArgs = array("locArgs");
//
//        $apn->sound=("test1.wav");;
//        $template->set_apnInfo($apn);
    return $template;
}

function IGtTransmissionTemplateDemo(){
    $template =  new IGtTransmissionTemplate();
    $template->set_appId(APPID);//应用appid
    $template->set_appkey(APPKEY);//应用appkey
    $template->set_transmissionType(1);//透传消息类型
    $template->set_transmissionContent("测试离线ddd");//透传内容
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    //APN简单推送
//        $template = new IGtAPNTemplate();
//        $apn = new IGtAPNPayload();
//        $alertmsg=new SimpleAlertMsg();
//        $alertmsg->alertMsg="";
//        $apn->alertMsg=$alertmsg;
////        $apn->badge=2;
////        $apn->sound="";
//        $apn->add_customMsg("payload","payload");
//        $apn->contentAvailable=1;
//        $apn->category="ACTIONABLE";
//        $template->set_apnInfo($apn);
//        $message = new IGtSingleMessage();

    //APN高级推送
    $apn = new IGtAPNPayload();
    $alertmsg=new DictionaryAlertMsg();
    $alertmsg->body="body";
    $alertmsg->actionLocKey="ActionLockey";
    $alertmsg->locKey="LocKey";
    $alertmsg->locArgs=array("locargs");
    $alertmsg->launchImage="launchimage";
//        IOS8.2 支持
    $alertmsg->title="Title";
    $alertmsg->titleLocKey="TitleLocKey";
    $alertmsg->titleLocArgs=array("TitleLocArg");

    $apn->alertMsg=$alertmsg;
    $apn->badge=7;
    $apn->sound="";
    $apn->add_customMsg("payload","payload");
    $apn->contentAvailable=1;
    $apn->category="ACTIONABLE";
    $template->set_apnInfo($apn);

    //PushApn老方式传参
//    $template = new IGtAPNTemplate();
//          $template->set_pushInfo("", 10, "", "com.gexin.ios.silence", "", "", "", "");

    return $template;
}



?>

