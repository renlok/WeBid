<?php

namespace includes\cron;


class Example extends CronBase
{
    protected $frequency = 'monthly';

    public function handle() {
        // the code you want to run goes here
    }

}
