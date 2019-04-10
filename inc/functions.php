<?php

if( ! defined( 'ABSPATH' ) )
    exit;


function learnpress_render_user_badge( $user_id = 0 ) {
    if( ! function_exists( 'mycred_get_users_total_balance' ) ) 
        return false;

	$user = learn_press_get_current_user();
    $user_id = $user->get_id();
    if( function_exists('bp_is_active') ) {
        $user_id = bp_displayed_user_id();
    }
    $points = mycred_get_users_balance( $user_id );
    $badge  = false;
    $max_points = 10000;

    $ranks = apply_filters( 'learnpress_user_badge_ranks', array(

        'beginner'  => array(

            'title'         => __( 'Beginner', 'learnpress' ),
            'threshhold'    => 1000

        ),
        'intermediate'  => array(

            'title'         => __( 'Intermediate', 'learnpress' ),
            'threshhold'    => 5000

        ),
        'advanced'  => array(

            'title'         => __( 'Advanced', 'learnpress' ),
            'threshhold'    => 10000

        )

    ) );

    foreach ($ranks as $key => $rank) {
        
        if( $points <= $rank['threshhold'] ) {

            $badge = $rank['title'];

            break;

        } else if( $points > $max_points ) {

            $badge = __( 'Expert', 'learnpress' );

        }

    }

    $badge = apply_filters( 'learnpress_user_badge_label', $badge, $user_id, $points );

    if( ! $badge )
        return false;
        
    $percent = number_format( $points / $max_points, 2 ) * 100;

    if( ! $percent ) {
        return false;
    }

    ob_start();
    ?>

    <div class="bo-badge <?php echo strtolower( $badge ); ?> star">
        <span class="ribbon"><span><?php print esc_html( $badge ); ?></span></span>
        <div class="progressbar ldBar" data-preset="circle" data-value="<?php print $percent; ?>" data-stroke-width="4" data-stroke="#f16767" data-stroke-trail-width="4" data-stroke-trail="#f3ba49">
            <h4 class="lpub-total-points"><?php echo $points; ?></h4>
        </div>
    </div>

    <?php

    echo apply_filters( 'learnpress_get_user_badge', ob_get_clean(), $user_id, $badge, $points );
}