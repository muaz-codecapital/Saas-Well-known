<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Reminder;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CrmController extends BaseController
{
    /**
     * Display CRM Dashboard
     */
    public function dashboard(Request $request)
    {
        $workspaceId = $this->user->workspace_id;

        // Get statistics
        $stats = [
            'total_companies' => Company::byWorkspace($workspaceId)->count(),
            'total_contacts' => Contact::byWorkspace($workspaceId)->contacts()->count(),
            'total_leads' => Contact::byWorkspace($workspaceId)->leads()->count(),
            'new_leads' => Contact::byWorkspace($workspaceId)->leads()->byStatus('new')->count(),
            'won_deals' => Contact::byWorkspace($workspaceId)->leads()->byStatus('won')->count(),
            'recent_activities' => Activity::byWorkspace($workspaceId)->recent(7)->count(),
            'upcoming_reminders' => Reminder::byWorkspace($workspaceId)->upcoming()->count(),
            'overdue_reminders' => Reminder::byWorkspace($workspaceId)->overdue()->count(),
        ];

        // Get pipeline data
        $pipelineData = Contact::byWorkspace($workspaceId)
            ->leads()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Get recent activities
        $recentActivities = Activity::byWorkspace($workspaceId)
            ->with(['contact', 'company', 'creator'])
            ->recent(10)
            ->get();

        // Get upcoming reminders
        $upcomingReminders = Reminder::byWorkspace($workspaceId)
            ->with(['contact', 'company', 'assignedUser'])
            ->upcoming()
            ->limit(5)
            ->get();

        return view('crm.dashboard', compact(
            'stats',
            'pipelineData',
            'recentActivities',
            'upcomingReminders'
        ));
    }

    /**
     * Display Contacts/Leads List
     */
    public function contacts(Request $request)
    {
        $workspaceId = $this->user->workspace_id;
        $type = $request->get('type', 'all'); // all, contacts, leads
        $status = $request->get('status');
        $source = $request->get('source');
        $assignedTo = $request->get('assigned_to');
        $companyId = $request->get('company_id');
        $search = $request->get('search');

        $query = Contact::byWorkspace($workspaceId)
            ->with(['company', 'assignedUser', 'creator']);

        // Apply filters
        if ($type === 'contacts') {
            $query->contacts();
        } elseif ($type === 'leads') {
            $query->leads();
        }

        if ($status) {
            $query->byStatus($status);
        }

        if ($source) {
            $query->where('source', $source);
        }

        if ($assignedTo) {
            $query->byAssignedUser($assignedTo);
        }

        if ($companyId) {
            $query->byCompany($companyId);
        }

        if ($search) {
            $query->search($search);
        }

        $contacts = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get filter options
        $companies = Company::byWorkspace($workspaceId)->orderBy('name')->get();
        $users = User::where('workspace_id', $workspaceId)->get();
        
        // Get CRM configuration data
        $pipelineStatuses = config('crm.pipeline_statuses');
        $leadSources = config('crm.lead_sources');
        $priorities = config('crm.priorities');

        return view('crm.contacts.list', compact(
            'contacts',
            'companies',
            'users',
            'type',
            'status',
            'source',
            'assignedTo',
            'companyId',
            'search',
            'pipelineStatuses',
            'leadSources',
            'priorities'
        ));
    }

    /**
     * Display Contacts/Leads Kanban
     */
    public function contactsKanban(Request $request)
    {
        $workspaceId = $this->user->workspace_id;
        $source = $request->get('source');
        $assignedTo = $request->get('assigned_to');
        $companyId = $request->get('company_id');
        $search = $request->get('search');

        // Get leads only for kanban (pipeline view)
        $query = Contact::byWorkspace($workspaceId)
            ->leads()
            ->with(['company', 'assignedUser', 'creator', 'activities']);

        // Apply filters
        if ($source) {
            $query->where('source', $source);
        }

        if ($assignedTo) {
            $query->byAssignedUser($assignedTo);
        }

        if ($companyId) {
            $query->byCompany($companyId);
        }

        if ($search) {
            $query->search($search);
        }

        $leads = $query->get();

        // Get filter options
        $companies = Company::byWorkspace($workspaceId)->orderBy('name')->get();
        $users = User::where('workspace_id', $workspaceId)->get();
        
        // Get CRM configuration data
        $pipelineStatuses = config('crm.pipeline_statuses');
        $leadSources = config('crm.lead_sources');
        $priorities = config('crm.priorities');

        return view('crm.contacts.kanban', compact(
            'leads',
            'companies',
            'users',
            'source',
            'assignedTo',
            'companyId',
            'search',
            'pipelineStatuses',
            'leadSources',
            'priorities'
        ));
    }

    /**
     * Display Companies List
     */
    public function companies(Request $request)
    {
        $workspaceId = $this->user->workspace_id;
        $industry = $request->get('industry');
        $search = $request->get('search');

        $query = Company::byWorkspace($workspaceId)->with(['creator']);

        if ($industry) {
            $query->byIndustry($industry);
        }

        if ($search) {
            $query->search($search);
        }

        $companies = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('crm.companies.list', compact('companies', 'industry', 'search'));
    }

    /**
     * Display Activities List
     */
    public function activities(Request $request)
    {
        $workspaceId = $this->user->workspace_id;
        $type = $request->get('type');
        $status = $request->get('status');
        $contactId = $request->get('contact_id');
        $companyId = $request->get('company_id');

        $query = Activity::byWorkspace($workspaceId)
            ->with(['contact', 'company', 'creator', 'task']);

        if ($type) {
            $query->byType($type);
        }

        if ($status) {
            $query->byStatus($status);
        }

        if ($contactId) {
            $query->byContact($contactId);
        }

        if ($companyId) {
            $query->byCompany($companyId);
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get filter options
        $contacts = Contact::byWorkspace($workspaceId)->orderBy('first_name')->get();
        $companies = Company::byWorkspace($workspaceId)->orderBy('name')->get();
        
        // Get CRM configuration data
        $activityTypes = config('crm.activity_types');
        $pipelineStatuses = config('crm.pipeline_statuses');

        return view('crm.activities.list', compact(
            'activities',
            'contacts',
            'companies',
            'type',
            'status',
            'contactId',
            'companyId',
            'activityTypes',
            'pipelineStatuses'
        ));
    }

    /**
     * Display Reminders List
     */
    public function reminders(Request $request)
    {
        $workspaceId = $this->user->workspace_id;
        $status = $request->get('status', 'pending');
        $type = $request->get('type');
        $assignedTo = $request->get('assigned_to');

        $query = Reminder::byWorkspace($workspaceId)
            ->with(['contact', 'company', 'assignedUser', 'creator']);

        if ($status) {
            $query->byStatus($status);
        }

        if ($type) {
            $query->byType($type);
        }

        if ($assignedTo) {
            $query->byAssignedUser($assignedTo);
        }

        $reminders = $query->orderBy('remind_at')->paginate(20);

        // Get filter options
        $contacts = Contact::byWorkspace($workspaceId)->orderBy('first_name')->get();
        $companies = Company::byWorkspace($workspaceId)->orderBy('name')->get();
        $users = User::where('workspace_id', $workspaceId)->get();
        
        // Get CRM configuration data
        $activityTypes = config('crm.activity_types');
        $priorities = config('crm.priorities');

        return view('crm.reminders.list', compact(
            'reminders',
            'contacts',
            'companies',
            'users',
            'status',
            'type',
            'assignedTo',
            'activityTypes',
            'priorities'
        ));
    }

    /**
     * Show Contact/Lead Details
     */
    public function contactShow($id)
    {
        $contact = Contact::byWorkspace($this->user->workspace_id)
            ->with(['company', 'assignedUser', 'creator', 'activities', 'reminders', 'tasks'])
            ->findOrFail($id);

        $activities = $contact->activities()
            ->with(['creator'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('crm.contacts.show', compact('contact', 'activities'));
    }

    /**
     * Show Company Details
     */
    public function companyShow($id)
    {
        $company = Company::byWorkspace($this->user->workspace_id)
            ->with(['creator', 'contacts', 'activities', 'reminders'])
            ->findOrFail($id);

        $contacts = $company->contacts()->orderBy('first_name')->get();
        $recentActivities = $company->activities()
            ->with(['contact', 'creator'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('crm.companies.show', compact('company', 'contacts', 'recentActivities'));
    }

    /**
     * Edit Company Form
     */
    public function companyEdit($id)
    {
        $company = Company::byWorkspace($this->user->workspace_id)->findOrFail($id);
        
        // Get CRM configuration data
        $companySizes = config('crm.company_sizes');
        $industries = config('crm.industries');
        $currencies = config('crm.currencies');
        $defaultCurrency = config('crm.default_currency');

        return view('crm.companies.edit', compact('company', 'companySizes', 'industries', 'currencies', 'defaultCurrency'));
    }

    /**
     * Update Company
     */
    public function companyUpdate(Request $request, $id)
    {
        $company = Company::byWorkspace($this->user->workspace_id)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'annual_revenue' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        $company->update([
            'name' => $request->name,
            'industry' => $request->industry,
            'company_size' => $request->company_size,
            'website' => $request->website,
            'email' => $request->email,
            'phone' => $request->phone,
            'annual_revenue' => $request->annual_revenue,
            'currency' => $request->currency,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
            'description' => $request->description,
            'updated_by' => $this->user->id,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Company updated successfully!',
                'company' => $company->fresh()
            ]);
        }

        return redirect()->route('admin.crm.companies.show', $company->id)
            ->with('success', 'Company updated successfully!');
    }

    /**
     * Create Contact Form
     */
    public function contactCreate()
    {
        $companies = Company::byWorkspace($this->user->workspace_id)->orderBy('name')->get();
        $users = User::where('workspace_id', $this->user->workspace_id)->get();
        
        // Get CRM configuration data
        $pipelineStatuses = config('crm.pipeline_statuses');
        $leadSources = config('crm.lead_sources');
        $priorities = config('crm.priorities');

        return view('crm.contacts.create', compact('companies', 'users', 'pipelineStatuses', 'leadSources', 'priorities'));
    }

    /**
     * Create Company Form
     */
    public function companyCreate()
    {
        return view('crm.companies.create');
    }

    /**
     * Create Activity Form
     */
    public function activityCreate(Request $request)
    {
        $contactId = $request->get('contact_id');
        $companyId = $request->get('company_id');

        $contacts = Contact::byWorkspace($this->user->workspace_id)->orderBy('first_name')->get();
        $companies = Company::byWorkspace($this->user->workspace_id)->orderBy('name')->get();
        
        // Get CRM configuration data
        $activityTypes = config('crm.activity_types');

        return view('crm.activities.create', compact('contacts', 'companies', 'contactId', 'companyId', 'activityTypes'));
    }

    /**
     * Create Reminder Form
     */
    public function reminderCreate(Request $request)
    {
        $contactId = $request->get('contact_id');
        $companyId = $request->get('company_id');

        $contacts = Contact::byWorkspace($this->user->workspace_id)->orderBy('first_name')->get();
        $companies = Company::byWorkspace($this->user->workspace_id)->orderBy('name')->get();
        $users = User::where('workspace_id', $this->user->workspace_id)->get();
        
        // Get CRM configuration data
        $activityTypes = config('crm.activity_types');
        $priorities = config('crm.priorities');

        return view('crm.reminders.create', compact('contacts', 'companies', 'users', 'contactId', 'companyId', 'activityTypes', 'priorities'));
    }

    /**
     * Store Contact
     */
    public function contactStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'nullable|email|unique:contacts,email',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'company_id' => 'nullable|exists:companies,id',
            'job_title' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'type' => 'required|in:contact,lead',
            'status' => 'required|string',
            'source' => 'nullable|string',
            'lead_value' => 'nullable|numeric|min:0',
            'expected_close_date' => 'nullable|date',
            'priority' => 'required|integer|min:1|max:5',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'zip_code' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $contact = Contact::create([
                'workspace_id' => $this->user->workspace_id,
                'company_id' => $request->company_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'job_title' => $request->job_title,
                'department' => $request->department,
                'type' => $request->type,
                'status' => $request->status,
                'source' => $request->source,
                'notes' => $request->notes,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'zip_code' => $request->zip_code,
                'lead_value' => $request->lead_value,
                'expected_close_date' => $request->expected_close_date,
                'priority' => $request->priority,
                'assigned_to' => $request->assigned_to,
                'created_by' => $this->user->id,
            ]);

            // Create initial activity if this is a new lead
            if ($request->type === 'lead') {
                Activity::create([
                    'workspace_id' => $this->user->workspace_id,
                    'contact_id' => $contact->id,
                    'company_id' => $request->company_id,
                    'created_by' => $this->user->id,
                    'type' => 'note',
                    'subject' => 'Lead Created',
                    'description' => 'Lead created in CRM system',
                    'status' => 'completed',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ucfirst($request->type) . ' created successfully',
                'contact' => $contact->load(['company', 'assignedUser'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create ' . $request->type . ': ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store Company
     */
    public function companyStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'industry' => 'nullable|string',
            'company_size' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'annual_revenue' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $company = Company::create([
                'workspace_id' => $this->user->workspace_id,
                'name' => $request->name,
                'description' => $request->description,
                'website' => $request->website,
                'industry' => $request->industry,
                'company_size' => $request->company_size,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'zip_code' => $request->zip_code,
                'phone' => $request->phone,
                'email' => $request->email,
                'annual_revenue' => $request->annual_revenue,
                'currency' => $request->currency ?? 'USD',
                'created_by' => $this->user->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Company created successfully',
                'company' => $company
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create company: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store Activity
     */
    public function activityStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_id' => 'required|exists:contacts,id',
            'company_id' => 'nullable|exists:companies,id',
            'type' => 'required|string',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:completed,scheduled,cancelled,no_show',
            'scheduled_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
            'duration_minutes' => 'nullable|integer|min:1',
            'location' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $contact = Contact::find($request->contact_id);

            $activity = Activity::create([
                'workspace_id' => $this->user->workspace_id,
                'contact_id' => $request->contact_id,
                'company_id' => $request->company_id ?: $contact->company_id,
                'created_by' => $this->user->id,
                'type' => $request->type,
                'subject' => $request->subject,
                'description' => $request->description,
                'notes' => $request->notes,
                'status' => $request->status,
                'scheduled_at' => $request->scheduled_at,
                'completed_at' => $request->completed_at,
                'duration_minutes' => $request->duration_minutes,
                'location' => $request->location,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Activity logged successfully',
                'activity' => $activity->load(['contact', 'company', 'creator'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to log activity: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store Reminder
     */
    public function reminderStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_id' => 'nullable|exists:contacts,id',
            'company_id' => 'nullable|exists:companies,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'remind_at' => 'required|date',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'is_recurring' => 'nullable|boolean',
            'recurrence_type' => 'nullable|in:daily,weekly,monthly,yearly',
            'recurrence_interval' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $reminder = Reminder::create([
                'workspace_id' => $this->user->workspace_id,
                'contact_id' => $request->contact_id,
                'company_id' => $request->company_id,
                'created_by' => $this->user->id,
                'assigned_to' => $request->assigned_to,
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'remind_at' => $request->remind_at,
                'priority' => $request->priority,
                'is_recurring' => $request->is_recurring ?? false,
                'recurrence_type' => $request->recurrence_type,
                'recurrence_interval' => $request->recurrence_interval ?? 1,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reminder created successfully',
                'reminder' => $reminder->load(['contact', 'company', 'assignedUser'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create reminder: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update Contact Status (AJAX)
     */
    public function updateContactStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $contact = Contact::byWorkspace($this->user->workspace_id)->findOrFail($id);
            $oldStatus = $contact->status;

            $contact->update([
                'status' => $request->status,
                'updated_by' => $this->user->id,
            ]);

            // Log status change as activity
            Activity::create([
                'workspace_id' => $this->user->workspace_id,
                'contact_id' => $contact->id,
                'company_id' => $contact->company_id,
                'created_by' => $this->user->id,
                'type' => 'note',
                'subject' => 'Status Updated',
                'description' => "Status changed from {$oldStatus} to {$request->status}",
                'status' => 'completed',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Contact status updated successfully',
                'contact' => $contact->load(['company', 'assignedUser'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update contact status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update Reminder Status (AJAX)
     */
    public function updateReminderStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:completed,cancelled',
            'completion_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $reminder = Reminder::byWorkspace($this->user->workspace_id)->findOrFail($id);

            $reminder->update([
                'status' => $request->status,
                'completed_at' => $request->status === 'completed' ? now() : null,
                'completion_notes' => $request->completion_notes,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reminder status updated successfully',
                'reminder' => $reminder->load(['contact', 'company', 'assignedUser'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update reminder status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Contact JSON (AJAX)
     */
    public function getContact($id)
    {
        try {
            $contact = Contact::byWorkspace($this->user->workspace_id)
                ->with(['company', 'assignedUser', 'creator', 'activities', 'reminders'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'contact' => $contact
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Contact not found'
            ], 404);
        }
    }

    /**
     * Get Company JSON (AJAX)
     */
    public function getCompany($id)
    {
        try {
            $company = Company::byWorkspace($this->user->workspace_id)
                ->with(['contacts', 'activities', 'reminders'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'company' => $company
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Company not found'
            ], 404);
        }
    }

    /**
     * Search Companies (AJAX)
     */
    public function searchCompanies(Request $request)
    {
        $search = $request->get('search', '');
        $limit = $request->get('limit', 10);

        $companies = Company::byWorkspace($this->user->workspace_id)
            ->search($search)
            ->limit($limit)
            ->get(['id', 'name', 'email', 'phone']);

        return response()->json([
            'success' => true,
            'companies' => $companies
        ]);
    }

    /**
     * Search Contacts (AJAX)
     */
    public function searchContacts(Request $request)
    {
        $search = $request->get('search', '');
        $type = $request->get('type', 'all');
        $limit = $request->get('limit', 10);

        $query = Contact::byWorkspace($this->user->workspace_id)
            ->with(['company']);

        if ($type !== 'all') {
            $query->byType($type);
        }

        $contacts = $query->search($search)
            ->limit($limit)
            ->get(['id', 'first_name', 'last_name', 'email', 'phone', 'company_id', 'type']);

        return response()->json([
            'success' => true,
            'contacts' => $contacts
        ]);
    }

    /**
     * Bulk Update Contact Status (AJAX)
     */
    public function bulkUpdateContactStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'integer|exists:contacts,id',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $contacts = Contact::byWorkspace($this->user->workspace_id)
                ->whereIn('id', $request->contact_ids)
                ->get();

            foreach ($contacts as $contact) {
                $oldStatus = $contact->status;
                $contact->update([
                    'status' => $request->status,
                    'updated_by' => $this->user->id,
                ]);

                // Log status change as activity
                Activity::create([
                    'workspace_id' => $this->user->workspace_id,
                    'contact_id' => $contact->id,
                    'company_id' => $contact->company_id,
                    'created_by' => $this->user->id,
                    'type' => 'note',
                    'subject' => 'Status Updated (Bulk)',
                    'description' => "Status changed from {$oldStatus} to {$request->status}",
                    'status' => 'completed',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Contact statuses updated successfully',
                'updated_count' => $contacts->count()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update contact statuses: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Contact (AJAX)
     */
    public function deleteContact($id)
    {
        try {
            $contact = Contact::byWorkspace($this->user->workspace_id)->findOrFail($id);

            // Check if contact has related activities or reminders
            $hasActivities = $contact->activities()->count() > 0;
            $hasReminders = $contact->reminders()->count() > 0;
            $hasTasks = $contact->tasks()->count() > 0;

            if ($hasActivities || $hasReminders || $hasTasks) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete contact with related activities, reminders, or tasks. Please archive instead.'
                ], 422);
            }

            $contact->delete();

            return response()->json([
                'success' => true,
                'message' => 'Contact deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete contact: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Company (AJAX)
     */
    public function deleteCompany($id)
    {
        try {
            $company = Company::byWorkspace($this->user->workspace_id)->findOrFail($id);

            // Check if company has related contacts, activities, or reminders
            $hasContacts = $company->contacts()->count() > 0;
            $hasActivities = $company->activities()->count() > 0;
            $hasReminders = $company->reminders()->count() > 0;

            if ($hasContacts || $hasActivities || $hasReminders) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete company with related contacts, activities, or reminders. Please archive instead.'
                ], 422);
            }

            $company->delete();

            return response()->json([
                'success' => true,
                'message' => 'Company deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete company: ' . $e->getMessage()
            ], 500);
        }
    }
}
