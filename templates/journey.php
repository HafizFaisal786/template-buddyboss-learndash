<?php
/**
 * Template Name: Journey Template
 * Template Post Type: post, page
 */

?>

<?php
   get_header(); 
?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/journey-template.css">

<?php

function isSafari() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') === false) {
        return true;
    }
    return false;
   }

?>

<style type="text/css">

</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<?php
   global $wpdb;
   $games = array();
   $all_courses = array();
   $user_id = get_current_user_id();
   $last_completed_id = '';
   $latest_course_to_read_id = '';
   $context = ( isset( $context ) ? $context : 'learndash' );
   $courses_query = "
      SELECT p.ID, p.post_name, p.post_title, p.post_content, p.post_status FROM wp_posts p LEFT JOIN wp_postmeta pm ON p.ID = pm. post_id AND pm.meta_key = '_sfwd-courses' WHERE p.post_type = 'sfwd-courses' AND p.post_status = 'publish' AND p.ID IN (SELECT    REPLACE(meta_key, 'course_completed_', '') FROM wp_usermeta WHERE user_id = ".$user_id." AND meta_key LIKE 'course_completed_%');   ";


   $query = $wpdb->prepare($courses_query);
   $results = $wpdb->get_results($query);

   foreach ($results as $result) {
      $last_completed_id = $result->ID;
      $games[] = array('id' => $result->ID);
   }
   $games_json = json_encode($games);
   $latest_course_to_read = "
      SELECT p.ID, p.post_name, p.post_title, p.post_content, p.post_status FROM wp_posts p LEFT JOIN wp_postmeta pm ON p.ID = pm. post_id AND pm.meta_key = '_sfwd-courses' WHERE p.post_type = 'sfwd-courses'  AND p.post_status = 'publish' AND p.ID > (".  $last_completed_id.") LIMIT 1;";
   $query_read = $wpdb->prepare($latest_course_to_read);
   $results_read = $wpdb->get_results($query_read);

   foreach ($results_read as $result_read) {;
      $latest_course_to_read_id = $result_read->post_name;
   }
   $category_first_query = "
      SELECT p.ID, p.post_name, p.post_title, p.post_content, p.post_status FROM wp_posts p LEFT JOIN wp_postmeta pm ON p.ID = pm. post_id AND pm.meta_key = '_sfwd-courses' LEFT JOIN wp_term_relationships tr ON p.ID = tr.object_id LEFT JOIN wp_term_taxonomy tt    ON tr.term_taxonomy_id = tt.term_taxonomy_id LEFT JOIN wp_terms t ON tt.term_id = t.term_id WHERE p.post_type = 'sfwd-courses'   AND p.post_status = 'publish' AND t.name = '1ai'";

   $categoryquery = $wpdb->prepare($category_first_query);
   $category_first_results = $wpdb->get_results($categoryquery);

   foreach ($category_first_results as $result) {
      $first_complete_courses[] = $result->ID;
   }

   $first_completecourses = json_encode($first_complete_courses);
   $allcourses_query = "
      SELECT p.ID, p.post_name, p.post_title, p.post_content, p.post_status FROM wp_posts p LEFT JOIN wp_postmeta pm1 ON p.ID = pm1.  post_id AND pm1.meta_key = '_sfwd-courses'
      LEFT JOIN wp_postmeta pm2 ON p.ID = pm2.post_id AND pm2.meta_key = 'course_order' WHERE p.post_type = 'sfwd-courses' AND p.     post_status = 'publish' AND pm2.meta_value IS NOT NULL ORDER BY CAST(pm2.meta_value AS UNSIGNED)";

   $query_all = $wpdb->prepare($allcourses_query);
   $results_all = $wpdb->get_results($query_all);

   foreach ($results_all as $row) {
      if (get_field("description_course", $row->ID)) {
         $description = get_field("description_course", $row->ID);
      } else {
         $description = "Description not exist";
      }
      $all_courses[] = array('id' => $row->ID, 'slug' => $row->post_name, 'title' => $row->post_title, 'description' => $description);
   }

   if(count($games)>0){
      $last_id_to_read = count($games)-1;
   }else{
      $last_id_to_read = 0;
   }
   $latest_course_id = $all_courses[$last_id_to_read]['id']; 
   $course_id = $latest_course_id;
   $current_user_id = $user_id;
   $lessons = learndash_get_course_lessons_list($course_id);
   $all_courses = json_encode($all_courses);
   $course_name = isset($_GET['course_name']) ? sanitize_text_field($_GET['course_name']) : null;
   $allcourses_query = "
      SELECT p.ID, p.post_name, p.post_title, p.post_content, p.post_status
      FROM wp_posts p
      LEFT JOIN wp_postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_sfwd-courses'
      LEFT JOIN wp_postmeta pm2 ON p.ID = pm2.post_id AND pm2.meta_key = 'course_order'
      WHERE p.post_type = 'sfwd-courses'
      AND p.post_status = 'publish'
      AND pm2.meta_value IS NOT NULL
      AND p.post_name = %s
      ORDER BY CAST(pm2.meta_value AS UNSIGNED)";

    $query_all = $wpdb->prepare($allcourses_query, $course_name);
    $results_all = $wpdb->get_results($query_all);
    $course_title = $results_all[0]->post_title;
    $course_id = $results_all[0]->ID;

   $course_pricing      = learndash_get_course_price( $course_id );
   $has_access          = sfwd_lms_has_access( $course_id, $current_user_id );
   $latest_not_completed_lesson = null;
   $is_completed = null;
   $lessons = learndash_get_course_lessons_list($course_id);

  
   $lessonsDetails = [];
   $lessonContents  = [];
   $course_atts = [
    'intro_intro_text',
    'intro_intro_image',
    'warmup_slide_warmup_video',
    'warmup_slide_warmup_help',
    'warmup_slide_warmup_bonus',
    'challenge_slide_challenge_video',
    'challenge_slide_challenge_help',
    'challenge_slide_challenge_bonus',
    'play_slide_play_help',
    'play_slide_play_bonus',
];

