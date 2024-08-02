<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestMinioUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-minio-url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test minio url';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $disk = Storage::disk('s3');

        // Upload a file
        $disk->put('test.txt', 'Hello MinIO!!');

        // Get the URL of a file
        $url = $disk->url('test.txt');
        print "Normal URL: " . $url . PHP_EOL;

        // Generate a temporary URL
        $tempUrl = $disk->temporaryUrl('test.txt', now()->addMinutes(5));
        print "Temporary URL: " . $tempUrl . PHP_EOL;
    }
}
