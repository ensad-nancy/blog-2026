/* Changer le thème */
    
changeTheme = () => {
    var theme = document.querySelector('input[name="theme"]:checked').value;
    var actualTheme = document.querySelector('#theme-style');
    if (actualTheme) {
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

/* Filtrer par date et par auteur·ice */

var articles = document.querySelectorAll("main a");
var dates = ["2026-09-28", "2026-10-05", "2026-10-12", "2026-10-19", "2026-10-26", "2026-11-02", "2026-11-09", "2026-11-16", "2026-11-23", "2026-11-30", "Tout"];

var selectDate = document.querySelector('input[name="date"]');
var selectAuthor = document.querySelector('#auteurices select');

function filterArticles() {
    var author = selectAuthor.value;
    var dateIndex = selectDate.value;
    var currentDate = dates[dateIndex];
    document.querySelector('#date label').innerText = currentDate;

    // Définition les limites de date
    var thresholdMin, thresholdMax;
    if (dateIndex == dates.length - 1) {
        thresholdMin = null;
        thresholdMax = null;
    }
    else if (dateIndex == dates.length - 2) {
        // Quand on est à la dernière date avant "Tout"
        thresholdMin = new Date(currentDate);
        thresholdMax = new Date(2026, 12, 31);
    } else {
        thresholdMin = new Date(currentDate);
        thresholdMax = new Date(dates[parseInt(dateIndex) + 1]);
    }

    articles.forEach((article) => {
        // Date

        var dateOK = false;

        // Quand on sélectionne "Tout"
        if (dateIndex == dates.length - 1) {
            dateOK = true;
        } else {
            var articleDate = new Date(article.getAttribute('data-date'));
            if (articleDate >= thresholdMin && articleDate < thresholdMax) {
                dateOK = true;
            } else {
                dateOK = false;
            }
        }

        // Auteur·ice

        var authorOK = false;

        if (author === "all" || article.getAttribute('data-author') === author) {
            authorOK = true;
        } else {
            authorOK = false;
        }


        // Décider de l'affichage ou non
        if (dateOK && authorOK) {
            article.style.display = "block";
            console.log(article)
        }
        else {
            article.style.display = "none";
        }
    });
}

selectDate.addEventListener('input', filterArticles);
selectAuthor.addEventListener('change', filterArticles);
