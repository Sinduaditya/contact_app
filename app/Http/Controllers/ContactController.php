<?php

namespace App\Http\Controllers;

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
        $query = Contact::query();
        if(request()->query('trash')){
            $query->onlyTrashed();
        }
        // local scope
        $contacts = $query->sortByNameAlpha()->filterByCompany()->where( function ($query){
            if($search = request()->query('search')) {
                $query->where("first_name", "LIKE", "%{$search}%");
                $query->orWhere("last_name", "LIKE", "%{$search}%");
                $query->orWhere("email", "LIKE", "%{$search}%");
            }
        })->paginate(10);
        // dump(DB::getQueryLog());
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        $companies = $this->company->pluck();
        $contact = new Contact();
        return view('contacts.create', compact('companies','contact'));
    }

    public function store(Request $request){
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'company_id' => 'required|exists:companies,id'
        ]);

        Contact::create($request->all());
        return redirect()->route('contacts.index')->with('message','Contact has been added successfully');
    }

    public function show($id)
    {

        $contact = Contact::findOrFail($id);
        return view('contacts.show')->with('contact', $contact);
    }

    public function edit($id)
    {
        $companies = $this->company->pluck();

        $contact = Contact::findOrFail($id);
        // return view('contacts.edit')->with('contact', $contact)->with('companies', $companies);
        return view('contacts.edit', compact('companies','contact'));

    }

    public function update(Request $request, $id){
        $contact = Contact::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'company_id' => 'required|exists:companies,id'
        ]);

        $contact->update($request->all());
        return redirect()->route('contacts.index')->with('message','Contact has been update successfully');
    }

    public function destroy($id)
    {

        $contact = Contact::findOrFail($id);
        $contact->delete();
        $redirect = request()->query('redirect');
        return ($redirect ? redirect()->route($redirect) : back())
        ->with('message','Contact has been moved to trash')
        ->with('undoRoute', $this->getUndoRoute('contacts.restore', $contact));
    }

    //soft delete
    public function restore($id)
    {

        $contact = Contact::onlyTrashed()->findOrFail($id);
        $contact->restore();
        return back()
        ->with('message','Contact has been restored from trash.')
        ->with('undoRoute', $this->getUndoRoute('contacts.destroy', $contact));
    }

    //agar setelah undo tidak keluar tulisan undo lagi
    protected function getUndoRoute($name,$resource){
        return request()->missing('undo') ? route($name, [$resource->id,'undo' => true]) : null;
    }

    public function forceDelete($id)
    {

        $contact = Contact::onlyTrashed()->findOrFail($id);
        $contact->forceDelete();
        return back()
        ->with('message','Contact has been removed permanently.');
    }

}
