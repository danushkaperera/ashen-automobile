<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('admin')->after('is_admin');
            $table->boolean('is_active')->default(true)->after('role');
        });

        DB::table('users')->where('is_admin', true)->update(['role' => 'admin', 'is_active' => true]);
        DB::table('users')->where('is_admin', false)->update(['role' => 'staff']);

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_year')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedInteger('visit_count')->default(0);
            $table->timestamp('first_visited_at')->nullable();
            $table->timestamp('last_visited_at')->nullable();
            $table->timestamps();

            $table->unique('phone');
            $table->index('email');
            $table->index('visit_count');
        });

        Schema::create('customer_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('registered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('category');
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('job_title')->nullable();
            $table->text('notes')->nullable();
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_year')->nullable();
            $table->timestamp('visited_at')->nullable();
            $table->timestamps();

            $table->index(['category', 'visited_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_visits');
        Schema::dropIfExists('customers');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_active']);
        });
    }
};
