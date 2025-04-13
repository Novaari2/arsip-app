@extends('layouts.app')

@section('content')
<style>
    .form-meta-information{
        width: 100%;
    }
    .sup-required {
        color:red;
    }
    .custom-error-size {
        font-size: 11px;
    }
    .nav-tabs .nav-item .nav-link.active {
    background-color: rgba(255, 0, 0, 0.663);
    color: #FFF;
}

.nav-tabs .nav-item .nav-link {
  color: rgba(255, 0, 0, 0.663);
}
/* Email notification styles */
.email-notification {
    display: none;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    position: relative;
}
.email-notification.error {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}
.email-notification-close {
    position: absolute;
    right: 10px;
    top: 10px;
    cursor: pointer;
    font-weight: bold;
}
.email-details {
    margin-top: 5px;
    font-size: 0.9em;
}
</style>
@include('layouts.overview', ['text' => 'Format Kutipan', 'icon' => 'mdi mdi-airplay'])
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- <a href="{{ route('risalah_lelang.add') }}" class="btn btn-sm bg-green text-white aadd mb-4"><i class="mdi mdi-airplus"></i>Tambah</a> --}}
            <!-- Email notification banner -->
            <div class="email-notification" id="emailNotification">
                <span class="email-notification-close" onclick="closeNotification()">&times;</span>
                <strong id="notificationTitle">Email Berhasil Dikirim!</strong>
                <div class="email-details" id="emailDetails"></div>
            </div>
            
            @include('layouts.message')
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table table-striped table-bordered table-hover datatables-styles data-all" width="100%" id="table1">
                        <thead>
                            <tr>
                                <th>Nomor Risalah Lelang</th>
                                <th>No Lot Barang</th>
                                <th>Nama Pembeli</th>
                                <th>Pejabat Lelang</th>
                                <th>Status Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>

    let table = $('.data-all').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('format.index') }}",
        columns: [
            {data: 'risalah', name: 'risalah'},
            {data: 'lot', name: 'lot'},
            {data: 'pembeli', name: 'pembeli'},
            {data: 'pejabat', name: 'pejabat'},
            {
                data: null,
                name: 'email_status',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.has_email_log) {
                        return `<span class="badge badge-success" title="Email terakhir dikirim: ${row.last_email_date}">
                                <i class="mdi mdi-email-check"></i> Email Terkirim
                                </span>`;
                    } else {
                        return `<span class="badge badge-secondary">
                                <i class="mdi mdi-email-outline"></i> Belum Dikirim
                                </span>`;
                    }
                }
            },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Check for email notification in localStorage
    $(document).ready(function() {
        const emailNotification = localStorage.getItem('emailNotification');
        if (emailNotification) {
            const notificationData = JSON.parse(emailNotification);
            showEmailNotification(notificationData);
            // Clear the notification from localStorage after displaying it
            localStorage.removeItem('emailNotification');
        }
    });

    // Function to display email notification
    function showEmailNotification(data) {
        const notification = $('#emailNotification');
        const title = $('#notificationTitle');
        const details = $('#emailDetails');
        
        // Set notification type (success/error)
        if (data.status === 'error') {
            notification.addClass('error');
            title.text('Pengiriman Email Gagal!');
        } else {
            title.text('Email Berhasil Dikirim!');
        }
        
        // Set notification details
        let detailsHtml = `
            <p>${data.message || ''}</p>
            <p><small>Waktu: ${data.timestamp || new Date().toLocaleString()}</small></p>
        `;
        details.html(detailsHtml);
        
        // Show the notification
        notification.fadeIn();
        
        // Auto-hide after 10 seconds
        setTimeout(function() {
            notification.fadeOut();
        }, 10000);
    }
    
    // Function to close notification
    function closeNotification() {
        $('#emailNotification').fadeOut();
    }
</script>
@endsection