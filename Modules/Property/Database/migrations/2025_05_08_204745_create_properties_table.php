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
            $table->text('description')->nullable();
            $table->foreignIdFor(Client::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SubCategory::class)->nullable()->index()->constrained()->nullOnDelete();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('long', 10, 8)->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->string('type')->nullable()->comment('نوع');
            $table->decimal('area', 10, 2)->nullable()->comment('المساحة');
            $table->unsignedTinyInteger('floor')->nullable()->comment('الطابق');
            $table->string('directions')->nullable()->comment('الاتجاهات');
            $table->unsignedTinyInteger('age')->nullable()->comment('عمر العقار');
            $table->enum('ownership_type', ['طابو اخضر', 'حكم محكمة', 'غير ذلك'])->nullable()->comment('نوع الملكية');
            $table->unsignedTinyInteger('bedrooms')->nullable()->comment('عدد غرف النوم');
            $table->unsignedTinyInteger('living_rooms')->nullable()->comment('عدد الصالات');
            $table->unsignedTinyInteger('bathrooms')->nullable()->comment('عدد الحمامات');
            $table->unsignedTinyInteger('facades')->nullable()->comment('عدد الواجهات');
            $table->decimal('scale', 10, 2)->nullable()->comment('الميزان');
            $table->unsignedTinyInteger('pools')->nullable()->comment('عدد المسبح');
            $table->unsignedTinyInteger('salons')->nullable()->comment('صالون');
            $table->decimal('total_area', 10, 2)->nullable()->comment('مساحة الاجماليه');
            $table->unsignedTinyInteger('fruit_trees')->nullable()->comment('أشجار مثمرة');
            $table->unsignedTinyInteger('water_wells')->nullable()->comment('بير مياه');
            $table->string('video')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_sold')->default(0);
            $table->string('unavailable_comment')->nullable();
            $table->enum('finishing_status', ['جاهز للسكن', 'بحاجة إلى اكساء'])->nullable()->comment('الاكساء');
            $table->enum('rental_period', ['شهري', 'يومي', 'سنوي', 'الكل'])->nullable()->comment('نوع الايجار');
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