if (!empty($lessons)) {
    foreach ($lessons as $lesson) {
        $lessonId = is_array($lesson) ? ($lesson['id'] ?? null) : ($lesson->ID ?? null);
        if ($lessonId) {
            $details = learndash_course_grid_prepare_template_post_attributes($lessonId, []);
            $lessonsDetails[] = $details;
            $lessonMeta = [];
            foreach ($course_atts as $meta_key) {
              $meta_value = get_post_meta($lessonId, $meta_key, true);
              if ($meta_key === 'intro_intro_image' && $meta_value) {
                  $meta_value = wp_get_attachment_url($meta_value);
              }
              if (($meta_key === 'warmup_slide_warmup_help' || $meta_key === 'warmup_slide_warmup_bonus' || $meta_key === 'challenge_slide_challenge_help' || $meta_key === 'challenge_slide_challenge_bonus' || $meta_key === 'play_slide_play_help' || $meta_key === 'play_slide_play_bonus') && $meta_value) {
                $meta_value = do_shortcode($meta_value);
              }           
              $lessonMeta[$meta_key] = $meta_value;
          }
            $lessonContents[$lessonId] = $lessonMeta;
        }
    }
}
   
   if (!empty($lessons)) {
      foreach ($lessons as $lesson) {
          $is_completed = learndash_is_lesson_complete($current_user_id, $lesson['post']->ID);
          if (!$is_completed) {           
              $latest_not_completed_lesson = $lesson['post'];
              break;
          }
      }
   }

  if ($latest_not_completed_lesson) {
      $last_parmalink = get_permalink($latest_not_completed_lesson->ID);
  }

   $ld_product = null;
   if ( class_exists( 'LearnDash\Core\Models\Product' ) ) {
	   $ld_product = LearnDash\Core\Models\Product::find( $course_id );
   }

   $progress = learndash_course_progress(
	   array(
		   'user_id'   => $current_user_id,
		   'course_id' => $course_id,
		   'array'     => true,
	   )
   );
   if ( empty( $progress ) ) {
	   $progress = array(
		   'percentage' => 0,
		   'completed'  => 0,
		   'total'      => 0,
	   );
   }
   $progress_status = ( 100 == $progress['percentage'] ) ? 'completed' : 'In Progress';
   if ( 0 < $progress['percentage'] && 100 !== $progress['percentage'] ) {
	   $progress_status = 'progress';
   }
   ?>

