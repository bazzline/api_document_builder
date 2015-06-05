<?php

return array(
    'assembler' => '\Net\Bazzline\Component\Locator\Configuration\Assembler\FromArrayAssembler',
    'class_name' => 'ApplicationLocator',    //determines file name as well as php class name
    'file_exists_strategy' => '\Net\Bazzline\Component\Locator\FileExistsStrategy\DeleteStrategy',
    'file_path' => __DIR__ . '/../source/Net/Bazzline/Component/ApiDocumentBuilder/Service',
    'instances' => array(
        array(
            'alias'         => 'CliArguments',
            'class_name'    => '\Net\Bazzline\Component\Cli\Arguments\Arguments',
            'is_factory'    => false,
            'is_shared'     => true
        ),
        array(
            'alias'         => 'ApigenBuilder',
            'class_name'    => '\Net\Bazzline\Component\ApiDocumentBuilder\Builder\Apigen',
            'is_factory'    => false,
            'is_shared'     => true
        ),
        array(
            'alias'         => 'CreateDirectory',
            'class_name'    => '\Net\Bazzline\Component\CommandCollection\Filesystem\Create',
            'is_factory'    => false,
            'is_shared'     => true
        ),
        array(
            'alias'         => 'Git',
            'class_name'    => '\Net\Bazzline\Component\CommandCollection\Vcs\Git',
            'is_factory'    => false,
            'is_shared'     => true
        ),
        array(
            'alias'         => 'RemoveDirectory',
            'class_name'    => '\Net\Bazzline\Component\CommandCollection\Filesystem\Remove',
            'is_factory'    => false,
            'is_shared'     => true
        )
    ),
    'method_prefix' => 'get',
    'namespace' => 'Net\Bazzline\Component\ApiDocumentBuilder\Service',
);