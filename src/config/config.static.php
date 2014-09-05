<?php
$this->staticPrefetchControl = array(
    '//ajax.googleapis.com',
    '//fonts.googleapis.com'
);

$this->staticImagesLocationUrl = "http://static.whotrades.com"; // al: don't need a "/" in the end
$this->jsLocationUrl = "http://static.whotrades.com/";
$this->cssLocationUrl = "http://static.whotrades.com/";
$this->staticDir = "http://static.whotrades.com"; // al: don't need a "/" in the end

$this->static_dir = $this->root_dir . '/static/www/';
$this->less_base_dir = $this->root_dir . '/static/www/';

$this->use_styles_cache = false;
$this->less_binary = '/var/opt/node_modules/less/bin/lessc';
$this->stylus_binary = '/usr/bin/stylus';

//an: Отключил, так как не компилился стилус на тесте
$this->stylusCustomJS = $this->static_dir . 'js/stylus/stylusCustom.js';

$this->css_preprocessor_command = 'node ' . $this->root_dir . '/misc/tools/css_preprocessor/rtl-converter.js';

$this->css_merged = true;
$this->javascript_merged = true;

// chunking for IE
$this->css_chunk_max_size=4095;

//va: since #who-678
//va: Now moved to config.static.php, since config.comon.php is included after config.build.php
//Do we need to cache the result of sites/styles/main.tpl
$this->cacheStylesMain = true;

//prefix of key for storing in cache (will be appended with build hash)
$this->stylesMainCacheKeyPrefix = 'styles_main_' . (empty($_SERVER['SERVER_NAME']) ? 'console' : $_SERVER['SERVER_NAME']) . '__';

// Reserved keys for style/script map.
$this->mapStyles = null;
$this->mapScripts = null;

// mars: old
$this->css = array(
    // another_merging_css_files begin

    'groups' => array('css/groups.css'),

    /* old and not used
        'map' => array('css/map.css'),
        'people' => array('css/people.css'),
        'photos' => array('css/photos.css'),
        'places' => array('css/places.css'),
    */
    // another_merging_css_files end
);

//id: #WHO-1753: сборки smarty-css
$this->cssSmarty = array(
    'main' => array('site/styles/main.css.tpl'),
    'custom-project' => array('site/projects/custom/styles/styles.css.tpl'),
    'custom-styles' => array('site/styles/custom-styles.css.tpl'),
);

//hash of template output (should be redefined in config.build.php)
$this->stylesHash = array('main' => null, 'custom-project' => null, 'custom-styles' => null);

/**
 * The module (interfaces) configure.
 *
 * Example:
 *     'name' => array(
 *         'view' => 'path/to/tpl',
 *         'styles' => 'path/to/tpl',
 *         'scripts' => 'path/to/tpl',
 *     )
 */
