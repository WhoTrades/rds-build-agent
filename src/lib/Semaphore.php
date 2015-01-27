<?php
/**
 * @author Artem Naumenko
 * Класс, который занимается защитой от двойного запуска скриптов
 */

class Semaphore
{
    /** @var \ServiceBase_IDebugLogger */
    protected $debugLogger;

    private $filename;
    private $f;

    public function __construct(\ServiceBase_IDebugLogger $debugLogger, $filename)
    {
        $this->filename = $filename;
        $this->f = fopen($this->filename, "w");
        $this->debugLogger = $debugLogger;
        if (!$this->f) {
            $this->debugLogger->error("Can't open file $this->filename");
            throw new ApplicationException("Can't open file for writing $this->filename");
        }
    }

    /**
     * Блокирующий. Ждем пока ресурс разблокируется и блокируем его
     * @return void
     */
    public function lock()
    {
        $wouldblock = 1;
        flock($this->f, LOCK_EX, $wouldblock);
    }

    /**
     * Неблокирующий. Освобождаем ресурс
     * @return void
     */
    public function unlock()
    {
        fclose($this->f);
    }
}
