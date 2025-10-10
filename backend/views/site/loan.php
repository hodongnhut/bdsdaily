<?php
use yii\helpers\Html;
$this->title = 'Tính Toán Khoản Vay';

// Register your custom JavaScript file
$this->registerJsFile('@web/js/calculator.js', ['depends' => [\yii\web\JqueryAsset::class]]);

// Register your custom CSS file
$this->registerCssFile('@web/css/calculator.css');


?>
<!-- Header -->
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Tính Toán Khoản Vay</div>
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

<main class="flex-1 p-6 overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="loan-calculator">
            <h1>Tính Toán Khoản Vay</h1>
            
            <!-- Form Section -->
            <div class="form-row">
                <div class="form-group">
                    <label for="loan-amount">Số tiền vay *</label>
                    <input type="text" id="loan-amount" placeholder="Nhập số tiền vay" oninput="formatLoanAmount(this)">
                </div>

                <div class="form-group">
                    <label for="loan-term">Thời hạn vay *</label>
                    <select id="loan-term">
                        <option value="6">6 tháng</option>
                        <option value="12">12 tháng</option>
                        <option value="18">18 tháng</option>
                        <option value="24">24 tháng</option>
                        <option value="36">36 tháng</option>
                        <option value="60">60 tháng</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="interest-rate">Lãi suất cho vay *</label>
                    <input type="number" id="interest-rate" placeholder="Nhập lãi suất %/năm" 
                        required 
                        min="0.1" 
                        max="100" 
                        step="0.1" 
                        oninput="validateInterestRate(this)">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="disbursement-date">Ngày giải ngân *</label>
                    <input type="date" id="disbursement-date">
                </div>

                <div class="form-group">
                    <label for="loan-interest">Số tiền lãi phải trả</label>
                    <input type="text" id="loan-interest" readonly>
                </div>

                <div class="form-group">
                    <label for="total-payment">Số tiền gốc và lãi phải trả</label>
                    <input type="text" id="total-payment" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" onclick="calculateLoan()">Tính toán khoản vay</button>
                </div>
                <div class="form-group">
                </div>
            </div>
            
        </div>
        
        <!-- Loan Amortization Table -->
        <h3>Bảng Tính Khoản Vay</h3>
        <table class="loan-schedule">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kỳ trả nợ</th>
                    <th>Số gốc còn lại</th>
                    <th>Gốc</th>
                    <th>Lãi</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody id="loan-schedule"></tbody>
        </table>
    </div>
</main>
