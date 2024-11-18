function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}

// Ajout pour l'animation de la section "news-section"
document.addEventListener('DOMContentLoaded', () => {
  const newsSection = document.querySelector('.news-section .container');

  if (newsSection) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          newsSection.classList.add('active');
        }
      });
    }, { threshold: 0.1 });

    observer.observe(newsSection);
  }
});

// JavaScript for smooth continuous scrolling
const galleryContainer = document.querySelector('.gallery-container');

// Duplicate the first image and append it to the end for seamless looping
const firstImage = galleryContainer.querySelector('img');
const clonedImage = firstImage.cloneNode(true); 
galleryContainer.appendChild(clonedImage);

// Adjust the scroll speed and behavior
let scrollSpeed = 1; // You can adjust this value for speed

function scrollGallery() {
  // Scroll by 'scrollSpeed' value
  galleryContainer.scrollBy({
    left: scrollSpeed, 
    behavior: 'smooth'
  });

  // Check if the container has scrolled to the last image
  // When reaching the end, reset the scroll position to the start (without a jump)
  if (galleryContainer.scrollLeft >= galleryContainer.scrollWidth - galleryContainer.clientWidth) {
    galleryContainer.scrollLeft = 0; // Reset scroll to the beginning
  }
}

// Continuously scroll every 30ms
setInterval(scrollGallery, 30);


document.addEventListener('DOMContentLoaded', () => {
  const aboutSection = document.querySelector('.section-about .container-about');

  if (aboutSection) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          aboutSection.classList.add('active');
        }
      });
    }, { threshold: 0.1 });

    observer.observe(aboutSection);
  }
});

