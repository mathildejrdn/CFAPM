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

// JavaScript for automatic scrolling effect
const galleryContainer = document.querySelector('.gallery-container');

function scrollGallery() {
  galleryContainer.scrollBy({
    left: 1, // Scroll by 1px on each frame
    behavior: 'smooth' // Smooth scrolling
  });

  // Check if the container has scrolled to the end, then reset
  if (galleryContainer.scrollLeft >= galleryContainer.scrollWidth - galleryContainer.clientWidth) {
    galleryContainer.scrollLeft = 0;
  }
}

// Set interval for scrolling every 30ms (adjust as necessary)
setInterval(scrollGallery, 30);

