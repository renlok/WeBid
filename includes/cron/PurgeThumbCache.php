<?php

namespace includes\cron;


class PurgeThumbCache extends CronBase
{
    protected $frequency = 'daily';

    public function handle() {
        if (!file_exists(UPLOAD_PATH . 'cache')) {
            mkdir(UPLOAD_PATH . 'cache', 0777);
        }

        if (!file_exists(UPLOAD_PATH . 'cache/purge')) {
            touch(UPLOAD_PATH . 'cache/purge');
        }

        $dir = UPLOAD_PATH . 'cache';
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != 'purge' && !is_dir($dir . '/' . $file) && (time() - filectime($dir . '/' . $file)) > 86400) {
                    unlink($dir . '/' . $file);
                }
            }
            closedir($dh);
        }
    }
}