<?php
/**
 * Template Name: Home Template
 * Template Post Type: post, page
 */
get_header(); ?>

<?php

function isSafari() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') === false) {
        return true;
    }
    return false;
}

if (isSafari()) {?>

<style>
/* 	svg a path{
        filter: url('#brightness-filter');
    }

    svg a.active path{
        filter: url('#brightness-filter-full');
		transform: scale(1.01);
    	transform-origin: center;
    } */

	svg a path{
      	-webkit-filter: url('#brightness-filter-0');
		filter: url('#brightness-filter-0');
  }
  svg a.active path{
      	-webkit-filter: url('#brightness-filter');
    	filter: url('#brightness-filter');
    	transform: scale(1.00); /* Slightly zoom in */
    	transform-origin: center;
  }

    @-webkit-keyframes glow {
        0% {
			filter: url("#brightness-filter");
		}
		20% {
			filter: url("#brightness-filter-20%");
		}
		40% {
			filter: url("#brightness-filter-40%");
		}
		60% {
			filter: url("#brightness-filter-60%");
		}
		80% {
			filter: url("#brightness-filter-80%");
		}
		100% {
			filter: url("#brightness-filter-full");
			opacity: 0.9;
		}
    }

    @keyframes glow {
		0% {
			filter: url("#brightness-filter");
		}
		20% {
			filter: url("#brightness-filter-20%");
		}
		40% {
			filter: url("#brightness-filter-40%");
		}
		60% {
			filter: url("#brightness-filter-60%");
		}
		80% {
			filter: url("#brightness-filter-80%");
		}
		100% {
			filter: url("#brightness-filter-full") ;
			opacity: 0.9;
			transform: scale(1.01); /* Slightly zoom in */
    		transform-origin: center;
		}
    }

    .glow_color {
        animation: glow 1s infinite alternate;
		animation-timing-function: ease-out;
		
		-webkit-animation: glow 1s infinite alternate;
		-webkit-animation-timing-function: ease-out;
    }
</style>
    
<?php } else {?>
<style>
svg a path{
      	-webkit-filter: brightness(50%);
		filter: brightness(50%);
  }
  svg a.active path{
      	-webkit-filter: brightness(100%);
    	filter: brightness(100%);
    	transform: scale(1.00); /* Slightly zoom in */
    	transform-origin: center;
  }
	@keyframes glow{
		100% {
			filter: brightness(120%) drop-shadow(0 0 2px #fff);
        	transform: scale(1.01);
		}
	}
  svg a.glow_color path {
     animation: glow 1s infinite alternate;
	  animation-timing-function: ease-out;
     transform-origin: center;
	  
	  -webkit-animation: glow 1s infinite alternate;
	  -webkit-animation-timing-function: ease-out;
     -webkit-transform-origin: center;
  }
</style>
    
<?php }

?>


<style type="text/css">
    svg {
		height: 100vh;
		width: 100%;
		padding: 50px 0;
        margin: 0 auto;
    	display: block;
    }
    .popup {
    	position: absolute;
		border: 1px solid #ccc;
		display: none;
		background-color: #000000;
		border-radius: 5px;
		padding: 30px 15px;
		z-index: 1000;
		max-width: 210px;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
		color: white;
		width: 100%;
    }
    .popup-title {
        font-weight: bold;
    }
	.popup-description {
      	font-weight: normal;
      	margin-bottom: 5px;
	}
	.popup-title {
      	font-weight: bold;
      	margin-bottom: 5px;
    }
   .play-button {
   		background-color: white !important;
		color: #000  !important;
	   	padding: 10px 30px  !important;
	   	cursor: pointer;
	   	margin-top: 5px;
	   	border-radius: 3px;
	   	text-transform: uppercase;
	   	font-size: 16px  !important;
	   	font-weight: 500;
	   	-webkit-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75)  !important;
	   	-moz-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75)  !important;
	  	 box-shadow: 0px 5px 7px 0px rgb(0 0 0 / 44%) !important;
	   	border-radius: 5px  !important;
	   	border: 1px solid green;
	   	margin-top: 30px;
	  	display: flex;
	   	align-items: flex-end;
   }
   button.play-button.disabled_btn:before {
    	background-repeat: no-repeat;
   		content: '';
    	background-image:url('https://artplay.academy/wp-content/uploads/2024/07/padlock.png');
     	background-size: contain;
    	width: 22px;
    	height: 22px;
    	display: inline-block;
    	margin-right: 10px;
	}
    button.play-button.disabled_btn {
    	opacity: 0.8;
	}
   .play-button:hover{
      	background-color: green;
      	color: white;
   }
   button.close-button:hover {
      	box-shadow: unset !important;
   }
   button.close-button {
		position: absolute;
		top: 0;
		right: 0;
		background: transparent !important;
		color: #fff !important;
		font-size: 24px !important;
		box-shadow: unset;
		border: unset;
		padding: 7px 10px 0 0;
		font-weight: 400;
   }
	a#continue_btn {
		margin-left: auto;
		display: block;
		width: 100%;
		max-width: 250px;
		height: auto;
		margin-top: 30px;
		text-align: center;
		font-size: 20px;
		font-weight: 700;
		border-radius: 15px;
		position: relative;
		color: #fff;
		background-color: #50C450;
		box-shadow: 0px 10px 10px 0px rgba(1.9999999999999567, 0.9999999999999784, 0.9999999999999784, 0.2);
		padding: 18px 40px 18px 40px;
		margin-right: auto;
	}
	.page-template-Home .site-content {
		min-height: 50vh;
	}
	.bb-grid.site-content-grid {
		display: block;
	}
	#continue_btn:hover{ color:green;}
 	
	@media (max-width: 992px) {
		.popup {transform: translateX(-50%);top: 50% !important;}
  }
	@media (max-width: 600px) {
		.page-template-Home svg {height: 370px;}
		.page-template-Home div#content {margin: 100px  0 0 0;}
		.popup {left: 50% !important;transform: translateX(-50%);top: 50% !important;}
	}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<?php
global $wpdb;
$games = array();
$all_courses = array();
$user_id = get_current_user_id();
$last_completed_id = '';
$latest_course_to_read_id = '';
$courses_query = "
    SELECT p.ID, p.post_name, p.post_title, p.post_content, p.post_status FROM wp_posts p LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_sfwd-courses' WHERE p.post_type = 'sfwd-courses' AND p.post_status = 'publish' AND p.ID IN (SELECT REPLACE(meta_key, 'course_completed_', '') FROM wp_usermeta WHERE user_id = ".$user_id." AND meta_key LIKE 'course_completed_%');";


