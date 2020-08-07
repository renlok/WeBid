<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/
// 90/110
if (!defined('InWeBid') || !defined('InAdmin')) {
    exit();
}

// common strings
$MSG['editor_help'] = "Note: each new line character will be converted to <b>&lt;br&gt;</b> HTML tag.";
$MSG['cannot_delete'] = "ไม่สามารถลบได้";

// aboutus.php
$MSG['about_us_page'] = "หน้าเกียวกับเรา";
$MSG['active_about_us'] = "Activate About us page?";
$MSG['active_about_us_explain'] = "Activate this option if you want an <u>About  us</u> link to appear in the footer of your pages.";
$MSG['about_us_content'] = "About us page content";
$MSG['about_us_content_explain'] = "Note: each new line character will be converted to <b>&lt;br&gt;</b> HTML tag.";
$MSG['about_us_updated'] = "About us Updated";

// accounts.php
// nothing

// activatenewsletter.php
$MSG['newsletter_settings_updated'] = "Newsletter Settings Updated";
$MSG['activate_newsletter'] = 'เปิดใช้งานจดหมายข่าว';
$MSG['activate_newsletter_explain'] = "If you activate this option, users will be given the option to subscribe to your newsletter.<br>The \"Newsletter management\" will let you send e-mail messages to the subscribed users";

// addnew.php
// nothing

// adminusers.php
$MSG['1100'] = 'คุณไม่สามารถลบบัญชีที่คุณกำลังเข้าสู่ระบบได้';
$MSG['1101'] = 'ลบบัญชีผู้ดูแลระบบแล้ว';

// analytics.php
$MSG['analytics'] = "Analytics";
$MSG['analytics_updated'] = "Analytics Settings updated";
$MSG['analytics_tracking_code'] = "Analytics Tracking Code";
$MSG['analytics_tracking_code_hint'] = "Copy and paste your analytics tracking code here (such as google analytics). You must include the opening and closing &lt;script&gt;&lt;/script&gt; tags.";

// auctions.php
$MSG['auction_settings'] = "การตั้งค่าการประมูล";
$MSG['auction_settings_updated'] = "อัปเดตการตั้งค่าการประมูลแล้ว";
$MSG['error_numeric_values'] = "โปรดป้อนค่าตัวเลขที่ถูกต้อง";
$MSG['error_max_pic_size_zero'] = "<i>ขนาดภาพสูงสุด</i> ไม่สามารถเป็น 0 ได้";
$MSG['error_max_num_pics_numeric'] = "<i>จำนวนภาพสูงสุด</i> ต้องเป็นตัวเลข.";
$MSG['error_max_pic_size_numeric'] = "<i>Max picture size</i> must be numeric.";
$MSG['enable_proxy_bidding'] = "Enable Proxy Bidding";
$MSG['enable_proxy_bidding_explain'] = "Proxy bidding works where the winning bidder pays the price of the second-highest bid plus a defined increment, instead of their maximum bid. <a href=\"https://en.wikipedia.org/wiki/Proxy_bid\" target=\"_blank\">Wikipedia explaination</a>";
$MSG['enable_custom_start_date'] = "เปิดใช้งานวันที่เริ่มต้นที่กำหนดเองหรือไม่";
$MSG['enable_custom_start_date_explain'] = "ผู้ใช้สามารถกำหนดวันที่เริ่มต้นสำหรับการประมูลได้เอง";
$MSG['enable_custom_end_date'] = "เปิดใช้งานวันที่สิ้นสุดที่กำหนดเองหรือไม่";
$MSG['enable_custom_end_date_explain'] = "ผู้ใช้สามารถกำหนดวัน <b> สิ้นสุด </b> ที่กำหนดเองสำหรับการประมูล";
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
$MSG['this_cannot_be_undone'] = 'This action cannot be undone.';

// categoriestrans.php
// nothing

// catsorting.php
$MSG['category_sorting'] = "การจัดเรียงหมวดหมู่";
$MSG['category_sorting_updated']= "Categories Sorting Settings Updated";
$MSG['category_sorting_explain'] = "The categories list in the left column of the home page, can be sorted <b>alphabetically</b> or on the number of auctions contained in each category (<b>categories counters</b>).<br>
			Choose below the sorting method you want to have";
$MSG['category_sorting_alpha'] = "Alphabetically";
$MSG['category_sorting_count'] = "Categories counters";
$MSG['categories_to_show'] = "Categories to show: ";
$MSG['categories_to_show_explain'] = "You can set below the number of categories you want to be shown in the left column of the home page";

// checkversion.php
$MSG['error_file_access_disabled'] = "<p>URL file-access is disabled on your server so WeBid is unable to run the version check</p>"; // Also index.php
$MSG['outdated_version'] = "คุณกำลังใช้งานเวอร์ชันเก่าคุณสามารถดาวน์โหลดเวอร์ชันล่าสุดได้ <a href='http://sourceforge.net/project/showfiles.php?group_id=181393'>ที่นี่</a>";
$MSG['current_version'] = "คุณกำลังใช้งานเวอร์ชันล่าสุด";

