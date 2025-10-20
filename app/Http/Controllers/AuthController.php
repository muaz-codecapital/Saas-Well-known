<?php

namespace App\Http\Controllers;

use App\Mail\PasswordReset;
use App\Mail\WelcomeEmail;
use App\Models\Setting;
use App\Models\StartupDetail;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class AuthController extends Controller
{
    //
    protected $settings;
    protected $super_settings;

    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            $super_settings = [];

            $super_settings_data = Setting::where('workspace_id',1)->get();
            foreach ($super_settings_data as $super_setting)
            {
                $super_settings[$super_setting->key] = $super_setting->value;
            }

            $this->super_settings = $super_settings;
            $language = $super_settings['language'] ?? 'en';
            App::setLocale($language);
            View::share("super_settings", $super_settings);
            return $next($request);
        });
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect("/dashboard");
        }

        return \view("auth.login");
    }

    public function superAdminLogin()
    {
        return \view("auth.super-admin-login");
    }

    public function passwordReset(Request $request)
    {
        $request->validate([
            "id" => "required|integer",
            "token" => "required|uuid",
        ]);

        $user = User::find($request->id);

        if (!$user) {
            return redirect("/")->withErrors([
                "key" => "Invalid user or link expired",
            ]);
        }

        if ($user->password_reset_key !== $request->token) {
            return redirect("/")->withErrors([
                "key" => "Invalid key",
            ]);
        }

        return \view("auth.reset-password", [
            "id" => $request->id,
            "password_reset_key" => $request->token,
        ]);
    }

    public function signup()
    {
        $plans = SubscriptionPlan::active()->ordered()->get();
        return \view("auth.signup", [
            "plans" => $plans
        ]);
    }

    public function forgotPassword()
    {
        return \view("auth.forgot-password");
    }

    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            "email" => "required|email",
        ]);

        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return redirect()
                ->back()
                ->withErrors([
                    "email" => "No account found with this email",
                ]);
        }

        $user->password_reset_key = Str::uuid();
        $user->save();

        if(!empty($this->super_settings['smtp_host']))
        {
            try{
                Config::set('mail.mailers.smtp.host',$this->super_settings['smtp_host']);
                Config::set('mail.mailers.smtp.username',$this->super_settings['smtp_username']);
                Config::set('mail.mailers.smtp.password',$this->super_settings['smtp_password']);
                Config::set('mail.mailers.smtp.port',$this->super_settings['smtp_port']);
                Mail::to($user->email)->send(new PasswordReset($user));
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }


        session()->flash(
            "status",
            "We sent you an email with the instruction to reset the password."
        );

        return redirect("/");
    }

    public function newPasswordPost(Request $request)
    {
        $request->validate([
            "password" => "required|confirmed",
            "id" => "required|integer",
            "password_reset_key" => "required|uuid",
        ]);

        $user = User::find($request->id);

        if (!$user) {
            return redirect()
                ->back()
                ->withErrors([
                    "email" => "No account found with this email",
                ]);
        }

        if ($user->password_reset_key !== $request->password_reset_key) {
            return redirect()
                ->back()
                ->withErrors([
                    "key" => "Invalid key",
                ]);
        }

        $user->password = Hash::make($request->password);

        $user->password_reset_key = null;

        $user->save();

        session()->flash(
            "status",
            "Your password has been reset, login with the new password."
        );

        return redirect("/");
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //Verify recaptcha v2
        if(!empty($this->super_settings['config_recaptcha_in_user_login']))
        {
            $recaptcha = $request->get('g-recaptcha-response');
            $secret = $this->super_settings['recaptcha_api_secret'] ?? '';

            $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$recaptcha}");
            $captcha_success = json_decode($verify);



            if ($captcha_success->success == false) {
                return redirect()->back()->withErrors([
                    'key' => 'Invalid captcha',
                ]);
            }
        }

        $remember = false;

        if($request->remember)
        {
            $remember = true;
        }

        if (Auth::attempt($credentials, $remember)) {
            $user = User::where('email',$request->email)->first();
            if($user)
            {
                $workspace = Workspace::find($user->workspace_id);

                if($workspace && $workspace->id != 1 && $workspace->trial == 1)
                {

                    $super_admin_settings = Setting::getSuperAdminSettings();

                    if(!empty($super_admin_settings['free_trial_days']))
                    {
                        $free_trial_days = $super_admin_settings['free_trial_days'];
                        $free_trial_days = (int) $free_trial_days;
                        $workspace_creation_date = $workspace->created_at;
                        $trial_will_expire = strtotime($workspace_creation_date) + ($free_trial_days*24*60*60);

                        if($trial_will_expire < time())
                        {
                            Auth::logout();
                            return back()->withErrors([
                                'trial_expired' => __('Your trial has been expired.'),
                            ]);
                        }
                    }
                }
            }
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function superAdminAuthenticate(Request $request)
    {
        $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        //Verify recaptcha v2
        if(!empty($this->super_settings['config_recaptcha_in_admin_login']))
        {
            $recaptcha = $request->get('g-recaptcha-response');
            $secret = $this->super_settings['recaptcha_api_secret'] ?? '';

            $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$recaptcha}");
            $captcha_success = json_decode($verify);
            if ($captcha_success->success == false) {
                return redirect()->back()->withErrors([
                    'key' => 'Invalid captcha',
                ]);
            }
        }

        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                "email" => __("User not found!"),
            ]);
        }

        if (!$user->super_admin) {
            return back()->withErrors([
                "email" => __("Invalid user."),
            ]);
        }

        if (Hash::check($request->password, $user->password)) {
            Auth::login($user, true);
            $request->session()->regenerate();

            return redirect(rtrim(config("app.url"), '/') . "/super-admin/dashboard");
        }

        return back()->withErrors([
            "email" => __("Invalid user."),
        ]);
    }

    public function signupPost(Request $request)
    {
        // Validate based on plan type
        $selectedPlan = SubscriptionPlan::find($request->selected_plan);
        $isContactPlan = $selectedPlan && $selectedPlan->cta_type === 'contact';
        
        $validationRules = [
            "email" => ["required", "email"],
            "first_name" => ["required", "string", "max:255"],
            "surname" => ["required", "string", "max:255"],
            "password" => ["required", "string", "min:8"],
            'selected_plan' => ['required'],
            'user_type' => ['required'],
            'company_name' => ['required', 'string', 'max:255'],
            'industry' => ['required'],
            'current_stage' => ['required'],
            'team_size' => ['required'],
        ];
        
        // Add duration validation for non-contact plans
        if (!$isContactPlan) {
            $validationRules['selected_duration'] = ['required', 'in:monthly,yearly'];
        }
        
        $request->validate($validationRules, [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'first_name.required' => 'First name is required.',
            'surname.required' => 'Surname is required.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'user_type.required' => 'Please select your role.',
            'company_name.required' => 'Company name is required.',
            'industry.required' => 'Please select an industry.',
            'current_stage.required' => 'Please select current stage.',
            'team_size.required' => 'Please select team size.',
            'selected_duration.required' => 'Please select billing duration.',
            'selected_duration.in' => 'Invalid duration selected.',
        ]);
        if(!empty($this->super_settings['config_recaptcha_in_user_signup']))
        {
            $recaptcha = $request->get('g-recaptcha-response');
            $secret = $this->super_settings['recaptcha_api_secret'] ?? '';

            $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$recaptcha}");
            $captcha_success = json_decode($verify);
            if ($captcha_success->success == false) {
                return redirect()->back()->withErrors([
                    'key' => 'Invalid captcha',
                ]);
            }
        }


        $check = User::where("email", $request->email)->first();

        if ($check) {
            return back()->withErrors([
                "email" => "User with this email already exists. Please use a different email or try logging in.",
            ]);
        }

        // Handle flow based on plan type
        if ($isContactPlan) {
            // For contact plans: Save user first, then redirect
            return $this->handleContactPlanRegistration($request, $selectedPlan);
        } else {
            // For paid plans: Process payment first, then save user
            return $this->handlePaidPlanRegistration($request, $selectedPlan);
        }
    }

    private function handleContactPlanRegistration($request, $selectedPlan)
    {
        // Create workspace
        $workspace = new Workspace();
        $workspace->name = $request->first_name . "'s workspace";
        $workspace->plan_id = $selectedPlan->id;
        $workspace->subscribed = false;
        $workspace->active = false;
        $workspace->term = 'custom';
        $workspace->save();

        // Create user
        $user = new User();
        $user->password = Hash::make($request->password);
        $user->first_name = $request->first_name;
        $user->last_name = $request->surname;
        $user->email = $request->email;
        $user->workspace_id = $workspace->id;
        $user->save();

        // Create startup details
        $startupDetail = new StartupDetail();
        $startupDetail->user_id = $user->id;
        $startupDetail->company_name = $request->company_name;
        $startupDetail->industry = $request->industry;
        $startupDetail->current_stage = $request->current_stage;
        $startupDetail->team_size = $request->team_size;
        $startupDetail->save();

        $workspace->owner_id = $user->id;
        $workspace->save();

        // Send welcome email if configured
        if(!empty($this->super_settings['smtp_host'])) {
            try{
                Config::set('mail.mailers.smtp.host',$this->super_settings['smtp_host']);
                Config::set('mail.mailers.smtp.username',$this->super_settings['smtp_username']);
                Config::set('mail.mailers.smtp.password',$this->super_settings['smtp_password']);
                Config::set('mail.mailers.smtp.port',$this->super_settings['smtp_port']);
                Mail::to($user)->send(new WelcomeEmail($user));
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        // Store user info in session for contact page
        session([
            'new_user' => [
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'plan' => $selectedPlan->name,
                'registered' => true
            ]
        ]);
        
        // Show redirect page first, then redirect to external contact page
        return view('auth.contact-redirect');
    }

    private function handlePaidPlanRegistration($request, $selectedPlan)
    {
        // For paid plans, store registration data in session for payment processing
        session([
            'registration_data' => [
                'email' => $request->email,
                'first_name' => $request->first_name,
                'surname' => $request->surname,
                'password' => $request->password,
                'user_type' => $request->user_type,
                'company_name' => $request->company_name,
                'industry' => $request->industry,
                'current_stage' => $request->current_stage,
                'team_size' => $request->team_size,
                'selected_plan' => $request->selected_plan,
                'selected_duration' => $request->selected_duration,
                'plan' => $selectedPlan
            ]
        ]);

        // Set pricing based on duration
        $amount = $request->selected_duration === 'monthly' ? $selectedPlan->price_monthly : $selectedPlan->price_yearly;
        
        // Redirect to payment page
        return redirect('/payment/stripe')->with([
            'plan' => $selectedPlan,
            'amount' => $amount,
            'duration' => $request->selected_duration
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect("/");
    }
}
