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
        // Add the generic_field1 field to the database
        if (!Schema::hasColumn('businesses', 'generic_field1')) {
            Schema::table('businesses', function (Blueprint $table) {
                $table->string('generic_field1')->nullable(); // Add a nullable string column
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn('generic_field1'); // Remove the column in the down method
        });
    }
};