// clear_image_cache.php/.tpl
$MSG['clear_image_cache'] = "ล้างแคชรูปภาพ";
$MSG['image_cache_cleared'] = "ล้างแคชรูปภาพแล้ว";
$MSG['clear_image_cache_explain'] = "Delete all the Image cache files, This can help if there are some images not showing on the site";

// clearcache.php
$MSG['clear_cache'] = "Clear Cache";
$MSG['clear_cache_explain'] = "Delete all the template cache files, you will need to do this each time you edit a template file";
$MSG['cache_cleared'] = "Cache cleared";

// contactseller.php
$MSG['contact_seller'] = "ติดต่อผู้ขาย";
$MSG['contact_seller_explain'] = "Giving anybody the option to contact sellers through your website is not recommended. For this reason WeBid
      gives you the ability to decide if sellers can be contacted by users browsing your site or not.";
$MSG['contact_seller_anyone'] = "Any visitor can contact the seller (the ability to contact the seller will be ALWAYS shown)";
$MSG['contact_seller_users_only'] = "Only logged in users can contact the seller (the ability to contact the seller will be shown only to other users of your site if logged in)";
$MSG['contact_seller_disabled'] = "Nobody can contact the seller (the ability to contact the seller will NEVER be shown)";
$MSG['hide_user_emails'] = "Hide user E-Mails";
$MSG['hide_user_emails_explain'] = "You can decide to allow users to see each others E-Mail addresses or to hide them and all communication must be done via PMs";

// cookiespolicy.php
$MSG['cookie_policy_updated'] = "Cookie Policy Settings Updated";
$MSG['enable_cookie_policy'] = "Enable Cookies Policy Page?";
$MSG['enable_cookie_policy_explain'] = "Activate this option if you want a Cookies Policy link to appear in the footer of your pages.";
$MSG['cookie_policy_content'] = "Cookies Policy content<br>(HTML allowed)";

// counters.php
$MSG['counter_settings'] = "แสดงเคาน์เตอร์";
$MSG['counter_settings_updated'] = "Counters Settings Updated";
$MSG['counters_shown'] = "เคาน์เตอร์ที่คุณต้องการแสดง";
$MSG['counters_shown_explain'] = "คุณสามารถเลือกที่จะแสดงตัวนับบางส่วนในส่วนหัวของหน้าเว็บไซต์ของคุณ<br>
        มีเคาน์เตอร์ให้เลือกสามแบบ:
        <ul>
        <li>การประมูลที่ใช้งานอยู่</li>
        <li>ผู้ใช้ที่ลงทะเบียน</li>
        <li>ผู้ใช้ออนไลน์</li>
        </ul>
        คุณสามารถเปิด / ปิดแต่ละตัวนับด้านล่าง";
$MSG['counters_online'] = "ผู้ใช้ออนไลน์";
$MSG['counters_active'] = "การประมูลที่ใช้งานอยู่";
$MSG['counters_registered'] = "ผู้ใช้ที่ลงทะเบียน";

// countries.php
$MSG['countries_updated'] = "อัปเดตประเทศแล้ว";

// currency.php
$MSG['currency_settings'] = "การตั้งค่าสกุลเงิน";
$MSG['currency_settings_updated'] = "Currency settings updated";
$MSG['default_currency'] = "สกุลเงินเริ่มต้น";
$MSG['default_currency_explain'] = "คุณสามารถใช้สกุลเงินที่คุณเลือกได้ทั่วทั้งไซต์.";
$MSG['money_format'] = "รูปแบบเงิน";
$MSG['money_format_us'] = "รูปแบบ US: 1,250.00";
$MSG['money_format_euro'] = "รูปแบบ EU: 1.250,00";
$MSG['money_decimals'] = "ตัวเลขทศนิยม";
$MSG['money_decimals_explain'] = "ตั้งค่าเป็นศูนย์หรือเว้นว่างไว้หากคุณไม่ต้องการให้ตัวเลขทศนิยมในการแสดงเงินของคุณ";
$MSG['money_symbol_position'] = "ตำแหน่งสัญลักษณ์";
$MSG['money_symbol_position_before'] = "ก่อนจำนวน (i.e. USD 200)";
$MSG['money_symbol_position_after'] = "หลังจำนวน (i.e. 200 USD)";
$MSG['new_currency'] = 'เพิ่มสกุลเงินใหม่';
$MSG['curreny_country_explain'] = "ตัวอย่าง: <b>United States</b><br>ต้องกรอกข้อความทั้ง 3 ช่องเพื่อเพิ่มสกุลเงินใหม่";
$MSG['currency_name'] = "ชื่อสกุลเงิน";
$MSG['curreny_name_explain'] = "ตัวอย่าง: <b>U.S. Dollar</b>";
$MSG['curreny_symbol'] = "สัญลักษณ์สกุลเงิน";
$MSG['curreny_symbol_explain'] = "ตัวอย่าง: <b>USD</b>";

