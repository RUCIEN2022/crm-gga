<nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="d-flex justify-content-between w-100 align-items-center">
                        <h2>Tableau de bord</h2>
                        <div class="user-info dropdown">
                        <button class="btn btn-dark dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 12px;">
                            Bonjour, <?= htmlspecialchars($userPrenom . ' ' . $userNom) ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="change_password.php"><i class="bi bi-lock"></i> Changer mot de passe</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Se Déconnecter</a></li>
                        </ul>
                        <span class="time" id="currentTime"></span>
                    </div>

                        <div class="position-relative animate-notification">
                            <a href="" class="text-white" style="text-decoration: none;">
                           <span class="badged rounded p-2" style="background-color: #923a4d;">
                           
                           <i class="bi bi-folder text-orange" style="font-size: 1.5rem;">
                            
                           </i>
                            <span id="totalnewcontrat" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-orange text-white" style="font-size: 0.75rem;">
                                
                            </span>
                            Nouveau
                           </span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>