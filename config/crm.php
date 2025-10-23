<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CRM Pipeline Statuses
    |--------------------------------------------------------------------------
    |
    | Define the various stages in your sales pipeline. These statuses will
    | be used for leads and determine the visual representation in the kanban board.
    |
    */

    'pipeline_statuses' => [
        'new' => [
            'label' => 'New',
            'class' => 'secondary',
            'color' => '#8392ab',
            'icon' => 'plus-circle',
            'description' => 'Fresh leads that need initial contact'
        ],
        'contacted' => [
            'label' => 'Contacted',
            'class' => 'info',
            'color' => '#17c1e8',
            'icon' => 'phone',
            'description' => 'Initial contact has been made'
        ],
        'qualified' => [
            'label' => 'Qualified',
            'class' => 'primary',
            'color' => '#667eea',
            'icon' => 'check-circle',
            'description' => 'Lead has been qualified and shows interest'
        ],
        'proposal' => [
            'label' => 'Proposal',
            'class' => 'warning',
            'color' => '#fbcf33',
            'icon' => 'file-text',
            'description' => 'Proposal or quote has been sent'
        ],
        'won' => [
            'label' => 'Won',
            'class' => 'success',
            'color' => '#11998e',
            'icon' => 'trophy',
            'description' => 'Deal has been closed successfully'
        ],
        'lost' => [
            'label' => 'Lost',
            'class' => 'danger',
            'color' => '#ea0606',
            'icon' => 'times-circle',
            'description' => 'Deal has been lost or declined'
        ],
        'nurturing' => [
            'label' => 'Nurturing',
            'class' => 'info',
            'color' => '#38ef7d',
            'icon' => 'seedling',
            'description' => 'Lead is being nurtured for future opportunities'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Lead Sources
    |--------------------------------------------------------------------------
    |
    | Define where your leads come from. This helps track marketing effectiveness
    | and understand which channels are most successful.
    |
    */

    'lead_sources' => [
        'website' => [
            'label' => 'Website',
            'icon' => 'globe',
            'color' => '#667eea'
        ],
        'referral' => [
            'label' => 'Referral',
            'icon' => 'users',
            'color' => '#11998e'
        ],
        'social_media' => [
            'label' => 'Social Media',
            'icon' => 'share-alt',
            'color' => '#fbcf33'
        ],
        'email' => [
            'label' => 'Email',
            'icon' => 'envelope',
            'color' => '#17c1e8'
        ],
        'phone' => [
            'label' => 'Phone',
            'icon' => 'phone',
            'color' => '#ea0606'
        ],
        'event' => [
            'label' => 'Event',
            'icon' => 'calendar-alt',
            'color' => '#764ba2'
        ],
        'advertising' => [
            'label' => 'Advertising',
            'icon' => 'bullhorn',
            'color' => '#38ef7d'
        ],
        'other' => [
            'label' => 'Other',
            'icon' => 'question-circle',
            'color' => '#8392ab'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Activity Types
    |--------------------------------------------------------------------------
    |
    | Define the different types of activities that can be logged for contacts.
    | These will be used for activity tracking and follow-ups.
    |
    */

    'activity_types' => [
        'call' => [
            'label' => 'Call',
            'icon' => 'phone',
            'color' => '#17c1e8'
        ],
        'email' => [
            'label' => 'Email',
            'icon' => 'envelope',
            'color' => '#667eea'
        ],
        'meeting' => [
            'label' => 'Meeting',
            'icon' => 'handshake',
            'color' => '#11998e'
        ],
        'note' => [
            'label' => 'Note',
            'icon' => 'sticky-note',
            'color' => '#fbcf33'
        ],
        'task' => [
            'label' => 'Task',
            'icon' => 'tasks',
            'color' => '#764ba2'
        ],
        'demo' => [
            'label' => 'Demo',
            'icon' => 'desktop',
            'color' => '#38ef7d'
        ],
        'proposal' => [
            'label' => 'Proposal',
            'icon' => 'file-text',
            'color' => '#ea0606'
        ],
        'contract' => [
            'label' => 'Contract',
            'icon' => 'file-signature',
            'color' => '#8392ab'
        ],
        'other' => [
            'label' => 'Other',
            'icon' => 'circle',
            'color' => '#8392ab'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Priorities
    |--------------------------------------------------------------------------
    |
    | Define priority levels for leads, activities, and reminders.
    | This helps prioritize work and manage urgency.
    |
    */

    'priorities' => [
        'low' => [
            'label' => 'Low',
            'class' => 'secondary',
            'color' => '#8392ab'
        ],
        'medium' => [
            'label' => 'Medium',
            'class' => 'info',
            'color' => '#17c1e8'
        ],
        'high' => [
            'label' => 'High',
            'class' => 'warning',
            'color' => '#fbcf33'
        ],
        'urgent' => [
            'label' => 'Urgent',
            'class' => 'danger',
            'color' => '#ea0606'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Company Sizes
    |--------------------------------------------------------------------------
    |
    | Define standard company size categories for lead qualification
    | and market segmentation.
    |
    */

    'company_sizes' => [
        '1-10' => '1-10 employees',
        '11-50' => '11-50 employees',
        '51-200' => '51-200 employees',
        '201-500' => '201-500 employees',
        '500+' => '500+ employees',
    ],

    /*
    |--------------------------------------------------------------------------
    | Industries
    |--------------------------------------------------------------------------
    |
    | Common industry categories for company classification.
    | Add or modify based on your target market.
    |
    */

    'industries' => [
        'technology' => 'Technology',
        'healthcare' => 'Healthcare',
        'finance' => 'Finance',
        'education' => 'Education',
        'retail' => 'Retail',
        'manufacturing' => 'Manufacturing',
        'real_estate' => 'Real Estate',
        'consulting' => 'Consulting',
        'media' => 'Media & Entertainment',
        'nonprofit' => 'Non-profit',
        'government' => 'Government',
        'other' => 'Other',
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    |
    | Default currency and supported currencies for lead values
    | and company revenue tracking.
    |
    */

    'currencies' => [
        'USD' => ['name' => 'US Dollar', 'symbol' => '$'],
        'EUR' => ['name' => 'Euro', 'symbol' => '€'],
        'GBP' => ['name' => 'British Pound', 'symbol' => '£'],
        'JPY' => ['name' => 'Japanese Yen', 'symbol' => '¥'],
        'CAD' => ['name' => 'Canadian Dollar', 'symbol' => 'C$'],
        'AUD' => ['name' => 'Australian Dollar', 'symbol' => 'A$'],
    ],

    'default_currency' => 'USD',

    /*
    |--------------------------------------------------------------------------
    | Reminder Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for reminder notifications and default settings.
    |
    */

    'reminder_defaults' => [
        'advance_notice_hours' => 24, // Hours before reminder to send notification
        'max_overdue_days' => 7, // Days after due date to consider overdue
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for CRM dashboard widgets and metrics.
    |
    */

    'dashboard_widgets' => [
        'pipeline_overview' => [
            'enabled' => true,
            'title' => 'Pipeline Overview',
            'description' => 'Current status of all leads in the pipeline'
        ],
        'recent_activities' => [
            'enabled' => true,
            'title' => 'Recent Activities',
            'description' => 'Latest interactions with leads and contacts'
        ],
        'upcoming_reminders' => [
            'enabled' => true,
            'title' => 'Upcoming Reminders',
            'description' => 'Tasks and follow-ups due soon'
        ],
        'conversion_metrics' => [
            'enabled' => true,
            'title' => 'Conversion Metrics',
            'description' => 'Lead to customer conversion rates'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Integration Settings
    |--------------------------------------------------------------------------
    |
    | Settings for integrating CRM with other modules like tasks and calendar.
    |
    */

    'integrations' => [
        'tasks' => [
            'enabled' => true,
            'auto_create_task_on_lead' => false,
            'default_task_status' => 'to_do',
            'default_task_priority' => 'medium',
        ],
        'calendar' => [
            'enabled' => true,
            'auto_sync_activities' => true,
            'auto_sync_reminders' => true,
        ],
        'notifications' => [
            'email_enabled' => true,
            'sms_enabled' => false,
            'push_enabled' => true,
        ],
    ],
];
