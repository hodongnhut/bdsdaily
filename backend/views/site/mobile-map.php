<?php

/** @var yii\web\View $this */
use yii\bootstrap5\Html;
$this->title = 'Bản Đồ Quy Hoạch TP.HCM';
?> 

<style>
.map-container {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
}

.logo-overlay {
    position: absolute;
    top: 2%;      
    left: 40%;      
    transform: translate(-50%, -50%); 
    z-index: 10;
    width: 129px;
    height: 50px; 
    background-color: white ;
    display: flex;
    justify-content: center; 
    align-items: center;
    border-radius: 8px;
}

.logo-overlay img {
    max-width: 90%; 
    max-height: 90%;
    object-fit: contain; 
}
.maplibregl-ctrl-bottom-right {
    display: none;
}
.Page-ZoningMapVer2-Container .GroupSearch {
    top: 35px;
}
</style>

<div class="map-container">
    <script>
    var RquiCLo = "1",
        jLanguage = "vi",
        _lade = "",
        _lode = "",
        _versions = "2025.0.3.1",
        _IdClient = "tapdoantoancaucom",
        M_http = "https://",
        _Device = "3",
        IsLocal = "",
        ctk="ntc",
        cth="8dfe862724c7c8b2c5e737c45c26ef9f",
        IsDevShow = "",
        IsDevelop = "",
        _decl=false;
</script>
<script type="text/javascript" src="https://kinglandgroup.vn/js/map/script.min.js"></script>
<script type="text/javascript" src="https://kinglandgroup.vn/js/map/rocker.helper.js"></script>
<!-- MapLibre GL JS and Turf.js -->
<script src="https://unpkg.com/maplibre-gl@3.6.2/dist/maplibre-gl.js"></script>
<script src="https://unpkg.com/@turf/turf@6.5.0/turf.min.js"></script>
<!-- Geocoder JS -->
<script src="https://unpkg.com/@maplibre/maplibre-gl-geocoder@1.5.0/dist/maplibre-gl-geocoder.min.js"></script>
<main class="NoPrintProcess MainPage JQQ  VVR QQR5">
   
