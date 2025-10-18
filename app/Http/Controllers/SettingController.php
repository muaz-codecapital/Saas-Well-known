<?php

namespace App\Http\Controllers;

use App\Models\Setting;

use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\Workspace;
use Doctrine\Inflector\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SettingController extends BaseController
{
    public function settings(Request $request)
    {
        $workspace = Workspace::find($this->user->workspace_id);
        $available_languages = User::$available_languages;

        return \view("settings.settings", [
            "selected_navigation" => "settings",
            "workspace" => $workspace,
            "available_languages" => $available_languages,
        ]);
    }

    public function settingsPost(Request $request)
    {
        if (config("app.environment") !== "demo") {

            $request->validate([
                "workspace_name" => "required|max:150",
                "logo" => "nullable|file|mimes:jpg,png",
                "favicon" => "nullable|file|mimes:jpg,png",
                'currency' => 'nullable|string|size:3',
                'landingpage' => 'nullable',
                'language' => 'nullable',

            ]);

            $workspace = Workspace::find($this->user->workspace_id);

            $workspace->name = $request->workspace_name;
            $workspace->save();

            Setting::updateSettings($this->workspace->id,'landingpage',$request->landingpage);
            Setting::updateSettings($this->workspace->id,'language',$request->language);

            Setting::updateSettings($this->workspace->id,'currency',$request->currency);
            Setting::updateSettings($this->workspace->id,'custom_script',$request->custom_script);
            Setting::updateSettings($this->workspace->id,'meta_description',$request->meta_description);




            if($request->logo)
            {
                $path = $request->file('logo')->store('media', 'uploads');
                Setting::updateSettings($this->workspace->id,'logo',$path);
            }


            if($request->favicon)
            {
                $path = $request->file('favicon')->store('media', 'uploads');
                Setting::updateSettings($this->workspace->id,'favicon',$path);
            }


            if($this->user->super_admin)
            {
                $free_trial_days = $request->free_trial_days ?? 0;
                Setting::updateSettings($this->workspace->id,'free_trial_days',$free_trial_days);
                return redirect('/super-admin-setting');
            }

            return redirect("/settings");


        }


    }

    public function billing()
    {
        // Load plans with their features to avoid htmlspecialchars error
        $plans = SubscriptionPlan::with('features')->active()->ordered()->get();

        $workspace = Workspace::find($this->user->workspace_id);

        $plan = null;

        if($workspace && Workspace::hasActiveSubscription($workspace))
        {
            $plan = SubscriptionPlan::with('features')->find($workspace->plan_id);
        }

        return \view("settings.billing", [
            "selected_navigation" => "billing",
            "plans" => $plans,
            "plan" => $plan,
            "workspace" => $workspace,
        ]);
    }


    // Activation disabled
//


    public function settingsStore(Request $request, $action)
    {
        switch ($action) {
            case "save-twilio-config":
                $request->validate([
                    "twilio_account_sid" => "required|string",
                    "twilio_api_key" => "required|string",
                    "twilio_api_secret" => "required|string",
                ]);

                Setting::updateSettings(
                    $this->workspace->id,
                    "twilio_account_sid",
                    $request->twilio_account_sid
                );
                Setting::updateSettings(
                    $this->workspace->id,
                    "twilio_api_key",
                    $request->twilio_api_key
                );
                Setting::updateSettings(
                    $this->workspace->id,
                    "twilio_api_secret",
                    $request->twilio_api_secret
                );

                return redirect("/settings");

                break;
            case "save-recaptcha-config":
                $request->validate([
                    "recaptcha_api_key" => "required|string",
                    "recaptcha_api_secret" => "required|string",
                    "config_recaptcha_in_user_login" => "nullable|boolean",
                ]);

                $config_recaptcha_in_user_login = $request->config_recaptcha_in_user_login ? 1 : 0;
                $config_recaptcha_in_admin_login = $request->config_recaptcha_in_admin_login ? 1 : 0;
                $config_recaptcha_in_user_signup = $request->config_recaptcha_in_user_signup ? 1 : 0;

                Setting::updateSettings(
                    $this->workspace->id,
                    "recaptcha_api_key",
                    $request->recaptcha_api_key
                );
                Setting::updateSettings(
                    $this->workspace->id,
                    "recaptcha_api_secret",
                    $request->recaptcha_api_secret
                );
                Setting::updateSettings(
                    $this->workspace->id,
                    "config_recaptcha_in_user_login",
                    $config_recaptcha_in_user_login
                );
                Setting::updateSettings(
                    $this->workspace->id,
                    "config_recaptcha_in_admin_login",
                    $config_recaptcha_in_admin_login
                );
                Setting::updateSettings(
                    $this->workspace->id,
                    "config_recaptcha_in_user_signup",
                    $config_recaptcha_in_user_signup
                );

                return redirect('/super-admin-setting');

                break;

            case "save-openai-config":
                $request->validate([
                    "openai_api_key" => "nullable|string",
                ]);

                Setting::updateSettings(
                    $this->workspace->id,
                    "openai_api_key",
                    $request->openai_api_key
                );


                return redirect('/super-admin-setting');

                break;


        }
    }

}
