<?php

namespace Http\Controllers;

use Mix\Http\Message\Request\HttpRequestInterface;
use Mix\Http\Message\Response\HttpResponseInterface;
use Mix\Http\Message\Response\HttpResponse;
use Elasticsearch\ClientBuilder;
/**
 * Class IndexController
 * @package Http\Controllers
 * @author liu,jian <coder.keda@gmail.com>
 */
class IndexController
{

    /**
     * 默认动作
     * @return string
     */
    public function actionIndex(HttpRequestInterface $request, HttpResponseInterface $response)
    {
        //        app()->response->format = HttpResponse::FORMAT_JSON;
        app()->response->format = HttpResponse::FORMAT_JSON;

        $client = ClientBuilder::create()->setHosts(['127.0.0.1:9200'])->build();
        //$p = ['index'=>'test_index','type'=>'test_type','id'=>1,'body'=>['a'=>1,'b'=>2]];
        //print_R($p);
        //$re = $client->index($p);
        //print_R($re);

        $pa = 
        [
            'index'=>'test_index',
            'type'=>'test_type',
            'body'=>
                ['query'=>
                    ['bool'=>
                        ['must'=>
                            ['multi_match'=>
                                ['query'=>1,'operator'=>'AND']
                            ]
                        ]
                    ]
                ]
        ];
        $search_return = json_decode(json_encode($client->search($pa)),true);
        //print_R($json_decode(json_encode($client->search($pa)),true));
        //print_R($search_return);
        return $search_return;//json_decode(json_encode($client->search($pa)),true);
    }

    public function actionAaa(HttpRequestInterface $request, HttpResponseInterface $response)
    {
        
        app()->response->format = HttpResponse::FORMAT_JSON;
        $db = app()->request->get('db') ?? "db";
        $sql = app()->request->get('sql') ?? 'show tables';

        $data = ["db"=>$db,"sql"=>$sql];
        $encypt = openssl_encrypt(base64_encode(json_encode($data)),"DES-ECB","hello",0);
        $decypt = openssl_decrypt($encypt,"DES-ECB","hello",0);
        $decypt = json_decode(base64_decode($decypt),true);
        //return $decypt;
        //print_R($request);
        //echo $sql;
        //app()->dump($sql);
        //print_R($id);
        $db = $decypt["db"];
        //$db = $sql = app()->request->get('db');
        $sql = $decypt['sql'];
        //return $db."-".$sql."\n";
        //$db = app()->$db;
        //$ret = $db->prepare($sql)->queryAll();
        //return $ret;
        print_R($decypt);
        $db1 = app()->$db;//->getConnection();
//        $db2 = app()->db_s2;//->getConnection();
        //$db->release(); // 不手动释放的连接不会归还连接池，会在析构时丢
        $ret2 = $db1->table('test_table')->select('*')->where(['id', '>', 1 ])->get();
        $ret = $db1->prepare($sql)->queryAll();
//        $ret2 = $db2->prepare($sql)->queryAll();
        $encypt = openssl_encrypt(json_encode($ret),'DES-ECB',"123456");
        $decypt = openssl_decrypt($encypt,'DES-ECB',"123456");
        return ['code' => 200, 'data' => $ret, 'data2' => $ret2,
            'encypt'=>$encypt,'decypt'=>json_decode($decypt,true),'message' => 'OK'];

    }

}