$query = $wpdb->prepare($courses_query);
$results = $wpdb->get_results($query);

foreach ($results as $result) {
	$last_completed_id = $result->ID;
    $games[] = array('id' => $result->ID);
}
$games_json = json_encode($games);
// echo("<script>console.log('PHP: " . $games_json . "');</script>");
$latest_course_to_read = "
    SELECT p.ID, p.post_name, p.post_title, p.post_content, p.post_status FROM wp_posts p LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_sfwd-courses' WHERE p.post_type = 'sfwd-courses'  AND p.post_status = 'publish' AND p.ID > (".$last_completed_id.") LIMIT 1;";
$query_read = $wpdb->prepare($latest_course_to_read);
$results_read = $wpdb->get_results($query_read);

foreach ($results_read as $result_read) {;
	$latest_course_to_read_id = $result_read->post_name;
}
$category_first_query = "
    SELECT p.ID, p.post_name, p.post_title, p.post_content, p.post_status FROM wp_posts p LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_sfwd-courses' LEFT JOIN wp_term_relationships tr ON p.ID = tr.object_id LEFT JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id LEFT JOIN wp_terms t ON tt.term_id = t.term_id WHERE p.post_type = 'sfwd-courses' AND p.post_status = 'publish' AND t.name = '1ai'";

$categoryquery = $wpdb->prepare($category_first_query);
$category_first_results = $wpdb->get_results($categoryquery);

foreach ($category_first_results as $result) {
    $first_complete_courses[] = $result->ID;
}

$first_completecourses = json_encode($first_complete_courses);
$allcourses_query = "
    SELECT p.ID, p.post_name, p.post_title, p.post_content, p.post_status FROM wp_posts p LEFT JOIN wp_postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_sfwd-courses'
LEFT JOIN wp_postmeta pm2 ON p.ID = pm2.post_id AND pm2.meta_key = 'course_order' WHERE p.post_type = 'sfwd-courses' AND p.post_status = 'publish' AND pm2.meta_value IS NOT NULL ORDER BY CAST(pm2.meta_value AS UNSIGNED)";

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
$latest_not_completed_lesson = null;

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

$all_courses = json_encode($all_courses);
?>

<script type="text/javascript">
	
	
	
    document.addEventListener('DOMContentLoaded', function () {
        const games = JSON.parse('<?php echo $games_json; ?>');
        const allcourses = JSON.parse('<?php echo $all_courses; ?>');
        const allfirstStagecourses = JSON.parse('<?php echo $first_completecourses; ?>');
		let latest_id_to_read = 0;
		let latest_level_to_read = 0;
        // Function to create popup
        if(games.length>0){
			let last_id = (games.length-1);
// 			latest_id_to_read = allcourses[last_id]['id']; 
// 			latest_id_to_read = games[last_id]['id'];
			
			
			latest_level_to_read = -1;
			for (var i = 0; i < games.length; i++) {
				for(var j = 0; j < allcourses.length; j++) {

					if(allcourses[j].id === games[i].id) {
						if (latest_level_to_read < j) {
							latest_level_to_read = j;
						}
						break;
					}
				}
			}
			latest_level_to_read = latest_level_to_read + 1;
			console.log(latest_level_to_read);
			latest_id_to_read = allcourses[latest_level_to_read].id;
			console.log(latest_id_to_read);
			
			const classToAdd = 'glow_color';
			const element1 = document.querySelector(`[data-id="${latest_id_to_read}"]`);

			if (element1) {
				element1.classList.add(classToAdd);
				let course_order = document.querySelector('.glow_color').getAttribute('course-order');
				console.log(course_order)
				if (document.getElementById('continue_btn').href){
				}else{
				document.getElementById('continue_btn').href = element1.getAttribute('xlink:href');	
				}
			} 
		}else{
			let last_id = 0;
			latest_id_to_read = allcourses[last_id]['id']; 
			const classToAdd = 'glow_color';
			const element1 = document.querySelector(`[data-id="${latest_id_to_read}"]`);
			if (element1) {
				element1.classList.add(classToAdd);
				let course_order = document.querySelector('.glow_color').getAttribute('course-order');
				console.log(course_order);
				if (document.getElementById('continue_btn').href){
					
				}else{
				document.getElementById('continue_btn').href = element1.getAttribute('xlink:href');	
				}	
			} 
		}
		
		
		
		
		
        
        function createPopup(title, description, courseUrl, main_id) {
          	let btn_enabled = ''
          	let disable_class = ''
// 		 	const exists = games.some(obj => obj.id === main_id);
			
			var level_num = -1;
			for(var i = 0; i < allcourses.length; i++) {
				if(allcourses[i].id === main_id) {
					level_num = i;
					break;
				}
			}
			console.log (level_num);
			
			const exists = (level_num <= latest_level_to_read);
		  	const last_id_exists = allcourses.some(obj => obj.id === latest_id_to_read);
			console.log(title, description, courseUrl, main_id, latest_id_to_read, last_id_exists);
			console.log(games);
			console.log(allcourses);
			console.log(exists);
			console.log(allfirstStagecourses);
			
			if (exists) {
			 btn_enabled = ''
			 disable_class = ''
			}else{
			  if(main_id==latest_id_to_read){
				  btn_enabled = '';
				  disable_class = '';	  	  
			  }else{
				  btn_enabled = 'disabled';
				  disable_class = 'disabled_btn' 
			  }				
			}
            const popup = document.createElement("div");
            popup.setAttribute("class", "popup");
            popup.innerHTML = `
                <div class="popup-title">${title}</div>
				<div class="popup-description">${description}</div>
                <button class="play-button ${disable_class}" ${btn_enabled}>PLAY</button>
                <button class="close-button">X</button>
            `;
            document.body.appendChild(popup);
          
            const playButton = popup.querySelector('.play-button');
            playButton.addEventListener('click', () => {
                window.location.href = courseUrl; // Use the course URL directly
            });
            // Event listener for close button
            const closeButton = popup.querySelector('.close-button');
            closeButton.addEventListener('click', () => {
                popup.style.display = 'none';
            });
            return popup;
        }

         // Function to position popup
        function positionPopup(popup, levelPolygon) {
            const rect = levelPolygon.getBoundingClientRect();
            const popupX = rect.left + window.scrollX + rect.width / 2 - popup.clientWidth / 2;
            const popupY = rect.top + window.scrollY + rect.height + 10; // Adjust as needed
            // Ensure popup is within viewport on mobile
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            if (popupX + popup.clientWidth > viewportWidth) {
                popup.style.left = `${viewportWidth - popup.clientWidth - 20}px`;
            } else {
                popup.style.left = `${popupX}px`;
            }
            if (popupY + popup.clientHeight > viewportHeight) {
                popup.style.top = `${viewportHeight - popup.clientHeight - 20}px`;
            } else {
                popup.style.top = `${popupY}px`;
            }
        }

        // Add event listeners to SVG elements
        $check_level = 0;
        document.querySelectorAll('svg a').forEach((levelPolygon) => {
            const courseUrl = levelPolygon.getAttribute('xlink:href');
            const main_id = levelPolygon.getAttribute('data-id');
			const check_id = games.some(obj => obj.id === main_id);
			  if (check_id) {
			  }else{
				   if(main_id==latest_id_to_read){
					   	  
				   }else{
					  levelPolygon.setAttribute('xlink:href',''); 
				   }	 	
			  }
            const foundObject = allcourses.find(item => item.id === main_id);
                const title = foundObject.title;
                const description = foundObject.description;
                levelPolygon.addEventListener('click', function(event) {
                    event.preventDefault();

                    document.querySelectorAll('.popup').forEach(popup => popup.style.display = 'none');

                    const popup = createPopup(title, description, courseUrl, main_id);
                    positionPopup(popup, levelPolygon);
                    popup.style.display = 'block';
                });
         $check_level++;   
        });

        games.forEach(game => {
            const activeCourse = document.querySelector(`svg a[data-id="${game.id}"]`);
            if (activeCourse) {
                activeCourse.classList.add('active');
            }
        });
    });
