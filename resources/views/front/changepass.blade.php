@extends('front.layouts.app')

@section('main')
<div class="container">
    <div class="tieude" style="margin-top: 30px">
        <a href="/">Trang chủ</a>
        <span>&nbsp;&nbsp;/&nbsp;&nbsp;</span>
        <a href="" style="color: black">Thay đổi mật khẩu</a>
    </div>

    <!-- Khu vực hiển thị thông báo -->
    <div id="alert-area"></div>

    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Thay đổi mật khẩu </div>

                <div class="card-body">
                    <!-- Form cập nhật mật khẩu -->
                    <form id="passwordChangeForm">
                        @csrf

                        <!-- Mật khẩu cũ -->
                        <div class="form-group">
                            <label for="password">Mật khẩu cũ</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <!-- Mật khẩu mới -->
                        <div class="form-group">
                            <label for="password_new">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="password_new" name="password_new" required>
                        </div>

                        <!-- Nhập lại mật khẩu mới -->
                        <div class="form-group">
                            <label for="password_confirmation">Nhập lại mật khẩu mới</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <!-- Nút cập nhật -->
                        <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script AJAX và tự động ẩn thông báo -->
<script>
    document.getElementById('passwordChangeForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let form = this;
        let formData = new FormData(form);

        fetch("{{ route('account.updatePassword') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            let alertArea = document.getElementById('alert-area');
            alertArea.innerHTML = ''; // Xóa thông báo cũ

            let alertDiv = document.createElement('div');
            if (data.status === 'success') {
                alertDiv.className = 'alert alert-success';
            } else if (data.status === 'warning') {
                alertDiv.className = 'alert alert-warning';
            } else {
                alertDiv.className = 'alert alert-danger';
            }

            alertDiv.textContent = data.message;
            alertArea.appendChild(alertDiv);

            // Ẩn thông báo sau 3 giây
            setTimeout(function() {
                alertDiv.style.display = 'none';
            }, 3000);

            // Xóa form nếu mật khẩu thay đổi thành công
            if (data.status === 'success') {
                form.reset();
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
        });
    });
</script>
@endsection