<div id="primary" class="bb-grid-cell">
   <main id="main" class="site-main">
      <div
         class="learndash learndash_post_sfwd-courses user_has_access"
         id="learndash_post_29838">
         <div class="learndash-wrapper">
            <div class="journey-banner color journey-banner-container">
               <div
                  class="bb-course-banner-info container bb-learndash-side-area"
                  style="max-width: 100%; width:1280px">
                  <div class="flex flex-wrap banner-content">
                     <div class="bb-course-banner inner">
                        <div class="journey-navigation">
                           <a
                              title="Go back"
                              href="https://artplay.academy/new-home">
                              <div class="navigation-icon">
                                 <i class="bb-icon-l buddyboss bb-icon-arrow-left color" aria-hidden="true"></i>
                              </div>
                              <span class="course-category-item">
                                 Back
                              </span>
                           </a>
                        </div>
                        <h1 class="entry-title"><?php echo $course_title ?></h1>
                        <div class="course-activity">
                           <?php
                           $course_args     = array(
                              'course_id'     => $course_id,
                              'user_id'       => $user_id,
                              'post_id'       => $course_id,
                              'activity_type' => 'course',
                           );
                           $course_activity = learndash_get_user_activity($course_args);

                           if (! empty($course_activity->activity_updated)) :
                              echo sprintf(
                                 esc_html_x('%s', 'Last activity date in infobar', 'buddyboss-theme'),
                                 '<i> Last Activity: ' . (learndash_adjust_date_time_display($course_activity->activity_updated)) . '</i>'
                              );
                           endif;
                           ?>
                        </div>
                     </div>
                     <div class="progress-container">
                        <div id="progress-value" style="visibility:hidden" data-progress=<?php echo $progress['percentage']; ?>></div>
                        <svg
                           class="progress-circle"
                           width="170"
                           height="170"
                           viewBox="0 0 170 170">
                           <circle class="progress-background" cx="85" cy="85" r="80" stroke="#ddd" stroke-width="8" fill="none"></circle>
                           <circle class="progress-bar" cx="85" cy="85" r="80" stroke="#BA5B95" stroke-width="8" fill="none" stroke-dasharray="502" stroke-dashoffset="100" style="stroke-dasharray: 502.655, 502.655; stroke-dashoffset: 502.655;"></circle>
                           <text class="progress-text" x="50%" y="45%" text-anchor="middle" alignment-baseline="middle" font-size="24" fill="#000">
                              <?php echo $progress['percentage'] ?>%
                           </text>
                           <text class="progress-description" x="50%" y="100" text-anchor="middle" alignment-baseline="middle" font-size="12" fill="#fff">
                              <?php echo $progress['completed'] ?> of <?php echo $progress['total'] ?> lessons
                           </text>
                        </svg>
                     </div>
                  </div>
               </div>
            </div>
            <div class="journey-main-content" id="journey-content"></div>
         </div>
      </div>
   </main>
</div>

      <!-- Popup Content -->
