<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer un Partenaire</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        form {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        .row .col {
            flex: 1;
            padding: 10px;
            min-width: 250px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color:rgb(80, 44, 240);
            color: white;
            cursor: pointer;
        }
        .btn {
            background-color:rgb(205, 15, 53);
            color: white;
            cursor: pointer;
        }
        .btn:hover {
            background-color:rgb(198, 85, 108);
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color:rgb(47, 35, 153);
        }
        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .spinner {
            display: none;
            margin-left: 10px;
        }
        .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        min-width: 250px;
        padding: 15px;
        border-radius: 8px;
        color: white;
        font-size: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        display: none;
    }
    .toast.success {
        background-color: #4CAF50;
    }
    .toast.error {
        background-color: #4CAF50;
    }
    .toast.show {
        display: block;
        animation: fadeIn 0.5s, fadeOut 0.5s 4s;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
    }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Créer un nouveau Partenaire</h1>
    <form id="partenaireForm">
        <div class="row">
            <div class="col">
                <input type="text" id="denom_social" placeholder="Dénomination sociale" required autofocus>
                <input type="text" id="pays_assu" placeholder="Pays d'assurance" required>
                <input type="text" id="ville_assu" placeholder="Ville d'assurance" required>
                <input type="text" id="adresse_assu" placeholder="Adresse" required>
                <input type="text" id="code_interne" placeholder="Code interne" required>
            </div>
            <div class="col">
                <input type="text" id="numeroAgree" placeholder="Numéro d'agrément" required>
                <input type="text" id="Rccm" placeholder="RCCM" required>
                <input type="text" id="numero_impot" placeholder="Numéro d'impôt" required>
                <input type="email" id="emailEntre" placeholder="Email de l'entreprise" required>
                <input type="text" id="telephone_Entr" placeholder="Téléphone de l'entreprise" required>
            </div>
            <div class="col">
                <input type="text" id="nomRespo" placeholder="Nom du responsable" required>
                <input type="email" id="emailRespo" placeholder="Email du responsable" required>
                <input type="text" id="TelephoneRespo" placeholder="Téléphone du responsable" required>
                
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="button" onclick="submitForm()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
            </div>
            <div class="col">
                <button type="button" class="btn btn-danger" onclick="clearForm()">Nouveau</button>
            </div>
        </div>
    </form>

    <div id="toast" class="toast"></div>

<script>
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        toast.className = `toast ${type} show`;
        toast.innerText = message;

        setTimeout(() => {
            toast.className = toast.className.replace('show', '');
        }, 4500); // Durée d'affichage de 4,5 secondes
    }

    function clearForm() {
        document.getElementById("partenaireForm").reset();
        document.getElementById("denom_social").focus();
    }

    function submitForm() {
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");

        const formData = {
            denom_social: document.getElementById("denom_social").value,
            pays_assu: document.getElementById("pays_assu").value,
            ville_assu: document.getElementById("ville_assu").value,
            adresse_assu: document.getElementById("adresse_assu").value,
            code_interne: document.getElementById("code_interne").value,
            numeroAgree: document.getElementById("numeroAgree").value,
            Rccm: document.getElementById("Rccm").value,
            numero_impot: document.getElementById("numero_impot").value,
            emailEntre: document.getElementById("emailEntre").value,
            telephone_Entr: document.getElementById("telephone_Entr").value,
            nomRespo: document.getElementById("nomRespo").value,
            emailRespo: document.getElementById("emailRespo").value,
            TelephoneRespo: document.getElementById("TelephoneRespo").value,
            etatpartenaire: 1
        };

        button.disabled = true;
        spinner.style.display = "inline-block";

        fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_partenaire.php/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            setTimeout(() => {
                button.disabled = false;
                spinner.style.display = "none";

                if (data.status === 200) {
                    showToast('Partenaire enregistré avec succès!', 'success');
                    clearForm();
                } else {
                    showToast(data.message || 'Une erreur est survenue.', 'error');
                }
            }, 3000);
        })
        .catch(error => {
            setTimeout(() => {
                button.disabled = false;
                spinner.style.display = "none";

                showToast('Erreur lors de l\'enregistrement.', 'error');
                console.error('Error:', error);
            }, 3000);
        });
    }
</script>


</body>
</html>
