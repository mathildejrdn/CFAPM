// Toggle navigation menu on mobile view
function toggleNavMenu() {
  const navMenu = document.getElementById("myTopnav");
  
  if (navMenu.classList.contains("topnav")) {
    navMenu.classList.add("responsive");
  } else {
    navMenu.classList.remove("responsive");
  }
}

// Handle intersection observer for sections that should animate when in view
function observeSectionAnimation(sectionClass) {
  const section = document.querySelector(sectionClass);
  
  if (section) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          section.classList.add('active');
        }
      });
    }, { threshold: 0.1 });

    observer.observe(section);
  }
}

// Smooth continuous scrolling for gallery container
function startContinuousScroll() {
  const galleryContainer = document.querySelector('.gallery-container');
  
  // Duplicate the first image and append it for seamless looping
  const firstImage = galleryContainer.querySelector('img');
  const clonedImage = firstImage.cloneNode(true); 
  galleryContainer.appendChild(clonedImage);

  let scrollSpeed = 1; // Adjust speed as needed

  function scrollGallery() {
    galleryContainer.scrollBy({
      left: scrollSpeed, 
      behavior: 'smooth'
    });

    // Reset scroll position when reaching the end of the container
    if (galleryContainer.scrollLeft >= galleryContainer.scrollWidth - galleryContainer.clientWidth) {
      galleryContainer.scrollLeft = 0;
    }
  }

  // Continuously scroll every 30ms
  setInterval(scrollGallery, 30);
}

// Initialize all scripts once the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
  // Initialize section animations
  observeSectionAnimation('.news-section .container');
  observeSectionAnimation('.section-about .container-about');
  observeSectionAnimation('.history-section .container');
  
  // Start the continuous scrolling of the gallery
  startContinuousScroll();
});
