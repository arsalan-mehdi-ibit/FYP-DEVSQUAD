<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubmittedAtAndRejectionReasonToTimesheetsTable extends Migration
{
    public function up()
    {
        Schema::table('timesheets', function (Blueprint $table) {
            $table->timestamp('submitted_at')->nullable()->after('status');
            $table->text('rejection_reason')->nullable()->after('submitted_at');
        });
    }

    public function down()
    {
        Schema::table('timesheets', function (Blueprint $table) {
            $table->dropColumn('submitted_at');
            $table->dropColumn('rejection_reason');
        });
    }
}
