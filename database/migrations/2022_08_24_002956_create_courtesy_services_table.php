<?php

use App\Models\AffiliateGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courtesy_services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AffiliateGroup::class)->constrained();
            $table->morphs('courtesable');
            $table->decimal('max_value', 19, 2)->default(0);
            $table->unsignedInteger('valid_days')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courtesy_services');
    }
};
