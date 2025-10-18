<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    public static function getMaximumAllowedUsers($workspace)
    {
        if(Workspace::hasActiveSubscription($workspace) && $workspace->plan_id)
        {
            $plan = SubscriptionPlan::find($workspace->plan_id);

            if($plan)
            {
                return $plan->maximum_allowed_users;
            }
        }
        return null;
    }

    public static function getPlan($workspace)
    {
        if(Workspace::hasActiveSubscription($workspace) && $workspace->plan_id)
        {
            return SubscriptionPlan::find($workspace->plan_id);
        }
        return null;
    }

    public static function usersCount($workspace_id)
    {
        return User::where('workspace_id',$workspace_id)->count();
    }

    /**
     * Check if workspace has an active subscription
     * @return bool
     */
    public function isActiveSubscription()
    {
        // Must be active workspace
        if (!$this->active) {
            return false;
        }

        // Must be subscribed
        if (!$this->subscribed) {
            return false;
        }

        // Must have subscription start date
        if (!$this->subscription_start_date) {
            return false;
        }

        // Must have next renewal date
        if (!$this->next_renewal_date) {
            return false;
        }

        // Subscription start date must be in the past or today
        $startDate = \Carbon\Carbon::parse($this->subscription_start_date);
        if ($startDate->isFuture()) {
            return false;
        }

        // Next renewal date must be in the future
        $renewalDate = \Carbon\Carbon::parse($this->next_renewal_date);
        if ($renewalDate->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Check if a user/workspace has an active subscription
     * @param mixed $workspace Workspace instance or workspace ID
     * @return bool
     */
    public static function hasActiveSubscription($workspace)
    {
        if (!$workspace) {
            return false;
        }

        if (is_numeric($workspace)) {
            $workspace = self::find($workspace);
        }

        if (!$workspace || !$workspace instanceof self) {
            return false;
        }

        return $workspace->isActiveSubscription();
    }

    /**
     * Get subscription status with details
     * @return array
     */
    public function getSubscriptionStatus()
    {
        $isActive = $this->isActiveSubscription();

        $status = [
            'is_active' => $isActive,
            'workspace_active' => (bool) $this->active,
            'workspace_subscribed' => (bool) $this->subscribed,
            'has_start_date' => !is_null($this->subscription_start_date),
            'has_renewal_date' => !is_null($this->next_renewal_date),
            'start_date' => $this->subscription_start_date,
            'renewal_date' => $this->next_renewal_date,
        ];

        if ($isActive) {
            $status['message'] = 'Active subscription';
        } elseif (!$this->active) {
            $status['message'] = 'Workspace is inactive';
        } elseif (!$this->subscribed) {
            $status['message'] = 'No active subscription';
        } elseif (!$this->subscription_start_date) {
            $status['message'] = 'Subscription not started';
        } elseif (!$this->next_renewal_date) {
            $status['message'] = 'No renewal date set';
        } else {
            $status['message'] = 'Subscription expired';
        }

        return $status;
    }

}
