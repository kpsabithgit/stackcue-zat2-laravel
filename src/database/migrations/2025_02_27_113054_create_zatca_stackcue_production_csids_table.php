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
        Schema::create('zatca_stackcue_production_csids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compliance_id')->nullable(); // Define the column first
            $table->datetime('cer_issue_date')->nullable(); // Certificate issue date
            $table->datetime('cer_exp_date')->nullable(); // Certificate expiration date
            $table->uuid('stackcue_production_identifier')->nullable(); // UUID for production identifier
            $table->integer('icv')->nullable()->default(0);
            $table->string('PIHvalue')->default('NWZlY2ViNjZmZmM4NmYzOGQ5NTI3ODZjNmQ2OTZjNzljMmRiYzIzOWRkNGU5MWI0NjcyOWQ3M2EyN2ZiNTdlOQ==');
            $table->integer('overall_status')->nullable(); // Overall status
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('compliance_id')
                  ->references('id')
                  ->on('zatca_stackcue_compliance_csids')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zatca_stackcue_production_csids');
    }
};