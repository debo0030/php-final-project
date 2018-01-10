// get the id
// then get the index of picture has that id
var selectedPicId = $('#pictureId').val();
var allPics = $('.column');

var initIndex = () => {
    var slideIndex = 1;
    for(var i = 0; i < allPics.length; i++)
    {
        if($(allPics[i]).attr('data-id') === selectedPicId)
        {
            slideIndex = $(allPics[i]).attr('data-index');
            break;
        }
    }
    
    return slideIndex;
};

var slideIndex = initIndex();
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

// thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

$('.column').on('click', function() {
    console.log($(this).attr('data-id'));
    currentSlide($(this).attr('data-index'));
    var pictureId = $(this).attr('data-id');
    $('#pictureId').val(pictureId);
});

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("slides");
  var dots = document.getElementsByClassName("demo");
  if (n> slides.lenght) {slideIndex = 1}
  if (n< 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i=0; i<dots.length; i++) {
    dots[i].className = dots[i].className.replace("active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}