$this->client_side_modules = array(
    // mars: vendor libs begin
        // jquery and jquery plugins
            'jquery' => array(
                'scripts' => array(
                    'vendor/jquery/dist/jquery.js',
                    'js/jqueryNoConflict.js',
                    'js/lib/jquery.browser.js',
                    'js/lib/jquery-ajax-prefilter.js',
                    'js/lib/jquery.serializeObject.js',
                ),
            ),
            'jquery-ui' => array(
                'scripts' => array(
                    'vendor-libs/jquery-ui/modules/jquery.ui.core.js',
                    'vendor-libs/jquery-ui/modules/jquery.ui.widget.js',
                    'vendor-libs/jquery-ui/modules/jquery.ui.mouse.js',
                ),
            ),
            'jquery-form' => array(
                'scripts' => array(
                    'vendor-libs/jquery.form/jquery.form.js',
                ),
            ),
            'jquery-inputmask' => array(
                'scripts' => array(
                    'vendor-libs/jquery.inputmask/jquery.inputmask.js',
                ),
            ),
            'jquery-bind-first' => array(
                'scripts' => array(
                    'vendor-libs/jquery.bind-first/jquery.bind-first.js',
                ),
            ),
            'jquery-inputmask-multi' => array(
                'scripts' => array(
                    'vendor-libs/jquery.inputmask-multi/jquery.inputmask-multi.js',
                ),
            ),
            'jquery-meio-mask' => array(
                'scripts' => array(
                    'vendor-libs/jquery.meio.mask/jquery.meio.mask.js',
                ),
            ),
            'jquery-ui-i18n' => array(
                'scripts' => array(
                    'vendor-libs/jquery-ui/i18n/jquery-ui-i18n.js',
                ),
            ),
            'jquery-ui-datepicker' => array(
                'scripts' => array(
                    'vendor-libs/jquery-ui/modules/jquery.ui.datepicker.js',
                ),
            ),
            'jquery-ui-draggable' => array(
                'scripts' => array(
                    'vendor-libs/jquery-ui/modules/jquery.ui.draggable.js',
                ),
            ),
            'jquery-ui-resizable' => array(
                'styles' => array(
                    'vendor-libs/jquery-ui/themes/base/jquery.ui.resizable.css',
                ),
                'scripts' => array(
                    'vendor-libs/jquery-ui/modules/jquery.ui.resizable.js',
                ),
            ),
            'jquery-effects-core' => array(
                'scripts' => array(
                    'vendor-libs/jquery-ui/modules/jquery.effects.core.js',
                ),
            ),
            'jquery-effects-bounce' => array(
                'scripts' => array(
                    'vendor-libs/jquery-ui/modules/jquery.effects.bounce.js',
                ),
            ),
            'jquery-sort-elements' => array(
                'scripts' => array(
                    'js/lib/jquery.sort-elements.js',
                ),
            ),

            'jquery-validate-en' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                ),
            ),
            'jquery-validate-ar' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_ar.js',
                ),
            ),
            'jquery-validate-bg' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_bg.js',
                ),
            ),
            'jquery-validate-ca' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_ca.js',
                ),
            ),
            'jquery-validate-cs' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_cs.js',
                ),
            ),
            'jquery-validate-da' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_da.js',
                ),
            ),
            'jquery-validate-de' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_de.js',
                ),
            ),
            'jquery-validate-el' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_el.js',
                ),
            ),
            'jquery-validate-es' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_es.js',
                ),
            ),
            'jquery-validate-et' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_et.js',
                ),
            ),
            'jquery-validate-eu' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_eu.js',
                ),
            ),
            'jquery-validate-fa' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_fa.js',
                ),
            ),
            'jquery-validate-fi' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_fi.js',
                ),
            ),
            'jquery-validate-fr' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_fr.js',
                ),
            ),
            'jquery-validate-he' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_he.js',
                ),
            ),
            'jquery-validate-hr' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_hr.js',
                ),
            ),
            'jquery-validate-hu' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_hu.js',
                ),
            ),
            'jquery-validate-it' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_it.js',
                ),
            ),
            'jquery-validate-ja' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_ja.js',
                ),
            ),
            'jquery-validate-ka' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_ka.js',
                ),
            ),
            'jquery-validate-kk' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_kk.js',
                ),
            ),
            'jquery-validate-lt' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_lt.js',
                ),
            ),
            'jquery-validate-lv' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_lv.js',
                ),
            ),
            'jquery-validate-nl' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_nl.js',
                ),
            ),
            'jquery-validate-no' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_no.js',
                ),
            ),
            'jquery-validate-pl' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_pl.js',
                ),
            ),
            'jquery-validate-pt-BR' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_pt_BR.js',
                ),
            ),
            'jquery-validate-pt-PT' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_pt_PT.js',
                ),
            ),
            'jquery-validate-ro' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_ro.js',
                ),
            ),
            'jquery-validate-ru' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_ru.js',
                ),
            ),
            'jquery-validate-si' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_si.js',
                ),
            ),
            'jquery-validate-sk' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_sk.js',
                ),
            ),
            'jquery-validate-sl' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_sl.js',
                ),
            ),
            'jquery-validate-sr' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_sr.js',
                ),
            ),
            'jquery-validate-sv' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_sv.js',
                ),
            ),
            'jquery-validate-th' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_th.js',
                ),
            ),
            'jquery-validate-tr' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_tr.js',
                ),
            ),
            'jquery-validate-uk' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_uk.js',
                ),
            ),
            'jquery-validate-vi' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_vi.js',
                ),
            ),
            'jquery-validate-zh' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_zh.js',
                ),
            ),
            'jquery-validate-zh-TW' => array(
                'scripts' => array(
                    'js/lib/jquery-validate.1.10.0/jquery.validate.js',
                    'js/lib/jquery-validate.1.10.0/localization/lang.js',
                    'js/lib/jquery-validate.1.10.0/localization/messages_zh_TW.js',
                ),
            ),

            'jquery-tags-input' => array(
                'styles' => array(
                    'vendor-libs/jquery-tags-input/jquery.tagsinput.css',
                ),
                'scripts' => array(
                    'vendor-libs/jquery-tags-input/jquery.tagsinput.js',
                ),
            ),
            'jquery-autocomplete' => array(
                'styles' => array(
                    'vendor-libs/jquery.autocomplete/jquery.autocomplete.css',
                ),
                'scripts' => array(
                    'vendor-libs/jquery.autocomplete/jquery.autocomplete.min.js',
                ),
            ),
        // end

        // prototype and prototype libs
            'prototype' => array(
                'scripts' => array(
                    'vendor-libs/prototype/prototype.js',
                ),
            ),

            // mars: scriptaculous scripts begin
                'builder' => array(
                    'scripts' => array(
                        'vendor-libs/scriptaculous/builder.js',
                    ),
                ),
            // mars: scriptaculous scripts end

            'accordion' => array(
                'scripts' => array(
                    'js/lib/accordion.js',
                ),
            ),
        // ens

        /*
         * Fallbacks.
         */
        'ie9lt' => array(
            'scripts' => array(
                'vendor/html5shiv/dist/html5shiv.js',
                'vendor/respond/dest/respond.src.js',
                'lib/polyfills/es5.js'
            ),
        ),

        'modernizr' => array(
            'scripts' => array(
                'vendor/modernizr/modernizr.js'
            ),
        ),

        'environment' => array(
            'scripts' => array('lib/environment.js')
        ),

        'milieu' => array(
            'scripts' => array(
                'vendor/modernizr/modernizr.js',
                'lib/environment.js'
            )
        ),

        'swfobject' => array(
            'scripts' => array(
                'js/lib/swfobject.js',
            ),
        ),

        'ie-png-fix' => array(
            'scripts' => array(
                'libs/ie_png-fix_files/iepngfix_tilebg.js',
            ),
        ),

        'masonry-lib' => array(
            'scripts' => array(
                'vendor-libs/masonry/masonry.js',
            ),
        ),

        'redactor-en' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/en.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-de' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/de.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-th' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/th.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-zh' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/zh.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-ru' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/ru.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-hi' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/hi.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-cs' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/cs.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-es' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/es.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-fa' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/fa.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-fr' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/fr.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-hr' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/hr.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-hu' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/hu.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-id_id' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/id_id.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-it' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/it.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-ms' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/ms.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-pl' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/pl.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-pt' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/pt.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-ro' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/ro.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-sl' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/sl.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-tr' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/tr.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),
        'redactor-ar' => array(
            'styles' => array(
                'libs/redactor/redactor.css',
                'libs/redactor/plugin/whotrades.styl',
            ),
            'scripts' => array(
                'libs/redactor/redactor.js',
                'libs/redactor/lang/ar.js',
                'libs/redactor/plugin/whotrades.js',
                'libs/redactor/plugin/tradingview.js',
                'libs/redactor/plugin/instruments.js',
            ),
        ),

        'cropper' => array(
            'styles' => array(
                'vendor-libs/cropper/cropper.less',
            ),
        ),
        'scripts-crop' => array(
            'scripts' => array(
                'vendor-libs/scriptaculous/dragdrop.js',
                'js/lib/dragdrop-extend.js',
                'vendor-libs/cropper/cropper.js',
            ),
        ),

        'moment.js' => array(
            'scripts' => array(
                'vendor-libs/moment.js/moment+langs.js',
            ),
        ),

        'jquery-slider' => array(
            'scripts' => array(
                'vendor-libs/jquery.unslider/src/unslider.js',
                //'vendor-libs/jquery.swipe/swipe.js'
            ),
        ),
        'ui-countdown' => array(
            'scripts' => array(
                'ui/countdown/countdown.js',
            ),
        ),

    // mars: end vendor libs


    // mars: our libs
        'cookie' => array(
            'scripts' => array(
                'js/lib/cookie.js',
            ),
        ),
    // mars: end our libs


    // mars: modules
        'ajax-form-submit' => array(
            'scripts' => array(
                'js/ajax-form-submit.js',
            ),
        ),
        'overlay-content-popup' => array(
            'scripts' => array(
                'site/blocks/overlay-content/overlay-content.js',
            ),
            'styles' => array(
                'site/blocks/overlay-content/overlay-content.less',
            ),
        ),
        'overlay-photo-gallery' => array(
            'styles' => array(
                'site/blocks/overlay-photo-gallery/overlay-photo-gallery.less',
            ),
            'scripts' => array(
                'site/blocks/overlay-photo-gallery/overlay-photo-gallery.js',
            ),
        ),
        'masonry' => array(
            'styles' => array(
                'site/blocks/masonry/masonry.styl',
            ),
            'scripts' => array(
                'site/blocks/masonry/masonry.js',
            ),
        ),
        'form-validation' => array(
            'scripts' => array(
                'common-blocks/form-validation/form-validation.js',
            ),
        ),
        'dialoggy' => array(
            'styles' => array(
                'ui/dialoggy/dialoggy.styl',
            ),
            'scripts' => array(
                'ui/dialoggy/dialoggy.js',
            ),
        ),
        'drop' => array(
            'styles' => array(
                'ui/drop/drop.styl',
            ),
            'scripts' => array(
                'ui/drop/drop.js',
            ),
        ),
        'countdown-core' => array(
            'styles' => array(
                'app/whotrades/components/countdown/countdown.styl'
            ),
            'scripts' => array(
                'lib/plugins/countdown/jquery.countdown.min.js',
                'app/whotrades/components/countdown/countdown.js',
            ),
        ),
            // локализация countdown
            'countdown-ru' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-ru.js',
                ),
            ),
            'countdown-de' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-de.js',
                ),
            ),
            'countdown-es' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-es.js',
                ),
            ),
            'countdown-fr' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-fr.js',
                ),
            ),
            'countdown-hr' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-hr.js',
                ),
            ),
            'countdown-hu' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-hu.js',
                ),
            ),
            'countdown-id_id' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-id_id.js',
                ),
            ),
            'countdown-it' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-it.js',
                ),
            ),
            'countdown-ms' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-ms.js',
                ),
            ),
            'countdown-pl' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-pl.js',
                ),
            ),
            'countdown-ro' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-ro.js',
                ),
            ),
            'countdown-sl' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-sl.js',
                ),
            ),
            'countdown-th' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-th.js',
                ),
            ),
            'countdown-tr' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-tr.js',
                ),
            ),
            'countdown-ar' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-ar.js',
                ),
            ),
            'countdown-cs' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-cs.js',
                ),
            ),
            'countdown-fa' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-fa.js',
                ),
            ),
            'countdown-zh' => array(
                'scripts' => array(
                    'lib/plugins/countdown/jquery.countdown-zh-TW.js',
                ),
            ),
        'forecast-preview' => array(
            'styles' => array(
                'app/whotrades/components/forecast-preview/forecast-preview.styl',
            ),
            'scripts' => array(
                'app/whotrades/components/forecast-preview/forecast-preview.js',
            ),
        ),
        'forecast' => array(
            'styles' => array(
                'app/whotrades/components/forecast/forecast.styl',
            ),
            'scripts' => array(
                'app/whotrades/components/forecast/forecast.js',
            ),
        ),
        'share' => array(
            'styles' => array(
                'ui/share/share.styl',
            ),
            'scripts' => array(
                'ui/share/share.js',
            ),
        ),
        'tooltip' => array(
            'styles' => array(
                'ui/tooltip/tooltip.styl',
            ),
            'scripts' => array(
                'ui/tooltip/tooltip.js',
            ),
        ),
        'ajax-append-items' => array(
            'scripts' => array(
                'site/blocks/ajax-append-items/ajax-append-items.js',
            ),
        ),
        'sorting-elements' => array(
            'scripts' => array(
                'js/sorting-elements.js',
            ),
        ),
        'tabbed-content' => array(
            'scripts' => array(
                'common-blocks/tabs/tabs.js',
            ),
        ),
    // mars: end modules

    // ui elements
        'search-field' => array(
            'styles' => array(
                'ui-elements/search-field/search-field.styl',
            ),
            'scripts' => array(
                'ui-elements/search-field/search-field.js',
            ),
        ),
        'chain-button' => array(
            'styles' => array(
                'site/blocks/chain-button/chain-button.less',
            ),
        ),
    // end

    // ui controls
        'input-time-mask' => array(
            'scripts' => array(
                'js/input-time-mask.js',
            ),
        ),
        'follow-link' => array(
            'scripts' => array(
                'site/blocks/follow-person/follow-person.js',
            ),
        ),
        'rating' => array(
            // al: include in #site-on-platforma
            /*'styles' => array(
                'site/modules/rating/rating.styl',
            ),*/
            'scripts' => array(
                'site/modules/rating/rating.js',
            ),
        ),
        'rating-mod' => array(
            'scripts' => array(
                'site/modules/rating/rating-mod.js',
            ),
        ),
        'toolbar-fallback' => array(
            // al: include in #site-on-platforma
            'styles' => array(
                'app/whotrades/components/toolbar/toolbar-fallback.styl',
            ),
        ),
        'share-block' => array(
            // al: include in #site-on-platforma
            /*'styles' => array(
                'app/whotrades/components/social/social-share.styl',
            ),*/
            'scripts' => array(
                'app/whotrades/components/social/social-share.js',
            ),
        ),
        'chart-forecast-voting-block' => array(
            'scripts' => array(
                'site/modules/charts/chart-forecast-voting-block/chart-forecast-voting-block.js',
            ),
        ),
        'popup-calendar' => array(
            'styles' => array(
                'vendor-libs/jquery-ui/themes/custom/datepicker.css', 'vendor-libs/jquery-ui/fixes.less',
            ),
        ),

        // phone
        'phone-field' => array(
            'scripts' => array(
                'site/blocks/phone-component/phone-input-field.js',
            ),
        ),
        'phone-verify-send-sms' => array(
            'scripts' => array(
                'site/blocks/phone-component/phone-verify-send-sms.js',
            ),
        ),
        'phone-component' => array(
            'scripts' => array(
                'site/blocks/phone-component/phone-component.js',
            ),
        ),
        'check-sms-status' => array(
            'scripts' => array(
                'site/blocks/phone-component/check-sms-status.js',
            ),
        ),
        // end
    // end ui controls

    // includes
        'comments' => array(
            'styles' => array(
                'site/blocks/comments/comments.less',
            ),
            'scripts' => array(
                'site/blocks/comments/comments.js',
            ),
        ),
    // end

    // mars: projects, глобальные сборщики для проектов
        //an: @see MergeJavascript
        'javascript_includes' => array(
            'scripts' => array(
                'vendor/jquery/dist/jquery.js',
                'js/jqueryNoConflict.js',
                'js/lib/jquery.browser.js',
                'js/lib/jquery-ajax-prefilter.js',
                'js/lib/jquery.serializeObject.js',

                'vendor-libs/prototype/prototype.js',
                'js/lib/cookie.js',
                'vendor/underscore/underscore.js',
                'js/dictionary.js',
                'vendor-libs/scriptaculous/builder.js',
                'vendor-libs/scriptaculous/controls.js',
                'js/lib/smooth.js',
                'vendor-libs/scriptaculous/sound.js',
                'js/lib/extend-generic.js',
                'js/lib/extend.js',
                'js/lib/WCH.js',
                'vendor-libs/scriptaculous/effects.js',
                'js/lib/dklab_realplexor.js',
                'js/realplexor.js',
                'js/lib/urlProcessor.js',
                'js/lib/url.js',
                'js/main.js',
                'ui/eventer/eventer.js',
                'js/dom-ready.js',
                'js/confirm-submit.js',
                'js/uppod_player.js',
                'js/dynamicTags.js',
                'js/helper.js',
                'js/onload.js',
                'js/navigation.js',
                'vendor-libs/scriptaculous/dragdrop.js',
                'js/lib/dragdrop-extend.js',
                'js/console.trace.js',
                'js/logger.js', // @prototype, ComonCabinet widget.
                'js/site/utils.js', // @prototype, ComonCabinet
            ),
        ),

        'javascript_includes_new_final' => array(
            'scripts' => array(
                'vendor/jquery/dist/jquery.js',
                'js/jqueryNoConflict.js',
                'js/lib/jquery.browser.js',
                'js/lib/jquery-ajax-prefilter.js',
                'js/lib/jquery.serializeObject.js',

                // Vendor.
                'vendor/underscore/underscore.js',
                //'vendor/requirejs/require.js',

                'js/lib/cookie.js',
                'js/dictionary.js',
                'js/lib/dklab_realplexor.js',
                'js/realplexor.js',
                'app/modules/socket-wrapper/socket-wrapper.js',
                'app/modules/socket-wrapper/libs/realplexor.js',
                'js/lib/urlProcessor.js',
                'js/lib/url.js',
                'js/dom-ready.js',

                //'js/site/utils.js',                             // @prototype, ComonCabinet widget.
            ),
        ),

        // @deprecated
        'javascript_includes_prototype' => array(
            'scripts' => array(
                'vendor-libs/prototype/prototype.js',
                'vendor-libs/scriptaculous/builder.js',
                'vendor-libs/scriptaculous/controls.js',
                'vendor-libs/scriptaculous/effects.js',
                'vendor-libs/scriptaculous/sound.js',           // http://whotrades.com/edit/
                'vendor-libs/scriptaculous/dragdrop.js',        // http://whotrades.com/edit/

                //'js/lib/smooth.js',                           // http://whotrades.com/edit/
                'js/lib/extend-generic.js',
                'js/lib/extend.js',

                'js/lib/WCH.js',                                // photos.js and ApplicationsItem.tpl

                'js/main.js',
                'js/helper.js',                                 // @prototype
                'js/onload.js',                                 // @prototype
                'js/navigation.js',                             // http://whotrades.com/edit/
                'js/lib/dragdrop-extend.js',                    // http://whotrades.com/edit/
                'js/console.trace.js',                          // not used

                'js/confirm-submit.js',
                'js/dynamicTags.js',                            // PlacesItemImprove.tpl
                'js/logger.js',                                 // @prototype, ComonCabinet widget.

                'js/site/utils.js',                             // @prototype, ComonCabinet widget.
            )
        ),

        'site-on-platforma' => array(
            'styles' => array(
                // Normalize.
                'vendor-libs/normalize/normalize.css',
                'site/reset.less',

                // Statement and utils classes, replace to state.styl
                'common-utils.less',
                'utils.less',
                'ui/state.styl', // todo ak: check full compatibility and REPLACE!

                // Interface.
                'ui/link.styl',
                'ui/grid.styl',
                'ui/label.styl',
                'ui/snippet.styl',
                'ui/hint/hint.styl',
                'ui/flags/flags.styl',
                'ui/notify/notify.styl',
                'ui/button/button.styl',
                'ui/button/button-suite.styl',
                'ui/button/button-group.styl',
                'ui/button/interface/default.styl',
                'ui/button/interface/air.styl',
                'ui/button/interface/host.styl',
                'ui/form/index.styl',

                /*
                 * Sortout! Sortout! Sortout!
                 * Все что находится ниже, отсортировать/отрефакторить.
                 */
                'site/links.less',
                'ui-elements/inline-elemens/inline-elements.less',
                'ui-elements/columns/columns.styl',
                'ui-elements/spacers/spacers.less',

                // Icons.
                'site/blocks/icons/icons.less',
                'site/blocks/loading-icon/loading-icon.less',
                'site/blocks/popup-close-icon/popup-close-icon.less', // for overlay-popup.less
                'site/blocks/cursor-loading-icon/cursor-loading-icon.less',

                // Locale.
                'app/whotrades/components/interfaces/locale.styl',

                // Social.
                'app/whotrades/components/social/social-share.styl',
                'site/blocks/follow-person/follow-person.less',
                'site/modules/blogs/blogs-base.less',
                'site/modules/rating/rating.styl',
                'site/blocks/user-pic/user-pic.less',
                'site/blocks/user-card/user-card.less',
                'site/blocks/blogs-user-card/blogs-user-card.less',

                // Form.
                'ui-elements/form/form.less',
                'common-blocks/checkbox-block/checkbox-block.less',
                'common-blocks/checkbox-radio-blocks/checkbox-radio-blocks.less',
                'site/projects/whotrades/block-simple-form-page/block-simple-form-page.less',
                'site/blocks/asterisk-required/asterisk-required.less',

                // Pagination.
                'site/blocks/pager/pager.less',
                'site/blocks/ajax-append-items/ajax-append-items.styl',
                'ui/pagination/pagination.styl',

                // Popup/Notify.
                'site/blocks/overlay-content-container/overlay-content-container.less',

                // Other.
                'common-blocks/anchor/anchor.less',
                'site/blocks/widget-block/widget-block.less',
                'site/blocks/common-layout/common-layout.styl',
                'site/blocks/text-content/text-content.less',
                'common-blocks/equidistant-blocks/equidistant-blocks.less',
                'common-blocks/lazy-load/lazy-load.less',
                'site/blocks/ajax-href/ajax-href.less',
                'site/blocks/captcha/captcha.less',

                // BEM
                'app/blocks/icon/icon.styl',
                'app/blocks/link/link.styl',
                'app/blocks/button/button.styl',
                'app/blocks/input/input.styl',
                'app/blocks/form/form.styl',
                'app/blocks/social-buttons/social-buttons.styl',
            ),
            'scripts' => array(
                // Vendor.
                'vendor/pimple.js/pimple.js',    // DI.
                'vendor/page.js/index.js',       // Routing.

                // Interface.
                'ui/button/button.js',
                'ui/notify/notify.js',
                'ui/eventer/eventer.js',

                // Polyfills.
                'lib/polyfills/json2.js',
                'lib/polyfills/placeholder.js',
                'lib/polyfills/console.js',
                'lib/polyfills/raf.js',

                // Eventer.
                'lib/eventer.js',
                'lib/eventer-click.js',
                'lib/eventer-submit.js',
                'lib/eventer/reload.js',
                'lib/eventer/close.js',
                'lib/eventer/spoiler.js',
                'lib/eventer/dialoggy.js',
                'lib/eventer/drop.js',
                'lib/eventer/share.js',
                'lib/eventer/chart.js',
                'lib/eventer/chart-google.js',
                'lib/eventer/require.js',
                'lib/eventer/lazy-load.js',
                'lib/eventer/logger/analytics.js',
                'lib/eventer/logger/interests.js',
                'lib/eventer/logger/cdn.js',
                'lib/eventer/logger/performance.js',
                'lib/eventer/stocktwits.js',

                // Api.
                'lib/api/chart.js',
                'lib/api/chart-google.js',

                // Application.
                'lib/app.js',
                'lib/manager.js',
                'lib/interface.js',
                'lib/utils.js',

                /*
                 * Sortout! Sortout! Sortout!
                 * Все что находится ниже, отсортировать/отрефакторить.
                 */
                'js/lib/date_format.js',
                'js/lib/persist-js-0.1.0/persist.js',
                'js/site/js-storage.js',
                'js/site/comet-activity.js',
                // 'js/site/errorLogger.js',  // @qbaka iz: временно отключаем

                // Deprecated due @prototype

                // Popup.
                'site/blocks/popup-window/open-popup-window.js', // al: target="popup-window", @rewrite in release-54!
//                'site/blocks/join-confirm-window/join-confirm-window.js',
                'site/blocks/popup-iframe/popup-iframe.js',
                'site/blocks/popup/popup.js',
                'site/blocks/popup-banner/popup-banner.js', // Usage in ComonLearning.tpl
                'site/projects/whotrades/messenger-popup/open-messenger-popup.js',

                // Tooltips/Dropdown.
                'ui-elements/switcher/switcher.js', // ComonPersonSubscriptions.tpl
                'site/blocks/dropdown-list/dropdown-list.js',

                // Tabs.
                'js/site/tabs.js',

                // Accordion.
                'js/site/collapsible-blocks.js',

                // UI.
                /*'vendor-libs/jquery-ui/modules/jquery.ui.core.js',
                'vendor-libs/jquery-ui/modules/jquery.ui.widget.js',
                'vendor-libs/jquery-ui/modules/jquery.ui.mouse.js',*/
                'ui-elements/custom-input-range/custom-input-range.js',
                'site/blocks/date-picker/date-picker-import.js',
                'site/blocks/cursor-loading-icon/cursor-loading-icon.js', // @delete
                'site/blocks/columns/columns.js',
                'site/blocks/ajax-href/ajax-href.js',
                'js/anchors-slide.js',

                // Utils.
                'js/inheritance.js',
                'js/lib/text-template.js',
                'js/ajax-html-templates.js',
                'libs/multi-requests.js',
                'libs/utils/utils.js',
                'js/autofocus.js',
                'site/blocks/print-section/print-section.js',

                // Lazyload.
                'vendor-libs/lazyload/lazyload.js',
                'libs/module-loader.js',
                'libs/in-viewport/in-viewport.js',

                // Validate.
                'site/projects/whotrades/jquery-validate-init.js',
                'js/site/input-mask.js', // @prototype

                // Social.
                'site/blocks/facebook-button/facebook-button.js',
                'js/site/vkontakte-button.js',
                'js/site/qq-button.js',
                'js/site/social-buttons.js',

                // layout
                'site/blocks/common-layout/common-layout.js',

                // Other.
                'site/projects/whotrades/personal-channel/personal-channel.js', // @prototype, client-asistance.
                'site/modules/blogs/delete-blog-post.js',
                'js/confirm-submit.js',
                'js/relative-time.js',

                // Domready load modules.
                'js/site/domready-load-modules.js',

                // Chat.
                'site/modules/chat/open-chat.js',

                // Smi2 Advertisements
                'js/site/smi2-ads-manager.js',

                // Adriver.
                'vendor-libs/adriver/adriver.core.2.js',
                'site/blocks/adriver-banner/adriver-banner.js',

                // BEM
                'app/blocks/input/input.js',
                'app/blocks/form/form.js',

                //warl: don't remove this lines, plz
                //chat
                //'libs/socket.io/socket.io.js',
                //'libs/chat/chat-client.js', // real path services/chat/
            ),
        ),

        'site-on-iframe' => array(
            'styles' => array(
                'vendor-libs/normalize/normalize.css',
                'site/reset.less',
                'site/projects/whotrades/base.less',

                'ui/button/button.styl',
                'ui/button/button-suite.styl',
                'ui/button/interface/default.styl',
                'ui/flags/flags.styl',
                'ui/notify/notify.styl',

                // Links.
                'site/links.less',

                // Icons.
                'site/blocks/icons/icons.less',
                'site/blocks/loading-icon/loading-icon.less',
                'site/blocks/popup-close-icon/popup-close-icon.less', // for overlay-popup.less
                'site/blocks/cursor-loading-icon/cursor-loading-icon.less',

                // Form.
                'common-blocks/checkbox-block/checkbox-block.less',
                'common-blocks/checkbox-radio-blocks/checkbox-radio-blocks.less',
                'site/projects/whotrades/block-simple-form-page/block-simple-form-page.less',
                'site/blocks/asterisk-required/asterisk-required.less',

                // Popup/Notify.
                'site/blocks/overlay-content-container/overlay-content-container.less',
            ),
            'scripts' => array(
                // Vendor.
                'vendor/pimple.js/pimple.js',    // DI.
                'vendor/page.js/index.js',       // Routing.

                // Interface.
                'ui/button/button.js',
                'ui/notify/notify.js',
                'ui/eventer/eventer.js',

                // Polyfills.
                'lib/polyfills/json2.js',
                'lib/polyfills/placeholder.js',
                'lib/polyfills/console.js',

                // Eventer.
                'lib/eventer.js',
                'lib/eventer-click.js',
                'lib/eventer-submit.js',
                'lib/eventer/reload.js',
                'lib/eventer/close.js',
                'lib/eventer/spoiler.js',
                'lib/eventer/dialoggy.js',
                'lib/eventer/drop.js',
                'lib/eventer/chart.js',
                'lib/eventer/chart-google.js',
                'lib/eventer/require.js',
                'lib/eventer/lazy-load.js',
                'lib/eventer/logger/analytics.js',
                'lib/eventer/logger/interests.js',

                // Application.
                'lib/app.js',
                'lib/manager.js',
                'lib/interface.js',
                'lib/manager.js',
                'lib/utils.js',

                // Utils.
                'js/lib/text-template.js',
                'js/ajax-html-templates.js',
                'site/blocks/cursor-loading-icon/cursor-loading-icon.js', // @delete

                // UI.
                'ui-elements/custom-input-range/custom-input-range.js',
                'site/blocks/date-picker/date-picker-import.js',
                'site/blocks/messenger/message-input-field-expand.js',

                // Lazyload.
                'vendor-libs/lazyload/lazyload.js',
                'libs/module-loader.js',
                'libs/multi-requests.js',
                'libs/utils/utils.js',
                'libs/in-viewport/in-viewport.js',

                // Validate.
                'site/projects/whotrades/jquery-validate-init.js',
                'js/site/input-mask.js', // @prototype
                'js/autofocus.js',

                // Domready load modules.
                'js/site/domready-load-modules.js',
            ),
        ),

        'whotrades' => array(
            'styles' => array(
                'app/whotrades/layouts/header.styl',
                'app/whotrades/layouts/header-bar.styl',

                // HELL!
                'site/projects/whotrades/whotrades.less',

                // whotrades footer
                'site/projects/whotrades/footer/footer.less',
                // end

                // Notification.
                'app/whotrades/components/notifications/notifications.styl',

                // Sorted!
                'site/projects/whotrades/internal-page-header/internal-page-header.styl',
                'site/projects/whotrades/nav-sidebar-relate/nav-sidebar-relate.styl',
                'site/blocks/popup-banner/popup-banner.less',
                'site/blocks/tooltip/tooltip.styl',
                'site/blocks/banner/banner.styl',

                //'css/special_site_extras.less', // from styles_group.tpl
            ),
            'scripts' => array(
                // Header.
                'app/whotrades/layouts/header.js',
                'vendor/sticky/jquery.sticky.js',

                // Notification.
                'app/whotrades/components/notifications/notifications.js',
                'libs/utils/jquery.slimscroll.min.js',
            )
        ),

        'debugger' => array(
            'styles' => array(
                'app/whotrades/components/interfaces/debugger.styl',
            ),
            'scripts' => array(
                'app/whotrades/components/interfaces/debugger.js',
            ),
        ),

        'print-window' => array(
            'styles' => array(
                'site/blocks/print-section/print-window.less',
            ),
        ),

        'platforma' => array(
            'scripts' => array(
                'js/platforma.js',
            ),
        ),

        'messenger-popup-iframe' => array(
            'styles' => array(
                'site/projects/whotrades/messenger-iframe/messenger-iframe.less',
                'site/projects/whotrades/messenger-iframe/messenger-iframe.styl',
            ),
            'scripts' => array(
                'site/blocks/messenger/message-input-field-expand.js',
            ),
        ),

        'registration-iframe' => array(
            'styles' => array(
                'site/projects/edu-china/registration-iframe/registration-iframe.styl',
            ),
        ),

        // Fallback IE6/7/8
        // @fallback
        'ie7' => array(
            'styles' => array(
                'css/ie7_fixes.css'
            ),
        ),
        'ie6' => array(
            'styles' => array(
                'css/ie6_fixes.css'
            ),
        ),
        'ie6_special_site_extras' => array(
            'styles' => array(
                'css/ie6_special_site_extras_fixes.css'
            ),
        ),
        'ie5' => array(
            'styles' => array(
                'css/ie5_fixes.css'
            ),
        ),

        'site_ie7' => array(
            'styles' => array(
                'site/old/ie7_group_fixes.css'
            ),
        ),
        'site_ie6' => array(
            'styles' => array(
                'site/old/ie6_group_fixes.css',
            ),
        ),
        'site_ie5' => array(
            'styles' => array(
                'site/old/ie5_group_fixes.css',
            ),
        ),

        // exotic options project
        'exotic-options' => array(
            'styles' => array(
                'site/projects/exotic-options/exotic-options.less',
                'site/projects/exotic-options/video/video.styl',
                'ui/notify/notify.styl',
            ),
            'scripts' => array(
                //'site/projects/exotic-options/platform-switcher/platform-switcher.js',
                'site/projects/exotic-options/jquery-validate-init.js',
                'site/projects/exotic-options/video/video.js',
            ),
        ),

        // edu china project
            'edu-china' => array(
                'styles' => array(
                    'site/projects/edu-china/edu-china.less',
                ),
                'scripts' => array(
                    'site/projects/edu-china/qq-button/qq-button.js',
                ),
            ),
            'edu-china-widget-rss-viewer' => array(
                'styles' => array(
                    'site/projects/edu-china/widget-rss-viewer/widget-rss-viewer.less',
                ),
            ),
        // end

        // finam site
            'finam-ru-blog-post-banner' => array(
                'styles' => array(
                    'site/projects/finam/finam-ru-blog-post-banner/finam-ru-blog-post-banner.styl',
                ),
                'scripts' => array(
                    'site/projects/finam/finam-ru-blog-post-banner/finam-ru-blog-post-banner.js',
                ),
            ),
            'finam-ru-blog-post-banner-v2' => array(
                'styles' => array(
                    'site/projects/finam/finam-ru-blog-post-banner/finam-ru-blog-post-banner-v2.styl',
                ),
                'scripts' => array(
                    'site/projects/finam/finam-ru-blog-post-banner/finam-ru-blog-post-banner-v2.js',
                ),
            ),
            'finam-ru-blog-post-banner-v3' => array(
                'styles' => array(
                    'site/projects/finam/finam-ru-blog-post-banner/finam-ru-blog-post-banner-v3.styl',
                ),
                'scripts' => array(
                    'site/projects/finam/finam-ru-blog-post-banner/finam-ru-blog-post-banner-v3.js',
                ),
            ),
            'finam-ru-blog-post-banner-v4' => array(
                'styles' => array(
                    'site/projects/finam/finam-ru-blog-post-banner/finam-ru-blog-post-banner-v4.styl',
                ),
                'scripts' => array(
                    'site/projects/finam/finam-ru-blog-post-banner/finam-ru-blog-post-banner-v4.js',
                ),
            ),
            'finam-ru-blog-post-banner-v5' => array(
                'styles' => array(
                    'site/projects/finam/finam-ru-blog-post-banner/finam-ru-blog-post-banner-v4.styl',
                ),
                'scripts' => array(
                    'site/projects/finam/finam-ru-blog-post-banner/finam-ru-blog-post-banner-v4.js',
                ),
            ),
            'finam-ru-sidebar-banner' => array(
                'styles' => array(
                    'site/projects/finam/finam-ru-sidebar-banner/finam-ru-sidebar-banner.styl',
                ),
                'scripts' => array(
                    'site/projects/finam/finam-ru-sidebar-banner/finam-ru-sidebar-banner.js',
                ),
            ),
            'finam-ru-sidebar-banner-v2' => array(
                'styles' => array(
                    'site/projects/finam/finam-ru-sidebar-banner/finam-ru-sidebar-banner-v2.styl',
                ),
                'scripts' => array(
                    'site/projects/finam/finam-ru-sidebar-banner/finam-ru-sidebar-banner-v2.js',
                ),
            ),
            'finam-social-buttons' => array(
                'scripts' => array(
                    'site/projects/finam/finam-social-buttons.js'
                )
            ),
        // end

        // NY group
        'landing-ny' => array(
            'styles' => array(
                'site/projects/whotrades/landing-ny/landing-ny.less',
            ),
        ),

        // custom project.
        'custom-project' => array(
            'styles' => array(
                'site/projects/custom-project/custom-project.less',
            ),
        ),

        // platforma constructor project, admin
        // @page /edit
            'javascript_includes_groupsAdmin' => array(
                'scripts' => array(
                    'vendor/jquery/dist/jquery.js',
                    'js/jqueryNoConflict.js',
                    'js/lib/jquery.browser.js',
                    'js/lib/jquery-ajax-prefilter.js',
                    'js/lib/jquery.serializeObject.js',
                    'js/lib/jsapi.js',
                    'vendor-libs/prototype/prototype.js',
                    'js/lib/cookie.js',
                    'vendor/underscore/underscore.js',
                    'js/dictionary.js',
                    'vendor-libs/scriptaculous/builder.js',
                    'vendor-libs/scriptaculous/controls.js',
                    'vendor-libs/scriptaculous/sound.js',
                    'js/lib/smooth.js',
                    'js/lib/extend-generic.js',
                    'js/lib/extend.js',
                    'vendor-libs/scriptaculous/dragdrop.js',
                    'js/lib/dragdrop-extend.js',
                    'vendor-libs/scriptaculous/effects.js',
                    'js/lib/colorpicker.js',
                    'js/lib/accordion.js',
                    'js/lib/urlProcessor.js',
                    'vendor-libs/jquery.meio.mask/jquery.meio.mask.js',
                    'js/lib/time-input-import.js',
                    'js/main.js',
                    'js/smileys-handlers.js',
                    'js/dom-ready.js',
                    'js/confirm-submit.js',
                    'js/uppod_player.js',
                    'js/helper.js',
                    'js/onload.js',
                    'js/navigation.js',
                    'mdr/site/checkbox-disable-input.js',
                    'vendor-libs/jquery-ui/modules/jquery.ui.core.js',
                    'vendor-libs/jquery-ui/modules/jquery.ui.datepicker.js',
                    'site/blocks/date-picker/date-picker-import.js',
                    'admin/main.js',
                    'admin/module.js',
                    'admin/blocks/global-page-notifications/global-page-notifications.js',

                    // new
                    'lib/utils.js',
                ),
            ),
            'admin_main' => array(
                'styles' => array(
                    'admin/admin-main.less', 'vendor-libs/jquery-ui/themes/custom/datepicker.css',
                ),
            ),
            'mirtesen__blue-form-panel' => array(
                'styles' => array(
                    'admin/blocks/mirtesen__blue-form-panel/blue-form-panel.less',
                ),
            ),
            'admin_ie6' => array(
                'styles' => array(
                    'admin/ie6-fixes.css',
                ),
            ),
            'admin_ie7' => array(
                'styles' => array(
                    'admin/ie7-fixes.css',
                ),
            ),
        // end

        // mdr project
            'mdr-main' => array(
                'styles' => array(
                    'mdr/mdr-main.less',
                ),
                'scripts' => array(
                    'vendor/jquery/dist/jquery.js',
                    'js/jqueryNoConflict.js',
                    'js/lib/jquery.browser.js',
                    'js/lib/jquery-ajax-prefilter.js',
                    'js/lib/jquery.serializeObject.js',

                    'vendor-libs/prototype/prototype.js',
                    'vendor-libs/scriptaculous/builder.js',
                    'vendor-libs/scriptaculous/effects.js',
                    'js/lib/cookie.js',
                    'js/lib/urlProcessor.js',
                    'js/autofocus.js',
                    'js/select-text.js',
                    'mdr/extend.js',
                    'mdr/common.js',
                    'common-blocks/achievements-table/achievements-table.js',
                    'mdr/blocks/popup-notifications/popup-notifications.js',
                    'mdr/blocks/arctic-modal/arctic-modal.js',
                    'js/relative-time.js',
                    'js/dom-ready.js',
                    'mdr/site/domready-load-modules.js',
                ),
            ),
            'mdr-page-dictionary' => array(
                'styles' => array(
                    'mdr/blocks/page-dictionary/page-dictionary.less',
                ),
                'scripts' => array(
                    'mdr/blocks/page-dictionary/page-dictionary.js',
                ),
            ),
            'mdr-page-dictionary-item' => array(
                'styles' => array(
                    'mdr/blocks/page-dictionary-item/page-dictionary-item.less',
                ),
            ),
            'mdr-page-domains-constraint' => array(
                'styles' => array(
                    'mdr/blocks/page-domains-constraint/page-domains-constraint.css',
                ),
                'scripts' => array(
                    'mdr/blocks/page-domains-constraint/page-domains-constraint.js',
                ),
            ),
            'mdr-comments-list' => array(
                'styles' => array(
                    'mdr/blocks/comments-list/comments-list.less',
                ),
            ),
            'mdr-dicwords-list' => array(
                'styles' => array(
                    'mdr/blocks/dicwords-list/dicwords-list.less',
                ),
                'scripts' => array(
                    'mdr/blocks/dicwords-list/dicwords-list.js',
                ),
            ),
            'mdr-delete-cache' => array(
                'scripts' => array(
                    'mdr/blocks/delete-cache/delete-cache.js',
                ),
            ),
        // end
    // mars: end


    // mars: стили/скрипты, которые подключаются в модулях для контекстов
        'blogs-sites' => array(
            'scripts' => array(
                'site/modules/blogs/blogs-sites.js',
            ),
        ),
        'client-assistance-registration-popup' => array(
            'scripts' => array(
                'site/modules/client-assistance/registration-popup.js',
            ),
        ),
    // end

    // widgets:
        // BlogPosts
            'blogs-list-short-with-authors' => array(
                'styles' => array(
                    'site/modules/blogs/blogs-list-short-with-authors.less',
                ),
            ),
            'blog-posts-list-three-columns' => array(
                'styles' => array(
                    'site/modules/blogs/blog-posts-list-three-columns.less',
                ),
            ),
            'blog-posts-list-masonry' => array(
                'styles' => array(
                    'site/modules/blogs/blog-posts-list-masonry.less',
                ),
                'scripts' => array(
                    'site/modules/blogs/blog-posts-masonry.js',
                ),
            ),
            'profile-blog-posts' => array(
                'styles' => array(
                    'site/widgets/blog-post-in-profile/blog-post-in-profile.less',
                ),
            ),
            'blog-author-list' => array(
                'styles' => array(
                    'site/widgets/popular-bloggers/popular-bloggers.less',
                ),
            ),
        // end

        // Groups
        'groups-inline-list' => array(
            'styles' => array(
                'site/widgets/groups-inline-list/groups-inline-list.less',
            ),
        ),

        // Instruments
            'instruments-tiles' => array(
                'styles' => array(
                    // Countdown for blue tile.
                    'ui/countdown/countdown.styl',
                    'ui/countdown/design/graphite.styl',

                    'site/modules/blogs/blog-posts-list-instruments.styl',
                    'site/projects/whotrades/modules/instruments/instruments-ticker.styl',
                    'site/projects/whotrades/modules/instruments/instruments-forecast.styl',
                    'site/projects/whotrades/modules/instruments/instruments-calendar.styl',
                    'site/projects/whotrades/modules/instruments/instruments-event.styl',
                ),
                'scripts' => array(
                    'site/projects/whotrades/modules/instruments/instruments-forecast.js',
                    'site/projects/whotrades/modules/instruments/instruments-calendar.js',
                    'site/projects/whotrades/modules/instruments/instruments-event.js',
                    'site/projects/whotrades/modules/instruments/instruments-tiles.js',
                ),
            ),
        // end

        'widget-comments' => array(
            'styles' => array(
                'site/widgets/comments/comments.less',
            ),
        ),

        'widget-profile-settings' => array(
            'styles' => array(
                'site/blocks/widget-profile-settings/widget-profile-settings.less',
            ),
        ),

        'widget-best-strategies' => array(
            'styles' => array(
                'site/widgets/best-strategies/best-strategies.less',
            ),
        ),

        'widget-search-people' => array(
            'styles' => array(
                'site/widgets/search/search.less',
            ),
            'scripts' => array(
                'site/widgets/search/search.js',
            ),
        ),

        'widget-search-strategies' => array(
            'styles' => array(
                'site/widgets/search-signal-repeater/search-signal-repeater.less',
            )
        ),

        'widget-client-assistance-message-guest' => array(
            'styles' => array(
                'site/blocks/messenger/messenger.less',
                'site/blocks/messenger/chat.less',
                'site/widgets/client-assistance-message-guest/client-assistance-message-guest.less',
            ),
        ),

        'widget-trade-cabinet-comet-objects' => array(
            'scripts' => array(
                'site/widgets/comon-cabinet/comet-objects.js',
            ),
        ),
    // end widgets


    // Very old styles.
    'splash' => array(
        'styles' => array(
            'css/splash.css'
        ),
    ),
    'regNet' => array( // RegistrationNetwork.tpl
        'styles' => array(
            'css/regNet.css'
        ),
    ),
    'picasa' => array( // PhotosUploadPicasa.tpl
        'styles' => array(
            'css/picasa.css'
        ),
    ),

    // Strategies-v2.
    'strategies-v2-items' => array(
        'styles' => array(
            'site/projects/whotrades/strategies-v2/strategies-v2.styl',
            'site/projects/whotrades/strategies-v2/strategies-v2-items.styl',
        ),
    ),
    // End Strategies-v2.


    'cabinet-proxy-page' => array(
        'styles' => array(
            'site/widgets/cabinet-proxy-page/cabinet-proxy-page.less',
        ),
        'scripts' => array(),
    ),
    'jquery-slimscroll' => array(
        'scripts' => array(
            'libs/utils/jquery.slimscroll.min.js',
        ),
    ),
    'instruments-dropdown-menu' => array(
        'styles' => array(
            'site/projects/whotrades/instruments-dropdown-menu/instruments-dropdown-menu.styl',
        )
    ),
    'popup-window' => array(
        'styles' => array(
            'site/blocks/popup-window/popup-window.less',
        ),
    ),

    'messages-popup' => array(
        'scripts' => array(
            'site/projects/whotrades/modules/messages-popup/messages-popup.js',
        ),
        'styles' => array(
            'site/projects/whotrades/modules/messages-popup/messages-popup.styl',
        ),
    ),
    'guest-messages-popup' => array(
        'scripts' => array(
            'site/projects/whotrades/modules/messages-popup/guest-messages-popup.js',
        ),
    ),

    // The widgets styles.
    // @marsel remove to interface!
    'cabinet-market-data' => array(
        'styles' => array(
            'site/blocks/cabinet-market-data/cabinet-market-data.less',
        ),
    ),
    'md-container' => array(
        'styles' => array(
            'site/blocks/md-container/md-container.less',
        ),
    ),
    'cabinet-widget' => array( // @marsel лишние стили, заменитть всё на block simple form page.
        'styles' => array(
            'site/blocks/cabinet-widget/cabinet-widget.less',
        ),
    ),
    'content-item-likeblock' => array(
        'styles' => array(
            'site/blocks/content-item-likeblock/content-item-likeblock.less',
        ),
    ),
    'friends-list' => array(
        'styles' => array(
            'site/blocks/friends-list/friends-list.less',
        ),
    ),
    'wizard-container' => array(
        'styles' => array(
            'site/blocks/wizard-container/wizard-container.less',
        ),
    ),

    'messages' => array(
        'styles' => array(
            'site/old/messages.less',
        ),
    ),

    // The includes tpl styles.
    // @marsel remove to interface!
    'cabinet-report' => array(
        'styles' => array(
            'site/blocks/cabinet-report/cabinet-report.less',
        ),
    ),
    'cabinet-reports-filter' => array(
        'styles' => array(
            'site/projects/whotrades/cabinet-reports-filter/cabinet-reports-filter.less',
        ),
    ),
    'friends-import-list' => array(
        'styles' => array(
            'site/blocks/friends-import-list/friends-import-list.less',
        ),
    ),
    'facebook-friends-list' => array(
        'styles' => array(
            'site/blocks/facebook-friends-list/facebook-friends-list.less',
        ),
    ),
    'cabinet-side-menu-popup' => array(
        'styles' => array(
            'site/blocks/cabinet-side-menu-popup/cabinet-side-menu-popup.less',
        ),
    ),
    'video-item' => array(
        'styles' => array(
            'site/blocks/video-item/video-item.less',
        ),
        'scripts' => array(
            'site/blocks/video-item/video-item.js',
        ),
    ),
    'add-media-splash-block' => array(
        'styles' => array(
            'site/blocks/add-media-splash-block/add-media-splash-block.less',
        ),
    ),
    'markets-accounts-manager-block' => array(
        'styles' => array(
            'site/widgets/comon-accounts-manager/comon-accounts-manager.less',
        ),
    ),
    'profile-accounts-tabs' => array(
        'styles' => array(
            'site/projects/whotrades/profile-accounts-tabs/profile-accounts-tabs.less',
        ),
    ),
    'users-table' => array(
        'styles' => array(
            'ui-elements/users-table/users-table.less',
        ),
    ),
    'signal-repeater-subscriptions' => array(
        'styles' => array(
            'site/blocks/signal-repeater-subscriptions/signal-repeater-subscriptions.less',
        ),
    ),
    'genereal-setting' => array(
        'styles' => array(
            'site/blocks/genereal-setting/genereal-setting.less',
        ),
    ),
    'media-edit' => array(
        'styles' => array(
            'site/blocks/media-edit/media-edit.less',
        ),
    ),
    'followers' => array(
        'styles' => array(
            'site/blocks/followers/followers.less',
        ),
    ),
    'messenger-popup' => array(
        'styles' => array(
            'site/projects/whotrades/messenger-popup/messenger-popup.less',
        ),
        'scripts' => array(
            'site/projects/whotrades/messenger-popup/messenger-popup.js',
        ),
    ),

    // static pages (staticTplDev as page)
        'page-trading-applications' => array(
            'styles' => array(
                'site/projects/whotrades/page-trading-applications/page-trading-applications.less',
            ),
        ),
        'page-trading-application' => array(
            'styles' => array(
                'site/projects/whotrades/page-trading-application/page-trading-application.less',
            ),
        ),
        'page-our-solutions' => array(
            'styles' => array(
                'site/projects/whotrades/page-our-solutions/page-our-solutions.less',
            ),
            'scripts' => array(
                'site/projects/whotrades/page-our-solutions/page-our-solutions__intro-nav.js',
                'site/projects/whotrades/page-our-solutions/page-our-solutions__market-switch.js',
            ),
        ),
        'page-fees-commission-wt-inc' => array(
            'styles' => array(
                'site/projects/whotrades/page-fees-commission-wt-inc/page-fees-commission-wt-inc.less',
            ),
            'scripts' => array(
                'site/projects/whotrades/page-fees-commission-wt-inc/page-fees-commission-wt-inc.js',
            ),
        ),
        'page-award-world-finance' => array(
            'styles' => array(
                'site/projects/whotrades/page-award-world-finance/page-award-world-finance.less',
            ),
        ),
        'page-moderator-rules' => array(
            'styles' => array(
                'site/projects/whotrades/layouts/moderator-rules.styl',
            ),
        ),
        'page-about' => array(
            'styles' => array(
                'site/projects/whotrades/page-about/page-about.less',
            ),
        ),
        'page-top-up-account' => array(
            'styles' => array(
                'site/projects/whotrades/page-top-up-account/page-top-up-account.less',
            ),
        ),
        'page-licenses' => array(
            'styles' => array(
                'site/projects/whotrades/page-licenses/page-licenses.less',
            ),
        ),
        'page-funds-withdrawal' => array(
            'styles' => array(
                'site/projects/whotrades/page-funds-withdrawal/page-funds-withdrawal.less',
            ),
        ),
        'page-faq' => array(
            'styles' => array(
                'site/projects/whotrades/page-faq/page-faq.less',
            ),
        ),
        'page-faq-video' => array(
            'styles' => array(
                'site/projects/whotrades/page-faq-video/page-faq-video.less',
            ),
            'scripts' => array(
                'site/projects/whotrades/page-faq-video/page-faq-video.js',
            ),
        ),
        'page-update-browser' => array(
            'styles' => array(
                'site/blocks/update-browser-page/update-browser-page.less',
            ),
        ),

        // mars: раздел /services
            'services-inc-forex' => array(
                'styles' => array(
                    'site/projects/whotrades/modules/services-inc/services-inc-forex.styl',
                )
            ),
        // end

        // landing pages
            'landing-social-people' => array(
                'styles' => array(
                    'site/projects/whotrades/modules/landings/landing-social/landing-social-people.styl',
                ),
            ),
        // end
    // end static pages


    // static blocks (staticTplDev widget as block)
        'real-account-open-steps' => array(
            'styles' => array(
                'site/projects/whotrades/real-account-open-steps/real-account-open-steps.less',
            ),
        ),
        'widget-award-world-finance' => array(
            'styles' => array(
                'site/widgets/award-world-finance/award-world-finance.less',
            ),
        ),
        'widget-moderator-rules' => array(
            'styles' => array(
                'site/projects/whotrades/layouts/moderator-rules.styl',
            ),
        ),
    // end


    // The lazy-load styles.

    // custom popups
        'fast-registration-popup' => array(
            'styles' => array(
                'site/blocks/fast-registration-popup/fast-registration-popup.less',
            ),
            'scripts' => array(
                'site/blocks/fast-registration-popup/fast-registration-popup.js',
            ),
        ),
        'popup-for-comon-users' => array(
            'styles' => array(
                'site/projects/whotrades/popup-for-comon-users/popup-for-comon-users.less',
            ),
            'scripts' => array(
                'site/projects/whotrades/popup-for-comon-users/popup-for-comon-users.js',
            ),
        ),
        'no-account-popup' => array(
            'scripts' => array(
                'site/projects/whotrades/no-account-popup/no-account-popup.js',
            ),
        ),
    // end

    'start-page-globe-people' => array(
        'styles' => array(
            'site/projects/whotrades/start-page/globe-people.less',
        ),
    ),


    'css_includes' => array( // @marsel не подключаются к site.
        'styles' => array(
            'css/common.less', 'css/layout.less',
            'css/rightbar.less',
            'css/forms.less',
            'css/special_site_extras.less',
            'css/notifications.less',
            'css/blogs.less',
        ),
    ),
    'css_includes_second' => array( // @warl Hack for release-25, to @mars clean up this!
        'styles' => array(
            'site/old/messages.less',
        ),
    ),

    /*
     * Services v2.
     */
    'services-v2-about' => array(
        'styles' => array(
            'vendor-libs/jquery.carousel/owl.carousel.css',
            'vendor-libs/jquery.carousel/owl.theme.css'
        ),
        'scripts' => array(
            'vendor-libs/jquery.carousel/owl.carousel.js',
            '/site/projects/whotrades/modules/services-v2/services-index.js',
        ),
    ),

    'services-v2-forex' => array(
        'styles' => array(
            '/site/projects/whotrades/modules/services-v2/services-forex.styl',
        ),
        'scripts' => array(
            '/site/projects/whotrades/modules/services-v2/services-forex.js',
        )
    ),

    'services-v2-eo' => array(
        'styles' => array(
            '/site/projects/whotrades/modules/services-v2/services-eo.styl',
        )
    ),

    'date-format' => array(
        'scripts' => array(
            'js/lib/date_format.js',
        ),
    ),
    'logger' => array(
        'scripts' => array(
            'js/logger.js',
        ),
    ),
    'start' => array(
        'scripts' => array(
            'js/lib/start.js',
        ),
    ),
    'geo-select' => array(
        'scripts' => array(
            'js/geoSelects.js',
        ),
    ),
    'inputs-manager' => array(
        'scripts' => array(
            'js/inputsManager.js',
        ),
    ),
    'ie-swfobject-tagcloud' => array(
        'scripts' => array(
            'js/swfobject_tagcloud.js',
        ),
    ),
    'domain-checker' => array(
        'scripts' => array(
            'js/domainChecker.js',
        ),
    ),


    'photos' => array(
        'scripts' => array(
            'js/photos.js',
        ),
    ),

    'trade' => array(
        'scripts' => array(
            'site/blocks/trade/trade.js',
        ),
    ),

    'media' => array(
        'scripts' => array(
            'site/blocks/media/media.js',
        ),
    ),

    'audio-handlers' => array(
        'scripts' => array(
            'site/blocks/audio-handlers/audio-handlers.js',
        ),
    ),
    'videos-handlers' => array(
        'scripts' => array(
            'site/blocks/videos-handlers/videos-handlers.js',
        ),
    ),
    'update-strategy-data' => array(
        'scripts' => array(
            'site/blocks/update-strategy-data/update-strategy-data.js',
        ),
    ),


    'comon-instrument-graph' => array(
        'scripts' => array(
            'site/blocks/instrument-graph/instrument-graph.js',
        ),
    ),
    'cabinet-toggle-popup' => array(
        'scripts' => array(
            'site/blocks/cabinet-toggle-popup/cabinet-toggle-popup.js',
        ),
    ),

    'eo-payments' => array(
        'scripts' => array(
            'site/projects/exotic-options/payments/payments-v2.js',
        ),
    ),
    'creating-markets' => array(
        'scripts' => array(
            'site/projects/whotrades/creating-markets/creating-markets.js',
        ),
    ),



    'charts-instruments-autocomplete' => array(
        'scripts' => array(
            'site/modules/charts/charts-instruments-autocomplete.js',
        ),
    ),





    'javascript_includes_open_social' => array(
        'scripts' => array(
            'js/shindig/util.js',
            'js/shindig/json.js',
            'js/shindig/rpc/fe.transport.js',
            'js/shindig/rpc/ifpc.transport.js',
            'js/shindig/rpc/nix.transport.js',
            'js/shindig/rpc/rmr.transport.js',
            'js/shindig/rpc/wpm.transport.js',
            'js/shindig/rpc/rpc.js',
            'js/shindig/container.js',
        ),
    ),

    'javascript_includes_map' => array(
        'scripts' => array(
            'js/lib/rsh.js',
            'js/mapControls.js',
            'js/markers.js',
            'js/markerManager.js',
            'js/map.js',
            'js/mapPlaces.js',
            'js/breadcrumbs.js',
            'js/markerSpiral.js',
            'js/anchor.js',
            'js/onload.js',
        ),
    ),

    // test modules
    'test-module' => array(
        'scripts' => array(
            'site/projects/whotrades/test-module/test-module.js',
        ),
    ),
    'test-module-2' => array(
        'scripts' => array(
            'site/projects/whotrades/test-module/test-module-2.js',
        ),
    ),

    /*
     * Collection styles to Landings.
     * Use the rules for the ID - landing-#name#.
     */
    'landing-learning-points' => array(
        'styles' => array(
            '/site/projects/whotrades/modules/landings/landing-learning-points/landing-learning-points.styl',
        )
    ),
    'landing-jaguar-2014' => array(
        'styles' => array(
            '/site/projects/whotrades/modules/landings/jaguar-2014/landing-jaguar-2014.styl',
        )
    ),
    'landing-strategies' => array(
        'styles' => array(
            '/site/projects/whotrades/modules/landings/strategies/landing-strategies.styl',
        )
    ),
    'landing-buffett' => array(
        'styles' => array(
            'app/whotrades/landings/buffett/landing-buffett.styl',
        )
    ),
    'landing-welcome' => array(
        'styles' => array(
            'app/whotrades/landings/welcome/landing-welcome.styl',
        )
    ),
);

