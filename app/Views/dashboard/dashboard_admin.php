
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Support Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #818cf8;
            --success: #22c55e;
            --warning: #f59e0b;
            --background: #0f172a;
            --surface: #1e293b;
            --text: #f8fafc;
            --border: #334155;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--background);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            background-color: var(--surface);
            width: 280px;
            height: 100vh;
            padding: 2rem 1.5rem;
            position: fixed;
            border-right: 1px solid var(--border);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2.5rem;
            padding: 0 0.75rem;
        }

        .logo h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text);
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            color: var(--text);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background-color: rgba(99, 102, 241, 0.1);
            color: var(--primary);
        }

        .main-content {
            margin-left: 280px;
            padding: 2rem;
            width: calc(100% - 280px);
        }

        .header {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background-color: var(--surface);
            border-radius: 1rem;
            border: 1px solid var(--border);
        }

        .header h1 {
            font-size: 1.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text);
        }

        .header p {
            color: #94a3b8;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: var(--surface);
            padding: 1.5rem;
            border-radius: 1rem;
            border: 1px solid var(--border);
        }

        .stat-card h3 {
            font-size: 0.875rem;
            font-weight: 500;
            color: #94a3b8;
            margin-bottom: 0.5rem;
        }

        .stat-card canvas {
            width: 100% !important;
            height: 200px !important;
        }

        .tickets-table {
            background-color: var(--surface);
            border-radius: 1rem;
            border: 1px solid var(--border);
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

.table-responsive {
    overflow-x: auto; /* Tambahkan ini */
    max-width: 100%;
}
        

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .table-header h3 {
            font-size: 1.125rem;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto; /* Pastikan kolom bisa menyesuaikan */
        }

        th, td {
            padding: 0.5rem 1rem; /* Kurangi padding agar tidak terlalu lebar */
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        th {
            background-color: rgba(99, 102, 241, 0.1);
            font-weight: 500;
            color: var(--text);
        }


        tr:hover {
    background-color: rgba(99, 102, 241, 0.05);
}

        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }

        .status-resolved {
            background-color: rgba(34, 197, 94, 0.1);
            color: var(--success);
        }

        .status-assigned {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .refresh-indicator {
            width: 8px;
            height: 8px;
            background-color: var(--success);
            border-radius: 50%;
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.5; }
            100% { transform: scale(1); opacity: 1; }
        }

        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
    th, td {
        font-size: 12px; /* Perkecil font agar tabel tetap muat */
        padding: 0.3rem 0.8rem;
    }
}
    </style>
</head>
<body>
<?= view('sidebar/sidebar') ?>


    <main class="main-content">
        <div class="header">
            <div class="refresh-indicator"></div>
            <h1>IT Support Dashboard</h1>
            <p>Real-time Ticket Monitoring System</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Ticket Status Distribution</h3>
                <canvas id="ticketChart"></canvas>
            </div>
            <div class="stat-card">
                <h3>Total Tickets Entered</h3>
                <canvas id="noChart"></canvas>
            </div>
        </div>

        <div class="tickets-table">
            <div class="table-header">
                <h3>Active Tickets</h3>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Type</th>
                            <th>Ticket</th>
                            <th>Team</th>
                            <th>Support</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>SLA</th>
                            <th>From Assign</th>
                            <th>From Create</th>
                        </tr>
                    </thead>
                    <tbody id="ticket-data"></tbody>
                </table>
            </div>
        </div>
    </main>


    <script>
    let counter = 1;
    let ticketsResolved = 0;
    let ticketsAssigned = 0;
    let ticketsData = [];

    // Arrays untuk menyimpan data time series
    let timeLabels = [];
    let resolvedData = [];
    let assignedData = [];

    const ticketChartElement = document.getElementById('ticketChart');
    const noChartElement = document.getElementById('noChart');
    const tableBody = document.getElementById('ticket-data');

    function getCurrentTime() {
        return new Date().toLocaleTimeString('en-US', { 
            hour12: false, 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        });
    }

    // Konfigurasi Chart
    const ticketChart = new Chart(ticketChartElement.getContext('2d'), {
        type: 'line',
        data: {
            labels: timeLabels,
            datasets: [
                {
                    label: 'Resolved',
                    data: resolvedData,
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 2
                },
                {
                    label: 'Assigned',
                    data: assignedData,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: { color: '#94a3b8' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.1)' },
                    ticks: { color: '#94a3b8' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8' }
                }
            }
        }
    });

    const noChart = new Chart(noChartElement.getContext('2d'), {
        type: 'line',
        data: {
            labels: timeLabels,
            datasets: [{
                label: 'Total Tickets',
                data: [],
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointRadius: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: { color: '#94a3b8' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.1)' },
                    ticks: { color: '#94a3b8' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8' }
                }
            }
        }
    });

    function fetchData() {
        if (!tableBody) return;

        fetch('dashboard/get-random-data')
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (!data || !data.ticket) return;

                if (ticketsData.includes(data.ticket)) return;

                const row = document.createElement('tr');
                const statusClass = data.status.toLowerCase() === 'resolved' ? 'status-resolved' : 'status-assigned';

                row.innerHTML = `
                    <td>${counter}</td>
                    <td>${data.type}</td>
                    <td>${data.ticket}</td>
                    <td>${data.team}</td>
                    <td>${data.support}</td>
                    <td>${data.subject}</td>
                    <td><span class="status-badge ${statusClass}">${data.status}</span></td>
                    <td>${data.sla}</td>
                    <td>${data.fromAssign}</td>
                    <td>${data.fromCreate}</td>
                `;

                tableBody.appendChild(row);

                if (data.status.toLowerCase() === 'resolved') ticketsResolved++;
                if (data.status.toLowerCase() === 'assigned') ticketsAssigned++;

                const currentTime = getCurrentTime();
                timeLabels.push(currentTime);
                resolvedData.push(ticketsResolved);
                assignedData.push(ticketsAssigned);

                const maxDataPoints = 10;
                if (timeLabels.length > maxDataPoints) {
                    timeLabels.shift();
                    resolvedData.shift();
                    assignedData.shift();
                }

                ticketChart.data.labels = timeLabels;
                ticketChart.data.datasets[0].data = resolvedData;
                ticketChart.data.datasets[1].data = assignedData;
                ticketChart.update();

                ticketsData.push(data.ticket);
                noChart.data.labels = timeLabels;
                noChart.data.datasets[0].data.push(ticketsData.length);
                if (noChart.data.datasets[0].data.length > maxDataPoints) {
                    noChart.data.datasets[0].data.shift();
                }
                noChart.update();

                counter++;

                // Reset data jika sudah mencapai 10
                if (counter > 10) {
                    resetTableAndData();
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function resetTableAndData() {
        tableBody.innerHTML = ''; // Mengosongkan tabel
        counter = 1;
        ticketsResolved = 0;
        ticketsAssigned = 0;
        ticketsData = [];
        timeLabels = [];
        resolvedData = [];
        assignedData = [];

        ticketChart.data.labels = timeLabels;
        ticketChart.data.datasets[0].data = resolvedData;
        ticketChart.data.datasets[1].data = assignedData;
        ticketChart.update();

        noChart.data.labels = timeLabels;
        noChart.data.datasets[0].data = [];
        noChart.update();
    }

    setInterval(fetchData, 5000);
    fetchData();
</script>


</body>
</html>
