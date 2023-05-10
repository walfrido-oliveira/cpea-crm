<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Direction;
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
            'organizer_id' => ['nullable', 'exists:users,id'],
            'direction_id' => ['nullable', 'exists:directions,id'],
            'employee_id' => ['nullable', 'exists:employees,id'],
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
        $cpeaIds = Conversation::whereNotNull("cpea_id")->pluck("cpea_id");
        $checkproposed = count($conversation->items()->where("item_type", "Prospect")->get()) > 0;
        $checkproject = count($conversation->items()->where("item_type", "Projeto")->get()) > 0;
        $directions = Direction::pluck("name", "id");
        $employees = Employee::pluck("name", "id");

        return view('conversations.item.create', compact('conversation', 'prospectingStatuses', 'proposedsStatuses',
                                                         'projectStatus', 'detailedContacts', 'products', 'organizers',
                                                         'cpeaIds', 'checkproposed', 'checkproject', 'directions', 'employees'));
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
            'cpea_linked_id' => isset($input['cpea_linked_id']) ? $input['cpea_linked_id'] : null,
            'item_details' => $input['item_details'],
            'schedule_type' => $input['schedule_type'],
            'schedule_name' => $input['schedule_name'],
            'schedule_at' => $input['schedule_at'],
            'organizer_id' => $input['organizer_id'],
            'addressees' => $input['addressees'],
            'optional_addressees' => $input['optional_addressees'],
            'schedule_details' => $input['schedule_details'],
            'direction_id' => $input['direction_id'],
            'employee_id' => $input['employee_id'],
            'user_id'=> auth()->user()->id,
        ]);

        $conversationItem->products()->sync($input['products']);

        if($input['schedule_type'] == 'internal') {
            $conversationItem->user->sendScheduleNotification($conversationItem);
        }

        $resp = [
            'message' => __('Interação  Cadastrada com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('customers.conversations.show', ['conversation' => $input['conversation_id']])->with($resp);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conversationItem = ConversationItem::findOrFail($id);
        $conversation = $conversationItem->conversation;
        $prospectingStatuses = ProspectingStatus::pluck("name", "id");
        $proposedsStatuses = ProposedStatus::pluck("name", "id");
        $projectStatus = ProjectStatus::pluck("name", "id");
        $detailedContacts = $conversation->customer->detailedContats->pluck("contact", "id");
        $products = Product::pluck("name", "id");
        $organizers = User::where("status", "active")->get()->pluck("full_name", "id");
        $cpeaIds = Conversation::whereNotNull("cpea_id")->pluck("cpea_id");
        $checkproposed = count($conversation->items()->where("item_type", "Prospect")->get()) > 0;
        $checkproject = count($conversation->items()->where("item_type", "Projeto")->get()) > 0;
        $directions = Direction::pluck("name", "id");
        $employees = Employee::pluck("name", "id");
        $conversationItemProduts = $conversationItem->products()->pluck("products.name", "products.id")->toArray();

        return view('conversations.item.edit', compact('conversation', 'prospectingStatuses', 'proposedsStatuses', 'projectStatus',
                                                       'detailedContacts', 'products', 'organizers', 'conversationItem', 'cpeaIds',
                                                       'checkproposed', 'directions', 'employees', 'conversationItemProduts', 'checkproject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validation($request);

        $conversationItem = ConversationItem::findOrFail($id);

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
            'cpea_linked_id' => isset($input['cpea_linked_id']) ? $input['cpea_linked_id'] : null,
            'item_details' => $input['item_details'],
            'schedule_type' => $input['schedule_type'],
            'schedule_name' => $input['schedule_name'],
            'schedule_at' => $input['schedule_at'],
            'organizer_id' => $input['organizer_id'],
            'addressees' => $input['addressees'],
            'optional_addressees' => $input['optional_addressees'],
            'schedule_details' => $input['schedule_details'],
            'direction_id' => $input['direction_id'],
            'employee_id' => $input['employee_id'],
            'user_id'=> auth()->user()->id,
        ]);

        $conversationItem->products()->sync($input['products']);

        $resp = [
            'message' => __('Interação  Atualizada com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('customers.conversations.show', ['conversation' => $input['conversation_id']])->with($resp);
    }
}
