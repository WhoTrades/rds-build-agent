<?php 
// twitter.com integration settings for application https://dev.twitter.com/apps/207708 (use login/password: whotrades/123qweEWQ)
$this->twitterSystem['twitterCom'] = array(
    'enabled' => true,
    'consumer_key' => 'SEPoswtqHiKoaMg7LvOg',
    'consumer_secret' => '9L7K84OJ3WUDqO2YOGd9tZhYr2KRMocq3gDYxNwTzmA',
    'callback' => 'http://whotrades.com/',
    'our_sources' => array(
        '<a href="http://WhoTrades.com/" rel="nofollow">WhoTrades.com</a>',
    ),
    'group_id' => 30892291396,
    'api_stream_user' => 'bash44444',
    'api_stream_password' => '0987654321',
    'api_stream_df_pid_kvdpp_key' => 'twitter_com_api_stream_df_pid',
    'our_tag' => 'WHOTRADES',
    'call_timeout' => 10,
);

$this->twitterSystem['max_len_message'] = 420; // vdm+sl: as facebook.com
$this->twitterSystem['filter_tags'] = array();