$this->cookie_js_debug_name = 'js_debug'; // ad: cookie name to override config.javascript_merged option to use not obfuscated js files #WHO-3339

// ----------------------------------
// ----  Widget static scripts settings --------
//
// lk: key == widget class name without prefix "Widget_"
$this->static_widgets = array(
    // mars: сортировка в алфавитном порядке
    // mars: todo move blocks -> widgets

    'TradeWidget' => array(
        '{}' => array(
            'less' => array('app/whotrades/components/trade/trade-app.styl'),
            'js' => array(
                'app/whotrades/components/trade/trade-app.js',
            ),
        ),
    ),
    'ProfileTrade' => array(
            '{}' => array(
                    'less' => array('app/whotrades/components/trade/trade-app.styl'),
                    'js' => array(
                            'app/whotrades/components/trade/trade-app.js',
                    ),
            ),
    ),
    'Activities' => array(
        '{}' => array(
            'less' => array('site/widgets/activities/activities.less'),
            'js' => array(
                'site/blocks/modal-share-external/modal-share-external.js', // @user.activity Activities.tpl
                'site/blocks/facebook-share-link/facebook-share-link.js', // @prototype inside functions calls

                'site/widgets/activities/activities-alignment.js',
                'site/widgets/activities/popup-activity-people-list.js',
                'site/widgets/activities/activities.js',
            ),
        )
    ),
    'AccountsItemClients' => array(
        '{"displayMode": "forex"}' => array(
            'less' => array(
                'site/projects/whotrades/modules/landings/landing-demo-account/landing-demo-account-metatrader.styl',
            ),
        ),
        '{"displayMode": "mma"}' => array(
            'less' => array(
                'site/projects/whotrades/modules/landings/landing-demo-account/landing-demo-account-mma.styl',
            ),
        ),
        '{"displayMode": "etna"}' => array(
            'less' => array(
                'site/projects/whotrades/modules/landings/landing-demo-account/landing-demo-account-etna.styl',
            ),
        ),
        '{"displayMode": "other"}' => array(
            'less' => array(
                'site/projects/whotrades/modules/landings/landing-demo-account/landing-demo-account-transaq.styl',
            ),
        )
    ),
    'AudioItemEdit' => array(
        '{}' => array(
            'less' => array(
                'site/blocks/media/media.less',
                'site/widgets/audio-item-edit/audio-item-edit.less',
            ),
        ),
    ),
    'BlogPostsItem' => array(
        '{}' => array(
            'less' => array(
                'app/whotrades/components/forecast/forecast.styl',
                'app/whotrades/components/toolbar/toolbar.styl',
                'app/whotrades/components/other-posts/other-posts.styl',
            ),
            'js' => array(
                'site/blocks/trading-view-chart/trading-view-chart.js', //sl: замена картинок на графики (старые)
                'site/widgets/blog-post-item/blog-post-item.js',
                'js/uppod_player.js',                                   // function.embed_audio.php and function.embed_video.php
                'app/whotrades/components/forecast/forecast-eventer.js',
                'app/whotrades/components/toolbar/toolbar-eventer.js',
            )
        ),
    ),

    'BlogPostsItemEdit' => array(
        '{}' => array(
            'less' => array(
                'site/widgets/edit-blog-post/edit-blog-post.less',
            ),
            'js' => array(
                'site/widgets/edit-blog-post/edit-blog-post.js',
            ),
        )
    ),
    'CabinetAccounts' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/custom-checkbox-block/custom-checkbox-block.less',
                'site/projects/whotrades/start-trade-button/start-trade-button.less',
                'site/widgets/cabinet-accounts/cabinet-accounts.less'
            ),
            'js' => array('site/widgets/cabinet-accounts/cabinet-accounts.js')
        ),
    ),
    'CabinetAgentsReport' => array(
        '{}' => array(
            'less' => array('site/widgets/cabinet-agents-report/cabinet-agents-report.less'),
        ),
    ),
    'CabinetChangeAccountPasswordSms' => array(
        '{}' => array(
            'less' => array('site/blocks/phone-component/phone-component.less'),
        ),
    ),
    'CabinetFundsDeposit' => array(
        '{}' => array(
            'less' => array(
                'site/widgets/cabinet-funds-deposit/cabinet-funds-deposit.less',
                'site/blocks/payment-type-choose/payment-type-choose.less',
            ),
        ),
    ),
    'CabinetMarketDataAndTradingPlatform' => array(
        '{}' => array(
            'js' => array('site/widgets/cabinet-market-data-and-trading-platform/cabinet-market-data-and-trading-platform.js')
        ),
    ),

    'CabinetMarketsHelp' => array(
        '{}' => array(
            'less' => array('app/whotrades/components/trade/trade-markets.styl'),
        ),
    ),

    'CabinetProfileEdit' => array(
        '{}' => array(
            'less' => array('site/blocks/phone-component/phone-component.less'),
        ),
    ),
    'CabinetProxyPage' => array(
        '{}' => array(
            'less' => array(
                'site/widgets/cabinet-proxy-page/header-dropdown.less',
                'site/widgets/cabinet-proxy-page/cabinet-proxy-page.less',
            ),
            'js' => array(
                'site/widgets/cabinet-proxy-page/header-dropdown.js',
                'site/widgets/cabinet-proxy-page/cabinet-proxy-page.js',
            ),
        ),
    ),
    'CabinetTechnicalAnalysis' => array(
        '{}' => array(
            'less' => array('site/widgets/cabinet-proxy-page/cabinet-proxy-page.less'),
        ),
    ),
    'CabinetTradeAccounts' => array(
        '{}' => array(
            'less' => array('site/widgets/cabinet-trade-accounts/cabinet-trade-accounts.less'),
            'js' => array('site/widgets/cabinet-trade-accounts/cabinet-trade-accounts.js'),
        )
    ),
    'CabinetTradeTransactions' => array(
        '{}' => array(
            'less' => array('site/blocks/phone-component/phone-component.less'),
            'js' => array('site/widgets/cabinet-trade-transactions/cabinet-trade-transactions.js'),
        ),
    ),
    'CabinetTradeTransactionsEcommerce' => array(
        '{}' => array(
            'less' => array('site/blocks/phone-component/phone-component.less'),
        ),
    ),
    'CabinetTradingPassword' => array(
        '{}' => array(
            'js' => array('site/widgets/cabinet-trading-password/cabinet-trading-password.js'),
        ),
    ),
    'ChartPosts' => array(
        '{}' => array(
            'js' => array(
                'site/widgets/chart-posts/chart-posts.js',
            ),
        )
    ),
    'ChartPostsItem' => array(
        '{}' => array(
            'less' => array(
                'site/modules/charts/chart-forecast-voting-block/chart-forecast-voting-block.less',
                'site/projects/whotrades/modules/instruments/instruments-copyright.styl'
            ),
            'js' => array(
                'site/widgets/chart-post-item/chart-post-item.js',
            ),
        )
    ),
    'ChartPostsItemEdit' => array(
        '{}' => array(
            'less' => array(
                'site/modules/charts/chart-post-edit.less'
            ),
            'js' => array(
                'site/modules/charts/chart-post-edit.js',
            ),
        )
    ),
    'Chat' => array(
        '{}' => array (
            'less' => array(
                'site/blocks/messenger/chat.less',
                'site/widgets/chat/chat.less',
            ),
            'js' => array(
//                'site/widgets/chat/chat.js',
                'site/widgets/chat/scrollTo.js',
                'site/widgets/chat/chats2.js',
            )
        )
    ),
    'ClientAssistanceAgentMessageTemplates' => array(
        '{}' => array (
            'less' => array('site/widgets/client-assistance-agent-message-templates/client-assistance-agent-message-templates.less'),
        )
    ),
    'ClientAssistanceClients' => array(
        '{}' => array (
            'less' => array(
                'site/projects/whotrades/modules/client-assistance/client-assistance-real-user-icon.styl',
                'ui-elements/users-table/users-table.less',
            ),
        )
    ),
    'ClientAssistanceInvite' => array(
        '{}' => array (
            'less' => array(
                'app/whotrades/components/assistance/assistance-invite.styl',
            ),
        )
    ),
    'ClientAssistanceClientSearch' => array(
        '{}' => array (
            'less' => array('site/widgets/client-assistance-client-search/client-assistance-client-search.less'),
            'js' => array('site/widgets/client-assistance-client-search/client-assistance-client-search.js'),
        )
    ),
    'ClientAssistanceMessageGuest' => array(
        '{}' => array (
            'js' => array(
                'js/smileys-handlers.js',
                'site/widgets/messages-person/messages-person.js',
            ),
        )
    ),
    "ClientAssistanceContests" => array(
        '{}' => array(
            'less' => array(
                '/site/projects/whotrades/modules/landings/landing-money-talks/landing-money-talks.styl',
            )
        )
    ),
    'Comments' => array(
        '{}' => array (
            'js' => array(
                'site/widgets/comments/comments.js',
            ),
        )
    ),
    'ComonAccounts' => array(
        '{}' => array(
            'less' => array('site/widgets/comon-accounts/comon-accounts.less'),
        ),
    ),
    'ComonAccountsManager' => array(
        '{}' => array(
            'less' => array(
                'site/widgets/comon-accounts-manager/comon-accounts-manager.less',
                'site/blocks/widget-profile-settings/widget-profile-settings.less',
            ),
            'js' => array('site/widgets/comon-accounts-manager/comon-accounts-manager.js'),
        ),
    ),
    'ComonBankingDetails' => array(
        '{}' => array(
            'less' => array(
                'site/widgets/comon-banking-details/banking-details.less',
                'site/blocks/phone-component/phone-component.less',
            ),
            'js' => array(
                'site/widgets/comon-banking-details/banking-details.js',
            ),
        ),
    ),
    'ComonCabinet' => array(
        '{}' => array(
            'less' => array(
                'site/widgets/comon-cabinet/comon-cabinet.less',
                'site/widgets/comon-cabinet/inputs-counter.less',
                'site/old/button/wt-old-button.less'
            ),
            'js' => array(
                'lib/deprecated/html-tag.js',
                'site/widgets/comon-cabinet/comon-cabinet.js',
                'site/widgets/comon-cabinet/inputs-counter.js',
                'site/widgets/comon-cabinet/comon-cabinet-training.js',
                'site/widgets/comon-cabinet/mt-popup.js',
            ),
        ),
    ),
    'ComonCabinetFake' => array(
           '{}' => array(
               'less' => array('site/widgets/cabinet-accounts/cabinet-accounts.less')
           ),
       ),
    'ComonConnections' => array(
        '{}' => array(
            'less' => array('site/blocks/new-connections-profile/new-connections-profile.less'),
        )
    ),
    'ComonFakeTrading' => array(
        '{}' => array(
            'less' => array('site/blocks/widget-landing-demo-trading/widget-landing-demo-trading.less'),
            'js' => array('site/blocks/widget-landing-demo-trading/widget-landing-demo-trading.js'),
        ),
    ),
    'ComonInviteSocial' => array(
        '{}' => array(
            'less' => array('site/blocks/invite-social-items/invite-social-items.less'),
            'js' => array('site/blocks/invite-social-items/invite-social-items.js'),
        ),
    ),
    'ComonMarketWatch' => array(
        '{}' => array(
            'less' => array('site/widgets/comon-market-watch/comon-market-watch.less'),
            'js' => array('site/widgets/comon-market-watch/comon-market-watch.js'),
        )
    ),
    'ComonPaymentUniversal' => array(
        '{}' => array(
            'less' => array(
                'site/blocks/phone-component/phone-component.less',
                'site/blocks/choose-payment-method-block/choose-payment-method-block-v2.less',
                'site/blocks/payment-type-choose/payment-type-choose.less',
                'site/projects/exotic-options/spinner/spinner.less'
            ),
            'js' => array(
                'site/widgets/comon-payment-universal/comon-payment-universal.js',
            ),
        ),
    ),
    'ComonProfitability' => array(
        '{}' => array(
            'less' => array('site/blocks/profile-perfomance/profile-perfomance.less'),
        )
    ),
    'ComonTransactions' => array(
        '{}' => array(
            'less' => array('site/widgets/profile-transactions/profile-transactions.less'),
            'js' => array('site/widgets/profile-transactions/profile-transactions.js'),
         ),
    ),
    'ContestPrizeMoneyTicker' => array(
        '{}' => array(
            'less' => array('site/projects/whotrades/modules/contests/contest-money-ticker.styl'),
            'js' => array('site/projects/whotrades/modules/contests/contest-money-ticker.js'),
        ),
    ),
    'FormEvent' => array(
        '{}' => array(
            'less' => array('site/widgets/form-event/form-event.less'),
            'js' => array('site/widgets/form-event/form-event.js'),
        ),
    ),
    'Groups' => array(
        '{}' => array(
            'less' => array('site/modules/blogs/blogs-users-podium/blogs-users-podium.less'),
        )
    ),
    'GroupsItemInviteNevada' => array(
        '{}' => array(
            'less' => array(
                'site/widgets/invite-friends/invite-friends.less',
                'site/blocks/invite-page/invite-page.less',
            ),
            'js' => array(
                'site/widgets/invite-friends/invite-friends.js',
                'site/widgets/invite-friends/invite-friends-widget.js'
            ),
        ),
    ),
    'GroupsItemInvitePeople' => array(
        '{}' => array(
            'js' => array('site/widgets/groups-item-invite-people/groups-item-invite-people.js'),
        )
    ),
    'GroupsItemPeople' => array(
        '{"displayMode": "podium"}' => array(
            'less' => array('site/projects/whotrades/contest-contesters-podium/contest-contesters-podium.less'),
        ),
        '{"displayMode": "badoo"}' => array(
            'less' => array('site/blocks/promo-people-on-main/promo-people-on-main.less'),
            // 'js' => array('site/blocks/promo-people-on-main/promo-people-on-main.js'),
        ),
        '{"displayMode": "short"}' => array(
             'less' => array('site/projects/whotrades/modules/landings/landing-social/landing-social-people.styl'),
            // 'js' => array('site/blocks/promo-people-on-main/promo-people-on-main.js'),
        ),
        '{"displayMode": "signalRepeater"}' => array(
            'less' => array('site/widgets/strategies-list/strategies-list.less'),
            'js' => array(),
        ),
    ),
    'GroupsItemPeopleItem' => array(
        '{}' => array(
            'less' => array('site/blocks/widget-groups-item-people-item/widget-groups-item-people-item.less'),
        ),
    ),
    'GroupsItemPeopleItemEditProfilePersonal' => array(
        '{}' => array(
            'js' => array('site/widgets/groups-item-people-item-edit-profile-personal/groups-item-people-item-edit-profile-personal.js'),
        )
    ),
    'GroupsItemPeopleItemFriends' => array(
        '{"mode": "widget"}' => array(
            'less' => array('site/widgets/richest-friends/richest-friends.less'),
        ),
        '{"mode": "content"}' => array(
            'less' => array('site/blocks/friends-table/friends-table.less'),
        ),
    ),
    'GroupsItemPeopleItemWizard' => array(
        '{}' => array(
            'less' => array(
                'site/blocks/phone-component/phone-component.less',
                'site/widgets/invite-friends/invite-friends.less'
            ),
            'js' => array('site/widgets/invite-friends/invite-friends.js'),
        ),
    ),
    'GroupsItemPeopleItemWizardPhoto' => array(
        '{}' => array(
            'js' => array('site/blocks/widget-registration-photo/widget-registration-photo.js'),
        )
    ),
    /*
    'GroupsItemPeopleItemVoteIndian' => array(
        '{}' => array(
            'less' => array('site/projects/whotrades/landing-indian/landing-indian.less'),
        ),
    ),
    */

   'GroupsItemTranslate' => array(
        '{}' => array(
            'less' => array(
                'site/blocks/translate-page/translate-page.less'
            ),
            'js' => array(
                'site/blocks/translate-page/translate-page.js'
            ),
        ),
    ),

    'FriendsImport' => array(
        '{}' => array(
            'less' => array(
                'site/blocks/invite-page/invite-page.less'
            ),
        )
    ),

    'InstrumenstItem' => array(
        '{}' => array(
            'less' => array('site/widgets/instruments-item/instruments-item.less'),
        )
    ),
    'InstrumentsProfileFeed' => array(
        '{}' => array(
            'less' => array('site/projects/whotrades/modules/instruments/instruments-copyright.styl'),
            'js' => array('site/widgets/instruments-profile-feed/instruments-profile-feed.js'),
        )
    ),

    'InstrumentsProfileTrading' => array(
        '{}' => array(
            'less' => array('site/projects/whotrades/modules/instrument/instrument-trading.styl'),
            'js' => array('site/widgets/instruments-profile-trading/instruments-profile-trading.js'),
        )
    ),

    'PersonTradeSignals' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/instrument/instrument-trading.styl',
                'site/projects/whotrades/person-trade-signals/person-trade-signals.styl',
            ),
        )
    ),

    'InstrumentsProfileCounters' => array(
        '{}' => array(
            //'less' => array('site/projects/whotrades/modules/instrument/instrument-about.styl'),
            'js' => array('site/projects/whotrades/modules/instrument/instrument-about.js'),
        )
    ),

    'InstrumentsSearch' => array(
        '{}' => array(
            'less' => array(
                'ui/autocomplete/autocomplete.styl',
                'ui/autocomplete/design/air.styl',
            ),
            'js' => array(
                'ui/autocomplete/autocomplete.js',
                'site/projects/whotrades/modules/instruments/instruments-search.js'
            )
        )
    ),

    'InstrumentsZoneFilter' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/instruments/instruments-filter.styl',
            ),
            'js' => array(
                'site/projects/whotrades/modules/instruments/instruments-filter.js',
            )
        )
    ),

    'InstrumentsTopInstruments' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/instruments/instruments-rate/instruments-rate.styl',
                'site/projects/whotrades/modules/instruments/instruments-rate/instruments-rate-chart.styl',
                'site/projects/whotrades/modules/instruments/instruments-rate/instruments-rate-volume.styl',
                'site/projects/whotrades/modules/instruments/instruments-rate/instruments-rate-trends.styl',
                'site/projects/whotrades/modules/instruments/instruments-rate/instruments-rate-quotes.styl',

                'vendor-libs/jquery.carousel/owl.carousel.css',
                'vendor-libs/jquery.carousel/owl.theme.css'
            ),
            'js' => array(
                'site/projects/whotrades/modules/instruments/instruments-rate/instruments-rate.js',
                'vendor-libs/jquery.carousel/owl.carousel.js',
            )
        )
    ),

    'InstrumentsEventsCalendar' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/instruments/instruments-events-calendar.styl',
                'site/projects/whotrades/modules/instruments/instruments-filter.styl',

            ),
            'js' => array(
                'site/projects/whotrades/modules/instruments/instruments-events-calendar.js',
            )
        )
    ),

    'InstrumentsTopChange' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/instruments/instruments-rate/instruments-rate.styl',
                'site/projects/whotrades/modules/instruments/instruments-rate/instruments-rate-chart.styl',
            ),
            // lonelind: js isn't needed here for static widget (its appearance causes exceptions: missing library)
            // 'js' => array('site/projects/whotrades/modules/instruments/instruments-rate/instruments-rate.js')
        )
    ),

    'InstrumentsRateChange' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/instruments/instruments-rate/instruments-rate.styl',
                'site/projects/whotrades/modules/instruments/instruments-rate/instruments-rate-quotes.styl',
            ),
            //'js' => array('site/projects/whotrades/modules/instruments/instruments-rate.js')
        ),
        '{"__view": "edit"}' => array(
            'less' => array(
                'ui/autocomplete/autocomplete.styl',
                'ui/autocomplete/design/air.styl',
                'site/widgets/instruments/instruments-search.less',
            ),
            'js' => array(
                'ui/autocomplete/autocomplete.js',
                'site/projects/whotrades/modules/personal/widgets/InstrumentsRateChange.js',
            )
        ),
    ),

    'InstrumentsProfileTitle' => array(
        '{}' => array(
            'less' => array(
                'ui/autocomplete/autocomplete.styl',
                'ui/autocomplete/design/air.styl',
                'site/projects/whotrades/modules/instrument/instrument-header/instrument-header.styl',
            ),
            'js' => array(
                'ui/autocomplete/autocomplete.js',
                'site/projects/whotrades/modules/instrument/instrument-header/instrument-header.js',
                'site/projects/whotrades/modules/instruments/instruments-search.js'
            )
        )
    ),

    'InstrumentsAccountProbability' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/instruments/instruments-probability.styl'
            ),
            'js' => array(
                'site/projects/whotrades/modules/instruments/instruments-probability.js'
            )
        ),
        '{"__view": "edit"}' => array(
            'less' => array(
//                'site/projects/whotrades/modules/instruments/instruments-rate-conf/instruments-rate-conf.styl',
            ),
            'js' => array(
                'js/lib/jsapi.js',
                'vendor-libs/jquery-ui/modules/jquery.ui.datepicker.js',
                'site/projects/whotrades/modules/personal/widgets/InstrumentsAccountProbability.js',
                'site/projects/whotrades/modules/instruments/instruments-probability.js' // ak: todo: HACK!!!!!! #WTS-1327 fast way to load configs before execution
            )
        ),
    ),

    'InstrumentsExternalHistoryIncome' => array(
        '{}' => array(
            'less' => array(
            //    'site/projects/whotrades/modules/instruments/instruments-external-history-income.styl'
            ),
            'js' => array(
                'site/projects/whotrades/modules/instruments/instruments-external-history-income.js'
            )
        ),
        '{"__view": "edit"}' => array(
            'js' => array(
                'site/projects/whotrades/modules/instruments/instruments-external-history-income.js' // ak: todo: HACK!!!!!! #WTS-1327 fast way to load configs before execution
            )
        )
    ),

    'InstrumentsChart' => array(
        '{}' => array(
            'less' => array(
//                'site/projects/whotrades/modules/instruments/instruments-probability.styl'
            ),
            'js' => array(
//                'site/projects/whotrades/modules/instruments/instruments-probability.js'
//                'site/projects/whotrades/modules/personal/widgets/InstrumentsChart.js',
            )
        ),
        '{"__view": "edit"}' => array(
            'less' => array(
//                'site/projects/whotrades/modules/instruments/instruments-rate-conf/instruments-rate-conf.styl',
            ),
            'js' => array(
//                'js/lib/jsapi.js',
//                'vendor-libs/jquery-ui/modules/jquery.ui.datepicker.js',
                'site/projects/whotrades/modules/personal/widgets/InstrumentsChart.js',
            )
        ),
    ),

    'InstrumentsHeatmap' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/instruments/instruments-heatmap/instruments-heatmap.styl',
                'site/projects/whotrades/modules/instruments/instruments-heatmap/instruments-activity.styl',
            ),
            'js' => array(
                'site/projects/whotrades/modules/instruments/instruments-heatmap/instruments-heatmap.js',
                'site/projects/whotrades/modules/instruments/instruments-heatmap/instruments-activity.js',
            )
        )
    ),

    'InstrumentsFeedOverall' => array(
        '{}' => array(
            'less' => array(
                'app/whotrades/components/instruments/feed/instruments-feed.styl',
            ),
        ),
    ),

    // ak: hack!
    'BlogPosts' => array(
        '{}' => array(
            'less' => array(
                'app/whotrades/components/widgets/widget-customization.styl',
                'app/whotrades/components/blogpost-preview/blogpost-preview.styl',
                'app/whotrades/components/forecast-preview/forecast-preview.styl',
                'app/whotrades/components/forecast/forecast.styl',
                'app/whotrades/components/comments-preview/comments-preview.styl',
                'app/whotrades/components/filter-personal/filter-personal.styl',
                'app/whotrades/components/forecast/forecast.styl',
                'app/whotrades/components/toolbar/toolbar.styl',
                'app/whotrades/components/tiles/tiles.styl',
            ),
            'js' => array(
                'app/whotrades/components/forecast-preview/forecast-preview-eventer.js',
                'site/projects/whotrades/modules/personal/personal-settings.js',
                'app/whotrades/components/countdown/countdown.js',
                'app/whotrades/components/countdown/countdown-eventer.js',
                'app/whotrades/components/toolbar/toolbar-eventer.js',
                'app/whotrades/components/tiles/tiles.js',
            )
        ),
        '{"filter": "personalOthers"}' => array(
            'less' => array(
                'app/whotrades/components/other-posts/other-posts.styl',
            ),
            'js' => array(
            )
        ),
        '{"__view": "edit", "__settingsMode": "general"}' => array(

        ),
        '{"__view": "edit", "__settingsMode": "finam.wt.admin"}' => array(
            'less' => array(
                'ui/autocomplete/autocomplete.styl',
                'ui/autocomplete/design/air.styl',
                'site/widgets/instruments/instruments-search.less',
                'ui/button/interface/flat.styl',
                'site/projects/whotrades/modules/personal/personal-dialoggy.styl',
            ),
            'js' => array(
                'ui/autocomplete/autocomplete.js',
                'site/projects/whotrades/modules/personal/widgets/BlogPosts.js'
            )
        ),
    ),
    // ak: end hack

    'PersonalFeed' => array(
        '{}' => array(
            'less' => array(
                'app/whotrades/components/blogpost-preview/blogpost-preview.styl',
                'app/whotrades/components/comments-preview/comments-preview.styl',
                'app/whotrades/components/forecast-preview/forecast-preview.styl',
                'app/whotrades/components/filter-personal/filter-personal.styl',
                'app/whotrades/components/tiles/tiles.styl',
            ),
            'js' => array(
                'app/whotrades/components/filter-personal/filter-personal.js',
                'app/whotrades/components/forecast-preview/forecast-preview-eventer.js',
                'app/whotrades/components/tiles/tiles.js',
            )
        ),
        '{"__extra": { "withTopBloggers": true }}' => array(
            'less' => array(
                'app/whotrades/components/blogpost-preview/blogpost-preview.styl',
                'app/whotrades/components/comments-preview/comments-preview.styl',
                'app/whotrades/components/forecast-preview/forecast-preview.styl',
                'app/whotrades/components/filter-personal/filter-personal.styl',
                'site/modules/blogs/blogs-users-podium/blogs-users-podium.less',
                'app/whotrades/components/tiles/tiles.styl',
            ),
            'js' => array(
                'app/whotrades/components/filter-personal/filter-personal.js',
                'app/whotrades/components/forecast-preview/forecast-preview-eventer.js',
                'app/whotrades/components/tiles/tiles.js',
            )
        )
    ),

    'MessagesPerson' => array(
        '{}' => array(
            'less' => array(
                'site/blocks/messenger/messenger.less',
                'site/blocks/messenger/dialog.less',
            ),
            'js' => array(
                'js/smileys-handlers.js',
                'site/widgets/messages-person/messages-person.js',
            ),
        ),
    ),
    'PeopleItemAchievements' => array(
        '{"mode": "widget"}' => array(
            'less' => array('site/widgets/people-achievements-short/people-achievements-short.less'),
            'js' => array('site/widgets/people-achievements-short/people-achievements-short.js'),
        ),
        '{"mode": "content"}' => array(
            'less' => array(
                'common-blocks/achievements-table/achievements-table.less',
                'site/widgets/people-achievements-full/people-achievements-full.less',
            ),
        ),
    ),
    'PersonPhone' => array(
        '{}' => array(
            'less' => array('site/blocks/phone-component/phone-component.less'),
        ),
    ),

    'PersonBirthday' => array(
        '{}' => array(
            'less' => array('site/projects/whotrades/modules/landings/landing-birthday/landing-birthday.styl'),
        ),
    ),

    'PersonalBanner' => array(
        '{}' => array(),
        '{"__view": "edit"}' => array(
            'less' => array(),
            'js' => array(
                'site/projects/whotrades/modules/personal/widgets/PersonalBanner.js',
            )
        ),
    ),

    'PersonalSiteHeader' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/personal/personal-head.styl'
            ),
            'js' => array(
                'vendor-libs/file-api/FileAPI.js',
                'site/projects/whotrades/modules/personal/personal-header.js',
                'site/projects/whotrades/modules/personal/personal-cover-upload.js',
            )
        ),
    ),
    'PersonalSiteGroupsItemEdit' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/personal/personal-dialoggy.styl',
            ),
        ),
    ),
    'RecommendedAction' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/personal/personal-promo.less'
            ),
            'js' => array(
                'site/projects/whotrades/modules/personal/jquery.async.js',
                'site/projects/whotrades/modules/personal/personal-promo.js'
            )
        ),
    ),
    'Photos' => array(
        '{}' => array(
            'less' => array('site/blocks/photos-previews-slider/photos-previews-slider.less'),
            'js' => array('site/blocks/photos-previews-slider/photos-previews-slider.js'),
        )
    ),
    'PhotosItem' => array(
        '{}' => array(
            'less' => array(
                'site/widgets/photos-item/photos-item.less',
                'site/blocks/gray-panel/gray-panel.less',
            ),
            'js' => array(
                'site/widgets/photos-item/photos-item.js',
            ),
        ),
    ),
    'PhotosSlideshowViewing' => array(
        '{}' => array(
            'less' => array('site/blocks/block-photos-slideshow-viewing/block-photos-slideshow-viewing.less'),
            'js' => array('site/blocks/block-photos-slideshow-viewing/block-photos-slideshow-viewing.js'),
        ),
    ),
    'PollsItem' => array(
        '{}' => array(
            'js' => array('site/widgets/polls-item/polls-item.js'),
        )
    ),
    'ProfileInfo' => array(
        '{}' => array(
            'less' => array(
                'site/widgets/profile-info/profile-info.less',
                'site/projects/whotrades/modules/personal/widgets/ProfileInfo.styl'
            ),
        ),
    ),
    'RealAccountOpen' => array(
        '{}' => array(
            'less' => array(
                'site/blocks/phone-component/phone-component.less',
                'site/blocks/steps-pager/steps-pager.less',
                'site/blocks/widget-profile-settings/widget-profile-settings.less',
            ),
            'js' => array(
                'site/widgets/real-account-open/real-account-open.js',
            ),
        ),
    ),
    'Registration' => array(
        '{}' => array(
            'less' => array('site/blocks/phone-component/phone-component.less'),
        ),
    ),
    'SendRequest' => array(
        '{}' => array(
            'js' => array('site/widgets/send-request/send-request.js'),
        ),
    ),
    'SettingsPrivacy' => array(
        '{}' => array(
            'js' => array('site/widgets/settings-privacy/settings-privacy.js'),
        ),
    ),

    'SignalRepeater_Strategies' => array(
        '{}' => array(
            'less' => array('site/widgets/strategies-list/strategies-list.less'),
        ),
    ),

    'SignalRepeater_StrategiesItemEdit' => array(
        '{}' => array(
            'js' => array(
                'site/widgets/signal-repeater-strategies-item-edit/signal-repeater-strategies-item-edit.js',
            ),
        ),
    ),

    'SignalRepeater_Subscriptions' => array(
        '{"display_mode": "person_subscribers"}' => array(
            'less' => array('site/widgets/strategy-followers/strategy-followers.less'),
            // js лежит в самом html шаблоне, т.к. маленький
        ),
        '{}' => array(
            'js' => array(
                'site/blocks/signal-repeater-subscriptions/signal-repeater-subscriptions.js'
            )
        )
        /*
        '{"display_mode": "person_subscriptions"}' => array(
            // js лежит в самом html шаблоне, т.к. маленький
        ),
        '{"display_mode": "person_accounts"}' => array(
        ),
        */
    ),
    'SignalRepeater_SubscriptionsItemEdit' => array(
        '{}' => array(
            'less' => array('site/widgets/signal-repeater-subscriptions-item-edit/signal-repeater-subscriptions-item-edit.less'),
            'js' => array(
                'site/widgets/signal-repeater-subscriptions-item-edit/signal-repeater-subscriptions-item-edit.js',
                'site/widgets/signal-repeater-subscriptions-item-edit/new-york-time.js',
            ),
        ),
    ),

    'SocialImport' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/personal/widgets/SocialImport.styl',
            ),
            'js' => array(
                'site/projects/whotrades/modules/personal/widgets/SocialImport.js',
            )
        ),
    ),
    /* mars: commented #WHO-918
    'StaticTplDev' => array(
        /* mars: example, template (for copy)
        '{"tpl": "/"}' => array(
            'less' => array(''),
        ),
        * /
    ),
    */

    'StaticHtmlWysiwyg' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/modules/personal/widgets/StaticHtmlWysiwyg.styl'
            ),
        ),
        '{"__view": "edit"}' => array(
            'js' => array(
                'site/projects/whotrades/modules/personal/widgets/StaticHtmlWysiwyg.js',
            )
        ),
    ),

    // lonelind: WidgetsList for personal sites constructor
    'WidgetsList' => array(
        '{}' => array(
            'less' => array('site/projects/whotrades/modules/personal/personal-widgets-list.styl'),
//            'js' => array('site/projects/whotrades/modules/personal/personal-widgets-list.js')
        ),
    ),


    // TradeRepeater.
    'TradeRepeater_StrategiesItemEdit' => array(
        '{}' => array(
            'less' => array('site/projects/whotrades/strategies-v2/strategies-v2-item-edit.styl'),
            'js' => array('site/projects/whotrades/strategies-v2/strategies-v2.js'),
        ),
    ),
    'TradeRepeater_StrategiesItemView' => array(
        '{}' => array(
            'less' => array(
                'ui/button/interface/flat-v2.styl',
                'site/projects/whotrades/strategies-v2/strategies-v2-item-view.styl',
                'app/whotrades/components/strategies/banner/strategies-banner-eo.styl',
                'app/whotrades/components/strategies/tile/strategies-tile.styl',
                'site/blocks/comments/comments.less'
            ),
            'js' => array(
                'app/whotrades/components/strategies/tile/strategies-tile.js',
                'js/lib/jsapi.js', //lk: google loader for strategy pie #WHO-4850, see strategy-tab-consist.tpl
                'site/projects/whotrades/strategies-v2/strategies-v2.js',
                'site/projects/whotrades/strategies-v2/strategies-v2-item-view.js',
                'site/blocks/comments/comments.js'
            ),
        ),
    ),
    // azw: нужно ли это ?
    'TradeRepeater_Strategies' => array(
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/strategies-v2/strategies-v2-search.styl',
                'site/projects/whotrades/strategies-v2/strategies-v2-items.styl',
            ),
            'js' => array(
                //'site/widgets/trade-repeater-strategies-search/trade-repeater-strategies-search.js',
                'site/projects/whotrades/strategies-v2/strategies-v2.js',
                'site/projects/whotrades/strategies-v2/strategies-v2-item-search.js',
            ),
        ),
    ),
    'TradeRepeater_StrategiesSearch' => array(
        '{"displayMode": "'.Widget_TradeRepeater_StrategiesSearch::DISPLAY_MODE_LARGE_TILE.'"}' => array(
            'less' => array(
                'ui/button/interface/flat-v2.styl',
                'site/projects/whotrades/strategies-v2/strategies-v2.styl',
                'site/projects/whotrades/strategies-v2/strategies-v2-items.styl',
                'site/projects/whotrades/strategies-v2/strategies-v2-search.styl',
                'app/whotrades/components/strategies/tile/strategies-tile.styl',
                'app/whotrades/components/strategies/banner/strategies-banner-eo.styl',
                //'app/whotrades/components/strategies/strategies.styl',
            ),
            'js' => array(
                'app/whotrades/components/strategies/tile/strategies-tile.js',
                //'site/widgets/trade-repeater-strategies-search/trade-repeater-strategies-search.js',
                'site/projects/whotrades/strategies-v2/strategies-v2.js',
                'site/projects/whotrades/strategies-v2/strategies-v2-item-search.js',
            ),
        ),
        '{}' => array(
            'less' => array(
                'site/projects/whotrades/strategies-v2/strategies-v2.styl',
                'site/projects/whotrades/strategies-v2/strategies-v2-items.styl',
                'site/projects/whotrades/strategies-v2/strategies-v2-search.styl',
                'app/whotrades/components/strategies/banner/strategies-banner-eo.styl',

            ),
            'js' => array(
                //'site/widgets/trade-repeater-strategies-search/trade-repeater-strategies-search.js',
                'site/projects/whotrades/strategies-v2/strategies-v2.js',
                'site/projects/whotrades/strategies-v2/strategies-v2-item-search.js',
            ),
        ),
    ),
    'Strategy' => array(
        '{}' => array(
            'less' => array(
                'app/whotrades/components/strategies/tile/strategies-tile.styl',
                'site/projects/whotrades/strategies-v2/strategies-v2-items.styl',
                'site/projects/whotrades/strategies-v2/strategy_widget.styl',
            ),
            'js' => array(
                'app/whotrades/components/strategies/tile/strategies-tile.js',
            ),
        ),
        '{"__view": "edit"}' => array(
            'js' => array(
                'app/whotrades/components/strategies/tile/strategies-tile.js' // ak: todo: HACK!!!!!! #WTS-1327 fast way to load configs before execution
            )
        )
    ),
    'TradeRepeater_Subscriptions' => array(
        // lk: since WHO-4197, see Widget_TradeRepeater_Subscriptions::DISPLAY_MODE_PORTFOLIO
        '{"display_mode": "portfolio"}' => array(
            'less' => array('site/projects/whotrades/strategies-v2/strategies-v2-subscriptions-my.styl'),
            'js' => array(
                'site/projects/whotrades/strategies-v2/strategies-v2.js',
                'site/projects/whotrades/strategies-v2/my-subscriptions-ajax-periodical-refresh.js'
            ),
        ),
        '{}' => array(
            'less' => array('site/projects/whotrades/strategies-v2/strategies-v2-subscriptions.styl'),
            'js' => array('site/projects/whotrades/strategies-v2/strategies-v2.js'),
        ),
    ),
    // bn: since #WHO-4569
    'TradeRepeater_SubscriptionsItemView' => array(
        '{}' => array(
            'less' => array ('site/projects/whotrades/strategies-v2/strategies-v2-subscriptions-view.styl'),
            'js' => array(
                //lk: google loader for subscription chart #WHO-4611
                'js/lib/jsapi.js',
                'site/projects/whotrades/strategies-v2/strategies-v2-subscriptions-view.js',
                'site/projects/whotrades/strategies-v2/my-subscription-chart-ajax-periodical-refresh.js'
            ),
        ),
    ),
    'TradeRepeater_AccountHistory' => array(
        '{}' => array(
            'less' => array('site/projects/whotrades/strategies-v2/strategies-v2-history.styl'),
        ),
    ),

    // lk: since #WTT-339, #WTT-340
    // lk: TODO: ensure proper resources for widget
    'TradeRepeater_Payment' => array(
        '{}' => array(
            'less' => array(
                //'site/blocks/phone-component/phone-component.less',
                'site/blocks/choose-payment-method-block/choose-payment-method-block-v2.less',
                //'site/blocks/payment-type-choose/payment-type-choose.less',
                //'site/projects/exotic-options/spinner/spinner.less'
            ),
            'js' => array(
                'site/widgets/comon-payment-universal/comon-payment-universal.js',
                'site/projects/exotic-options/payments/payments-v2.js'
            ),
        ),
    ),

    'ExoticOptionsCashOut' => array(
        '{}' => array(
            'less' => array(
                'site/blocks/choose-payment-method-block/choose-payment-method-block-v2.less',
                'site/projects/whotrades/strategies-v2/strategies-v2-payment.styl'
            ),
            'js' => array(
                'site/widgets/comon-payment-universal/comon-payment-universal.js',
                'site/projects/exotic-options/payments/payments-v2.js'
            ),
        ),
    ),

    // End TradeRepeater.


    'SupportForm' => array(
        '{}' => array(
            'less' => array(
                'site/blocks/payment-type-choose/payment-type-choose.less',
                'site/blocks/phone-component/phone-component.less',
            ),
        ),
    ),

    'Twitter' => array(
        '{}' => array(
            'less' => array('site/widgets/twitter/twitter.less'),
            'js' => array(
                'lib/deprecated/html-tag.js',
                'site/widgets/twitter/twitter.js'
            ),
        ),
    ),
    'UploadQueueItem' => array(
        '{}' => array(
            'js' => array('site/widgets/upload-queue-item/upload-queue-item.js'),
            // 'less' => array('site/widgets/upload-queue-item/upload-queue-item.less'),
        ),
    ),
    'Videoroom' => array(
        '{}' => array(
            'js' => array('site/widgets/videoroom/videoroom.js'),
        ),
    ),
    'Videos' => array(
        '{}' => array(
            'less' => array('site/widgets/videos/videos.less'),
            'js' => array('site/widgets/videos/videos.js'),
        ),
    ),
    'VideosItem' => array(
        '{}' => array(
            'less' => array('site/widgets/videos-item/videos-item.less'),
        ),
    ),
    'VideosItemEdit' => array(
        '{}' => array(
            'less' => array(
                'site/blocks/media/media.less',
                'site/widgets/videos-item-edit/videos-item-edit.less',
            ),
        ),
    ),
    // mars: сортировка в алфавитном порядке
);

