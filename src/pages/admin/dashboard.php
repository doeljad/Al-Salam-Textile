<?php
include 'src/config/koneksi.php';

// Query untuk mengambil data pesanan
$sql = "SELECT tanggal_pesanan, total_harga FROM pesanan";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // Output data setiap baris
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Menutup koneksi
$conn->close();

// Mengubah data ke dalam format yang dapat digunakan oleh Chart.js
$labels = array();
$values = array();
foreach ($data as $item) {
    $labels[] = $item['tanggal_pesanan'];
    $values[] = $item['total_harga'];
}

// Menyusun data dalam format JSON
$dataJSON = array(
    'labels' => $labels,
    'values' => $values
);

// Output data dalam format JSON
// echo json_encode($dataJSON);
?>

<div class="tab-content tab-content-basic">
    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">

        <div class="row">
            <div class="col-lg-8 d-flex flex-column">
                <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="card-title card-title-dash">Data Pendapatan</h4>
                                        <h5 class="card-subtitle card-subtitle-dash">Grafik Total Pendapatan</h5>
                                    </div>
                                    <div id="performanceLine-legend"></div>
                                </div>
                                <div class="chartjs-wrapper mt-4">
                                    <canvas id="performanceLine" width="600" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 d-flex flex-column">
                <div class="row flex-grow">
                    <div class="col-md-12 col-lg-12 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body pb-0">
                                <h4 class="card-title card-title-dash text-black">Data Penjualan</h4>
                                <h5 class="card-subtitle card-subtitle-dash">Grafik Total Penjualan</h5>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="chartjs-wrapper mt-4">
                                            <canvas id="data-penjualan" width="600" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <div class="row flex-grow">
                                    <div class="col-lg-12 ">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="card-title card-title-dash">Penjualan Berdasarkan Kategori</h4>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mb-3">
                                            <canvas class="my-auto" id="dataKategori" style="max-width: 60%"></canvas>
                                        </div>
                                        <div id="dataKategori-legend"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>