<?php

return [
    'statuses' => [
        'idea' => [
            'label' => 'Idea',
            'class' => 'info',
            'color' => '#17c1e8'
        ],
        'validation' => [
            'label' => 'Validation',
            'class' => 'warning',
            'color' => '#ffc107'
        ],
        'in_development' => [
            'label' => 'In Development',
            'class' => 'primary',
            'color' => '#0d6efd'
        ],
        'testing' => [
            'label' => 'Testing',
            'class' => 'secondary',
            'color' => '#6c757d'
        ],
        'released' => [
            'label' => 'Released',
            'class' => 'success',
            'color' => '#198754'
        ],
        'archived' => [
            'label' => 'Archived',
            'class' => 'dark',
            'color' => '#212529'
        ]
    ],

    'priorities' => [
        'low' => [
            'label' => 'Low',
            'class' => 'secondary',
            'color' => '#6c757d'
        ],
        'medium' => [
            'label' => 'Medium',
            'class' => 'info',
            'color' => '#17c1e8'
        ],
        'high' => [
            'label' => 'High',
            'class' => 'warning',
            'color' => '#ffc107'
        ],
        'urgent' => [
            'label' => 'Urgent',
            'class' => 'danger',
            'color' => '#dc3545'
        ]
    ],

    'group_types' => [
        'milestone' => [
            'label' => 'Milestone',
            'icon' => 'flag'
        ],
        'feature' => [
            'label' => 'Feature',
            'icon' => 'star'
        ],
        'epic' => [
            'label' => 'Epic',
            'icon' => 'layers'
        ]
    ],

    'views' => [
        'list' => [
            'label' => 'List View',
            'icon' => 'list'
        ],
        'kanban' => [
            'label' => 'Kanban Board',
            'icon' => 'kanban'
        ],
        'timeline' => [
            'label' => 'Timeline',
            'icon' => 'timeline'
        ]
    ],

    'filters' => [
        'status' => [
            'label' => 'Status',
            'type' => 'select',
            'options' => 'statuses'
        ],
        'priority' => [
            'label' => 'Priority',
            'type' => 'select',
            'options' => 'priorities'
        ],
        'product_id' => [
            'label' => 'Product',
            'type' => 'select',
            'options' => 'products'
        ],
        'department_id' => [
            'label' => 'Department',
            'type' => 'select',
            'options' => 'departments'
        ],
        'assigned_to' => [
            'label' => 'Assigned To',
            'type' => 'select',
            'options' => 'users'
        ],
        'group_type' => [
            'label' => 'Group Type',
            'type' => 'select',
            'options' => 'group_types'
        ],
        'due_date' => [
            'label' => 'Due Date',
            'type' => 'date_range'
        ]
    ],

    'sort_options' => [
        'created_at' => 'Date Created',
        'title' => 'Title',
        'status' => 'Status',
        'priority' => 'Priority',
        'due_date' => 'Due Date',
        'progress' => 'Progress'
    ]
];
