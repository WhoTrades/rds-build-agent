<?php 
$this->uploadSystem['physicalLocationDir'] = '/var/tmp/upload/';
$this->uploadSystem['torrentsLocationDir'] = '/var/tmp/torrent/';

$this->uploadSystem['signatureSalt'] = 'abrvalg'; 

$this->uploadSystem['maxFileSize']['default'] = 1 * 1024 * 1024 * 1024; // 1 Gb
$this->uploadSystem['maxFileSize']['developer'] = 2 * 1024 * 1024 * 1024; // 2 Gb (it must correlate with nginx and php and apache configs)

$this->uploadSystem['maxAudioFileSize']['default'] = 50 * 1024 * 1024; // 50 Mb
$this->uploadSystem['maxAudioFileSize']['developer'] = 50 * 1024 * 1024; // 50 Mb (it must correlate with nginx and php and apache configs)

$this->uploadSystem['torrent']['maxFilesCount'] = 200;
$this->uploadSystem['torrent']['maxTotalSize'] = 50 * 2 * 1024 * 1024 * 1024; // 100 Gb
$this->uploadSystem['torrent']['maxItemSize'] = 2 * 1024 * 1024 * 1024; // 2 Gb

$this->uploadSystem['photo']['sizes'] = array(
    'original' => array(
        'width' => 1280,
        'height' => 1280,
    ),
    'huge' => array(
        'width' => 1024,
        'height' => 1024,
    ),
    'big' => array(
        'width' => 480,
        'height' => 640,
    ),
    'medium' => array(
        'width' => 120,
        'height' => 120,
        'needSharp' => true,
    ),
    'medium_square' => array(
        'method' => 'quadratize',
        'width' => 120,
        'height' => 120,
        'size' => 120,
        'needSharp' => true
    ),
    'small' => array(
        'method' => 'quadratize',
        'width' => 48,
        'height' => 48,
        'size' => 48,
        'needSharp' => true,
    ),
    'xsmall' => array(
        'method' => 'quadratize',
        'width' => 24,
        'height' => 24,
        'size' => 24,
        'needSharp' => true,
    ),
    'xmedium' => array(/*person*/
        'method' => 'quadratize',
        'width' => 74,
        'height' => 74,
        'size' => 74,
        'needSharp' => true,
    ),
    'icon' => array(
        'method' => 'quadratize',
        'width' => 16,
        'height' => 16,
        'size' => 16,
        'needSharp' => true,
    ),
    

    'person_main' => array(/*person*/
        'method' => 'horizontalize',
        'width' => 200,
        'height' => 1000,
    ),
    'person_normal' => array(/*person*/
        'method' => 'horizontalize',
        'width' => 120,
        'height' => 600,
        'needSharp' => true,
    ),

    'blogpost' => array(/* attach_blogpost */
        'width' => 720,
        'height' => 720,
        'needSharp' => true
    ),

    'group_main' => array(/*group*/
        'width' => 160,
        'height' => 320,
        'needSharp' => true
    ),
	'group_xmedium' => array(/*group*/
        'method' => 'quadratize',
		'width' => 60,
        'height' => 60,
		'size' => 60,
        'needSharp' => true,
    ),

    'group_logo_asis' => array(/*group_logo, promo_badge*/
        'method' => 'asis',
        'width' => 450,
        'height' => 200,
        'strict' => false,
    ),
    'group_logo_main' => array(/*group_logo*/
        'width' => 160,
        'height' => 320,
        'needSharp' => true
    ),
    'group_logo_little' => array(/*group_logo, promo_badge*/
        'method' => 'asis',
        'width' => 120,
        'height' => 120,
        'strict' => false,
    ),
    'group_logo_xlittle' => array(/*group_logo, promo_badge*/
        'method' => 'asis',
        'width' => 75,
        'height' => 75,
        'strict' => false,
    ),
    
    'place_main' => array(/*place*/
        'width' => 400,
        'height' => 160,
        'needSharp' => true
    ),
    'place_little' => array(/*place*/
        'width' => 70,
        'height' => 140,
        'needSharp' => true,
    ),
    'place_xlittle' => array(/*place*/
        'width' => 48,
        'height' => 48,
        'needSharp' => true,
    ),    

    'comment_pnormal' => array(/*comment*/
        'method' => 'horizontalize',
        'width' => 300,
        'height' => 300,
        'needSharp' => true,
    ),
    'comment_gpnormal' => array(/*comment*/
        'method' => 'horizontalize',
        'width' => 300,
        'height' => 300,
        'needSharp' => true,
    ),    
    
    'video_little' => array(
        'width' => 160,
        'height' => 120,
        'needSharp' => true,
    ),
    'video_xlittle' => array(
        'width' => 97,
        'height' => 75,
        'needSharp' => true,
    ),

    //charts
    'charts_small' => array(
        'width' => 240,
        'height' => 120,
    ),
);