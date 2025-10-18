<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Payment - {{config('app.name')}}</title>
    @if(!empty($super_settings['favicon']))
        <link rel="icon" type="image/png" href="{{PUBLIC_DIR}}/uploads/{{$super_settings['favicon']}}">
    @endif
    <link id="pagestyle" href="{{PUBLIC_DIR}}/css/app.css" rel="stylesheet"/>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .payment-card {
            max-width: 600px;
            margin: 0 auto;
        }
        .plan-summary {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .price-display {
            font-size: 2rem;
            font-weight: bold;
            color: #4f55da;
        }
        .btn-payment {
            background-color: #4f55da;
            border-color: #4f55da;
            padding: 12px 30px;
            font-size: 1.1rem;
        }
        .btn-payment:hover {
            background-color: #3d42a8;
            border-color: #3d42a8;
        }
        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="g-sidenav-show bg-gray-100">

<section>
    <div class="page-header section-height-75">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card payment-card mt-8">
                        <div class="card-header pb-0 text-center">
                            <h3 class="font-weight-bolder text-purple">Complete Your Payment</h3>
                            <p class="mb-0">Secure payment powered by Stripe</p>
                        </div>
                        <div class="card-body">
                            
                            <!-- Plan Summary -->
                            <div class="plan-summary">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h5 class="mb-1">{{$plan->name}}</h5>
                                        <p class="text-muted mb-0">{{ucfirst($duration)}} subscription</p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div class="price-display">${{number_format($amount, 2)}}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Button -->
                            <div class="text-center">
                                <button type="button" class="btn btn-primary btn-payment" id="checkout-button">
                                    <span class="loading-spinner" id="loading-spinner"></span>
                                    <span id="button-text">Proceed to Payment</span>
                                </button>
                            </div>

                            <!-- Security Notice -->
                            <div class="text-center mt-4">
                                <small class="text-muted">
                                    <i class="fas fa-lock me-1"></i>
                                    Your payment is secured with 256-bit SSL encryption
                                </small>
                            </div>

                            <!-- Cancel Link -->
                            <div class="text-center mt-3">
                                <a href="/signup" class="text-muted">← Back to Registration</a>
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
    const checkoutButton = document.getElementById('checkout-button');
    const loadingSpinner = document.getElementById('loading-spinner');
    const buttonText = document.getElementById('button-text');

    checkoutButton.addEventListener('click', function() {
        // Show loading state
        checkoutButton.disabled = true;
        loadingSpinner.style.display = 'inline-block';
        buttonText.textContent = 'Processing...';

        // Create Stripe checkout session
        fetch('/payment/stripe/create-session', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.checkout_url) {
                // Redirect to Stripe Checkout
                window.location.href = data.checkout_url;
            } else {
                throw new Error(data.error || 'Payment processing failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Reset button state
            checkoutButton.disabled = false;
            loadingSpinner.style.display = 'none';
            buttonText.textContent = 'Proceed to Payment';

            // Show error message
            Swal.fire({
                title: 'Payment Error',
                text: error.message || 'Something went wrong. Please try again.',
                icon: 'error',
                confirmButtonColor: '#4f55da'
            });
        });
    });
});
</script>

</body>
</html>
