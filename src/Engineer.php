<?php

namespace Tower;

use Tower\Console\Color;

class Engineer
{
    protected string $version;

    protected array $commands = [
        'build' => [
            'controller' ,
            'resource' ,
            'middleware' ,
            'job' ,
            'exception' ,
            'task' ,
            'test' ,
        ] ,
        'factory' => [
            'settingUp'
        ] ,
        'tests' => [
            'run'
        ] ,
    ];

    protected array $description = [
        'build' => [
            'controller' => '       create a new controller class' ,
            'resource' => '         create a new resource class' ,
            'middleware' => '       create a new middleware class' ,
            'job' => '              create a new job class' ,
            'exception' => '        create a new exception class' ,
            'task' => '             create a new task class' ,
            'test' => '             create a new test class' ,
        ],
        'factory' => [
            'settingUp' => '        Please run the {php engineer factory:settingUp start} command to start the factory' ,
        ],
        'tests' => [
            'run' => '              run all tests' ,
        ],
    ];

    protected array $class = [
        'build' => [
            'controller' => [
                'class' => 'Build\Controller' ,
                'method' => 'build'
            ] ,
            'resource' => [
                'class' => 'Build\Resource' ,
                'method' => 'build'
            ] ,
            'middleware' => [
                'class' => 'Build\Middleware' ,
                'method' => 'build'
            ] ,
            'job' => [
                'class' => 'Build\Job' ,
                'method' => 'build'
            ] ,
            'exception' => [
                'class' => 'Build\Exception' ,
                'method' => 'build'
            ] ,
            'task' => [
                'class' => 'Build\Task' ,
                'method' => 'build'
            ] ,
            'test' => [
                'class' => 'Build\Test' ,
                'method' => 'build'
            ] ,
        ],
        'factory' => [
            'settingUp' => [
                'class' => 'Factory\SettingUp' ,
                'method' => 'run' ,
            ] ,
        ],
        'tests' => [
            'run' => [
                'class' => 'Tests\Test' ,
                'method' => 'run' ,
            ] ,
        ],
    ];

    public function __construct(string $version)
    {
        $this->version = $version;
    }

    public function run(array $arguments): void
    {
        if (count($arguments) == 1){
            $this->commands();
            return;
        }

        $operation = explode(':' , $arguments[1]);

        if (count($operation) == 1){
            $this->oneArgument($operation , $arguments);
            return;
        }

        $this->multiArguments($operation , $arguments);
    }

    protected function oneArgument(array $operation , array $arguments): void
    {
        if (! array_key_exists($operation[0] , $this->commands) || is_array($this->commands[$operation[0]])){
            echo Color::error("command not found!");
            return;
        }

        $class = 'Tower\\Engineer\\' . $this->class[$operation[0]]['class'];
        $method = $this->class[$operation[0]]['method'];
        $operation = new $class();
        $operation->$method($arguments);
    }
    protected function multiArguments(array $operation , array $arguments): void
    {
        if (! array_key_exists($operation[0] , $this->commands)){
            echo Color::error("command not found!");
            return;
        }

        if (! in_array($operation[1] , $this->commands[$operation[0]])){
            echo Color::error("command not found!");
            return;
        }

        $class = 'Tower\\Engineer\\' . $this->class[$operation[0]][$operation[1]]['class'];
        $method = $this->class[$operation[0]][$operation[1]]['method'];
        $operation = new $class();
        $operation->$method($arguments);
    }

    protected function commands(): void
    {
        echo Color::LIGHT_WHITE . 'tower framework ' . Color::LIGHT_BLUE . $this->version . Color::RESET . PHP_EOL . PHP_EOL;
        echo Color::GREEN . 'Hello
I am the engineer of your tower and I am ready to help you
What did he do to me?' . Color::RESET . PHP_EOL . PHP_EOL;

        echo Color::LIGHT_GRAY . 'What can I do to help?' . Color::RESET . PHP_EOL . PHP_EOL;

        foreach ($this->commands as $index => $command){
            if (is_int($index))
                echo Color::YELLOW . " $command" . Color::RESET;
            else
                echo Color::YELLOW . " $index" . Color::RESET . PHP_EOL;
            if (is_array($command)){
                foreach ($command as $item){
                    $description = Color::WHITE . $this->description[$index][$item];
                    echo Color::GREEN . "  $item $description" . Color::RESET . PHP_EOL;
                }
            }else{
                $description = Color::WHITE . $this->description[$command];
                echo Color::GREEN . "  $description" . Color::RESET . PHP_EOL;
            }
        }
    }
}