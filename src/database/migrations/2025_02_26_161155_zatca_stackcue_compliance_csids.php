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
        Schema::create('zatca_stackcue_compliance_csids', function (Blueprint $table) {
            $table->id();
            $table->string('company_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('cert_name')->nullable();
            $table->string('common_name')->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->string('company_name')->nullable();
            $table->string('vat_number')->nullable();
            $table->boolean('is_required_simplified_doc')->default(false);
            $table->boolean('is_required_standard_doc')->default(false);
            $table->string('device_serial_number1')->nullable();
            $table->string('device_serial_number2')->nullable();
            $table->string('device_serial_number3')->nullable();
            $table->text('reg_address')->nullable();
            $table->string('business_category')->nullable();
            $table->string('otp')->nullable();
            $table->string('stackcue_compliance_identifier')->nullable();
            $table->date('certificate_issue_date')->nullable();
            $table->date('certificate_expiry_date')->nullable();
            $table->string('overall_status')->nullable(); // You can adjust the default value as needed
            $table->timestamps(); // Adds `created_at` and `updated_at` columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zatca_stackcue_compliance_csids');
    }
};
