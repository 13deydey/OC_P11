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