// defaultcountry.php
$MSG['default_country'] = "ประเทศเริ่มต้น";
$MSG['default_country_explain'] = "You can select a default country for your site.<br>It will automatically appear as the selected country in the countries select box throughout the site.";
$MSG['default_country_updated'] = "Default country updated";

// deleteauction.php
$MSG['confirm_auction_delete'] = 'Are you sure you want to delete the auction \'%s\'';

// deletebanner.php
// nothing

// deletemessage.php
$MSG['confirm_msg_delete'] = 'Are you sure you want to delete this message (ID: %s)';

// deletenews.php
$MSG['confirm_news_delete'] = 'Are you sure you want to delete the news item \'%s\'';

// deleteuser.php
$MSG['confirm_user_delete'] = 'Are you sure you want to delete the user \'%s\'';
$MSG['user_has_active_auctions'] = "The user has active auctions:<br>";
$MSG['plus_x_more'] = "plus %d more";
$MSG['user_has_x_bids'] = "The user has placed bids on %s auction(s).";

// deleteuserfeed.php
$MSG['confirm_feedback_delete'] = 'Are you sure you want to delete this user feedback (ID: %s)';

// displaysettings.php
$MSG['display_settings'] = 'การตั้งค่าการแสดงผล';
$MSG['display_settings_updated'] = 'Display Settings Updated';
$MSG['show_per_page'] = 'ผลลัพธ์ที่แสดงต่อหน้า';
$MSG['show_per_page_explain'] = 'The maximum number of items before a page break';
$MSG['max_featured_items'] = 'Max number of featured items shown';
$MSG['max_featured_items_explain'] = 'Featured items are shown above the normal items on searches, this is how may will be shown on each page.';
$MSG['thumbnail_size'] = 'ขนาดภาพขนาดย่อ';
$MSG['thumbnail_size_explain'] = 'This is the size of the thumbnail that will appear on lists of auctions such as when a user does a search';
$MSG['front_page_settings'] = 'การตั้งค่าหน้าแรก';
$MSG['home_page_featured'] = "รายการแนะนำ หน้าแรก";
$MSG['home_page_featured_explain'] = "This is the number of featured items to show in the home page.<br>0 (zero) is permitted.";
$MSG['home_page_recent'] = "Last Created Items";
$MSG['home_page_recent_explain'] = "This is the number of most recent items to show in the home page.<br>0 (zero) is permitted.";
$MSG['home_page_hot'] = "Hot Items";
$MSG['home_page_hot_explain'] = "This is the number of items to show in the Hot Items list in the home page.<br>0 (zero) is permitted.";
$MSG['home_page_ending_soon'] = "Next Ending";
$MSG['home_page_ending_soon_explain'] = "This is the number of items to show in the Next Ending list in the home page.<br>0 (zero) is permitted.";
$MSG['home_page_login'] = "Display login box?";
$MSG['home_page_login_explain'] = "Will enable the quick login box on the home page.";
$MSG['home_page_news'] = "Display news box?";
$MSG['home_page_news_explain'] = "Will show news items on the home page.";
$MSG['number_news_shown'] = "Number of news you want to show";

// durations.php
$MSG['duration_table_updated'] = "อัปเดตตารางระยะเวลาแล้ว";

// editadminuser.php
// nothing

// editauction.php
$MSG['error_current_bid_too_low'] = "Current Bid must be greater than minimum bid.";

// editbanner.php
$MSG['error_wrong_file_type'] = "Wrong file type. Allowed formats: GIF, JPG, PNG, SWF"; // Also userbanners.php

// editbanneruser.php
// nothing

// editboards.php
$MSG['error_msg_numeric'] = "Messages to show must be numeric"; // Also newboard.php
$MSG['error_msg_not_zero'] = "Messages to show cannot be zero"; // Also newboard.php

//editfaq.php
// nothing

// editfaqcategory.php
// nothing

// editmessage.php
// nothing

// editmessages.php
// nothing

// editnew.php
$MSG['edit_news'] = "แก้ไขข่าว";

// edituser.php
// nothing

// edituserfeed.php
// nothing

