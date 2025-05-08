<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\Category\App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Modules\Client\App\Models\Client;
use Modules\Property\App\Models\TransactionType;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignIdFor(Client::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Category::class)->nullable()->index()->constrained()->nullOnDelete();
            $table->foreignIdFor(TransactionType::class)->nullable()->index()->constrained()->nullOnDelete();
            $table->decimal('price', 12, 2);
            $table->decimal('area', 10, 2)->comment('المساحة');
            $table->unsignedTinyInteger('floor')->nullable()->comment('الطابق');
            $table->string('directions')->nullable()->comment('الاتجاهات');
            $table->unsignedTinyInteger('age')->nullable()->comment('عمر العقار');
            $table->string('ownership_type')->nullable()->comment('نوع الملكية');
            $table->unsignedTinyInteger('bedrooms')->nullable()->comment('عدد غرف النوم');
            $table->unsignedTinyInteger('living_rooms')->nullable()->comment('عدد الصالات');
            $table->unsignedTinyInteger('bathrooms')->nullable()->comment('عدد الحمامات');
            $table->decimal('width_ratio', 5, 2)->nullable()->comment('نسبة الاتساع');
            $table->text('notes')->nullable()->comment('ملاحظات اخري');
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
