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

    // Chart
    const ctx = document.getElementById('chartAssureur').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Assureur A', 'Assureur B', 'Assureur C', 'Assureur D'],
            datasets: [{
                label: 'Chiffres d\'Affaires ($)',
                data: [48000, 30000, 20000, 10000],
                backgroundColor: '#e94364',
                borderColor: '#e94364',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Ticker Animation
    const tickerContent = document.querySelector('.ticker-content');
    const contracts = [
        'Nouveau contrat: Client A - $50,000',
        'Nouveau contrat: Client B - $75,000',
        'Nouveau contrat: Client C - $100,000',
        'Nouveau contrat: Client D - $25,000',
        'Nouveau contrat: Client E - $80,000'
    ];

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