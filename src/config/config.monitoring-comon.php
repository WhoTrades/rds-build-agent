<?php

// bn: settings for grabbing detailed logs for performance and operations monitoring and analytics

$this->monitoring['strategies'] = array(
    'Monitoring_Autotagger_Strategy_Person',
    'Monitoring_Autotagger_Strategy_Anonym',
);

$this->monitoring['business_loggers'] = array(
    'Monitoring_BusinessLogger_ClientFlowHandler',
    'Monitoring_BusinessLogger_ClientOperationHandler',
    'Monitoring_BusinessLogger_ChartsHandler',
    'Monitoring_BusinessLogger_BlogPostsHandler'
);

$this->monitoring['task_one_time_lag'] = 60; //mk: все OneTime таски, которые лагают больше чем на минуту - сливаются в STM
