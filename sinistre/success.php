<?php
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : "Opération réussie.";
$numPolice = isset($_GET['numPolice']) ? htmlspecialchars($_GET['numPolice']) : "Non spécifié";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Succès</title>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .error-container {
            text-align: center;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
        }
        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #923a4d;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
            margin: 0 auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .error-icon {
            font-size: 100px;
            color: #923a4d;
        }
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .numPolice {
            font-size: 16px;
            margin-top: 10px;
            color: #555;
        }
        h1 {
            font-size: 2.5rem;
            color: #343a40;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 30px;
        }
        a {
            font-size: 1.1rem;
            text-decoration: none;
            color: #fff;
            background-color: #923a4d;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #923a4d;
        }
    </style>
</head>
<body>

    <!-- Loader that shows before the success message -->
    <div id="loader" class="loader"></div>

    
    <div class="error-container" id="successMessage">
        <div class="error-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h3 class="message"><?php echo $message; ?></h3>
        <p class="numPolice">Numéro de police : <span class="fw-bold"><?php echo $numPolice; ?></span></p>
        <p>Une note de débit (ND) vient d'être générée sur ce contrat.</p>
        <a href="./notedebit?np=<?php echo $numPolice; ?>" target="_blank">Voir la note de débit</a>

    </div>

    <script>
        setTimeout(function() {
            document.getElementById('loader').style.display = 'none';
            document.getElementById('successMessage').style.display = 'block';
        }, 3000);
    </script>

</body>
</html>
