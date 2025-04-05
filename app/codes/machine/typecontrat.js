document.addEventListener('DOMContentLoaded', function () {
    const selectTypeContrat = document.getElementById('typecontrat');
    const typepolice = document.getElementById('typecont');

    // Fonction pour charger les types de contrat
    function chargerTypesContrat() {
        fetch('http://localhost/crm-gga/app/codes/api/v1/ggacontrat.php/getTypeContrat')
            .then(response => response.json())
            .then(data => {
                if (data.status === 200) {
                    data.data.forEach(type => {
                        const option = document.createElement('option');
                        option.value = type.idtype;
                        option.textContent = type.libtype;
                        selectTypeContrat.appendChild(option);
                    });

                    // Afficher la première option sélectionnée si elle existe
                  //  if (selectTypeContrat.options.length > 0) {
                  //      afficherTypeContrat();
                  //  }
                } else {
                    console.error('Erreur: ', data.message);
                }
            })
            .catch(error => console.error('Erreur lors du chargement des types de contrats:', error));
    }
    // Charger les types de contrat au démarrage
    //chargerTypesContrat();
    // Mettre à jour l'affichage lors du changement de sélection
    //selectTypeContrat.addEventListener('change', afficherTypeContrat);


    

});