
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Facture GGA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family:Verdana, Geneva, Tahoma, sans-serif;
        }
        .invoice-card {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
        }
        .header-logo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            
        }
        .header-logo img{
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 50%;
        }
        .facture-label {
            background-color: #ddd;
            padding: 5px 15px;
            font-weight: bold;
            border-radius: 5px;
        }
        .bank-details {
    border-left: 3px solid #923a4d;  /* Bordure à gauche */
    border-right: 3px solid #923a4d; /* Bordure à droite */
    border-radius: 15px 15px 15px 15px;    /* Arrondis en haut */
    padding: 15px;
    }

    </style>
</head>
<body>

<?php
/*
    if (!isset($_GET['np'])) {
        die("Numéro de police manquant !");
    }

    $numPolice = $_GET['np'];
    $api_url = "http://localhost/crm-gga/app/codes/api/contrat.php?np=" . urlencode($numPolice);
    
    $response = file_get_contents($api_url);
    $contrat = json_decode($response, true);

    if (!$contrat || isset($contrat['error'])) {
        die("Contrat non trouvé !");
    }
    */
?>
<div class="container">
    <div class="card invoice-card shadow">
        <div class="card-body m-5">
        <div class="header-logo d-flex justify-content-center mt-0">
        <img src="../ressources/logogga2.PNG" alt="Logo GGA" class="img-fluid" style="width: 900px;margin-top: -70px;">
        </div>

            
            <!-- Infos Client -->
                <div class="d-flex justify-content-between pt-5">
                <div class="d-flex align-items-center">
                <span style="display: inline-block; height: 45px; width: 10px; border-right: 3px solid #923a4d; margin-right: 10px;"></span>
                <span class="fw-bold text-center rounded-3" style="background-color: #ccc; padding: 10px 100px;">
                    Facture
                </span>
                
                </div>


                <div class="text-end">
                    <h5 class="text-end fw-fold"><span id="codeND" style="font-size: 14px;"></span></h5>
                </div>
                
            </div>
            <div class="text-end pt-5">
               
                    <h5 class="text-end fw-fold"><span id="codeND" style="font-size: 14px;"></span></h5>
                    <h5 class="fw-bold text-end" style="font-size: 14px;"><span id="nomclient"></span></h5>
                    <p style="font-size: 14px;"><span id="adresseclient"></span><br>
                       <span id="communevilleclient" style="text-decoration: underline;"></span><br>
                    </p>
                    <span class="text-center" style="font-size: 14px;">Date d'édition : <span id="dateedition"></span></span>
                </div>
            <!-- Message -->
            <p class="mt-3" style="font-size: 14px;">Cher client,</p>
            <p style="font-size: 12px;">Veuillez trouver la Facture N° <strong><span id="codeND"></span></strong>, correspondant aux 50% des honoraires de GGA pour <br> la gestion de la couverture médicale de vos agents et ayants droit en province.</p>

            <!-- Détails Facture -->
            <ul class="list-unstyled" style="font-size: 14px;">
                <li>Période : Du <span id="dateeffet"></span> Au <span id="dateecheance"></span></li>
                <li>Nombre de bénéficiaires : <span id="nombrebenef"></span></li>
                <li>Cotisation totale : <span id="montantbudget"></span></li>
                <li>Frais de gestion GGA : <span id="fraisgestion"></span></li>
                <li>TVA sur Frais de gestion : <span id="tva"></span></li>
                <li class="fw-bold" style="font-size: 14px;">Total Frais de gestion : <strong><span id="totalfraisgestion"></span></strong></li>
            </ul>
            <p class="" style="font-size: 14px;"><span id="pourcentagefraisgestion"></span> à reverser à la mise en place : <span id="montantfrais"></span></p>
            <p><h5 style="font-size: 14px;">Nous restons à votre disposition pour toute information complémentaire.</h5></p>
            <hr>
            <!-- Infos Bancaires -->
            <h5 class="text-start fw-bold text-uppercase mt-4" style="font-size: 12px;text-decoration:underline">
                Merci de transférer les fonds uniquement sur le compte ci-dessous
            </h5>

            <div class="row text-center mt-4">
                <div class="col-md-6">
                    <div class="bank-details text-start" style="font-size: 10px;">
                        <h5 style="font-size: 12px;"><strong>Titulaire du compte :</strong> GGA RDC PRODUCTION</h5>
                        <h5 style="font-size: 12px;"><strong>Domiciliation :</strong> BANK OF AFRICA</h5>
                        <h5 style="font-size: 12px;"><strong>BIC :</strong> AFRICDKSXXX</h5>
                        <h5 style="font-size: 12px;"><strong>RIB :</strong> 00029 01015 02118310024 69 (USD)</h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bank-details text-start" style="font-size: 12px;">
                        <h5 style="font-size: 12px;"><strong>Titulaire du compte :</strong> GGA RDC PRODUCTION</h5>
                        <h5 style="font-size: 12px;"><strong>Domiciliation :</strong> RAWBANK</h5>
                        <h5 style="font-size: 12px;"><strong>BIC :</strong> RAWBODKI</h5>
                        <h5 style="font-size: 12px;"><strong>RIB :</strong> 05100-05101-010083563402-62 (USD)</h5>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Signatures -->
            <div class="row text-center mt-4">
                <div class="col-md-6">
                    <p class="fw-bold" style="font-size: 10px;"><span id="nomuser"></span> <?php echo $userPrenom. " ".$userNom;?></p>
                    <p><a href="#" class="text-decoration-none" style="font-size: 12px;">Gestionnaire Production</a></p>
                </div>
                <div class="col-md-6">
                    <p class="fw-bold" style="font-size: 10px;">Yves MOBOLAMA</p>
                    <p><a href="#" class="text-decoration-none" style="font-size: 12px;">Directeur Général</a></p>
                </div>
            </div>
            <div class="row text-start mt-5">
                <div class="col-md-12">
                    <p>
                        <h5 style="font-size: 8px;"><span class="text-danger">GROUPEMENT DE GESTION ET D’ASSURANCE RDC</span> – S.A. AVEC CONSEIL D’ADMINISTRATION AU CAPITAL DE 10 000 USD ENTIEREMENT LIBERE. GESTIONNAIRE AGREE PAR L’ARCA SOUS N° 30001.</h5>
                        <h5 style="font-size: 8px;">66 BOULEVARD DU 30 JUIN, IMMEUBLE RR HOUSE – 2ème ETAGE  - KINSHASA / GOMBE  – TEL : 081 889 6969 – RCCM CD/KNG/RCCM/18-B-00262 – ID NAT 01-83-N57853Z </h5>
                        <h5 style="font-size: 8px;">N° IMPÔT A2030206F</h5>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Récupérer le numéro de police depuis l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const numeroPolice = urlParams.get("np");

    if (!numeroPolice) {
        alert("Aucun numéro de police fourni !");
        return;
    }
    function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("fr-FR"); // Convertit en JJ/MM/AAAA
}

