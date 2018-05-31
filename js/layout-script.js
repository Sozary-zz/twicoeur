$('.navbar').addClass('original').clone().insertAfter('.navbar').addClass('cloned').css('position', 'fixed').css('top', '0').css('margin-top', '0').css('z-index', '500').removeClass('original').hide();

scrollIntervalID = setInterval(stickIt, 10);


var stickIt = () => {
  var orgElementPos = $('.original').offset();
  orgElementTop = orgElementPos.top;

  if ($(window).scrollTop() >= (orgElementTop)) {
    orgElement = $('.original');
    coordsOrgElement = orgElement.offset();
    leftOrgElement = coordsOrgElement.left;
    widthOrgElement = orgElement.css('width');
    $('.cloned').css('left', leftOrgElement + 'px').css('top', 0).css('width', widthOrgElement).show();
    $('.original').css('visibility', 'hidden');
  } else {
    $('.cloned').hide();
    $('.original').css('visibility', 'visible');
  }
}

var onNewTwicChange = (element, progress) => {
  if (element.value == '') {
    $('.new-twic-send').removeClass('active')
    $('.new-twic-send').prop("type", "button")
  } else {
    $('.new-twic-send').addClass('active')
    $('.new-twic-send').prop("type", "submit")
  }

  progress.update((10 * element.textLength) / 14)

}
let modalNewTwic = () => {
  $('#newTwic').modal('show')

}

var newTwicProgress = new ProgressBar('new-twic-progress', 0, 1);
newTwicProgress.create(document.querySelector('.new-twic-progress-container'));
let newBrowse = () => {
  $('#browse-twic').modal('show')
}
let escapeHtml = (text) => {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
    " ": '%20'
  };

  return text.replace(/[&<>"' ]/g, function(m) {
    return map[m];
  });
}

let newTwic = (myAccount) => {
  if (!document.querySelector('.new-twic-send').classList.contains('active'))
    return

  let textArea = document.querySelector('.new-twic-textarea')
  let content = escapeHtml(textArea.value)
  let pic = document.querySelector('.new-twic-pic-content')
  content = content.replace(/\r?\n/g, '<br>');



  var loader = document.querySelector('.loader')
  textArea.disabled = true
  document.querySelector('.new-twic-send').classList.remove('active')
  document.querySelector('.new-twic-loader').classList.add('active')

  var newDiv = document.createElement("div");
  if (myAccount) {
    var newLi = document.createElement("li");
    newDiv.classList.add('twic')
    newLi.appendChild(newDiv)
    var list = document.querySelector(".twicList");
    list.insertBefore(newLi, list.firstChild);
  }
  $(newDiv).load("?action=newPost&twic-content=" + content + "&twic-pic=" + pic.getAttribute('src') + " #target", () => {

    textArea.value = ""
    textArea.disabled = false
    document.querySelector('.new-twic-send').classList.add('active')
    document.querySelector('.new-twic-loader').classList.remove('active')
    $('#newTwic').modal('hide')
  })
  if (myAccount) {
    newDiv.classList.add('tada')
    setTimeout(function() {
      newDiv.classList.remove('tada')
    }, 1000);
    if (parseInt(document.querySelector(".squeals-number").innerHTML) == 0) {
      document.querySelector('.twicList').removeChild(document.querySelector('.twicList').getElementsByTagName('li')[1])
    }
    if (document.querySelector(".squeals-number") != undefined)
      document.querySelector(".squeals-number").innerHTML = parseInt(document.querySelector(".squeals-number").innerHTML) + 1
  }
}

let area = document.querySelector('.new-twic-textarea');
if (area.addEventListener) {
  area.addEventListener('input', function() {
    onNewTwicChange(this, newTwicProgress)
  }, false);
} else if (area.attachEvent) {
  area.attachEvent('onpropertychange', function() {
    onNewTwicChange(this, newTwicProgress)
  });
}