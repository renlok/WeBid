<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2016 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (!defined('InWeBid')) exit();

// aboutus.php
$MSG['about_us_page'] = "About Us Page";
$MSG['active_about_us'] = "Activate About us page?";
$MSG['active_about_us_explain'] = "Activate this option if you want an <u>About  us</u> link to appear in the footer of your pages.";
$MSG['about_us_content'] = "About us page content";
$MSG['about_us_content_explain'] = "Note: each new line character will be converted to <b>&lt;br&gt;</b> HTML tag.";
$MSG['about_us_updated'] = "About us Updated";

// accounts.php
// nothing

// activatenewsletter.php
$MSG['newsletter_settings_updated'] = "Newsletter Settings Updated";
$MSG['activate_newsletter'] = 'Enable newsletter';
$MSG['activate_newsletter_explain'] = "If you activate this option, users will be given the option to subscribe to your newsletter.<br>The \"Newsletter management\" will let you send e-mail messages to the subscribed users";

// addnew.php
// nothing

// adminusers.php
$MSG['1100'] = 'You cannot delete the account you are currently logged in from';
$MSG['1101'] = 'Admin accounts deleted';

// analytics.php
$MSG['analytics'] = "Analytics";
$MSG['analytics_updated'] = "Analytics Settings updated";
$MSG['analytics_tracking_code'] = "Analytics Tracking Code";
$MSG['analytics_tracking_code_hint'] = "Copy and paste your analytics tracking code here (such as google analytics). You must include the opening and closing &lt;script&gt;&lt;/script&gt; tags.";

// auctions.php
$MSG['auction_settings'] = "Auction Settings";
$MSG['auction_settings_updated'] = "Auction Settings Updated";
$MSG['error_numeric_values'] = "Please enter valid numeric values.";
$MSG['error_max_pic_size_zero'] = "<i>Max picture size</i> cannot be zero.";
$MSG['error_max_num_pics_numeric'] = "<i>Max. number of pictures</i> must be numeric.";
$MSG['error_max_pic_size_numeric'] = "<i>Max picture size</i> must be numeric.";
$MSG['enable_proxy_bidding'] = "Enable Proxy Bidding";
$MSG['enable_proxy_bidding_explain'] = "Proxy bidding works where the winning bidder pays the price of the second-highest bid plus a defined increment, instead of their maximum bid. <a href=\"https://en.wikipedia.org/wiki/Proxy_bid\" target=\"_blank\">Wikipedia explaination</a>";
$MSG['enable_custom_start_date'] = "Enable Custom Start Date?";
$MSG['enable_custom_start_date_explain'] = "Users can set a custom start date for auctions";
$MSG['enable_custom_end_date'] = "Enable Custom End Date?";
$MSG['enable_custom_end_date_explain'] = "Users can set a custom <b>end</b> date for auctions";
$MSG['enable_custom_increments'] = "Enable Custom Increments";
$MSG['enable_custom_increments_explain'] = "Users can set custom bid increments for their auctions (this is the minimum difference between two bids)";
$MSG['hours_until_countdown'] = "Hours until auction ends count-down";
$MSG['hours_until_countdown_explain'] = "Hours remaining on an auction until the time remaining becomes an automatic countdown timer";
$MSG['additional_auction_options'] = "Additional auction options";
$MSG['enable_featured_items'] = "Enable Featured Items";
$MSG['enable_featured_items_explain'] = "Allows sellers to make their auctions featured on the homepage and category pages";
$MSG['enable_hightlighted_items'] = "Enable Highlighted Items";
$MSG['enable_hightlighted_items_explain'] = "Allows sellers to make their auctions highlighted (displayed listing in a different colour in search results etc)";
$MSG['enable_bold_items'] = "Enable Bold Items";
$MSG['enable_bold_items_explain'] = "Allows sellers to make their auctions bold (displayed listing in bold in search results etc)";
$MSG['enable_subtitles'] = 'Enable subtitles';
$MSG['enable_subtitles_explain'] = 'Allows sellers to add a subtitle to their auction which will appear on all auction lists';
$MSG['enable_second_cat'] = 'Enable Secondary Category';
$MSG['enable_second_cat_explain'] = 'Allows sellers to add their auction to multiple categories';
$MSG['enable_auto_relist'] = 'Enable Auto-Relist';
$MSG['enable_auto_relist_explain'] = 'Allow users to automatically relist auctions if they end without a winner';
$MSG['max_relists'] = 'Max Relists';
$MSG['max_relists_explain'] = 'Set the maximum times an auction can be automatically relisted';
$MSG['auction_extension_settings'] = "Auction Extension Settings";
$MSG['enable_auto_extension'] = "Enable Auctions Auto extension?";
$MSG['enable_auto_extension_explain'] = "Auctions Auto extension gives you the ability to automatically extend the auctions end time by <b>X</b> seconds,
				if someone bids in the last <b>Y</b> seconds of the auctions duration.";
