fetch('get_cv_data.php')
    .then(response => response.json())
    .then(data => {
        // Trier les CVs par score
        data.sort((a, b) => a.score - b.score);

        // Afficher les CVs triés
        const cvList = document.getElementById('cv-list');
        data.forEach(cv => {
            const cvItem = document.createElement('div');
            cvItem.classList.add('cv-item');
            cvItem.innerHTML = `
                <h2>${cv.nom}</h2>
                <p>Score : ${cv.score}</p>
                <p>Compétences : ${cv.competences}</p>
            `;
            cvList.appendChild(cvItem);
        });
    })
    .catch(error => console.error('Error:', error));
Assurez-vous d'avoir les fichiers HTML, CSS et JavaScript dans le même répertoire. Vous devrez également créer une base de données MySQL et ajouter des données aux CVs en utilisant un gestionnaire de bases de données ou un outil comme phpMyAdmin. Vous devrez également créer un fichier PHP (get_cv_da