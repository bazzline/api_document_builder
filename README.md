# Api Document Builder

Api document builder centralize api documentation generation and updating of existing projects.
Use it as a cronjob to have the latest documentation in time.

# Work Flow

* iterating over collection of project paths
* generates documentation using [apigen](https://github.com/ApiGen/ApiGen)
* creates index.html
* do a git pull and evaluates the output to check if there is work to do

# Usage

```
./bin/net_bazzline_api_document_builder path/to/configuration.php
```

# History

* upcomming
    * @todo
        * refactor by using the [process pipe](https://github.com/bazzline/php_component_process_pipe) component
        * refactor by using the [requirement](https://github.com/bazzline/php_component_requirement) component
        * implement unit tests
        * make it dynamically
            * use [diactoros](https://github.com/zendframework/zend-diactoros)
            * generate a index.php instead of a index.html
            * add htaccess
            * <url>/my_project should be callable and transform into a redirect (if exists)
        * easy up adding project
            * <add> <url to composer.json>
            * parse composer.json
        * easy up deleting project
            * <validate>
            * deletes all where response code is greater or equal 300
        * add more documentation generators (beside apigen)
        * create factories
        * add "keep_cache" (boolean) value
        * implement cache and output cleanup (if project is moved or deleted etc.)
        * supporting multiple project tags 
* [1.0.0](https://github.com/bazzline/api_document_builder/tree/1.0.0)
    * initial release
