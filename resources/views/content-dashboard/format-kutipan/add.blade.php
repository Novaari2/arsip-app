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
.invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 80%;
}
.is-invalid {
    border-color: #dc3545 !important;
}
/* Loading spinner styles */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    display: none;
}
.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@include('layouts.overview', ['text' => 'Format Kutipan', 'icon' => 'mdi mdi-airplay'])
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- <a href="{{ route('format.kutipan' }}" class="btn btn-sm bg-green text-white mb-4" target="_blank"><i class="mdi mdi-airplus"></i>Cetak Pdf</a> --}}
            <form action="{{ route('format.kutipan', Request::segment(4, 'default')) }}" method="POST" class="forms-sample" id="kutipanForm">
                @csrf
                <div class="form-group">
                    <label for="kepala_kantor">Input Kepala Kantor <span class="sup-required">*</span></label>
                    <input type="text" name="kepala_kantor" id="kepala_kantor" class="form-control" required>
                    <div class="invalid-feedback" id="kepala_kantor_error" style="display: none;">
                        Nama Kepala Kantor harus diisi
                    </div>
                </div>
                <div class="form-group">
                    <label for="saksi_1">Input Saksi I <span class="sup-required">*</span></label>
                    <input type="text" name="saksi_1" id="saksi_1" class="form-control" required>
                    <div class="invalid-feedback" id="saksi_1_error" style="display: none;">
                        Nama Saksi I harus diisi
                    </div>
                </div>
                <div class="form-group">
                    <label for="saksi_2">Input Saksi II <span class="sup-required">*</span></label>
                    <input type="text" name="saksi_2" id="saksi_2" class="form-control" required>
                    <div class="invalid-feedback" id="saksi_2_error" style="display: none;">
                        Nama Saksi II harus diisi
                    </div>
                </div>
                <div class="form-group">
                    <label for="catatan">Masukkan Catatan <span class="sup-required">*</span></label>
                    <textarea name="catatan" id="catatan" cols="30" rows="10" class="form-control" required></textarea>
                    <div class="invalid-feedback" id="catatan_error" style="display: none;">
                        Catatan harus diisi
                    </div>
                </div>
                <button type="submit" class="btn btn-sm bg-green text-white mb-4" target="_blank"><i class="mdi mdi-airplus"></i>Cetak Pdf</button>
                <button type="button" class="btn btn-sm bg-blue text-white mb-4" id="kirimEmailBtn"><i class="mdi mdi-email"></i>Kirim Email</button>
            </form>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
    <div style="color: white; margin-top: 15px; font-weight: bold;">Mengirim email...</div>
</div>

<!-- Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Kirim Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="email">Email Address: <span class="sup-required">*</span></label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" required>
                    <div class="invalid-feedback" id="email_error" style="display: none;">
                        Email harus diisi dengan format yang benar
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="sendEmailBtn">Send</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Form validation function
        function validateForm() {
            let isValid = true;
            
            // Validate kepala_kantor
            if ($('#kepala_kantor').val().trim() === '') {
                $('#kepala_kantor').addClass('is-invalid');
                $('#kepala_kantor_error').show();
                isValid = false;
            } else {
                $('#kepala_kantor').removeClass('is-invalid');
                $('#kepala_kantor_error').hide();
            }
            
            // Validate saksi_1
            if ($('#saksi_1').val().trim() === '') {
                $('#saksi_1').addClass('is-invalid');
                $('#saksi_1_error').show();
                isValid = false;
            } else {
                $('#saksi_1').removeClass('is-invalid');
                $('#saksi_1_error').hide();
            }
            
            // Validate saksi_2
            if ($('#saksi_2').val().trim() === '') {
                $('#saksi_2').addClass('is-invalid');
                $('#saksi_2_error').show();
                isValid = false;
            } else {
                $('#saksi_2').removeClass('is-invalid');
                $('#saksi_2_error').hide();
            }
            
            // Validate catatan
            if ($('#catatan').val().trim() === '') {
                $('#catatan').addClass('is-invalid');
                $('#catatan_error').show();
                isValid = false;
            } else {
                $('#catatan').removeClass('is-invalid');
                $('#catatan_error').hide();
            }
            
            return isValid;
        }

        // Form submission
        $('#kutipanForm').on('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
            return true;
        });

        // Real-time validation on input
        $('#kepala_kantor, #saksi_1, #saksi_2, #catatan').on('input', function() {
            if ($(this).val().trim() !== '') {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').hide();
            }
        });

        // Email modal
        $('#kirimEmailBtn').click(function() {
            // Validate form first
            if (!validateForm()) {
                return;
            }
            $('#emailModal').modal('show');
        });

        // Email validation
        function validateEmail() {
            let email = $('#email').val().trim();
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email === '' || !emailRegex.test(email)) {
                $('#email').addClass('is-invalid');
                $('#email_error').show();
                return false;
            } else {
                $('#email').removeClass('is-invalid');
                $('#email_error').hide();
                return true;
            }
        }

        $('#email').on('input', function() {
            validateEmail();
        });

        $('#sendEmailBtn').click(function() {
            if (!validateEmail()) {
                return;
            }
            
            var email = $('#email').val();
            var id = $('input[name="id"]').val();

            // Show loading overlay
            $('#loadingOverlay').show();
            // Disable send button to prevent multiple clicks
            $('#sendEmailBtn').prop('disabled', true).text('Sending...');

            $.ajax({
                url: '{{ route( 'format.send.email', Request::segment(4, 'default')) }}',
                type: 'GET',
                data: { 
                    email: email, 
                    id: id, 
                    kepala_kantor: $('input[name="kepala_kantor"]').val(), 
                    saksi_1: $('input[name="saksi_1"]').val(),
                    saksi_2: $('input[name="saksi_2"]').val(), 
                    catatan: $('textarea[name="catatan"]').val() 
                },
                success: function(response) {
                    // Hide loading overlay
                    $('#loadingOverlay').hide();
                    // Reset button state
                    $('#sendEmailBtn').prop('disabled', false).text('Send');
                    
                    // Close modal first
                    $('#emailModal').modal('hide');
                    $('#email').val('');
                    
                    // Store email info in localStorage for display on index page
                    if (response.status === 'success') {
                        // Store notification for index page
                        let emailInfo = {
                            email: email,
                            message: response.message,
                            timestamp: response.timestamp || new Date().toLocaleString(),
                            status: 'success'
                        };
                        localStorage.setItem('emailNotification', JSON.stringify(emailInfo));
                        
                        // Store email sent status for this specific item
                        if (response.item_id) {
                            let emailSentInfo = {
                                email: email,
                                timestamp: response.timestamp || new Date().toLocaleString()
                            };
                            localStorage.setItem('email_sent_' + response.item_id, JSON.stringify(emailSentInfo));
                        }
                    }
                    
                    // Show success message and wait for user to click OK before reloading
                    swal.fire({
                        title: 'Berhasil',
                        text: response.message || 'Email berhasil dikirim',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    // Hide loading overlay
                    $('#loadingOverlay').hide();
                    // Reset button state
                    $('#sendEmailBtn').prop('disabled', false).text('Send');
                    
                    // Get error message from response if available
                    let errorMessage = 'Email gagal dikirim';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    // Show error message
                    swal.fire({
                        title: 'Gagal',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
@endsection