// emailsettings.php
$MSG['email_settings'] = 'การตั้งค่าอีเมล';
$MSG['error_missing_SMTP_settings'] = 'Please enter missing or incorrect SMTP settings';
$MSG['mail_protocol'] = 'Mail Protocol:';
$MSG['mail_parameters'] = 'Webid Mail Parameters:';
$MSG['mail_parameters_explain'] = '*When using \'Webid Mail\', additional mail parameters can be added here (e.g. "-femail@yourwebid.com").';
$MSG['SMTP_settings'] = "SMTP Specific Options:";
$MSG['SMTP_settings_explain'] = 'Used <b>only</b> for SMTP mail';
$MSG['SMTP_authentication'] = 'SMTP Authentication';
$MSG['SMTP_security'] = 'SMTP Security:';
$MSG['SMTP_port'] = 'SMTP Port:';
$MSG['SMTP_username'] = 'SMTP Username:';
$MSG['SMTP_password'] = 'SMTP Password:';
$MSG['SMTP_host'] = 'SMTP Host:';
$MSG['SMTP_host_explain'] = '*For Gmail accounts. Set the encryption system using a prefix of [<b>ssl://</b>] or [<b>tls://</b>] Examples:<br>[ ssl://smtp.googlemail.com ], [ tls://smtp.googlemail.com ]';
$MSG['other_admin_emails'] = 'Additional Admin E-Mails:';
$MSG['other_admin_emails_explain'] = 'Additional email accounts you want to receive admin related email, in addition to the main site email address of %s. (comma separated)';
$MSG['email_sending_success'] = 'Your email has been successfully sent.';
$MSG['email_sending_failure'] = 'Email not sent! Please check your PHP mail configuration.Response:<br>%s';

// enablefees.php
$MSG['enable_fees'] = "Enable/Disable Fees";
$MSG['enable_fees_explain'] = "Do you want your auction site to be completely free or do you want to charge for it";
$MSG['fee_settings_updated'] = 'Fee Settings Updated';
$MSG['set_payment_type'] = "Set payment type";
$MSG['set_payment_type_explain'] = "This is how users will pay the fees. Balance mode is where the users can choose when to pay and live payments is where the user must pay for every action that has a fee";
$MSG['balance_mode'] = "Balance mode";
$MSG['live_payments'] = "Live payments";
$MSG['payment_sandbox'] = "Payment gateway sandbox";
$MSG['payment_sandbox_explain'] = 'You can turn on the payment gateways sandbox to test the payment gateways but make sure disable the sandbox mode before making your site live';
$MSG['balance_mode_settings'] = "The following settings are only used when in balance mode";
$MSG['max_debt'] = "Maximum Debt";
$MSG['max_debt_explain'] = "The maximum debt an account can have before they must pay it back";
$MSG['signup_credit'] = "Signup Credit";
$MSG['signup_credit_explain'] = "Free credit given to an account on its creation";
$MSG['suspend_debt_accounts'] = "Suspend Accounts";
$MSG['suspend_debt_accounts_explain'] = "Suspend Accounts that are over the Debit Limit";

// errorhandling.php
$MSG['error_handling'] = "Error Handling";
$MSG['error_settings_updated'] = "Error Handling settings updated.";
$MSG['error_text'] = "Error Text";
$MSG['error_text_explain'] = "Fatal errors that occur during WeBid's execution (typically MySQL errors) will redirect users to an error page. You can customise the error message you want to appear in the error page below.";

// errorlog.php
$MSG['error_log_purged'] = "Error Log Purged";
$MSG['error_log_empty'] = 'Error log is currently empty';

// excludeauction.php
$MSG['suspend_auction'] = "Suspend auction";
$MSG['unsuspend_auction'] = "Reactivate auction";

// excludeuser.php
$MSG['suspend_user'] = "ระงับผู้ใช้";
$MSG['suspend_user_confirm'] = "Are you sure you want to suspend this user?";
$MSG['activate_user'] = 'เปิดใช้งานผู้ใช้';
$MSG['activate_user_confirm'] = 'Are you sure you want to activate this user?';
$MSG['reactivate_user'] = "เปิดใช้งานผู้ใช้อีกครั้ง";
$MSG['reactivate_user_confirm'] = "Are you sure you want to reactivate this user?";

// faqs.php
$MSG['faqs_deleted'] = 'FAQs deleted';

// faqscategories.php
$MSG['faq_delete_action'] = 'What do you want to do with the FAQs in the following categories';
$MSG['confirm_faq_action'] = 'Are you sure you want to process the following categories: ';
$MSG['contains_x_faqs'] = '(contains %d FAQs)';

// fee_gateways.php
$MSG['gateway_settings_update'] = 'Fee Gateway Settings Updated';

// fees.php
$MSG['error_from_must_be_less_than_to'] = 'The <i>from</i> value must be less than the <i>to</i> value'; // also increments.php

// footer.php
// nothing

// header.php
// nothing

// help.php
// nothing

// increments.php
$MSG['increments_updated'] = "Increments table updated";

// index.php
$MSG['counters_updated'] = "อัปเดตตัวนับแล้ว";

