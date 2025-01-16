<?php
session_start();
session_unset();//on deconnecte la session
session_destroy();//on detruit les identifiants
header("Location: login/"); // on redirige vers la page de connexion
exit();
