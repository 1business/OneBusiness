<?php

namespace App\Http\Models\Tables\t_master;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequest extends Model
{
    protected $primaryKey = "txn_no";
    protected $connection = "mysql2";
    protected $table = 't_cashr_rqst';
    public $timestamps = false;

    public function user(){
    	return $this->hasOne("App\User", "UserID", "userid");
    }

    public function from_branch2(){
    	return $this->hasOne("App\Branch", "Branch", "from_branch");
    }

    public function to_branch2(){
    	return $this->hasOne("App\Branch", "Branch", "to_branch");
    }
}