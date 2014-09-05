<?php

$this->chatSystem['defaultDisplayLimit'] = 25;
$this->chatSystem['maxDisplayLimit'] = 50;
$this->chatSystem['balls_count_for_ban'] = 20;
$this->chatSystem['banSteps'] = array(
    4*3600,
    8*3600,
    24*3600,
    3*24*3600,
    7*24*3600,
);
// Не добавляет общий чат для данных групп
$this->chatSystem['ignore_groups'] = array(
    30892291396, // group_platforma_group_id
    30133661355, // group_usa_group_id
    30937503660, // group_mma_group_id
);

$this->chatSystem['group_without_chat'] = array(
    30133661355, // group_usa_group_id
    30937503660, // group_mma_group_id
);


//не открывается по умолчанию на данных страницах
$this->chatSystem['ignore_open_default_pages'] = array(
    "groups_item_cabinet",
    "groups_item__landing_birthday",
    "groups_item__landing_birthday_v1",
    "groups_item_cabinet_profile",
    "groups_item_cabinet_skip_training_hints",
    "payments_system_account_data_json",
    "groups_item_payment_universal_trader",
    "groups_item_payment_universal_trader_account",
    "groups_item_payment_universal_invoice",
    "groups_item_cabinet_accounts_add_start",
    "groups_item_cabinet_accounts_add",
    "groups_item_strategies_item_edit",
    "groups_item_subscribe_strategy",
    "groups_item_subscribe_strategy_success",
    "groups_item_subscriptions_item_remove",
    "groups_item_cabinet_accounts_json",
    "groups_item_cabinet_subscribe",
    "groups_item_cabinet_accounts_merge",
    "groups_item_settings_accounts_tradingpassword_action",
    "groups_item_settings_accounts_tradingpassword_recovery_action",
    "groups_item_settings_accounts_tradingpassword_recovery",
    "groups_item_settings_accounts_tradingpassword_change",
    "groups_item_settings_accounts_tradingpassword_change_json",
    "groups_item_cabinet_assignment",
    "groups_item_settings_banking_details",
    "groups_item_settings_orders_history",
    "groups_item_settings_banking_transactions",
    "groups_item_settings_banking_transactions_ecommerce",
    "groups_item_settings_banking_transactions_acount",
    "groups_item_settings_cabinet_reports",
    "groups_item_settings_cabinet_agents_report",
    "groups_item_client_assistance_add",
    "groups_item_client_assistance",
    "groups_item_client_assistance_filter",
    "groups_item_client_assistance_settings",
    "groups_item_client_assistance_cashout",
    "groups_item_client_assistance_messages_item_edit",
    "groups_item_client_assistance_messages_item_add",
    "groups_item_cabinet_funds",
    "groups_item_cabinet_funds_deposit",
    "cabinet_trade_jtrade",
    "cabinet_trade_widget",
    "cabinet_trading_select",
    "cabinet_trading_select_json",
    "cabinet_trading_account_change_password",
    "cabinet_trading_account_change_password_json",
    "cabinet_trading_account_change_password_sms",
    "cabinet_trading",
    "groups_item_technical_analysis",
    "groups_item_document_upload",
    "groups_item_document_upload_universal",
    "groups_item_settings_accounts_real_start",
    "groups_item_settings_accounts_real_open",
    "groups_item_settings_accounts_real_open_market_start",
    "groups_item_settings_accounts_real_open_market_mct",
    "groups_item_settings_accounts_real_open_market",
    // tt #WTS503
    "groups_item__landing_investolympic",
    "groups_item__landing_investolympic_v1",
    "groups_item__landing_investolympic_v1_description",
    "groups_item__landing_investolympic_v1_rating",

    // dz: #WTT-1070
    "groups_item__landing_indianolympic",
    "groups_item__landing_indianolympic_description",
    "groups_item__landing_indianolympic_rating",

    "groups_item__landing_money_talks",
    "groups_item__landing_money_talks_v1",

    //account new page_name
    "groups_item_settings_accounts_real_open_market_market_id",

    // service
    "groups_item_pages_services",
    "groups_item_pages_services_about",
    "groups_item_pages_services",
    "groups_item_pages_services_forex",
    "groups_item_pages_services_forex_accounts",
    "groups_item_pages_services_forex__detail",
    "groups_item_pages_services_forex__detail_cfd",
    "groups_item_pages_services_forex__detail_analysis",
    "groups_item_pages_services_forex_light__detail",
    "groups_item_pages_services_forex_more",
    "groups_item_pages_services_usmarkets",
    "groups_item_pages_services_usmarkets_more",
    "groups_item_pages_services_usmarkets_inc",
    "groups_item_pages_services_usmarkets_inc__detail",
    "groups_item_pages_services_micex",
    "groups_item_pages_services_micex__detail",
    "groups_item_pages_services_mma",
    "groups_item_pages_services_mma_features",
    "groups_item_pages_services_mma_conditions",
    "groups_item_pages_services_mma_platforms",
    "groups_item_pages_services_mma_portfolio",
    "groups_item_pages_services_single_trading_account",
    "groups_item_pages_services_mma",
    "groups_item_pages_services_single_trading_account_features",
    "groups_item_pages_services_mma_features",
    "groups_item_pages_services_single_trading_account_conditions",
    "groups_item_pages_services_mma_conditions",
    "groups_item_pages_services_single_trading_account_platforms",
    "groups_item_pages_services_mma_conditions_platforms",

    // service-v2
    "groups_item_pages_services_v2",
    "groups_item_pages_services_v2_about",
    "groups_item_pages_services_v2_mma",
    "groups_item_pages_services_v2_mma_features",
    "groups_item_pages_services_v2_mma_conditions",
    "groups_item_pages_services_v2_mma_platforms",
    "groups_item_pages_services_v2_mma_portfolio",
    "groups_item_pages_services_v2_mma_io",
    "groups_item_pages_services_v2_forex",
    "groups_item_pages_services_v2_forex_accounts",
    "groups_item_pages_services_v2_forex_io",
    "groups_item_pages_services_v2_forex_start",
    "groups_item_pages_services_v2_forex_platforms",
    "groups_item_pages_services_v2_forex_bonus",
    "groups_item_pages_services_v2_usmarkets",
    "groups_item_pages_services_v2_usmarkets_conditions",
    "groups_item_pages_services_v2_strategies"
);

$this->chatSystem['close_expire'] = 3600*24;
