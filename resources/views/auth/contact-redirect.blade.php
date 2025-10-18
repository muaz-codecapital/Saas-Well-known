<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Redirecting to Contact - {{config('app.name')}}</title>
    @if(!empty($super_settings['favicon']))
        <link rel="icon" type="image/png" href="{{PUBLIC_DIR}}/uploads/{{$super_settings['favicon']}}">
    @endif
    <link id="pagestyle" href="{{PUBLIC_DIR}}/css/app.css" rel="stylesheet"/>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="g-sidenav-show bg-gray-100">

<section>
    <div class="page-header section-height-75">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-8">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="font-weight-bolder text-dark mb-3">Registration Successful!</h3>
                            <p class="text-muted mb-4">
                                Your account has been created successfully. You will now be redirected to our contact page to discuss your custom package requirements.
                            </p>
                            
                            <div class="mb-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Redirecting in <span id="countdown">5</span> seconds...</p>
                            </div>

                            <div class="d-flex justify-content-center gap-3">
                                <a href="https://grsventures.ltd/contact" class="btn btn-primary">
                                    <i class="fas fa-external-link-alt me-2"></i>
                                    Go to Contact Page Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let countdown = 5;
    const countdownElement = document.getElementById('countdown');
    
    // Show success message
    Swal.fire({
        title: 'Registration Complete!',
        text: 'You are now registered in our system. You will be redirected to our contact page to discuss your custom package.',
        icon: 'success',
        confirmButtonColor: '#4f55da',
        confirmButtonText: 'Continue',
        showCancelButton: false,
        allowOutsideClick: false
    }).then(() => {
        // Start countdown
        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = 'https://grsventures.ltd/contact';
            }
        }, 1000);
    });
});
</script>

</body>
</html>
