<?php
declare(strict_types=1);

namespace YarnTask\Task;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\AbstractExternalTask;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\Context\GitPreCommitContext;
use GrumPHP\Task\Context\RunContext;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GrumPHP\Runner\TaskResultInterface;

class YarnTask extends AbstractExternalTask
{
    public function getName(): string
    {
        return 'yarn';
    }

    public function getConfigurableOptions(): OptionsResolver
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(
            [
                'script' => null,
                'triggered_by' => ['js', 'jsx', 'coffee', 'ts', 'less', 'sass', 'scss'],
                'working_directory' => './',
                'is_run_task' => false,
                'options' => [],
            ]
        );

        $resolver->addAllowedTypes('script', ['string']);
        $resolver->addAllowedTypes('options', ['array']);
        $resolver->addAllowedTypes('triggered_by', ['array']);
        $resolver->addAllowedTypes('working_directory', ['string']);
        $resolver->addAllowedTypes('is_run_task', ['bool']);

        return $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function canRunInContext(ContextInterface $context): bool
    {
        return $context instanceof GitPreCommitContext || $context instanceof RunContext;
    }

    /**
     * {@inheritdoc}
     */
    public function run(ContextInterface $context): TaskResultInterface
    {
        $config = $this->getConfiguration();
        $files = $context->getFiles()->extensions($config['triggered_by']);
        if (0 === \count($files)) {
            return TaskResult::createSkipped($this, $context);
        }

        $arguments = $this->processBuilder->createArgumentsForCommand('yarn');
        $arguments->addOptionalArgument('run', $config['is_run_task']);
        $arguments->addRequiredArgument('%s', $config['script']);

        foreach ($config['options'] as $option) {
            $arguments->addOptionalArgument('%s', $option);
        }

        $process = $this->processBuilder->buildProcess($arguments);
        $process->setWorkingDirectory(realpath($config['working_directory']));

        $process->run();

        if (!$process->isSuccessful()) {
            return TaskResult::createFailed($this, $context, $this->formatter->format($process));
        }

        return TaskResult::createPassed($this, $context);
    }

}
