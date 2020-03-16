<?php

namespace Console\Commands;

use Mix\Core\Timer;

/**
 * Class TimerCommand
 * @package Console\Commands
 * @author liu,jian <coder.keda@gmail.com>
 */
class TimerCommand
{

    /**
     * 主函数
     */
    public function main()
    {
        // 一次性定时
        /*Timer::new()->after(1000, function () {
            println(time());
        });*/

        $a = -1;
        $arr = [];

        // 持续定时
        $timer = new Timer();
        $timer->tick(1, function () use ( &$a , &$arr) {
           /* $db = app()->dbPool->getConnection();
            $db->release(); // 不手动释放的连接不会归还连接池，会在析构时丢
            $ret = $db->table('t_match')->select('*')->first();
            print_r($ret);*/

           //array_push($arr, ++$a);

           //print_r($arr);
            echo ++$a . PHP_EOL;
        });

        // 停止定时
       /* Timer::new()->after(10000, function () use ($timer) {
            $timer->clear();
        });*/
    }

}
