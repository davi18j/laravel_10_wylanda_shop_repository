<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::table('products', function (Blueprint $table){
    $table->text('short_description')->nullable()->after('description');
    $table->text('shipping_returns')->nullable()->after('short_description');
    $table->text('related_products')->nullable()->after('shipping_returns');
    });
    }
    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
    Schema::table('products', function (Blueprint $table){
    $table->dropColumn('short_description')->nullable();
    $table->dropColumn('shipping_returns')->nullable();
    $table->dropColumn('related_products')->nullable();
    });
}
};
