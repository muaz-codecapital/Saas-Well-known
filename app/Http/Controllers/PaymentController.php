<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\Setting;
use App\Models\StartupDetail;
use App\Models\User;
use App\Models\Workspace;
use App\Models\SubscriptionPlan;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class PaymentController extends Controller
{
    public function stripePayment(Request $request)
    {
        // Check if registration data exists in session
        $registrationData = session('registration_data');
        if (!$registrationData) {
            return redirect('/signup')->withErrors(['error' => 'Registration session expired. Please register again.']);
        }

        // Get Stripe configuration
        $stripeGateway = PaymentGateway::where('api_name', 'stripe')->where('active', 1)->first();
        if (!$stripeGateway) {
            return redirect('/signup')->withErrors(['error' => 'Payment gateway not configured. Please contact support.']);
        }

        $plan = $registrationData['plan'];
        $amount = $registrationData['selected_duration'] === 'monthly' ? $plan->price_monthly : $plan->price_yearly;

        return view('payment.stripe', [
            'registrationData' => $registrationData,
            'plan' => $plan,
            'amount' => $amount,
            'duration' => $registrationData['selected_duration'],
            'stripePublicKey' => $stripeGateway->public_key
        ]);
    }

    public function createStripeSession(Request $request)
    {
        try {
            // Get registration data from session
            $registrationData = session('registration_data');
            if (!$registrationData) {
                return response()->json(['error' => 'Registration session expired'], 400);
            }

            // Get Stripe configuration
            $stripeGateway = PaymentGateway::where('api_name', 'stripe')->where('active', 1)->first();
            if (!$stripeGateway) {
                return response()->json(['error' => 'Payment gateway not configured'], 400);
            }

            // Set Stripe API key
            Stripe::setApiKey($stripeGateway->private_key);

            $plan = $registrationData['plan'];
            $amount = $registrationData['selected_duration'] === 'monthly' ? $plan->price_monthly : $plan->price_yearly;

            // Create Stripe Checkout Session
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $plan->name . ' - ' . ucfirst($registrationData['selected_duration']),
                            'description' => 'Subscription to ' . $plan->name . ' plan',
                        ],
                        'unit_amount' => $amount * 100, // Convert to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => url('/payment/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('/payment/cancel'),
                'metadata' => [
                    'plan_id' => $plan->id,
                    'duration' => $registrationData['selected_duration'],
                ]
            ]);

            return response()->json(['checkout_url' => $session->url]);

        } catch (\Exception $e) {
            Log::error('Stripe session creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment processing failed. Please try again.'], 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        try {
            $sessionId = $request->get('session_id');
            if (!$sessionId) {
                return redirect('/signup')->withErrors(['error' => 'Invalid payment session.']);
            }

            // Get registration data from session
            $registrationData = session('registration_data');
            if (!$registrationData) {
                return redirect('/signup')->withErrors(['error' => 'Registration data expired. Please register again.']);
            }

            // Get Stripe configuration
            $stripeGateway = PaymentGateway::where('api_name', 'stripe')->where('active', 1)->first();
            if (!$stripeGateway) {
                return redirect('/signup')->withErrors(['error' => 'Payment gateway not configured.']);
            }

            // Set Stripe API key and retrieve session
            Stripe::setApiKey($stripeGateway->private_key);
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                // Now create the user and workspace after successful payment
                $workspace = new Workspace();
                $workspace->name = $registrationData['first_name'] . "'s workspace";
                $workspace->plan_id = $registrationData['selected_plan'];
                $workspace->subscribed = true;
                $workspace->active = true;
                $workspace->subscription_start_date = now();
                
                // Set pricing and term
                $plan = $registrationData['plan'];
                if ($registrationData['selected_duration'] === 'monthly') {
                    $workspace->price = $plan->price_monthly;
                    $workspace->term = 'monthly';
                    $workspace->next_renewal_date = now()->addMonth();
                } else {
                    $workspace->price = $plan->price_yearly;
                    $workspace->term = 'yearly';
                    $workspace->next_renewal_date = now()->addYear();
                }
                
                $workspace->save();

                // Create user
                $user = new User();
                $user->password = Hash::make($registrationData['password']);
                $user->first_name = $registrationData['first_name'];
                $user->last_name = $registrationData['surname'];
                $user->email = $registrationData['email'];
                $user->workspace_id = $workspace->id;
                $user->save();

                // Create startup details
                $startupDetail = new StartupDetail();
                $startupDetail->user_id = $user->id;
                $startupDetail->company_name = $registrationData['company_name'];
                $startupDetail->industry = $registrationData['industry'];
                $startupDetail->current_stage = $registrationData['current_stage'];
                $startupDetail->team_size = $registrationData['team_size'];
                $startupDetail->save();

                $workspace->owner_id = $user->id;
                $workspace->save();

                // Send welcome email if configured
                $super_settings = Setting::pluck('value', 'key');
                if(!empty($super_settings['smtp_host'])) {
                    try{
                        Config::set('mail.mailers.smtp.host',$super_settings['smtp_host']);
                        Config::set('mail.mailers.smtp.username',$super_settings['smtp_username']);
                        Config::set('mail.mailers.smtp.password',$super_settings['smtp_password']);
                        Config::set('mail.mailers.smtp.port',$super_settings['smtp_port']);
                        Mail::to($user)->send(new WelcomeEmail($user));
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                    }
                }

                // Log the user in
                Auth::login($user);

                // Clear registration session
                session()->forget('registration_data');

                return redirect('/dashboard')->with('success', 'Payment successful! Welcome to your dashboard.');
            } else {
                return redirect('/payment/cancel')->withErrors(['error' => 'Payment was not completed.']);
            }

        } catch (\Exception $e) {
            Log::error('Payment success handling failed: ' . $e->getMessage());
            return redirect('/signup')->withErrors(['error' => 'Payment verification failed. Please contact support.']);
        }
    }

    public function paymentCancel()
    {
        return view('payment.cancel');
    }
}