<div id="popup" class="mfp-hide">
  <div class="popup-content">
    <a class="mfp-close"
      ><img
        src="https://artplay.academy/wp-content/uploads/2024/08/cross-icon.svg"
        alt="Close Icon"
    /></a>
    <div class="carousel-wrapper">
      <div class="slider-breadcrumb">
        <div class="slider-tab first active">
          <svg
            class="breadcrumb-svg"
            viewBox="0 0 250 60"
            xmlns="http://www.w3.org/2000/svg"
          >
            <polygon
              points="220,0 250,30 220,60 0,60 0,0"
              fill="#fff"
              stroke="rgba(245, 245, 245, 1)"
              stroke-width="1"
            ></polygon>
            <!-- Lesson Title -->
            <text
              class="slide-title"
              x="80"
              y="35"
              font-family="Montserrat"
              font-size="16"
              font-weight="600"
              fill="black"
            >
              INTRO
            </text>
          </svg>
        </div>
        <div class="slider-tab second">
          <svg
            class="breadcrumb-svg"
            viewBox="0 0 290 60"
            xmlns="http://www.w3.org/2000/svg"
          >
            <polygon
              points="260,0 290,30 260,60 0,60 0,0"
              fill="#fff"
              stroke="rgba(245, 245, 245, 1)"
              stroke-width="1"
            ></polygon>
            <!-- Lesson Title -->
            <text
              class="slide-title"
              x="110"
              y="35"
              font-family="Montserrat"
              font-size="16"
              font-weight="600"
              fill="black"
            >
              WARMUP
            </text>
          </svg>
        </div>
        <div class="slider-tab third">
          <svg
            class="breadcrumb-svg"
            viewBox="0 0 290 60"
            xmlns="http://www.w3.org/2000/svg"
          >
            <polygon
              points="260,0 290,30 260,60 0,60 0,0"
              fill="#fff"
              stroke="rgba(245, 245, 245, 1)"
              stroke-width="1"
            ></polygon>
            <!-- Lesson Title -->
            <text
              class="slide-title"
              x="110"
              y="35"
              font-family="Montserrat"
              font-size="16"
              font-weight="600"
              fill="black"
            >
              CHALLENGE
            </text>
          </svg>
        </div>
        <div class="slider-tab forth">
          <svg
            class="breadcrumb-svg"
            viewBox="0 0 290 60"
            xmlns="http://www.w3.org/2000/svg"
          >
            <polygon
              points="260,0 290,30 260,60 0,60 0,0"
              fill="#fff"
              stroke="rgba(245, 245, 245, 1)"
              stroke-width="1"
            ></polygon>
            <!-- Lesson Title -->
            <text
              class="slide-title"
              x="110"
              y="35"
              font-family="Montserrat"
              font-size="16"
              font-weight="600"
              fill="black"
            >
              PLAY
            </text>
          </svg>
        </div>
      </div>
      <div class="carousel">
        <div data-tab="1">
          <div
            class="first-slide slide-content"
            style="width: 100%; display: inline-block"
          >
            <div class="image-section">
              <img
                id="intro-image"
                src="https://artplay.academy/wp-content/uploads/2024/08/image-49.png"
                alt="Intro Image"
              />
              <div id="intro-text" class="content-section">
                Intro Text not found for this Lesson.
              </div>
            </div>
          </div>
        </div>
        <div data-tab="2">
          <div class="slide-content">
            <div class="slide2 iframe-container">
              <p id="warmup-video">No Video found.</p>
              <div id="warmup-play-button" class="slider-video-button color">
                <span class="video-content">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="17"
                    viewBox="0 0 16 17"
                    fill="none"
                  >
                    <path
                      d="M14.2073 5.96635C16.2561 7.11122 16.2561 10.0591 14.2073 11.204L4.91034 16.3994C2.91063 17.5169 0.446868 16.0713 0.446868 13.7806L0.446869 3.3898C0.446869 1.09903 2.91063 -0.346523 4.91033 0.770961L14.2073 5.96635Z"
                      fill="#BA5B95"
                    />
                  </svg>
                </span>
                <h5>Start Lesson!</h5>
              </div>
            </div>
            <div class="warmup-slide-buttons">
              <a
                class="question-button color active warmup-lesson-help"
                href="#"
                tabindex="0"
                ><img
                  src="https://artplay.academy/wp-content/uploads/2024/08/fi_help-circle.svg"
              /></a>
              <a
                class="mark-button color warmup-lesson-bonus"
                href="#"
                tabindex="0"
                ><img
                  src="https://artplay.academy/wp-content/uploads/2024/08/Vector-1.svg"
              /></a>
              <a
                class="mark-button color warmup-lesson-notes"
                data-note-type="warmup"
                href="#"
              >
                <img
                  src="https://artplay.academy/wp-content/uploads/2024/08/note.svg"
                />
              </a>
            </div>
          </div>
        </div>
        <div data-tab="3">
          <div class="challenge-slider slide-content">
            <div class="slide3 iframe-container">
              <p id="challenge-video">No Video found.</p>
              <div id="challenge-play-button" class="slider-video-button color">
                <span class="video-content">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="17"
                    viewBox="0 0 16 17"
                    fill="none"
                  >
                    <path
                      d="M14.2073 5.96635C16.2561 7.11122 16.2561 10.0591 14.2073 11.204L4.91034 16.3994C2.91063 17.5169 0.446868 16.0713 0.446868 13.7806L0.446869 3.3898C0.446869 1.09903 2.91063 -0.346523 4.91033 0.770961L14.2073 5.96635Z"
                      fill="#BA5B95"
                    />
                  </svg>
                </span>
                <h5>Start Lesson!</h5>
              </div>
            </div>
            <div class="warmup-slide-buttons">
              <a
                class="question-button color active challenge-lesson-help"
                href="#"
                tabindex="0"
                ><img
                  src="https://artplay.academy/wp-content/uploads/2024/08/fi_help-circle.svg"
              /></a>
              <a
                class="mark-button color challenge-lesson-bonus"
                href="#"
                tabindex="0"
                ><img
                  src="https://artplay.academy/wp-content/uploads/2024/08/Vector-1.svg"
              /></a>
              <a
                class="mark-button color challenge-lesson-notes"
                data-note-type="challenge"
                href="#"
                tabindex="0"
              >
                <img
                  src="https://artplay.academy/wp-content/uploads/2024/08/note.svg"
                />
              </a>
            </div>
          </div>
        </div>
        <div data-tab="4">
          <div class="play-slider slide-content">
            <h4>Right Hand | Melody</h4>
            <h4>G E B A</h4>
            <p>
              Create a melody using only these notes in this order play them in
              any octave, quantity, and rhythm.
            </p>
            <h4>Left Hand | Chords</h4>
            <h4>C G Em</h4>
            <p>
              Create a progression using only these chords in any order, octave,
              quantity, and rhythm.
            </p>
            <p>
              Diatonic passing chord: Approach any chord a neighboring diatonic
              chord. Adding passing chords makes transitions within the
              progression both smoother and more dynamic.
            </p>
            <div class="recording-uploading-buttons color">
              <div class="recording-btn">
                <span class="icon recording">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="26"
                    height="30"
                    viewBox="0 0 26 30"
                    fill="none"
                  >
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M13.2621 19.8261H12.7376C9.1325 19.8261 6.21037 16.9391 6.21037 13.3805V6.4456C6.21037 2.8856 9.1325 0 12.7376 0H13.2621C16.8672 0 19.7908 2.8856 19.7908 6.4456V13.3805C19.7908 16.9391 16.8672 19.8261 13.2621 19.8261ZM22.8439 13.1743C22.8439 12.3808 23.4948 11.7394 24.2969 11.7394C25.099 11.7394 25.75 12.3808 25.75 13.1743C25.75 19.6299 20.8008 24.9606 14.4538 25.6766V28.5651C14.4538 29.3572 13.8028 30 13.0007 30C12.1972 30 11.5477 29.3572 11.5477 28.5651V25.6766C5.19917 24.9606 0.25 19.6299 0.25 13.1743C0.25 12.3808 0.900977 11.7394 1.70307 11.7394C2.50517 11.7394 3.15615 12.3808 3.15615 13.1743C3.15615 18.5337 7.57204 22.8943 13.0007 22.8943C18.428 22.8943 22.8439 18.5337 22.8439 13.1743Z"
                      fill="#BA5B95"
                    />
                  </svg> </span
                ><span class="text">Record</span>
              </div>
              <div class="uploading-button">
                <input
                  type="file"
                  id="fileInput"
                  class="file-input"
                  style="display: none"
                  tabindex="0"
                />

                <span class="icon upload-file">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="37"
                    height="36"
                    viewBox="0 0 37 36"
                    fill="none"
                  >
                    <path
                      d="M25.16 13.35C30.56 13.815 32.765 16.59 32.765 22.665V22.86C32.765 29.565 30.08 32.25 23.375 32.25H13.61C6.90497 32.25 4.21997 29.565 4.21997 22.86V22.665C4.21997 16.635 6.39497 13.86 11.705 13.365"
                      stroke="#BA5B95"
                      stroke-width="3"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M18.5 22.5V5.42999"
                      stroke="#BA5B95"
                      stroke-width="3"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M23.5251 8.775L18.5001 3.75L13.4751 8.775"
                      stroke="#BA5B95"
                      stroke-width="3"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </span>
                <label for="fileInput" class="upload-label">
                  <span class="text">Upload</span>
                </label>
              </div>
            </div>
            <div class="warmup-slide-buttons">
              <a
                class="question-button color active play-lesson-help"
                href="#"
                tabindex="0"
                ><img
                  src="https://artplay.academy/wp-content/uploads/2024/08/fi_help-circle.svg"
              /></a>
              <a
                class="mark-button color play-lesson-bonus"
                href="#"
                tabindex="0"
                ><img
                  src="https://artplay.academy/wp-content/uploads/2024/08/Vector-1.svg"
              /></a>
              <a
                class="mark-button color play-lesson-notes"
                data-note-type="play"
                id="openPopup"
                href="#"
                tabindex="0"
              >
                <img
                  src="https://artplay.academy/wp-content/uploads/2024/08/note.svg"
                />
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="lesson-buttons">
        <a class="review-button color" href="#" tabindex="0">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="20"
            viewBox="0 0 16 20"
            fill="none"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M4.9 0H11.07C13.78 0 15.97 1.07 16 3.79V18.97C16 19.14 15.96 19.31 15.88 19.46C15.75 19.7 15.53 19.88 15.26 19.96C15 20.04 14.71 20 14.47 19.86L7.99 16.62L1.5 19.86C1.351 19.939 1.18 19.99 1.01 19.99C0.45 19.99 0 19.53 0 18.97V3.79C0 1.07 2.2 0 4.9 0ZM4.22 7.62H11.75C12.18 7.62 12.53 7.269 12.53 6.83C12.53 6.39 12.18 6.04 11.75 6.04H4.22C3.79 6.04 3.44 6.39 3.44 6.83C3.44 7.269 3.79 7.62 4.22 7.62Z"
              fill="#BA5B95"
            />
          </svg>
          Review Later
        </a>
        <a class="mark-button color" href="#" tabindex="0">
          <img
            src="https://artplay.academy/wp-content/uploads/2024/08/tick-img.svg"
          />
          Mark Complete
        </a>
      </div>
    </div>

    <div id="second-popup" class="second-popup community-popup">
      <div class="popup-content">
        <div class="popup-header">
          <div class="second-popup-title">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="74"
              viewBox="0 0 74 74"
              fill="none"
            >
              <path
                d="M56.9492 51.8925L58.1517 61.6358C58.46 64.195 55.7159 65.9833 53.5267 64.6575L42.8584 58.3058C42.1184 57.8741 41.9334 56.9491 42.3342 56.2091C43.8759 53.3725 44.7084 50.1658 44.7084 46.9591C44.7084 35.6741 35.0267 26.4858 23.125 26.4858C20.6892 26.4858 18.315 26.8558 16.095 27.5958C14.9542 27.9658 13.8442 26.9175 14.1217 25.7458C16.9275 14.5225 27.7192 6.16663 40.6075 6.16663C55.6542 6.16663 67.8334 17.5441 67.8334 31.5733C67.8334 39.8983 63.5475 47.2675 56.9492 51.8925Z"
                fill="#BA5B95"
              />
              <path
                d="M40.0834 46.9592C40.0834 50.6283 38.7267 54.02 36.4451 56.7025C33.3926 60.4025 28.5517 62.7767 23.1251 62.7767L15.0776 67.5558C13.7209 68.3883 11.9942 67.2475 12.1792 65.675L12.9501 59.6008C8.81841 56.7333 6.16675 52.1392 6.16675 46.9592C6.16675 41.5325 9.06508 36.7533 13.5051 33.9167C16.2492 32.1283 19.5484 31.1108 23.1251 31.1108C32.4984 31.1108 40.0834 38.2025 40.0834 46.9592Z"
                fill="#BA5B95"
              />
            </svg>
            Community
          </div>
          <span id="closePopup" class="close-btn"
            ><img
              src="https://artplay.academy/wp-content/uploads/2024/08/cross-icon.svg"
              alt="close icon"
          /></span>
        </div>
        <div class="popup-body">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="74"
            height="74"
            viewBox="0 0 74 74"
            fill="none"
          >
            <path
              d="M56.9492 51.8925L58.1517 61.6358C58.46 64.195 55.7159 65.9833 53.5267 64.6575L42.8584 58.3058C42.1184 57.8741 41.9334 56.9491 42.3342 56.2091C43.8759 53.3725 44.7084 50.1658 44.7084 46.9591C44.7084 35.6741 35.0267 26.4858 23.125 26.4858C20.6892 26.4858 18.315 26.8558 16.095 27.5958C14.9542 27.9658 13.8442 26.9175 14.1217 25.7458C16.9275 14.5225 27.7192 6.16663 40.6075 6.16663C55.6542 6.16663 67.8334 17.5441 67.8334 31.5733C67.8334 39.8983 63.5475 47.2675 56.9492 51.8925Z"
              fill="#BA5B95"
            />
            <path
              d="M40.0834 46.9592C40.0834 50.6283 38.7267 54.02 36.4451 56.7025C33.3926 60.4025 28.5517 62.7767 23.1251 62.7767L15.0776 67.5558C13.7209 68.3883 11.9942 67.2475 12.1792 65.675L12.9501 59.6008C8.81841 56.7333 6.16675 52.1392 6.16675 46.9592C6.16675 41.5325 9.06508 36.7533 13.5051 33.9167C16.2492 32.1283 19.5484 31.1108 23.1251 31.1108C32.4984 31.1108 40.0834 38.2025 40.0834 46.9592Z"
              fill="#BA5B95"
            />
          </svg>
          <h5>Do you want to post your recording to the community forum?</h5>
          <textarea
            rows="4"
            cols="50"
            placeholder="Write a description here to post with your recording."
          ></textarea>
          <div class="buttons">
            <a class="primary" href="#">No</a
            ><a href="#" class="secondary">Yes</a>
          </div>
        </div>
      </div>
    </div>

    <div id="help-popup" class="second-popup help-bonus">
      <div class="popup-content">
        <div class="popup-header">
          <div class="second-popup-title color"></div>
          <span id="closeHelp" class="close-btn"
            ><img
              src="https://artplay.academy/wp-content/uploads/2024/08/cross-icon.svg"
              alt="close icon"
          /></span>
        </div>
        <div class="popup-body"></div>
      </div>
    </div>
  </div>
