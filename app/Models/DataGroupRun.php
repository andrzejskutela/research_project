<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use chillerlan\QRCode\{QRCode, QROptions, Output\QROutputInterface};

class DataGroupRun extends Model
{
    protected $table = 'data_group_runs';

    protected $guarded = [];

    public function participants() : HasMany {
        return $this->hasMany(DataLead::class, 'data_group_run_id', 'id');
    }

    public function generateQRImage(string $path) {
        $options = new QROptions;
        $options->outputType = QROutputInterface::GDIMAGE_PNG;
        $options->scale = 20;
        $options->imageTransparent = true;
        $options->returnResource = true;
        $gdImage = (new QRCode($options))->render($path);
        imagepng($gdImage, public_path('qr/' . $this->id . '.png'));
    }

    public static function generateRandomGroupCode() {
        $chars = str_split('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ+_', length: 1);
        $charsLength = count($chars);
        do {
            $hash = sha1(Str::uuid());
            $code = '';
            for ($i = 0; $i < strlen($hash); $i += 4) {
                $hex = substr($hash, $i, 4);
                $dec = hexdec($hex);
                $code .= $chars[ $dec % $charsLength ];
            }

            $groupsCount = self::where('code', $code)->count();
        } while( $groupsCount > 0 );

        return $code;
    }
}
