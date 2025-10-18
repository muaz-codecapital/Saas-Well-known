<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Payment Cancelled - {{config('app.name')}}</title>
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
                                <i class="fas fa-times-circle text-warning" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="font-weight-bolder text-dark mb-3">Payment Cancelled</h3>
                            <p class="text-muted mb-4">
                                Your payment was cancelled. Don't worry, no charges were made to your account.
                            </p>
                            
                            <div class="d-flex justify-content-center gap-3">
                                <a href="/payment/stripe" class="btn btn-primary">
                                    <i class="fas fa-credit-card me-2"></i>
                                    Try Payment Again
                                </a>
                                <a href="/signup" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Back to Registration
                                </a>
                            </div>

                            <div class="mt-4">
                                <small class="text-muted">
                                    Need help? <a href="mailto:support@{{config('app.url')}}" class="text-primary">Contact Support</a>
                                </small>
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
    // Show cancellation message
    Swal.fire({
        title: 'Payment Cancelled',
        text: 'Your payment was cancelled. You can try again or contact support if you need assistance.',
        icon: 'info',
        confirmButtonColor: '#4f55da',
        confirmButtonText: 'OK'
    });
});
</script>

</body>
</html>
