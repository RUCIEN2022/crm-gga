

document.getElementById('reassurance').addEventListener('change', function () {
    const reassuranceFields = document.getElementById('reassurance-fields');
    const reassureur = document.getElementById('reassureur');
    const quotePartReassureur = document.getElementById('QpReassureur');
    const quotePartAssureur = document.getElementById('QpAssureur');

    if (this.checked) {
        // Activer les champs
        reassuranceFields.classList.remove('d-none');
        reassureur.disabled = false;
        quotePartReassureur.disabled = false;
        quotePartAssureur.disabled = false;
    } else {
        // Désactiver les champs
        reassuranceFields.classList.add('d-none');
        reassureur.disabled = true;
        quotePartReassureur.disabled = true;
        quotePartAssureur.disabled = true;
    }
});
function calculateTotalFraisGestion() {
    var typecontrat = document.getElementById('typecontrat').value; // Récupérer le type de contrat
    var fraisGestionPourcentage = parseFloat(document.getElementById('fraisGestionGGA').value) || 0;
    var tvaChecked = document.getElementById('TVA').checked;
    
    var baseCalcul = 0;

    if (typecontrat === '1') {
        baseCalcul = parseFloat(document.getElementById('primeNette').value) || 0;
    } else if (typecontrat === '2') {
        baseCalcul = parseFloat(document.getElementById('budgetTotal').value) || 0;
    }

    // Calcul des frais de gestion HT
    var fraisGestionGGAHT = (baseCalcul * fraisGestionPourcentage) / 100;
    document.getElementById('ValfraisGestionGGAHT').value = fraisGestionGGAHT.toFixed(2);

    // Ajout de la TVA si cochée
    var totalFraisGestion = fraisGestionGGAHT;
    if (tvaChecked) {
        totalFraisGestion += fraisGestionGGAHT * 0.16;
    }

    // Mise à jour du total
    document.getElementById('totalFraisGestion').value = totalFraisGestion.toFixed(2);
}

// Attacher les événements pour recalculer automatiquement
document.getElementById('typecontrat').addEventListener('change', calculateTotalFraisGestion);
document.getElementById('fraisGestionGGA').addEventListener('input', calculateTotalFraisGestion);
document.getElementById('budgetTotal').addEventListener('input', calculateTotalFraisGestion);
document.getElementById('primeNette').addEventListener('input', calculateTotalFraisGestion);
document.getElementById('TVA').addEventListener('change', calculateTotalFraisGestion);

// Initialisation au chargement de la page
window.onload = function() {
    calculateTotalFraisGestion();
};

     // Fonction de calcul de Prime TTC
     function calculatePrimeTtc() {
        var primeNette = parseFloat(document.getElementById('primeNette').value) || 0; // récupère la valeur de primeNette
        var accessoires = parseFloat(document.getElementById('accessoires').value) || 0; // récupère la valeur de accessoires
        
        // Calcule la Prime TTC comme la somme de primeNette et accessoires
        var primeTtc = primeNette + accessoires;

        // Met à jour la valeur de primeTtc
        document.getElementById('primeTtc').value = primeTtc.toFixed(2);
    }
    function calculateModaliteFacturation() {
    const pourcentageField = document.getElementById("mod_Facturation");
    const valeurField = document.getElementById("Valmod_Facturation");
    const totalAmountField = document.getElementById("primeNette");

    const pourcentage = parseFloat(pourcentageField.value) || 0; // Récupère le pourcentage
    const totalAmount = parseFloat(totalAmountField.value) || 0; // Récupère le montant total
    // Calcul de la valeur
    const valeur = (totalAmount * pourcentage) / 100;
    // Affiche le résultat dans le champ "Valeur"
    valeurField.value = valeur.toFixed(2); 
    document.getElementById('Valmod_Facturation').value = valeurField.toFixed(2);// Formate à 2 décimales
}

function calculateEffectifs() {
    const agent = document.getElementById("effectAgent");
    const conjoint = document.getElementById("effectConj");
    const enfant = document.getElementById("effectEnf");
    const totalEffectif = document.getElementById("effectTot"); // Correction du nom
    // Récupération des valeurs (avec gestion des valeurs vides ou invalides)
    const effAgent = parseInt(agent.value) || 0;
    const effConjoint = parseInt(conjoint.value) || 0;
    const effEnfant = parseInt(enfant.value) || 0;
    // Calcul du total
    const total = effAgent + effConjoint + effEnfant;
    // Mise à jour du champ "Effectif Total"
    totalEffectif.value = total; 
}
    // Fonction pour valider que seules les valeurs numériques sont saisies
    function validateNumericInput(event) {
        var value = event.target.value;
        // Remplace tout ce qui n'est pas un chiffre ou un point
        event.target.value = value.replace(/[^0-9.]/g, '');
    }

    // Attacher l'événement de validation numérique aux champs
    document.getElementById('primeNette').addEventListener('input', validateNumericInput);
    document.getElementById('accessoires').addEventListener('input', validateNumericInput);
    document.getElementById('budgetTotal').addEventListener('input', validateNumericInput);
    document.getElementById('PourcmodAppelFonds').addEventListener('input', validateNumericInput);

    // Initialisation de la valeur de primeTtc au chargement de la page
    window.onload = function() {
        calculatePrimeTtc();
    };
//------------ fin traitement formulaire---------------

