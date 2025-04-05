<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>success</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .success-container {
            text-align: center;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .error-icon {
            font-size: 100px;
            color:rgb(100, 191, 243);
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
            background-color:rgb(121, 247, 203);
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color:rgb(39, 221, 142);
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>Succès</h1>
        <p>Le nouveau contrat est créé avec succès</p>
        <a href="/crm-gga/">Continuer</a>
    </div>
</body>
</html>
