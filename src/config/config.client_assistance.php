<?php

$this->clientAssistance['reward'] = array(
    'registration' => array('value' => 10),

    //'registrationExoticOptions' => array('value' => 0.1),

    'realAccountOpen' => array(
        'value' => 20,
        'minValue' => array(
            'USD' => 10,
            'EUR' => 10,
            'RUB' => 300
        )
    ),

    'groupCreate' => array(
        'value' => 5
    ),

    'firstDemoOrder' => array(
        'value' => 5
    ),

    //'makingTransactionsRealAccount' => array('percent' => 1, 'period' => '1 month'),
    //'fundAccountExoticOptions' => array('percent' => 2),

    //warl: общие критерии начисления вознаграждения
    'criteria' => array(
        'messages' => array(
            'beginner' => array(
                'min' => 2
            ),
            'agent' => array(
                'min' => 2
            )
        )
    )
);

//warl: deprecated list
$this->clientAssistance['templateMessages']['default'] = array(
    'en' => array(
        'client_assistance__template_messages__default__1',
        'client_assistance__template_messages__default__2',
        'client_assistance__template_messages__default__3',
        'client_assistance__template_messages__default__4',
        'client_assistance__template_messages__default__5',
        'client_assistance__template_messages__default__6',
        'client_assistance__template_messages__default__7',
        'client_assistance__template_messages__default__8',
        'client_assistance__template_messages__default__9',
        'client_assistance__template_messages__default__10',
    ),
    'ru' => array(
        'client_assistance__template_messages__default__11',
        'client_assistance__template_messages__default__12',
        'client_assistance__template_messages__default__13',
        'client_assistance__template_messages__default__14',
    ),
    'id_id' => array(
        'client_assistance__template_messages__default__1',
        'client_assistance__template_messages__default__2',
        'client_assistance__template_messages__default__3',
        'client_assistance__template_messages__default__4',
        'client_assistance__template_messages__default__5',
        'client_assistance__template_messages__default__6',
        'client_assistance__template_messages__default__7',
        'client_assistance__template_messages__default__8',
        'client_assistance__template_messages__default__9',
        'client_assistance__template_messages__default__10',
        'client_assistance__template_messages__default__11',
        'client_assistance__template_messages__default__12',
        'client_assistance__template_messages__default__13',
        'client_assistance__template_messages__default__14',
    )
);

$this->clientAssistance['pageAfterRegistration'] = array(
    'ru' => 'http://whotrades.com/learning/course/view/22?start_source=wtAgentsAssistanceRequest',
    'en' => 'http://whotrades.com/learning/course/view/27?start_source=wtAgentsAssistanceRequest',
);

$this->clientAssistance['emails_notify']['cash_out'] = array(
    '_WT_Support@corp.finam.ru'
);

$this->clientAssistanceMixRatingForSendingMessage = 300;

$this->clientAssistance['spam_dialogs'] = array(
    'US' => array(
        array(
            'client_assistance__bot_dialog_8__message_1',
            'client_assistance__bot_dialog_8__message_2',
        ),
        array(
            'client_assistance__bot_dialog_9__message_1',
            'client_assistance__bot_dialog_9__message_2',
        ),
        array(
            'client_assistance__bot_dialog_10__message_1',
            'client_assistance__bot_dialog_10__message_2',
        ),
        array(
            'client_assistance__bot_dialog_11__message_1',
            'client_assistance__bot_dialog_11__message_2',
        ),
        array(
            'client_assistance__bot_dialog_12__message_1',
            'client_assistance__bot_dialog_12__message_2',
        ),
        array(
            'client_assistance__bot_dialog_13__message_1',
            'client_assistance__bot_dialog_13__message_2',
        ),
        array(
            'client_assistance__bot_dialog_14__message_1',
            'client_assistance__bot_dialog_14__message_2',
        ),
        array(
            'client_assistance__bot_dialog_15__message_1',
            'client_assistance__bot_dialog_15__message_2',
        ),
    ),
    'other' => array(
        array(
            'client_assistance__bot_dialog_1__message_1'
        ),
        array(
            'client_assistance__bot_dialog_2__message_1',
        ),
        array(
            'client_assistance__bot_dialog_3__message_1',
            'client_assistance__bot_dialog_3__message_2',
        ),
        array(
            'client_assistance__bot_dialog_4__message_1',
            'client_assistance__bot_dialog_4__message_2',
        ),
        array(
            'client_assistance__bot_dialog_5__message_1',
            'client_assistance__bot_dialog_5__message_2',
        ),
        array(
            'client_assistance__bot_dialog_6__message_1',
            'client_assistance__bot_dialog_6__message_2',
        ),
        array(
            'client_assistance__bot_dialog_7__message_1',
            'client_assistance__bot_dialog_7__message_2',
        )
    )
);

$this->clientAssistance['random_persons'] = array(
    'US' => array(
        //the same like other!
        array(
            'displayName' => 'client_assistance__bot_sender_1__name',
            'avatar' => 'http://get.whotrades.com/u2/photo1886/20136809648-0/xsmall.jpeg',
        ),
        array(
            'displayName' => 'client_assistance__bot_sender_2__name',
            'avatar' => 'http://get.whotrades.com/u2/photo80E2/20359882497-0/xsmall.jpeg',
        ),
        array(
            'displayName' => 'client_assistance__bot_sender_3__name',
            'avatar' => 'http://get.whotrades.com/u2/photo98BB/20582955346-0/xsmall.jpeg',
        )
    ),
    'other' => array(
        array(
            'displayName' => 'client_assistance__bot_sender_1__name',
            'avatar' => 'http://get.whotrades.com/u2/photo1886/20136809648-0/xsmall.jpeg',
        ),
        array(
            'displayName' => 'client_assistance__bot_sender_2__name',
            'avatar' => 'http://get.whotrades.com/u2/photo80E2/20359882497-0/xsmall.jpeg',
        ),
        array(
            'displayName' => 'client_assistance__bot_sender_3__name',
            'avatar' => 'http://get.whotrades.com/u2/photo98BB/20582955346-0/xsmall.jpeg',
        )
    )
);

$this->clientAssistance['logoutTimeout'] = 4*60;
$this->clientAssistance['logoutRecheckLimit'] = 8;
$this->clientAssistance['logoutRecheckTimeout'] = 8*60;

// last line!!! last line!!! last line!!! last line!!! last line!!! last line!!!
