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
    link.href = "themes/index/" + theme + ".css";
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

/* Changer la date */

var articles = document.querySelectorAll("main a");
var dates = ["2026-09-28", "2026-10-05", "2026-10-12", "2026-10-19", "2026-10-26", "2026-11-02", "2026-11-09", "2026-11-16", "2026-11-23", "2026-11-30", "Tout"];

document.querySelector('input[name="date"]').addEventListener('input', (event) => {
    var value = event.target.value;
    var currentDate = dates[value];
    document.querySelector('#date label').innerText = currentDate;

    // Quand on sélectionne "Tout"
    if (value == dates.length - 1) {
        articles.forEach((article) => {
            article.style.display = "block";
        });
    // Quand on est à la dernière date avant "Tout"
    } else if (value == dates.length - 2){
        var thresholdMin = new Date(currentDate);
        var thresholdMax = new Date(2026, 12, 31);

        articles.forEach((article) => {
            var articleDate = new Date(article.getAttribute('data-date'));
            if (articleDate >= thresholdMin && articleDate < thresholdMax){
                article.style.display = "block";
            } else {
                article.style.display = "none";
            }
        });
    // Quand on a sélectionné les autres dates
    } else {
        var nextDate = dates[Number(value)+1];
        var thresholdMin = new Date(currentDate);
        var thresholdMax = new Date(nextDate);

        articles.forEach((article) => {
            var articleDate = new Date(article.getAttribute('data-date'));
            if (articleDate >= thresholdMin && articleDate < thresholdMax){
                article.style.display = "block";
            } else {
                article.style.display = "none";
            }
        });
    }
});

/* Filtrer par auteur·ice */

var selectAuthor = document.querySelector('#auteurices select');
selectAuthor.addEventListener("change", (event) => {
    var author = event.target.value;
    var articles = document.querySelectorAll("main a");
    if (author === "all") {
        articles.forEach((article) => {
            article.style.display = "block";
        });
    } else {
        articles.forEach((article) => {
            if (author === "all" || article.getAttribute('data-author') === author) {
                                article.style.display = "block";
            } else {
                article.style.display = "none";
            }
        });
    }
});