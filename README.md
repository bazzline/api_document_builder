# Api Document Builder

Api document builder centralize api documentation generation and updating of existing projects.
Use it as a cronjob to have the latest documentation in time.
Available at [packagist](https://packagist.org/packages/net_bazzline/api_document_builder) and [openhub.net](https://openhub.net/p/api_document_builder).

[https://www.versioneye.com/user/projects/55f5a588ad2f68000d000651/badge.svg?style=flat](https://www.versioneye.com/user/projects/55f5a588ad2f68000d000651#dialog_dependency_badge)

# Work Flow

* iterating over collection of project paths
* generates documentation using [apigen](https://github.com/ApiGen/ApiGen)
* creates index.html
* do a git pull and evaluates the output to check if there is work to do

# Usage

```
./bin/net_bazzline_api_document_builder path/to/configuration.php
```

# Example

```
mkdir -p net_bazzline/api_document_builder
cd net_bazzline/api_document_builder
git clone https://github.com/bazzline/api_document_builder/ .
./bin/net_bazzline_api_document_builder example/configuration.php
lynx example/output/index.html
```

# History

* upcomming
    * @todo
        * implement usage of [template](https://github.com/bazzline/php_component_template/)
        * add link to current / latest tag (<path>/latest-release)
            * example link: https://github.com/bazzline/php_component_database_file_storage/releases/tag/0.6.2
        * add links for each tag/release
        * add optional link to "demo page"
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
            * validate git pull return message
        * supporting multiple project tags 
* [1.2.0](https://github.com/bazzline/api_document_builder/tree/1.2.0) - released at 29.02.2016
    * moved to psr-4 autoloading
* [1.1.9](https://github.com/bazzline/api_document_builder/tree/1.1.9) - released at 24.01.2016
    * updated dependency
* [1.1.8](https://github.com/bazzline/api_document_builder/tree/1.1.8) - released at 18.12.2015
    * updated dependency
* [1.1.7](https://github.com/bazzline/api_document_builder/tree/1.1.7) - released at 19.11.2015
    * updated dependency
* [1.1.6](https://github.com/bazzline/api_document_builder/tree/1.1.6) - released at 14.11.2015
    * updated dependency
* [1.1.5](https://github.com/bazzline/api_document_builder/tree/1.1.5) - released at 08.11.2015
    * updated dependency
* [1.1.4](https://github.com/bazzline/api_document_builder/tree/1.1.4) - released at 25.09.2015
    * updated dependency
* [1.1.3](https://github.com/bazzline/api_document_builder/tree/1.1.3) - released at 18.09.2015
    * updated dependency
* [1.1.2](https://github.com/bazzline/api_document_builder/tree/1.1.2) - released at 13.09.2015
    * updated dependency
* [1.1.1](https://github.com/bazzline/api_document_builder/tree/1.1.1) - released at 04.07.2015
    * updated dependency
* [1.1.0](https://github.com/bazzline/api_document_builder/tree/1.1.0)
    * implemented feature request of [issue/2](https://github.com/bazzline/api_document_builder/issues/2)
    * see [migration steps](https://github.com/bazzline/api_document_builder/blob/master/migration/from_1.0.x_to_1.1.0.md)
* [1.0.4](https://github.com/bazzline/api_document_builder/tree/1.0.4)
    * fixed [issue/1](https://github.com/bazzline/api_document_builder/issues/1)
* [1.0.3](https://github.com/bazzline/api_document_builder/tree/1.0.3)
    * implemented usage of [progress bar](https://github.com/bazzline/php_component_cli_progress_bar) component
* [1.0.2](https://github.com/bazzline/api_document_builder/tree/1.0.2)
    * added optional "tracking_snippet" support for configuration
    * made index.html valid
* [1.0.1](https://github.com/bazzline/api_document_builder/tree/1.0.1)
    * updated dependency
* [1.0.0](https://github.com/bazzline/api_document_builder/tree/1.0.0)
    * initial release