// invoice_settings.php
$MSG['invoice_settings'] = 'Invoice Settings';
$MSG['invoice_settings_updated'] = 'Invoice settings updated';
$MSG['invoice_notice'] = 'Invoice Notice';
$MSG['invoice_notice_explain'] = 'This will show in a yellow box above the end message on users invoices';
$MSG['invoice_end_msg'] = 'Invoice End Message';
$MSG['invoice_end_msg_explain'] = 'This will show at the end of every users invoice';

// invoice.php
// nothing

// listauctions.php
$MSG['view_open_auctions'] = "ดูการประมูลที่เปิดอยู่";

// listclosedauctions.php
// nothing

// listreportedauctions.php
$MSG['view_reported_auctions'] = "ดูการประมูลที่ได้รับรายงาน";

// listsuspendedauctions.php
$MSG['view_suspended_auctions'] = "ดูการประมูลที่ถูกระงับ";

// listusers.php
// nothing

// loggedin.inc.php
// nothing

// login.php
// nothing

// logo_upload.php
$MSG['your_logo'] = "โลโก้ของคุณ";
$MSG['current_logo'] = "โลโก้ปัจจุบัน";
$MSG['upload_new_logo'] = "อัปโหลดโลโก้ใหม่";
$MSG['logo_upload_success'] = 'อัปโหลดโลโก้เรียบร้อยแล้ว';

// logout.php
// nothing

// maintenance.php
$MSG['maintenance_settings'] = "Under Maintenance Page";
$MSG['maintenance_settings_updated'] = "Under Maintenance settings updated";
$MSG['enable_maintenance_mode'] = "Enable \"Under Maintenance\" mode?";
$MSG['enable_maintenance_mode_explain'] = "You can temporary disable the access to your site if necessary.<br>
                In Maintenance mode only one user will have access to it. After you registered a user via <a target=\"_new\" href=\"../register.php\">the usual users registration page</a>
                , insert below the username. After switching the site to Maintenance mode <a target=\"_new\" href=\"../user_login.php\">login here</a> to access the site.";
$MSG['maintenance_mode_msg'] = "Under Maintenance HTML code";

// managebanners.php
// nothing

// membertypes.php
$MSG['member_types_updates'] = 'อัปเดตประเภทสมาชิกแล้ว';

// metatags.php
$MSG['metatag_settings'] = "HTML meta Tags";
$MSG['metatag_settings_updated'] = "อัปเดตการตั้งค่า Meta Tags แล้ว";
$MSG['metatag_desc'] = "Meta Description Tag";
$MSG['metatag_desc_explain'] = "The Meta Description Tag is usually used to describe your pages in the search results pages search engines show.<br>
				Enter the text which better describes your site below.";
$MSG['metatag_keywords'] = "Meta Keywords Tag";
$MSG['metatag_keywords_explain'] = "The Meta Keywords Tag gives some search engines additional information to use to index your site.<br>
				Enter the your keywords below separated by comas (i.e. books, books auctions, book sales).";

// moderateauctions.php
// nothing

// moderation.php
$MSG['moderation_settings'] = 'การตั้งค่าการกลั่นกรอง';
$MSG['moderation_settings_updated'] = "อัปเดตการตั้งค่าการกลั่นกรองแล้ว";
$MSG['moderation'] = 'Moderation';
$MSG['auction_moderation'] = 'Auction Moderation';
$MSG['new_auction_moderation'] = 'New auction moderation';
$MSG['moderation_disabled'] = 'Disabled';
$MSG['moderation_pre_moderation'] = 'Pre-moderation';
$MSG['moderation_post_moderation'] = 'Post-moderation';

// multilingual.php
$MSG['multilingual_support_settings_updated'] = 'อัปเดตการตั้งค่าการสนับสนุนหลายภาษา';
$MSG['multilingual_support'] = "การสนับสนุนหลายภาษา";
$MSG['default_language'] = "ภาษาเริ่มต้น";
$MSG['default_language_explain'] = "นี่คือภาษาที่จะแสดงสำหรับแขกและผู้ใช้ใหม่";
$MSG['current_default_language'] = '<span style="color:#CD0000;"><b>ภาษาเริ่มต้นปัจจุบัน</b></span>';

// newadminuser.php
$MSG['new_admin_user'] = "ผู้ดูแลระบบใหม่";

// newbanneruser.php
// nothing

// newboard.php
// nothing

// newfaq.php
// nothing

// news.php
// nothing

// newsletter.php
$MSG['error_subject_or_body_missing'] = "หัวเรื่องหรือเนื้อหาของจดหมายข่าวหายไป";
$MSG['x_messages_sent'] = "ส่งข้อความแล้ว %d";
$MSG['all_users'] = "ผู้ใช้ทั้งหมด"; // Also listusers.tpl
$MSG['active_users'] = "ผู้ใช้ที่ใช้งานอยู่"; // Also listusers.tpl
$MSG['suspended_by_admin'] = "ถูกระงับโดยผู้ดูแลระบบ"; // Also listusers.tpl
$MSG['signup_fee_unpaid'] = "ไม่ได้ชำระค่าธรรมเนียมการสมัคร"; // Also listusers.tpl
$MSG['account_never_confirmed'] = "ไม่เคยยืนยันบัญชี"; // Also listusers.tpl