</script>
<a id="continue_btn" href="<?php echo $last_parmalink?>">Continue Journey</a>

<svg width="747" height="780" viewBox="-30 -30 820 800" fill="none" xmlns="http://www.w3.org/2000/svg">
	<defs>
		<filter id="brightness-filter-0">
            <feComponentTransfer>
                <feFuncR type="linear" slope="0.2" />
                <feFuncG type="linear" slope="0.2" />
                <feFuncB type="linear" slope="0.2" />
            </feComponentTransfer>
        </filter>
        <filter id="brightness-filter">
            <feComponentTransfer>
                <feFuncR type="linear" slope="1" />
                <feFuncG type="linear" slope="1" />
                <feFuncB type="linear" slope="1" />
            </feComponentTransfer>
        </filter>
        <filter id="brightness-filter-full">
            <feComponentTransfer>
                <feFuncR type="linear" slope="7" />
                <feFuncG type="linear" slope="7" />
                <feFuncB type="linear" slope="7" />
            </feComponentTransfer>
        </filter>
		<filter id="brightness-filter-20%">
            <feComponentTransfer>
                <feFuncR type="linear" slope="2.2" />
                <feFuncG type="linear" slope="2.2" />
                <feFuncB type="linear" slope="2.2" />
            </feComponentTransfer>
        </filter>
		<filter id="brightness-filter-40%">
            <feComponentTransfer>
                <feFuncR type="linear" slope="3.4" />
                <feFuncG type="linear" slope="3.4" />
                <feFuncB type="linear" slope="3.4" />
            </feComponentTransfer>
        </filter>
		<filter id="brightness-filter-60%">
            <feComponentTransfer>
                <feFuncR type="linear" slope="4.6" />
                <feFuncG type="linear" slope="4.6" />
                <feFuncB type="linear" slope="4.6" />
            </feComponentTransfer>
        </filter>
		<filter id="brightness-filter-80%">
            <feComponentTransfer>
                <feFuncR type="linear" slope="5.8" />
                <feFuncG type="linear" slope="5.8" />
                <feFuncB type="linear" slope="5.8" />
            </feComponentTransfer>
        </filter>
		
    </defs>
<!-- 74-->
  <a course-order="74" data-id="36115" target="_blank" xlink:href="https://artplay.academy/courses/level-74/">
      <path d="M101.402 97.0117L101.478 97.084L101.482 97.0545L294.894 74.6092L295.035 74.533L274.6 1.26172L101.41 97L101.402 97.0117Z" fill="#2A8B6E" stroke="#2A8B6E", stroke-width="1"/>
    </a>
	<text x="170" y="40" font-family="Arial" font-size="20" fill="black">F</text>
<!-- 72-->
   <a course-order="72" data-id="36013" target='_blank' xlink:href="https://artplay.academy/courses/level-72/">
     <path d="M294.895 74.6094L101.482 97.0547L101.479 97.0841L157.481 150.58L157.486 150.57C157.657 150.476 294.533 74.809 294.895 74.6094Z" fill="#2F9874" stroke="#2F9874", stroke-width="1"/>
   </a>
<!-- 50-->
   <a course-order="50" data-id="35276" target='_blank' xlink:href="https://artplay.academy/courses/level-50/">
     <path d="M295.066 74.6426L295.051 74.5918L294.895 74.6096C294.533 74.8092 157.659 150.474 157.488 150.569L157.481 150.58L213.559 204.149L213.565 204.141L213.674 204.083L213.592 204.071L295.066 74.6426Z" fill="#34A984" stroke="#34A984", stroke-width="1"/>
   </a>
<!-- 48-->
   <a course-order="48" data-id="34861" target='_blank' xlink:href="https://artplay.academy/courses/level-48/">
      <path d="M295.066 74.6426L213.592 204.07L213.674 204.082C214.228 203.775 315.428 147.828 315.471 147.804L295.066 74.6426Z" fill="#38B58D" stroke="#38B58D", stroke-width="1"/>
   </a> 
<!-- 26-->
   <a course-order="26" data-id="33904" target='_blank' xlink:href="https://artplay.academy/courses/level-26/">
     <path d="M213.674 204.082L335.906 221.076L315.471 147.805C315.428 147.828 214.228 203.776 213.674 204.082Z" fill="#3CBF95" stroke="#3CBF95", stroke-width="1"/>
   </a>
