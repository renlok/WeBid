<?php
include 'common.php';
include INCLUDE_PATH . 'functions_sell.php';

// Stop back button killing auction
if (isset($_SESSION['previous'])) {
   if (basename($_SERVER['PHP_SELF']) != $_SESSION['previous']) {
        ### unset variable to stop back button
        unset($_SESSION['SELL_auction_id']);
       //header('location: user_menu.php');
   }
}

if(isset($_GET['is'], $_GET['item'], $_GET['time'], $_GET['duration'])){
       $is = $_GET['is'];
       $auction_id = $_GET['item'];
       $a_ends = $_GET['time'];
    

    
    switch($is){
        case 'done':
    
        $template->assign_vars(array(
                    'AUCTION_ID' => $auction_id,
                    'MESSAGE' => sprintf($MSG['102'], $auction_id, $dt->formatDate($a_ends, 'D j M \a\t g:ia'))
                    ));
        break;
        }
}
include 'header.php';
$template->set_filenames(array(
        'body' => 'sellsuccess.tpl'
        ));
$template->display('body');
include 'footer.php';
