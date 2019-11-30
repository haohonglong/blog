<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/03/2018
 * Time: 12:36 PM
 */

namespace backend\controllers;

use backend\models\Catches;
use yii;




class CatchController extends BaseController
{


    public function actionIndex_()
    {


        $url = 'http://blog.admin/html/rr33tt.com.html';

        $rules = [
                'title'=>['.item h3>a','text'],
                'href'=>['.item h3>a','href'],
            ];
        /**
         * first get of all title and href of title then get
         */
        $arr = QueryList::get($url)->rules($rules)->query()->getData()->toArray();
        $data = [];
        foreach ($arr as $k =>&$v){
            $v['href'] = 'https://www.rr33tt.com'.$v['href'];
            $data[] = [
                $v['title'],
                $v['href'],
                time(),
            ];
        }



        var_dump($data);
//        Yii::$app->db->createCommand()->batchInsert('rr33tt_title',['title','href','create_by'], $data)->execute();
        exit;


    }

    /**
     * @author: lhh
     * 创建日期：2019-09-06
     * 修改日期：2019-09-06
     * 名称： http_curl
     * 功能：
     * 说明：
     * 注意：
     * @param $url
     * @param string $params
     * @param string $type
     * @return mixed
     */
    private function http_curl($url,$params='',$type='GET')
    {
        $ch = curl_init();

// 2. 设置选项
        curl_setopt($ch, CURLOPT_URL,$url);  // 设置要抓取的页面地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);              // 抓取结果直接返回（如果为0，则直接输出内容到页面）
        curl_setopt($ch, CURLOPT_HEADER, 0);                      // 不需要页面的HTTP头

// 3. 执行并获取HTML文档内容，可用echo输出内容
        $output = curl_exec($ch);

// 4. 释放curl句柄
        curl_close($ch);
        return $output;

    }

    public function actionIndex()
    {

        $request = Yii::$app->request;
        if($request->isPost){
            $root = $request->post('root');
            $url = $request->post('url');
            $path = $request->post('path');
            $replace = $request->post('replace');
            $search = $request->post('search');

            $catch = new Catches($url,$path);
            foreach ($search as $k => $v){
                $catch->replace($search[$k],$replace[$k]);
            }
            $catch->run();
            if($root != 'null'){
                $catch->replace($root,$catch->rel_path);
            }
            $catch->saved();
            echo $catch->getContent();
            exit;
        }

        return $this->render('index');



    }






}