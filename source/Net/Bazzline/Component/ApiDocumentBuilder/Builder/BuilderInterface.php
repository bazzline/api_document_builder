<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-24 
 */

namespace Net\Bazzline\Component\ApiDocumentBuilder\Builder;

interface BuilderInterface
{
    /**
     * @return array
     */
    public function build();

    /**
     * @param string $path
     * @return $this
     */
    public function setDestination($path);

    /**
     * @param string $path
     * @return $this
     */
    public function setSource($path);

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title);
}