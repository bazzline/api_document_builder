<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-24 
 */

return array(
    'paths' => array(
        'cache'     => __DIR__ . '/cache',
        'target'    => __DIR__ . '/output'
    ),
    'projects' => array(
        array(
            'source'        => 'source/Net/Bazzline/Component/Command/',
            'title'         => 'Command by Bazzline',
            'url'           => 'https://github.com/bazzline/php_component_command'
        ),
        array(
            'source'        => 'source/Net/Bazzline/Component/Cli/Arguments',
            'title'         => 'Cli Arguments by Bazzline',
            'url'           => 'https://github.com/bazzline/php_component_cli_arguments'
        )
    ),
    'template' => array(
        'layout'        => __DIR__ . '/layout.html',
        'project_view'  => __DIR__ . '/project_view.html'
    ),
    'title' => 'www.bazzline.net'
);