<!-- 24-->
   <a course-order="24" data-id="32574" target='_blank' xlink:href="https://artplay.academy/courses/level-24/">
     <path d="M213.674 204.082L213.566 204.141L213.558 204.148L269.639 257.718L269.642 257.711L335.906 221.078L213.674 204.082Z" fill="#49C49D" stroke="#49C49D", stroke-width="1"/>
   </a>
<!-- 2-->
   <a course-order="2" data-id="29839" target='_blank' xlink:href="https://artplay.academy/courses/level-2/">
     <path d="M269.639 257.719L373.697 357.121L373.861 357.164L335.906 221.078L269.643 257.711L269.639 257.719Z" fill="#56C7A0" stroke="#56C7A0", stroke-width="1"/>
   </a>
<!-- 75-->
   <a course-order="75" data-id="36117"  target='_blank' xlink:href="https://artplay.academy/courses/level-75/">
     <path d="M1.26953 262.324L77.9375 281.838L101.479 97.084L101.402 97.0117L1.26953 262.324Z" fill="#2D6F7E" stroke="#2D6F7E", stroke-width="1"/>
   </a>
	<text x="10" y="170" font-family="Arial" font-size="20" fill="black">Bb</text>
<!-- 71-->
   <a course-order="71" data-id="35946" target='_blank' xlink:href="https://artplay.academy/courses/level-71/">
     <path d="M157.48 150.58L101.479 97.084L77.9375 281.838L77.9708 281.849C78.4234 281.103 157.21 151.026 157.48 150.58Z" fill="#327B8D" stroke="#327B8D", stroke-width="1"/>
   </a>
<!-- 51-->
   <a course-order="51" data-id="35277" target='_blank' xlink:href="https://artplay.academy/courses/level-51/">
      <path d="M157.48 150.58C157.21 151.026 78.4233 281.101 77.9707 281.848L78.0117 281.859L213.496 204.257L213.559 204.15L157.48 150.58Z" fill="#37869A" stroke="#37869A", stroke-width="1"/>
   </a>
<!-- 47-->
   <a course-order="47" data-id="34793" target='_blank' xlink:href="https://artplay.academy/courses/level-47/">
      <path d="M78.0117 281.857L154.67 301.369C154.97 300.876 213.229 204.698 213.496 204.256L78.0117 281.857Z" fill="#3C97A7" stroke="#3C97A7", stroke-width="1"/>
   </a>
<!-- 27-->
   <a course-order="27" data-id="33940" target='_blank' xlink:href="https://artplay.academy/courses/level-27/">
      <path d="M213.496 204.256C213.229 204.698 154.97 300.876 154.67 301.369L231.33 320.883L231.367 320.838L213.531 204.234L213.496 204.256Z" fill="#429EB5" stroke="#429EB5", stroke-width="1"/>
   </a>
<!-- 23-->
   <a course-order="23" data-id="32571" target='_blank' xlink:href="https://artplay.academy/courses/level-23/">
     <path d="M213.496 204.256L213.531 204.233L231.367 320.837L231.33 320.882L231.371 320.893L269.639 257.717L213.559 204.147C213.558 204.147 213.496 204.256 213.496 204.256Z" fill="#4DA8BE" stroke="#4DA8BE", stroke-width="1"/>
   </a>
<!-- 3-->
   <a course-order="3" data-id="29840" target='_blank' xlink:href="https://artplay.academy/courses/level-3/">
     <path d="M231.371 320.894L373.697 357.121L269.639 257.719L231.371 320.894Z" fill="#51B3C8" stroke="#51B3C8", stroke-width="1"/>
   </a>
<!-- 76-->
   <a course-order="76" data-id="36118" target='_blank' xlink:href="https://artplay.academy/courses/level-76/">
     <path d="M0.789048 453.434L0.904282 453.403L0.8906 453.392L77.8945 281.865L77.9259 281.92L77.9414 281.897L77.9297 281.904L77.9376 281.838L1.26962 262.324L1.15829 262.508L0.771576 453.404L0.789048 453.434Z" fill="#2F3476" stroke="#2F3476", stroke-width="1"/>
   </a>
	<text x="-30" y="370" font-family="Arial" font-size="20" fill="black">Eb</text>
<!-- 70-->
   <a course-order="70" data-id="35875" target='_blank' xlink:href="https://artplay.academy/courses/level-70/">
     <path d="M0.904282 453.404L77.582 433.643L77.5643 433.612L77.8709 282.009L77.9256 281.921L77.8942 281.866L0.890289 453.394L0.904282 453.404Z" fill="#353B84" stroke="#353B84", stroke-width="1"/>
   </a>
<!-- 52-->
   <a course-order="52" data-id="35280" target='_blank' xlink:href="https://artplay.academy/courses/level-52/">
     <path d="M154.352 413.717L77.9258 281.922L77.873 282.01L77.5645 433.613L77.5822 433.643L154.354 413.858L154.352 413.717Z" fill="#3A4193" stroke="#3A4193", stroke-width="1"/>
   </a>
<!-- 46-->
   46<a course-order="46" data-id="34731" target='_blank' xlink:href="https://artplay.academy/courses/level-46/">
     <path d="M77.9414 281.898L77.9259 281.921L154.352 413.716V413.675L154.358 413.677L154.584 301.511L154.67 301.368L78.012 281.857L77.9414 281.898Z" fill="#42499F" stroke="#42499F", stroke-width="1"/>
   </a>
<!-- 28-->
   <a course-order="28" data-id="34002" target='_blank' xlink:href="https://artplay.academy/courses/level-28/">
     <path d="M231.33 320.883L154.67 301.369L154.584 301.512L154.357 413.678L154.453 413.715L231.33 320.883Z" fill="#4850AF" stroke="#4850AF", stroke-width="1"/>
   </a>
<!-- 22-->
   <a course-order="22" data-id="32569" target='_blank' xlink:href="https://artplay.academy/courses/level-22/">
     <path d="M231.33 320.883L154.453 413.715L154.637 413.783L231.164 394.061L231.149 394.034L231.297 321.016L231.371 320.896L231.33 320.883Z" fill="#4F59B6" stroke="#4F59B6", stroke-width="1"/>
   </a>
<!-- 4-->
   <a course-order="4" data-id="29842" target='_blank' xlink:href="https://artplay.academy/courses/level-4/">
     <path d="M373.848 357.266L373.697 357.121L231.371 320.895L231.297 321.016L231.148 394.033L231.164 394.06L373.842 357.288L373.848 357.266Z" fill="#5D63BC" stroke="#5D63BC", stroke-width="1"/>
   </a>
