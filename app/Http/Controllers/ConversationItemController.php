<?php

namespace App\Http\Controllers;

use App\Models\Cnpj;
use App\Models\User;
use App\Models\Etapa;
use App\Models\Value;
use App\Models\Product;
use App\Models\Direction;
use App\Models\Attachment;
use App\Models\Department;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\ScheduleAddress;
use App\Models\ConversationItem;
use App\Models\ConversationStatus;
use App\Models\CpeaId;
use App\Models\Customer;
use App\Models\Employee;

class ConversationItemController extends Controller
{
  public function __construct()
  {
    $this->middleware('role:admin')->only(['create', 'edit', 'store', 'update', 'fasterCreate']);
    $this->middleware('role:admin|viewer')->only(['show']);
  }

  public function validation($request)
  {
    $request->validate([
      'item_type' => ['required', 'in:Prospect,Proposta,Projeto'],
      'interaction_at' => ['required'],
      'schedule_at' => ['nullable'],
      'additive' => ['nullable', 'in:y,n'],
      'schedule_type' => ['nullable', 'in:internal,external'],
      'cpea_linked_id' => ['nullable', 'string', 'max:255'],
      'schedule_name' => ['nullable', 'string', 'max:255'],
      'schedule_details' => ['nullable', 'string'],
      'item_details' => ['nullable', 'string'],
      //'conversation_id' => ['required', 'exists:conversations,id'],
      'conversation_status_id' => ['nullable', 'exists:conversation_statuses,id'],
      'detailed_contact_id' => ['required', 'exists:detailed_contacts,id'],
      'organizer_id' => ['nullable', 'exists:users,id'],
      'direction_id' => ['nullable', 'exists:directions,id'],
      'employee_id' => ['nullable', 'exists:employees,id'],
      'department_id' => ['nullable', 'exists:departments,id'],
      'cnpj_id' => ['nullable', 'exists:cnpjs,id'],
      'etapa_id' => ['nullable', 'exists:etapas,id'],
      'ppi' => ['nullable', 'in:y,n'],
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
    $conversationStatuses = ConversationStatus::pluck("name", "id");
    $detailedContacts = $conversation->customer->detailedContats->pluck("contact", "id");
    $products = Product::pluck("name", "id");
    $organizers = User::where("status", "active")->get()->pluck("full_name", "id");
    $cpeaIds = Conversation::whereNotNull("cpea_id")->pluck("cpea_id");
    $cnpjs = Cnpj::all()->pluck("display_name", "id");
    $etapas = Etapa::pluck("name", "id");
    $employees = Employee::where("status", "active")->get()->pluck("name", "id");
    $directions = Direction::pluck("name", "id");
    $departments = Department::all()->pluck('name', 'id');
    $probabilities = ConversationItem::probabilities();

    return view('conversations.item.create', compact(
      'conversation',
      'conversationStatuses',
      'detailedContacts',
      'products',
      'organizers',
      'cpeaIds',
      'directions',
      'departments',
      'cnpjs',
      'etapas',
      'employees',
      'probabilities'
    ));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function fasterCreate(Request $request)
  {
    $conversationStatuses = ConversationStatus::pluck("name", "id");
    $products = Product::pluck("name", "id");
    $organizers = User::where("status", "active")->get()->pluck("full_name", "id");
    $cpeaIds = Conversation::whereNotNull("cpea_id")->pluck("cpea_id");
    $cnpjs = Cnpj::all()->pluck("display_name", "id");
    $etapas = Etapa::pluck("name", "id");
    $employees = Employee::where("status", "active")->get()->pluck("name", "id");
    $directions = Direction::pluck("name", "id");
    $departments = Department::all()->pluck('name', 'id');
    $probabilities = ConversationItem::probabilities();
    $customers = Customer::where("status", "active")->pluck("name", "id");

    return view('conversations.item.faster-create', compact(
      'conversationStatuses',
      'products',
      'organizers',
      'cpeaIds',
      'directions',
      'departments',
      'cnpjs',
      'etapas',
      'employees',
      'probabilities',
      'customers'
    ));
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

    if(!$input['conversation_id']) {
      if(isset($input['customer_value'])) {
        $conversation = Conversation::create([
          'customer_id' => $input['customer_value']
        ]);
        $input['conversation_id'] = $conversation->id;
      }
    } else {
      $conversation = Conversation::findOrFail($input['conversation_id']);
    }

    $conversationItem = ConversationItem::create([
      'conversation_id' => $input['conversation_id'],
      'item_type' => $input['item_type'],
      'interaction_at' => $input['interaction_at'],
      'conversation_status_id' => $input['conversation_status_id'],
      'detailed_contact_id' => $input['detailed_contact_id'],
      'additive' => $input['additive'] == "y" ? true : false,
      'cpea_linked_id' => isset($input['cpea_linked_id']) ? $input['cpea_linked_id'] : null,
      'item_details' => $input['item_details'],
      'schedule_type' => $input['schedule_type'],
      'schedule_name' => $input['schedule_name'],
      'schedule_at' => $input['schedule_at'],
      'schedule_end' => $input['schedule_end'],
      'organizer_id' => $input['organizer_id'],
      'schedule_details' => $input['schedule_details'],
      'direction_id' => $input['direction_id'],
      'employee_id' => isset($input['employee_id']) ? $input['employee_id'] : null,
      'department_id' => isset($input['department_id']) ? $input['department_id'] : null,
      'meeting_form' => $input['meeting_form'],
      'meeting_place' => $input['meeting_place'],
      'user_id' => auth()->user()->id,
      'order' => count($conversation->items) + 1,
      'cnpj_id' => $input['cnpj_id'],
      'etapa_id' => $input['etapa_id'],
      'ppi' => $input['ppi'],
      'state' => $input['state'],
      'city' => $input['city'],
      'probability' => $input['probability'],
    ]);

    if ($input['item_type'] == "Proposta" && !$conversation->cpea_id) {
      $cpeaId = CpeaId::create();
      $conversation->cpea_id = $cpeaId->id;
      $conversation->save();
    }

    if (isset($input['products'])) :
      $conversationItem->products()->sync($input['products']);
    endif;

    if (isset($input['files'])) :
      foreach ($input['files'] as $file) {
        $path = $file['file']->store('public/files');

        Attachment::create([
          'conversation_item_id' => $conversationItem->id,
          'name' => $file['name'],
          'obs' => $file['obs'],
          'path' => $path,
        ]);
      }
    endif;

    if (isset($input['values'])) :
      foreach ($input['values'] as $value) {
        Value::create([
          'conversation_item_id' => $conversationItem->id,
          'obs' => $value['obs'],
          'value_type' => $value['value_type'],
          'value' => $value['value'],
          'additional_value' =>  $value['additional_value'] == 'true' ? true : false,
          'user_id' => auth()->user()->id,
        ]);
      }
    endif;

    if (isset($input['address'])) :
      foreach ($input['address'] as $address) {
        ScheduleAddress::create([
          'conversation_item_id' => $conversationItem->id,
          'address_name' => $address['address_name'],
          'obs' => $address['obs'],
          'address' => $address['address'],
        ]);
      }
    endif;

    $conversationItem->notify(true);

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
  public function show($id)
  {
    $conversationItem = ConversationItem::findOrFail($id);

    return view('conversations.item.show', compact('conversationItem'));
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
    $conversationStatuses = ConversationStatus::pluck("name", "id");
    $detailedContacts = $conversation->customer->detailedContats->pluck("contact", "id");
    $products = Product::pluck("name", "id");
    $organizers = User::where("status", "active")->get()->pluck("full_name", "id");
    $cpeaIds = Conversation::whereNotNull("cpea_id")->pluck("cpea_id", "cpea_id");
    $cnpjs = Cnpj::all()->pluck("display_name", "id");
    $etapas = Etapa::pluck("name", "id");
    $employees = Employee::where("status", "active")->get()->pluck("name", "id");
    $directions = Direction::pluck("name", "id");
    $departments = Department::all()->pluck('name', 'id');
    $conversationItemProduts = $conversationItem->products()->pluck("products.name", "products.id")->toArray();
    $probabilities = ConversationItem::probabilities();

    return view('conversations.item.edit', compact(
      'conversation',
      'conversationStatuses',
      'detailedContacts',
      'products',
      'organizers',
      'cpeaIds',
      'directions',
      'departments',
      'conversationItem',
      'conversationItemProduts',
      'cnpjs',
      'etapas',
      'employees',
      'probabilities'
    ));
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

    $conversationItem->update([
      'conversation_id' => $input['conversation_id'],
      'item_type' => $input['item_type'],
      'interaction_at' => $input['interaction_at'],
      'conversation_status_id' => $input['conversation_status_id'],
      'detailed_contact_id' => $input['detailed_contact_id'],
      'additive' => $input['additive'] == "y" ? true : false,
      'cpea_linked_id' => isset($input['cpea_linked_id']) ? $input['cpea_linked_id'] : null,
      'item_details' => $input['item_details'],
      'schedule_type' => $input['schedule_type'],
      'schedule_name' => $input['schedule_name'],
      'schedule_at' => $input['schedule_at'],
      'schedule_end' => $input['schedule_end'],
      'organizer_id' => $input['organizer_id'],
      'schedule_details' => $input['schedule_details'],
      'direction_id' => $input['direction_id'],
      'employee_id' => isset($input['employee_id']) ? $input['employee_id'] : null,
      'department_id' => isset($input['department_id']) ? $input['department_id'] : null,
      'meeting_form' => $input['meeting_form'],
      'meeting_place' => $input['meeting_place'],
      'user_id' => auth()->user()->id,
      'cnpj_id' => $input['cnpj_id'],
      'etapa_id' => $input['etapa_id'],
      'ppi' => $input['ppi'],
      'state' => $input['state'],
      'city' => $input['city'],
      'probability' => $input['probability'],
    ]);

    if ($input['item_type'] == "Proposta" && !$conversationItem->conversation->cpea_id) {
      $cpeaId = CpeaId::create();
      $conversationItem->conversation->cpea_id = $cpeaId->id;
      $conversationItem->conversation->save();
    }

    if (isset($input['products'])) :
      $conversationItem->products()->sync($input['products']);
    endif;

    if (isset($input['files'])) :
      foreach ($input['files'] as $file) {
        $path = $file['file']->store('public/files');

        Attachment::create([
          'conversation_item_id' => $conversationItem->id,
          'name' => $file['name'],
          'obs' => $file['obs'],
          'path' => $path,
        ]);
      }
    endif;

    if (isset($input['values'])) :
      foreach ($input['values'] as $value) {
        Value::create([
          'conversation_item_id' => $conversationItem->id,
          'obs' => $value['obs'],
          'value_type' => $value['value_type'],
          'value' => $value['value'],
          'additional_value' =>  $value['additional_value'] ? true : false,
          'user_id' => auth()->user()->id,
        ]);
      }
    endif;

    if (isset($input['address'])) :
      foreach ($input['address'] as $address) {
        ScheduleAddress::create([
          'conversation_item_id' => $conversationItem->id,
          'address_name' => $address['address_name'],
          'obs' => $address['obs'],
          'address' => $address['address'],
        ]);
      }
    endif;

    $conversationItem->notify(false);

    $resp = [
      'message' => __('Interação  Atualizada com Sucesso!'),
      'alert-type' => 'success'
    ];

    return redirect()->route('customers.conversations.show', ['conversation' => $input['conversation_id']])->with($resp);
  }

}
