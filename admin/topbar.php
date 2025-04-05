<nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="d-flex justify-content-between w-100 align-items-center">
                        <h4>Adminiatration</h4>
                        <span class="time" id="currentTime"></span>
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
                        
                    </div>
                        
                    </div>
                </div>
            </nav>