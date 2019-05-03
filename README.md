# grumphp-yarn-task
Simple grumphp task akin to the 'npm_script' task, but runs yarn instead

## Usage
### Installation
To install the yarn task simply run <br>
`composer require jandc/grumphp-yarn-task` <br>
or <br>
`composer global require jandc/grumphp-yarn-task`

depending on your grumphp location

You can register the task by adding it's extension:
```yaml
# grumphp.yml
parameters:
    extensions:
        - YarnTask\Extension\Loader
```

### Configuration
Usage is almost identical to npm_script: <br>
(https://github.com/phpro/grumphp/blob/v0.15.0/doc/tasks/npm_script.md)
```yaml
# grumphp.yml
parameters:
    tasks:
        yarn:
            script: lint
            options:
                - '--no-fix'
                - '--max-warnings=0'
            triggered_by: [js, jsx, coffee, ts, less, sass, scss]
            working_directory: ./
            is_run_task: false
```

Note the extra 'options' array which can be used to append extra parameters to your scripts
