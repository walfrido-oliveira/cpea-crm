<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\ProjectStatus;
use App\Models\ProposedStatus;
use App\Models\ConversationItem;
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
        $detailedContacts = $conversation->customer->detailedContats->pluck("contact", "id");
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

        $conversationItem = ConversationItem::create([
            'conversation_id' => $input['conversation_id'],
            'item_type' => $input['item_type'],
            'interaction_at' => $input['interaction_at'],
            'project_status_id' => $input['project_status_id'],
            'proposed_status_id' => $input['proposed_status_id'],
            'prospecting_status_id' => $input['prospecting_status_id'],
            'detailed_contact_id' => $input['detailed_contact_id'],
            'additive' => $input['additive'] == "y" ? true : false,
            'cpea_linked_id' => $input['cpea_linked_id'],
            'item_details' => $input['item_details'],
            'schedule_type' => $input['schedule_type'],
            'schedule_name' => $input['schedule_name'],
            'schedule_at' => $input['schedule_at'],
            'organizer_id' => $input['organizer_id'],
            'addressees' => $input['addressees'],
            'optional_addressees' => $input['optional_addressees'],
            'schedule_details' => $input['schedule_details'],
            'user_id'=> auth()->user()->id,
        ]);

        $conversationItem->products()->sync($input['products']);

        $resp = [
            'message' => __('Interação  Cadastrada com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('customers.conversations.show', ['conversation' => $input['conversation_id']])->with($resp);

    }
}