$MSG['auto_extend_auction_by'] = "Extend auction by %s seconds if someone bid during the last %s seconds";
$MSG['enable_picture_gallery'] = "Enable Picture Gallery?";
$MSG['enable_picture_gallery_explain'] = "Allows sellers to be able to upload multiple pictures to their auction.";
$MSG['gallery_images_allowance'] = "Max. Number of pictures"; // Also index.php
$MSG['gallery_image_max_kb'] = "Max. pictures size"; // Also index.php
$MSG['gallery_image_max_kb_explain'] = "Enter the maximum allowed size (in Kbytes) of the pictures sellers can upload for each auction.";
$MSG['thumbnail_size'] = "Thumbnail Size"; // Also displaysettings.php
$MSG['thumbnail_size_explain'] = "This is the size of the thumbnail that will appear on the auctions listing page";
$MSG['pixels'] = " pixels "; // Also displaysettings.php
$MSG['gallery_image_max_size'] = "Gallery photo max size";
$MSG['gallery_image_max_size_explain'] = "Set the maximum width or height a photo can be if it is over this size it will be resized";

// banips.php/tpl
$MSG['ip_addresses'] = "IP Addresses"; // Also user-sidebar.tpl
$MSG['ip_ban_management'] = "IP Ban Management";
$MSG['ban_this_ip'] = "Ban this IP address: ";
$MSG['ip_example'] = "(Complete IP address - example: 185.39.51.63)";
$MSG['no_ips_banned'] = 'No IP addresses have been banned as of yet.';
$MSG['manually_entered'] = "Manually entered";
$MSG['ip_address'] = "IP Address"; // Also viewuserips.tpl
$MSG['ban'] = "Ban"; // Also viewuserips.tpl
$MSG['accept'] = "Accept"; // Also viewuserips.tpl
$MSG['accepted'] = 'Accepted'; // Also viewuserips.tpl
$MSG['banned'] = 'Banned'; // Also viewuserips.tpl
$MSG['process_selection'] = "Process Selection"; // Also viewuserips.tpl
$MSG['ip_banned'] = "IP address banned.";
$MSG['ip_bans_removed'] = "%d IP addresses have been removed from the ban list.";
$MSG['ip_bans_added'] = "%d IP addresses have been added to the ban list.";
$MSG['error_cannot_ban_self'] = "You cannot ban your own IP address";

// banners.php
$MSG['banner_admin'] = "Banner Administration";
$MSG['activate_banner_support'] = "Activate banners support?";
$MSG['activate_banner_support_explain'] = "WeBid banners system retrieves banners on a random basis from the database, after applying the filters you set when you inserted the banner.";
$MSG['banner_settings_updated'] = "Banners settings updated";

// boards.php/tpl
$MSG['board_management'] = "Message Board Management"; // Also editboard, newboard, editmessage
$MSG['boards_removed'] = "Selected boards removed";
$MSG['num_messages'] = "# MSGS"; // Also editboards.tpl
$MSG['show'] = "SHOW";
$MSG['delete_board_warning'] = "NOTE: deleting a message board will delete all the associated messages.";

// boardsettings.php
$MSG['msg_board_settings'] = "Message Boards Settings";
$MSG['msg_board_settings_updated'] = "Message Board Settings Updated";
$MSG['enable_message_boards'] = "Enable Message Boards?";
$MSG['enable_message_boards_explain'] = "The message boards are a place where users can post public messages and questions to each other";

// buyerprivacy.php
$MSG['bidder_privacy'] = "Bidder Privacy";
$MSG['bidder_privacy_updated'] = "Bidder Privacy Settings Updated";
$MSG['enable_bidder_privacy'] = "Enable Bidder Privacy?";
$MSG['enable_bidder_privacy_explain'] = "If enabled the bidders identity is hidden to everyone but the seller of the item";

// buyitnow.php
$MSG['buy_it_now_settings_updated'] = "Buy it now settings updates";
$MSG['enable_buy_it_now'] = "Enable Buy it Now?";
$MSG['enable_buy_it_now_explain'] = "Gives an option to sellers to set a buy it now price.";
$MSG['enable_buy_it_now_only'] = "Enable Buy it now only auctions?";
$MSG['enable_buy_it_now_only_explain'] = "Give your sellers the ability to set up auctions for which it will not be possible to place any bid, but only use the <b>Buy it now</b> feature (fixed price auctions).<br><b>Note:</b> the <b>Buy it now only</b> option will only take effect if <b>Buy it now</b> is enabled.";
$MSG['enable_bin_only_auto_disable'] = "Enable Buy it now only auto disable";
$MSG['enable_bin_only_auto_disable_explain'] = "The Buy it now auto disable feature will automatically disable the buy it now only option for users if the percentage of buy it now only auctions reach the set value, you may want to use this as a deterrent to stop people making lots of spam buy it now only auctions";
$MSG['buy_it_now_only_limit'] = "Buy it now only limit";

// categories.php
$MSG['delete_category_move_auctions'] = 'What do you want to do with the auctions & subcategories in the following categories<br><small>(If you want to move them you must enter the category id of where you want them moved)</small>';
$MSG['move_category_missing_id'] = 'Some categories selected to move could not be processed as no valid category ID was given to where they would be moved to';

// logo_upload.php
$MSG['your_logo'] = "Your logo";
$MSG['current_logo'] = "Current logo";
$MSG['upload_new_logo'] = "Upload a new logo";
$MSG['logo_upload_success'] = 'Logo uploaded successfully';

// usergroups.php
$MSG['cannot_delete_default_user_groups'] = 'Default User Groups (Sellers & Buyers) cannot be removed';
$MSG['user_group_deleted'] = 'User Group Deleted';
$MSG['user_group_name_empty_update'] = 'Group name cannot be empty. User Group was not updated';
$MSG['user_group_name_empty_new'] = 'Group name cannot be empty. The new User Group was not created';

// viewuserips.php
$MSG['registration_ip'] = "Registration IP";