/*
 * Old widget data.
 * @deprecated
 */
$this->widgets_data = array(
    'Activities' => array(
        'overlay_content' => 'site/widgets/Activities_overlay_content.tpl',
    ),
    'Audio' => array(
        'scripts' => 'site/widgets/Audio_scripts.tpl',
    ),
    'AudioItemEdit' => array(
        'styles' => 'site/widgets/AudioItemEdit_styles.tpl',
        'scripts' => 'site/widgets/AudioItemEdit_scripts.tpl',
    ),
    'BlogPosts' => array(
        'styles' => 'site/widgets/BlogPosts_styles.tpl',
        'scripts' => 'site/widgets/BlogPosts_scripts.tpl',
    ),
    'BlogPostsItem' => array(
        'styles' => 'site/widgets/BlogPostsItem_styles.tpl',
        'scripts' => 'site/widgets/BlogPostsItem_scripts.tpl',
    ),
    'CabinetAccounts' => array(
        'scripts' => 'site/widgets/CabinetAccounts_scripts.tpl',
    ),
    'CabinetAgentsReport' => array(
        'styles' => 'site/widgets/CabinetAgentsReport_styles.tpl',
        'html_templates' => 'site/widgets/CabinetAgentsReport_html_templates.tpl',
    ),
    'CabinetAssignment' => array(
        'styles' => 'site/widgets/CabinetAssignment_styles.tpl',
    ),
    'CabinetMarketDataAndTradingPlatform' => array(
        'styles' => 'site/widgets/CabinetMarketDataAndTradingPlatform_styles.tpl',
        'scripts' => 'site/widgets/CabinetMarketDataAndTradingPlatform_scripts.tpl',
    ),
    'CabinetTradeTransactions' => array(
        'scripts' => 'site/widgets/CabinetTradeTransactions_scripts.tpl',
    ),
    'ChartPostsItem' => array(
        'styles' => 'site/widgets/ChartPostsItem_styles.tpl',
    ),
    'ClientAssistanceMessageGuest' => array(
        'styles' => 'site/widgets/ClientAssistanceMessageGuest_styles.tpl',
    ),
    'Comments' => array(
        'styles' => 'site/widgets/Comments_styles.tpl',
    ),
    'ComonCabinet' => array(
        'scripts' => 'site/widgets/ComonCabinet_scripts.tpl',
    ),
    'ComonBankingDetails' => array(
        'scripts' => 'site/widgets/ComonBankingDetails_scripts.tpl',
    ),
    'ComonGroupsItemEdit' => array(
        'scripts' => 'site/widgets/ComonGroupsItemEdit_scripts.tpl',
    ),
    'ComonFakeTrading' => array(
        'overlay_content' => 'site/widgets/ComonFakeTrading_overlay_content.tpl',
    ),
    'ComonMarketWatch' => array(
        'scripts' => 'site/widgets/ComonMarketWatch_scripts.tpl',
        'html_templates' => 'site/widgets/ComonMarketWatch_html_templates.tpl',
    ),
    'CabinetFundsDeposit' => array(
        'html_templates' => 'site/widgets/CabinetFundsDeposit_html_templates.tpl',
    ),
    'CabinetProxyPage' => array(
        'styles' => 'site/widgets/CabinetProxyPage_styles.tpl',
        'html_templates' => 'site/widgets/CabinetProxyPage_html_templates.tpl',
    ),
    'CabinetReport' => array(
        'styles' => 'site/widgets/CabinetReport_styles.tpl',
        'html_templates' => 'site/widgets/CabinetReport_html_templates.tpl',
    ),
    'ComonPaymentUniversal' => array(
        'scripts' => 'site/widgets/ComonPaymentUniversal_scripts.tpl',
    ),
    'ComonPortfolio' => array(
        'styles' => 'site/widgets/ComonPortfolio_styles.tpl',
        'scripts' => 'site/widgets/ComonPortfolio_scripts.tpl',
    ),
    'ComonProfileGeneralSettings' => array(
        'styles' => 'site/widgets/ComonProfileGeneralSettings_styles.tpl',
    ),
    'ComonProfitability' => array(
        'styles' => 'site/widgets/ComonProfitability_styles.tpl',
    ),
    'ComonTradeSignals' => array(
        'styles' => 'site/widgets/ComonTradeSignals_styles.tpl',
    ),
    'ComonTransactions' => array(
        'styles' => 'site/widgets/ComonTransactions_styles.tpl',
    ),
    'CabinetTradingPassword' => array(
        'styles' => 'site/widgets/ComonTradeSignals_styles.tpl',
    ),
    'Groups' => array(
        'styles' => 'site/widgets/Groups_styles.tpl',
    ),
    'GroupsItemPeople' => array(
        'styles' => 'site/widgets/GroupsItemPeople_styles.tpl',
        'scripts' => 'site/widgets/GroupsItemPeople_scripts.tpl',
    ),
    'GroupsItemPeopleItemEditEmail' => array(
        'styles' => 'site/widgets/GroupsItemPeopleItemEditEmail_styles.tpl',
    ),
    'GroupsItemPeopleItemEditProfilePersonal' => array(
        'styles' => 'site/widgets/GroupsItemPeopleItemEditProfilePersonal_styles.tpl',
        'scripts' => 'site/widgets/GroupsItemPeopleItemEditProfilePersonal_scripts.tpl',
    ),
    'GroupsItemPeopleItemFollows' => array(
        'styles' => 'site/widgets/GroupsItemPeopleItemFollows_styles.tpl',
        'scripts' => 'site/widgets/GroupsItemPeopleItemFollows_scripts.tpl',
    ),
    'GroupsItemPeopleItemWizardInvite' => array(
        'styles' => 'site/widgets/GroupsItemPeopleItemWizardInvite_styles.tpl',
    ),
    'GroupsItemPeopleItemWizardPersonal' => array(
        'styles' => 'site/widgets/GroupsItemPeopleItemWizardPersonal_styles.tpl',
    ),
    'GroupsItemPeopleItemWizardPhoto' => array(
        'styles' => 'site/widgets/GroupsItemPeopleItemWizardPhoto_styles.tpl',
    ),
    'InstrumentsProfileFeed' => array(
        'styles' => 'site/widgets/InstrumentsProfileFeed_styles.tpl',
    ),
    'InstrumentsTiles' => array(
        'styles' => 'site/widgets/InstrumentsTiles_styles.tpl',
        'scripts' => 'site/widgets/InstrumentsTiles_scripts.tpl',
    ),
    'Login' => array(
        'scripts' => 'site/widgets/Login_scripts.tpl',
    ),
    'Messages' => array(
        'styles' => 'Messages_styles.tpl',
        'scripts' => 'Messages_scripts.tpl',
    ),
    'MessagesPerson' => array(
        'styles' => 'site/widgets/MessagesPerson_styles.tpl',
    ),
    'PersonalFeed' => array(
        'styles' => 'site/widgets/BlogPosts_styles.tpl',
        'scripts' => 'site/widgets/BlogPosts_scripts.tpl',
    ),
    'PersonFollowers' => array(
        'styles' => 'site/widgets/PersonFollowers_styles.tpl',
    ),
    'PersonFollows' => array(
        'styles' => 'site/widgets/PersonFollows_styles.tpl',
    ),
    'PersonCounters' => array(
        'styles' => 'site/widgets/PersonCounters_styles.tpl',
    ),
    'PhotosItem' => array(
        'styles' => 'site/widgets/PhotosItem_styles.tpl',
    ),
    'PhotosItemEdit' => array(
        'styles' => 'site/widgets/PhotosItemEdit_styles.tpl',
        'scripts' => 'site/widgets/PhotosItemEdit_scripts.tpl',
    ),
    'ProfileStatistics' => array(
        'styles' => 'site/widgets/ProfileStatistics_styles.tpl',
    ),
    'RssViewer' => array(
        'styles' => 'site/widgets/RssViewer_styles.tpl',
    ),
    'Search' => array(
        'styles' => 'site/widgets/Search_styles.tpl',
        'scripts' => 'site/widgets/Search_scripts.tpl',
    ),
    'SettingsPrivacy' => array(
        'styles' => 'site/widgets/SettingsPrivacy_styles.tpl',
    ),
    'SignalRepeater_Strategies' => array(
        'styles' => 'site/widgets/SignalRepeater_Strategies_styles.tpl',
        'scripts' => 'site/widgets/SignalRepeater_Strategies_scripts.tpl',
        'overlay_content' => 'site/widgets/SignalRepeater_Strategies_overlay_content.tpl'
    ),
    'SignalRepeater_StrategiesItems' => array(
        'styles' => 'site/widgets/SignalRepeater_StrategiesItems_styles.tpl',
        'scripts' => 'site/widgets/SignalRepeater_StrategiesItems_scripts.tpl',
        'overlay_content' => 'site/widgets/SignalRepeater_StrategiesItems_overlay_content.tpl',
    ),
    'SignalRepeater_Subscriptions' => array(
        'styles' => 'site/widgets/SignalRepeater_Subscriptions_styles.tpl',
        'scripts' => 'site/widgets/SignalRepeater_Subscriptions_scripts.tpl',
    ),
    'SignalRepeater_SubscriptionsArchive' => array(
        'styles' => 'site/widgets/SignalRepeater_SubscriptionsArchive_styles.tpl',
    ),
    'TagCloud' => array(
        'styles' => 'site/widgets/TagCloud_styles.tpl',
        'scripts' => 'site/widgets/TagCloud_scripts.tpl',
    ),
    'UploadQueueItem' => array(
        'styles' => 'site/widgets/UploadQueueItem_styles.tpl',
        'scripts' => 'site/widgets/UploadQueueItem_scripts.tpl',
    ),
    'Videos' => array(
        'styles' => 'site/widgets/Videos_styles.tpl',
        'scripts' => 'site/widgets/Videos_scripts.tpl',
    ),
    'VideosItem' => array(
        'styles' => 'site/widgets/VideosItem_styles.tpl',
        'scripts' => 'site/widgets/VideosItem_scripts.tpl',
    ),
    'VideosItemEdit' => array(
        'styles' => 'site/widgets/VideosItemEdit_styles.tpl',
        'scripts' => 'site/widgets/VideosItemEdit_scripts.tpl',
    ),
    // mars: сортировка в алфавитном порядке
);