<!-- 77-->
   <a course-order="77" data-id="36119" target='_blank' xlink:href="https://artplay.academy/courses/level-77/">
     <path d="M100.363 618.547L156.666 564.771L156.644 564.76V564.756L156.598 564.68L0.904235 453.405L0.789001 453.435L100.35 618.54L100.363 618.547Z" fill="#472F76" stroke="#472F76", stroke-width="1"/>
   </a>
	<text x="20" y="550" font-family="Arial" font-size="20" fill="black">Ab</text>
<!-- 69-->
   <a course-order="69" data-id="35844" target='_blank' xlink:href="https://artplay.academy/courses/level-69/">
     <path d="M156.598 564.68C156.248 564.101 77.6172 433.701 77.582 433.643L0.904297 453.404L156.598 564.68Z" fill="#503887" stroke="#503887", stroke-width="1"/>
   </a>
<!-- 53-->
   <a course-order="53" data-id="35282" target='_blank' xlink:href="https://artplay.academy/courses/level-53/">
     <path d="M154.354 413.857L77.582 433.643C77.6172 433.701 156.248 564.101 156.598 564.68L156.691 564.746L156.764 564.678L154.354 413.857Z" fill="#563D96" stroke="#563D96", stroke-width="1"/>
   </a>
<!-- 45-->
   <a course-order="45" data-id="34729" target='_blank' xlink:href="https://artplay.academy/courses/level-45/">
     <path d="M154.354 413.857L156.764 564.678L212.971 510.992L212.941 510.977C212.812 510.765 154.405 413.906 154.373 413.852L154.354 413.857Z" fill="#5D45A2" stroke="#5D45A2", stroke-width="1"/>
   </a>
<!-- 29-->
   <a course-order="29" data-id="34059" target='_blank' xlink:href="https://artplay.academy/courses/level-29/">
     <path d="M212.971 510.992L269.201 457.287L154.637 413.783L154.373 413.852C154.406 413.905 212.812 510.765 212.941 510.977L212.971 510.992Z" fill="#674BB0" stroke="#674BB0", stroke-width="1"/>
   </a>
<!-- 21-->
   <a course-order="21" data-id="32567" target='_blank' xlink:href="https://artplay.academy/courses/level-21/">
     <path d="M269.201 457.287L269.273 457.219L269.238 457.2L231.164 394.061L154.637 413.784L269.201 457.287Z" fill="#7254B7" stroke="#7254B7", stroke-width="1"/>
   </a>

<!-- 5 -->
	<a course-order="5" data-id="29846" target="_blank" xlink:href="https://artplay.academy/courses/level-5/">
     <path d="M269.273 457.219L373.82 357.365L231.165 394.06L269.273 457.219Z" fill="#7C60BB" stroke="#7C60BB" ,="" stroke-width="1"></path>
   </a>
<!-- 78-->
   <a course-order="78" data-id="36172" target='_blank' xlink:href="https://artplay.academy/courses/level-78/">
     <path d="M273.156 713.635L156.805 564.906L156.914 564.908L156.666 564.771L100.363 618.547L273.156 713.635Z" fill="#632E77" stroke="#632E77", stroke-width="1"/>
   </a>
	<text x="150" y="690" font-family="Arial" font-size="20" fill="black">Db</text>
<!-- 68-->
   <a course-order="68" data-id="35840" target='_blank' xlink:href="https://artplay.academy/courses/level-68/">
     <path d="M273.207 713.662L293.922 640.303C293.467 640.05 157.449 565.203 156.914 564.908L156.805 564.906L273.156 713.635L273.207 713.662Z" fill="#6D3485" stroke="#6D3485", stroke-width="1"/>
   </a>
<!-- 54-->
   <a course-order="54" data-id="35285" target='_blank' xlink:href="https://artplay.academy/courses/level-54/">
     <path d="M314.629 566.936L314.502 566.865L314.539 566.955L156.914 564.908C157.449 565.203 293.466 640.05 293.922 640.303L314.627 566.981L314.594 566.962L314.629 566.936Z" fill="#803D96" stroke="#803D96", stroke-width="1"/>
   </a>
<!-- 44-->
   <a course-order="44" data-id="34728" target='_blank' xlink:href="https://artplay.academy/courses/level-44/">
     <path d="M156.764 564.678L156.766 564.799L156.691 564.746L156.666 564.772L156.914 564.909L314.539 566.956L314.502 566.866C313.999 566.587 213.029 511.025 212.971 510.993L156.764 564.678Z" fill="#8C44A3" stroke="#8C44A3", stroke-width="1"/>
   </a>
<!-- 30-->
   <a course-order="30" data-id="34113" target='_blank' xlink:href="https://artplay.academy/courses/level-30/">
     <path d="M212.971 510.992C213.029 511.022 313.998 566.587 314.502 566.865L269.238 457.301L269.201 457.286L212.971 510.992Z" fill="#954AB1" stroke="#954AB1", stroke-width="1"/>
   </a>
<!-- 20-->
	<a course-order="20" data-id="30701" target='_blank' xlink:href="https://artplay.academy/courses/level-20/">
     <path d="M269.201 457.287L269.238 457.302L314.502 566.867L314.629 566.937L314.642 566.926L335.355 493.582L269.273 457.219L269.201 457.287Z" fill="#A057B9" stroke="#A057B9", stroke-width="1"/>
   </a>
<!-- 6-->
   6<a course-order="6" data-id="39967" target='_blank' xlink:href="https://artplay.academy/courses/level-6/">
     <path d="M269.273 457.219L335.355 493.582L373.82 357.365L269.273 457.219Z" fill="#A464BF" stroke="#A464BF", stroke-width="1"/>
   </a>
<!-- 79-->
   <a course-order="79" data-id="36198" target='_blank' xlink:href="https://artplay.academy/courses/level-79/">
     <path d="M473.166 713.221L452.732 639.961L452.706 639.963L452.622 640.01H452.454L452.492 640.029L273.332 713.663L473.039 713.29L473.166 713.221Z" fill="#772E5C" stroke="#772E5C", stroke-width="1"/>
	  
   </a>
	<text x="345" y="740" font-family="Arial" font-size="20" fill="black">F#/Gb</text>
