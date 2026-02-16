//MODALE DE CONTACT AVEC RÉFÉRENCE PHOTO PRÉ-REMPLIE
// Modale et overlay créés une fois
const modaleContact = document.querySelector('.modale-contact');
const overlay = document.createElement('div');
document.body.appendChild(overlay);

// Fonctions ouverture / fermeture
// La fonction openModale s'exécute avec un paramètre optionnel : la référence de la photo
function openModale(photoReference = '') {

  // Met à jour le champ de référence SELON FORMULAIRE CONTACT FORM 7
  // 1. Récupère le champ de référence DOM pour l'employer en JavaScript
  let referenceInput = modaleContact.querySelector('input[name="ref-photo"]');
  // 2. Met à jour la valeur 
  referenceInput.value = photoReference;

    // Affiche la modale et l'overlay
  modaleContact.classList.add('visible');
  overlay.classList.add('lightbox-overlay');
  document.body.classList.add('no-scroll');
}
function closeModale() {
  modaleContact.classList.remove('visible');
  overlay.classList.remove('lightbox-overlay');
  document.body.classList.remove('no-scroll');
}

// Fermer au clic sur overlay
overlay.addEventListener('click', closeModale);

// FERMETURE AU CLIC SUR BOUTON FERMER SELON LES CHAMPS REQUIS DE CONTACT FORM 7
const closeButton = modaleContact.querySelector('.wpcf7-submit');
const contactForm = document.querySelector('form.wpcf7-form'); 
if (contactForm) {
    // 1. Utilisez classList.contains() pour vérifier si formulaire INVALID auquel cas garder modale ouverte
    if (contactForm.classList.contains('invalid')) {
        //si formulaire invalide, les errreurs de validation sont présentes
        console.log("Le formulaire contient des erreurs de validation.");
        modaleContact.classList.add('visible');  
        overlay.classList.add('lightbox-overlay');
        document.body.classList.add('no-scroll');
    } 
    //2. sinon, le formulaire est valide ou n'a pas encore été soumis et agit comme d'habitude
    else {
        console.log("Le formulaire est valide (ou n'a pas encore été soumis).");
        // Placez ici le code à exécuter si la classe n'est pas présente
    }
}

// Gestion du bouton de la page des photos
const contactButton = document.querySelector('.contact_cta');
if (contactButton) contactButton.addEventListener('click', function(event) {
    event.preventDefault(); // Stoppe la navigation/soumission

    //ref récupérée depuis l'attribut data-reference du bouton dans le template single-photo.php
    const ref = this.getAttribute('data-reference');
    console.log('Référence photo :', ref);
    openModale(ref); // Ouvre la modale avec la référence de la photo
});
// Gestion du lien "Contact" dans le menu WordPress
const menuContact = document.querySelector('#menu-item-19 a');
menuContact.addEventListener('click', function(event) {
    //Stoppe la navigation vers la page de contact
    event.preventDefault(); 
    //lance l'ouverture de la modale sans référence de photo comme paramètre
    openModale();
});

//RÉPÉTER LE TITRE "CONTACT" DANS LA MODALE
    const titreModale = modaleContact.querySelector('.titre');
    const texte = "Contact";
    const repeatedText5 = texte.repeat(5);  // répète 5 fois
    const repeatedText7 = texte.repeat(7);  // répète 7 fois
titreModale.innerHTML = `
    <span class="repeat5">${repeatedText5}</span>
    <span class="repeat7">  ${repeatedText7}</span>
`;


//GALERIE ACCUEIL DES PHOTOS _ CPT UI 
let currentPage = 1;
const postsPerPage = 8;
let allPosts = []; // Pour stocker tous les posts récupérés via AJAX
const gallery = document.querySelector('#gallery');
const loadMoreButton = document.querySelector('.load_more_button');