function formatCurrency(value) {
    return new Intl.NumberFormat("fr-FR", { style: "currency", currency: "USD" }).format(value);
}
    // Effectuer une requête AJAX pour récupérer les données
    fetch(`../app/codes/api/v1/ControllerGetContrat.php?np=${numeroPolice}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert("Contrat non trouvé !");
                return;
            }

            // Remplir les champs du document avec les données récupérées
            document.getElementById("codeND").textContent = data.num_nd;
            document.getElementById("nomclient").textContent = data.Client_name;
            document.getElementById("adresseclient").textContent = data.adresse_entr;
            document.getElementById("communevilleclient").textContent = data.ville_entr;
            document.getElementById("dateeffet").textContent = formatDate(data.dateEffet);
            document.getElementById("dateecheance").textContent = formatDate(data.dateEcheance);
            document.getElementById("nombrebenef").textContent = data.effectif_Benef;
            document.getElementById("montantbudget").textContent = formatCurrency(data.prime_ttc);
            document.getElementById("fraisgestion").textContent = formatCurrency(data.frais_gga);
            document.getElementById("pourcentagefraisgestion").textContent = formatCurrency(data.modalite);
            document.getElementById("tva").textContent = formatCurrency(data.tva);

            // Calcul du total frais de gestion
            document.getElementById("totalfraisgestion").textContent = formatCurrency(
            parseFloat(data.frais_gga) + parseFloat(data.tva)
        );

        
        const pourcentage = 50;
            document.getElementById("pourcentagefraisgestion").textContent = pourcentage + "%";
            const totalFraisGestion = (parseFloat(data.frais_gga) || 0) + (parseFloat(data.tva) || 0);
            const montantFrais = (totalFraisGestion * pourcentage) / 100;
            document.getElementById("montantfrais").textContent = formatCurrency(montantFrais);
            function formatCurrency(value) {
                return new Intl.NumberFormat("fr-FR", { style: "currency", currency: "USD" }).format(value);
            }


            const today = new Date().toISOString().split("T")[0];
            document.getElementById("dateedition").textContent = formatDate(today);

        })
        .catch(error => console.error("Erreur lors de la récupération des données :", error));
});
</script>


</body>
</html>
