/* Changer le thème */
    
changeTheme = () => {
    var theme = document.querySelector('input[name="theme"]:checked').value;
    var actualTheme = document.querySelector('#theme-style');
    if (actualTheme){
        actualTheme.remove();
    }

    var link = document.createElement("link");
    link.id = "theme-style";
    link.type = "text/css";
    link.rel = "stylesheet";
    link.href = "themes/article/" + theme + ".css";
    document.head.appendChild(link);

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
            changeTheme();
        }
    }
});