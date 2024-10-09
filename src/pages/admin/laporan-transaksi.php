<body>
    <div class="container">
        <h2 class="mb-4">Laporan Transaksi</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Laporan Pesanan</h5>
                        <div class="form-group">
                            <label for="bulanPesanan">Pilih Bulan:</label>
                            <select class="form-control" id="bulanPesanan">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <button class="btn btn-primary" onclick="exportToPDF('pesanan')">Ekspor PDF</button>
                        <!-- <button class="btn btn-success ml-2" onclick="exportToExcel('pesanan')">Ekspor Excel</button> -->
                    </div>
                </div>
            </div>


        </div>
    </div>


    <script>
        function exportToPDF(type) {
            var selectedMonth;
            if (type === 'pesanan') {
                selectedMonth = document.getElementById('bulanPesanan').value;
            } else if (type === 'pembelian') {
                selectedMonth = document.getElementById('bulanPembelian').value;
            }
            window.location.href = 'src/pages/admin/controller/export-pdf-' + type + '.php?bulan=' + selectedMonth;
        }

        function exportToExcel(type) {
            var selectedMonth;
            if (type === 'pesanan') {
                selectedMonth = document.getElementById('bulanPesanan').value;
            } else if (type === 'pembelian') {
                selectedMonth = document.getElementById('bulanPembelian').value;
            }
            window.location.href = 'src/pages/admin/controller/export-excel-' + type + '.php?bulan=' + selectedMonth;
        }
    </script>


</body>

</html>