$this->static_widgets_data = array(
    "Comon/award-world-finance-page.tpl" => array(
        "styles" => "page-award-world-finance",
    ),
    "WhotradesLtd/whotrades-ltd__page_moderator-rules.tpl" => array(
        "styles" => "page-moderator-rules",
    ),
    "Comon/award-world-finance-widget.tpl" => array(
        "styles" => "widget-award-world-finance",
    ),
    "Comon/moderator-rules-widget.tpl" => array(
        "styles" => "widget-moderator-rules",
    ),
    "Comon/comon__page_faq.tpl" => array(
        "styles" => "page-faq",
    ),

    "Comon/page-faq-video.tpl" => array(
        "styles" => "page-faq-video",
        "scripts" => "page-faq-video",
    ),
    "Comon/real-account-open-steps.tpl" => array(
        "styles" => "real-account-open-steps",
    ),
    "Comon/landings/learning-points/landing-learning-points-index.tpl" => array(
        "styles" => "landing-learning-points",
    ),
    "Comon/landings/webinar-points/landing-webinar-points-index.tpl" => array(
        "styles" => "landing-learning-points",
    ),
    "Comon/landings/jaguar-2014/landing-jaguar-2014.tpl" => array(
        "styles" => "landing-jaguar-2014",
    ),
    "Comon/landings/jaguar-2014/landing-jaguar-2014-reglament.tpl" => array(
        "styles" => "landing-jaguar-2014",
    ),
    "Comon/landings/jaguar-2014/landing-jaguar-2014-faq.tpl" => array(
        "styles" => "landing-jaguar-2014",
    ),
    "Comon/landings/strategies/landing-strategies.tpl" => array(
        "styles" => "landing-strategies",
    ),
    "Comon/landings/buffett/landing-buffett.tpl" => array(
        "styles" => "landing-buffett",
    ),
    "Comon/landings/welcome/landing-welcome.tpl" => array(
        "styles" => "landing-welcome",
    ),

    /* Start Whotardes Ltd. */
    "WhotradesLtd/about.tpl" => array(
        "styles" => "page-about",
    ),
    "WhotradesLtd/our-solutions.tpl" => array(
        "styles" => "page-our-solutions",
        "scripts" => "page-our-solutions",
    ),
    "WhotradesLtd/whotrades-ltd__page_funds-withdrawal.tpl" => array(
        "styles" => "page-funds-withdrawal",
    ),
    "WhotradesLtd/whotrades-ltd__page_regulation.tpl" => array(
        "styles" => "page-licenses",
    ),
    "WhotradesLtd/whotrades-ltd__page_top-up-account.tpl" => array(
        "styles" => "page-top-up-account",
    ),
    "WhotradesLtd/comon__page_trading-applications.tpl" => array(
        "styles" => "page-trading-applications",
    ),
    "WhotradesLtd/page_new_about_forex_tariff_details_analysis.tpl" => array(
        "styles" => "cabinet-proxy-page",
    ),



    "WhotradesLtd/services-v2/forex/services-forex.tpl" => array(
        "styles" => "services-v2-forex",
    ),
    "WhotradesLtd/services-v2/forex/services-forex-accounts.tpl" => array(
        "styles" => "services-v2-forex",
    ),
    "WhotradesLtd/services-v2/forex/services-forex-platforms.tpl" => array(
        "styles" => "services-v2-forex"
    ),
    "WhotradesLtd/services-v2/forex/services-forex-bonus.tpl" => array(
        "styles" => "services-v2-forex"
    ),
    "WhotradesLtd/services-v2/about/services-about.tpl" => array(
        "styles" => "services-v2-about",
        "scripts" => "services-v2-about"
    ),
    "WhotradesLtd/services-v2/forex/services-forex-instruments.tpl" => array(
        "styles" => "services-v2-forex",
        "scripts" => "services-v2-forex"
    ),

    "WhotradesLtd/services-v2/eo/services-eo-overview.tpl" => array(
        "styles" => "services-v2-eo"
    ),
    "WhotradesLtd/services-v2/eo/services-eo-features.tpl" => array(
        "styles" => "services-v2-eo"
    ),
    "WhotradesLtd/services-v2/eo/services-eo-conditions.tpl" => array(
        "styles" => "services-v2-eo"
    ),
    "WhotradesLtd/services-v2/eo/services-eo-io.tpl" => array(
        "styles" => "services-v2-eo"
    ),
    "WhotradesLtd/services-v2/eo/services-eo-requirements.tpl" => array(
        "styles" => "services-v2-eo"
    ),

    /* End Whotardes Ltd. */

    /* Start Whotardes USA. */
    "WhotradesUsa/fees.tpl" => array(
        "styles" => "page-fees-commission-wt-inc",
        "scripts" => "page-fees-commission-wt-inc",
    ),
    'WhotradesUsa/services/services-forex.tpl' => array(
        'styles' => 'services-inc-forex',
    ),
    'WhotradesUsa/services/services-forex-price.tpl' => array(
        'styles' => 'services-inc-forex',
    ),
    'WhotradesUsa/services/services-forex-apps.tpl' => array(
        'styles' => 'services-inc-forex',
    ),
    'WhotradesUsa/services/services-forex-apps-metatrader.tpl' => array(
        'styles' => 'services-inc-forex',
    ),
    'WhotradesUsa/services/services-forex-apps-pulsefx.tpl' => array(
        'styles' => 'services-inc-forex',
    ),
    'WhotradesUsa/services/services-forex-apps-web.tpl' => array(
        'styles' => 'services-inc-forex',
    ),
    'WhotradesUsa/services/services-forex-apps-mobile.tpl' => array(
        'styles' => 'services-inc-forex',
    ),
    'WhotradesUsa/services/services-forex-resources.tpl' => array(
        'styles' => 'services-inc-forex',
    ),
    'WhotradesUsa/services/services-forex-resources-more.tpl' => array(
        'styles' => 'services-inc-forex',
    ),
    /* End Whotrades USA. */

    "GroupsItem/update-browser.tpl" => array(
        "styles" => "page-update-browser",
    ),
    "GroupsItem/finam-ru-sidebar-banner.tpl" => array(
        "styles" => "finam-ru-sidebar-banner",
        "scripts" => "finam-ru-sidebar-banner",
    ),
    "GroupsItem/finam-ru-sidebar-banner-v2.tpl" => array(
        "styles" => "finam-ru-sidebar-banner-v2",
        "scripts" => "finam-ru-blog-post-banner",
    ),
    "GroupsItem/finam-ru-sidebar-banner-v3.tpl" => array(
        "styles" => "finam-ru-sidebar-banner-v2",
        "scripts" => "finam-ru-blog-post-banner",
    ),
    "GroupsItem/finam-ru-blog-post-banner.tpl" => array(
        "styles" => "finam-ru-blog-post-banner",
        "scripts" => "finam-ru-blog-post-banner",
    ),
    "GroupsItem/finam-ru-blog-post-banner-v2.tpl" => array(
        "styles" => "finam-ru-blog-post-banner-v2",
        "scripts" => "finam-ru-blog-post-banner",
    ),
    "GroupsItem/finam-ru-blog-post-banner-v3.tpl" => array(
        "styles" => "finam-ru-blog-post-banner-v3",
        "scripts" => "finam-ru-blog-post-banner-v3",
    ),
    "GroupsItem/finam-ru-blog-post-banner-v4.tpl" => array(
        "styles" => "finam-ru-blog-post-banner-v4",
        "scripts" => "finam-ru-blog-post-banner-v4",
    ),
    "GroupsItem/finam-ru-blog-post-banner-v5.tpl" => array(
        "styles" => "finam-ru-blog-post-banner-v5",
        "scripts" => "finam-ru-blog-post-banner-v5",
    ),
    "GroupsItem/finam-ru-banner-test-for-rmukhin.tpl" => array(
        //"styles" => array("finam-ru-blog-post-banner", "finam-ru-sidebar-banner"),
        "scripts" => array("finam-ru-blog-post-banner", "finam-ru-sidebar-banner"),
    ),
    'BlogPosts/blogs_search.tpl' => array(
        'styles' => 'search-field',
        'scripts' => 'search-field',
    ),
    'FinamRu/vk-fb-button.tpl' => array(
        'scripts' => 'finam-social-buttons'
    )
);

