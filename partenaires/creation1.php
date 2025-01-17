
<?php 
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {//si on ne trouve aucun utilisateur
    header("Location: ../login/"); // on redirige vers la page de connexion si non connecté
    exit();
}

// Récupération des données utilisateur
$userId = $_SESSION['user_id'];
$userEmail = $_SESSION['email'];
$userNom = $_SESSION['nom'];
$userPrenom = $_SESSION['prenom'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partenaire Assurance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body{
            background-color: #f4f4f9;
            font-size: 12px;
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

.text-orange {
    color:rgb(240, 235, 235); /* Orange */
}

.bg-orange {
    background-color: #d71828; /* Orange */
}
        .form-section {
           
            border-top: 2px solid #dee2e6;
            margin-top: 20px;
            padding-top: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include_once('navbar.php'); ?>
        <!-- Page Content -->
        <div id="content">
            <!-- Header -->
            <?php include_once('topbar.php'); ?>
            <!-- Cards -->
            <div class="container mt-2">
            <h5 class=" mb-4">Partenaire/Création</h5>
        <div class="card shadow">
            <div class="card-body">
            <form id="partenaireForm" class="p-3">
    <!-- Section 1 -->
    <div class="row g-3 mb-1">
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="denom_social" placeholder="Dénomination sociale" required autofocus>
                <label for="denom_social">Dénomination sociale</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="pays_assu" placeholder="Pays d'assurance" required>
                <label for="pays_assu">Pays d'assurance</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="ville_assu" placeholder="Ville d'assurance" required>
                <label for="ville_assu">Ville d'assurance</label>
            </div>
        </div>
    </div>

    <!-- Section 2 -->
    <div class="row g-3 mb-1">
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="adresse_assu" placeholder="Adresse" required>
                <label for="adresse_assu">Adresse</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="code_interne" placeholder="Code interne" required>
                <label for="code_interne">Code interne</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="numeroAgree" placeholder="Numéro d'agrément" required>
                <label for="numeroAgree">Numéro d'agrément</label>
            </div>
        </div>
    </div>

    <!-- Section 3 -->
    <div class="row g-3 mb-1">
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="Rccm" placeholder="RCCM" required>
                <label for="Rccm">RCCM</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="numero_impot" placeholder="Numéro d'impôt" required>
                <label for="numero_impot">Numéro d'impôt</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="email" class="form-control" id="emailEntre" placeholder="Email de l'entreprise" required>
                <label for="emailEntre">Email de l'entreprise</label>
            </div>
        </div>
    </div>

    <!-- Section 4 -->
    <div class="row g-3 mb-1">
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="telephone_Entr" placeholder="Téléphone de l'entreprise" required>
                <label for="telephone_Entr">Téléphone de l'entreprise</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="nomRespo" placeholder="Nom du responsable" required>
                <label for="nomRespo">Nom du responsable</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="email" class="form-control" id="emailRespo" placeholder="Email du responsable" required>
                <label for="emailRespo">Email du responsable</label>
            </div>
        </div>
    </div>

    <!-- Section 5 -->
    <div class="row g-3 mb-1">
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="TelephoneRespo" placeholder="Téléphone du responsable" required>
                <label for="TelephoneRespo">Téléphone du responsable</label>
            </div>
        </div>
    </div>

    <!-- Boutons d'action -->
    <div class="d-flex justify-content-center gap-3 mt-4">
      
        <button type="button" class="btn btn-success" onclick="submitForm()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
        <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearForm()">
            <i class="bi bi-plus-circle"></i> Nouveau
        </button>
    </div>
</form>


            </div>
        </div>
        </div>
        </div>
    </div>
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

        fetch('http://localhost/gga1/app/codes/api/v1/api_partenaire.php/create', {
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