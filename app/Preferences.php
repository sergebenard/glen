<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preferences extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'email',
        'address',
        'phone',
        'markup',
    ];

    public function setPhoneAttribute( $value )
    {
    	$phone = preg_replace("/[^0-9]/","", $value);
    	$this->attributes['phone'] = ( empty( $phone ) ? null : $phone );
    }

    public function formatPhoneNumber( $value = null )
    {
    	$value = ( is_null( $value ) ) ? $value = $this->attributes['phone'] : $value;

    	$length = strlen($value);
    	switch($length)
    	{
    		case 7:
    			return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $value);
    			break;
    		case 10:
    			return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $value);
    		break;
    		case 11:
    			return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3-$4", $value);
    		break;
    		default:
    			return $value;
    		break;
    	}
    }
}
