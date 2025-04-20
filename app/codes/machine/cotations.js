document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM complètement chargé !");
    console.log("Fichier JS chargé !");

    fetchCotation(); // Charger les cotations au démarrage
    chargerTypesContrat(); // Charger les types de contrat
});

// Sélection des éléments
const selectTypeContrat = document.getElementById('typecontrat');
const form = document.getElementById("cotationForm");
const submitBtn = form.querySelector("button[type='submit']");
const searchInput = document.getElementById("searchInput");

// Fonction pour charger les types de contrat
function chargerTypesContrat() {
    const apiUrl = BASE_API_URL + "ggacontrat.php/getTypeContrat";
    fetch('http://localhost:8080/crm-gga/app/codes/api/v1/ggacontrat.php/getTypeContrat')
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
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
}

// Gestion du formulaire de cotation
form.addEventListener("submit", function (e) {
    e.preventDefault();

    submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Création...`;
    submitBtn.disabled = true;

    const formData = new FormData(form);
    const jsonData = {};

    formData.forEach((value, key) => {
        jsonData[key] = value;
    });

    fetch("http://localhost/crm-gga/app/codes/api/v1/AddCotation.php", {
        method: "POST",
        headers: { "Content-Type": "application/json", "Accept": "application/json" },
        body: JSON.stringify(jsonData),
    })
    .then(response => response.json())
    .then(response => {
        setTimeout(() => {
            submitBtn.innerHTML = "Créer";
            submitBtn.disabled = false;

            if (response.status === "success") {
                Swal.fire({
                    title: "Succès !",
                    text: "Cotation enregistrée avec succès !",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    fetchCotation(); // Recharger les cotations après l'ajout
                    form.reset(); // Réinitialiser le formulaire
                    closeModal(); // Fermer le modal
                });
            } else {
                Swal.fire({
                    title: "Erreur !",
                    text: response.message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        }, 2000);
    })
    .catch(error => {
        setTimeout(() => {
            submitBtn.innerHTML = "Créer";
            submitBtn.disabled = false;
            Swal.fire({
                title: "Erreur !",
                text: "Erreur lors de l'enregistrement !",
                icon: "error",
                confirmButtonText: "OK"
            });
        }, 2000);
        console.error("Erreur:", error);
    });
});

// Fonction pour récupérer et afficher les cotations
function fetchCotation() {
    fetch('http://localhost/crm-gga/app/codes/api/v1/getCotations.php')
        .then(response => response.json())
        .then(response => {
            console.log("Réponse API :", response);

            let tbody = document.querySelector("#cotationTable tbody");
            tbody.innerHTML = "";  // Nettoyer le tableau avant de le remplir

            if (response.status === "success") {
                response.data.forEach((cot, index) => {
                    let row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${cot.datecotation}</td>
                            <td>${cot.libtype}</td>
                            <td>${cot.nomdemandeur} (${cot.societe})</td>
                            <td>${cot.beneficiaire}</td>
                            <td>${cot.budget}</td>
                            <td>${cot.couverture}</td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });

                // Mettre à jour la pagination après le remplissage du tableau
                updatePagination();
            } else {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;">Aucune cotation trouvée</td></tr>`;
            }
        })
        .catch(error => {
            console.error("Erreur lors de l'appel API :", error);
        });
}

// Fonction pour fermer le modal après l'ajout d'une cotation
function closeModal() {
    const modal = document.getElementById("modalCotation");
    if (modal) {
        modal.style.display = "none"; // Ferme le modal (ajuste cette ligne en fonction de la méthode de fermeture de ton modal)
    }
}





