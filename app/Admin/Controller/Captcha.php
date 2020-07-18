<?php

/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/20
 * Time: 13:42
 */

namespace app\Admin\Controller;

use dcr\Session;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Captcha
{
    /**
     * 输出验证码
     * @param int $width
     * @param int $height
     */
    public function output(int $width = 154, int $height = 40)
    {
        //得出等级
        $clsConfig = new \app\Model\Config();
        $level = $clsConfig->getSystemConfig('captcha_level');
        $phraseBuilder = new PhraseBuilder(4);
        switch ($level) {
            case 1:
                $phraseBuilder = new PhraseBuilder(4, '0123456789');
                break;
            case 2:
                $phraseBuilder = new PhraseBuilder(4);
                break;
        }
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build($width, $height);
        $quality = 90;
        switch ($level) {
            case 1:
                $quality = 100;
                $builder->setMaxBehindLines(1);
                $builder->setMaxFrontLines(1);
                //$builder->setBackgroundColor(1, 1, 1);
                //$builder->setDistortion(true);
                break;
            case 2:
                $builder->setMaxBehindLines(2);
                $builder->setMaxFrontLines(2);
                $quality = 80;
                break;
        }
        Session::_set('captcha', $builder->getPhrase());
        header('Content-type: image/jpeg');
        $builder->output($quality);
    }
}