// mars: for main/tpls/*.tpl
// @deprecated
$this->content_tpls_static_data = array(
    /* mars: example
    'path to tpl' => array(
        'styles' => 'path to styles tpl',
        'scripts' => 'path to scripts tpl'
    ),
    */
    'GroupsItemEdit2ndLevelDomain.tpl' => array(
        'scripts' => 'GroupsItemEdit2ndLevelDomain_scripts.tpl',
    ),
    'GroupsItemPhotosItem.tpl' => array(
        'styles' => 'GroupsItemPhotosItem_styles.tpl',
        'scripts' => 'GroupsItemPhotosItem_scripts.tpl',
    ),
    'GroupsItemPhotosItemEdit.tpl' => array(
        'styles' => 'GroupsItemPhotosItemEdit_styles.tpl',
        'scripts' => 'GroupsItemPhotosItemEdit_scripts.tpl',
    ),
    'Messages.tpl' => array(
        'styles' => 'Messages_styles.tpl',
        'scripts' => 'Messages_scripts.tpl',
    ),
    'Messenger.tpl' => array(
        'styles' => 'Messenger_styles.tpl',
    ),
    'PeopleItem.tpl' => array(
        'scripts' => 'PeopleItem_scripts.tpl',
    ),
    'PeopleItemPhotos.tpl' => array(
        'styles' => 'PeopleItemPhotos_styles.tpl',
        'scripts' => 'PeopleItemPhotos_scripts.tpl',
    ),
    'PeopleItemPhotosItem.tpl' => array(
        'styles' => 'PeopleItemPhotosItem_styles.tpl',
        'scripts' => 'PeopleItemPhotosItem_scripts.tpl',
    ),
    'PhotosItemEdit.tpl' => array(
        'scripts' => 'PhotosItemEdit_scripts.tpl',
    ),
    'PhotosUpload.tpl' => array(
        'styles' => 'PhotosUpload_styles.tpl',
        'scripts' => 'PhotosUpload_scripts.tpl',
    ),
);

