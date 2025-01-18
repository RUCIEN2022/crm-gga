
$(document).ready(function () {
    const selectPays = $('#pays');
    // Charger les pays
    fetch('https://flagcdn.com/fr/codes.json')
        .then(response => response.json())
        .then(countries => {
            selectPays.empty();
            for (const [code, name] of Object.entries(countries)) {
                const option = new Option(name, code);
                selectPays.append(option);
            }
            selectPays.select2({
                placeholder: '--choisir un pays--',
                allowClear: true
            });
        })
        .catch(error => console.error('Erreur lors du chargement des pays :', error));
});

document.addEventListener('DOMContentLoaded', function () {
    fetch('http://localhost/crm-gga/app/codes/api/v1/ggacontrat.php/getTypeContrat')
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                const selectTypeContrat = document.getElementById('typecontrat');
                data.data.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.idtype;
                    option.textContent = type.libtype;
                    selectTypeContrat.appendChild(option);
                });
            } else {
                console.error('Erreur: ', data.message);
            }
        })
        .catch(error => console.error('Erreur lors du chargement des types de contrats:', error));

        const selectPartenaire = document.getElementById('assureur');
selectPartenaire.innerHTML = '<option>Chargement...</option>'; // Avant la requête

fetch('http://localhost/crm-gga/app/codes/api/v1/api_partenaire.php/partenaires')
    .then(response => response.json())
    .then(data => {
        selectPartenaire.innerHTML = ''; // Nettoyer les options par défaut
        
        // Ajouter l'option par défaut
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '--choisir--';
        selectPartenaire.appendChild(defaultOption);

        // Ajouter les options récupérées depuis l'API
        data.forEach(parten => {
            const option = document.createElement('option');
            option.value = parten.idpartenaire;
            option.textContent = parten.denom_social;
            selectPartenaire.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Erreur:', error);
        selectPartenaire.innerHTML = '<option>Erreur de chargement</option>';
    });


        
});