// newuser.php
// nothing

// payments.php
$MSG['payment_methods_updated'] = "อัปเดตตารางวิธีการชำระเงินแล้ว";

// privacypolicy.php
$MSG['privacy_policy'] = "หน้านโยบายความเป็นส่วนตัว";
$MSG['privacy_policy_updated'] = "อัปเดตการตั้งค่านโยบายความเป็นส่วนตัวแล้ว";
$MSG['enable_privacy_policy'] = "เปิดใช้งานหน้านโยบายความเป็นส่วนตัวหรือไม่";
$MSG['enable_privacy_policy_explain'] = "เปิดใช้ตัวเลือกนี้หากคุณต้องการให้ลิงก์นโยบายความเป็นส่วนตัวปรากฏที่ส่วนท้ายของหน้าของคุณ";
$MSG['privacy_policy_content'] = "เนื้อหานโยบายความเป็นส่วนตัว<br>(อนุญาต HTML)";

// profile.php
$MSG['registration_fields_updated'] = 'User Registration Fields Updated';
$MSG['error_required_field_cannot_be_hidden'] = 'A field must be shown if it\'s a required field';

// removefrommoderation.php
// nothing

// searchauctions.php
$MSG['search_auctions'] = "ค้นหาการประมูล";

// settings.php
$MSG['general_settings'] = "การตั้งค่าทั่วไป"; // Also sidebar-settings.tpl
$MSG['general_settings_updated'] = "อัปเดตการตั้งค่าทั่วไปแล้ว";
$MSG['site_name'] = "ชื่อเว็บไซต์";
$MSG['site_name_explain'] = "ชื่อไซต์ของคุณจะปรากฏในข้อความอีเมลที่ WeBid ส่งถึงผู้ใช้";
$MSG['site_url'] = "URL เว็บไซต์"; // Also home.tpl
$MSG['site_url_explain'] = "ต้องเป็น URL ที่สมบูรณ์ (ขึ้นต้นด้วย <b>http://</b>) ของการติดตั้ง WeBid ของคุณ<br>อย่าลืมใส่เครื่องหมายทับลงท้ายด้วย";
$MSG['admin_email'] = "e-mail ผู้ดูแลระบบ"; // Also home.tpl
$MSG['admin_email_explain'] = "ที่อยู่อีเมลของผู้ดูแลระบบใช้เพื่อส่งข้อความอีเมลอัตโนมัติ";
$MSG['copyright_msg'] = "ข้อความลิขสิทธิ์ของคุณ";
$MSG['copyright_msg_explain'] = "นี่คือข้อความที่ถูกเพิ่มที่ด้านล่างของทุกหน้า";
$MSG['batch_settings'] = "Batch Procedures Settings";
$MSG['run_cron'] = "Run cron";
$MSG['run_cron_explain'] = "WeBid needs to periodically run <code>batch.php</code> to close expired auctions and send notification e-mails to the seller and/or the winner. The recommended way to run <code>batch.php</code> is to set up a <a href=\"http://www.webidsupport.com/forums/index.php?threads/setting-up-a-cronjob.10244/\" target=\"_blank\">cronjob</a> if you run a Unix/Linux server.<br>If for any reason you can't run a cronjob on your server, you can choose the <b>Non-batch</b> option below to have <code>batch.php</code> run by WeBid itself: in this case <code>cron.php</code> will be run each time someone access your home page.";
$MSG['batch'] = "Batch"; // Also index.php
$MSG['non_batch'] = "Non-batch"; // Also index.php
$MSG['clear_closed_auctions'] = "ลบการประมูลที่เก่ากว่า";
$MSG['clear_closed_auctions_explain'] = "After an auction is closed how many days will an auction be kept before it is deleted. Can be set to 0 to keep indefinatly.";
$MSG['optimisation'] = "การเพิ่มประสิทธิภาพ";
$MSG['enable_template_cache'] = "เปิดใช้งานแคชเทมเพลตหรือไม่";
$MSG['enable_template_cache_explain'] = "This will increase the speed of your site. It is recommended this is only disabled when making updates to your template";
$MSG['ssl_support'] = "SSL Support";
$MSG['enable_ssl'] = "Enable SSL support?";
$MSG['enable_ssl_explain'] = "<p>If you have SSL support on the server where you are running WeBid, you may want to give your customers a safer environment to operate.</p>Once The SSL Support is activated, your users will operate under secure HTTPS transactions when they log in or register.";
$MSG['ssl_url'] = 'Shared SSL URL';
$MSG['ssl_url_explain'] = 'If you\'re using shared SSL enter the URL here';

