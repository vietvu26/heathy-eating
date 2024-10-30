@extends('front.layouts.app')

@section('main')
<div class="container">
    <div class="tieude" style="margin-top:40px">
        <a href="/">Trang chủ</a>
        <span>&nbsp;&nbsp;/&nbsp;&nbsp;</span>
        <a href="" style="color: black">Công cụ tính BMI</a>
    </div>
    <div class="package-title text-center mb-4">Công cụ tính chỉ số BMI</div>

    <!-- Form nhập dữ liệu -->
    <div class="bmi-calculator">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="bmiForm">
                    <div class="mb-3">
                        <label for="weight" class="form-label">Cân nặng (kg):</label>
                        <input type="number" id="weight" class="form-control" placeholder="Nhập cân nặng của bạn" required>
                    </div>
                    <div class="mb-3">
                        <label for="height" class="form-label">Chiều cao (cm):</label>
                        <input type="number" id="height" class="form-control" placeholder="Nhập chiều cao của bạn" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="calculateBMI()">Tính BMI</button>
                </form>

                <!-- Kết quả -->
                <div id="result" class="mt-4"></div>
            </div>
        </div>
    </div>
    <p>
        <img src="front-asset/images/bmi.png" alt="" style="width: 100%">
    </p>
</div>

<script>
    function calculateBMI() {
        // Lấy giá trị cân nặng và chiều cao
        const weight = parseFloat(document.getElementById('weight').value);
        const heightCm = parseFloat(document.getElementById('height').value);

        if (!weight || !heightCm) {
            document.getElementById('result').innerHTML = '<p style="color: red;">Vui lòng nhập đủ cân nặng và chiều cao.</p>';
            return;
        }

        // Tính chỉ số BMI
        const heightM = heightCm / 100;
        const bmi = weight / (heightM * heightM);

        // Phân loại chỉ số BMI
        let category = '';
        if (bmi < 18.5) {
            category = 'Gầy';
        } else if (bmi >= 18.5 && bmi < 24.9) {
            category = 'Bình thường';
        } else if (bmi >= 25 && bmi < 29.9) {
            category = 'Thừa cân';
        } else {
            category = 'Béo phì';
        }

        // Hiển thị kết quả
        document.getElementById('result').innerHTML = `
            <p><strong>BMI của bạn là:</strong> ${bmi.toFixed(2)}</p>
            <p><strong>Phân loại:</strong> ${category}</p>
        `;
    }
</script>
@endsection
