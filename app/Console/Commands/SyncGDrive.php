<?php

namespace App\Console\Commands;

use App\Models\FileStorage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SyncGDrive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sync-gdrive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'upload file to google drive';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo "Sync google drive start ..";
        echo "\n";

        // get all file for sync
        $files = FileStorage::where('url_gdrive', '!=', 1)->limit(50)->get();
        foreach($files as $file){
            $folder = folderGDrive($file->data_type);
            if($folder == ""){
                echo "Folder Not Found";
                echo "\n";
                return false;
            }

            $path = 'public/berkas/' . $file->file_path;
            if (!Storage::exists($path)) {
                echo "File Not Found";
                echo "\n";
                return false;
            }

            $fileContents = Storage::get($path);
            $upload = Storage::disk($folder)->put($file->file_name, $fileContents);
            if($upload == true){
                echo "Success upload";
                echo "\n";
                $file->url_gdrive = true;
                $file->save();
            }else{
                echo "Failed upload";
                echo "\n";
            }
        }

        echo "Sync google drive end";
        echo "\n";
        return Command::SUCCESS;
    }
}
