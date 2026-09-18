<?php

use App\Support\StaffPermissions;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->after('price_label');
        });

        $defaults = [
            'Diagnostics & Repairs' => 185,
            'EV & Hybrid Specialists' => 220,
            'Pre-Purchase Inspections' => 249,
            'Engine diagnostics' => 149,
            'Mechanical repairs' => 189,
            'Brake & suspension' => 169,
            'Cooling systems' => 159,
            'Electrical faults' => 149,
            'Battery health checks' => 89,
        ];

        foreach ($defaults as $title => $price) {
            DB::table('services')->where('title', $title)->update([
                'price' => $price,
                'price_label' => '$'.number_format($price, 2),
            ]);
        }

        Schema::create('workshop_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('invoice_number')->nullable()->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_year')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('draft');
            $table->decimal('gst_rate', 5, 2)->default(15);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('gst_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamp('invoiced_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('workshop_job_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('workshop_jobs')->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('title');
            $table->decimal('quantity', 8, 2)->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('line_total', 10, 2)->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        if (Schema::hasColumn('users', 'permissions')) {
            $users = DB::table('users')->where('role', 'staff')->get();
            foreach ($users as $user) {
                $permissions = $user->permissions ? json_decode($user->permissions, true) : StaffPermissions::defaults();
                if (! is_array($permissions)) {
                    $permissions = StaffPermissions::defaults();
                }
                if (! in_array('staff.jobs', $permissions, true)) {
                    $permissions[] = 'staff.jobs';
                    DB::table('users')->where('id', $user->id)->update([
                        'permissions' => json_encode(array_values($permissions)),
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('workshop_job_items');
        Schema::dropIfExists('workshop_jobs');

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
