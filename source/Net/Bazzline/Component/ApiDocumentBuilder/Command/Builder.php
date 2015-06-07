<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-24 
 */

namespace Net\Bazzline\Component\ApiDocumentBuilder\Command;

use Net\Bazzline\Component\ApiDocumentBuilder\Builder\Apigen;
use Net\Bazzline\Component\ApiDocumentBuilder\Builder\BuilderInterface;
use Net\Bazzline\Component\ApiDocumentBuilder\Service\ApplicationLocator;
use Net\Bazzline\Component\Cli\Arguments\Arguments;
use Net\Bazzline\Component\CommandCollection\Filesystem\Create;
use Net\Bazzline\Component\CommandCollection\Filesystem\Remove;
use Net\Bazzline\Component\CommandCollection\Vcs\Git;

class Builder
{
    /** @var Arguments */
    private $arguments;

    /** @var ApplicationLocator */
    private $locator;

    /** @var string */
    private $source;

    /**
     * @param array $arguments
     */
    function __construct(array $arguments)
    {
        $this->locator      = new ApplicationLocator();
        $this->arguments    = $this->locator->getCliArguments();

        $this->arguments->setArguments($arguments);
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
            $projects           = array();

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

                $projects[] = array(
                    'path'  => $identifier,
                    'title' => $project['title'],
                    'url'   => $project['url']
                );
                $progressBar->forward();
            }
            $progressBar->isFinished();
            echo 'generating output' . PHP_EOL;
            //@todo build index.html
            if (isset($configuration['tracking_snippet'])) {
                file_put_contents($pathToTarget . '/index.html', $this->getContent($projects, $configuration['title'], $configuration['tracking_snippet']));
            } else {
                file_put_contents($pathToTarget . '/index.html', $this->getContent($projects, $configuration['title']));
            }
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
     * @param array $projects
     * @param string $title
     * @param string $trackingSnippet
     * @return string
     */
    private function getContent(array $projects, $title, $trackingSnippet = null)
    {
        $content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>' . $title . '</title>
    </head>
    <body>
        <h1>Available Projects</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Link to Code</th>
                <th>Link to API</th>
            </tr>';

        foreach ($projects as $project) {
            $content .= '
            <tr>
                <td>' . $project['title'] . '</td>
                <td><a href="' . $project['url'] . '" title="code for ' . $project['title'] . '">code</a></td>
                <td><a href="' . $project['path'] . '/index.html" title="api for ' . $project['title'] . '">api</a></td>
            </tr>';
        }

        $content .= '
        </table>
        <p>
            Last updated at ' . date('Y-m-d H:i:s') . '
        </p>' . (!is_null($trackingSnippet) ? PHP_EOL . $trackingSnippet . PHP_EOL : '') . '
    </body>
</html>';

        return $content;
    }
}
