<?php

use App\Http\Controllers\Api\StorageController;
use App\Models\StorageFile;
use App\Traits\Media;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateToWebpDb extends Migration
{
    use Media;

    /**
     * Run the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function up()
    {
        $files = StorageFile::withTrashed()->get();
        foreach ($files as $file) {
            $domain = $file->user->domain;
            $url = $file->url;

            $parsedUrl = parse_url($url);
            $parsedUrl = $parsedUrl['path'] ?? null;
            if ($parsedUrl) {
                $fileInfo = pathinfo($file->filename);
                $extension = $fileInfo['extension'] ?? null;

                if (in_array($extension, ['jpg', 'jpeg', 'bmp', 'gif', 'png'])) {

                    $request = self::setMigrationRequest($domain, $url, $file);

                    Auth::login($file->user, true);

                    app(StorageController::class)->addBase64Files($request);

                    self::deleteFile($file);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webp_db', function (Blueprint $table) {
            //
        });
    }
}
