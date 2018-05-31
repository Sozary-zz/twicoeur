let createTwics = (twics) => {

  let main_div = document.querySelector('.twicList')

  for (let i = 0; i < twics.length; i++) {
    if (twics[i]['nbvotes'] == null)
      twics[i]['nbvotes'] = 0

    let div = []
    let span = []
    let a = []
    let img = []
    let h5 = []
    let h6 = []
    let li = []
    let ul = []
    let p = []

    for (let j = 0; j < 5; j++)
      div.push(document.createElement('div'))
    for (let j = 0; j < 6; j++)
      span.push(document.createElement('span'))
    for (let j = 0; j < 2; j++)
      a.push(document.createElement('a'))
    for (let j = 0; j < 6; j++)
      img.push(document.createElement('img'))
    for (let j = 0; j < 1; j++)
      h5.push(document.createElement('h5'))
    for (let j = 0; j < 1; j++)
      h6.push(document.createElement('h6'))
    for (let j = 0; j < 5; j++)
      li.push(document.createElement('li'))
    for (let j = 0; j < 2; j++)
      ul.push(document.createElement('ul'))
    for (let j = 0; j < 1; j++)
      p.push(document.createElement('p'))

    div[0].classList.add('twic')
    div[1].classList.add('votes')
    if (twics[i]['nbvotes'] != 0)
      div[1].classList.add('active')
    span[0].classList.add('votes-number')
    span[0].appendChild(document.createTextNode(twics[i]['nbvotes']))
    img[0].setAttribute('src', 'images/svg/like.svg')
    img[0].setAttribute('width', '15px')
    img[0].setAttribute('alt', 'vote')

    div[2].classList = 'card text-white bg-info mb-3'
    div[3].classList.add('card-header')
    h5[0].classList.add('card-title')
    h5[0].appendChild(document.createTextNode("Posté par "))
    a[0].style.color = "inherit"
    a[0].setAttribute('href', '?action=showAccount&id=' + twics[i]['parent'])
    span[1].setAttribute('data-toggle', 'tooltip')
    span[1].setAttribute('title', '<img width="20px" src="' + twics[i]['parent_pic'] + '"> ' + twics[i]['parent_name'])
    span[1].appendChild(document.createTextNode('@' + twics[i]['parent_name']))
    h6[0].classList = "card-subtitle text-muted"
    h6[0].appendChild(document.createTextNode("Partagé par "))
    a[1].style.color = "inherit"
    a[1].setAttribute('href', '?action=showAccount&id=' + twics[i]['emetteur'])
    span[2].setAttribute('data-toggle', 'tooltip')
    span[2].setAttribute('title', '<img width="20px" src="' + twics[i]['emetteur_pic'] + '"> ' + twics[i]['emetteur_name'])
    span[2].appendChild(document.createTextNode('@' + twics[i]['emetteur_name']))
    if (twics[i]['post_pic'] != "") {
      img[1].style.height = "200px"
      img[1].style.width = "100%"
      img[1].style.display = "block"
      img[1].setAttribute('src', twics[i]['post_pic'])
    }
    div[4].classList.add("card-body")
    p[0].classList.add("card-text")
    p[0].appendChild(document.createTextNode(twics[i]['post_text']))
    ul[0].classList = "list-group list-group-flush"
    ul[0].style.color = "#222"
    li[0].classList.add("list-group-item")
    li[0].appendChild(document.createTextNode("Date de création: " + twics[i]['post_date']))
    li[1].classList = "list-group-item more"
    li[2].classList.add("vote-item")
    li[2].setAttribute('onclick', "vote(this)")
    li[2].setAttribute('data-twic', twics[i]['id'])
    if (twics[i]['voted'] == "false") {
      span[3].appendChild(document.createTextNode('Vote'))
      img[2].setAttribute('src', 'images/svg/like.svg')
    } else {
      span[3].appendChild(document.createTextNode('Enlever le vote'))
      img[2].setAttribute('src', 'images/svg/unlike.svg')
    }
    img[2].setAttribute('alt', 'vote')

    li[3].classList.add("share-item")
    li[3].setAttribute('onclick', 'share(this,' + twics[i]['id'] + ')')
    li[3].setAttribute('data-twic', twics[i]['id'])
    if (twics[i]['shared'] == "true" || twics[i]['self_shared'] == "true")
      li[3].style.cursor = "not-allowed"
    if (twics[i]['shared'] == "false" && twics[i]['self_shared'] == "false") {
      span[4].appendChild(document.createTextNode('Partager'))
    } else if (twics[i]['shared'] == "true")
      span[4].appendChild(document.createTextNode('Déjà partagé'))
    else
      span[4].appendChild(document.createTextNode('Un de vos posts'))

    img[3].setAttribute('src', 'images/svg/share.svg')
    img[3].setAttribute('alt', 'share')

    div[0].appendChild(div[1]) //div twic
    div[0].appendChild(div[2])
    div[1].appendChild(span[0]) // div vote
    div[1].appendChild(img[0])
    div[2].appendChild(div[3]) // div card
    div[3].appendChild(h5[0]) // card title
    div[3].appendChild(h6[0])
    h5[0].appendChild(a[0])
    a[0].appendChild(span[1])
    h6[0].appendChild(a[1])
    a[1].appendChild(span[2])
    div[2].appendChild(img[1])
    div[2].appendChild(div[4]) // card body
    div[4].appendChild(p[0])
    div[4].appendChild(ul[0])
    ul[0].appendChild(li[0])
    ul[0].appendChild(li[1])
    li[1].appendChild(ul[1])
    ul[1].appendChild(li[2])
    li[2].appendChild(span[3])
    li[2].appendChild(img[2])
    ul[1].appendChild(li[3])
    li[3].appendChild(span[5])
    span[5].appendChild(span[4])
    span[5].appendChild(img[3])

    let fi = document.createElement('li')
    fi.appendChild(div[0])
    main_div.appendChild(fi)

  }
  $('[data-toggle="tooltip"]').tooltip({
    html: true
  });
}