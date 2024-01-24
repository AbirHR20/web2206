@extends('layouts.admin')
@section('content')
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3>Last week order</h3>
            </div>
            <div class="card-body">
                <div>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3>Last week sells</h3>
            </div>
            <div class="card-body">
                <div>
                    <canvas id="sales_chart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_script')
    <script>
        const sales_chart = document.getElementById('sales_chart');
        var labels2 = {{ Js::from($after_explode_sales_labels) }};
        var data2 = {{ Js::from($after_explode_sales_data) }};

        new Chart(sales_chart, {
            type: 'polarArea',
            data: {
                labels: labels2,
                datasets: [{
                    label: 'total order',
                    data: data2,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        const ctx = document.getElementById('myChart');
        var labels = {{ Js::from($after_explode_orders_labels) }};
        var data = {{ Js::from($after_explode_orders_data) }};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'total order',
                    data: data,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
