/* Changer le thème */

function setThemeStylesheet(id, href, media) {
    let link = document.getElementById(id);
    if (!link) {
        link = document.createElement("link");
        link.id = id;
        link.type = "text/css";
        link.rel = "stylesheet";
        document.head.appendChild(link);
    }

    link.href = href;
    link.media = media;
}

changeTheme = () => {
    var theme = document.querySelector('input[name="theme"]:checked').value;
    setThemeStylesheet('theme-style', "themes/article/" + theme + ".css", "screen");
    setThemeStylesheet('print-theme-style', "themes/print/" + theme + ".css", "print");

    // Sauvegarder le thème sélectionné
    localStorage.setItem('selectedTheme', theme);
}

// var themesNumber = document.querySelectorAll('input[name="theme"]').length;
// var randomTheme = Math.floor(Math.random() * themesNumber);

// document.querySelectorAll('input[name="theme"]')[randomTheme].checked = true;
// changeTheme();

// Charger le thème sauvegardé au rechargement de la page
window.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('selectedTheme');
    if (savedTheme) {
        const radio = document.querySelector(`input[name="theme"][value="${savedTheme}"]`);
        if (radio) {
            radio.checked = true;
        }
    }
    if (document.querySelector('input[name="theme"]:checked')) {
        changeTheme();
    }
});