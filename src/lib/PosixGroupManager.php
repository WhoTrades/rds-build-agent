<?php
/**
 * @author Maksim Rodikov
 */
declare(strict_types=1);

namespace whotrades\RdsBuildAgent\lib;

/**
 * Class PosixGroupManager
 *
 * @package whotrades\RdsBuildAgent\lib
 */
final class PosixGroupManager
{
    /** @var int */
    private $gid;

    /**
     * PosixGroupManager constructor.
     */
    public function __construct()
    {
        $this->gid = posix_getpgid(posix_getpid());
    }

    /**
     * Sets current process id as gid
     */
    public function setCurrentPidAsGid(): bool
    {
        return posix_setpgid(posix_getpid(), posix_getpid());
    }

    /**
     * @return int
     */
    public function getCurrentPid(): int
    {
        return posix_getpid();
    }

    /**
     * @return int
     */
    public function getCurrentGid(): int
    {
        return posix_getpgid(posix_getpid());
    }

    /**
     * Restores original gid
     */
    public function restoreGid(): bool
    {
        return posix_setpgid(posix_getpid(), $this->gid);
    }

}