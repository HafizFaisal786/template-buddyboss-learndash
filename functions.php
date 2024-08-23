<?php
/**
 * @package BuddyBoss Child
 * The parent theme functions are located at /buddyboss-theme/inc/theme/functions.php
 * Add your own functions at the bottom of this file.
 */


/****************************** THEME SETUP ******************************/
/*
 * Internal Function for Fluent Forms Custom Slug
 * Do not EDIT this function
 */
function customFfLandingPageSlug($slug)
{
    add_action('init', function () use ($slug) {
        add_rewrite_endpoint($slug, EP_ALL);
    });
    add_action('wp', function () use ($slug) {
        global $wp_query;
        if (isset($wp_query->query_vars[$slug])) {
            $formString = $wp_query->query_vars[$slug];
            if (!$formString) {
                return;
            }
            $array = explode('/', $formString);

            $formId = $array[0];

            if (!$formId || !is_numeric($formId)) {
                return;
            }

            $secretKey = '';
            if (count($array) > 1) {
                $secretKey = $array[1];
            }

            $paramKey = apply_filters('fluentform/conversational_url_slug', 'fluent-form');

            $_GET[$paramKey] = $formId;
            $_REQUEST[$paramKey] = $formId;

            $request = wpFluentForm('request');
	    $request->set($paramKey, $formId);
	    $request->set('form', $secretKey);
        }
    });
}

/*
 * Creating custom slug for conversational form landing page
 *
 * my-forms is your custom slug for the form
 * if your form id is 123 then the landing page url will be then
 * https://your-domain.com/my-forms/123
 * if you use Security Code on conversational form then the url will be
 * https://your-domain.com/my-forms-x/123/SECURITY-CODE
 *
 * After paste the code to your theme's functions.php file please re-save the permalink settings
*/

customFfLandingPageSlug('beta-testing-invite');


/**
 * Sets up theme for translation
 *
 * @since BuddyBoss Child 1.0.0
 */
