<?php
namespace App\Models;

use CodeIgniter\Model;

class LanguageModel extends Model
{
    protected $table      = 'db_languages';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];
}
