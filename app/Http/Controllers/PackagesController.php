<?php

namespace App\Http\Controllers;

use App\Events\PackageReceivedEvent;
use App\Models\Package;
use App\Http\Requests\PackageRequest as Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PackagesController extends Controller
{
    public function index()
    {
        $query = Package::query();

        $rows = $query->latest()->paginate();
        return view('packages.index', compact('rows'));
    }

    public function create()
    {
        return view('packages.create');
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
        $filename = Str::random(15) .'.jpg';

        // $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->input('photo')));
        // if (!Storage::put('packages/'. $filename, $file)) {
        //     flash()->error('Houve um erro ao fazer upload da imagem');
        //     return redirect()->back()->withInput($request->all());
        // }
        // $requestData['photo'] = $filename;

        //dd($request->all());

        $ext = $request->file('photo')->getClientOriginalExtension();
        $filename = date('YmdHis') .'-'. Str::random(10) .'.'. $ext;

        $disk = '';

        if ($request->file('photo')->storeAs('packages', $filename)) {
            $requestData['photo'] = $filename;
        } else {
            flash()->error('Houve um erro ao subir a imgem');
            return redirect()->back();
        }

        // Find customer by suite
        // $customer = Customer::whereSuite($request->get('suite'))->first();
        // if (!$customer) {
        //     flash()->error('Não foi encontrada a suite: '. $request->get('suite'));
        //     return redirect()->back();
        // }
        // $requestData['customer_id'] = $customer->id;

        if ($package = Package::create($requestData)) {
            event(new PackageReceivedEvent($package->user, $package));
            flash()->success('Pacote cadastrado com sucesso!');
        } else {
            flash()->error('Houve um erro ao cadastrar o pacote');
        }

        if ($requestData['next'] == 'add_items') {
            return redirect(route('package-items.create', ['package_id' => $package->id]));
        } else if ($requestData['next'] == 'mais_um') {
            return redirect(route('packages.create'));
        } else {
            return redirect(route('packages.index'));
        }
    }

    public function edit($id)
    {
        $row = Package::find($id);
        $customer = User::with('userable')->where('id', $row->customer_id)->first();
        return view('packages.edit', compact('row', 'customer'));
    }

    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        if ($request->file('photo') && $filename = $this->uploadFile($request->file('photo'))) {
            $requestData['photo'] = $filename;
        } else unset($requestData['photo']);

        $package = Package::findOrFail($id);

        if ($package->update($requestData)) {
            flash()->success('Pacote editado com sucesso!');
        } else {
            flash()->error('Houve um erro ao editar o pacote');
        }
        return redirect(url('packages'));
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        if ($package->delete()) {
            flash()->success('Pacote removido com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover o pacote');
        }
        return redirect(url('packages'));
    }

    private function uploadFile(UploadedFile $file): ?string
    {
        if ($file->isValid()) {
            $name = md5(date('YmdHis'));
            $extension = $file->getClientOriginalExtension();

            $filename = $name .'.'. $extension;

            if ($file->storeAs('packages', $filename)) return $filename;
        }
        return null;
    }
}
