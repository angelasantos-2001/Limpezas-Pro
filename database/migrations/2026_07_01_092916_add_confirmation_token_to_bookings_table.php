<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->string('confirmation_token')->nullable()->after('address');
        $table->string('status')->default('pendente')->after('confirmation_token');
    });
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn('confirmation_token');
        $table->dropColumn('status');
    });
}
};
