<?php
/**
 * @author Net\Bazzline\Component\Locator
 * @since 2015-06-07
 */

namespace Net\Bazzline\Component\ApiDocumentBuilder\Service;

/**
 * Class ApplicationLocator
 *
 * @package Net\Bazzline\Component\ApiDocumentBuilder\Service
 */
class ApplicationLocator
{
    /**
     * @var $sharedInstancePool
     */
    private $sharedInstancePool = [];

    /**
     * @return \Net\Bazzline\Component\Cli\Arguments\Arguments
     */
    public function getCliArguments()
    {
        return $this->fetchFromSharedInstancePool(\Net\Bazzline\Component\Cli\Arguments\Arguments::class);
    }

    /**
     * @return \Net\Bazzline\Component\Cli\ProgressBar\ProgressBar
     */
    public function getCliProgressBar()
    {
        return $this->fetchFromSharedInstancePool(\Net\Bazzline\Component\Cli\ProgressBar\ProgressBar::class);
    }

    /**
     * @return \Net\Bazzline\Component\ApiDocumentBuilder\Builder\Apigen
     */
    public function getApigenBuilder()
    {
        return $this->fetchFromSharedInstancePool(\Net\Bazzline\Component\ApiDocumentBuilder\Builder\Apigen::class);
    }

    /**
     * @return \Net\Bazzline\Component\CommandCollection\Filesystem\Create
     */
    public function getCreateDirectory()
    {
        return $this->fetchFromSharedInstancePool(\Net\Bazzline\Component\CommandCollection\Filesystem\Create::class);
    }

    /**
     * @return \Net\Bazzline\Component\CommandCollection\Vcs\Git
     */
    public function getGit()
    {
        return $this->fetchFromSharedInstancePool(\Net\Bazzline\Component\CommandCollection\Vcs\Git::class);
    }

    /**
     * @return \Net\Bazzline\Component\CommandCollection\Filesystem\Remove
     */
    public function getRemoveDirectory()
    {
        return $this->fetchFromSharedInstancePool(\Net\Bazzline\Component\CommandCollection\Filesystem\Remove::class);
    }

    /**
     * @param string $className
     * @return object
     * @throws InvalidArgumentException
     */
    final protected function fetchFromSharedInstancePool($className)
    {
        if ($this->isNotInSharedInstancePool($className)) {
            if (!class_exists($className)) {
                throw new InvalidArgumentException(
                    'class "' . $className . '" does not exist'
                );
            }
            
            $instance = new $className();
            $this->addToSharedInstancePool($className, $instance);
        }

        return $this->getFromSharedInstancePool($className);
    }

    /**
     * @param string $className
     * @param object $instance
     * @return $this
     */
    private function addToSharedInstancePool($className, $instance)
    {
        $this->sharedInstancePool[$className] = $instance;

        return $this;
    }

    /**
     * @param string $className
     * @return null|object
     */
    private function getFromSharedInstancePool($className)
    {
        return $this->sharedInstancePool[$className];
    }

    /**
     * @param string $className
     * @return boolean
     */
    private function isNotInSharedInstancePool($className)
    {
        return (!isset($this->sharedInstancePool[$className]));
    }
}