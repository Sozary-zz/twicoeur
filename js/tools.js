function ProgressBar(mainClass, minOpacity, maxOpacity) {
  this.initValue = 0;
  this.minValue = 0;
  this.maxValue = 100;
  this.inc = 1;
  this.progressClass = "progress " + mainClass;
  this.baseDesign = "bg-success";
  this.thresholds = true;
  this.minOpacity = minOpacity;
  this.maxOpacity = maxOpacity;
  this.progress;
  this.bar;
  this.thresholdsValues = [{
      threshold: [0, 50],
      design: "bg-success"
    },
    {
      threshold: [51, 85],
      design: "bg-warning"
    },
    {
      threshold: [86, 100],
      design: "bg-danger"
    }
  ];

  this.create = (parent) => {
    this.progress = document.createElement("div");
    this.bar = document.createElement("div");

    this.progress.classList = this.progressClass
    this.bar.classList = "progress-bar " + this.baseDesign
    this.bar.setAttribute("role", "progressbar")
    this.bar.setAttribute("style", "width: " + this.initValue + "%")
    this.bar.setAttribute("style", "width: " + this.initValue + "%")
    this.bar.setAttribute("aria-valuenow", this.initValue)
    this.bar.setAttribute("aria-valuemin", this.minValue)
    this.bar.setAttribute("aria-valuemax", this.maxValue)

    parent.appendChild(this.progress);
    this.progress.appendChild(this.bar);
  }

  this.update = (newValue) => {

    if (newValue == 0)
      this.progress.style.opacity = this.minOpacity;
    else
      this.progress.style.opacity = this.maxOpacity;

    this.bar.style.width = newValue + "%";
    this.bar.setAttribute("aria-valuenow", newValue)

    for (var i = 0; i < this.thresholdsValues.length; i++) {
      let threshold = this.thresholdsValues[i];

      if (newValue >= threshold.threshold[0] && newValue <= threshold.threshold[1])
        this.bar.classList = "progress-bar " + threshold.design

    }
  }
}

function Carousel(associateClass, picList, delay, width, height, exception) {
  this.pictures = picList;
  this.class = associateClass;
  this.delay = delay;
  this.height = height;
  this.width = width;
  this.list;
  this.loop;
  this.current = 0;
  this.desc = true;
  this.exception = exception;

  this.create = (parent) => {
    parent.style.height = this.height + "px";
    parent.style.width = this.width + "px";
    parent.style.position = "relative";
    parent.style.float = "left";
    parent.style.marginRight = "10px";
    parent.style.overflow = "hidden";

    this.list = document.createElement("ul");
    this.list.style.listStyleType = "none";
    this.list.style.maxHeight = this.height + "px";
    this.list.style.maxWidth = this.width + "px";
    this.list.style.position = "relative";
    this.list.style.left = -(2 * this.width) + "px";
    this.list.style.transition = "all .3s linear";

    for (var i = 0; i < this.pictures.length; i++) {
      let tmp_elem = document.createElement("li");
      let tmp_pic = document.createElement("img");

      tmp_pic.setAttribute("src", this.pictures[i]);
      tmp_pic.setAttribute("width", this.width + "px");

      tmp_elem.appendChild(tmp_pic);
      this.list.appendChild(tmp_elem);
    }
    parent.appendChild(this.list);
  }

  this.switchPic = () => {
    if (this.exception())
      this.stop();
    if (this.desc)
      this.current++;
    else
      this.current--;
    if (this.current - 1 == -1)
      this.desc = true;

    if (this.current + 1 == this.pictures.length)
      this.desc = false;

    this.list.style.top = -(this.height * this.current) + "px";
  }

  this.start = () => {
    this.loop = window.setInterval(this.switchPic, this.delay);
  }


  this.stop = () => {
    window.clearInterval(this.loop)
  }
}