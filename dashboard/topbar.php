 <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="d-flex justify-content-between w-100 align-items-center">
                        <h2>Dashboard</h2>
                        <div class="user-info">
                            <span class="user-name">Bonjour, <?= htmlspecialchars($userPrenom . ' ' . $userNom) ?></span>
                            <span class="time" id="currentTime"></span>
                        </div>
                        <div class="position-relative animate-notification">
                            <a href="" class="text-white" style="text-decoration: none;">
                           <span class="badged rounded p-2 bg-danger">
                           
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