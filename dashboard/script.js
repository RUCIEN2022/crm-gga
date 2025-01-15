document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const sidebarCollapse = document.getElementById('sidebarCollapse');

    sidebarCollapse.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        content.classList.toggle('active');
    });

    // Menu Items Interaction
    const menuItems = document.querySelectorAll('#sidebar ul li');
    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            menuItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            document.querySelector('.navbar h2').textContent = 
                item.querySelector('span').textContent || 'Dashboard';
        });
    });

// Update Time
function updateTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0'); // Ajout des secondes
    document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds}`;
}

// Met à jour l'heure immédiatement et toutes les secondes
updateTime();
setInterval(updateTime, 1000);



});