@extends('admin.admin')

@section('title', 'Dashboard')

@section('content')

<div class="min-h-screen bg-slate-950 text-slate-100 p-6">

    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <div id="stats-cards" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8"></div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
        @if (request()->user()->role === 'superadmin')
            <div class="bg-slate-900 rounded-xl p-6 xl:col-span-2 shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Évolution hebdomadaire</h2>
                <canvas id="weeklyChart"></canvas>
            </div>
        @else
            <div class="bg-slate-900 rounded-xl p-6 xl:col-span-2 shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Vente Total Par Semaine</h2>
                <canvas id="weeklyChart"></canvas>
            </div>
        @endif

        <div class="bg-slate-900 rounded-xl p-6 shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Répartition des biens</h2>
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    <div id="last-sales" class="bg-slate-900 rounded-xl p-6 shadow-lg hidden">
        <h2 class="text-lg font-semibold mb-4">5 Dernières ventes</h2>
        <table class="w-full text-sm">
            <thead class="border-b border-slate-700">
                <tr>
                    <th class="py-3 text-left">Bien</th>
                    <th class="py-3 text-left">Prix</th>
                    <th class="py-3 text-left">Agent</th>
                    <th class="py-3 text-left">Date</th>
                </tr>
            </thead>
            <tbody id="sales-table"></tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
fetch('/dashboard/data', {
    method: 'GET',
    headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
    credentials: 'same-origin'
})
.then(response => {
    console.log('RAW RESPONSE:', response);

    if (!response.ok) {
        throw new Error('HTTP ERROR: ' + response.status);
    }

    return response.text(); // on lit en texte pour debug
})
.then(text => {
    console.log('RAW TEXT:', text);

    if (!text) {
        throw new Error('Empty response');
    }

    const data = JSON.parse(text);
    console.log('PARSED JSON:', data);

    renderDashboard(data['data']);
})
.catch(err => {
    console.error('FETCH ERROR:', err);
});

function renderDashboard(data) {
    console.log(data)
    buildStatsCards(data)

    if (data['pie_properties']){
        console.log(data['pie_properties'])
        buildPie(data['pie_properties'])
    }
    if (data.weekly_chart) buildWeeklyChart(data.weekly_chart)

    if (data.total_sales) buildTotalSalesChart(data.total_sales)

    if (data.last_sales) buildSalesTable(data.last_sales)
}

function buildStatsCards(data) {

    let cards = ''

    if (data.stats?.total_revenue !== undefined) {
        cards += card('Chiffre d\'affaire', data.stats.total_revenue + ' $', 'fa-chart-line')
    }

    if (data.stats?.total_properties !== undefined) {
        cards += card('Biens', data.stats.total_properties, 'fa-building')
    }

    if (data.stats?.total_users !== undefined) {
        cards += card('Utilisateurs', data.stats.total_users, 'fa-users')
    }

    if (data.stats?.revenue !== undefined) {
        cards += card('Revenue', data.stats.revenue + ' $', 'fa-money-bill')
    }

    if (data.stats?.commission !== undefined) {
        cards += card('Commission', data.stats.commission + ' $', 'fa-wallet')
    }


    document.getElementById('stats-cards').innerHTML = cards
}

function card(label, value, icon) {
    return `
    <div class="bg-slate-900 rounded-xl p-6 shadow-lg hover:-translate-y-1 transition-all">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-sm">${label}</p>
                <p class="text-2xl font-bold">${value}</p>
            </div>
            <i class="fas ${icon} text-indigo-500 text-3xl"></i>
        </div>
    </div>`
}

function buildPie(data) {
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Vendus', 'Disponibles'],
            datasets: [{
                data: [data.sold, data.available],
                backgroundColor: ['#4f46e5','#1e293b']

            }]
        }
    })
}

function buildWeeklyChart(data) {
    new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',
        data: {
            labels: data.map(e => e.day),
            datasets: [{
                data: data.map(e => e.total),
                borderColor: '#6366f1',
                backgroundColor: ['#4f46e5']
            }]
        }
    })
}

function buildTotalSalesChart(data) {
    new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',
        data: {
            labels: data.map(e => e.day),
            datasets: [{
                data: data.map(e => e.total),
                borderColor: '#6366f1',
                backgroundColor: ['#4f46e5']
            }]
        }
    })
}

function buildSalesTable(data) {

    document.getElementById('last-sales').classList.remove('hidden')

    let rows = ''

    data.forEach(p => {
        rows += `
        <tr class="border-b border-slate-800 hover:bg-slate-800/40">
            <td class="py-3">${p.title}</td>
            <td>${p.price} $</td>
            <td>${p.user?.name ?? '-'}</td>
            <td>${new Date(p.updated_at).toLocaleDateString()}</td>
        </tr>`
    })

    document.getElementById('sales-table').innerHTML = rows
}
</script>

@endsection