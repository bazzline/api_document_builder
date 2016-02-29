<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-24 
 */

namespace Net\Bazzline\Component\ApiDocumentBuilder\Command;

use Net\Bazzline\Component\Command\Command;
use Net\Bazzline\Component\Command\RuntimeException;

class CleanDirectory extends Command
{
    /**
     * @param string $path
     * @return array
     */
    public function clean($path)
    {
        if (!is_dir($path)
            || !is_writable($path)) {
            throw new RuntimeException(
                'given path must be a writable directory'
            );
        }

        return $this->execute('/usr/bin/rm -fr ' . $path . '/*');
    }
}