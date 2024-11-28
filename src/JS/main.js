// menu burger
function toggleNavMenu() {
  const navMenu = document.getElementById("myTopnav"); 
  
  if (navMenu.classList.contains("topnav")) {
    navMenu.classList.add("responsive");
  } else {
    navMenu.classList.remove("responsive");
  }
}


// gestion des sections au scroll
function observeSectionAnimation(sectionClass) {
  const section = document.querySelector(sectionClass);
  
  if (section) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          section.classList.add('active'); //déclanche le CSS avec l'écoute
        }
      });
    }, { threshold: 0.1 }); //10px

    observer.observe(section);
  }
}

// Gallerie
function startContinuousScroll() {
  const galleryContainer = document.querySelector('.gallery-container');
  
  // Duplication de la première image pour un loop
  const firstImage = galleryContainer.querySelector('img');
  const clonedImage = firstImage.cloneNode(true); 
  galleryContainer.appendChild(clonedImage);

  let scrollSpeed = 1; 

  function scrollGallery() {
    galleryContainer.scrollBy({
      left: scrollSpeed, 
      behavior: 'smooth'
    });

    // reset du scroll
    if (galleryContainer.scrollLeft >= galleryContainer.scrollWidth - galleryContainer.clientWidth) {
      galleryContainer.scrollLeft = 0;
    }
  }

  // continuité de l'animation 30s d'intervale
  setInterval(scrollGallery, 30);
}

// Initialisation des script au chargement du DOM
document.addEventListener('DOMContentLoaded', () => {
  // Animation des sections
  observeSectionAnimation('.news-section .container');
  observeSectionAnimation('.section-about .container-about');
  observeSectionAnimation('.history-section .container');
  
  // Début du scroll de gallerie
  startContinuousScroll();
});