//id: since #WHO-3344 also holds templates for template controller, not only for smarty function;
$this->client_side_html_templates = array(
    'overlay_content_popup_template' => 'site/partials/overlay-content-popup.tpl',
    'overlay-photo-gallery' => 'site/partials/overlay-photo-gallery.tpl',
    'printWindowTemplate' => 'site/partials/print-window-template.tpl',
    'market-watch-line-template' => 'site/partials/market-watch-line-template.tpl',
    'fast-registration-popup' => 'site/partials/fast-registration-popup.tpl',
    'dropdown-list' => 'site/partials/dropdown-list.tpl',
    'dropdown-list-item-instrument' => 'site/partials/dropdown-list-item-instrument.tpl',
    'messenger-popup' => 'site/partials/messenger-popup.tpl',
    'eo-video-popup' => 'site/partials/eo-video-popup.tpl',
    'instruments-heatmap-ticker' => 'site/partials/instruments-heatmap-ticker.tpl',
    'user-rating-bubble-template' => 'site/partials/user-rating-bubble.tpl',
    'chart-post-tradingview' => 'site/partials/chart-post-tradingview.tpl',
    'notifications' => 'site/partials/notifications.tpl',
    'notifications-item' => 'site/partials/notifications-item.tpl',
    'whotrades-us-disclaimer' => 'site/partials/whotrades-us-disclaimer.tpl',
    'social-share' => 'site/partials/social/social-share.tpl',
    'authorize-message-comment' => 'site/partials/authorize/authorize-message-comment.tpl',
    'authorize-message-favorite' => 'site/partials/authorize/authorize-message-favorite.tpl',
    'authorize-message-follow' => 'site/partials/authorize/authorize-message-follow.tpl',
    'authorize-message-download' => 'site/partials/authorize/authorize-message-download.tpl',
    'authorize-message-like' => 'site/partials/authorize/authorize-message-like.tpl',
    'authorize-message-forecast' => 'site/partials/authorize/authorize-message-forecast.tpl',
    'authorize-message-web-app' => 'site/partials/authorize/authorize-message-web-app.tpl',

    'entered-phone' => 'site/components/phone-component/entered-phone.tpl',
    'phone-verify-field' => 'site/components/phone-component/phone-verify-field-template.tpl',
    'phone-verify-form-item-template' => 'site/components/phone-component/phone-verify-form-item.tpl',
    'banner-smi2-teaser-template' => 'site/partials/banner-smi2-teaser.tpl',
);

/**
 * The layouts configure.
 *
 * Use the rules:
 *     'layout-#name#' => array(
 *         'view' => 'path/to/tpl',
 *         'styles' => 'path/to/tpl',
 *         'scripts' => 'path/to/tpl',
 *     )
 */
