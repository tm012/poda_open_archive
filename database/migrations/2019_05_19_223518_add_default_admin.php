<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;


class AddDefaultAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $sell_save = New User;
        $sell_save ->name = "Admin";
        $sell_save ->email = "tmamun@mtu.edu";
        $sell_save ->password = bcrypt("tauseef");
        $sell_save ->user_approval_status = "1";
        $sell_save ->admin_status = "1";

        
        $sell_save -> save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

        User::where('email',  "tmamun@mtu.edu")->delete();
    }
}
