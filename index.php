
<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}


include 'koneksi.php';




/* =========================
   GRAFIK SURAT MASUK
========================= */

$data_bulan = [];
$total_bulan = [];

for($i=1; $i<=12; $i++){

    $q = mysqli_query($koneksi,"
        SELECT COUNT(*) as total
        FROM surat_masuk
        WHERE MONTH(tanggal_surat) = $i
    ");

    $d = mysqli_fetch_assoc($q);

    $data_bulan[] = "'".$i."'";
    $total_bulan[] = $d['total'];

}



/* =========================
   GRAFIK DISPOSISI
========================= */

$q2 = mysqli_query($koneksi,"
    SELECT status, COUNT(*) as total
    FROM disposisi
    GROUP BY status
");

$status = [];
$jumlah = [];

while($d2 = mysqli_fetch_assoc($q2)){

    $status[] = "'".$d2['status']."'";
    $jumlah[] = $d2['total'];

}



/* =========================
   TOTAL CARD
========================= */

$qMasuk = mysqli_query($koneksi,"
    SELECT COUNT(*) as total
    FROM surat_masuk
");

$dMasuk = mysqli_fetch_assoc($qMasuk);
$total_masuk = $dMasuk['total'];



$qKeluar = mysqli_query($koneksi,"
    SELECT COUNT(*) as total
    FROM surat_keluar
");

$dKeluar = mysqli_fetch_assoc($qKeluar);
$total_keluar = $dKeluar['total'];



$qDispo = mysqli_query($koneksi,"
    SELECT COUNT(*) as total
    FROM disposisi
");

$dDispo = mysqli_fetch_assoc($qDispo);
$total_disposisi = $dDispo['total'];



/* =========================
   GRAFIK MASUK vs KELUAR
========================= */

$bulan = [];
$grafik_masuk = [];
$grafik_keluar = [];

$bulan_nama = [
    "Jan","Feb","Mar","Apr","Mei","Jun",
    "Jul","Agu","Sep","Okt","Nov","Des"
];

for($i=1; $i<=12; $i++){

    $q1 = mysqli_query($koneksi,"
        SELECT COUNT(*) as total
        FROM surat_masuk
        WHERE MONTH(tanggal_surat) = $i
    ");

    $d1 = mysqli_fetch_assoc($q1);



    $q3 = mysqli_query($koneksi,"
        SELECT COUNT(*) as total
        FROM surat_keluar
        WHERE MONTH(tanggal) = $i
    ");

    $d3 = mysqli_fetch_assoc($q3);



    $bulan[] = "'".$bulan_nama[$i-1]."'";

    $grafik_masuk[] = $d1['total'];
    $grafik_keluar[] = $d3['total'];

}



include 'layout/header.php';
include 'layout/sidebar.php';
?>



<style>

/* =========================
   CONTENT
========================= */

.content{
    margin-left:260px;
    padding:25px;
    min-height:100vh;
}



/* =========================
   CARD
========================= */

.card-container{

    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:25px;

    margin-bottom:30px;

}

.card{

    position:relative;
    overflow:hidden;

    border-radius:24px;

    padding:35px 30px;

    color:white;

    display:flex;
    align-items:center;
    gap:25px;

    box-shadow:0 10px 25px rgba(0,0,0,0.06);

}

.card::before{

    content:'';

    position:absolute;

    width:180px;
    height:180px;

    border-radius:50%;

    background:rgba(255,255,255,0.15);

    right:-60px;
    bottom:-60px;

}

.blue{
    background:linear-gradient(135deg,#3b82f6,#60a5fa);
}

.green{
    background:linear-gradient(135deg,#22c55e,#4ade80);
}

.orange{
    background:linear-gradient(135deg,#f59e0b,#fbbf24);
}


.card-icon{

    width:75px;
    height:75px;

    background:white;

    border-radius:20px;

    display:flex;
    justify-content:center;
    align-items:center;

    font-size:34px;

}

.card-icon.blue-icon{
    color:#2563eb;
}

.card-icon.green-icon{
    color:#22c55e;
}

.card-icon.orange-icon{
    color:#f59e0b;
}

.card-info h4{
    font-size:18px;
    margin-bottom:10px;
    font-weight:600;
}

.card-info h2{
    font-size:52px;
    font-weight:700;
}


/* =========================
   CHART
========================= */

.chart-row{

    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;

    margin-bottom:25px;

}

.chart-card,
.chart-pie{

    background:white;

    border-radius:24px;

    padding:22px;

    box-shadow:0 8px 20px rgba(0,0,0,0.04);

}

.chart-card h3,
.chart-pie h3{

    font-size:20px;
    color:#1e3a8a;

    margin-bottom:20px;

}

.chart-container{
    position:relative;
    height:300px;
}

.chart-pie .chart-container{
    height:320px;
}


/* =========================
   RESPONSIVE
========================= */

@media(max-width:1000px){

    .chart-row{
        grid-template-columns:1fr;
    }

}

@media(max-width:768px){

    .content{
        margin-left:0;
        padding:20px;
    }

}



</style>





<div class="content">


    <!-- =========================
         TOPBAR
    ========================= -->

    <div class="topbar">

        <div class="topbar-left">

            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fa-solid fa-bars"></i>
            </button>

            <h2>Dashboard</h2>

        </div>



        <div class="user-box">

            <div class="user-icon">
                <i class="fa-solid fa-user"></i>
            </div>

            <div>

                <div class="user-name">
                    <?= $_SESSION['nama']; ?>
                </div>

                <div class="role-user">
                    Administrator
                </div>

            </div>

        </div>

    </div>





    <!-- =========================
         CARD
    ========================= -->

    <div class="card-container">


        <!-- SURAT MASUK -->
        <div class="card blue">

            <div class="card-icon blue-icon">
                <i class="fa-solid fa-download"></i>
            </div>

            <div class="card-info">

                <h4>Surat Masuk</h4>

                <h2><?= $total_masuk ?></h2>

            </div>

        </div>




        <!-- DISPOSISI -->
        <div class="card green">

            <div class="card-icon green-icon">
                <i class="fa-solid fa-file-signature"></i>
            </div>

            <div class="card-info">

                <h4>Disposisi</h4>

                <h2><?= $total_disposisi ?></h2>

            </div>

        </div>




        <!-- SURAT KELUAR -->
        <div class="card orange">

            <div class="card-icon orange-icon">
                <i class="fa-solid fa-paper-plane"></i>
            </div>

            <div class="card-info">

                <h4>Surat Keluar</h4>

                <h2><?= $total_keluar ?></h2>

            </div>

        </div>

    </div>





    <!-- =========================
         CHART ROW
    ========================= -->

    <div class="chart-row">


        <!-- CHART MASUK -->
        <div class="chart-card">
            <i class="fa-solid fa-download"></i>
            <h3>Grafik Surat Masuk</h3>

            <div class="chart-container">
                <canvas id="chartMasuk"></canvas>
            </div>

        </div>




        <!-- CHART KELUAR -->
        <div class="chart-card">
            <i class="fa-solid fa-paper-plane"></i>
            <h3> Grafik Surat Keluar</h3>

            <div class="chart-container">
                <canvas id="chartGabungan"></canvas>
            </div>

        </div>

    </div>





    <!-- =========================
         CHART DISPOSISI
    ========================= -->

    <div class="chart-pie">
        <i class="fa-solid fa-file-signature"></i>
        <h3>Grafik Disposisi</h3>

        <div class="chart-container">
            <canvas id="chartDisposisi"></canvas>
        </div>

    </div>

</div>





<?php include 'layout/footer.php'; ?>





<script>

/* =========================
   CHART MASUK
========================= */

var ctx = document.getElementById('chartMasuk').getContext('2d');

new Chart(ctx, {

    type:'bar',

    data:{

        labels:[<?= implode(",", $data_bulan) ?>],

        datasets:[{

            label:'Surat Masuk',

            data:[<?= implode(",", $total_bulan) ?>],

            backgroundColor:'rgba(59,130,246,0.85)',
            borderRadius:10,
            borderSkipped:false

        }]

    },

    options:{

        responsive:true,
        maintainAspectRatio:false,

        plugins:{
            legend:{
                position:'top'
            }
        },

        scales:{
            y:{
                beginAtZero:true,
                ticks:{
                    stepSize:1
                }
            }
        }

    }

});





/* =========================
   CHART GABUNGAN
========================= */

var ctx2 = document.getElementById('chartGabungan').getContext('2d');

new Chart(ctx2, {

    type:'bar',

    data:{

        labels:[<?= implode(",", $bulan) ?>],

        datasets:[

            {

                label:'Surat Masuk',

                data:[<?= implode(",", $grafik_masuk) ?>],

                backgroundColor:'rgba(59,130,246,0.85)',
                borderRadius:10

            },

            {

                label:'Surat Keluar',

                data:[<?= implode(",", $grafik_keluar) ?>],

                backgroundColor:'rgba(74,222,128,0.85)',
                borderRadius:10

            }

        ]

    },

    options:{

        responsive:true,
        maintainAspectRatio:false,

        scales:{
            y:{
                beginAtZero:true,
                ticks:{
                    stepSize:1
                }
            }
        }

    }

});






/* =========================
   CHART DISPOSISI
========================= */

var ctx3 = document.getElementById('chartDisposisi').getContext('2d');

new Chart(ctx3, {

    type:'doughnut',

    data:{

        labels:[<?= implode(",", $status) ?>],

        datasets:[{

            data:[<?= implode(",", $jumlah) ?>],

            backgroundColor:[

                '#3b82f6',
                '#22c55e',
                '#fbbf24',
                '#8b5cf6',
                '#fb7185',
                '#2dd4bf'

            ],

            borderWidth:2

        }]

    },

    options:{

        responsive:true,
        maintainAspectRatio:false,

        plugins:{
            legend:{
                position:'right'
            }
        }

    }

});

</script>