$this->layouts = array(
    'center' => array(
        'view' => 'site/content-layouts/empty.tpl'
    ),
    'empty' => array(
        'view' => 'site/content-layouts/empty.tpl'
    ),
    'center+right' => array(
        'view' => 'site/content-layouts/columns_main-right.tpl',
        'styles' => array(
            'site/content-layouts/layout-center-right.less',
        ),
    ),
    'main+right' => array(
        'view' => 'site/content-layouts/columns_main-right.tpl',
        'styles' => array(
            'site/content-layouts/layout-center-right.less',
        ),
    ),
    'left+center' => array(
        'view' => 'site/content-layouts/columns_left-main.tpl',
        'styles' => array(
            'site/content-layouts/layout-left-main.less',
        ),
    ),
    'left+main' => array(
        'view' => 'site/content-layouts/columns_left-main.tpl',
        'styles' => array(
            'site/content-layouts/layout-left-main.less',
        ),
    ),
    'left+center+right' => array(
        'view' => 'site/content-layouts/left-center-right.tpl',
        'styles' => array(
            'site/content-layouts/layout-left-center-right.less',
        ),
    ),
    'left-center-right' => array(
        'view' => 'site/content-layouts/left-center-right.tpl',
        'styles' => array(
            'site/content-layouts/layout-left-center-right.less',
        ),
    ),
    'empty-one' => array(
        'view' => 'site/content-layouts/empty-one.tpl' // mars: без обёртки для виджета <div class="bWidgetItemContainer">, для одного виджета, когда виджет — это страница.
    ),
    'left+main+header' => array(
        'view' => 'site/content-layouts/left-main-header.tpl'
    ),
    'left+center&split' => array(
        'view' => 'site/content-layouts/left-center_header-body_grid.tpl'
    ),
    'left+center+bottom' => array(
        'view' => 'site/content-layouts/left-center-bottom.tpl'
    ),
    'left-main-align-top-menu' => array(
        'view' => 'site/content-layouts/left-main-align-top-menu.tpl'
    ),
    'top-left-right' => array(
        'view' => 'site/content-layouts/top-left-right.tpl',
        'styles' => array(
            'site/content-layouts/layout-top-left-right.less',
        ),
    ),
    'left+center+right+bottom' => array(
        'view' => 'site/content-layouts/left_center_right_bottom.tpl',
        'styles' => array(
            'site/content-layouts/layout-left-center-right.less',
        ),
    ),
    'empty-full' => array(
        'view' => 'site/content-layouts/empty-full.tpl',
    ),

    // Whotrades project.
    'wt-header-body-wide' => array(
        'view' => 'site/projects/whotrades/content-layouts/layout-header-body-wide.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/header-body-wide/header-body-wide.less',
            'site/projects/whotrades/layouts/header-body-wide/header.styl',
        ),
    ),
    'wt-header-body-wide-smartlanding' => array(
        'view' => 'site/projects/whotrades/content-layouts/layout-header-body-wide-smartlanding.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/header-body-wide/header-body-wide.less',
            'site/projects/whotrades/layouts/header-body-wide/header.styl',
            'site/blocks/masonry/masonry-layout.styl',
        ),
    ),
    'wt-header-main-right-wide' => array(
        'view' => 'site/projects/whotrades/content-layouts/layout-header-main-right-wide.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/header-body-wide/header-body-wide.less',
            'site/projects/whotrades/layouts/header-body-wide/header.styl',
        ),
    ),
    'wt-header-body-wide-masonry' => array(
        'view' => 'site/projects/whotrades/content-layouts/layout-header-body-wide-masonry.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/header-body-wide/header-body-wide.less',
            'site/projects/whotrades/layouts/header-body-wide/header.styl',
            'site/blocks/masonry/masonry-layout.styl',
        ),
    ),
    'wt-header-body-wide-blogs' => array(
        'view' => 'site/projects/whotrades/content-layouts/layout-header-body-wide-blogs.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/header-body-wide/header-body-wide.less',
            'site/projects/whotrades/layouts/header-body-wide/header.styl',
            'site/projects/whotrades/layouts/header-body-wide/body.styl',
        ),
    ),
    'wt-header-main-right-wide-masonry' => array(
        'view' => 'site/projects/whotrades/content-layouts/layout-header-main-right-wide-masonry.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/header-body-wide/header-body-wide.less',
            'site/projects/whotrades/layouts/header-body-wide/header.styl',
            'site/blocks/masonry/masonry-layout.styl',
        ),
    ),
    'start' => array(
        'view' => 'site/projects/whotrades/content-layouts/start-page-layout.tpl',
        'styles' => array(
            'site/projects/whotrades/start-page/start-page.less'
        ),
        'scripts' => array(
            'site/projects/whotrades/start-page/globe-photos.js',
            'site/projects/whotrades/start-page/widget-switch.js',
        ),
    ),
    'profile' => array(
        'view' => 'site/projects/whotrades/content-layouts/profile.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/layout-profile.less',
        ),
    ),
    'strategies' => array(
        'view' => 'site/projects/whotrades/content-layouts/strategies.tpl',
        'styles' => array(
            'site/projects/whotrades/strategies/strategies-layout.less',
        ),
    ),
    'strategies-v2' => array(
        'view' => 'site/projects/whotrades/content-layouts/strategies-v2.tpl',
        'styles' => array(
            'site/projects/whotrades/strategies-v2/strategies-v2.styl',
            'site/projects/whotrades/strategies-v2/strategies-v2-layout.styl'
        ),
    ),
    'strategies-v2-main+right' => array(
        'view' => 'site/projects/whotrades/content-layouts/strategies-v2-main-right.tpl',
        'styles' => array(
            'site/projects/whotrades/strategies-v2/strategies-v2.styl',
            'site/projects/whotrades/strategies-v2/strategies-v2-layout.styl'
        ),
    ),
    'strategies-v2-centered' => array(
        'view' => 'site/projects/whotrades/content-layouts/strategies-v2-centered.tpl',
        'styles' => array(
            'site/projects/whotrades/strategies-v2/strategies-v2.styl',
            'site/projects/whotrades/strategies-v2/strategies-v2-layout.styl'
        ),
    ),
    'blogs' => array(
        'view' => 'site/projects/whotrades/content-layouts/blogs.tpl',
        'styles' => array(
            'site/modules/blogs/blogs-content-layout.less',
            'site/modules/blogs/blogs-tabs/blogs-tabs.less'
        ),
    ),
    'charts-1-col' => array(
        'view' => 'site/projects/whotrades/content-layouts/charts-layout-1-col.tpl',
        'styles' => array(
            'site/layouts/layout-charts.styl',
            'site/modules/blogs/blogs-tabs/blogs-tabs.less'
        ),
    ),
    'charts-2-col' => array(
        'view' => 'site/projects/whotrades/content-layouts/charts-layout-2-col.tpl',
        'styles' => array(
            'site/layouts/layout-charts.styl',
        ),
    ),
    'cabinet' => array(
        'view' => 'site/projects/whotrades/content-layouts/cabinet.tpl'
    ),
    'wt-empty-one' => array(
        'view' => 'site/projects/whotrades/content-layouts/empty-one.tpl'
    ),
    'wt-empty-title' => array(
        'view' => 'site/projects/whotrades/content-layouts/empty-title.tpl'
    ),

    'wt-search-result' => array(
        'view' => 'site/projects/whotrades/content-layouts/search-result.tpl'
    ),

    /**
     * Layout Search
     */
    'layout-search' => array(
        'view' => 'site/projects/whotrades/layouts/layout-search.tpl',
        'styles' => array(
            'ui/button/interface/flat.styl',
//            'site/projects/whotrades/modules/stripy/stripy.styl',
//            'site/blocks/masonry/masonry-two-column.styl',
            'site/projects/whotrades/modules/personal/personal.styl',
            'site/projects/whotrades/layouts/layout-search.styl',
//            'site/projects/whotrades/modules/personal/personal-dialoggy.styl',
        ),
//        'scripts' => array(
//
//        ),
    ),

    /*
     * The "Services" section.
     */
    'layout-services' => array(
        'view' => 'site/projects/whotrades/layouts/layout-services.tpl',
        'styles' => array(
            'site/projects/whotrades/nav/nav-bar.less',
            'site/projects/whotrades/modules/services-v2/services.styl',
        ),
        'scripts' => array(
            'site/projects/whotrades/nav/nav-bar.js',
            'site/projects/whotrades/go-to-wt-inc-popup/go-to-wt-inc-popup.js',
            '/site/projects/whotrades/modules/services-v2/services.js'
        ),
    ),

    'layout-services-old' => array(
        'view' => 'site/projects/whotrades/layouts/layout-services.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/services/services.styl',
            'site/projects/whotrades/modules/services/services-tile.styl',
            'site/projects/whotrades/nav/nav-bar.less',
            'site/widgets/cabinet-proxy-page/cabinet-proxy-page.less',
        ),
        'scripts' => array(
            'site/projects/whotrades/nav/nav-bar.js',
            'site/projects/whotrades/modules/services/services.js',
            'site/projects/whotrades/go-to-wt-inc-popup/go-to-wt-inc-popup.js',
        ),
    ),

    'layout-services-usa' => array(
        'view' => 'site/projects/whotrades/layouts/layout-services.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/services/services.styl',
            'site/projects/whotrades/modules/services-inc/services-inc.styl',
            'site/projects/whotrades/nav/nav-bar.less',
        ),
        'scripts' => array(
            'site/projects/whotrades/nav/nav-bar.js',
            '/site/projects/whotrades/modules/services-v2/services.js',
            'site/projects/whotrades/modules/services-inc/services-inc.js',
        ),
    ),

    /*
     * The "Markets" section.
     */
    'layout-markets' => array(
        'view' => 'site/projects/whotrades/layouts/layout-markets.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/layout-markets-default.styl',
            'site/projects/whotrades/layouts/layout-markets.styl',
        ),
    ),

    'layout-markets-tiles' => array(
        'view' => 'site/projects/whotrades/layouts/layout-markets-tiles.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/layout-markets-default.styl',
            'site/projects/whotrades/layouts/layout-markets.styl',
        ),
    ),

    'layout-markets-profile' => array(
        'view' => 'site/projects/whotrades/layouts/layout-markets-profile.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/layout-markets-default.styl',
            'site/projects/whotrades/layouts/layout-markets.styl',

            // @refactoring
            'site/projects/whotrades/modules/instruments/instruments-heatmap/instruments-heatmap.styl',
            'site/projects/whotrades/modules/instrument/instrument.styl',

            'site/projects/whotrades/modules/instruments/instruments-ticker.styl',
            'site/projects/whotrades/modules/instruments/instruments-forecast.styl',
            'site/projects/whotrades/modules/instruments/instruments-calendar.styl',
            'site/projects/whotrades/modules/instruments/instruments-event.styl',
        ),
        'scripts' => array(
            // @refactoring
            'site/projects/whotrades/modules/instruments/instruments-heatmap/instruments-heatmap.js',
            'site/projects/whotrades/modules/instruments/instruments-forecast.js',
            'site/projects/whotrades/modules/instruments/instruments-calendar.js',
            'site/projects/whotrades/modules/instruments/instruments-event.js',
            'site/projects/whotrades/modules/instruments/instruments-tiles.js',

            'vendor/jquery-autosize/jquery.autosize.js',
            'site/projects/whotrades/modules/instrument/instrument.js',
        ),
    ),

    /*
     * The "Personal" section.
     */
    'layout-personal' => array(
        'view' => 'site/projects/whotrades/layouts/layout-personal.tpl',
        'styles' => array(
            'ui/button/interface/flat.styl',
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/blocks/masonry/masonry-two-column.styl',
            'site/projects/whotrades/modules/personal/personal.styl',
            'site/projects/whotrades/layouts/layout-personal.styl',
            'site/projects/whotrades/modules/personal/personal-dialoggy.styl',
        ),
        'scripts' => array(
            'vendor/components/baconjs/dist/Bacon.js',
            'vendor/components/bacon.model/dist/bacon.model.js',
            'vendor/components/bacon.jquery/dist/bacon.jquery.js',
            'app/whotrades/components/request-manager/RequestManager.js',
            'app/whotrades/components/request-manager/CApiRequest.js',
            'site/projects/whotrades/modules/personal/personal-settings.js',
        )
    ),

    /*
     * The "Personal" section.
     */
    'layout-blogs' => array(
        'view' => 'site/projects/whotrades/layouts/layout-personal.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/personal/personal.styl',
            'site/projects/whotrades/layouts/layout-personal.styl',
        )
    ),

    /*
     * The "Landings" section.
     */
    'layout-landing-investolympic' => array(
        'view' => 'site/projects/whotrades/layouts/layout-landing-investolympic.tpl',
        'styles' => array(
            // Cuntdown for blue tile.
            'ui/countdown/countdown.styl',
            'ui/countdown/design/graphite.styl',

            'site/projects/whotrades/layouts/layout-landing-investolympic.styl',
            'site/projects/whotrades/modules/landings/landing-investolympic/landing-investolympic.styl',
        ),
        'scripts' => array(
            'site/projects/whotrades/modules/landings/landing-investolympic/landing-investolympic.js',
        ),
    ),

    // dz: #WTT-1070
    'layout-landing-indianolympic' => array(
        'view' => 'site/projects/whotrades/layouts/layout-landing-indianolympic.tpl',
        'styles' => array(
            // Cuntdown for blue tile.
            'ui/countdown/countdown.styl',
            'ui/countdown/design/graphite.styl',

            'site/projects/whotrades/layouts/layout-landing-indianolympic.styl',
            'site/projects/whotrades/modules/landings/landing-indianolympic/landing-indianolympic.styl',
        ),
        'scripts' => array(
            'site/projects/whotrades/modules/landings/landing-indianolympic/landing-indianolympic.js',
        ),
    ),


    'layout-landing' => array(
        'view' => 'site/projects/whotrades/layouts/layout-landing.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
        ),
    ),

    'layout-landing-stripes' => array(
        'view' => 'site/projects/whotrades/layouts/layout-landing-stripes.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
        ),
        'scripts' => array(),
    ),

    'demo-metatrader-4' => array(
        'view' => 'site/projects/whotrades/content-layouts/demo-metatrader-4.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/landings/landing-demo-account/landing-demo-account.styl',
            'site/projects/whotrades/nav/nav-bar.less'
        ),
        'scripts' => array(
            'site/projects/whotrades/nav/nav-bar.js'
        ),
    ),

    // Landings.
    'landing-10percent' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-10percent.tpl',
        'styles' => array(
            'site/projects/whotrades/page-landing-10percent/page-landing-10percent.less',
        ),
    ),
    'landing-islands' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-islands.tpl',
        'styles' => array(
            'site/projects/islands/landing-page/landing-page.less',
        ),
    ),
    'landing-learning' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-learning.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/learning/landing-page/landing-page.less',
        ),
    ),
    'landing-social' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-social.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/services/services.styl',
            'site/projects/whotrades/modules/landings/landing-social/landing-social.styl',
        ),
        'scripts' => array(
            'site/projects/whotrades/modules/landings/landing-social/landing-social.js',
        ),
    ),
    'landing-social-people' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-social-people.tpl'
    ),
    'landing-demo-forex' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-demo-forex.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/services/services.styl',
            'site/projects/whotrades/modules/landings/landing-demo-forex/landing-demo-forex.styl',
            'site/projects/whotrades/finam-certificates/finam-certificates.less',
        ),
    ),
    'landing-forex-50' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-forex-50.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/services/services.styl',
            'site/projects/whotrades/modules/landings/landing-forex-50/landing-forex-50.styl',
        ),
    ),
    'landing-webinar-gerchik-v1' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-webinar-gerchik.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/services/services.styl',
            'site/projects/whotrades/modules/services/services-tile.styl',
            'site/projects/whotrades/nav/nav-bar.less',
            'site/projects/whotrades/modules/services-v2/services.styl',
            'site/projects/whotrades/modules/landings/landing-webinar-gerchik/landing-webinar-gerchik.styl',

        ),
        'scripts' => array(
                'site/projects/whotrades/modules/landings/landing-webinar-gerchik/landing-webinar-gerchik.js',
        ),
    ),
    'landing-webinar-gerchik-v2' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-webinar-gerchik-v2.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/landings/landing-webinar-gerchik/landing-webinar-gerchik-v2.styl',

        ),
        'scripts' => array(
            'site/projects/whotrades/modules/landings/landing-webinar-gerchik/landing-webinar-gerchik.js',
        ),
    ),
    'landing-indian-webinar-v1' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-indian-webinar.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/landings/landing-indian-webinar/landing-indian-webinar.styl',

        ),
        'scripts' => array(
            'site/projects/whotrades/modules/landings/landing-indian-webinar/landing-indian-webinar.js',
        ),
    ),
    'landing-american-dream' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-american-dream.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/services/services.styl',
            'site/projects/whotrades/modules/services/services-tile.styl',
            'site/projects/whotrades/nav/nav-bar.less',
            'site/projects/whotrades/modules/services-v2/services.styl',
            'site/projects/whotrades/modules/landings/landing-american-dream/landing-american-dream.styl',
        ),
        'scripts' => array(
            'site/projects/whotrades/modules/landings/landing-american-dream/landing-american-dream.js',
        ),
    ),
    'landing-bonus-50' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-bonus-50.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/services/services.styl',
            'site/projects/whotrades/modules/services/services-tile.styl',
            'site/projects/whotrades/nav/nav-bar.less',
            'site/projects/whotrades/modules/services-v2/services.styl',
            'site/projects/whotrades/modules/landings/landing-bonus-50/landing-bonus-50.styl',
        ),
        'scripts' => array(
            'site/projects/whotrades/modules/landings/landing-bonus-50/landing-bonus-50.js',
        ),
    ),
    'landing-demo-mma' => array(
            'view' => 'site/projects/whotrades/content-layouts/landing-demo-mma.tpl',
            'styles' => array(
                    'site/projects/whotrades/modules/stripy/stripy.styl',
                    'site/projects/whotrades/modules/landings/landing-demo-mma/landing-demo-mma.styl',
            ),
    ),
    'landing-mma-book' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-mma_book.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/landings/landing-mma-book/landing-mma-book.styl',
        ),
    ),
    'landing-mma-book-v2' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-mma-book-v2.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/landings/landing-mma-book/landing-mma-book.styl',
        ),
    ),
    'landing-masterclass' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-masterclass.tpl',
        'styles' => array(
            'site/projects/whotrades/modules/stripy/stripy.styl',
            'site/projects/whotrades/modules/landings/landing-masterclass/landing-masterclass.styl',
        ),
    ),
    'landing-indian' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-indian.tpl',
        'styles' => array(
            'site/projects/whotrades/landing-indian/landing-indian.less',
        ),
        'scripts' => array(
            'site/projects/whotrades/landing-indian/landing-indian.js',
        ),
    ),
    'landing-change-fate-vote' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-change-fate-vote.tpl',
        'styles' => array(
            'site/projects/whotrades/landing-indian/landing-indian.less',
            'site/projects/whotrades/landing-indian/landing-indian-change-fate-vote.less',
        ),
        'scripts' => array(
            'site/projects/whotrades/landing-change-fate-vote/landing-change-fate-vote.js',
        ),
    ),
    'landing-indian-v2' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-indian-v2.tpl',
        'styles' => array(
            'site/projects/whotrades/landing-indian/landing-indian-v2.less',
        ),
        'scripts' => array(
            'site/projects/whotrades/landing-indian/landing-indian-v2.js',
        ),
    ),

    'landing-indian-v2-result' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-indian-v2-result.tpl',
        'styles' => array(
            'site/projects/whotrades/landing-indian/landing-indian-v2.less',
        ),
        'scripts' => array(
            'site/projects/whotrades/landing-indian/landing-indian-v2-result.js',
        ),
    ),

    'landing-indian-vote' => array(
        'view' => 'site/projects/whotrades/content-layouts/landing-indian-vote.tpl',
        'styles' => array(
            'site/projects/whotrades/landing-indian/landing-indian.less',
        ),
        'scripts' => array(
            'site/projects/whotrades/landing-indian/landing-indian.js',
        ),
    ),

    'blogstar-contest' => array(
        'view' => 'site/projects/whotrades/content-layouts/blogstar-contest.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/layout-landing-blogstar.styl',
        ),
    ),
    'blogstar-contest-landing' => array(
        'view' => 'site/projects/whotrades/content-layouts/blogstar-contest-landing.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/layout-landing-blogstar.styl',
        ),
        'scripts' => array(
            'site/projects/whotrades/layouts/layout-landing-blogstar.js',
        ),
    ),
    'moderator-rules' => array(
        'view' => 'site/static/managed/Comon/moderator-rules.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/moderator-rules.styl',
        ),
    ),

    'layout-static' => array(
        'view' => 'site/projects/whotrades/layouts/layout-static.tpl',
        'styles' => array(
            'site/projects/whotrades/layouts/layout-static.styl',
        )
    ),

    /*
     * The "Exotic Options" section.
     */
    'layout-landing-earnings' => array(
        'view' => 'site/projects/exotic-options/content-layouts/layout-landing-earnings.tpl',
        'styles' => array(
            'site/projects/exotic-options/layouts/layout-landing-earnings.less'
        ),
    ),

    /*
     * The "ChinaEdu ChinaEdu" section.
     */
    'edu-china-main' => array(
        'view' => 'site/projects/edu-china/content-layouts/edu-china-layout-main.tpl'
    ),
    'edu-china-internal' => array(
        'view' => 'site/projects/edu-china/content-layouts/edu-china-layout-internal.tpl',
        'styles' => array('site/projects/edu-china/content-layouts/edu-china-layout-internal.styl'),
    ),
    'edu-china-one-column' => array(
        'view' => 'site/projects/edu-china/content-layouts/edu-china-layout-one-column.tpl',
        'styles' => array('site/projects/edu-china/content-layouts/edu-china-layout-one-column.styl'),
    ),

    /*
     * The "Sites on platforms" section.
     */
    'lichfin' => array(
        'view' => 'site/projects/lichfin/content-layouts/default.tpl'
    ),
    'exotic-options-promo' => array(
        'view' => 'site/projects/exotic-options-promo/content-layouts/default.tpl'
    ),
    'sipi-index-guess' => array(
        'view' => 'site/projects/sipi-index-guess/sipi-index-guess-layout.tpl'
    ),
    'mikola' => array(
        'view' => 'site/projects/mikola/mikola-layout.tpl'
    ),
);

// @remove
$this->layouts['wt-services'] = $this->layouts['layout-services-old']; // in release-52

# iv: WHO-3344
$this->clientSideHtmlTemplatesHash = null;

/**
 * The video collection.
 *
 * Example:
 *     'name' => array(
 *         'lang' => array('id' => 'Video ID', 'h' => 'hosting: vimeo, youku, youtube')
 *     )
 */
$this->video = array(
    'trading-guide' => array(
        "en" => array("id" => "zlFiYqDXb98"),
        "th" => array("id" => "JZVuHwhh58k"),
        "zh" => array("id" => "XNTUzMTg2ODY0", "h" => "youku"),
        "es" => array("id" => "YazytnFNfzQ"),
        "ar" => array("id" => "Bs3xLemCI-Q"),
    ),
    'trading-app-metatrader-whotrades' => array(
        "en" => array("id" => "NJHN0JzIfp4"),
        "th" => array("id" => "BYo8xqRDYX8"),
        "zh" => array("id" => "XNDUyODEzNjM2", "h" => "youku"),
        "es" => array("id" => "o-jpbaJ53YU"),
        "ar" => array("id" => "y-RfzVf42D4")
    ),
    'faq-video' => array(
        "en" => array(
            array("id" => "dRdF17xklXI", "duration" => "1:26", "titleDicWord" => "faq_video_1_title"),
            array("id" => "nPcWCzsee08", "duration" => "2:37", "titleDicWord" => "faq_video_2_title"),
            array("id" => "e-LBXNATsF8", "duration" => "2:34", "titleDicWord" => "faq_video_3_title"),
        ),
        "th" => array(
            array("id" => "Ue9pu07oTdk", "duration" => "1:15", "titleDicWord" => "faq_video_1_title"),
            array("id" => "-ljgt0O6pkY", "duration" => "3:00", "titleDicWord" => "faq_video_2_title"),
            array("id" => "YXnCVkaC0j4", "duration" => "2:22", "titleDicWord" => "faq_video_3_title"),
        ),
        "zh" => array(
            array("id" => "6MulfasGYY0", "duration" => "1:20", "titleDicWord" => "faq_video_1_title"),
            array("id" => "OLm64xPYHEA", "duration" => "1:49", "titleDicWord" => "faq_video_2_title"),
            array("id" => "JCeIEHUsqt4", "duration" => "1:21", "titleDicWord" => "faq_video_3_title"),
        ),
        "es" => array(
            array("id" => "04VHC8a0Y3Y", "duration" => "1:10", "titleDicWord" => "faq_video_1_title"),
            array("id" => "8G-Z7cxpWNY", "duration" => "3:15", "titleDicWord" => "faq_video_2_title"),
            array("id" => "UOmDtkB-EWg", "duration" => "2:34", "titleDicWord" => "faq_video_3_title"),
        ),
        "ar" => array(
            array("id" => "VQrZjLM3i4k", "duration" => "1:46", "titleDicWord" => "faq_video_ar_1_title"),
            array("id" => "GwEfgvbc9t8", "duration" => "5:01", "titleDicWord" => "faq_video_ar_2_title"),
            array("id" => "y58hnE0IEe4", "duration" => "6:34", "titleDicWord" => "faq_video_ar_3_title"),
            array("id" => "y-RfzVf42D4", "duration" => "2:44", "titleDicWord" => "faq_video_ar_4_title"),
        ),
    ),
    'exotic-options-android' =>  array(
        'ru' => array("id" => "LX5EKstRYjc"),
        'en' => array("id" => "7I_3PAAMfCs"),
    ),
    'exotic-options-all' =>  array(
        'ru' => array("id" => "XsBUCU6qGgs"),
        'en' => array("id" => "Q87qudG0vcM"),
    ),
    'landing-blogstar' =>  array(
        "en" => array("id" => "AJmLPZjplBE"),
//       "zh" => array("id" => "XNTUzMTg2ODY0", "h" => "youku"),
        "ru" => array("id" => "AJmLPZjplBE"),
    ),
    'mma-book' =>  array(
        'ru' => array("id" => "xDj3CJAjHuQ"),
        'en' => array("id" => "xDj3CJAjHuQ"),
    ),
    'webinar-gerchik' =>  array(
        'en' => array("id" => "YTdyUa9exGc"),
    ),
    'services' => array(
        "en" => array(
            array("id" => "H2k3c76ijxA", "titleDicWord" => "services__index__video_item_1"),
            array("id" => "Fv_ik0WfwgE", "titleDicWord" => "services__index__video_item_2"),
            array("id" => "SinCOtXD9w4", "titleDicWord" => "services__index__video_item_3"),
            array("lnkName" => "exotic_options__earnings", "titleDicWord" => "services__index__video_item_4"),
            array("id" => "kJSqfJ6AMho", "titleDicWord" => "services__index__video_item_5"),
        ),
        "ru" => array(
            array("id" => "ZyswzVW1rnA", "titleDicWord" => "services__index__video_item_1"),
            array("id" => "QRQS2n9vnEU", "titleDicWord" => "services__index__video_item_2"),
            array("id" => "bw9TYC9mXD0", "titleDicWord" => "services__index__video_item_3"),
            array("lnkName" => "exotic_options__earnings", "titleDicWord" => "services__index__video_item_4"),
            array("id" => "xDj3CJAjHuQ", "titleDicWord" => "services__index__video_item_5"),
        ),
    ),
    'indian-olypic' =>  array(
        'en' => array("id" => "28bsmGeiPDQ"),
    ),
);

// azw: url game islands #WHO-3855
$this->islands_game_iframe_url = "http://free-client-ostrova.finam.ru?locale=en&platform=wt";

// al: pagename or module:contexts list to enabled prototype #WTS-864
//     1. urlMapExoticOptions is free
//     2. urlMapWhotradesUsa is free
//     3. urlMapInstruments is free
//     4. urlMapCharts is free
//     5. urlMapBlogs is free
//     6. urlMapServices is free
//     7. urlMapMessages is free
//     8. urlMapCommonRu is free
//     9. urlMapCabinet is free
//     10. urlMap is free
$this->protofuck = array(
    // pagename
    'messages_person_json' => true,
    'messages_json' => true,
    'groups_item_photos_upload' => true,            // @page /photos/upload/
    'groups_item_applications' => true,             // @page /applications

    // module:contexts
    'Groups:edit' => true,                          // @page /groups/create
    'Messages:default' => true,                     // @page /messages
    'Messages:item' => true,                        // @page /messages/#id#
    'GroupsItemPeople:item' => true,                // @page /people/me/old
    'Comon:accounts_item' => true,                  // @page /people/me/accounts/#market# or /trade/v1
    'Comon:accounts_item_clients' => true,          // @page /people/me/accounts/#market#/clients
    'Comon:accounts_manager' => true,               // @page /settings/accounts/*
    'Comon:profile_settings_privacy' => true,       // @page /settings/profile/privacy
    'GroupsItemPeople:edit' => true,                // @page /settings/profile
    'GroupsItemInvite:nevada' => true,              // @page /invite
    'Comon:friends' => true,                        // @page /friends

    'Photos:default' => true,                       // @page /photos
    'Photos:photos' => true,                        // @page /photos
    'Photos:photos_filter' => true,                 // @page /photos/latest
    'Photos:photos_my_filter' => true,              // @page /photos/my/filter
    'Photos:edit' => true,                          // @page /photos/edit

    'Activity:default' => true,                     // @page /activity

    'ComonCabinet:trading' => true,
    'ComonCabinet:trading_go_cabinet_trade' => true,
    'ComonCabinet:trading_select' => true,
    'ComonCabinet:trading_account_change_password' => true,
    'ComonCabinet:trading_account_change_password_sms' => true,
);
?>