<script type="text/javascript">
hp_HeadCode([
    "https://kinglandgroup.vn/css/map/maplibre-gl.css",
    "https://kinglandgroup.vn/css/map/ZoningMapVer2.css",
    "https://kinglandgroup.vn/css/map/stylezoning.css",
],"css");
hp_HeadCode([
    "https://kinglandgroup.vn/js/map/maplibre-gl.js",
    "https://kinglandgroup.vn/js/map/turf.js",
    "https://kinglandgroup.vn/js/map/Zone.js"
],"js");
</script>
    <section id="MainPageContainer" data-action="ZoningMapVer2" class="MainPageContainer  Page-ZoningMapVer2 View  ">
        <div class="AreaContent">
            <script type="text/javascript">BodyCollaped()</script>
            <style>
            </style>
            <div class="Page-ZoningMapVer2-Container">
                <div id="sidebar">
                    <div class="header">
                        <h2>Thông tin thửa đất</h2>
                        <div class="GroupButton">
                            <div id="markerButton" class="Thumbtack ButtonTooltip">
                                <i class="fas fa-thumbtack"></i>
                                <span class="tooltip">Ghim vị trí đánh dấu</span>
                            </div>
                            <div class="close jSidebarClose"> <i class="fa fa-times"></i> </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="infoContainer">
                            <p><strong>Số tờ:</strong> <span id="soto"></span></p>
                            <p><strong>Số thửa:</strong> <span id="sothua"></span></p>
                            <p><strong>Địa chỉ:</strong> <span id="diachi"></span></p>
                            <p><strong>Toạ độ:</strong> <span id="lat"></span>, <span id="lng"></span></p>
                        </div>
                        <h3>Quy hoạch sử dụng đất</h3>
                        <ul id="landuse"></ul>
                        <!-- <button id="markerButton" class="button-marker">Đánh dấu vị trí</button> -->
                    </div>
                </div>
                <div class="GroupSearch">
                    <i class="fas fa-caret-down"></i>
                    <div class="FilterText">
                        <span class="FilterText-Default">Khu vực</span>
                        <span class="FilterText-Title"></span>
                        <span class="FilterText-Sub"></span>
                    </div>
                    <div class="FilterItems">
                        <ul>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7773145,106.6999907" data-districtname="Quận 1">
                                Quận 1
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7801495,106.7032527" data-districtname="Quận 1" data-wardname="Phường Bến Nghé">
                                        Phường Bến Nghé
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7737414,106.6941118" data-districtname="Quận 1" data-wardname="Phường Bến Thành">
                                        Phường Bến Thành
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7622107,106.6934252" data-districtname="Quận 1" data-wardname="Phường Cô Giang">
                                        Phường Cô Giang
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7654571,106.6967082" data-districtname="Quận 1" data-wardname="Phường Cầu Ông Lãnh">
                                        Phường Cầu Ông Lãnh
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7581211,106.6890049" data-districtname="Quận 1" data-wardname="Phường Cầu Kho">
                                        Phường Cầu Kho
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7630751,106.6863012" data-districtname="Quận 1" data-wardname="Phường Nguyễn Cư Trinh">
                                        Phường Nguyễn Cư Trinh
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7686402,106.7005920" data-districtname="Quận 1" data-wardname="Phường Nguyễn Thái Bình">
                                        Phường Nguyễn Thái Bình
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7673332,106.6905498" data-districtname="Quận 1" data-wardname="Phường Phạm Ngũ Lão">
                                        Phường Phạm Ngũ Lão
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7925016,106.6907644" data-districtname="Quận 1" data-wardname="Phường Tân Định">
                                        Phường Tân Định
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7888339,106.6987037" data-districtname="Quận 1" data-wardname="Phường Đa Kao">
                                        Phường Đa Kao
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7727320,106.6683666" data-districtname="Quận 10">
                                Quận 10
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7650966,106.6777316" data-districtname="Quận 10" data-wardname="Phường 1">
                                        Phường 1
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7691052,106.6728037" data-districtname="Quận 10" data-wardname="Phường 10">
                                        Phường 10
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7732679,106.6784535" data-districtname="Quận 10" data-wardname="Phường 11">
                                        Phường 11
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7745630,106.6724584" data-districtname="Quận 10" data-wardname="Phường 12">
                                        Phường 12
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7793424,106.6706065" data-districtname="Quận 10" data-wardname="Phường 13">
                                        Phường 13
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7720346,106.6617550" data-districtname="Quận 10" data-wardname="Phường 14">
                                        Phường 14
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7818399,106.6650821" data-districtname="Quận 10" data-wardname="Phường 15">
                                        Phường 15
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7630306,106.6736825" data-districtname="Quận 10" data-wardname="Phường 2">
                                        Phường 2
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7631539,106.6696648" data-districtname="Quận 10" data-wardname="Phường 4">
                                        Phường 4
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7613963,106.6667771" data-districtname="Quận 10" data-wardname="Phường 5">
                                        Phường 5
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7618896,106.6636383" data-districtname="Quận 10" data-wardname="Phường 6">
                                        Phường 6
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7614271,106.6615039" data-districtname="Quận 10" data-wardname="Phường 7">
                                        Phường 7
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7650966,106.6661180" data-districtname="Quận 10" data-wardname="Phường 8">
                                        Phường 8
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7665459,106.6707006" data-districtname="Quận 10" data-wardname="Phường 9">
                                        Phường 9
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7658124,106.6474946" data-districtname="Quận 11">
                                Quận 11
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7566804,106.6391461" data-districtname="Quận 11" data-wardname="Phường 1">
                                        Phường 1
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7621734,106.6434051" data-districtname="Quận 11" data-wardname="Phường 10">
                                        Phường 10
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7660142,106.6504162" data-districtname="Quận 11" data-wardname="Phường 11">
                                        Phường 11
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7612078,106.6529716" data-districtname="Quận 11" data-wardname="Phường 12">
                                        Phường 12
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7641689,106.6535395" data-districtname="Quận 11" data-wardname="Phường 13">
                                        Phường 13
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7691254,106.6487344" data-districtname="Quận 11" data-wardname="Phường 14">
                                        Phường 14
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7739564,106.6552538" data-districtname="Quận 11" data-wardname="Phường 15">
                                        Phường 15
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7555216,106.6486470" data-districtname="Quận 11" data-wardname="Phường 16">
                                        Phường 16
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7567018,106.6439730" data-districtname="Quận 11" data-wardname="Phường 2">
                                        Phường 2
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7607987,106.6389418" data-districtname="Quận 11" data-wardname="Phường 3">
                                        Phường 3
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7579463,106.6551776" data-districtname="Quận 11" data-wardname="Phường 4">
                                        Phường 4
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7705416,106.6439730" data-districtname="Quận 11" data-wardname="Phường 5">
                                        Phường 5
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7599204,106.6550902" data-districtname="Quận 11" data-wardname="Phường 6">
                                        Phường 6
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7606070,106.6597533" data-districtname="Quận 11" data-wardname="Phường 7">
                                        Phường 7
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7611006,106.6487344" data-districtname="Quận 11" data-wardname="Phường 8">
                                        Phường 8
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7616155,106.6455019" data-districtname="Quận 11" data-wardname="Phường 9">
                                        Phường 9
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8616036,106.6609731" data-districtname="Quận 12">
                                Quận 12
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8588271,106.6966734" data-districtname="Quận 12" data-wardname="Phường An Phú Đông">
                                        Phường An Phú Đông
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8810530,106.6388025" data-districtname="Quận 12" data-wardname="Phường Hiệp Thành">
                                        Phường Hiệp Thành
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8678527,106.6231544" data-districtname="Quận 12" data-wardname="Phường Tân Chánh Hiệp">
                                        Phường Tân Chánh Hiệp
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8380911,106.6235253" data-districtname="Quận 12" data-wardname="Phường Tân Hưng Thuận">
                                        Phường Tân Hưng Thuận
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8616587,106.6415600" data-districtname="Quận 12" data-wardname="Phường Tân Thới Hiệp">
                                        Phường Tân Thới Hiệp
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8306721,106.6151355" data-districtname="Quận 12" data-wardname="Phường Tân Thới Nhất">
                                        Phường Tân Thới Nhất
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8731713,106.6860324" data-districtname="Quận 12" data-wardname="Phường Thạnh Lộc">
                                        Phường Thạnh Lộc
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8719549,106.6726095" data-districtname="Quận 12" data-wardname="Phường Thạnh Xuân">
                                        Phường Thạnh Xuân
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8786809,106.6521484" data-districtname="Quận 12" data-wardname="Phường Thới An">
                                        Phường Thới An
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8549056,106.6146723" data-districtname="Quận 12" data-wardname="Phường Trung Mỹ Tây">
                                        Phường Trung Mỹ Tây
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8428486,106.6309776" data-districtname="Quận 12" data-wardname="Phường Đông Hưng Thuận">
                                        Phường Đông Hưng Thuận
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7786390,106.6870156" data-districtname="Quận 3">
                                Quận 3
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7682818,106.6772890" data-districtname="Quận 3" data-wardname="Phường 1">
                                        Phường 1
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7812878,106.6763877" data-districtname="Quận 3" data-wardname="Phường 10">
                                        Phường 10
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7862202,106.6698217" data-districtname="Quận 3" data-wardname="Phường 11">
                                        Phường 11
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7883702,106.6738557" data-districtname="Quận 3" data-wardname="Phường 12">
                                        Phường 12
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7860094,106.6784048" data-districtname="Quận 3" data-wardname="Phường 13">
                                        Phường 13
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7890447,106.6793918" data-districtname="Quận 3" data-wardname="Phường 14">
                                        Phường 14
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7676494,106.6818595" data-districtname="Quận 3" data-wardname="Phường 2">
                                        Phường 2
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7704108,106.6793704" data-districtname="Quận 3" data-wardname="Phường 3">
                                        Phường 3
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7736993,106.6828465" data-districtname="Quận 3" data-wardname="Phường 4">
                                        Phường 4
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7718864,106.6857862" data-districtname="Quận 3" data-wardname="Phường 5">
                                        Phường 5
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7826368,106.6796064" data-districtname="Quận 3" data-wardname="Phường 9">
                                        Phường 9
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7829320,106.6893481" data-districtname="Quận 3" data-wardname="Phường Võ Thị Sáu">
                                        Phường Võ Thị Sáu
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7607328,106.7075519" data-districtname="Quận 4">
                                Quận 4
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7543899,106.6910863" data-districtname="Quận 4" data-wardname="Phường 1">
                                        Phường 1
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7606930,106.7055058" data-districtname="Quận 4" data-wardname="Phường 10">
                                        Phường 10
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7642977,106.7078018" data-districtname="Quận 4" data-wardname="Phường 13">
                                        Phường 13
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7582055,106.7087030" data-districtname="Quận 4" data-wardname="Phường 14">
                                        Phường 14
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7543055,106.7077911" data-districtname="Quận 4" data-wardname="Phường 15">
                                        Phường 15
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7553174,106.7124795" data-districtname="Quận 4" data-wardname="Phường 16">
                                        Phường 16
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7571936,106.7168784" data-districtname="Quận 4" data-wardname="Phường 18">
                                        Phường 18
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7578893,106.6962575" data-districtname="Quận 4" data-wardname="Phường 2">
                                        Phường 2
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7537785,106.6992402" data-districtname="Quận 4" data-wardname="Phường 3">
                                        Phường 3
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7556547,106.7036819" data-districtname="Quận 4" data-wardname="Phường 4">
                                        Phường 4
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7607562,106.7000341" data-districtname="Quận 4" data-wardname="Phường 6">
                                        Phường 6
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7588906,106.7037570" data-districtname="Quận 4" data-wardname="Phường 8">
                                        Phường 8
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7636653,106.7023730" data-districtname="Quận 4" data-wardname="Phường 9">
                                        Phường 9
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7553616,106.6685441" data-districtname="Quận 5">
                                Quận 5
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7535467,106.6816663" data-districtname="Quận 5" data-wardname="Phường 1">
                                        Phường 1
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7508483,106.6632342" data-districtname="Quận 5" data-wardname="Phường 10">
                                        Phường 10
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7536310,106.6626977" data-districtname="Quận 5" data-wardname="Phường 11">
                                        Phường 11
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7561185,106.6581916" data-districtname="Quận 5" data-wardname="Phường 12">
                                        Phường 12
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7491196,106.6566038" data-districtname="Quận 5" data-wardname="Phường 13">
                                        Phường 13
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7523240,106.6550588" data-districtname="Quận 5" data-wardname="Phường 14">
                                        Phường 14
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7527785,106.6718441" data-districtname="Quận 5" data-wardname="Phường 15">
                                        Phường 15
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7566666,106.6804647" data-districtname="Quận 5" data-wardname="Phường 2">
                                        Phường 2
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7589433,106.6798639" data-districtname="Quận 5" data-wardname="Phường 3">
                                        Phường 3
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7616838,106.6792631" data-districtname="Quận 5" data-wardname="Phường 4">
                                        Phường 4
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7514807,106.6749715" data-districtname="Quận 5" data-wardname="Phường 5">
                                        Phường 5
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7511013,106.6699504" data-districtname="Quận 5" data-wardname="Phường 6">
                                        Phường 6
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7539261,106.6717529" data-districtname="Quận 5" data-wardname="Phường 7">
                                        Phường 7
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7559499,106.6714096" data-districtname="Quận 5" data-wardname="Phường 8">
                                        Phường 8
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7586482,106.6709375" data-districtname="Quận 5" data-wardname="Phường 9">
                                        Phường 9
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7458860,106.6392921" data-districtname="Quận 6">
                                Quận 6
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7463369,106.6514969" data-districtname="Quận 6" data-wardname="Phường 1">
                                        Phường 1
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7368923,106.6281938" data-districtname="Quận 6" data-wardname="Phường 10">
                                        Phường 10
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7443553,106.6317558" data-districtname="Quận 6" data-wardname="Phường 11">
                                        Phường 11
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7503002,106.6336441" data-districtname="Quận 6" data-wardname="Phường 12">
                                        Phường 12
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7527456,106.6278076" data-districtname="Quận 6" data-wardname="Phường 13">
                                        Phường 13
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7579736,106.6307258" data-districtname="Quận 6" data-wardname="Phường 14">
                                        Phường 14
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7500051,106.6507244" data-districtname="Quận 6" data-wardname="Phường 2">
                                        Phường 2
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7427952,106.6464328" data-districtname="Quận 6" data-wardname="Phường 3">
                                        Phường 3
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7458310,106.6456174" data-districtname="Quận 6" data-wardname="Phường 4">
                                        Phường 4
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7484450,106.6436004" data-districtname="Quận 6" data-wardname="Phường 5">
                                        Phường 5
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7518602,106.6458749" data-districtname="Quận 6" data-wardname="Phường 6">
                                        Phường 6
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7385367,106.6390943" data-districtname="Quận 6" data-wardname="Phường 7">
                                        Phường 7
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7434277,106.6404247" data-districtname="Quận 6" data-wardname="Phường 8">
                                        Phường 8
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7522736,106.6406229" data-districtname="Quận 6" data-wardname="Phường 9">
                                        Phường 9
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7375481,106.7302238" data-districtname="Quận 7">
                                Quận 7
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7428374,106.7230796" data-districtname="Quận 7" data-wardname="Phường Bình Thuận">
                                        Phường Bình Thuận
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7061532,106.7378425" data-districtname="Quận 7" data-wardname="Phường Phú Mỹ">
                                        Phường Phú Mỹ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7294201,106.7348597" data-districtname="Quận 7" data-wardname="Phường Phú Thuận">
                                        Phường Phú Thuận
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7449034,106.6981887" data-districtname="Quận 7" data-wardname="Phường Tân Hưng">
                                        Phường Tân Hưng
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7491196,106.7104625" data-districtname="Quận 7" data-wardname="Phường Tân Kiểng">
                                        Phường Tân Kiểng
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7270680,106.7261695" data-districtname="Quận 7" data-wardname="Phường Tân Phú">
                                        Phường Tân Phú
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7303569,106.7055701" data-districtname="Quận 7" data-wardname="Phường Tân Phong">
                                        Phường Tân Phong
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7422471,106.7099475" data-districtname="Quận 7" data-wardname="Phường Tân Quy">
                                        Phường Tân Quy
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7508483,106.7217063" data-districtname="Quận 7" data-wardname="Phường Tân Thuận Tây">
                                        Phường Tân Thuận Tây
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7450840,106.7316294" data-districtname="Quận 7" data-wardname="Phường Tân Thuận Đông">
                                        Phường Tân Thuận Đông
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7217236,106.6296151" data-districtname="Quận 8">
                                Quận 8
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7458632,106.6909481" data-districtname="Quận 8" data-wardname="Phường 1">
                                        Phường 1
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7452891,106.6635803" data-districtname="Quận 8" data-wardname="Phường 10">
                                        Phường 10
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7480685,106.6626886" data-districtname="Quận 8" data-wardname="Phường 11">
                                        Phường 11
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7433128,106.6568024" data-districtname="Quận 8" data-wardname="Phường 12">
                                        Phường 12
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7454402,106.6558620" data-districtname="Quận 8" data-wardname="Phường 13">
                                        Phường 13
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7390958,106.6472826" data-districtname="Quận 8" data-wardname="Phường 14">
                                        Phường 14
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7256211,106.6333834" data-districtname="Quận 8" data-wardname="Phường 15">
                                        Phường 15
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7191906,106.6236163" data-districtname="Quận 8" data-wardname="Phường 16">
                                        Phường 16
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7455308,106.6865816" data-districtname="Quận 8" data-wardname="Phường 2">
                                        Phường 2
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7438692,106.6825225" data-districtname="Quận 8" data-wardname="Phường 3">
                                        Phường 3
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7404855,106.6761879" data-districtname="Quận 8" data-wardname="Phường 4">
                                        Phường 4
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7379478,106.6629653" data-districtname="Quận 8" data-wardname="Phường 5">
                                        Phường 5
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7331377,106.6485241" data-districtname="Quận 8" data-wardname="Phường 6">
                                        Phường 6
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7056884,106.6243320" data-districtname="Quận 8" data-wardname="Phường 7">
                                        Phường 7
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7499718,106.6793552" data-districtname="Quận 8" data-wardname="Phường 8">
                                        Phường 8
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7465882,106.6714216" data-districtname="Quận 8" data-wardname="Phường 9">
                                        Phường 9
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7500035,106.5148858" data-districtname="Huyện Bình Chánh">
                                Huyện Bình Chánh
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6832971,106.6058778" data-districtname="Huyện Bình Chánh" data-wardname="Xã An Phú Tây">
                                        Xã An Phú Tây
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6640614,106.5680161" data-districtname="Huyện Bình Chánh" data-wardname="Xã Bình Chánh">
                                        Xã Bình Chánh
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7269776,106.6561600" data-districtname="Huyện Bình Chánh" data-wardname="Xã Bình Hưng">
                                        Xã Bình Hưng
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7519129,106.4805651" data-districtname="Huyện Bình Chánh" data-wardname="Xã Bình Lợi">
                                        Xã Bình Lợi
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6504860,106.6238593" data-districtname="Huyện Bình Chánh" data-wardname="Xã Hưng Long">
                                        Xã Hưng Long
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7863046,106.5189635" data-districtname="Huyện Bình Chánh" data-wardname="Xã Lê Minh Xuân">
                                        Xã Lê Minh Xuân
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7913170,106.5139262" data-districtname="Huyện Bình Chánh" data-wardname="Xã Phạm Văn Hai">
                                        Xã Phạm Văn Hai
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6968222,106.6546923" data-districtname="Huyện Bình Chánh" data-wardname="Xã Phong Phú">
                                        Xã Phong Phú
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6481241,106.6556167" data-districtname="Huyện Bình Chánh" data-wardname="Xã Quy Đức">
                                        Xã Quy Đức
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7078955,106.5980823" data-districtname="Huyện Bình Chánh" data-wardname="Xã Tân Kiên">
                                        Xã Tân Kiên
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7114664,106.5519332" data-districtname="Huyện Bình Chánh" data-wardname="Xã Tân Nhựt">
                                        Xã Tân Nhựt
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6558844,106.5869950" data-districtname="Huyện Bình Chánh" data-wardname="Xã Tân Quý Tây">
                                        Xã Tân Quý Tây
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6901149,106.5826774" data-districtname="Huyện Bình Chánh" data-wardname="Thị trấn Tân Túc">
                                        Thị trấn Tân Túc
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8188059,106.5764808" data-districtname="Huyện Bình Chánh" data-wardname="Xã Vĩnh Lộc A">
                                        Xã Vĩnh Lộc A
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7908153,106.5772533" data-districtname="Huyện Bình Chánh" data-wardname="Xã Vĩnh Lộc B">
                                        Xã Vĩnh Lộc B
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6737662,106.6509389" data-districtname="Huyện Bình Chánh" data-wardname="Xã Đa Phước">
                                        Xã Đa Phước
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7703708,106.5996353" data-districtname="Quận Bình Tân">
                                Quận Bình Tân
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7249151,106.6129429" data-districtname="Quận Bình Tân" data-wardname="Phường An Lạc">
                                        Phường An Lạc
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7487261,106.6224286" data-districtname="Quận Bình Tân" data-wardname="Phường An Lạc A">
                                        Phường An Lạc A
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8077196,106.6034316" data-districtname="Quận Bình Tân" data-wardname="Phường Bình Hưng Hòa">
                                        Phường Bình Hưng Hòa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7840040,106.6078353" data-districtname="Quận Bình Tân" data-wardname="Phường Bình Hưng Hoà A">
                                        Phường Bình Hưng Hoà A
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8019230,106.5913656" data-districtname="Quận Bình Tân" data-wardname="Phường Bình Hưng Hoà B">
                                        Phường Bình Hưng Hoà B
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7663912,106.6167997" data-districtname="Quận Bình Tân" data-wardname="Phường Bình Trị Đông">
                                        Phường Bình Trị Đông
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7693609,106.5956394" data-districtname="Quận Bình Tân" data-wardname="Phường Bình Trị Đông A">
                                        Phường Bình Trị Đông A
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7504813,106.6128383" data-districtname="Quận Bình Tân" data-wardname="Phường Bình Trị Đông B">
                                        Phường Bình Trị Đông B
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7610471,106.5887200" data-districtname="Quận Bình Tân" data-wardname="Phường Tân Tạo">
                                        Phường Tân Tạo
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7547879,106.5843890" data-districtname="Quận Bình Tân" data-wardname="Phường Tân Tạo A">
                                        Phường Tân Tạo A
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8117887,106.7039109" data-districtname="Quận Bình Thạnh">
                                Quận Bình Thạnh
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7980240,106.6977167" data-districtname="Quận Bình Thạnh" data-wardname="Phường 1">
                                        Phường 1
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8161503,106.6939401" data-districtname="Quận Bình Thạnh" data-wardname="Phường 11">
                                        Phường 11
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8124408,106.7002487" data-districtname="Quận Bình Thạnh" data-wardname="Phường 12">
                                        Phường 12
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8266462,106.7047977" data-districtname="Quận Bình Thạnh" data-wardname="Phường 13">
                                        Phường 13
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8051903,106.6973305" data-districtname="Quận Bình Thạnh" data-wardname="Phường 14">
                                        Phường 14
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7986563,106.7044115" data-districtname="Quận Bình Thạnh" data-wardname="Phường 15">
                                        Phường 15
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7961691,106.7069435" data-districtname="Quận Bình Thạnh" data-wardname="Phường 17">
                                        Phường 17
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7907310,106.7100119" data-districtname="Quận Bình Thạnh" data-wardname="Phường 19">
                                        Phường 19
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8005111,106.7017078" data-districtname="Quận Bình Thạnh" data-wardname="Phường 2">
                                        Phường 2
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7969595,106.7122113" data-districtname="Quận Bình Thạnh" data-wardname="Phường 21">
                                        Phường 21
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7927545,106.7191314" data-districtname="Quận Bình Thạnh" data-wardname="Phường 22">
                                        Phường 22
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8056540,106.7053127" data-districtname="Quận Bình Thạnh" data-wardname="Phường 24">
                                        Phường 24
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8050639,106.7173289" data-districtname="Quận Bình Thạnh" data-wardname="Phường 25">
                                        Phường 25
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8125673,106.7107414" data-districtname="Quận Bình Thạnh" data-wardname="Phường 26">
                                        Phường 26
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8164453,106.7204618" data-districtname="Quận Bình Thạnh" data-wardname="Phường 27">
                                        Phường 27
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8217566,106.7302465" data-districtname="Quận Bình Thạnh" data-wardname="Phường 28">
                                        Phường 28
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7984877,106.6941547" data-districtname="Quận Bình Thạnh" data-wardname="Phường 3">
                                        Phường 3
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8116820,106.6876316" data-districtname="Quận Bình Thạnh" data-wardname="Phường 5">
                                        Phường 5
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8067289,106.6883826" data-districtname="Quận Bình Thạnh" data-wardname="Phường 6">
                                        Phường 6
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8068765,106.6925668" data-districtname="Quận Bình Thạnh" data-wardname="Phường 7">
                                        Phường 7
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.5265318,106.8821244" data-districtname="Huyện Cần Giờ">
                                Huyện Cần Giờ
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.5888605,106.7902851" data-districtname="Huyện Cần Giờ" data-wardname="Xã An Thới Đông">
                                        Xã An Thới Đông
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6635602,106.7755651" data-districtname="Huyện Cần Giờ" data-wardname="Xã Bình Khánh">
                                        Xã Bình Khánh
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.4147541,106.9714754" data-districtname="Huyện Cần Giờ" data-wardname="Thị trấn Cần Thạnh">
                                        Thị trấn Cần Thạnh
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.4714385,106.7688703" data-districtname="Huyện Cần Giờ" data-wardname="Xã Lý Nhơn">
                                        Xã Lý Nhơn
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.3795331,106.8798280" data-districtname="Huyện Cần Giờ" data-wardname="Xã Long Hòa">
                                        Xã Long Hòa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.5991293,106.8604273" data-districtname="Huyện Cần Giờ" data-wardname="Xã Tam Thôn Hiệp">
                                        Xã Tam Thôn Hiệp
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.4697294,106.9749498" data-districtname="Huyện Cần Giờ" data-wardname="Xã Thạnh An">
                                        Xã Thạnh An
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="11.0370567,106.5024104" data-districtname="Huyện Củ Chi">
                                Huyện Củ Chi
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="11.0870701,106.5136957" data-districtname="Huyện Củ Chi" data-wardname="Xã An Nhơn Tây">
                                        Xã An Nhơn Tây
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="11.1108006,106.5065074" data-districtname="Huyện Củ Chi" data-wardname="Xã An Phú">
                                        Xã An Phú
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9292146,106.6462612" data-districtname="Huyện Củ Chi" data-wardname="Xã Bình Mỹ">
                                        Xã Bình Mỹ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9744159,106.4948968" data-districtname="Huyện Củ Chi" data-wardname="Thị trấn Củ Chi">
                                        Thị trấn Củ Chi
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9774470,106.6169715" data-districtname="Huyện Củ Chi" data-wardname="Xã Hòa Phú">
                                        Xã Hòa Phú
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="11.0322743,106.4873671" data-districtname="Huyện Củ Chi" data-wardname="Xã Nhuận Đức">
                                        Xã Nhuận Đức
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="11.0240928,106.5648662" data-districtname="Huyện Củ Chi" data-wardname="Xã Phú Hòa Đông">
                                        Xã Phú Hòa Đông
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="11.1310949,106.4788900" data-districtname="Huyện Củ Chi" data-wardname="Xã Phú Mỹ Hưng">
                                        Xã Phú Mỹ Hưng
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="11.0344540,106.5230191" data-districtname="Huyện Củ Chi" data-wardname="Xã Phạm Văn Cội">
                                        Xã Phạm Văn Cội
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9900647,106.4500522" data-districtname="Huyện Củ Chi" data-wardname="Xã Phước Hiệp">
                                        Xã Phước Hiệp
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="11.0062416,106.4258479" data-districtname="Huyện Củ Chi" data-wardname="Xã Phước Thạnh">
                                        Xã Phước Thạnh
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9845103,106.5215662" data-districtname="Huyện Củ Chi" data-wardname="Xã Phước Vĩnh An">
                                        Xã Phước Vĩnh An
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9579007,106.4716310" data-districtname="Huyện Củ Chi" data-wardname="Xã Tân An Hội">
                                        Xã Tân An Hội
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9422865,106.5385228" data-districtname="Huyện Củ Chi" data-wardname="Xã Tân Phú Trung">
                                        Xã Tân Phú Trung
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9638801,106.5069310" data-districtname="Huyện Củ Chi" data-wardname="Xã Tân Thông Hội">
                                        Xã Tân Thông Hội
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9848474,106.5692665" data-districtname="Huyện Củ Chi" data-wardname="Xã Tân Thạnh Tây">
                                        Xã Tân Thạnh Tây
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9569755,106.6011791" data-districtname="Huyện Củ Chi" data-wardname="Xã Tân Thạnh Đông">
                                        Xã Tân Thạnh Đông
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9912655,106.3989828" data-districtname="Huyện Củ Chi" data-wardname="Xã Thái Mỹ">
                                        Xã Thái Mỹ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9955413,106.5919733" data-districtname="Huyện Củ Chi" data-wardname="Xã Trung An">
                                        Xã Trung An
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="11.0086848,106.4716815" data-districtname="Huyện Củ Chi" data-wardname="Xã Trung Lập Hạ">
                                        Xã Trung Lập Hạ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="11.0524922,106.4516400" data-districtname="Huyện Củ Chi" data-wardname="Xã Trung Lập Thượng">
                                        Xã Trung Lập Thượng
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8345635,106.6739598" data-districtname="Quận Gò Vấp">
                                Quận Gò Vấp
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8176678,106.6886186" data-districtname="Quận Gò Vấp" data-wardname="Phường 1">
                                        Phường 1
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8329132,106.6709112" data-districtname="Quận Gò Vấp" data-wardname="Phường 10">
                                        Phường 10
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8391193,106.6614456" data-districtname="Quận Gò Vấp" data-wardname="Phường 11">
                                        Phường 11
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8359424,106.6406902" data-districtname="Quận Gò Vấp" data-wardname="Phường 12">
                                        Phường 12
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8547599,106.6588783" data-districtname="Quận Gò Vấp" data-wardname="Phường 13">
                                        Phường 13
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8476354,106.6417776" data-districtname="Quận Gò Vấp" data-wardname="Phường 14">
                                        Phường 14
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8525115,106.6709227" data-districtname="Quận Gò Vấp" data-wardname="Phường 15">
                                        Phường 15
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8464989,106.6660880" data-districtname="Quận Gò Vấp" data-wardname="Phường 16">
                                        Phường 16
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8408087,106.6751861" data-districtname="Quận Gò Vấp" data-wardname="Phường 17">
                                        Phường 17
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8187905,106.6791511" data-districtname="Quận Gò Vấp" data-wardname="Phường 3">
                                        Phường 3
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8213772,106.6856145" data-districtname="Quận Gò Vấp" data-wardname="Phường 4">
                                        Phường 4
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8275313,106.6935110" data-districtname="Quận Gò Vấp" data-wardname="Phường 5">
                                        Phường 5
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8426122,106.6834563" data-districtname="Quận Gò Vấp" data-wardname="Phường 6">
                                        Phường 6
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8287693,106.6841033" data-districtname="Quận Gò Vấp" data-wardname="Phường 7">
                                        Phường 7
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8403030,106.6504668" data-districtname="Quận Gò Vấp" data-wardname="Phường 8">
                                        Phường 8
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8464568,106.6516255" data-districtname="Quận Gò Vấp" data-wardname="Phường 9">
                                        Phường 9
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8783450,106.5763531" data-districtname="Huyện Hóc Môn">
                                Huyện Hóc Môn
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8460353,106.6036891" data-districtname="Huyện Hóc Môn" data-wardname="Xã Bà Điểm">
                                        Xã Bà Điểm
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8860463,106.5927134" data-districtname="Huyện Hóc Môn" data-wardname="Thị trấn Hóc Môn">
                                        Thị trấn Hóc Môn
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9114429,106.6739844" data-districtname="Huyện Hóc Môn" data-wardname="Xã Nhị Bình">
                                        Xã Nhị Bình
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9035521,106.5919127" data-districtname="Huyện Hóc Môn" data-wardname="Xã Tân Hiệp">
                                        Xã Tân Hiệp
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8933224,106.5788840" data-districtname="Huyện Hóc Môn" data-wardname="Xã Tân Thới Nhì">
                                        Xã Tân Thới Nhì
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8747294,106.6013671" data-districtname="Huyện Hóc Môn" data-wardname="Xã Tân Xuân">
                                        Xã Tân Xuân
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8927081,106.6131300" data-districtname="Huyện Hóc Môn" data-wardname="Xã Thới Tam Thôn">
                                        Xã Thới Tam Thôn
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8659288,106.6093539" data-districtname="Huyện Hóc Môn" data-wardname="Xã Trung Chánh">
                                        Xã Trung Chánh
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8770551,106.5823173" data-districtname="Huyện Hóc Môn" data-wardname="Xã Xuân Thới Sơn">
                                        Xã Xuân Thới Sơn
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8606184,106.5694427" data-districtname="Huyện Hóc Môn" data-wardname="Xã Xuân Thới Thượng">
                                        Xã Xuân Thới Thượng
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8675303,106.5924453" data-districtname="Huyện Hóc Môn" data-wardname="Xã Xuân Thới Đông">
                                        Xã Xuân Thới Đông
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.9033520,106.6387939" data-districtname="Huyện Hóc Môn" data-wardname="Xã Đông Thạnh">
                                        Xã Đông Thạnh
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6509670,106.7263825" data-districtname="Huyện Nhà Bè">
                                Huyện Nhà Bè
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6019797,106.7418765" data-districtname="Huyện Nhà Bè" data-wardname="Xã Hiệp Phước">
                                        Xã Hiệp Phước
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6505492,106.7297100" data-districtname="Huyện Nhà Bè" data-wardname="Xã Long Thới">
                                        Xã Long Thới
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6956953,106.7395591" data-districtname="Huyện Nhà Bè" data-wardname="Thị trấn Nhà Bè">
                                        Thị trấn Nhà Bè
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6729650,106.6990041" data-districtname="Huyện Nhà Bè" data-wardname="Xã Nhơn Đức">
                                        Xã Nhơn Đức
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6790702,106.7509673" data-districtname="Huyện Nhà Bè" data-wardname="Xã Phú Xuân">
                                        Xã Phú Xuân
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6949363,106.7049693" data-districtname="Huyện Nhà Bè" data-wardname="Xã Phước Kiển">
                                        Xã Phước Kiển
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.6994906,106.6847133" data-districtname="Huyện Nhà Bè" data-wardname="Xã Phước Lộc">
                                        Xã Phước Lộc
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8009810,106.6794379" data-districtname="Quận Phú Nhuận">
                                Quận Phú Nhuận
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7986961,106.6826391" data-districtname="Quận Phú Nhuận" data-wardname="Phường 1">
                                        Phường 1
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7953652,106.6711121" data-districtname="Quận Phú Nhuận" data-wardname="Phường 10">
                                        Phường 10
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7925588,106.6761809" data-districtname="Quận Phú Nhuận" data-wardname="Phường 11">
                                        Phường 11
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7909778,106.6693146" data-districtname="Quận Phú Nhuận" data-wardname="Phường 13">
                                        Phường 13
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7962988,106.6796145" data-districtname="Quận Phú Nhuận" data-wardname="Phường 15">
                                        Phường 15
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7936892,106.6825068" data-districtname="Quận Phú Nhuận" data-wardname="Phường 17">
                                        Phường 17
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7982822,106.6859046" data-districtname="Quận Phú Nhuận" data-wardname="Phường 2">
                                        Phường 2
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8023464,106.6814778" data-districtname="Quận Phú Nhuận" data-wardname="Phường 3">
                                        Phường 3
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8073372,106.6793266" data-districtname="Quận Phú Nhuận" data-wardname="Phường 4">
                                        Phường 4
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8058195,106.6837680" data-districtname="Quận Phú Nhuận" data-wardname="Phường 5">
                                        Phường 5
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8008414,106.6885708" data-districtname="Quận Phú Nhuận" data-wardname="Phường 7">
                                        Phường 7
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7980573,106.6746959" data-districtname="Quận Phú Nhuận" data-wardname="Phường 8">
                                        Phường 8
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8030061,106.6778362" data-districtname="Quận Phú Nhuận" data-wardname="Phường 9">
                                        Phường 9
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8025830,106.6521157" data-districtname="Quận Tân Bình">
                                Quận Tân Bình
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7957897,106.6666030" data-districtname="Quận Tân Bình" data-wardname="Phường 1">
                                        Phường 1
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7821309,106.6466903" data-districtname="Quận Tân Bình" data-wardname="Phường 10">
                                        Phường 10
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7890447,106.6480636" data-districtname="Quận Tân Bình" data-wardname="Phường 11">
                                        Phường 11
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7999631,106.6504669" data-districtname="Quận Tân Bình" data-wardname="Phường 12">
                                        Phường 12
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8036306,106.6428279" data-districtname="Quận Tân Bình" data-wardname="Phường 13">
                                        Phường 13
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7937663,106.6419696" data-districtname="Quận Tân Bình" data-wardname="Phường 14">
                                        Phường 14
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8235270,106.6355752" data-districtname="Quận Tân Bình" data-wardname="Phường 15">
                                        Phường 15
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8064128,106.6671180" data-districtname="Quận Tân Bình" data-wardname="Phường 2">
                                        Phường 2
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7933868,106.6628265" data-districtname="Quận Tân Bình" data-wardname="Phường 3">
                                        Phường 3
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8006376,106.6586207" data-districtname="Quận Tân Bình" data-wardname="Phường 4">
                                        Phường 4
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7902251,106.6619253" data-districtname="Quận Tân Bình" data-wardname="Phường 5">
                                        Phường 5
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7841123,106.6589641" data-districtname="Quận Tân Bình" data-wardname="Phường 6">
                                        Phường 6
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7883702,106.6560888" data-districtname="Quận Tân Bình" data-wardname="Phường 7">
                                        Phường 7
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7834378,106.6526985" data-districtname="Quận Tân Bình" data-wardname="Phường 8">
                                        Phường 8
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7747532,106.6511964" data-districtname="Quận Tân Bình" data-wardname="Phường 9">
                                        Phường 9
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7914967,106.6278431" data-districtname="Quận Tân Phú">
                                Quận Tân Phú
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7786319,106.6376351" data-districtname="Quận Tân Phú" data-wardname="Phường Hòa Thạnh">
                                        Phường Hòa Thạnh
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7716335,106.6272497" data-districtname="Quận Tân Phú" data-wardname="Phường Hiệp Tân">
                                        Phường Hiệp Tân
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7799387,106.6271638" data-districtname="Quận Tân Phú" data-wardname="Phường Phú Thạnh">
                                        Phường Phú Thạnh
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7856300,106.6275072" data-districtname="Quận Tân Phú" data-wardname="Phường Phú Thọ Hòa">
                                        Phường Phú Thọ Hòa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7765239,106.6420126" data-districtname="Quận Tân Phú" data-wardname="Phường Phú Trung">
                                        Phường Phú Trung
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8040522,106.6206836" data-districtname="Quận Tân Phú" data-wardname="Phường Sơn Kỳ">
                                        Phường Sơn Kỳ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7941456,106.6222286" data-districtname="Quận Tân Phú" data-wardname="Phường Tân Quý">
                                        Phường Tân Quý
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7992044,106.6320132" data-districtname="Quận Tân Phú" data-wardname="Phường Tân Sơn Nhì">
                                        Phường Tân Sơn Nhì
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7909840,106.6344165" data-districtname="Quận Tân Phú" data-wardname="Phường Tân Thành">
                                        Phường Tân Thành
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7635568,106.6308483" data-districtname="Quận Tân Phú" data-wardname="Phường Tân Thới Hòa">
                                        Phường Tân Thới Hòa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8124830,106.6237735" data-districtname="Quận Tân Phú" data-wardname="Phường Tây Thạnh">
                                        Phường Tây Thạnh
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="filter-item">
                                <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8298295,106.7617899" data-districtname="Thành phố Thủ Đức">
                                Thành phố Thủ Đức
                                <i class="fa fa-chevron-right"></i>
                                </a> 
                                <ul>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7916585,106.7318343" data-districtname="Thành phố Thủ Đức" data-wardname="Phường An Khánh">
                                        Phường An Khánh
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7703265,106.7252683" data-districtname="Thành phố Thủ Đức" data-wardname="Phường An Lợi Đông">
                                        Phường An Lợi Đông
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7950310,106.7443656" data-districtname="Thành phố Thủ Đức" data-wardname="Phường An Phú">
                                        Phường An Phú
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8778137,106.7323493" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Bình Chiểu">
                                        Phường Bình Chiểu
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8456138,106.7663383" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Bình Thọ">
                                        Phường Bình Thọ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7858408,106.7617892" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Bình Trưng Tây">
                                        Phường Bình Trưng Tây
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7862624,106.7747497" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Bình Trưng Đông">
                                        Phường Bình Trưng Đông
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7779152,106.7688274" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Cát Lái">
                                        Phường Cát Lái
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8322102,106.7247962" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Hiệp Bình Chánh">
                                        Phường Hiệp Bình Chánh
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8521046,106.7215346" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Hiệp Bình Phước">
                                        Phường Hiệp Bình Phước
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8458245,106.7770671" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Hiệp Phú">
                                        Phường Hiệp Phú
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8537062,106.7638492" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Linh Chiểu">
                                        Phường Linh Chiểu
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8579210,106.7548370" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Linh Tây">
                                        Phường Linh Tây
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8596068,106.7805003" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Linh Trung">
                                        Phường Linh Trung
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8796680,106.7712306" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Linh Xuân">
                                        Phường Linh Xuân
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8483113,106.7471122" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Linh Đông">
                                        Phường Linh Đông
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8674460,106.8392943" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Long Bình">
                                        Phường Long Bình
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8097011,106.8611809" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Long Phước">
                                        Phường Long Phước
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8424104,106.8256473" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Long Thạnh Mỹ">
                                        Phường Long Thạnh Mỹ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8020288,106.8134593" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Long Trường">
                                        Phường Long Trường
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7909556,106.7993184" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Phú Hữu">
                                        Phường Phú Hữu
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8148436,106.7719173" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Phước Bình">
                                        Phường Phước Bình
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8255924,106.7651796" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Phước Long A">
                                        Phường Phước Long A
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8266462,106.7748355" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Phước Long B">
                                        Phường Phước Long B
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8675336,106.7358533" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Tam Bình">
                                        Phường Tam Bình
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8624340,106.7441358" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Tam Phú">
                                        Phường Tam Phú
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8611937,106.8071466" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Tân Phú">
                                        Phường Tân Phú
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7733621,106.7597722" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Thạnh Mỹ Lợi">
                                        Phường Thạnh Mỹ Lợi
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8074245,106.7329501" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Thảo Điền">
                                        Phường Thảo Điền
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.7762685,106.7144193" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Thủ Thiêm">
                                        Phường Thủ Thiêm
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8261404,106.8158626" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Trường Thạnh">
                                        Phường Trường Thạnh
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8360880,106.7567252" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Trường Thọ">
                                        Phường Trường Thọ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8435063,106.7941474" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Tăng Nhơn Phú A">
                                        Phường Tăng Nhơn Phú A
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jGetLatLng" href="javascript:void(0);" data-latlng="10.8356665,106.7806720" data-districtname="Thành phố Thủ Đức" data-wardname="Phường Tăng Nhơn Phú B">
                                        Phường Tăng Nhơn Phú B
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="GroupButton">
                        <div class="ButtonZone Search jSearch">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="ButtonZone ButtonTooltip Marker">
                            <i class="fa fa-map-marker-alt"></i>
                            <span class="tooltip">Đến vị trí đánh dấu</span>
                        </div>
                        <div class="ButtonZone ButtonTooltip Location">
                            <i class="fa fa-location"></i>
                            <span class="tooltip">Vị trí của bạn</span>
                        </div>
                    </div>
                    <div class="FrmItems    jFrmInput SearchBox jGetSearchBox Type-Text Items-q fHasLeftIcon  fNoLabel " data-required="0" data-required-type="" data-lang="" data-type="Text">
                        <div class="FrmLabel jFrmLabel" data-label="Toạ độ"></div>
                        <input placeholder="Toạ độ" type="text" class="FrmInput jEle  " name="q" value="">
                        <div class="fIconLeft"><i class="fa fa-search"></i></div>
                    </div>
                </div>
                <div class="GroupButtonZoom">
                    <div class="ButtonZone Zoom jZoomIn">
                        <i class="fa fa-plus"></i>
                    </div>
                    <div class="ButtonZone Zoom jZoomOut">
                        <i class="fa fa-minus"></i>
                    </div>
                </div>
                <div id="map" class="maplibregl-map">
                   
                </div>
            </div>
            <script>
                /* document.addEventListener('DOMContentLoaded', () => {*/
                $(document).ready(() => {
                    var Device = 3;
                    const layer1 = [{
                        filter: ["==", "class", "senior"],
                        id: "lo_gioi_senior",
                        type: "line",
                        minzoom: 12,
                        maxzoom: 16,
                        source: "main",
                        "source-layer": "logioi",
                        paint: {
                            "line-color": "green",
                            "line-width": {
                                base: 1,
                                stops: [
                                    [17, 1],
                                    [22, 2]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "class", "junior"],
                        id: "lo_gioi_junior",
                        type: "line",
                        minzoom: 12,
                        source: "main",
                        "source-layer": "logioi",
                        paint: {
                            "line-color": "blue",
                            "line-width": {
                                base: .2,
                                stops: [
                                    [17, .2],
                                    [22, .8]
                                ]
                            }
                        }
                    }, {
                        id: "long-duong-qh",
                        type: "line",
                        source: "main",
                        "source-layer": "longduong",
                        minzoom: 10,
                        maxzoom: 15,
                        paint: {
                            "line-color": "#f58742",
                            "line-width": 1
                        }
                    }, {
                        filter: ["==", "landuse", "honhop"],
                        type: "fill",
                        id: "h-honhop",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "#ffb908",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "public"],
                        type: "fill",
                        id: "h-public",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "red",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "military"],
                        type: "fill",
                        id: "h-military",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "blue",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "medic"],
                        type: "fill",
                        id: "h-medic",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "pink",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "podium"],
                        type: "fill",
                        id: "h-podium",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "gray",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "commer"],
                        type: "fill",
                        id: "h-commer",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "#ec42f5",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [17, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "hotel"],
                        type: "fill",
                        id: "h-hotel",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "#ec42f5",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [17, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "nghiatrang"],
                        type: "fill",
                        id: "h-nghiatrang",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "#000",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "tongiao"],
                        type: "fill",
                        id: "h-tongiao",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "black",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "coquan"],
                        type: "fill",
                        id: "h-coquan",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "red",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "culture"],
                        type: "fill",
                        id: "h-culture",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "yellow",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "edu"],
                        type: "fill",
                        id: "h-edu",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "cyan",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "metro"],
                        type: "fill",
                        id: "h-metro",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "#424ef5",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "parkinglot"],
                        type: "fill",
                        id: "h-parkinglot",
                        source: "main",
                        "source-layer": "landuse",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "gray",
                            "fill-opacity": {
                                base: 1,
                                stops: [
                                    [10, 1],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        filter: ["==", "landuse", "green"],
                        id: "h-grass",
                        minzoom: 10,
                        maxzoom: 17,
                        paint: {
                            "fill-color": "green",
                            "fill-opacity": .45
                        },
                        source: "main",
                        "source-layer": "landuse",
                        type: "fill"
                    }, {
                        id: "thua-dat",
                        type: "fill",
                        source: "extra",
                        "source-layer": "parcels",
                        minzoom: 17,
                        paint: {
                            "fill-color": ["case", ["boolean", ["feature-state", "hover"], !1], "green", "#d6d6d6"],
                            "fill-opacity": {
                                base: .8,
                                stops: [
                                    [18, 0],
                                    [20, 0]
                                ]
                            }
                        }
                    }, {
                        id: "subparcels-outline",
                        type: "line",
                        minzoom: 17,
                        "source-layer": "subparcels",
                        paint: {
                            "line-color": "black",
                            "line-width": {
                                base: .5,
                                stops: [
                                    [17, .5],
                                    [20, 1]
                                ]
                            }
                        },
                        source: "extra"
                    }, {
                        id: "subparcels",
                        minzoom: 17,
                        type: "fill",
                        "source-layer": "subparcels",
                        paint: {
                            "fill-color": ["match", ["get", "rgbcolor"], "165,124,0", "rgb(255,236,158)", "127,63,0", "rgb(255,255,255)", ["concat", "rgb(", ["get", "rgbcolor"], ")"]],
                            "fill-opacity": .25
                        },
                        source: "extra"
                    }, {
                        id: "contructions",
                        type: "line",
                        minzoom: 19,
                        source: "main",
                        "source-layer": "constructions",
                        paint: {
                            "line-color": "magenta",
                            "line-opacity": .3,
                            "line-width": {
                                base: .5,
                                stops: [
                                    [17, .5],
                                    [20, 1]
                                ]
                            }
                        }
                    }, {
                        id: "diachi",
                        type: "symbol",
                        source: "main",
                        "source-layer": "addresses",
                        "text-field": ["get", "housenumber"],
                        minzoom: 17,
                        layout: {
                            "text-font": ["Noto Sans Regular"],
                            "text-size": 11,
                            "text-field": ["get", "housenumber"],
                            "symbol-placement": "point",
                            "text-anchor": "bottom",
                            "text-justify": "center",
                            "text-max-width": 7,
                            "text-line-height": 1.1,
                            "text-padding": 5
                        },
                        paint: {
                            "text-color": "blue"
                        }
                    }, {
                        id: "text-ranhqh",
                        type: "symbol",
                        source: "main",
                        "source-layer": "logioi",
                        "text-field": ["get", "name"],
                        minzoom: 20,
                        layout: {
                            "text-font": ["Noto Sans Regular"],
                            "text-size": 11,
                            "text-field": "ranh quy hoạch",
                            "symbol-placement": "line",
                            "text-anchor": "bottom",
                            "text-justify": "center",
                            "text-max-width": 7,
                            "text-line-height": 1.1,
                            "text-padding": 5
                        },
                        paint: {
                            "text-color": "green"
                        }
                    }, {
                        id: "text-longduong",
                        type: "symbol",
                        source: "main",
                        "source-layer": "longduong",
                        "text-field": ["get", "name"],
                        minzoom: 20,
                        layout: {
                            "text-font": ["Noto Sans Regular"],
                            "text-size": 11,
                            "text-field": "l\xf2ng đường quy hoạch",
                            "symbol-placement": "line",
                            "text-anchor": "bottom",
                            "text-justify": "center",
                            "text-max-width": 7,
                            "text-line-height": 1.1,
                            "text-padding": 5
                        },
                        paint: {
                            "text-color": "#f58742"
                        }
                    }];
                    const layer2 = [{
                            filter: ["==", "class", "grass"],
                            id: "landcover_grass",
                            minzoom: 10,
                            maxzoom: 14,
                            paint: {
                                "fill-color": "green",
                                "fill-opacity": .45
                            },
                            source: "openmaptiles",
                            "source-layer": "landcover",
                            type: "fill"
                        }, {
                            filter: ["all", ["==", "$type", "LineString"],
                                ["in", "class", "trunk", "primary"]
                            ],
                            minzoom: 10,
                            id: "road_trunk_primary",
                            maxzoom: 15,
                            layout: {
                                "line-cap": "round",
                                "line-join": "round"
                            },
                            paint: {
                                "line-color": "#f58742",
                                "line-opacity": .8,
                                "line-width": {
                                    base: 1.4,
                                    stops: [
                                        [6, .5],
                                        [20, 20]
                                    ]
                                }
                            },
                            source: "openmaptiles",
                            "source-layer": "transportation",
                            type: "line"
                        }, {
                            filter: ["all", ["==", "$type", "LineString"],
                                ["in", "class", "secondary", "tertiary", "primary", "trunk", "motorway", "path", "track", "raceway"]
                            ],
                            minzoom: 13,
                            maxzoom: 15,
                            id: "road_secondary_tertiary",
                            layout: {
                                "line-cap": "round",
                                "line-join": "round"
                            },
                            paint: {
                                "line-color": "gray",
                                "line-opacity": 1,
                                "line-width": {
                                    base: 1,
                                    stops: [
                                        [6, .5],
                                        [20, .5]
                                    ]
                                }
                            },
                            source: "openmaptiles",
                            "source-layer": "transportation",
                            type: "line"
                        }, {
                            minzoom: 10,
                            id: "road-osm-name",
                            type: "symbol",
                            source: "openmaptiles",
                            "source-layer": "transportation_name",
                            "text-field": ["get", "name"],
                            layout: {
                                "symbol-placement": "line",
                                "text-field": "{name}",
                                "text-font": ["Noto Sans Regular"],
                                "text-letter-spacing": .1,
                                "text-rotation-alignment": "map",
                                "text-size": {
                                    base: 1.5,
                                    stops: [
                                        [10, 8],
                                        [22, 30]
                                    ]
                                },
                                "text-transform": "uppercase"
                            },
                            "text-padding": 1,
                            paint: {
                                "text-color": "green"
                            }
                        }, {
                            filter: ["all", ["==", "$type", "Polygon"],
                                ["!=", "intermittent", 1]
                            ],
                            minzoom: 10,
                            id: "water",
                            paint: {
                                "fill-color": "hsl(205, 56%, 73%)"
                            },
                            source: "openmaptiles",
                            "source-layer": "water",
                            type: "fill"
                        }, {
                            filter: ["all", ["==", "$type", "Polygon"],
                                ["==", "intermittent", 1]
                            ],
                            id: "water_intermittent",
                            paint: {
                                "fill-color": "hsl(205, 56%, 73%)",
                                "fill-opacity": .7
                            },
                            source: "openmaptiles",
                            "source-layer": "water",
                            type: "fill"
                        }, {
                            filter: ["in", "admin_level", 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                            id: "admin_sub",
                            paint: {
                                "line-color": "red",
                                "line-width": 2,
                                "line-dasharray": [2, 1]
                            },
                            source: "openmaptiles",
                            "source-layer": "boundary",
                            type: "line"
                        }, {
                            filter: ["all", ["<=", "admin_level", 2],
                                ["==", "$type", "LineString"]
                            ],
                            id: "admin_country",
                            layout: {
                                "line-cap": "round",
                                "line-join": "round"
                            },
                            paint: {
                                "line-color": "hsl(0, 0%, 60%)",
                                "line-width": {
                                    base: 1.3,
                                    stops: [
                                        [3, .5],
                                        [22, 15]
                                    ]
                                }
                            },
                            source: "openmaptiles",
                            "source-layer": "boundary",
                            type: "line"
                        }, {
                            filter: ["all", ["==", "$type", "Polygon"],
                                ["in", "brunnel", "bridge"]
                            ],
                            id: "road_bridge_area",
                            layout: {},
                            paint: {
                                "fill-color": "hsl(47, 26%, 88%)",
                                "fill-opacity": .5
                            },
                            source: "openmaptiles",
                            "source-layer": "transportation",
                            type: "fill"
                        }, {
                            filter: ["all", ["==", "$type", "LineString"],
                                ["in", "class", "path", "track"]
                            ],
                            id: "road_path",
                            layout: {
                                "line-cap": "square",
                                "line-join": "bevel"
                            },
                            paint: {
                                "line-color": "hsl(0, 0%, 97%)",
                                "line-dasharray": [1, 1],
                                "line-width": {
                                    base: 1.55,
                                    stops: [
                                        [4, .25],
                                        [20, 10]
                                    ]
                                }
                            },
                            source: "openmaptiles",
                            "source-layer": "transportation",
                            type: "line"
                        }, {
                            filter: ["all", ["==", "$type", "LineString"],
                                ["in", "class", "minor", "service"]
                            ],
                            id: "road_minor",
                            layout: {
                                "line-cap": "round",
                                "line-join": "round"
                            },
                            paint: {
                                "line-color": "black",
                                "line-width": .1
                            },
                            source: "openmaptiles",
                            "source-layer": "transportation",
                            type: "line",
                            minzoom: 13,
                            maxzoom: 15
                        }, {
                            filter: ["all", ["==", "$type", "Point"],
                                ["==", "rank", 1]
                            ],
                            id: "poi_label",
                            layout: {
                                "icon-size": 1,
                                "text-anchor": "top",
                                "text-field": "{name}",
                                "text-font": ["Noto Sans Regular"],
                                "text-max-width": 8,
                                "text-offset": [0, .5],
                                "text-size": 11
                            },
                            minzoom: 14,
                            paint: {
                                "text-color": "#666",
                                "text-halo-blur": 1,
                                "text-halo-color": "rgba(255,255,255,0.75)",
                                "text-halo-width": 1
                            },
                            source: "openmaptiles",
                            "source-layer": "poi",
                            type: "symbol"
                        },
                        {
                            id: "place_label_other",
                            minzoom: 10,
                            filter: ["all", ["==", "$type", "Point"],
                                ["!in", "class", "district", "city"]
                            ],
                            layout: {
                                "text-font": ["Noto Sans Regular"],
                                "text-anchor": "center",
                                "text-field": "{name}",
                                "text-max-width": 6,
                                "text-size": {
                                    stops: [
                                        [10, 12],
                                        [14, 17]
                                    ]
                                }
                            },
                            paint: {
                                "text-color": "blue",
                                "text-halo-blur": 0,
                                "text-halo-color": "hsl(0, 0%, 100%)",
                                "text-halo-width": 2
                            },
                            source: "openmaptiles",
                            "source-layer": "place",
                            type: "symbol"
                        },
                        {
                            /* filter: ["all", ["has", "iata"]],
                                id: "airport-label",
                                layout: {
                                    "icon-size": 1,
                                    "text-anchor": "top",
                                    "text-field": "{name}",
                                    "text-font": ["Noto Sans Regular"],
                                    "text-max-width": 8,
                                    "text-offset": [0, .5],
                                    "text-size": 11
                                },
                                minzoom: 10,
                                paint: {
                                    "text-color": "#666",
                                    "text-halo-blur": 1,
                                    "text-halo-color": "rgba(255,255,255,0.75)",
                                    "text-halo-width": 1
                                },
                                source: "openmaptiles",
                                "source-layer": "aerodrome_label",
                                type: "symbol"
                            }, {*/
                            filter: ["all", ["==", "$type", "Point"],
                                ["==", "class", "city"]
                            ],
                            id: "place_label_city",
                            layout: {
                                "text-field": "{name}",
                                "text-font": ["Noto Sans Regular"],
                                "text-max-width": 10,
                                "text-size": {
                                    stops: [
                                        [3, 12],
                                        [8, 16]
                                    ]
                                }
                            },
                            maxzoom: 16,
                            paint: {
                                "text-color": "hsl(0, 0%, 0%)",
                                "text-halo-blur": 0,
                                "text-halo-color": "hsla(0, 0%, 100%, 0.75)",
                                "text-halo-width": 2
                            },
                            source: "openmaptiles",
                            "source-layer": "place",
                            type: "symbol"
                        }
                    ];
                
                    layer3 = [{
                            id: "hoverLayer",
                            type: "fill",
                            source: "hoverSource",
                            paint: {
                                "fill-color": "blue",
                                "fill-opacity": 0.1,
                            }
                        },
                        {
                            id: "hoverLayerOutline",
                            type: "line",
                            source: "hoverSource",
                            paint: {
                                "line-color": "black",
                                "line-width": 2
                            }
                        },
                        {
                            id: "clickLayer",
                            type: "fill",
                            source: "clickSource",
                            paint: {
                                "fill-color": "blue",
                                "fill-opacity": 0.02,
                            }
                        },
                        {
                            id: "clickLayerOutline",
                            type: "line",
                            source: "clickSource",
                            paint: {
                                "line-color": "blue",
                                "line-width": 1.5
                            }
                        },
                        {
                            id: 'lenghtFeature',
                            type: 'symbol',
                            source: 'infoLengthFeatures',
                            layout: {
                                "text-font": ["Noto Sans Regular"],
                                'text-field': ['get', 'length'],
                                'text-size': 11,
                                'text-offset': [0, 0],
                                'text-rotation-alignment': 'viewport',
                                'text-rotate': ['get', 'angle'],
                                'text-justify': 'auto',
                                'text-anchor': 'center',
                
                            },
                            paint: {
                                'text-color': '#000',
                                'text-halo-color': '#fff',
                                'text-halo-width': 14,
                            }
                        },
                        {
                            id: 'areaFeature',
                            type: 'symbol',
                            source: 'infoAreaFeatures',
                            layout: {
                                "text-font": ["Noto Sans Regular"],
                                'text-field': ['concat', ['get', 'dientich'], ' m²'],
                                'text-size': 11,
                                'text-offset': [0, 0], // Điều chỉnh vị trí hiển thị text
                                'text-rotation-alignment': 'viewport',
                                'text-rotate': 0,
                                'text-justify': 'auto',
                                'text-anchor': 'center',
                            },
                            paint: {
                                'text-color': '#000',
                
                            }
                        },
                        {
                            id: 'pointsLocation',
                            type: 'symbol',
                            minzoom: 15,
                            source: 'pointLocation',
                            layout: {
                                'icon-image': 'pulsing-dot'
                            }
                        },
                    ];
                    const setCookie = (name, value, months = 12) => {
                        const expires = new Date();
                        expires.setTime(expires.getTime() + (months * 30 * 24 * 60 * 60 * 1000));
                        document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
                    };
                    const getCookie = (name) => {
                        const nameEQ = name + "=";
                        const ca = document.cookie.split(';');
                        for (let i = 0; i < ca.length; i++) {
                            let c = ca[i];
                            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
                        }
                        return null;
                    };
                
                    const getParcels = (map, gid) => {
                        return map.querySourceFeatures('extra', {
                            sourceLayer: 'parcels',
                            filter: ['in', '$id', gid]
                        });
                    };
                
                    const getFillColor = (paint) => {
                        return `rgba(${paint['fill-color'].r * 255}, ${paint['fill-color'].g * 255}, ${paint['fill-color'].b * 255}, ${paint['fill-color'].a})`;
                    };
                
                    const updateMapPaintProperty = (map, layer, property, value) => {
                        map.setPaintProperty(layer, property, value);
                    };
                
                    const getFeaturesAll = (map, gid) => {
                        const features = map.queryRenderedFeatures('extra', {
                            layers: ['subparcels'],
                            filter: ['==', ['get', 'gid'], gid]
                        });
                
                        const uniqueFeatures = features.reduce((acc, feature) => {
                            if (!acc.find(f => f.id === feature.id)) {
                                acc.push(feature);
                            }
                            return acc;
                        }, []);
                
                        return uniqueFeatures;
                    };
                
                    const getLengtFeatures = (featuresAll) => {
                        const lengtFeatures = [];
                
                        featuresAll.forEach((feature) => {
                            const coordinates = feature.geometry.coordinates[0];
                
                            for (let i = 0; i < coordinates.length - 1; i++) {
                                const p1 = turf.point(coordinates[i]);
                                const p2 = turf.point(coordinates[i + 1]);
                                const length = turf.distance(p1, p2, {
                                    units: 'meters'
                                });
                                const midPoint = turf.midpoint(p1, p2).geometry.coordinates;
                                const bearing = turf.bearing(p1, p2);
                                let angle = bearing - 90;
                                if (angle < -90 || angle > 90) angle -= 180;
                                lengtFeatures.push({
                                    type: "Feature",
                                    geometry: {
                                        type: "Point",
                                        coordinates: midPoint
                                    },
                                    properties: {
                                        length: length.toFixed(2),
                                        angle: angle,
                                    }
                                });
                            }
                        });
                
                        return lengtFeatures;
                    };
                
                    const getAreaFeature = (featuresAll) => {
                        const areaFeatures = [];
                        featuresAll.forEach((feature) => {
                            const centroid = turf.centerOfMass(feature).geometry;
                            areaFeatures.push({
                                type: "Feature",
                                geometry: centroid,
                                properties: {
                                    dientich: feature.properties.dientich.toFixed(2),
                                }
                            });
                        });
                
                        return areaFeatures;
                    };
                
                
                    const updateSourceData = (map, source, data) => {
                        map.getSource(source).setData({
                            type: "FeatureCollection",
                            features: data
                        });
                    };
                
                    const getDiaChi = (parcel, addressFeatures = []) => {
                        const housenumber = addressFeatures.length > 0 && addressFeatures[0].properties.housenumber ? addressFeatures[0].properties.housenumber + ', ' : '';
                        const sonha = parcel.properties.sonha && parcel.properties.sonha !== 'None' ? parcel.properties.sonha + ', ' : '';
                        const tenduong = parcel.properties.tenduong && parcel.properties.tenduong !== 'None' ? parcel.properties.tenduong + ', ' : '';
                        const tenphuongxa = parcel.properties.tenphuongxa && parcel.properties.tenphuongxa !== 'None' ? parcel.properties.tenphuongxa + ', ' : '';
                        const tenquanhuyen = parcel.properties.tenquanhuyen !== 'None' ? parcel.properties.tenquanhuyen : '';
                
                        return `${housenumber || sonha}${tenduong}${tenphuongxa}${tenquanhuyen}`;
                    };
                
                
                    const updateSidebar = (parcel, featuresAll, diachi, e) => {
                        document.getElementById('soto').textContent = parcel.properties.soto || '';
                        document.getElementById('sothua').textContent = parcel.properties.sothua || '';
                        document.getElementById('diachi').textContent = diachi || '';
                        const latElement = document.getElementById('lat');
                        const lngElement = document.getElementById('lng');
                        if (e.lngLat && typeof e.lngLat.lat === 'number' && typeof e.lngLat.lng === 'number') {
                            latElement.textContent = e.lngLat.lat.toFixed(6);
                            lngElement.textContent = e.lngLat.lng.toFixed(6);
                        } else {
                            latElement.textContent = '';
                            lngElement.textContent = '';
                        }
                
                        const landuseList = document.getElementById('landuse');
                        landuseList.innerHTML = '';
                
                        featuresAll.forEach(feature => {
                            const li = document.createElement('li');
                            li.innerHTML = `<span class="icon" style="background-color: rgb(${feature.properties.rgbcolor || "0, 0, 0"});"></span> ${feature.properties.chucnangsdd || 'Thông tin không có sẵn'} (${feature.properties.dientich.toFixed(2)} m²)`;
                            landuseList.appendChild(li);
                        });
                
                        const sidebar = document.getElementById('sidebar');
                        if (!sidebar.classList.contains('active')) {
                            sidebar.classList.add('active');
                        }
                    };
                
                    const generatePopupHTML = (feature, parcel, diachi) => {
                        return `
                            <div class="popup-content">
                                <span class="popup-icon" style="background-color: rgb(${feature.properties.rgbcolor || "0, 0, 0"});"></span>
                                <strong>${feature.properties.chucnangsdd || "Thông tin không có sẵn"}</strong>
                            </div>
                            <div class="popup-details">
                                <p><strong>Số tờ:</strong> ${parcel.properties.soto || "Không có sẵn"}, <strong>Số thửa:</strong> ${parcel.properties.sothua || "Không có sẵn"}</p>
                                <p><strong>Địa chỉ:</strong> ${diachi || "Không có sẵn"}</p>
                            </div>
                        `;
                    };
                
                    const handleMapMouseMove = (map, popup, e) => {
                        const features = map.queryRenderedFeatures(e.point, {
                            layers: ['subparcels']
                        });
                
                        if (!features.length) {
                            updateSourceData(map, 'hoverSource', []);
                            popup.remove();
                            return;
                        }
                
                        const feature = features[0];
                        const gid = feature.properties.gid;
                        const parcels = getParcels(map, gid);
                
                        if (!parcels.length) return;
                
                        updateMapPaintProperty(map, 'hoverLayer', 'fill-color', `rgb(${feature.properties.rgbcolor})`);
                        updateMapPaintProperty(map, 'hoverLayer', 'fill-opacity', feature.layer.paint['fill-opacity'] * 0.4);
                        updateSourceData(map, 'hoverSource', parcels);
                
                        const addressFeatures = map.queryRenderedFeatures(e.point, {
                            layers: ['diachi']
                        });
                        const diachi = getDiaChi(parcels[0], addressFeatures);
                
                        popup.setLngLat(e.lngLat)
                            .setHTML(generatePopupHTML(feature, parcels[0], diachi))
                            .addTo(map);
                    };
                
                
                    const handleMapClick = (map, e) => {
                        const features = map.queryRenderedFeatures(e.point, {
                            layers: ['subparcels']
                        });
                
                        if (!features.length) {
                            updateSourceData(map, 'clickSource', []);
                            updateSourceData(map, 'infoLengthFeatures', []);
                            updateSourceData(map, 'infoAreaFeatures', []);
                            document.getElementById('sidebar').classList.remove('active');
                            return;
                        }
                
                        const feature = features[0];
                        const gid = feature.properties.gid;
                        const parcels = getParcels(map, gid);
                        if (!parcels.length) return;
                        const parcel = parcels[0];
                        updateMapPaintProperty(map, 'clickLayer', 'fill-color', `rgb(${feature.properties.rgbcolor})`);
                
                        const featuresAll = getFeaturesAll(map, gid);
                        const areaFeatures = getAreaFeature(featuresAll);
                        const lengtFeatures = getLengtFeatures(featuresAll);
                
                        updateSourceData(map, 'clickSource', parcels);
                        updateSourceData(map, 'infoLengthFeatures', lengtFeatures);
                        updateSourceData(map, 'infoAreaFeatures', areaFeatures);
                        const addressFeatures = map.queryRenderedFeatures(e.point, {
                            layers: ['diachi']
                        });
                        const diachi = getDiaChi(parcel, addressFeatures);
                        updateSidebar(parcel, featuresAll, diachi, e);
                        return true;
                    };
                
                
                    const initializeMap = () => {
                        const baseUrlMap = "https://files.rockervietnam.com/ZoningMapVer2";
                
                        const mapStyle = {
                            version: 8,
                            name: "HCM city parcel land",
                            glyphs: "https://maps.ankapong.com/fonts/{fontstack}/{range}.pbf",
                            sources: {
                                openmaptiles: {
                                    type: "vector",
                                    url: baseUrlMap + "/data/v3.json"
                                },
                                main: {
                                    type: "vector",
                                    url: baseUrlMap + "/data/main.json",
                                    promoteId: "id"
                                },
                                extra: {
                                    type: "vector",
                                    url: baseUrlMap + "/data/extra.json"
                                },
                                clickSource: {
                                    type: "geojson",
                                    data: {
                                        type: "FeatureCollection",
                                        features: []
                                    }
                                },
                                hoverSource: {
                                    type: "geojson",
                                    data: {
                                        type: "FeatureCollection",
                                        features: []
                                    }
                                },
                                infoLengthFeatures: {
                                    type: 'geojson',
                                    data: {
                                        type: "FeatureCollection",
                                        features: []
                                    }
                                },
                                infoAreaFeatures: {
                                    type: 'geojson',
                                    data: {
                                        type: "FeatureCollection",
                                        features: []
                                    }
                                },
                                pointLocation: {
                                    type: 'geojson',
                                    data: {
                                        'type': 'FeatureCollection',
                                        'features': []
                                    }
                                },
                            },
                            layers: [
                                ...layer1,
                                ...layer2,
                                ...layer3
                            ]
                        };
                        var lngLat = getCookie('lngLat') ? JSON.parse(getCookie('lngLat')) : [106.702103, 10.775496];
                        var lngLatClick = [];
                        const map = new maplibregl.Map({
                            container: 'map',
                            style: mapStyle,
                            center: lngLat,
                            zoom: 13,
                            warnings: false,
                            attributionControl: {
                                customAttribution: null,
                            },
                        });
                
                        const popup = new maplibregl.Popup({
                            closeButton: false,
                            closeOnClick: false,
                            className: 'custom-popup',
                            offset: [2, -2],
                        });
                        const marker = new maplibregl.Marker({
                            color: 'red',
                            draggable: true,
                        }).setLngLat(lngLat).addTo(map);
                
                        map.getCanvas().style.cursor = 'pointer';
                        if (Device == 3) {
                            map.on('mousemove', (e) => {
                                handleMapMouseMove(map, popup, e);
                            });
                        }
                        map.on('click', (e) => {
                            const resultClick = handleMapClick(map, e);
                            if (resultClick) {
                                lngLatClick = e.lngLat;
                                map.panTo(e.lngLat);
                            };
                        });
                        marker.on('dragend', (e) => {
                            lngLat = marker.getLngLat();
                            e.lngLat = lngLat;
                            e.point = map.project(lngLat);
                            const resultClick = handleMapClick(map, e);
                            if (resultClick) {
                                lngLatClick = lngLat;
                            };
                            map.panTo(lngLat);
                            setCookie('lngLat', JSON.stringify(lngLat));
                        });
                        document.getElementById('markerButton').addEventListener('click', () => {
                            lngLat = lngLatClick;
                            marker.setLngLat(lngLat);
                            map.panTo(lngLat);
                            setCookie('lngLat', JSON.stringify(lngLat));
                        });
                
                        /* search */
                        /*$(document).on('change','.jProvinceItems .jEle',function(){ 
                        console.log($(this).find('option:selected').data('latlng'));
                    });*/
                
                        $(document).on('click', '.jZoomIn', function(event) {
                            map.zoomIn();
                        });
                        $(document).on('click', '.jZoomOut', function(event) {
                            map.zoomOut();
                        });
                
                        $(document).on('click', '.jSidebarClose', function(event) {
                            $(document).find('#sidebar').removeClass('active');
                        });
                        /*
                        $(document).on('change', '.jDistrictsItems .jEle', function() {
                            const latLng = $(this).find('option:selected').data('latlng');
                            if (latLng) {
                                const [lat, lng] = latLng.split(',').map(Number);
                                map.flyTo({
                                    center: [lng, lat],
                                    zoom: 14,
                                })
                            }
                        });
                        $(document).on('change', '.jWardsItems .jEle', function() {
                            const latLng = $(this).find('option:selected').data('latlng');
                            if (latLng) {
                                const [lat, lng] = latLng.split(',').map(Number);
                                map.flyTo({
                                    center: [lng, lat],
                                    zoom: 17,
                                })
                            }
                        });*/
                
                        $(document).on('click', '.jGetLatLng', function() {
                            const latLng = $(this).data('latlng');
                            if (!latLng) {
                                return;
                            }
                            const [lat, lng] = latLng.split(',').map(Number);
                            const districtName = $(this).data('districtname');
                            const wardName = $(this).data('wardname');
                            $(document).find('.FilterText-Default').hide();
                            $(document).find('.FilterText-Title').text(districtName).show();
                            if (wardName) {
                                $(document).find('.FilterText-Sub').text(wardName).show();
                                map.flyTo({
                                    center: [lng, lat],
                                    zoom: 17,
                                })
                                if (Device == 1) {
                                    $(document).find('.GroupSearch').addClass('no-hover');
                                }
                            } else {
                                $(document).find('.FilterText-Sub').hide();
                                map.flyTo({
                                    center: [lng, lat],
                                    zoom: 14,
                                })
                            }
                            if (Device == 3) {
                                $(document).find('.GroupSearch').addClass('no-hover');
                                setTimeout(() => {
                                    $(document).find('.GroupSearch').removeClass('no-hover');
                                }, 50);
                            }
                        });
                
                        if (Device == 1) {
                            $(document).on('click', '.GroupSearch', function(event) {
                                var target = $(event.target);
                                if (target.closest('.FilterItems, .GroupButton').length === 0) {
                                    $(this).removeClass('no-hover');
                                }
                            });
                            map.on('load', (e) => {
                                $(document).find('.maplibregl-ctrl.maplibregl-ctrl-attrib.maplibregl-compact').removeClass('maplibregl-compact-show').removeAttr('open');
                            })
                        }
                        $(document).on('click', '.jSearch', function(event) {
                            $(document).find('.jGetSearchBox').toggleClass('active');
                        })
                        $(document).on('click', function(event) {
                            if (!$(event.target).closest('.jGetSearchBox').length && !$(event.target).closest('.jSearch').length) {
                                $(document).find('.jGetSearchBox').removeClass('active');
                            }
                        });
                
                        $(document).on('keyup', '.jGetSearchBox .jEle', function(event) {
                            const query = event.target.value.trim();
                            if (!query) {
                                return;
                            }
                            const latLngRegex = /^-?\d{1,3}\.\d+,\s*-?\d{1,3}\.\d+$/;
                            if (latLngRegex.test(query)) {
                                const [lat, lng] = query.split(',').map(Number);
                                const lngLatSearch = [lng, lat];
                                map.flyTo({
                                    center: lngLatSearch,
                                    zoom: 19,
                                });
                                map.once('moveend', () => {
                                    const point = map.project(lngLatSearch);
                                    const e = {
                                        lngLat: {lat: lngLatSearch[0], lng: lngLatSearch[1]},
                                        point
                                    };
                                    handleMapClick(map, e);
                                });
                                return;
                            }
                            const toThuaRegex = /^(\d{1,3})[/-](\d{1,3})$/;
                            if (toThuaRegex.test(query)) {
                                const [soTo, soThua] = query.split(/[/-]/).map(Number);
                                console.log(soTo, soThua);
                                return;
                            }
                            const removeAccents = (str) => {
                                return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                            }
                            const toThuaquery = removeAccents(event.target.value.trim());
                            const toThuaTextRegex = /^to (\d{1,3}) thua (\d{1,3})$/i;
                            const toThuaTextRegex2 = /^so to (\d{1,3}) so thua (\d{1,3})$/i;
                            if (toThuaTextRegex.test(toThuaquery)) {
                                const [_, soTo, soThua] = query.match(toThuaTextRegex);
                                return;
                            }
                            if (toThuaTextRegex2.test(toThuaquery)) {
                                const [_, soTo, soThua] = query.match(toThuaTextRegex2);
                                return;
                            }
                        });
                
                        $(document).on('click', '.ButtonZone.Marker', function(event) {
                            map.flyTo({
                                center: lngLat,
                                zoom: 19,
                            });
                            map.once('moveend', () => {
                                const point = map.project(lngLat);
                                const e = {
                                    lngLat: lngLat,
                                    point
                                };
                                handleMapClick(map, e);
                            });
                        });
                        $(document).on('click', '.ButtonZone.Location', function(event) {
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition((position) => {
                                    const lngLatLocation = [position.coords.longitude, position.coords.latitude];
                                    map.flyTo({
                                        center: lngLatLocation,
                                        zoom: 19,
                                    })
                                }, (error) => {
                                    alert('Không thể lấy vị trí hiện tại của bạn.');
                                });
                            } else {
                                alert('Trình duyệt của bạn không hỗ trợ định vị GPS.');
                            }
                        });
                
                        const size = 120;
                        const pulsingDot = {
                            width: size,
                            height: size,
                            data: new Uint8Array(size * size * 4),
                
                            onAdd() {
                                const canvas = document.createElement('canvas');
                                canvas.width = this.width;
                                canvas.height = this.height;
                                this.context = canvas.getContext('2d');
                            },
                
                            render() {
                                const duration = 1000;
                                const t = (performance.now() % duration) / duration;
                
                                const radius = (size / 2) * 0.3;
                                const outerRadius = (size / 2) * 0.7 * t + radius;
                                const context = this.context;
                
                                context.clearRect(0, 0, this.width, this.height);
                                context.beginPath();
                                context.arc(
                                    this.width / 2,
                                    this.height / 2,
                                    outerRadius,
                                    0,
                                    Math.PI * 2
                                );
                                context.fillStyle = `rgba(255, 200, 200,${1 - t})`;
                                context.fill();
                
                                context.beginPath();
                                context.arc(
                                    this.width / 2,
                                    this.height / 2,
                                    radius,
                                    0,
                                    Math.PI * 2
                                );
                                context.fillStyle = 'rgba(255, 10, 10, 1)';
                                context.strokeStyle = 'white';
                                context.lineWidth = 3 + 4 * (1 - t);
                                context.fill();
                                context.stroke();
                
                                this.data = context.getImageData(
                                    0,
                                    0,
                                    this.width,
                                    this.height
                                ).data;
                
                                map.triggerRepaint();
                
                                return true;
                            }
                        };
                
                        setTimeout(() => {
                            map.on('load', () => {
                                map.addImage('pulsing-dot', pulsingDot, {
                                    pixelRatio: 2
                                });
                                if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition((position) => {
                                        const lngLatLocation = [position.coords.longitude, position.coords.latitude];
                                        map.getSource('pointLocation').setData({
                                            'type': 'FeatureCollection',
                                            'features': [{
                                                'type': 'Feature',
                                                'geometry': {
                                                    'type': 'Point',
                                                    'coordinates': lngLatLocation
                                                }
                                            }]
                                        });
                                    });
                                }
                            });
                
                        }, 500);
                
                        return map;
                    };
                    initializeMap();
                })
                /* });*/
            </script>
        </div>
    </section>
</main>
<script type="text/javascript" src="https://kinglandgroup.vn/js/map/Translator.js"></script>
<script type="text/javascript" src="https://kinglandgroup.vn/js/map/rocker.all.js"></script>
<script type="text/javascript" src="https://kinglandgroup.vn/js/map/jquery.history.js"></script>
<script type="text/javascript" src="https://kinglandgroup.vn/js/map/rocker.dtl.js"></script>
<script type="text/javascript" src="https://kinglandgroup.vn/js/map/rocker.fm.js"></script>
</div>