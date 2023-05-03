<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\ProjectStatus;
use App\Models\ProposedStatus;
use App\Models\ProspectingStatus;

class ConversationItemController extends Controller
{
    public function validation($request)
    {
        $request->validate([
            'item_type' => ['required', 'in:Prospect,Proposta,Projeto'],
            'interaction_at' => ['required'],
            'schedule_at' => ['nullable'],
            'additive' => ['required', 'in:y,n'],
            'schedule_type' => ['nullable', 'in:internal,external'],
            'cpea_linked_id' => ['nullable', 'string', 'max:255'],
            'schedule_name' => ['nullable', 'string', 'max:255'],
            'addressees' => ['nullable', 'string', 'max:255'],
            'optional_addressees' => ['nullable', 'string', 'max:255'],
            'schedule_details' => ['nullable', 'string', 'max:255'],
            'item_details' => ['nullable', 'string', 'max:255'],
            'conversation_id' => ['required', 'exists:conversations,id'],
            'project_status_id' => ['nullable', 'exists:project_statuses,id'],
            'proposed_status_id' => ['nullable', 'exists:proposed_statuses,id'],
            'prospecting_status_id' => ['nullable', 'exists:prospecting_statuses,id'],
            'detailed_contact_id' => ['required', 'exists:detailed_contacts,id'],
            'organizer_id' => ['required', 'exists:users,id'],
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $conversation = Conversation::findOrFail($id);
        $prospectingStatuses = ProspectingStatus::pluck("name", "id");
        $proposedsStatuses = ProposedStatus::pluck("name", "id");
        $projectStatus = ProjectStatus::pluck("name", "id");
        $detailedContacts = $conversation->customer->detailedContats;
        $products = Product::pluck("name", "id");
        $organizers = User::where("status", "active")->get()->pluck("full_name", "id");

        return view('conversations.item.create', compact('conversation', 'prospectingStatuses', 'proposedsStatuses', 'projectStatus', 'detailedContacts', 'products', 'organizers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);

        $input = $request->all();

        dd($input);

    }
}
