@extends('admin.layout.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <h2 class="mt-5">Thống kê tổng quan</h2>
    <div class="row mb-5">
        <div class="col-md-6">
            <canvas id="overviewPieChart"></canvas>
        </div>
        <div class="col-md-6">
            <p><strong>Tổng Doanh Thu:</strong> {{ number_format($totalRevenue, 0, ',', '.') }} VND</p>
            <p><strong>Tổng Chi Phí:</strong> {{ number_format($totalCost, 0, ',', '.') }} VND</p>
            <p><strong>Lợi Nhuận:</strong> {{ number_format($profit, 0, ',', '.') }} VND</p>
        </div>
    </div>

    <!-- Form lọc doanh thu -->
    <form id="filterForm" class="row g-3 p-4 shadow-sm rounded bg-light mb-5">
        <div class="col-md-4">
            <label for="viewType" class="form-label fw-bold text-primary">Hiển thị theo</label>
            <select name="view_type" id="viewType" class="form-select border-primary" style="padding: 10px; font-size: 1.1em;">
                <option value="" disabled selected>Chọn loại hiển thị</option>
                <option value="year">Năm</option>
                <option value="month">Tháng</option>
                <option value="day">Ngày</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="year" class="form-label fw-bold text-primary">Năm</label>
            <select name="year" id="year" class="form-select border-primary" style="padding: 10px; font-size: 1.1em;" required>
                <option value="" disabled selected>Chọn năm</option>
                @for ($i = date('Y'); $i >= 2000; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-4" id="monthContainer" style="display: none;">
            <label for="month" class="form-label fw-bold text-primary">Tháng</label>
            <select name="month" id="month" class="form-select border-primary" style="padding: 10px; font-size: 1.1em;">
                <option value="" disabled selected>Chọn tháng</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="col-12 d-flex justify-content-center mt-4">
            <button type="button" class="btn btn-primary px-4 py-2 fw-bold" onclick="filterStats()">Xem</button>
        </div>
    </form>

    <!-- Kết quả doanh thu sau khi lọc -->
    <div class="mb-5">
        <canvas id="revenueChart"></canvas>
    </div>

    <!-- Bảng Doanh Thu -->
    <div id="revenueTableContainer" class="mb-5">
        <h4>Bảng Doanh Thu</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Thời Gian</th>
                    <th>Doanh Thu</th>
                </tr>
            </thead>
            <tbody id="revenueTableBody"></tbody>
        </table>
    </div>

    <hr>

    <!-- Top 5 Sản phẩm bán chạy nhất -->
    <h3 class="mt-4">Top 5 Sản Phẩm Bán Chạy Nhất</h3>
    <div class="row">
        <div class="col-md-12">
            <canvas id="topProductsBarChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.getElementById('viewType').addEventListener('change', function() {
        const viewType = this.value;
        document.getElementById('monthContainer').style.display = (viewType === 'day') ? 'block' : 'none';
    });

    function filterStats() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const viewType = formData.get('view_type'); // Kiểm tra giá trị viewType
    console.log("ViewType selected:", viewType);

    fetch('{{ route('admin.filterStats') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log("Data received from server:", data);
        updateRevenueChart(data);
        updateRevenueTable(data, viewType); // Truyền viewType vào
    })
    .catch(error => console.error('Error:', error));
    }

    let revenueChart, overviewPieChart, topProductsBarChart;

    function updateRevenueChart(data) {
        const labels = Object.keys(data);
        const revenues = Object.values(data);

        if (revenueChart) revenueChart.destroy();
        revenueChart = new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh Thu',
                    data: revenues,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });
    }

    function updateRevenueTable(data, viewType) {
    console.log("Inside updateRevenueTable with viewType:", viewType); // Kiểm tra giá trị viewType
    const tableBody = document.getElementById('revenueTableBody');
    tableBody.innerHTML = ''; // Xóa nội dung hiện tại

    const formatter = new Intl.NumberFormat('vi-VN', { style: 'decimal' });

    // Kiểm tra nếu data không rỗng
    if (!data || Object.keys(data).length === 0) {
        tableBody.innerHTML = '<tr><td colspan="2">Không có dữ liệu.</td></tr>';
        return;
    }

    for (const [time, revenue] of Object.entries(data)) {
        let displayTime;

        if (viewType === 'day') {
            displayTime = `Ngày ${time}`;
        } else if (viewType === 'month') {
            displayTime = `Tháng ${time}`;
        } else if (viewType === 'year') {
            displayTime = `Năm ${time}`;
        } else {
            displayTime = time; // Nếu viewType không khớp, hiển thị time nguyên bản
        }

        const row = `<tr>
                        <td>${displayTime}</td>
                        <td>${formatter.format(revenue)} VND</td>
                     </tr>`;
        tableBody.innerHTML += row;
    }
    }



    // Biểu đồ tròn cho thống kê tổng quan
    overviewPieChart = new Chart(document.getElementById('overviewPieChart'), {
        type: 'pie',
        data: {
            labels: ['Tổng Doanh Thu', 'Tổng Chi Phí', 'Lợi Nhuận'],
            datasets: [{
                data: [{{ $totalRevenue }}, {{ $totalCost }}, {{ $profit }}],
                backgroundColor: ['#36A2EB', '#FF6384', '#4BC0C0'],
                hoverOffset: 4
            }]
        }
    });

    // Biểu đồ cột cho top 5 sản phẩm bán chạy nhất
    const topProductLabels = @json($topProducts->pluck('category.name'));
    const topProductData = @json($topProducts->pluck('total_quantity'));

    topProductsBarChart = new Chart(document.getElementById('topProductsBarChart'), {
        type: 'bar',
        data: {
            labels: topProductLabels,
            datasets: [{
                label: 'Số Lượng Bán',
                data: topProductData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });
</script>
@endsection
