<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Carbon\Carbon;

class PackagesController extends Controller
{
    public function index()
    {
        $query = Package::query();

        if (request()->has('keyword') && !empty(request()->get('keyword'))) {
            $keyword = request()->get('keyword');

            $query->where(function($q) use($keyword) {
                foreach (Package::fields() as $field) {
                    $q->orWhere($field, 'LIKE', "%{$keyword}%");
                }
            });
        }

        $rows = $query->paginate();
        return view('customer.packages.index', compact('rows'));
    }

    public function show($id)
    {
        $package = Package::with('items', 'user')->findOrFail($id);
        return view('customer.packages.show', compact('package'));
    }

    public function destroy(Package $package)
    {
        if ($package->delete()) {
            flash()->success('Pacote removido com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover o pacote.');
        }
        return redirect()->route('packages.index');
    }
}