// Fonction pour gérer le chargement (initial ou suivant)
function loadPhotos(resetGallery = false, categoryId = null, formatId = null, sortOrder = '') {

    let totalPages ; // Variable pour stocker le total des pages
    
    // Si c'est un NOUVEAU filtre (resetGallery = true), on recommence à la page 1
    if (resetGallery) {
        currentPage = 1;
        gallery.innerHTML = ''; // Vider la galerie
    }

    // Définition des variables d'ordre et de tri par date par défaut
    let finalOrder = 'desc'; // Ordre décroissant par défaut
    let finalOrderBy = 'id';  // Tri par ID par défaut (ordre de création)

    // Si l'utilisateur a choisi un ordre (asc ou desc) dans le menu
    if (sortOrder !== '' && sortOrder !== null) {
        finalOrder = sortOrder;
        // Si l'utilisateur trie, on trie généralement par date
        finalOrderBy = 'date'; 
    }

    // --- CONSTRUCTION DE L'URL DYNAMIQUE ---
    let restUrl = `/wp-json/wp/v2/photo?per_page=${postsPerPage}&page=${currentPage}`;
    //Ajout paramètre filtres si présents issus de taxnomies ACF
        if (categoryId) {
            restUrl += `&categorie=${categoryId}`;
        }
        if (formatId) {
            restUrl += `&photo_formats=${formatId}`;
        }
    // Ajout des paramètres de tri (orderby et order) selon les choix de l'utilisateur
            // Si l'utilisateur n'a rien touché, ce sera : &orderby=id&order=desc
    restUrl += `&orderby=${finalOrderBy}&order=${finalOrder}`;
    console.log("URL de tri :", restUrl);

    //Utilisation de l'API REST pour TOUTES les requêtes
    fetch(restUrl)
    .then(response => {
        //Récupérer le total des pages (X-WP-TotalPages) dans le header
        //parseInt pour convertir en nombre entier en JS
        totalPages = parseInt(response.headers.get('X-WP-TotalPages'));
        return response.json();
    })
    .then(data => {
        //Vérifier si des articles ont été retournés
        //si 0length=0article et page 1 c'est qu'il n'y a aucun post au total
        if (!data.length && currentPage === 1) {
            // Aucun post trouvé au total
            gallery.innerHTML = '<p>Aucune photo trouvée.</p>';
            return;
        }

        // Boucle pour afficher les articles
        data.forEach(post => {
            const article = document.createElement('article');
            article.classList.add('gallery-item');
            article.innerHTML = `
            <a href="${post.link}">
                <img src="${post.featured_image_url}" alt="${post.title.rendered}" />
            </a>
            `;
        
            const info = document.createElement('div');
            info.classList.add('info_overlay');
            info.innerHTML = `
            <img src="wp-content/themes/mota_perso/assets/iconeSurvol/Icon_fullscreen.png" alt="Aperçu lightbox" class="apercu"/>
            <a href="${post.link}">
                <img src="wp-content/themes/mota_perso/assets/iconeSurvol/Icon_eye.png" alt="Plein écran" class="pleinEcran"/>
            </a>
            <div class="infos-content">
                <p>${post.title.rendered}</p>
                <p>${post.categorie_name}</p>
            </div>
            `;
        
            article.appendChild(info);
            gallery.appendChild(article);
        
            // Stocker les données utiles en dataset pour accès simple
            article.dataset.singlephoto = post.featured_image_url;
            article.dataset.reference = post.acf?.reference || '';
            article.dataset.categories = post.categorie_name;
            article.dataset.link = post.link;
        });    
        
        //Mise à jour de la page courante 
        //lorsque les photos sont chargées avec succès la page courante s'incrémente de 1
        // le bouton n'est plus disabled et son texte redevient "Charger plus"
        currentPage++;
        if (currentPage > totalPages) {
            if (loadMoreButton) loadMoreButton.style.display = 'none';
        } else {
            if (loadMoreButton) loadMoreButton.style.display = 'block';
        }

        //Réinitialiser les écouteurs de la lightbox
        //cad réappeler la fonction GalleryListeners,
        //afin que les éléments de la nouvelle page soient eux aussi push dans le tableau Gallery 
        // et aient eux aussi des écouteurs 
        initGalleryListeners();
    })
    .catch(error => {
        console.error("Erreur de chargement des photos:", error);
        if (loadMoreButton) {
            loadMoreButton.textContent = 'Erreur de chargement';
        }    
    });
}

let currentIndex = 0;
const galleryItems = [];


// Fonction pour ouvrir la lightbox
function openLightbox(index) {
    currentIndex = index;

    //si overlay existe déjà, le supprimer avant d'en créer un nouveau
    if(document.querySelector('.lightbox-overlay')){
        document.querySelector('.lightbox-overlay').remove();
    }

    const overlay = document.createElement('div');
    overlay.classList.add('lightbox-overlay');
    document.body.appendChild(overlay);

    const item = galleryItems[currentIndex];

    // Mettre à jour la lightbox (overlay et contenu)

    let lightbox_content = document.querySelector('.lightbox');
    if (!lightbox_content) {
        lightbox_content = document.createElement('div');
        lightbox_content.classList.add('lightbox');
        document.body.appendChild(lightbox_content);
    }

    lightbox_content.innerHTML = `
        <article class="fleche_prec">
            <i class="fa-solid fa-arrow-left-long"></i>
            <p>Précédente</p>
        </article>
        <article class="previsualisation">
            <a href="${item.dataset.link}">
                <img src="${item.dataset.singlephoto}" alt="Photo sélectionnée" />
            </a>
            <div class="light_rang2">
                <p>${item.dataset.reference}</p>
                <p>${item.dataset.categories}</p>
            </div>
        </article>
        <article class="fleche_suiv">
            <p>Suivante</p>
            <i class="fa-solid fa-arrow-right-long"></i>
        </article>
    `;

    // Bloquer scroll
    document.body.classList.add('no-scroll');

    // Écouteur fermeture overlay
    overlay.addEventListener('click', () => {
        lightbox_content.remove();
        overlay.remove();
        document.body.classList.remove('no-scroll');
    });

    // Navigation précédente
    const precedente = lightbox_content.querySelector('.fleche_prec');
    precedente.addEventListener('click', () => {
        // moyen de boucler en récupérant le modulo de la longueur du tableau CAD le reste de la division
        // si photo n°6, donc élément n°5 pour une longueur de 6, (5-1+6)%6 = 4 donc on revient à l'élément d'avant
        // car 10%6 => 10/6 = 1 reste 4 donc on récupère le 4
        currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
        openLightbox(currentIndex);
    });

    // Navigation suivante
    const suivante = lightbox_content.querySelector('.fleche_suiv');
    suivante.addEventListener('click', () => {
        // moyen de boucler en récupérant le modulo de la longueur du tableau CAD le reste de la division
        //si photo 5, élément n°4 pour une longueur de 5, (4+1)%5 = 0 donc on revient au début
        currentIndex = (currentIndex + 1) % galleryItems.length;
        openLightbox(currentIndex);
    });
}

