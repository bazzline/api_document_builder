<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-24 
 */

namespace Net\Bazzline\Component\ApiDocumentBuilder\Command;

use Net\Bazzline\Component\ApiDocumentBuilder\Service\ApplicationLocator;
use Net\Bazzline\Component\Cli\Arguments\Arguments;

class Builder
{
    /** @var Arguments */
    private $arguments;

    /** @var ApplicationLocator */
    private $locator;

    /** @var string */
    private $source;

    function __construct(array $arguments)
    {
        $this->locator      = new ApplicationLocator();
        $this->arguments    = $this->locator->getCliArguments();

        $this->arguments->parseArguments($arguments);
        $this->source   = basename(array_shift($arguments));
    }

    public function execute()
    {
        //@todo move dependencies fetching into factory
        $arguments  = $this->arguments;
        $locator    = $this->locator;
        $builder    = $locator->getApigenBuilder();

        if ($arguments->hasValues()) {
            $values = $arguments->getValues();
            $pathToConfigurationFile = array_shift($values);

            //@todo implement validation
            $configuration  = require_once $pathToConfigurationFile;

            $cwd                = getcwd();
            $numberOfProjects   = count($configuration['projects']);
            $pathToCache        = $configuration['paths']['cache'];
            $pathToTarget       = $configuration['paths']['target'];
            $progressBar        = $locator->getCliProgressBar();
            $projects           = [];

            $progressBar->setTotalSteps($numberOfProjects);
            echo 'updating projects ' . $numberOfProjects . PHP_EOL;

            foreach ($configuration['projects'] as $project) {
                $git                = $locator->getGit();
                $identifier         = sha1($project['url']);
                $pathToProjectCache = $pathToCache . '/' . $identifier;
                $remove             = $locator->getRemoveDirectory();

                if (!is_dir($pathToProjectCache)) {
                    $create = $locator->getCreateDirectory();
                    $create($pathToProjectCache);
                    chdir($pathToProjectCache);
                    $git->create($project['url'], '.');
                } else {
                    chdir($pathToProjectCache);
                    //only do update if return is not 'Already up-to-date.'
                    $git->update($pathToProjectCache);
                }
                chdir($cwd);
                $remove($pathToTarget . '/' . $identifier);

                $builder->setDestination($pathToTarget . '/' . $identifier);
                $builder->setSource($pathToCache . '/' . $identifier . '/' . $project['source']);
                $builder->setTitle($project['title']);
                $builder->build();

                $projects[] = ['path'  => $identifier, 'title' => $project['title'], 'url'   => $project['url']];
                $progressBar->forward();
            }
            $progressBar->isFinished();
            echo 'generating output' . PHP_EOL;

            //@todo move to separate method
            if (!isset($configuration['template'])) {
                $configuration['template'] = ['layout'        => __DIR__ . '/../Template/layout.html', 'project_view'  => __DIR__ . '/../Template/project_view.html'];
            } else {
                if (!isset($configuration['template']['layout'])) {
                    $configuration['template']['layout'] = __DIR__ . '/../Template/layout.html';
                }
                if (!isset($configuration['template']['project_view'])) {
                    $configuration['template']['project_view'] = __DIR__ . '/../Template/project_view.html';
                }
            }
            $this->renderOutput(
                $pathToTarget . '/index.html',
                $projects, $configuration['title'],
                $configuration['template']['layout'],
                $configuration['template']['project_view']
            );
            echo 'done' . PHP_EOL;
        } else {
            $this->printUsage();
        }
    }

    private function printUsage()
    {
        $usage = $this->source . ' <path to configuration.php>';

        echo $usage . PHP_EOL;
    }

    /**
     * @param string $fileName
     * @param string $title
     * @param string $pathToLayout
     * @param string $pathToProjectView
     */
    private function renderOutput($fileName, array $projects, $title, $pathToLayout, $pathToProjectView)
    {
        //@todo implement validation
        $layout         = file_get_contents($pathToLayout);
        $projectData    = '';
        $projectView    = file_get_contents($pathToProjectView);

        foreach ($projects as $project) {
            $projectData .= str_replace(
                    ['{path}', '{title}', '{url}'],
                    [$project['path'], $project['title'], $project['url']],
                    $projectView
            ) . PHP_EOL;
        }

        $layoutData = str_replace(
            ['{last_updated_at}', '{projects}', '{title}'],
            [date('Y-m-d H:i:s'), $projectData, $title],
            $layout
        );

        file_put_contents($fileName, $layoutData);
    }
}