// spam.php
$MSG['spam_settings'] = 'การตั้งค่าสแปม'; // Also sidebar-settings.tpl
$MSG['spam_settings_updated'] = 'อัปเดตการตั้งค่าสแปมแล้ว';
$MSG['error_recaptcha_missing_keys'] = 'คุณไม่สามารถใช้ reCaptcha ได้หากไม่มีคีย์ทั้งสอง';
$MSG['recaptcha_public_key'] = "reCaptcha คีย์สาธารณะ";
$MSG['recaptcha_public_key_explain'] = 'ในการใช้ reCaptcha คุณต้องสร้างบัญชีฟรีด้วย <a href="https://www.google.com/recaptcha/intro/index.html" class="new-window">Google reCAPTCHA</a> และเพิ่มโดเมนนี้ในคู่คีย์';
$MSG['recaptcha_secret_key'] = "คีย์ลับ Recaptcha";
$MSG['registration_captcha_type'] = "ประเภท Captcha ในหน้าการลงทะเบียน";
$MSG['registration_captcha_type_explain'] = "Captcha ใช้เพื่อป้องกันสแปมโดยทั่วไปควรเปิดใช้งาน captcha บางประเภท";
$MSG['friend_captcha_type'] = "Captcha type on send auction to friend page";
$MSG['item_report_captcha_type'] = "ประเภท Captcha ในหน้ารายงานรายการ";
$MSG['spam_blocked_email_enabled'] = 'เปิดใช้งานบล็อกโดเมนอีเมล';
$MSG['spam_blocked_email_domains'] = 'ปฏิเสธการลงทะเบียนจากอีเมลที่ใช้แล้วทิ้ง';
$MSG['spam_blocked_email_domains_explain'] = 'ใส่แต่ละโดเมนในบรรทัดใหม่';

// stat_settings.php
$MSG['statistics_settings_updated'] = "อัปเดตการตั้งค่าสถิติแล้ว";
$MSG['error_stat_type_missing'] = "คุณต้องเลือกประเภทสถิติอย่างน้อยหนึ่งประเภท (การเข้าถึงเบราว์เซอร์และแพลตฟอร์มตามประเทศ)";
$MSG['statistics_explain'] = "กรุณาเลือกด้านล่างหากคุณต้องการให้ WeBid สร้างสถิติการเข้าถึงเว็บไซต์ของคุณ";
$MSG['enable_statistics'] = "เปิดใช้งานสถิติไหม";
$MSG['stat_types_explain'] = "เลือกประเภทของสถิติที่คุณต้องการสร้าง";
$MSG['enable_user_access_stats'] = "สร้างสถิติการเข้าถึงของผู้ใช้";
$MSG['enable_browser_stats'] = "สร้างสถิติเบราว์เซอร์และแพลตฟอร์ม";

// tax_levels.php
// nothing

// tax.php
$MSG['tax_settings'] = 'การตั้งค่าภาษี';
$MSG['tax_settings_updated'] = 'อัปเดตการตั้งค่าภาษีแล้ว';
$MSG['enable_tax'] = 'เปิดใช้งานภาษี';
$MSG['enable_tax_explain'] = 'การตั้งค่าส่วนกลางเพื่อเปิดหรือปิดภาษี';
$MSG['enable_user_tax'] = 'ผู้ใช้สามารถเรียกเก็บภาษี';
$MSG['enable_user_tax_explain'] = 'เปิดใช้งานเพื่อให้ผู้ใช้มีตัวเลือกในการเก็บภาษีสินค้าของตน';

// terms.php
$MSG['terms_conditions_page'] = "ข้อตกลง &amp; เงือนไข"; // Also sidebar-content.tpl
$MSG['terms_conditions_settings_updated'] = "Terms &amp; Conditions Settings Updated";
$MSG['enable_terms_conditions'] = "Enable Terms &amp; Conditions page?";
$MSG['enable_terms_conditions_explain'] = "Will display a <u>Terms &amp; Conditions</u> link in the footer of every page.";
$MSG['terms_conditions_content'] = "Terms &amp; Conditions page content<br>(HTML allowed)";

// theme.php
$MSG['default_theme_updated'] = "อัปเดตธีมเริ่มต้นแล้ว";
$MSG['error_theme_missing'] = "ไม่มีธีมที่เลือก";

// time.php
$MSG['time_settings'] = "การตั้งค่าเวลา"; // also sidebar-settings.tpl
$MSG['time_settings_updated'] = "ตั้งค่าเวลาแล้ว";
$MSG['date_format'] = "รูปแบบวันที่"; // also home.tpl
$MSG['date_format_explain'] = "เลือกรูปแบบที่คุณต้องการให้วันที่ปรากฏบนไซต์ของคุณ";
$MSG['american_dates'] = "mm/dd/yyyy"; // also index.php
$MSG['european_dates'] = "dd/mm/yyyy"; // also index.php
$MSG['default_time_zone'] = "โซนเวลาเริ่มต้น";
$MSG['default_time_zone_explain'] = "เลือกเขตเวลาเริ่มต้น";

