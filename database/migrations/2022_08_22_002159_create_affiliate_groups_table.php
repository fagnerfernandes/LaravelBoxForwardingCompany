<?php

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
        Schema::create('affiliate_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_default')->default(false);
            $table->decimal('company_fee_percent', 19, 2)->default(0);
            $table->decimal('premium_services_percent', 19, 2)->default(0);
            $table->decimal('extra_services_percent', 19, 2)->default(0);
            $table->unsignedInteger('number_free_shippings')->default(0);
            $table->decimal('free_shipping_max_value')->default(0);
            $table->unsignedInteger('free_shipping_valid_days')->default(0);
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
        Schema::dropIfExists('affiliate_groups');
    }
};
