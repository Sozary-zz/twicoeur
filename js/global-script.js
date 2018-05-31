let switchNav = (tab) => {
  $('.navbar-nav').children().removeClass('active')
  $(tab).addClass('active')
}