// userbanners.php
// nothing

// userfeedback.php
// nothing

// usergroups.php
$MSG['error_must_have_one_autojoin'] = "อย่างน้อยหนึ่งกลุ่มต้องเปิดใช้งานการเข้าร่วมอัตโนมัติ";
$MSG['cannot_delete_default_user_groups'] = 'ไม่สามารถลบกลุ่มผู้ใช้เริ่มต้น (ผู้ขายและผู้ซื้อ) ได้';
$MSG['user_group_deleted'] = 'ลบกลุ่มผู้ใช้แล้ว';
$MSG['user_group_name_empty_update'] = 'ชื่อกลุ่มต้องไม่ว่างเปล่า ไม่ได้อัปเดตกลุ่มผู้ใช้';
$MSG['user_group_name_empty_new'] = 'ชื่อกลุ่มต้องไม่ว่างเปล่า ไม่ได้สร้างกลุ่มผู้ใช้ใหม่';

// usersettings.php
$MSG['user_settings'] = "การตั้งค่าผู้ใช้"; // Also sidebar-settings.tpl
$MSG['user_settings_updated'] = "อัปเดตการตั้งค่าผู้ใช้แล้ว";
$MSG['enable_reauthentication'] = "เปิดใช้งานการตรวจสอบสิทธิ์ผู้ใช้อีกครั้ง";
$MSG['enable_reauthentication_explain'] = "ผู้ใช้จะถูกขอให้ป้อนรหัสผ่านก่อนดำเนินการเช่นออกความคิดเห็นส่งการประมูลหรือออกจากการเสนอราคา";
$MSG['user_confirm_method'] = "วิธีการยืนยันของผู้ใช้";
$MSG['user_confirm_method_explain'] = "ใน WeBid บัญชีผู้ใช้แต่ละบัญชีจะต้องเปิดใช้งานก่อนจึงจะสามารถใช้งานได้ เลือกวิธีที่คุณต้องการใช้";
$MSG['prune_unactivated_users'] = "Prune unactivated users";
$MSG['prune_unactivated_users_explain'] = "ลบบัญชีผู้ใช้ที่ไม่ได้เปิดใช้งานโดยอัตโนมัติ";
$MSG['prune_unactivated_users_days'] = "จำนวนวันก่อนลบบัญชีที่ไม่ได้เปิดใช้งาน";
$MSG['prune_unactivated_users_days_explain'] = "จำนวนวันก่อนลบบัญชีที่ไม่ได้เปิดใช้งาน";
$MSG['bidding_visable_to_guest'] = 'เปิดระบบ Buy Now ผู้เยี่ยมชม';
$MSG['bidding_visable_to_guest_explain'] = 'ผู้เยี่ยมชมสามารถเห็นตัวเลือกเสนอราคาตอนนี้ / ซื้อทันทีเมื่อดูการประมูลซึ่งควรปิดการใช้งานหากคุณวางแผนที่จะเรียกใช้ไซต์ผู้ขายเดียว';
$MSG['email_admin_on_signup'] = 'ส่งอีเมลถึงผู้ดูแลระบบเมื่อสมัคร';
$MSG['email_admin_on_signup_explain'] = 'ผู้ดูแลระบบจะได้รับอีเมลทุกครั้งที่ผู้ใช้ใหม่ลงทะเบียน';
$MSG['user_request_seller_permission'] = 'ผู้ใช้สามารถขอเป็นผู้ขายได้';
$MSG['user_request_seller_permission_explain'] = 'ผู้ใช้ที่ไม่ได้รับอนุญาตให้ขายสินค้าสามารถขออนุญาตได้';

// util_cc1.php
$MSG['category_table_updated'] = "อัปเดตตารางหมวดหมู่แล้ว";

// viewaccessstats.php
$MSG['monthly_report'] = "รายงานประจำเดือน"; // Also accounts.tpl
$MSG['years_months'] = "ปี/เดือน";
$MSG['weekly_report'] = 'รายงานประจำสัปดาห์'; // Also accounts.tpl
$MSG['week'] = 'อาทิตย์'; // Also accounts.php
$MSG['day'] = "วัน";

// viewbrowserstats.php
// nothing

// viewfilters.php
$MSG['banner_filters'] = 'ตัวกรองแบนเนอร์';

// viewplatformstats.php
// nothing

// viewuserips.php
$MSG['registration_ip'] = "การลงทะเบียน IP";

// viewwinners.php
// nothing

// wordsfilter.php
$MSG['word_filter_updated'] = "อัปเดตตัวกรองคำ";
