<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discount_coupons', function (Blueprint $table) {

            $table->id();
            // O código do cupom de desconto
            $table->string('code');
            // O nome legível do código do cupom de desconto
            $table->string('name')->nullable();
            // A descrição do cupom. Não é necessário
            $table->text('description')->nullable();
            // O número máximo de usos que este cupom de desconto tem
            $table->integer('max_uses')->nullable();
            // Quantas vezes um usuário pode usar este cupom
            $table->integer('max_uses_user')->nullable();
            // Se o cupom é um desconto percentual ou um preço fixo.
            $table->enum('type', ['percent', 'fixed'])->default('fixed');
            // O valor do desconto com base no tipo
            $table->double('discount_amount', 10, 2);
            // O valor mínimo para aplicar o desconto (opcional)
            $table->double('min_amount', 10, 2)->nullable();
            // O status do cupom (ativo por padrão)
            $table->integer('status')->default(1);
            // Quando o cupom começa a ser válido
            $table->timestamp('starts_at')->nullable();
            // Quando o cupom expira
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
    
                
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
    }
};
