<?php
include_once(__DIR__ . '/../../models/ClassUser.php');
require_once 'tindamail.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
    exit;
}

// Lecture des données envoyées
$data = json_decode(file_get_contents('php://input'), true);

// check params
if (!isset($data['email']) || empty($data['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Adresse email requise']);
    exit;
}

$users = new Utilisateur();
$result = $users->fx_resetpwd($data['email']);
if ($result['status'] === 'success') {
    // Préparation des données pour l'envoi de l'email
    $subject = 'Réinitialisation de votre mot de passe';
    $message = "
        Bonjour,
        
        Votre mot de passe a été réinitialisé avec succès. Voici votre mot de passe temporaire :
        
        Mot de passe : {$result['temporaryPassword']}
        
        Veuillez vous connecter à votre compte et changer immédiatement votre mot de passe.
        
        Lien de connexion : http://localhost/app-gga/login/
        
        
        Cordialement,
        L'équipe de support.
    ";
    $emailSent = sendMail($data['email'], $subject, $message);

    if ($emailSent) {
        echo json_encode(['status' => 'success', 'message' => 'Mot de passe réinitialisé et envoyé par email']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email']);
    }
} else {
    echo json_encode($result);
}
