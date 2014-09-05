<?php
$this->ratingSystem = array(

    'DB' => array(
        'Connection' => 'DSN_DB3',
    ),

    'calculators' => array(

        'blogPost' => array(

            // va: those are default values, real ones are taken from kvdpp
            'factors' => array(
                'comments'    => 5,
                'shares'      => 2,
                'votesScore'  => 0.5,
                'userPosts'   => 0.5,

                'z' => 1,
                'v' => 10,

                //'accountType' => 0,
                //'userScore'   => 0,
                //'scoreTimeCorrected' => 4500000,
            ),
            'minMaxValues' => array(
                'comments'    => array(0, 2300),
                'shares'      => array(0, 200),
                //'score'       => array(-300, 300),
                'userPosts'   => array(0, 1000),
                //'accountType' => array(0, 2),
                //'userScore'   => array(0, 200000),
            ),
        ),

        'comment' => array(
            'factors' => array(
                'lastRatingValue'    => 1,
                'personRating'       => 0.1,
                'scoreValue'         => 1,
            ),

            'minMaxValues' => array()
        ),

        'chartPost' => array(
            'factors' => array(
                'plusVotingValue'    => 1,
                'minusVotingValue'       => 1
            ),

            'minMaxValues' => array()
        ),

        'personChartPost' => array(
            'factors' => array(
                'plusVotingValueTotal'    => 1,
                'plusVotingValue'       => 1,
                'minusVotingValueTotal' => 1,
            ),

            'minMaxValues' => array()
        )
    ),
);