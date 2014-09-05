<?php
$this->bfsSystem['servers'] = array(
    'mtdata.ru',
);


$this->bfsSystem['memcached']['servers'] =  array(
    'mc-0-1.comon.local:11211',
    'mc-0-2.comon.local:11211',
//NY  "mc-1-1.comon.local:11211"
);

$this->bfsSystem['db']['default']['dsn'] = $this->DSN_DB1;

$this->bfsSystem['capacity']['person']['default'] = 1 * 1024 * 1024 * 1024; // 1 Gb
$this->bfsSystem['capacity']['person']['developer'] = 2 * 1024 * 1024 * 1024; // 2 Gb
// vdm: used if tarif's space is less than this
$this->bfsSystem['capacity']['group']['default'] = 1 * 1024 * 1024 * 1024; // 1 Gb
$this->bfsSystem['capacity']['group']['developer'] = 10 * 1024 * 1024 * 1024; // 10 Gb
$this->bfsSystem['capacity']['group']['demo_mode'] = 1 * 1024 * 1024 * 1024; // 1 Gb

$this->bfsSystem['maxFileSize'] = 2*1000*1000*1000; // < 2gb
$this->bfsSystem['signatureSalt'] = 'this!is~very@long#and(secure)string*mirtesen'; // vdm: NB: this key hardcoded in nginx!

$this->bfsSystem['files_items'] = array(
    'brokerage_agreement',
    // ag: Since #WHO-4706
    'brokerage_agreement_real_account_open_ru',
    'metatrader_client',
    'transaq_mma_demo_client_en',
    'transaq_mma_demo_client_ru',
    'transaq_mma_real_client_en',
    'transaq_mma_real_client_ru',

    // bn: #WTT-672
    'transaq_mma_investolympic_client_en',
    'transaq_mma_investolympic_client_ru',
    'transaq_mma_demo_league_client_en',
    'transaq_mma_demo_league_client_ru',

    // dz: #WTT-1070
    'transaq_mma_indianolympic_client_en',
    'transaq_mma_indianolympic_client_ru',

    'xetra_demo_client_transaq',
    'nysdaq_demo_client_transaq',
    'transaq_client_real',
    'rox_client_real',

    'order_execution_policy',
    'order_execution_policy_ru', // al: WHO-2666

    'summary_conflicts_of_interest_policy',
    'summary_conflicts_of_interest_policy_ru', // al: WHO-2666

    'auto_follow_description',
    'auto_follow_description_ru', // al: WHO-2383

    'forex_contracts_trading_regulations', //lk: #WHO-1125
    'forex_contracts_trading_regulations_ru', //azw: #WTT-945

    'signal_repeater_terms_and_conditions',
    'signal_repeater_terms_and_conditions_ru', // al: #WHO-3322

    'landing_forex_fifty_agreement',
    'landing_forex_fifty_agreement_ru',
    'landing_forex_fifty_agreement_ar',
    'landing_forex_fifty_agreement_fr', // al: #WHO-3732

    'landing_forex_fifty_agreement_xmas',
    'landing_forex_fifty_agreement_xmas_id_id', // as: #WEBUI-322

    'landing_forex_fifty_agreement_new',
    'landing_forex_fifty_agreement_new_ru', // as: #WEBUI-355

    'landing_blogstar_regulation',
    'landing_investolympic_regulation', // al: #WEBUI-347
    'landing_investolympic_regulation_ru',

    'landing_birthday_fifty_regulation', // lonelind: #WTS-393
    'landing_birthday_fifty_regulation_ru',

    'landing_indianolympic_regulation',

    // mars: #WHO-1174
    'payment_options_guidance',

    // mars: #WHO-1551
    'cabinet_instructions',

    // sl: #WHO-2497
    'brokerage_agreement_ru',

    // sl: #WHO-3908
    'trading_regulation_ru',
    'trading_regulation_en',

    'declaration_of_risk_ru',
    'declaration_of_risk_en',

    'full_risk_disclosure_doc',

    // de: #WHO-4183
    'forex_deposit_english',
    'broker_to_broker',

    'registration_finamru_contest_smartphone_ru', // al: template `registration_finamru_contest_smartphone`
    'services_forex_light_tariff_regulation_ru',

    'services_mma_regulation',
    'services_mma_regulation_ru',

    // lonelind: #WTS-192
    'landing_indian_v2_investment_idea',

    // al: #WTT-613
    'services_documents_account_individual',
    'services_documents_account_corporate',
    'services_documents_account_limited',
    'services_documents_account_partnership',
    'services_documents_account_trust',

    'services_documents_forms_agreement',
    'services_documents_forms_trading',
    'services_documents_forms_ira_distribution',
    'services_documents_forms_ira_deposit',
    'services_documents_forms_agreement_option',

    'services_documents_disclosures_risks',
    'services_documents_disclosures_options_novtwelve',
    'services_documents_disclosures_special',

    'services_documents_transfer_acat',
    'services_documents_transfer_request',

    'services_documents_w_wben',
    'services_documents_w_wimy',
    'services_documents_w_wexp',
    'services_documents_w_weci',

    // azw: #WTT-1093
    // Seychelles
    'trade_repeater_user_agreement_fx_light',
    'trade_repeater_user_agreement_fx_light_ru',
    'trade_repeater_user_disclosures_fx_light',
    'trade_repeater_user_disclosures_fx_light_ru',

    // Cyprus
    'trade_repeater_user_agreement_fx_light_cy',
    'trade_repeater_user_agreement_fx_light_cy_ru',
    'trade_repeater_user_disclosures_fx_light_cy',
    'trade_repeater_user_disclosures_fx_light_cy_ru',

    //as: #WTT-1272
    'registration_mma_book_mail_1',
    'registration_mma_book_mail_2',


    // ak: #WTT-1047
    'services_ltd_forex_bonus_fifty',
    'services_ltd_forex_bonus_fifty_ru',
    'services_ltd_forex_bonus_fx_gold',
    'services_ltd_forex_bonus_fx_gold_ru',
    'services_ltd_forex_bonus_deposit',
    'services_ltd_forex_bonus_deposit_ru',
    'services_ltd_forex_bonus_business',
    'services_ltd_forex_bonus_business_ru',

    // as: #WTT-1631
    'landing_strategies_agreement',
    'landing_strategies_agreement_ru',

    // as: #WTS-1266
    'landing_bonus_50_light',
    'landing_bonus_50_light_ru',
    'landing_bonus_50_standart',
    'landing_bonus_50_standart_ru',

    // sd: #WTI-370
    'agent_tariff_NY_IB_one_p',
    'agent_tariff_NY_IB_one_p_ru',
    'agent_tariff_NY_IB_two_p',
    'agent_tariff_NY_IB_two_p_ru',
    'agent_tariff_NY_IB_three_p',
    'agent_tariff_NY_IB_three_p_ru',
    'agent_tariff_NY_IB_ten',
    'agent_tariff_NY_IB_ten_ru',
    'agent_tariff_NY_IB_fifteen',
    'agent_tariff_NY_IB_fifteen_ru',
    'agent_tariff_NY_IB_twenty',
    'agent_tariff_NY_IB_twenty_ru',
    'agent_tariff_NY_IB_thirty',
    'agent_tariff_NY_IB_thirty_ru',
    'agent_tariff_NY_IB_forty',
    'agent_tariff_NY_IB_forty_ru',
    'agent_tariff_NY_IB_fifty',
    'agent_tariff_NY_IB_fifty_ru',
);
