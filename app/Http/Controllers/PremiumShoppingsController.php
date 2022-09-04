<?php
namespace App\Http\Controllers;

use App\Models\PremiumShopping;
use App\Models\PremiumShoppingImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PremiumShoppingsController extends Controller
{
    public function index(Request $request)
    {
        $query = PremiumShopping::query();
        
        foreach (request()->all() as $field => $value) {
            if (!empty($value) && $value != "") {
                $query->where($field, 'LIKE', "%{$value}%");
            }
        }

        $rows = $query->latest()->paginate();
        return view('premium_shoppings.index', compact('rows'));
    }

    public function show(PremiumShopping $premium_shopping)
    {
        $status_options = PremiumShopping::$status_options;

        $premium_shopping->load(['package_item', 'premium_service', 'user', 'user.userable']);
        return view('premium_shoppings.show', compact('premium_shopping', 'status_options'));
    }

    public function update(Request $request, PremiumShopping $premium_shopping)
    {
        DB::beginTransaction();
        try {
            $fields = $request->all();

            // Upload de arquivos cadastrados pelo admin
            if ($request->has('files') && !empty($request->file('files'))) {
                foreach ($request->file('files') as $file) {
                    PremiumShoppingImage::upload($premium_shopping, $file);
                }
                $fields['status'] = 3;
            }
            $premium_shopping->update($fields);

            DB::commit();
            flash()->success('Compra de serviço premium atualizada com sucesso!');
            return redirect()->to(route('premium_shoppings.index'));
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('erro ao atualizar a compra de serviço premium', [
                $e->getMessage(),
                $e->getLine(),
            ]);
            flash()->error('Houve um erro ao atualizar a compra do serviço premium: '. $e->getMessage());
            return redirect()->back()->withInput($request->all());
        }
    }
}