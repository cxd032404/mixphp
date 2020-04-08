<?php

namespace Console\Commands;

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
        //php mix-console hl -n=111 --say=222
        $name = Flag::string(['n', 'name'], 'Xiao Ming');
        $say  = Flag::string('say', 'Hello, World!');
        println("{$name}: {$say}");
    }

}