<!-- 67-->
   <a course-order="67" data-id="35775" target='_blank' xlink:href="https://artplay.academy/courses/level-67/">
     <path d="M273.332 713.664L452.492 640.029L452.454 640.01L293.927 640.305L293.921 640.303L273.206 713.663L273.21 713.665L273.332 713.664Z" fill="#813463" stroke="#813463", stroke-width="1"/>
   </a>
<!-- 55-->
   <a course-order="55" data-id="35286" target='_blank' xlink:href="https://artplay.academy/courses/level-55/">
     <path d="M314.627 566.98L293.922 640.303L293.926 640.305L452.455 640.01L314.627 566.98Z" fill="#8B386D" stroke="#8B386D", stroke-width="1"/>
   </a>
<!-- 43-->
   <a course-order="43" data-id="34682" target='_blank' xlink:href="https://artplay.academy/courses/level-43/">
     <path d="M452.707 639.963L452.558 639.982L452.684 639.783L432.295 566.677L432.207 566.726L314.642 566.945L314.639 566.943L314.627 566.982L452.455 640.011H452.623L452.707 639.963Z" fill="#993E78" stroke="#993E78", stroke-width="1"/>
   </a>
<!-- 31-->
 <a course-order="31" data-id="34173" target='_blank' xlink:href="https://artplay.academy/courses/level-31/">
     <path d="M432.295 566.676L411.867 493.438L411.856 493.436L314.643 566.926L314.639 566.941L314.643 566.943L432.207 566.724L432.295 566.676Z" fill="#A74681" stroke="#A74681", stroke-width="1"/>
   </a>
<!-- 19-->
   <a course-order="19" data-id="30702" target='_blank' xlink:href="https://artplay.academy/courses/level-19/">
     <path d="M314.643 566.926L411.855 493.436L411.867 493.438L411.859 493.404L411.793 493.441L335.357 493.584L314.643 566.926Z" fill="#B34E91" stroke="#B34E91", stroke-width="1"/>
   </a>
<!-- 7-->
   <a course-order="7" data-id="29845" target='_blank' xlink:href="https://artplay.academy/courses/level-7/">
     <path d="M373.82 357.365L335.355 493.582L411.793 493.442L411.859 493.404L373.904 357.318L373.886 357.303L373.82 357.365Z" fill="#BA5B95" stroke="#BA5B95", stroke-width="1"/>
   </a>

<!-- 80-->
   <a course-order="80" data-id="36227" target='_blank' xlink:href="https://artplay.academy/courses/level-80/">
		<path d="M646.291 617.516L646.17 617.4L646.159 617.479L452.731 639.961L473.165 713.221L646.288 617.52L646.291 617.516Z" fill="#762F3B" stroke="#762F3B", stroke-width="1"/>
   	</a>
	<text x="570" y="690" font-family="Arial" font-size="20" fill="black">B</text>
<!-- 66-->
   <a course-order="66" data-id="35697" target='_blank' xlink:href="https://artplay.academy/courses/level-66/">
     <path d="M646.17 617.4L590.215 563.949C589.765 564.198 452.944 639.833 452.73 639.951L452.732 639.963L646.16 617.48L646.17 617.4Z" fill="#7F343F" stroke="#7F343F", stroke-width="1"/>
   </a>
<!-- 56-->
   <a course-order="56" data-id="35403" target='_blank' xlink:href="https://artplay.academy/courses/level-56/">
     <path d="M452.684 639.781L452.73 639.951C452.944 639.833 589.763 564.201 590.213 563.951L534.137 510.379C534.136 510.379 533.877 510.523 533.875 510.524L452.684 639.781Z" fill="#873841" stroke="#873841", stroke-width="1"/>
   </a>
<!-- 42-->
   <a course-order="42" data-id="34632" target='_blank' xlink:href="https://artplay.academy/courses/level-42/">
     <path d="M452.684 639.781L533.875 510.523C533.135 510.934 432.47 566.579 432.295 566.676L452.684 639.781Z" fill="#913C48" stroke="#913C48", stroke-width="1"/>
   </a>
<!-- 8-->
   <a course-order="8" data-id="29850" target='_blank' xlink:href="https://artplay.academy/courses/level-8/">
     <path d="M411.859 493.404L478.057 456.811L373.904 357.318L411.859 493.404Z" fill="#B14A58" stroke="#B14A58", stroke-width="1"/>
   </a>
<!-- 18-->
   <a course-order="18" data-id="30703" target='_blank' xlink:href="https://artplay.academy/courses/level-18/">
     <path d="M411.859 493.404L411.867 493.438L533.988 510.239L478.056 456.811L411.859 493.404Z" fill="#A84553" stroke="#A84553", stroke-width="1"/>
   </a>
<!-- 32-->
   <a course-order="32" data-id="34174" target='_blank' xlink:href="https://artplay.academy/courses/level-32/">
     <path d="M533.996 510.246L533.988 510.239L411.867 493.438L432.295 566.676C432.47 566.579 533.135 510.934 533.875 510.524L534.008 510.313L533.996 510.246Z" fill="#9B424D" stroke="#9B424D", stroke-width="1"/>
   </a>
<!-- 81-->
   <a course-order="81" data-id="36243" target='_blank' xlink:href="https://artplay.academy/courses/level-81/">
     <path d="M746.531 452.023L669.828 432.498V432.509L669.758 432.627L646.17 617.4L646.291 617.515L746.531 452.023Z" fill="#7F4634" stroke="#7F4634", stroke-width="1"/>
   </a>
	<text x="700" y="550" font-family="Arial" font-size="20" fill="black">E</text>
<!-- 65 -->
   <a course-order="65" data-id="35669" target='_blank' xlink:href="https://artplay.academy/courses/level-65/">
     <path d="M669.758 432.627L590.215 563.949L646.17 617.4L669.758 432.627Z" fill="#8A4D35" stroke="#8A4D35", stroke-width="1"/>
   </a>
<!-- 57 -->
	<a course-order="57" data-id="35444" target="_blank" xlink:href="https://artplay.academy/courses/level-57/">
     <path d="M534.209 510.26L534.137 510.379L590.215 563.949L669.758 432.627L534.209 510.26Z" fill="#934F3A" stroke="#934F3A" ,="" stroke-width="1"></path>
   </a>
<!-- 41 -->
   <a course-order="41" data-id="34577" target='_blank' xlink:href="https://artplay.academy/courses/level-41/">
     <path d="M534.209 510.26L669.771 432.516L669.756 432.627L669.827 432.51V432.498L593.114 412.973V413.003L534.209 510.26Z" fill="#9E583F" stroke="#9E583F", stroke-width="1"/>
   </a>
