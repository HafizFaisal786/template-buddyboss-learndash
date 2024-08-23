

  function getLevelNumber() {
    const url = window.location.href;
    const urlObj = new URL(url);
    const courseName = urlObj.searchParams.get('course_name');
    if (courseName && courseName.startsWith('level-')) {
      const match = courseName.match(/level-(\d+)/);
      if (match) {
        return parseInt(match[1], 10);
      }
    }
    return null;
  }

  function applyColorVariable() {
    let levelToColorVar = {
        1: '--color-set1', 13: '--color-set1', 25: '--color-set1', 49: '--color-set1', 61: '--color-set1', 73: '--color-set1',
        2: '--color-set2', 24: '--color-set2', 26: '--color-set2', 48: '--color-set2', 50: '--color-set2', 72: '--color-set2', 74: '--color-set2',
        3: '--color-set3', 23: '--color-set3', 27: '--color-set3', 47: '--color-set3', 51: '--color-set3', 71: '--color-set3', 75: '--color-set3',
        4: '--color-set4', 22: '--color-set4', 28: '--color-set4', 46: '--color-set4', 52: '--color-set4', 70: '--color-set4', 76: '--color-set4',
        5: '--color-set5', 21: '--color-set5', 29: '--color-set5', 45: '--color-set5', 53: '--color-set5', 69: '--color-set5', 77: '--color-set5',
        6: '--color-set6', 20: '--color-set6', 30: '--color-set6', 44: '--color-set6', 54: '--color-set6', 68: '--color-set6', 78: '--color-set6',
        7: '--color-set7', 19: '--color-set7', 31: '--color-set7', 43: '--color-set7', 55: '--color-set7', 67: '--color-set7', 79: '--color-set7',
        8: '--color-set8', 18: '--color-set8', 32: '--color-set8', 42: '--color-set8', 56: '--color-set8', 66: '--color-set8', 80: '--color-set8',
        9: '--color-set9', 17: '--color-set9', 33: '--color-set9', 41: '--color-set9', 57: '--color-set9', 65: '--color-set9', 81: '--color-set9',
        10: '--color-set10', 16: '--color-set10', 34: '--color-set10', 40: '--color-set10', 58: '--color-set10', 64: '--color-set10', 82: '--color-set10',
        11: '--color-set11', 15: '--color-set11', 35: '--color-set11', 39: '--color-set11', 59: '--color-set11', 63: '--color-set11', 83: '--color-set11',
        12: '--color-set12', 14: '--color-set12', 36: '--color-set12', 38: '--color-set12', 60: '--color-set12', 62: '--color-set12', 84: '--color-set12'
      };
    $('.color').each(function() {
        const number = getLevelNumber();
      const colorVar = levelToColorVar[number] || '--default-color';
      $(this).css('--box-color', `var(${colorVar})`);
    });
  }
  applyColorVariable();


function updateTextPosition() {
    const breadcrumbTitle = $('.slide-title');
    const breadcrumbPolygon = $('.breadcrumb-svg polygon');
    const breadcrumbSvgs = $('.breadcrumb-svg');
    const width = window.innerWidth;
    let xPosition;
    let yposition;
    if (width <= 539){
        xPosition = '70';
        yposition = '20'
        breadcrumbPolygon.attr('points', '220,0 250,15 220,30 0,30 0,0');
        breadcrumbSvgs.attr('viewBox', '0 0 250 30');
    }
    breadcrumbTitle.attr('x', xPosition);
    breadcrumbTitle.attr('y', yposition);
}

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

updateTextPosition();
$(window).on('resize', debounce(updateTextPosition, 200));