function buddyboss_theme_child_languages()
{
  /**
   * Makes child theme available for translation.
   * Translations can be added into the /languages/ directory.
   */

  // Translate text from the PARENT theme.
  load_theme_textdomain( 'buddyboss-theme', get_stylesheet_directory() . '/languages' );

  // Translate text from the CHILD theme only.
  // Change 'buddyboss-theme' instances in all child theme files to 'buddyboss-theme-child'.
  // load_theme_textdomain( 'buddyboss-theme-child', get_stylesheet_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'buddyboss_theme_child_languages' );

/**
 * Enqueues scripts and styles for child theme front-end.
 *
 * @since Boss Child Theme  1.0.0
 */
function buddyboss_theme_child_scripts_styles()
{
  /**
   * Scripts and Styles loaded by the parent theme can be unloaded if needed
   * using wp_deregister_script or wp_deregister_style.
   *
   * See the WordPress Codex for more information about those functions:
   * http://codex.wordpress.org/Function_Reference/wp_deregister_script
   * http://codex.wordpress.org/Function_Reference/wp_deregister_style
   **/

  // Styles
  wp_enqueue_style( 'buddyboss-child-css', get_stylesheet_directory_uri().'/assets/css/custom.css' );

  // Javascript
  wp_enqueue_script( 'buddyboss-child-js', get_stylesheet_directory_uri().'/assets/js/custom.js' );
}
add_action( 'wp_enqueue_scripts', 'buddyboss_theme_child_scripts_styles', 9999 );


/****************************** CUSTOM FUNCTIONS ******************************/

// Add your own custom functions here

add_action( 'woocommerce_payment_complete', 'custom_auto_complete_order' );
function custom_auto_complete_order( $order_id ) {
    if ( ! $order_id ) {
        return;
    }

    $order = wc_get_order( $order_id );

    // Only for orders with "Processing" status
    if ( $order->get_status() == 'processing' ) {
        $order->update_status( 'completed' );
    }
}

// __    __  ____  ____   __   ____  _  _ 
// (  )  (  )(  _ \(  _ \ / _\ (  _ \( \/ )
// / (_/\ )(  ) _ ( )   //    \ )   / )  / 
// \____/(__)(____/(__\_)\_/\_/(__\_)(__/   

function custom_theme_setup() {
    // Register a new image size
    add_image_size('custom-thumbnail', 300, 169, true); // Adjust width and height as needed, with cropping enabled
}
add_action('after_setup_theme', 'custom_theme_setup');

function show_current_user_purchased_tutorials() {
    if (is_page('my-tutorials')) {
        $current_user = wp_get_current_user();
        $purchased_tutorials = wc_get_orders(array(
            'customer_id' => $current_user->ID,
            'status' => array('completed', 'processing')
        ));

        if (!empty($purchased_tutorials)) {
            echo '<div id="library-dev-content">';
            echo "<div class='related-posts-grid-library-dev'>";

            foreach ($purchased_tutorials as $order) {
                $order_items = $order->get_items();
                foreach ($order_items as $item) {
                    $product_id = $item->get_product_id();
                    $product = wc_get_product($product_id);

                    if ($product) {
                        $product_tags = wp_get_post_terms($product_id, 'product_tag', array('fields' => 'slugs'));
                        if (!empty($product_tags)) {
                            show_posts_by_tags($product_tags);
                        }
                    }
                }
            }

            echo '</div>'; // Close related-posts-grid-library-dev
            echo '</div>'; // Close library-dev-content
        } else {
            echo "<p>" . esc_html__("You haven't purchased any tutorials yet.", "text-domain") . "</p>";
        }
    }
}

function show_posts_by_tags($tags) {
    $args = array(
        'tag' => implode(',', array_map('sanitize_text_field', $tags)),
        'posts_per_page' => 5,
    );

    $related_posts = new WP_Query($args);

    if ($related_posts->have_posts()) {
        while ($related_posts->have_posts()) {
            $related_posts->the_post();
            ?>
            <div class="elementor-post__card">
                <a class="elementor-post__thumbnail__link" href="<?php the_permalink(); ?>" tabindex="-1">
                    <div class="elementor-post__thumbnail elementor-fit-height">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('custom-thumbnail', ['loading' => 'lazy', 'decoding' => 'async']); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/path/to/default-image.jpg'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" decoding="async" width="300" height="169">
                        <?php endif; ?>
                    </div>
                </a>
                <div class="elementor-post__text">
                    <h3 class="elementor-post__title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <a class="elementor-post__read-more" href="<?php the_permalink(); ?>" aria-label="<?php printf(esc_attr__('Read more about %s', 'text-domain'), get_the_title()); ?>" tabindex="-1">
                        <?php esc_html_e('View Tutorial', 'text-domain'); ?>
                    </a>
                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo "<p>" . esc_html__("No related posts found.", "text-domain") . "</p>";
    }
}

add_action('wp_footer', 'show_current_user_purchased_tutorials');


// Register Custom Post Types for HELP and BONUS
function create_custom_post_types() {
    // Custom post type for HELP
    register_post_type('help_content',
        array(
            'labels' => array(
                'name'                  => __('Help Content'),
                'singular_name'         => __('Help Content'),
                'menu_name'             => __('Help Content'),
                'name_admin_bar'        => __('Help Content'),
                'add_new'               => __('Add New'),
                'add_new_item'          => __('Add New Help Content'),
                'new_item'              => __('New Help Content'),
                'edit_item'             => __('Edit Help Content'),
                'view_item'             => __('View Help Content'),
                'all_items'             => __('All Help Content'),
                'search_items'          => __('Search Help Content'),
                'not_found'             => __('No Help Content found.'),
                'not_found_in_trash'    => __('No Help Content found in Trash.'),
            ),
            'public'              => true,
            'has_archive'         => true,
            'supports'            => array('title', 'editor'),
            'show_in_rest'        => true,
            'rewrite'             => array('slug' => 'help-content'),
        )
    );

    // Custom post type for BONUS
    register_post_type('bonus_content',
        array(
            'labels' => array(
                'name'                  => __('Bonus Content'),
                'singular_name'         => __('Bonus Content'),
                'menu_name'             => __('Bonus Content'),
                'name_admin_bar'        => __('Bonus Content'),
                'add_new'               => __('Add New'),
                'add_new_item'          => __('Add New Bonus Content'),
                'new_item'              => __('New Bonus Content'),
                'edit_item'             => __('Edit Bonus Content'),
                'view_item'             => __('View Bonus Content'),
                'all_items'             => __('All Bonus Content'),
                'search_items'          => __('Search Bonus Content'),
                'not_found'             => __('No Bonus Content found.'),
                'not_found_in_trash'    => __('No Bonus Content found in Trash.'),
            ),
            'public'              => true,
            'has_archive'         => true,
            'supports'            => array('title', 'editor'),
            'show_in_rest'        => true,
            'rewrite'             => array('slug' => 'bonus-content'),
        )
    );


}
add_action('init', 'create_custom_post_types');

function display_bonus_data($atts) {
    $atts = shortcode_atts(
        array(
            'id' => '',
        ),
        $atts,
        'bonus_data'
    );

    if (empty($atts['id'])) {
        return 'No BONUS data ID provided.';
    }
    $post_id = intval($atts['id']);
    $post = get_post($post_id);

    if ($post && $post->post_type === 'bonus_data') {
        $field_value = get_field('additional_challenges', $post_id);
        
        if ($field_value) {
            return do_shortcode($field_value);
        } else {
            return 'No content found in the specified ACF field.';
        }
    }
    return 'Invalid BONUS data ID or post type.';
}
add_shortcode('bonus_data', 'display_bonus_data');


// Shortcode to display HELP content
function display_help_content($atts) {
    $atts = shortcode_atts(
        array(
            'id' => '',
        ),
        $atts,
        'help_content'
    );

    if (empty($atts['id'])) {
        return 'No HELP content ID provided.';
    }

    $post_id = intval($atts['id']);
    $post = get_post($post_id);

    if ($post && $post->post_type === 'help_content') {
        $post_content = $post->post_content;
        
        if ($post_content) {
            return do_shortcode($post_content);
        } else {
            return 'No content found in the specified post.';
        }
    }

    return 'Invalid HELP content ID or post type.';
}
add_shortcode('help_content', 'display_help_content');


// Shortcode to display BONUS content
function display_bonus_content($atts) {
    $atts = shortcode_atts(
        array(
            'id' => '',
        ),
        $atts,
        'bonus_content'
    );
    if (empty($atts['id'])) {
        return 'No BONUS content ID provided.';
    }
    $post_id = intval($atts['id']);
    $post = get_post($post_id);
    if ($post && $post->post_type === 'bonus_content') {
        $post_content = $post->post_content;
        
        if ($post_content) {
            return do_shortcode($post_content);
        } else {
            return 'No content found in the specified post.';
        }
    }

    return 'Invalid BONUS content ID or post type.';
}
add_shortcode('bonus_content', 'display_bonus_content');



// Handle loading notes via AJAX
function load_slide_notes() {
    check_ajax_referer('notes_nonce', 'nonce');

    if (isset($_POST['post_id']) && is_user_logged_in()) {
        $post_id = intval($_POST['post_id']);
        $current_user_id = get_current_user_id();

        $warmup_notes = get_user_meta($current_user_id, '_warmup_notes_' . $post_id, true);
        $challenge_notes = get_user_meta($current_user_id, '_challenge_notes_' . $post_id, true);
        $play_notes = get_user_meta($current_user_id, '_play_notes_' . $post_id, true);

        wp_send_json(array(
            'success' => true,
            'data' => array(
                'warmup' => $warmup_notes,
                'challenge' => $challenge_notes,
                'play' => $play_notes,
            )
        ));
    } else {
        wp_send_json_error(array('message' => 'Invalid request or user not logged in.'));
    }
}
add_action('wp_ajax_load_slide_notes', 'load_slide_notes');

// Handle saving notes via AJAX
function save_slide_notes() {
    check_ajax_referer('notes_nonce', 'nonce');

    if (isset($_POST['post_id'], $_POST['notes_content'], $_POST['note_type']) && is_user_logged_in()) {
        $post_id = intval($_POST['post_id']);
        $notes_content = sanitize_textarea_field($_POST['notes_content']);
        $note_type = sanitize_text_field($_POST['note_type']);
        $current_user_id = get_current_user_id();
        $valid_note_types = array('warmup', 'challenge', 'play');
        
        if (!in_array($note_type, $valid_note_types)) {
            wp_send_json_error(array('message' => 'Invalid note type.'));
            return;
        }
        
        $meta_key = '_' . $note_type . '_notes_' . $post_id;
        update_user_meta($current_user_id, $meta_key, $notes_content);

        wp_send_json_success(array('message' => ucfirst($note_type) . ' notes saved successfully.'));
    } else {
        wp_send_json_error(array('message' => 'Invalid request or user not logged in.'));
    }
}
add_action('wp_ajax_save_slide_notes', 'save_slide_notes');

function enqueue_my_scripts() {
    wp_enqueue_script('journey-template-script', get_stylesheet_directory_uri() . '/assets/js/journey-template.js', array('jquery'), null, true);

    $nonce = wp_create_nonce('notes_nonce');
    wp_localize_script('journey-template-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => $nonce
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_my_scripts');