</div>



<?php

   $images = [
      'completed' => 'https://artplay.academy/wp-content/uploads/2024/08/tick-icon.svg',
      'spider' =>    'https://artplay.academy/wp-content/uploads/2024/08/spider-icon.svg',
      'musicnote' => 'https://artplay.academy/wp-content/uploads/2024/08/music-icon.svg',
      'telegram1' => 'https://artplay.academy/wp-content/uploads/2024/08/telegram-cloud.svg',
      'telegram2' => 'https://artplay.academy/wp-content/uploads/2024/08/piano-img-1.svg',
      'arrowIcon' => 'https://artplay.academy/wp-content/uploads/2024/08/down-arrow.svg'
   ];

   function getPositionClass($index) {
      return ['center', 'left', 'center', 'right'][($index - 1) % 4];
   }

   function getImageForLesson($index, $images, $lessonCount) {
      if ($index === $lessonCount) return $images['spider'];
      $cycleImages = [$images['musicnote'], $images['telegram1'], $images['telegram2']];
      return $cycleImages[($index - 1) % 3];
   }

   $htmlContent = '';
   $first = true;
   $lessonCount = count($lessons);

   foreach ($lessons as $index => $lesson) {
      $i = $index;
      $positionClass = getPositionClass($i);
      $imageURL = $lesson['status'] === 'completed'? $images['completed'] : getImageForLesson($i, $images, $lessonCount);
      $lessonStatus = $lesson['id'] > $latest_not_completed_lesson->ID ? 'inactive' : ($lesson['id'] ==    $latest_not_completed_lesson->ID ? 'inprogress color' : 'completed color');
      $lessonId = $lesson['id'];
      $first = false;
    
      $htmlContent .= '
         <div class="color course-lesson-view ' . htmlspecialchars($positionClass) . '  ' . htmlspecialchars($lessonStatus) . '">
            <a id="openPopover" href="#" data-status="'. htmlspecialchars($lessonStatus) . '" data-id="'. htmlspecialchars($lessonId) .   '">
            <span class="color course-lesson-bubble ' . htmlspecialchars($lessonStatus) . '">
                  <img src="' . htmlspecialchars($imageURL) . '" />
             </span>
            </a>
            ' . ($i < $lessonCount ? '
            <div class="line">
               <div class="arrow-icon">
                     <img src="' . htmlspecialchars($images['arrowIcon']) . '" />
               </div>
            </div>
            ' : '') . '
         </div>
      ';
   }

?>
<?php
   echo '<script>';
   echo 'const lessons = ' . json_encode($lessons) . ';';
   echo 'const lessonsDetails = ' . json_encode($lessonsDetails) . ';';
   echo 'const lessonContents = ' . json_encode($lessonContents) . ';';
   echo '</script>';
?>
<script>
   const numLessons = <?php echo $lessonCount; ?>;
   let htmlContent = `<?php echo addslashes($htmlContent); ?>`;
</script>
<script src="https://player.vimeo.com/api/player.js"></script>
<!-- <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/journey-template.js"></script> -->
<?php get_footer(); ?>