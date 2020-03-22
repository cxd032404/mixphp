<?php

namespace Console\Commands;

use Elasticsearch\ClientBuilder;
use Mix\Console\CommandLine\Flag;

/**
 * Class HelloCommand
 * @package Console\Commands
 * @author liu,jian <coder.keda@gmail.com>
 */
class HelloCommand
{

    /**
     * 主函数
     */
    public function main()
    {
        $redis = app()->redis;
        $redis_key = "redis_test";
        $rand = rand(1,9);
        echo "rand:".$rand."\n";
        echo "redis:".$redis->incrBy($redis_key,$rand)."\n";
        $name = Flag::string(['n', 'name'], 'Xiao Ming');
        $say  = Flag::string('say', 'Hello, World!');
        println("{$name}: {$say}");

        $db1 = app()->db_s1;//->getConnection();
        $db2 = app()->db_s2;//->getConnection();

        $ret1 = $db1->table('test_table')->select('*')->where(['id', '>', 1 ])->get();
        print_r($ret1);
        $sql = "select * from test_table";
        $ret2 = $db2->prepare($sql)->queryAll();
        print_R($ret2);

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

        print_R($search_return);

    }

}