<!-- 33 -->
   <a course-order="33" data-id="34175" target='_blank' xlink:href="https://artplay.academy/courses/level-33/">
     <path d="M516.48 393.465L533.996 510.238L534.049 510.246L534.03 510.276L534.087 510.331L534.21 510.259L593.116 413.003V412.973L516.48 393.465Z" fill="#A75B44" stroke="#A75B44", stroke-width="1"/>
   </a>
<!-- 17 -->
   <a course-order="17" data-id="30704" target='_blank' xlink:href="https://artplay.academy/courses/level-17/">
     <path d="M516.48 393.465L516.406 393.446V393.501L478.061 456.807L478.057 456.809L533.989 510.237H533.996L516.48 393.465Z" fill="#B1624A" stroke="#B1624A", stroke-width="1"/>
   </a>
<!-- 9 -->
   <a course-order="9" data-id="29849" target='_blank' xlink:href="https://artplay.academy/courses/level-9/">
     <path d="M373.896 357.293L373.904 357.319L478.056 456.812L478.06 456.81L516.406 393.503V393.448L374.097 357.224L373.922 357.27L373.896 357.293Z" fill="#B86951" stroke="#B86951", stroke-width="1"/>
   </a>
<!-- 82 -->
   <a course-order="82" data-id="36272" target='_blank' xlink:href="https://artplay.academy/courses/level-82/">
      <path d="M746.928 261.137L746.905 261.144L669.831 432.431L669.829 432.428V432.5L746.532 452.025L746.54 452.014L746.928 261.137Z" fill="#7D692E" stroke="#7D692E", stroke-width="1"/>
   </a>
	<text x="755" y="370" font-family="Arial" font-size="20" fill="black">A</text>
<!-- 64 -->
   <a course-order="64" data-id="35577" target='_blank' xlink:href="https://artplay.academy/courses/level-64/">
      <path d="M746.904 261.143L670.135 280.928C670.135 281.159 669.828 432.258 669.828 432.426L669.83 432.43L746.904 261.143Z" fill="#887031" stroke="#887031", stroke-width="1"/>
   </a>
<!-- 58 -->
   <a course-order="58" data-id="35496" target='_blank' xlink:href="https://artplay.academy/courses/level-58/">
      <path d="M669.828 432.426C669.829 432.258 670.135 281.159 670.135 280.928L593.389 300.707V300.73L593.355 300.715L593.347 300.718V300.777L593.373 300.747L669.828 432.426Z" fill="#937C36" stroke="#937C36", stroke-width="1"/>
   </a>
<!-- 40 -->
   40<a course-order="40" data-id="34521" target='_blank' xlink:href="https://artplay.academy/courses/level-40/">
      <path d="M669.828 432.426L593.371 300.746L593.345 300.776C593.341 301.317 593.114 412.909 593.114 412.972L669.827 432.497L669.828 432.426Z" fill="#9D823A" stroke="#9D823A", stroke-width="1"/>
   </a>
<!-- 34 -->
   <a course-order="34" data-id="34176" target='_blank' xlink:href="https://artplay.academy/courses/level-34/">
      <path d="M593.346 300.777L516.475 393.422L516.482 393.465L593.117 412.973C593.117 412.91 593.342 301.318 593.346 300.777Z" fill="#A88C3F" stroke="#A88C3F", stroke-width="1"/>
   </a>
<!-- 16 -->
   <a course-order="16" data-id="30698" target='_blank' xlink:href="https://artplay.academy/courses/level-16/">
      <path d="M593.346 300.777V300.719L516.553 320.51L516.406 393.447L516.48 393.466L516.473 393.423L593.346 300.777Z" fill="#B39544" stroke="#B39544", stroke-width="1"/>
   </a>
<!-- 10 -->
  <a course-order="10" data-id="29848" target='_blank' xlink:href="https://artplay.academy/courses/level-10/">
     <path d="M516.406 393.447L516.553 320.51L374.098 357.223L516.406 393.447Z" fill="#BB9C4A" stroke="#BB9C4A", stroke-width="1"/>
   </a>
<!-- 15 -->
   <a course-order="15" data-id="30695" target='_blank' xlink:href="https://artplay.academy/courses/level-15/">
      <path d="M478.504 257.383L516.553 320.482V320.509L593.346 300.718V300.71L478.602 257.4L478.568 257.318L478.504 257.383Z" fill="#B5D132" stroke="#B5D132", stroke-width="1"/>
   </a>
<!-- 59 -->
   59<a course-order="59" data-id="35524" target='_blank' xlink:href="https://artplay.academy/courses/level-59/">
      <path d="M591.094 149.846L593.389 300.707L670.135 280.928V280.905C670.135 280.905 591.291 150.151 591.102 149.837L591.094 149.846Z" fill="#98B829" stroke="#98B829", stroke-width="1"/>
   </a>
<!-- 11 -->
   <a course-order="11" data-id="29847" target='_blank' xlink:href="https://artplay.academy/courses/level-11/">
      <path d="M373.996 357.197L374.098 357.224L516.553 320.511V320.484L478.504 257.383L373.996 357.197Z" fill="#BBD445" stroke="#BBD445", stroke-width="1"/>
   </a>
<!-- 35 -->
   <a course-order="35" data-id="34179" target='_blank' xlink:href="https://artplay.academy/courses/level-35/">
      <path d="M478.568 257.32L478.602 257.402L593.347 300.713V300.694C593.347 300.694 535.08 204.07 534.802 203.61L478.568 257.32Z" fill="#AECA2D" stroke="#AECA2D", stroke-width="1"/>
   </a>
<!-- 39 -->
   <a course-order="39" data-id="34460" target='_blank' xlink:href="https://artplay.academy/courses/level-39/">
     <path d="M534.801 203.611C535.079 204.072 593.346 300.695 593.346 300.695V300.714L593.353 300.716L593.387 300.709L591.092 149.847L534.801 203.611Z" fill="#A7C22B" stroke="#A7C22B", stroke-width="1"/>
   </a>
<!-- 63 -->
   <a course-order="63" data-id="35566" target='_blank' xlink:href="https://artplay.academy/courses/level-63/">
     <path d="M591.102 149.838C591.291 150.152 670.135 280.906 670.135 280.906V280.929L746.904 261.144L746.916 261.117L591.201 149.744L591.102 149.838Z" fill="#94B027" stroke="#94B027", stroke-width="1"/>
   </a>
