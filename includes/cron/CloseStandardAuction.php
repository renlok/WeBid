<?php

namespace includes\cron;


class Example extends CronBase
{
    protected $frequency = 'hourly';

    public function handle() {
        // the code you want to run goes here
        $query = closedAuctionSQL() . " AND a.auction_type = 2 AND a.bn_only = 0";
        $db->direct_query($query);
        foreach ($auction_data as $Auction) {

        }
    }

}
