<?php
// +----------------------------------------------------------------------
// | Created by PhpStorm
// +----------------------------------------------------------------------
// | Date: 2019-05-24
// +----------------------------------------------------------------------
// | Blog: ( http://www.woann.cn )
// +----------------------------------------------------------------------
// | Author: woann <www.woann.cn>
// +----------------------------------------------------------------------


class Wechat
{
    /**
     * @Author woann <www.woann.cn>
     * @param $code
     * @return array
     * @des 获取用户信息
     */
    public function getUserInfoByWx($code)
    {
        $app = config('wechat.app');//获取app_id,secret
        //获取认证信息
        $auth_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$app['appid']."&secret=".$app['secret']."&code=".$code."&grant_type=authorization_code";
        $auth_res = httpRequest($auth_url);
        if(isset($auth_res['errcode'])){
            return ['code' => $auth_res['errcode'], 'msg' => $auth_res['errmsg']];
        }
        //获取用户信息
        $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$auth_res['access_token']."&openid=".$auth_res['openid']."&lang=zh_CN";
        $userinfo = httpRequest($info_url);
        if(isset($userinfo['errcode'])){
            return ['code' => $userinfo['errcode'], 'msg' => $userinfo['errmsg']];
        }
        //返回用户信息
        return ['code' => 200, 'msg' => $userinfo];
    }
}