$(document).ready(function() {
    $(document).on('click', '.mfp-close', function(e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    document.getElementById('openPopup').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('second-popup').style.display = 'flex';
    });

    document.getElementById('closePopup').addEventListener('click', function() {
        document.getElementById('second-popup').style.display = 'none';
    });
    $(document).on('keydown', function(event) {
        if (event.key === 'Escape' || event.keyCode === 27) { 
            document.getElementById('second-popup').style.display = 'none';
            document.getElementById('help-popup').style.display = 'none';
        }
    });
    document.getElementById('closeHelp').addEventListener('click', function() {
        document.getElementById('help-popup').style.display = 'none';
    });

    $(document).on('click', '.mfp-close', function() {
        if ($(this).closest('.popup-inner').length) {
            $.magnificPopup.instance.close();
        }
    });

    function CloseIconPosition(){
        mediaQuery = window.matchMedia('(min-width: 1080px)');
        if(mediaQuery.matches){
            $('.mfp-close').remove();
            $('.slider-breadcrumb').prepend('<a class="mfp-close close-button"><img src="https://artplay.academy/wp-content/uploads/2024/08/cross-icon.svg" alt="Close Icon"></a>')
        }
    }
    CloseIconPosition();

    let challengeNotes = "";
    let warmupNotes = "";
    let playNotes = "";
    let postId = "";

// Event listener for fetching notes data
$(document).on('click', '.course-lesson-bubble', function(event) {
    event.preventDefault();
    postId = $(this).closest('a#openPopover').data('id'); // Correctly get the post ID

    // Skip AJAX if notes are already fetched
    if (challengeNotes || warmupNotes || playNotes) {
        console.log('Notes data for post ' + postId + ' already fetched.');
        return;
    }

    $.ajax({
        url: ajax_object.ajax_url,
        type: 'POST',
        data: {
            action: 'load_slide_notes',
            post_id: postId,
            nonce: ajax_object.nonce
        },
        success: function(response) {
            if (response.success) {
                const data = response.data;
                challengeNotes = data.challenge || "";
                warmupNotes = data.warmup || "";
                playNotes = data.play || "";
                $('#notes-editor-container-' + postId).show();
            }
        },
        error: function() {
            console.error('Failed to load notes for post ' + postId);
        }
    });
});

// Event listener for saving notes
$(document).on('click', '.save-notes-button', function(event) {
    const button = $(this);
    const noteType = button.data('note-type');
    const postId = button.data('post-id');
    const notesContent = $('#notes-editor-' + noteType + '-' + postId).val();
    const statusElement = $('#notes-status-' + postId);

    $.ajax({
        url: ajax_object.ajax_url,
        type: 'POST',
        data: {
            action: 'save_slide_notes',
            post_id: postId,
            note_type: noteType,
            notes_content: notesContent,
            nonce: ajax_object.nonce
        },
        success: function(response) {
            if (response.success) {
                statusElement.text(noteType.charAt(0).toUpperCase() + noteType.slice(1) + ' notes saved successfully!');
                // Update the notes cache
                switch (noteType) {
                    case 'warmup':
                        warmupNotes = notesContent;
                        break;
                    case 'challenge':
                        challengeNotes = notesContent;
                        break;
                    case 'play':
                        playNotes = notesContent;
                        break;
                }
            } else {
                statusElement.text('Failed to save ' + noteType + ' notes.');
            }
        },
        error: function() {
            statusElement.text('Failed to save ' + noteType + ' notes.');
        }
    });
});

// Event listener for showing the popup
$(document).on('click', '.warmup-lesson-notes, .challenge-lesson-notes, .play-lesson-notes', function(event) {
    event.preventDefault();
    event.stopPropagation();

    const clickedElement = $(event.currentTarget);
    const noteType = clickedElement.data('note-type');

    if (!noteType) {
        console.error('Note type is undefined');
        return;
    }

    let noteContent = '';

    switch (noteType) {
        case 'warmup':
            noteContent = warmupNotes;
            break;
        case 'challenge':
            noteContent = challengeNotes;
            break;
        case 'play':
            noteContent = playNotes;
            break;
        default:
            console.error('Invalid note type:', noteType);
            noteContent = '';
            break;
    }

    const noteEditorId = `notes-editor-${noteType}-${postId}`;

$('#help-popup .popup-body').html(
    '<textarea tabindex="0" class="notes-editor" id="' + noteEditorId + '" rows="5" cols="50">' + 
    noteContent + '</textarea>' +
    '<button class="save-notes-button" data-note-type="' + noteType + '" data-post-id="' + postId + '">' +
    'Save ' + noteType.charAt(0).toUpperCase() + noteType.slice(1) + ' Notes</button>'
);

    $('#help-popup').css('display', 'flex');
    $('#help-popup').addClass('notes-popup');
    $('#help-popup').removeClass('help-popup challenge-popup');
    $('#help-popup .second-popup-title').html('<img src="https://artplay.academy/wp-content/uploads/2024/08/note.svg">Notes');
});


    function setProgress(percentage) {
        const circle = document.querySelector('.progress-bar');
        const radius = circle.r.baseVal.value;
        const circumference = 2 * Math.PI * radius;
        const offset = circumference - (percentage / 100) * circumference;
        circle.style.strokeDasharray = `${circumference} ${circumference}`;
        circle.style.strokeDashoffset = offset;
    }

    const progress = document.getElementById('progress-value').dataset.progress;
    setProgress(progress);
});


