# grumphp-yarn-task
Simple grumphp task akin to the 'npm scripts' task, but runs yarn instead

## Usage

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
