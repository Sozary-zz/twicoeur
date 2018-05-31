////////////////////////////////////////////////////////////
// switchTab(element,side)
// function used for switched between either the followers or the twics themselves
////////////////////////////////////////////////////////////

let switchTab = (element, side) => {
  let $elem_one = $(element)
  let $elem_two = $(element + '-tab')

  let summary_list = $('.summary').children('.list')

  summary_list.children().removeClass('active')

  $('.profile').children().animate({
    opacity: '0'
  }, "fast")
  $('.profile').children(element + '-tab').animate({
    opacity: '1'
  }, "fast")
  $('.profile').children().css('display', 'none')

  $elem_one.addClass('active')
  $elem_two.css('display', 'block')
}

////////////////////////////////////////////////////////////
// My slide show :)
////////////////////////////////////////////////////////////
let currentSlideShow = (element) => {
  direction = element - currentSlide > 0 ? -1 : 1
  document.querySelector('.slide-container ul').style.marginLeft = direction * 100 * (element - 1) + "%"

  var dots = document.getElementsByClassName("dot");

  for (let i = 0; i < dots.length; i++)
    dots[i].className = dots[i].className.replace(" active", "");

  dots[element - 1].className += " active";
}


////////////////////////////////////////////////////////////
// currentTabActive()
// function that returns the current active table
////////////////////////////////////////////////////////////

let currentTabActive = () => {
  let summary = document.querySelector('.summary').children[0]
  for (var i = 0; i < summary.children.length; i++)
    if (summary.children[i].classList.contains('active'))
      return summary.children[i].classList[0];

  return null;
}

////////////////////////////////////////////////////////////
// onUpdateStatusChange(element,progress)
// function that applies changes when the statusUpdate textarea is updated
// the progress bar is updated according to the textarea update
////////////////////////////////////////////////////////////

var onUpdateStatusChange = (element, progress) => {
  changeSendVisibility(element);
  progress.update(element.textLength)
}


let updateStatut = () => {
  let textArea = document.querySelector('.update-status-textarea')
  let content = escapeHtml(textArea.value)
  content = content.replace(/\r?\n/g, '<br>');


  textArea.disabled = true
  document.querySelector('.update-status-send').classList.remove('active')
  document.querySelector('.update-status-loader').classList.add('active')


  $(".user-status").load("?action=updateStatus&status-content=" + content + " #target", () => {

    textArea.value = ""
    textArea.disabled = false
    document.querySelector('.update-status-send').classList.add('active')
    document.querySelector('.update-status-loader').classList.remove('active')
    $('#updateStatus').modal('hide')

  })
}

let changeStatus = () => {
  $('#updateStatus').modal('show')
}

////////////////////////////////////////////////////////////
// changeSendVisibility(element)
// function that changes the not-allowd cursor into a normal cursor if the textarea's content isn t null
////////////////////////////////////////////////////////////
var changeSendVisibility = (element) => {
  if (element.value == '') {
    $('.update-status-send').removeClass('active')
    $('.update-status-send').prop("type", "button")
  } else {
    $('.update-status-send').addClass('active')
    $('.update-status-send').prop("type", "submit")
  }
}

var saveUserInfo = (item) => {
  document.querySelector('.user-info-title').textContent = item.children[0].children[0].textContent
  document.querySelector('.user-info-body').textContent = item.children[1].children[1].textContent
  document.querySelector('.user-info-statut').textContent = item.children[1].children[2].textContent
  document.querySelector('.user-show-profil-link').href = "?action=showAccount&id=" + item.children[1].children[0].textContent
}

////////////////////////////////////////////////////////////
// Current slide, for showing either the username or infos
////////////////////////////////////////////////////////////
var currentSlide = 1;
currentSlideShow(1)

////////////////////////////////////////////////////////////
// Creation of the progressbar for the updateStatus
////////////////////////////////////////////////////////////
var updateStatusProgress = new ProgressBar('update-status', 0, 1);
updateStatusProgress.create(document.querySelector('.update-status-progress-container'));


////////////////////////////////////////////////////////////
// Creation of the carousel
////////////////////////////////////////////////////////////
var emoCarousel = new Carousel('emo-carousel-style', ["images/svg/confused.svg", "images/svg/happy.svg", "images/svg/happy_2.svg", "images/svg/in-love.svg", "images/svg/sad.svg"],
  1000, 20, 28.1333, () => {
    return !$('#updateStatus').is(':visible')
  })
emoCarousel.create(document.querySelector('.emo-carousel'))


////////////////////////////////////////////////////////////
// If the modal is shown we have to start the carousel
////////////////////////////////////////////////////////////
$('#updateStatus').on('shown.bs.modal', function() {
  emoCarousel.start()
});

////////////////////////////////////////////////////////////
// Here we are managing the input update of the textarea
////////////////////////////////////////////////////////////
let updateArea = document.querySelector('.update-status-textarea');
if (updateArea.addEventListener) {
  updateArea.addEventListener('input', function() {
    onUpdateStatusChange(this, updateStatusProgress)
  }, false);
} else if (updateArea.attachEvent) {
  updateArea.attachEvent('onpropertychange', function() {
    onUpdateStatusChange(this, updateStatusProgress)
  });
}

////////////////////////////////////////////////////////////
// Here I m managing the tabs switch between twics and followers
////////////////////////////////////////////////////////////
document.querySelector('.twics').onclick = () => {
  if (currentTabActive() != 'twics')
    switchTab('.twics')
}
document.querySelector('.following').onclick = () => {
  if (currentTabActive() != 'following')
    switchTab('.following')
}