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
        Schema::create('affiliate_courtesy_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'affiliate_courtesy_service_customer_foreign')
                    ->references('id')->on('customers');
            $table->unsignedInteger('service_type');
            $table->decimal('max_value', 19, 2)->default(0);
            $table->datetime('valid_until');
            $table->boolean('used')->default(false);
            $table->datetime('used_at')->nullable();
            $table->nullableMorphs('courtesable', 'affiliate_courtesy_services_courtesable_idx');
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
        Schema::dropIfExists('affiliate_courtesy_services');
    }
};
