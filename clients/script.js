document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
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

 


    function updateTicker() {
        tickerContent.innerHTML = contracts.map(contract => 
            `<div class="ticker-item">${contract}</div>`
        ).join('');
    }

    updateTicker();
    setInterval(updateTicker, 30000);

    // Update Time
    function updateTime() {
        const now = new Date();
        const timeElement = document.getElementById('currentTime');
        timeElement.textContent = now.toLocaleString('fr-FR', {
            hour: '2-digit',
            minute: '2-digit',
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    updateTime();
    setInterval(updateTime, 1000);
});