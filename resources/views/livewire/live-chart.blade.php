<div>
    <canvas id="salesChart"></canvas>
    
    <script>
        document.addEventListener('livewire:load', function () {
            var ctx = document.getElementById('salesChart').getContext('2d');
            var salesChart = new Chart(ctx, {
                type: 'bar', // Hoặc 'line', 'pie', etc.
                data: @json($chartData),
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            Livewire.on('updateChart', data => {
                salesChart.data = data;
                salesChart.update();
            });
        });
    </script>
</div>