function buildJourney(callback) {
    const journeyContent = document.getElementById('journey-content');
    journeyContent.innerHTML = htmlContent;

    const lineElements = document.querySelectorAll('.line');
    const bubbleElements = document.querySelectorAll('.course-lesson-bubble');

    lineElements.forEach((line, index) => {
        const fromElem = bubbleElements[index];
        const toElem = bubbleElements[index + 1];

        if (!toElem) return;

        const fromRect = fromElem.getBoundingClientRect();
        const toRect = toElem.getBoundingClientRect();
        const containerRect = journeyContent.getBoundingClientRect();
        const fromStartX = fromRect.left - containerRect.left + (fromElem.offsetWidth / 2);
        const fromStartY = fromRect.bottom - containerRect.top;
        let top = fromRect.height;
        const toEndX = toRect.left - containerRect.left + (toElem.offsetWidth / 2);
        const toEndY = toRect.bottom - containerRect.top;
        const deltaX = toEndX - fromStartX;
        const deltaY = toEndY - fromStartY;
        const length = Math.sqrt(deltaX ** 2 + deltaY ** 2);
        const angle = Math.atan2(deltaY, deltaX) * (180 / Math.PI);

        let adjustedFromStartX = fromStartX;
        let adjustedFromStartY = fromStartY;

        if (angle > 60) {
            adjustedFromStartX -= 20;
            top -= 10;
        } else {
            adjustedFromStartX += 20;
            top -= 10;
        }

        const mediaQuery = window.matchMedia('(max-width: 335px)');

        function applyConditions() {
            if (mediaQuery.matches) {
                if (angle < 65) {
                    adjustedFromStartX += 30;
                    top -= 10;
                }
            }
        }
        applyConditions();

        line.style.position = 'absolute';
        line.style.top = `${top}px`;
        line.style.left = `${adjustedFromStartX}px`;
        line.style.width = `126px`;
        line.style.transform = `rotate(${angle}deg)`;
        line.style.height = '4px';
        line.style.transformOrigin = '0 0';

        const arrowIcon = line.querySelector('.arrow-icon');
        if (arrowIcon) {
            arrowIcon.style.position = 'absolute';
            arrowIcon.style.left = '38%';
            arrowIcon.style.top = `-17px`;
            arrowIcon.style.transform = `translate(-50%, 1)`;
            arrowIcon.style.width = '30px';
            arrowIcon.style.height = '30px';
        }
    });

        if (typeof applyColorVariable === 'function') {
            applyColorVariable();
        }
        
        function darkenRgb(r, g, b, percent) {
            const factor = (100 - percent) / 100;
            const newR = Math.round(r * factor);
            const newG = Math.round(g * factor);
            const newB = Math.round(b * factor);
            return `rgb(${newR}, ${newG}, ${newB})`;
          }

          const rgbColor = $('.course-lesson-bubble.inprogress').css('background-color');
          if (rgbColor) {
              const [r, g, b] = rgbColor.match(/\d+/g).map(Number);
              const darkerColor = darkenRgb(r, g, b, 30);
              $('.course-lesson-bubble.inprogress').css('border-color', darkerColor);
              $('.course-lesson-bubble.completed').css('border-color', darkerColor);
              $('.course-lesson-view.completed .line').css('border-top-color', darkerColor);
          }

        if (callback) callback();
}
window.onload = () => {
    buildJourney(() => {
        let element = document.querySelector('.inprogress');
        if (element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('click', (e) => {
        let anchorElement = e.target.closest('a#openPopover');

        if (anchorElement) {
            e.preventDefault();
            const dataId = anchorElement.dataset.id;
            const dataStatus = anchorElement.dataset.status;
            const newLessons = Object.values(lessons);
            const newLessonDetail = Object.values(lessonsDetails);
            const lesson = newLessons.find(l => l.id == dataId);
            const lessonDesc = newLessonDetail.find(l => l.title == lesson.post.post_title)

            if (!lesson) {
                console.error('Lesson not found');
                return;
            }
            let existingPopover = document.getElementById('popover');
            if (existingPopover) {
                existingPopover.remove();
            }
            const buttonClass = dataStatus === "inactive" ? "disabled_btn" : "";
            const mfpSource = dataStatus === "inactive"? '' : '#popup';
            const popover = document.createElement('div');
            popover.id = 'popover';
            popover.className = 'popover';
            let lessonContent = lessonDesc['description'] ? lessonDesc['description'] : "No description found";
            popover.innerHTML = `
                <div class="popover-content">
                    <div class="close-btn">
                        <button id="closePopover" class="closePopup closePopover">X</button>
                    </div>
                    <div class="popover-body">
                        <div class="popover-title">${lesson.post.post_title}</div>
                        <div class="popover-description">
                            ${lessonContent}
                        </div>
                        <div class="play-button">
                            <button class="open-popup ${buttonClass}" data-mfp-src="${mfpSource}">Play</button>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(popover);

            if (dataId) {
                const lessonContent = lessonContents[dataId];
                const {
                    intro_intro_image: introImage,
                    intro_intro_text: introText,
                    challenge_slide_challenge_video: challengeVideoUrl,
                    challenge_slide_challenge_bonus: challengeBonus,
                    challenge_slide_challenge_help: challengeHelp,
                    warmup_slide_warmup_video: warmupVideoUrl,
                    warmup_slide_warmup_bonus: warmupBonus,
                    warmup_slide_warmup_help: warmupHelp,
                    play_slide_play_help: playHelp,
                    play_slide_play_bonus: playBonus,

                } = lessonContent;

                    $('.warmup-lesson-help, .challenge-lesson-help, .play-lesson-help').on('click', function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        if(warmupHelp || challengeHelp || playHelp){
                            const clickedElement = $(e.currentTarget);
                            if (clickedElement.hasClass('warmup-lesson-help') && warmupHelp) {
                                $('#help-popup .popup-body').html(warmupHelp);
                                } else if (clickedElement.hasClass('challenge-lesson-help') && challengeHelp) {
                                    $('#help-popup .popup-body').html(challengeHelp);
                                } else if (clickedElement.hasClass('play-lesson-help') && playHelp) {
                                    $('#help-popup .popup-body').html(playHelp);
                                }
                        } else {
                            $('#help-popup .popup-body').html('No Help content found for this lesson.');
                        }
                            $('#help-popup').addClass('help-popup');
                            $('#help-popup').removeClass('challenge-popup notes-popup');
                            $('#help-popup .second-popup-title').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 17H12.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.08997 8.99996C9.32507 8.33163 9.78912 7.76807 10.3999 7.40909C11.0107 7.05012 11.7289 6.9189 12.4271 7.03867C13.1254 7.15844 13.7588 7.52148 14.215 8.06349C14.6713 8.60549 14.921 9.29148 14.92 9.99996C14.92 12 11.92 13 11.92 13" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Help');
                            $('#help-popup').css('display', 'flex');
                    })
                    $('.warmup-lesson-bonus, .challenge-lesson-bonus, .play-lesson-bonus').on('click', function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        if(challengeBonus || warmupBonus || playBonus){
                            const clickedElement = $(e.currentTarget);
                            if (clickedElement.hasClass('warmup-lesson-bonus') && warmupBonus) {
                                $('#help-popup .popup-body').html(warmupBonus);
                                } else if (clickedElement.hasClass('challenge-lesson-bonus') && challengeBonus) {
                                    $('#help-popup .popup-body').html(challengeBonus);
                                } else if (clickedElement.hasClass('play-lesson-bonus') && playBonus) {
                                    $('#help-popup .popup-body').html(playBonus);
                            }
                        } else {
                                $('#help-popup .popup-body').html('No Bonus content found for this lesson.');
                            }
                        $('#help-popup').addClass('challenge-popup');
                        $('#help-popup').removeClass('help-popup notes-popup');
                        $('#help-popup .second-popup-title').html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" viewBox="0 0 16 20" fill="none"><path d="M13.91 8.72002H10.82V1.52002C10.82 -0.15998 9.91001 -0.499981 8.80001 0.760019L8.00001 1.67002L1.23001 9.37002C0.300011 10.42 0.690012 11.28 2.09001 11.28H5.18001V18.48C5.18001 20.16 6.09001 20.5 7.20001 19.24L8.00001 18.33L14.77 10.63C15.7 9.58002 15.31 8.72002 13.91 8.72002Z" fill="#444444"/></svg>Bonus');
                        $('#help-popup').css('display', 'flex');
                    })
            
                const $introImage = $('#intro-image');
                const $introText = $('#intro-text');
                const $warmupPlayButton = $('#warmup-play-button');
                const $challengePlayButton = $('#challenge-play-button');
            
                if (introImage){
                    $introImage.attr('src', introImage);
                } else {
                    $introImage.attr('src', 'https://artplay.academy/wp-content/uploads/2024/08/image-49.png');
                }
                if (introText){
                    $introText.html(insertBreakAfterFirstSentence(introText));
                } else {
                    $introText.html('Intro Text not found for this Lesson.');
                }
                // Event handlers
                const handlePlayButtonClick = (button, player) => () => {
                    button.hide();
                    player.play().catch(function(error) {
                    console.error('Error playing the video:', error);
                });
                player.on('ended', function() {
                    handleVideoEnd(button);
                });
            };
            
                const handleVideoEnd = (button, videoElement) => {
                    button.show();
                };

                if (warmupVideoUrl) {
                    $warmupPlayButton.hide();
                    $('#warmup-video').replaceWith('<iframe id="warmup-video" src="' + warmupVideoUrl+'?dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>');
                    const videoElement = $('#warmup-video').get(0);
                    const player = new Vimeo.Player(videoElement);
                    player.on('loaded', function() {
                        $warmupPlayButton.show();
                    });
                    $warmupPlayButton.on('click', function() {
                        console.log('button clicked');
                        handlePlayButtonClick($warmupPlayButton, player)();
                    });
                } else {
                    $('#warmup-video').replaceWith('<p class="no-video" id="warmup-video">No video found.</p>');
                    $warmupPlayButton.hide();
                }
                if(challengeVideoUrl){
                    $challengePlayButton.hide();
                    $('#challenge-video').replaceWith('<iframe id="challenge-video" src="' + challengeVideoUrl+'?dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>');
                    const videoElement = $('#challenge-video').get(0);
                    const player = new Vimeo.Player(videoElement);
                    player.on('loaded', function() {
                        $challengePlayButton.show();
                    });
                    $challengePlayButton.on('click', function() {
                        handlePlayButtonClick($challengePlayButton, player)();
                    });
                } else {
                    $('#challenge-video').replaceWith('<p class="no-video" id="challenge-video">No video found.</p>');
                    $challengePlayButton.hide();
                }
            }
            
            function insertBreakAfterFirstSentence(text) {
                const regex = /([.!?])\s+/;
                return text.replace(regex, '$1<br>');
            }
            

            // Disable scroll
            function disableScroll() {
               $('body').addClass('no-scroll');
            }

            // Enable scroll
            function enableScroll() {
               $('body').removeClass('no-scroll');
            }

            // Initialize magnificPopup
            $('.open-popup').magnificPopup({
                type: 'inline',
                midClick: false,
                closeBtnInside: true,
                callbacks: {
                    open: function() {
                        disableScroll();
                        $('.carousel').slick({
                            dots: true,
                            arrows: true,
                            infinite: false,
                            speed: 500,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        });
                        const rgbColor = $('.course-lesson-bubble.inprogress').css('background-color');
                        document.documentElement.style.setProperty('--box-color', rgbColor);
                        $('.slider-tab.first').addClass('active');
                    },
                    close: function() {
                        enableScroll();
                        $('.carousel').slick('unslick');
                        $('.slider-tab').removeClass('active');
                    }
                }
            });

            function onSlideChange(index) {
                $('.slider-tab').removeClass('active color');
                $('.slider-tab').eq(index).addClass('active color');
            }

            $('.carousel').on('afterChange', function(event, slick, currentSlide){
                onSlideChange(currentSlide);
            });

            const rect = anchorElement.getBoundingClientRect();
            popover.style.top = `${rect.bottom + window.scrollY}px`;
            popover.style.left = `${rect.left + window.scrollX}px`;

            // Close popover
            document.getElementById('closePopover').addEventListener('click', () => {
                popover.remove();
            });

            // Hide popover when clicking outside
            const clickOutsideHandler = (e) => {
                if (!popover.contains(e.target) && e.target !== anchorElement) {
                    popover.remove();
                    document.removeEventListener('click', clickOutsideHandler);
                }
            };
            document.addEventListener('click', clickOutsideHandler);
        }
    });
});