<?php

use Modules\Client\App\Models\Client;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\Category\App\Models\SubCategory;
use Illuminate\Database\Migrations\Migration;
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
            $table->foreignIdFor(SubCategory::class)->nullable()->index()->constrained()->nullOnDelete();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('long', 10, 8)->nullable();
            $table->string('city');
            $table->string('address')->nullable();
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
            $table->string('video')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_furnished')->default(0)->comment('بعفش او بدون عفش');
            $table->boolean('is_installment')->default(0)->comment('بالتقسيط');
            $table->boolean('is_active')->default(0);
            $table->boolean('is_available')->default(1);
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
