document
  .getElementById("lectureBandeAnnonce")
  .addEventListener("click", function () {
    var lecteur = document.getElementById("lecteurVideo");
    var source = document.getElementById("sourceVideo");
    var urlBandeAnnonce = "{{ leFilm.bandeAnnonce }}"; // Remplacez par l'URL de votre bande-annonce

    // Mettre à jour l'URL de la vidéo
    source.setAttribute("src", urlBandeAnnonce);

    // Afficher le lecteur vidéo
    lecteur.style.display = "block";

    // Démarrer la lecture
    lecteur.play();
  });
