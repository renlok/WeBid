<?php

namespace includes\cron;

class CronBase
{
    protected $db;
    protected $dt;

    public function __construct() {
        global $db, $dt;
        $this->db = $db;
        $this->dt = $dt;
    }

    public function printLog($str, $level = 0)
    {
        global $system;

        if ($level > 0) {
            for ($i = 1; $i <= $level; ++$i) {
                $str = "\t" . $str;
            }
        }
        if (defined('LogCron') && LogCron == true) {
            $system->log('cron', $str . "\n");
        }
    }

    public function getFrequency() {
        return $this->frequency;
    }

    public function canRun($last_run) {
        $current_time = new DateTime('now', $this->dt->UTCtimezone);
        $last_run_time = new DateTime($last_run, $this->dt->UTCtimezone);
        $difference = $last_run_time->diff($current_time);
        if ($this->getFrequency() == 'weekly' && $difference->days >= 7) {
            return true;
        }
        if ($this->getFrequency() == 'daily' && $difference->days >= 1) {
            return true;
        }
        if ($this->getFrequency() == 'hourly' && ($difference->days >= 1 || $difference->h >= 1)) {
            return true;
        }
        return false;
    }
}
