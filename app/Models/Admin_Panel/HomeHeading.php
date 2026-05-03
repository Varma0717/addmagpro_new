<?php

namespace App\Models\Admin_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeHeading extends Model
{
    use HasFactory;
    public $table="home_page_headings";
    public $timestamps=false;
    public $primaryKey="id";
}