// Fonction pour initialiser les écouteurs sur tous les articles (nouveaux et anciens)
function initGalleryListeners() {
    galleryItems.length = 0; // Réinitialiser le tableau
    Array.from(document.querySelectorAll('.gallery-item')).forEach(item => galleryItems.push(item));// Remplir le tableau avec les éléments actuels
    galleryItems.forEach(item => {
        const infoOverlay = item.querySelector('.info_overlay');

        // C'est ici que vous vérifiez si l'écouteur n'est pas déjà là (bonne pratique)
        if (!item.dataset.listenersAdded) { 
            // 1. Écouteurs de survol
            item.addEventListener('mouseenter', () => {
                infoOverlay.classList.add('visible');
            });
            item.addEventListener('mouseleave', () => {
                infoOverlay.classList.remove('visible');
            });

            // 2. Écouteur d'ouverture Lightbox
            const apercu = item.querySelector('.apercu');
            apercu.addEventListener('click', () => {
                console.log("apercu visible par js");

                // Trouver l'index de l'élément dans le tableau global
                const index = galleryItems.indexOf(item); 
                openLightbox(index);
            });
            item.dataset.listenersAdded = true; // Marquer l'élément comme initialisé
        }    
    });
}


// Initialisation des écouteurs pour les éléments de filtre
// Sélection des menus de filtre (catégorie et format) selon les ID du template
const selectCat = document.querySelector('#categorySelect'); 
const selectFormat = document.querySelector('#formatSelect');
const selectDate = document.querySelector('#dateSelect');

function declencherFiltre() {
    let catId;
        if(selectCat) {
            catId = selectCat.value;
            console.log("Catégorie sélectionnée :", catId);
        } else {
            catId = null;
        }   

    let formatId;
        if(selectFormat) {
            formatId = selectFormat.value;
            console.log("Format sélectionné :", formatId);
        } else {
            formatId = null;
        }
    
    let choixTri;
        if(selectDate) {
            choixTri = selectDate.value;
            console.log("Choix de tri par date :", choixTri);
        } else {
            choixTri = '';
        }
    // On appelle loadPhotos avec resetGallery = true pour vider la grille
    loadPhotos(true, catId, formatId, choixTri);
}
// On écoute le changement
if(selectCat) selectCat.addEventListener('change', declencherFiltre);
if(selectFormat) selectFormat.addEventListener('change', declencherFiltre);
if(selectDate) selectDate.addEventListener('change', declencherFiltre);

// Et l'écouteur au bouton charger plus
if (loadMoreButton) {
    loadMoreButton.addEventListener('click', () => {
        const catId = selectCat ? selectCat.value : null;
        const formatId = selectFormat ? selectFormat.value : null;
        loadPhotos(false, catId, formatId);
    });
}

// Initialisation du chargement des photos
if (gallery) {
    // 1. Chargement Initial (Page 1)
    loadPhotos(); 
}
if (loadMoreButton) {
    // 2. Écouteur du Bouton (Charge la page suivante)
    loadMoreButton.addEventListener('click', function(e) {
        e.preventDefault();
        loadPhotos(); 
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const menuContainer = document.querySelector('.nav-menu-container');

    if (menuToggle && menuContainer) {
        menuToggle.addEventListener('click', function() {
            // On ajoute ou retire la classe 'is-open'
            menuContainer.classList.toggle('is-open');
            document.body.classList.add('no-scroll');
            
            // Accessibilité : on change l'état du bouton
            const isOpen = menuContainer.classList.contains('is-open');
            menuToggle.setAttribute('aria-expanded', isOpen);
            
            // Optionnel : on change l'icône du burger en croix
            menuToggle.classList.toggle('active');
        });
    }
});
