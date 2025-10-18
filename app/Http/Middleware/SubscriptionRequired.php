<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Workspace;
use App\Models\SubscriptionPlan;

class SubscriptionRequired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        $workspace = Workspace::find($user->workspace_id);

        // If no workspace exists, redirect to login
        if (!$workspace) {
            return redirect('/login');
        }

        // Define URL patterns that are allowed without subscription
        $allowedPatterns = [
            '/dashboard',           // Main dashboard
            '/billing',             // My Plan (billing page)
            '/settings',            // Settings page
            '/profile',             // Profile page
            '/staff',               // Staff management
            '/new-user',            // Add new user
            '/user-edit/',          // Edit user (with ID)
            '/delete/',             // Delete actions (with action and ID)
        ];

        $currentPath = $request->getPathInfo();

        // Check if current path matches any allowed pattern
        $isAllowedPath = false;
        foreach ($allowedPatterns as $pattern) {
            if (strpos($currentPath, $pattern) === 0) {
                $isAllowedPath = true;
                break;
            }
        }

        // Allow access to permitted paths or if user has active subscription
        if ($isAllowedPath || Workspace::hasActiveSubscription($workspace)) {
            return $next($request);
        }

        // For non-subscribed users, redirect to billing page with message
        return redirect('/billing')->with('warning', __('You need an active subscription to access this feature. Please choose a plan that fits your needs.'));
    }
}