document.addEventListener('DOMContentLoaded', function () {
    const selectTypeContrat = document.getElementById('typecontrat');
    const typepolice = document.getElementById('typecont');

    // Fonction pour charger les types de contrat
    
    function chargerTypesContrat() {
       // const apiUrl = BASE_API_URL + "ggacontrat.php/getTypeContrat";
      //  fetch(apiUrl)
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
                    if (selectTypeContrat.options.length > 0) {
                        afficherTypeContrat();
                    }
                } else {
                    console.error('Erreur: ', data.message);
                }
            })
            .catch(error => console.error('Erreur lors du chargement des types de contrats:', error));
    }

    // Fonction pour afficher le type de contrat sélectionné
    function afficherTypeContrat() {
        const selectedOption = selectTypeContrat.options[selectTypeContrat.selectedIndex];
        typepolice.textContent = selectedOption.textContent; // Mise à jour du texte
    }

    // Charger les types de contrat au démarrage
    chargerTypesContrat();

    // Mettre à jour l'affichage lors d'un changement de sélection
    selectTypeContrat.addEventListener('change', afficherTypeContrat);

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

    //Les reassusseurs
const selectReassureur = document.getElementById('reassureur');
selectReassureur.innerHTML = '<option>Chargement...</option>'; // Avant la requête
fetch('http://localhost/crm-gga/app/codes/api/v1/api_partenaire.php/partenaires')
    .then(response => response.json())
    .then(data => {
        selectReassureur.innerHTML = ''; // Nettoyer les options par défaut
        
        // Ajouter l'option par défaut
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '--choisir--';
        selectReassureur.appendChild(defaultOption);

        // Ajouter les options récupérées depuis l'API
        data.forEach(parten2 => {
            const option = document.createElement('option');
            option.value = parten2.idpartenaire;
            option.textContent = parten2.denom_social;
            selectReassureur.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Erreur:', error);
        selectReassureur.innerHTML = '<option>Erreur de chargement</option>';
    });

    //Les gestionnaires

const selectAgent = document.getElementById('gestionnaire');
selectAgent.innerHTML = '<option>Chargement...</option>'; // Avant la requête
fetch('http://localhost/crm-gga/app/codes/api/v1/ggacontrat.php/getGestionnaire')
    .then(response => response.json())
    .then(responseData => {
        // Vérifier si la réponse contient la clé "data"
        if (responseData.status === 200 && Array.isArray(responseData.data)) {
            const data = responseData.data;

            selectAgent.innerHTML = ''; // Nettoyer les options par défaut
            
            // Ajouter l'option par défaut
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '--choisir--';
            selectAgent.appendChild(defaultOption);

            // Ajouter les options récupérées depuis l'API
            data.forEach(agent => {
                const option = document.createElement('option');
                option.value = agent.idagent;
                option.textContent = `${agent.nomagent} ${agent.prenomagent}`;
                selectAgent.appendChild(option);
            });

            // Initialiser Select2 une fois les options ajoutées
            $('#gestionnaire').select2({
                placeholder: '--choisir--',
                allowClear: true,
            });
        } else {
            throw new Error('Structure inattendue de la réponse');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        selectAgent.innerHTML = '<option>Erreur de chargement</option>';
    });

const selectIntermaire = document.getElementById('intermediaire');
selectIntermaire.innerHTML = '<option>Chargement...</option>'; // Avant la requête
fetch('http://localhost/crm-gga/app/codes/api/v1/intermediaire.php/liste')
    .then(response => response.json())
    .then(responseData => {
        // Vérifier si la réponse est un tableau d'objets
        if (Array.isArray(responseData)) {
            selectIntermaire.innerHTML = ''; // Nettoyer les options par défaut

            // Ajouter l'option par défaut
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '--choisir--';
            selectIntermaire.appendChild(defaultOption);

            // Ajouter les options récupérées depuis l'API
            responseData.forEach(inter => {
                const option = document.createElement('option');
                option.value = inter.idinte;
                option.textContent = inter.nomcomplet; // Correction ici, vous aviez 'nocomplet' au lieu de 'nomcomplet'
                selectIntermaire.appendChild(option);
            });

            // Initialiser Select2 une fois les options ajoutées
            $('#intermediaire').select2({
                placeholder: '--choisir--',
                allowClear: true,
            });
        } else {
            throw new Error('Structure inattendue de la réponse');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        selectIntermaire.innerHTML = '<option>Erreur de chargement</option>';
    });

const selectClient = document.getElementById('client');
selectClient.innerHTML = '<option>Chargement...</option>'; // Avant la requête
fetch('http://localhost/crm-gga/app/codes/api/v1/api_client.php/rccm')
    .then(response => {
        if (!response.ok) {
            throw new Error(`Erreur HTTP ! Statut : ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        // Vérifier si la réponse est un tableau
        if (Array.isArray(data)) {
            selectClient.innerHTML = ''; // Nettoyer les options par défaut
            
            // Ajouter l'option par défaut
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '--choisir--';
            selectClient.appendChild(defaultOption);

            // Ajouter les options récupérées depuis l'API
            data.forEach(client => {
                const option = document.createElement('option');
                option.value = client.idclient;
                option.textContent = client.den_social;
                selectClient.appendChild(option);
            });

            // Initialiser Select2 une fois les options ajoutées
            $('#client').select2({
                placeholder: '--choisir--',
                allowClear: true,
            });
        } else {
            throw new Error('Structure inattendue de la réponse API');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        selectClient.innerHTML = '<option>Erreur de chargement</option>';
    });

});