<!-- 83 -->
   <a course-order="83" data-id="36321" target='_blank' xlink:href="https://artplay.academy/courses/level-83/">
     <path d="M647.4 96.0664L591.201 149.744L746.916 261.117L746.905 261.144L746.927 261.136V261.113L647.4 96.0664Z" fill="#899E25" stroke="#899E25", stroke-width="1"/>
   </a>
	<text x="720" y="180" font-family="Arial" font-size="20" fill="black">D</text>
<!-- 84 -->
   <a course-order="84" data-id="36385" target='_blank' xlink:href="https://artplay.academy/courses/level-84/">
      <path d="M474.725 0.986328L591.092 149.713V149.666L591.201 149.744L647.4 96.0664L647.35 95.9805L474.725 0.986328Z" fill="#4D922B" stroke="#4D922B", stroke-width="1"/>
   </a>
<!-- 62 -->
   <a course-order="62" data-id="35564" target='_blank' xlink:href="https://artplay.academy/courses/level-62/">
     <path d="M453.777 74.2188C453.963 74.3197 591.057 149.76 591.057 149.76L591.068 149.777L591.094 149.779L591.092 149.713L474.725 0.986223L474.495 0.8573L453.777 74.2188Z" fill="#529B2E" stroke="#529B2E", stroke-width="1"/>
   </a>
	<text x="570" y="30" font-family="Arial" font-size="20" fill="black">G</text>
<!-- 60 -->
   <a course-order="60" data-id="35561" target='_blank' xlink:href="https://artplay.academy/courses/level-60/">
     <path d="M433.09 147.568L591.066 149.777L591.055 149.762C591.055 149.762 453.962 74.3197 453.776 74.2189L433.079 147.51L433.131 147.537L433.09 147.568Z" fill="#56A42F" stroke="#56A42F", stroke-width="1"/>
   </a>
<!-- 38 -->
   <a course-order="38" data-id="34458" target='_blank' xlink:href="https://artplay.academy/courses/level-38/">
     <path d="M433.074 147.582C433.442 147.785 534.76 203.539 534.76 203.539L534.801 203.611L591.094 149.846V149.824L591.067 149.777L433.091 147.568L433.074 147.582Z" fill="#60B134" stroke="#60B134", stroke-width="1"/>
   </a>
<!-- 36 -->
   <a course-order="36" data-id="34182" target='_blank' xlink:href="https://artplay.academy/courses/level-36/">
      <path d="M433.057 147.594L433.049 147.619L478.567 257.32L534.799 203.611L534.758 203.543C534.758 203.543 433.44 147.785 433.072 147.582L433.057 147.594Z" fill="#6BC53E" stroke="#6BC53E", stroke-width="1"/>
   </a>
<!-- 14 -->
   <a course-order="14" data-id="30694" target='_blank' xlink:href="https://artplay.academy/courses/level-14/">
      <path d="M478.504 257.383L478.568 257.32L433.051 147.619L412.346 220.936L478.465 257.319L478.504 257.383Z" fill="#7FCD58" stroke="#7FCD58", stroke-width="1"/>
   </a>
<!-- 12 -->
   <a course-order="12" data-id="40133" target='_blank' xlink:href="https://artplay.academy/courses/level-12/">
     <path d="M373.996 357.197L478.504 257.383L478.465 257.318L412.346 220.935L373.877 357.168L373.996 357.197Z" fill="#8DD267" stroke="#8DD267", stroke-width="1"/>
   </a>
<!-- 73 -->
   <a course-order="73" data-id="36074" target='_blank' xlink:href="https://artplay.academy/courses/level-73/">
     <path d="M474.309 0.855469L274.66 1.2285L274.6 1.26176L295.035 74.5333L295.076 74.5098H295.178L474.309 0.855469Z" fill="#287A38" stroke="#287A38", stroke-width="1"/>
   	</a>
	<text x="365" y="-10" font-family="Arial" font-size="20" fill="black">C</text>
<!-- 61 -->
   <a course-order="61" data-id="35563" target='_blank' xlink:href="https://artplay.academy/courses/level-61/">
     <path d="M474.309 0.855476L295.178 74.5098L453.771 74.2149L453.779 74.2186L474.496 0.857307L474.488 0.855347L474.309 0.855476Z" fill="#2A803D" stroke="#2A803D", stroke-width="1"/>
   </a>
<!-- 49 -->
   <a course-order="49" data-id="35275" target='_blank' xlink:href="https://artplay.academy/courses/level-49/">
     <path d="M295.178 74.5098L295.055 74.5606L433.08 147.51L453.777 74.2187L453.77 74.215L295.178 74.5098Z" fill="#2E8840" stroke="#2E8840", stroke-width="1"/>
   </a>
<!-- 37 -->
   <a course-order="37" data-id="34456" target='_blank' xlink:href="https://artplay.academy/courses/level-37/">
     <path d="M295.102 74.5859L295.066 74.6426L315.471 147.805L315.492 147.793L433.031 147.574L433.029 147.568H433.063L433.078 147.51L295.102 74.5859Z" fill="#308D42" stroke="#308D42", stroke-width="1"/>
   </a>
<!-- 25 -->
   <a course-order="25" data-id="33903" target='_blank' xlink:href="https://artplay.academy/courses/level-25/">
     <path d="M335.906 221.076H335.912L433.045 147.604L433.03 147.574L315.495 147.793L315.47 147.805L335.906 221.076Z" fill="#349B49" stroke="#349B49", stroke-width="1"/>
   </a>
<!-- 13 -->
   <a course-order="13" data-id="30654" target='_blank' xlink:href="https://artplay.academy/courses/level-13/">
     <path d="M335.912 221.076L412.344 220.934L433.051 147.619L433.043 147.604L335.912 221.076Z" fill="#38A64F" stroke="#38A64F", stroke-width="1"/>
   </a>
<!-- 1 -->
   <a course-order="1" data-id="29838" target="_blank" xlink:href="https://artplay.academy/courses/level-1/">
     <path d="M335.91 221.076L335.906 221.078L373.861 357.164L373.877 357.168L412.345 220.935L335.91 221.076Z" fill="#40AF5E" stroke="#40AF5E", stroke-width="1"/>
   </a>

</svg>
<?php get_footer(); ?>