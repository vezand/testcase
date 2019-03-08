<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //Table name

	protected $table = 'documents';
	protected $primaryKey = 'id';
}
