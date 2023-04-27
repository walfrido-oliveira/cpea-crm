<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateEmail;
use App\Http\Requests\TemplateEmailRequest;

class TemplateEmailController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = TemplateEmail::paginate(10);
        return view('config.emails.templates.index', compact('templates'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $template = TemplateEmail::findOrFail($id);
        $notification = $template->notification;
        if(class_exists($notification))
        {
            $notification = $notification::create();
            $content = ($notification)->toMail(auth()->user());
            return view('config.emails.templates.show', compact('content'));
        }
        else
        {
            return abort(404, "Não encontrado");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = TemplateEmail::findOrFail($id);
        $tags = explode(",", $template->tags);
        return view('config.emails.templates.edit', compact('template', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TemplateEmailRequest $request, $id)
    {
        $template = TemplateEmail::findOrFail($id);
        $input = $request->all();

        $template->update([
            'subject' => $input['subject'],
            'description' => $input['description'],
            'value' => $input['value'],
        ]);

        return redirect()->route('config.emails.templates.edit', ['template' => $id])->with(defaultSaveMessagemNotification());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
