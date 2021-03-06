<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOldOtDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('old_ot_data', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('ic_no');
            $table->string('staffname');
            $table->string('company');
            $table->string('cost_ctr');
            $table->string('cost_desc');
            $table->string('exist');
            $table->string('off_local');
            $table->string('state_code');
            $table->string('cust_seg');
            $table->string('ot_gs_bypass');
            $table->string('appl_date');
            $table->string('ot_date');
            $table->string('ot_start1');
            $table->string('ot_end1');
            $table->string('ot_start2');
            $table->string('ot_end2');
            $table->string('ot_start3');
            $table->string('ot_end3');
            $table->string('ot_hours');
            $table->string('trans_cd');
            $table->decimal('amount',10,3);
            $table->string('status');
            $table->string('jenisot');
            $table->string('project_type');
            $table->string('resp_cc');
            $table->string('proj_no');
            $table->string('nethdr');
            $table->string('netact');
            $table->decimal('gaji','10','3');
            $table->string('otexpl');
            $table->string('staff_no');
            $table->decimal('ot_hours_decimal',10,3);
            $table->string('sup_date');
            $table->string('mgr_date');
            $table->string('sent_date');
            $table->string('sup_icno');
            $table->string('sup_name');
            $table->string('mgr_icno');
            $table->string('mgr_name');
            $table->string('sup_date_dt')->nullable();
            $table->string('mgr_date_dt')->nullable();
            $table->string('sent_date_dt')->nullable();
            $table->integer('appl_persno')->nullable();
            $table->integer('sup_persno')->nullable();
            $table->integer('mgr_persno')->nullable();
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_ot_data');
    }
}
