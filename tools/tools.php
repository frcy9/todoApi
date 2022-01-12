<?php

namespace App\tools;
use App\Http\Controllers\Controller;

class WechatPush extends Controller
{

    /**
     * start
     * 外层调用方式： （待研究）
     * $WeChatPush = new WeChatPush('wx37f7e6dc95d94cf7', '448579acb2e39aeed97e52a754537901');
     */

    //微信公众号appid
    protected $appid;
    //微信公众号secret
    protected $secret;
    /**
     * 构造方法
     * [__construct description]
     * @Pasa吴
     * @DateTime 2019-01-22T16:39:56+0800
     * @param    [type]                   $appid  [微信公众号appid]
     * @param    [type]                   $secret [微信公众号secret]
     */
    public function __construct($appid, $secret)
    {
        $this->appid  = $appid;
        $this->secret = $secret;
    }
    /**
     * 发送推送
     * [send description]
     * @Pasa吴
     * @DateTime 2019-01-22T21:02:04+0800
     * @param    [type]                   $openid      [用户openid]
     * @param    [type]                   $template_id [模板ID]
     * @param    [type]                   $url         [跳转URL]
     * @param    [type]                   $_data       [模板内容]
     * @return   [type]                                [description]
     */
    public function push($openid, $template_id, $url, $_data)
    {
        //提交成功，触发信息推送
        $data = [
            'touser'      => $openid,
            'template_id' => $template_id,
            'url'         => $url,
            'topcolor'    => "#FF0000",
            'data'        => $_data,
        ];
        $get_all_access_token = $this->getAllAccessToken();
        $json_data            = json_encode($data); //转化成json数组让微信可以接收
        $url                  = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $get_all_access_token['access_token']; //模板消息请求URL

        $res = $this->curlRequest($url, urldecode($json_data)); //请求开始
        $res = json_decode($res, true);
        return $res;
    }
    /**
     * 获取微信 AccessToken
     * [getAllAccessToken description]
     * @Pasa吴
     * @DateTime 2019-01-22T21:03:03+0800
     * @return   [type]                   [description]
     */
    public function getAllAccessToken()
    {
        $wxTokenUrl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->appid . '&secret=' . $this->secret;

        if (!Cache::get('access_token')) {
            $access_token = $this->curlRequest($wxTokenUrl);
            $access_token = json_decode($access_token, true);
            if (!empty($access_token['errcode'])) {
                // var_dump(['code'=>2004,'msg'=>'请求微信服务器access_token失败']);
                return;
            }
            Cache::set('access_token', $access_token['access_token'], 7000);
        } else {
            $access_token['access_token'] = Cache::get('access_token');
        }
        return $access_token;
    }
    /**
     * curl方法
     * @param $url 请求url
     * @param $data 传送数据，有数据时使用post传递
     * @param type 为2时,设置json传递
     */
    public function curlRequest($url, $data = null, $type = 1)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            if ($type == 2) {
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
            }
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}
