<?php
session_start();

// notre chemin de base
define('BASE_URL', '/app-gga'); // Chemin racine

if ((!isset($_SESSION['idutile'])) || ($_SESSION['adresseIP'] != $_SERVER['REMOTE_ADDR'])) {
    if (!isset($_SESSION['idutile'])) {
        // Redirection vers la page de login avec le chemin absolu
        header("Location: " . BASE_URL . "/login");
        exit();
    }
}
?>

