<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductPlanning;
use App\Models\User;
use App\Models\Product;
use App\Models\Department;

class ProductPlanningSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        if (!$user) return;

        $workspaceId = $user->workspace_id;

        // Create sample products
        $product1 = Product::create([
            'name' => 'Mobile App',
            'description' => 'Main mobile application',
            'workspace_id' => $workspaceId,
            'created_by' => $user->id,
        ]);

        $product2 = Product::create([
            'name' => 'Web Platform',
            'description' => 'Web-based platform',
            'workspace_id' => $workspaceId,
            'created_by' => $user->id,
        ]);

        // Create sample departments
        $dept1 = Department::create([
            'name' => 'Development',
            'description' => 'Software development team',
            'workspace_id' => $workspaceId,
            'created_by' => $user->id,
        ]);

        $dept2 = Department::create([
            'name' => 'Design',
            'description' => 'UI/UX design team',
            'workspace_id' => $workspaceId,
            'created_by' => $user->id,
        ]);

        // Create sample planning items
        $items = [
            [
                'title' => 'User Authentication System',
                'description' => 'Implement secure user authentication with JWT tokens and OAuth integration',
                'status' => 'in_development',
                'priority' => 'high',
                'product_id' => $product1->id,
                'department_id' => $dept1->id,
                'assigned_to' => $user->id,
                'progress' => 65,
                'start_date' => now()->subDays(10),
                'due_date' => now()->addDays(5),
                'estimated_hours' => 40,
                'tags' => ['backend', 'security', 'authentication']
            ],
            [
                'title' => 'Mobile UI Design',
                'description' => 'Design modern and intuitive mobile interface',
                'status' => 'idea',
                'priority' => 'medium',
                'product_id' => $product1->id,
                'department_id' => $dept2->id,
                'assigned_to' => $user->id,
                'progress' => 0,
                'start_date' => now()->addDays(2),
                'due_date' => now()->addDays(15),
                'estimated_hours' => 25,
                'tags' => ['design', 'mobile', 'ui']
            ],
            [
                'title' => 'API Documentation',
                'description' => 'Create comprehensive API documentation for developers',
                'status' => 'validation',
                'priority' => 'medium',
                'product_id' => $product2->id,
                'department_id' => $dept1->id,
                'assigned_to' => $user->id,
                'progress' => 30,
                'start_date' => now()->subDays(5),
                'due_date' => now()->addDays(10),
                'estimated_hours' => 20,
                'tags' => ['documentation', 'api', 'developer']
            ],
            [
                'title' => 'Database Optimization',
                'description' => 'Optimize database queries and improve performance',
                'status' => 'testing',
                'priority' => 'high',
                'product_id' => $product2->id,
                'department_id' => $dept1->id,
                'assigned_to' => $user->id,
                'progress' => 85,
                'start_date' => now()->subDays(15),
                'due_date' => now()->addDays(2),
                'estimated_hours' => 35,
                'tags' => ['database', 'performance', 'optimization']
            ],
            [
                'title' => 'User Onboarding Flow',
                'description' => 'Design and implement user onboarding experience',
                'status' => 'released',
                'priority' => 'low',
                'product_id' => $product1->id,
                'department_id' => $dept2->id,
                'assigned_to' => $user->id,
                'progress' => 100,
                'start_date' => now()->subDays(30),
                'due_date' => now()->subDays(5),
                'estimated_hours' => 15,
                'tags' => ['onboarding', 'ux', 'completed']
            ],
            [
                'title' => 'Payment Integration',
                'description' => 'Integrate payment gateway for subscription management',
                'status' => 'idea',
                'priority' => 'urgent',
                'product_id' => $product2->id,
                'department_id' => $dept1->id,
                'assigned_to' => $user->id,
                'progress' => 0,
                'start_date' => now()->addDays(1),
                'due_date' => now()->addDays(20),
                'estimated_hours' => 50,
                'tags' => ['payment', 'subscription', 'integration']
            ]
        ];

        foreach ($items as $item) {
            ProductPlanning::create(array_merge($item, [
                'workspace_id' => $workspaceId,
                'created_by' => $user->id,
            ]));
        }

        $this->command->info('Created ' . count($items) . ' product planning items');
    }
}
