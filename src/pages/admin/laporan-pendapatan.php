    <div class="container">



        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4">Laporan Pendapatan</h2>
                        <!-- <h5 class="card-title">Laporan Pesanan</h5> -->
                        <div class="form-group">
                            <label for="bulan">Pilih Bulan:</label>
                            <select class="form-control" id="bulan">
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
                        <button class="btn btn-primary" onclick="exportToPDF('pendapatan')">Ekspor PDF</button>
                        <!-- <button class="btn btn-success ml-2" onclick="exportToExcel('pesanan')">Ekspor Excel</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function exportToPDF(type) {
            var selectedMonth = document.getElementById('bulan').value;
            window.location.href = 'src/pages/admin/controller/export-pdf-' + type + '.php?bulan=' + selectedMonth;
        }

        function exportToExcel(type) {
            var selectedMonth = document.getElementById('bulan').value;
            window.location.href = 'src/pages/admin/controller/export-excel-' + type + '.php?bulan=' + selectedMonth;
        }
    </script>