<?php
use yii\helpers\Html;
$this->title = "Zalo Marketing";
?>

    <div class="content-wrapper">
        <header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
            <div class="text-lg font-semibold text-gray-800">Zalo Marketing</div>
            <div class="relative flex items-center space-x-4">
                <button
                    id="userMenuButton"
                    class="w-10 h-10 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-md transition-colors duration-200"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <i class="fas fa-user"></i>
                </button>
                <div
                    id="userMenu"
                    class="absolute right-0 mt-20 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-10 hidden"
                    role="menu"
                    aria-orientation="vertical"
                    aria-labelledby="userMenuButton"
                >
                <a href="<?= \yii\helpers\Url::to(['/login-version']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Phiên Đăng Nhập</a>
                    <a href="<?= \yii\helpers\Url::to(['/change-password']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Đổi Mật Khẩu</a>
                    <?= Html::a('Đăng Xuất', ['/site/logout'], [
                        'data-method' => 'post',
                        'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100',
                        'role' => 'menuitem'
                    ]) ?>
                </div>
            </div>
        </header>

        <main class="container-fluid p-4">

            <div id="dashboard-page" class="page-content active">
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng
                                            số phone</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">4,985 / 5,000</div>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: 99.7%"></div>
                                        </div>
                                    </div>
                                    <div class="col-auto card-icon"><i class="fas fa-phone text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kết
                                            bạn hôm nay</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">18 / 20</div>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: 90%"></div>
                                        </div>
                                    </div>
                                    <div class="col-auto card-icon"><i class="fas fa-user-check text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tin nhắn
                                            đã gửi</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">15 (Tỷ lệ: 83%)</div>
                                    </div>
                                    <div class="col-auto card-icon"><i
                                            class="fas fa-comment-dots text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Lỗi
                                            gần nhất</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">2 <a href="#"
                                                class="fs-6">(Xem)</a></div>
                                    </div>
                                    <div class="col-auto card-icon"><i
                                            class="fas fa-exclamation-triangle text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 mb-4">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Thống kê kết bạn/gửi tin (Tháng)</h6>
                            </div>
                            <div class="card-body"><canvas id="mainChart"></canvas></div>
                        </div>
                    </div>
                    <div class="col-lg-5 mb-4">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Logs hệ thống gần đây</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Thời gian</th>
                                            <th>Hành động</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>14:30:05</td>
                                            <td>Kết bạn 090xxxx123</td>
                                            <td><span class="badge bg-success">Success</span></td>
                                        </tr>
                                        <tr>
                                            <td>14:29:50</td>
                                            <td>Gửi tin 091xxxx456</td>
                                            <td><span class="badge bg-success">Success</span></td>
                                        </tr>
                                        <tr>
                                            <td>14:28:10</td>
                                            <td>Kết bạn 098xxxx789</td>
                                            <td><span class="badge bg-danger">Error</span></td>
                                        </tr>
                                        <tr>
                                            <td>14:27:00</td>
                                            <td>Gửi tin 097xxxx321</td>
                                            <td><span class="badge bg-success">Success</span></td>
                                        </tr>
                                        <tr>
                                            <td>14:25:45</td>
                                            <td>Kết bạn 096xxxx654</td>
                                            <td><span class="badge bg-success">Success</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="phone-list-page" class="page-content">
                <div class="card shadow-sm">
                    <div class="card-header bg-light py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary"><i class="fas fa-list-ol me-2"></i>Quản lý Danh sách Số
                                điện thoại</h5><button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#uploadCsvModal"><i class="fas fa-upload me-2"></i> Upload
                                CSV</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4"><label for="statusFilter" class="form-label">Lọc theo trạng
                                    thái:</label><select id="statusFilter" class="form-select form-select-sm">
                                    <option value="">Tất cả</option>
                                    <option value="Accepted">Accepted</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Rejected">Rejected</option>
                                </select></div>
                            <div class="col-md-8 text-end">
                                <div class="dropdown"><button class="btn btn-secondary btn-sm dropdown-toggle"
                                        type="button" id="bulkActions" data-bs-toggle="dropdown" disabled>Hành động
                                        hàng loạt</button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item text-danger" href="#" id="bulkDelete">Xóa các
                                                mục đã chọn</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="phoneDataTable" class="table table-striped table-bordered"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center"><input type="checkbox" id="selectAll"></th>
                                        <th>ID</th>
                                        <th>Số phone</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày thêm</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="row-checkbox"></td>
                                        <td>1</td>
                                        <td><a href="#">0901234567</a></td>
                                        <td><span class="badge bg-success">Accepted</span></td>
                                        <td>2025-08-26</td>
                                        <td class="text-center"><button class="btn btn-sm btn-info"
                                                title="Chỉnh sửa"><i class="fas fa-edit"></i></button><button
                                                class="btn btn-sm btn-danger" title="Xóa"><i
                                                    class="fas fa-trash"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="row-checkbox"></td>
                                        <td>2</td>
                                        <td><a href="#">0912345678</a></td>
                                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                                        <td>2025-08-26</td>
                                        <td class="text-center"><button class="btn btn-sm btn-info"
                                                title="Chỉnh sửa"><i class="fas fa-edit"></i></button><button
                                                class="btn btn-sm btn-danger" title="Xóa"><i
                                                    class="fas fa-trash"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="row-checkbox"></td>
                                        <td>3</td>
                                        <td><a href="#">0987654321</a></td>
                                        <td><span class="badge bg-danger">Rejected</span></td>
                                        <td>2025-08-26</td>
                                        <td class="text-center"><button class="btn btn-sm btn-info"
                                                title="Chỉnh sửa"><i class="fas fa-edit"></i></button><button
                                                class="btn btn-sm btn-danger" title="Xóa"><i
                                                    class="fas fa-trash"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="row-checkbox"></td>
                                        <td>3</td>
                                        <td><a href="#">0987654321</a></td>
                                        <td><span class="badge bg-danger">Rejected</span></td>
                                        <td>2025-08-26</td>
                                        <td class="text-center"><button class="btn btn-sm btn-info"
                                                title="Chỉnh sửa"><i class="fas fa-edit"></i></button><button
                                                class="btn btn-sm btn-danger" title="Xóa"><i
                                                    class="fas fa-trash"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="row-checkbox"></td>
                                        <td>3</td>
                                        <td><a href="#">0987654321</a></td>
                                        <td><span class="badge bg-danger">Rejected</span></td>
                                        <td>2025-08-26</td>
                                        <td class="text-center"><button class="btn btn-sm btn-info"
                                                title="Chỉnh sửa"><i class="fas fa-edit"></i></button><button
                                                class="btn btn-sm btn-danger" title="Xóa"><i
                                                    class="fas fa-trash"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="row-checkbox"></td>
                                        <td>3</td>
                                        <td><a href="#">0987654321</a></td>
                                        <td><span class="badge bg-danger">Rejected</span></td>
                                        <td>2025-08-26</td>
                                        <td class="text-center"><button class="btn btn-sm btn-info"
                                                title="Chỉnh sửa"><i class="fas fa-edit"></i></button><button
                                                class="btn btn-sm btn-danger" title="Xóa"><i
                                                    class="fas fa-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="campaigns-page" class="page-content">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Quản lý Campaigns</h5><button class="btn btn-primary"
                            style="background-color: var(--zalo-blue);" data-bs-toggle="modal"
                            data-bs-target="#createCampaignModal"><i class="fas fa-plus me-2"></i> Tạo campaign
                            mới</button>
                    </div>
                    <div class="card-body">
                        <table id="campaignsTable" class="table table-hover table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tên Campaign</th>
                                    <th>Trạng thái</th>
                                    <th>Số kết bạn/ngày</th>
                                    <th>Tỷ lệ thành công</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Campaign Chào Hè</td>
                                    <td>
                                        <div class="form-check form-switch"><input class="form-check-input"
                                                type="checkbox" checked> Active</div>
                                    </td>
                                    <td>20</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: 85%">85%</div>
                                        </div>
                                    </td>
                                    <td class="table-actions text-center"><button
                                            class="btn btn-sm btn-secondary"><i class="fas fa-rocket"></i>
                                            Trigger</button><button class="btn btn-sm btn-info"><i
                                                class="fas fa-edit"></i></button><button
                                            class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
                                </tr>
                                <tr>
                                    <td>Campaign Tháng 9</td>
                                    <td>
                                        <div class="form-check form-switch"><input class="form-check-input"
                                                type="checkbox"> Paused</div>
                                    </td>
                                    <td>20</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                style="width: 40%">40%</div>
                                        </div>
                                    </td>
                                    <td class="table-actions text-center"><button
                                            class="btn btn-sm btn-secondary"><i class="fas fa-rocket"></i>
                                            Trigger</button><button class="btn btn-sm btn-info"><i
                                                class="fas fa-edit"></i></button><button
                                            class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>


