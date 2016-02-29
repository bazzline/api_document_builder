<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-24 
 */

namespace Net\Bazzline\Component\ApiDocumentBuilder\Builder;

use Net\Bazzline\Component\Command\Command;

class Apigen extends Command implements BuilderInterface
{
    /** @var string */
    private $destinationPath;

    /** @var string */
    private $sourcePath;

    /** @var string */
    private $title;

    /**
     * @return array
     */
    public function build()
    {
        $options = array(
            '--source ' . $this->sourcePath,
            '--destination ' . $this->destinationPath,
            '--title "' . $this->title . '"'
        );

        $command = __DIR__ . '/../../../../../../vendor/bin/apigen generate ' . implode(' ', $options);

        return $this->execute($command);
    }

    /**
     * @param string $path
     * @return $this
     * @todo validation
     */
    public function setDestination($path)
    {
        $this->destinationPath = $path;

        return $this;
    }

    /**
     * @param string $path
     * @return $this
     * @todo validation
     */
    public function setSource($path)
    {
        $this->sourcePath = $path;

        return $this;
    }

    /**
     * @param string $title
     * @return $this
     * @todo validation
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}