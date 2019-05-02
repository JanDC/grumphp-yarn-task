<?php
declare(strict_types=1);

namespace YarnTask\Extension;

use GrumPHP\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use YarnTask\Task\YarnTask;

class Loader implements ExtensionInterface{

    public function load(ContainerBuilder $container)
    {
        $container->register('task.yarn', YarnTask::class)
            ->addArgument(new Reference('config'))
            ->addArgument(new Reference('process_builder'))
            ->addArgument(new Reference('formatter.raw_process'))
            ->addTag('grumphp.task', ['config' => 'yarn']);
    }
}