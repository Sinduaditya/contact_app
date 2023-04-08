<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function __construct(protected CompanyRepository $company)
    {
    }

    public function index(CompanyRepository $company, Request $request)
    {
        $companies = $this->company->pluck();
        // DB::enableQueryLog();
        // local scope rausable
        $contacts = Contact::allowedTrash()
        ->allowedSorts(['first_name','last_name','email'], "first_name")
        ->allowedFilters('company_id')
        ->allowedSearch('first_name','last_name','email')
        ->paginate(10);
        // dump(DB::getQueryLog());
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        $companies = $this->company->pluck();
        $contact = new Contact();
        return view('contacts.create', compact('companies','contact'));
    }

    public function store(ContactRequest $request){
        Contact::create($request->all());
        return redirect()->route('contacts.index')->with('message','Contact has been added successfully');
    }


    public function show(Contact $contact)
    {
        return view('contacts.show')->with('contact', $contact);
    }

    public function edit(Contact $contact)
    {
        $companies = $this->company->pluck();
        return view('contacts.edit', compact('companies','contact'));

    }

    public function update(ContactRequest $request, Contact $contact){
        $contact->update($request->all());
        return redirect()->route('contacts.index')->with('message','Contact has been update successfully');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        $redirect = request()->query('redirect');
        return ($redirect ? redirect()->route($redirect) : back())
        ->with('message','Contact has been moved to trash')
        ->with('undoRoute', $this->getUndoRoute('contacts.restore', $contact));
    }

    //soft delete
    public function restore(Contact $contact)
    {
        $contact->restore();
        return back()
        ->with('message','Contact has been restored from trash.')
        ->with('undoRoute', $this->getUndoRoute('contacts.destroy', $contact));
    }

    //agar setelah undo tidak keluar tulisan undo lagi
    protected function getUndoRoute($name,$resource){
        return request()->missing('undo') ? route($name, [$resource->id,'undo' => true]) : null;
    }

    public function forceDelete(Contact $contact)
    {
        $contact->forceDelete();
        return back()
        ->with('message','Contact has been removed permanently.');
    }

}