<div class="modal fade" id="uploadCsvModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File CSV</h5><button type="button" class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Vui lòng upload file CSV có một cột chứa số điện thoại theo định dạng của Việt Nam.</p>
                <form>
                    <div class="mb-3"><label for="csvFile" class="form-label">Chọn file</label><input
                            class="form-control" type="file" id="csvFile" accept=".csv"></div>
                </form>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Đóng</button><button type="button" class="btn btn-primary"
                    style="background-color: var(--zalo-blue);">Xác nhận upload</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="createCampaignModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tạo Campaign Mới</h5><button type="button" class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3"><label for="campaignName" class="form-label">Tên campaign</label><input
                            type="text" class="form-control" id="campaignName"
                            placeholder="Ví dụ: Campaign Chào Hè"></div>
                    <div class="mb-3"><label for="dailyLimit" class="form-label">Số lượng kết bạn/ngày</label><input
                            type="number" class="form-control" id="dailyLimit" value="20" max="20"></div>
                    <div class="mb-3"><label for="messageTemplate" class="form-label">Template tin nhắn
                            SEO</label><textarea class="form-control" id="messageTemplate" rows="4"
                            placeholder="Chào bạn, mời bạn tham gia sự kiện của chúng tôi tại [link]"></textarea>
                    </div>
                    <div class="form-check form-switch"><input class="form-check-input" type="checkbox"
                            id="autoTrigger" checked><label class="form-check-label" for="autoTrigger">Kích hoạt tự
                            động</label></div>
                </form>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Hủy</button><button type="button" class="btn btn-primary"
                    style="background-color: var(--zalo-blue);">Tạo Campaign</button></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        // === PAGE NAVIGATION SIMULATION ===
        $('.sidebar .nav-link').on('click', function (e) {
            e.preventDefault();

            // Update active state on sidebar
            $('.sidebar .nav-link').removeClass('active');
            $(this).addClass('active');

            // Show/hide page content
            var targetPage = $(this).data('target');
            $('.page-content').removeClass('active');
            $('#' + targetPage).addClass('active');

            // Update page title
            var pageTitle = $(this).text().trim();
            $('#page-title').text(pageTitle);
        });

        // === DASHBOARD PAGE ===
        const ctx = document.getElementById('mainChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8'],
                    datasets: [{
                        label: 'Kết bạn thành công', data: [55, 65, 80, 75, 90, 110], borderColor: 'rgba(0, 104, 255, 1)', backgroundColor: 'rgba(0, 104, 255, 0.1)', fill: true, tension: 0.4
                    }, {
                        label: 'Tin nhắn đã gửi', data: [40, 50, 65, 60, 72, 95], borderColor: 'rgba(28, 200, 138, 1)', backgroundColor: 'rgba(28, 200, 138, 0.1)', fill: true, tension: 0.4
                    }]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });
        }

        // === PHONE LIST PAGE ===
        var phoneTable = $('#phoneDataTable').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/vi.json" },
            "order": [[1, 'desc']]
        });

        $('#statusFilter').on('change', function () {
            var status = $(this).val();
            if (status) {
                phoneTable.column(3).search('^' + status + '$', true, false).draw();
            } else {
                phoneTable.column(3).search('').draw();
            }
        });

        $('#selectAll').on('click', function () {
            $('.row-checkbox').prop('checked', this.checked).trigger('change');
        });

        $('#phoneDataTable tbody').on('change', '.row-checkbox', function () {
            toggleBulkActionsButton();
        });

        function toggleBulkActionsButton() {
            var anyChecked = $('.row-checkbox:checked').length > 0;
            $('#bulkActions').prop('disabled', !anyChecked);
        }

        $('#bulkDelete').on('click', function (e) {
            e.preventDefault();
            var selectedCount = $('.row-checkbox:checked').length;
            if (selectedCount > 0 && confirm('Bạn có chắc chắn muốn xóa ' + selectedCount + ' mục đã chọn?')) {
                alert('Chức năng xóa đang được phát triển. Sẽ gửi request xóa đến backend.');
            }
        });

        // === CAMPAIGNS PAGE ===
        $('#campaignsTable').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/vi.json" },
            "searching": false,
            "lengthChange": false
        });
    });
</script>
