<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class PremiumShoppingImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['premium_shopping_id', 'file'];

    public function premium_shopping()
    {
        return $this->belongsTo(PremiumShopping::class);
    }

    public static function upload(PremiumShopping $premium_shopping, UploadedFile $file): bool
    {
        $filename = 'file_'. date('dmYHis') .'.'. $file->getClientOriginalExtension();
        if ($file->storeAs('premium_shopping_files', $filename)) {
            $premium_shopping->files()->create(['file' => $filename]);
            return true;
        }
        throw new UploadException('Erro ao fazer upload do arquivo');
    }
}
