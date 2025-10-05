<?php
    
namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index()
    {
        return Client::orderBy('id', 'desc')->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required','string','max:120'],
            'apellido'    => ['required','string','max:120'],
            'email'   => ['required','email','max:150','unique:clients,email'],
            'phone'   => ['nullable','string','max:30'],
            'address' => ['nullable','string','max:200'],
        ]);

        $client = Client::create($data);
        return response()->json($client, Response::HTTP_CREATED); 
    }

    public function show(Client $client)
    {
        return $client;
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'    => ['sometimes','required','string','max:120'],
            'apellido'    => ['sometimes','required','string','max:120'],
            'email'   => ['sometimes','required','email','max:150', Rule::unique('clients','email')->ignore($client->id)],
            'phone'   => ['nullable','string','max:30'],
            'address' => ['nullable','string','max:200'],
        ]);

        $client->update($data);
        return response()->json($client, Response::HTTP_OK);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT); 
    }
}
